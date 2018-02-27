<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 26-02-2018
 * Time: 21:19
 */

namespace Paypal;

class Paypal
{
    private $data;
    private $queryString = '';
    private $token;
    private $response;
    private $verificationQuery = 'cmd=_notify-validate';

    /**
     * Paypal constructor.
     * @param array $data
     */
    function __construct(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * Build URL query parameters.
     */
    public function buildQuery()
    {
        // TODO: Catch exception if all the parameter are not passed in the constructor.

        $this->token = $this->generateTrackingCode();
        $_SESSION['paypal']['data'] = $this->data;

        $this->queryString .= '?business=' . urlencode(MERCHANT_EMAIL) . '&';

        foreach ($this->data as $key => $value) {
            $value = urlencode(stripslashes($value));
            $this->queryString .= "$key=$value&";
        }

        $this->queryString .= 'return=' . urlencode(PAYMENT_SUCCESS_URL . "?token=" . $this->token) . '&';
        $this->queryString .= 'cancel_return=' . urlencode(PAYMENT_FAILURE_URL . "?token=" . $this->token) . '&';
        $this->queryString .= 'notify_url=' . urlencode(PAYMENT_NOTIFY_URL) . '&';

        $this->queryString .= 'custom=' . urlencode($this->token);
    }

    /**
     * Redirect to the Paypal server for payment.
     */
    public function redirect() {
        $url = ENV === 'development' ? SANDBOX_ENDPOINT : LIVE_ENDPOINT;
        header("Location: {$url}/cgi-bin/webscr" . $this->queryString);
    }

    /**
     * Logs unique transaction identifier in the database.
     *
     * @throws \Exception
     */
    public function initTransaction() {
        $driver = new \mysqli_driver();
        $default_driver = $driver->report_mode; // Get the default error reporting mode.
        $driver->report_mode = MYSQLI_REPORT_STRICT; // Throw exception instead of returning warning.

        $db = \Database::connect();
        $query = "INSERT INTO payments (cust_fname, cust_lname, cust_email, cust_mobile, tracking_id) VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $db->prepare($query);
            $stmt->bind_param('sssss', $this->data['first_name'], $this->data['last_name'], $this->data['email'], $this->data['mobile'], $this->token);
            $stmt->execute();
        } catch (\mysqli_sql_exception $e) {
            throw new \Exception('Failed to instantiate transaction!');
        }

        $driver->report_mode = $default_driver; // Restore the default error reporting mode.
        \Database::disconnect();
    }

    /**
     * Read the response received from the Paypal IPN.
     */
    public function readIPNResponse() {
        foreach($_POST as $key => $val) {
            $this->response[$key] = $val;
        }
    }

    /**
     * Build payment verification query.
     */
    public function buildVerificationQuery() {
        foreach($_POST as $key => $val) {
            $val = urlencode(stripslashes($val));
            $val = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}', $val);
            $this->verificationQuery .= "&{$key}={$val}";
        }
    }

    /**
     * Validate if payment was successful or not.
     *
     * @return bool
     * @throws \Exception
     */
    public function validatePayment() {
        $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Content-Length: " . strlen($this->verificationQuery) . "\r\n\r\n";

        $url = ENV === 'development' ? SANDBOX_VERIFIER : LIVE_VERIFIER;
        $fp = fsockopen ("{$url}", 443, $errno, $errstr, 30);

        if (! $fp) {
            throw new \Exception('Failed to open connection!');
        } else {
            fputs($fp, $header . $this->verificationQuery);

            while (! feof($fp)) {
                $response = fgets($fp, 1024);

                if (strcmp($response, "VERIFIED") == 0) {
                    // Return TRUE if payment was successful.
                    return TRUE;
                }
            }
        }
        // Return FALSE in all other cases.
        return FALSE;
    }

    /**
     * Update payment status in database on successful payment.
     *
     * @throws \Exception
     */
    public function updatePaymentStatus() {
        $driver = new \mysqli_driver();
        $default_driver = $driver->report_mode; // Get the default error reporting mode.
        $driver->report_mode = MYSQLI_REPORT_STRICT; // Throw exception instead of returning warning.

        $db = \Database::connect();
        $query = "UPDATE payments SET paypal_txn_id = ?,
                  payment_amount = ?, 
                  payment_currency = ?, 
                  payment_status = ?, 
                  payer_email = ?, 
                  item_name = ?, 
                  item_number = ?
                  WHERE tracking_id = ?";

        try {
            $stmt = $db->prepare($query);
            $stmt->bind_param("ssssssss",
                $this->response['txn_id'],
                $this->response['mc_gross'],
                $this->response['mc_currency'],
                $this->response['payment_status'],
                $this->response['payer_email'],
                $this->response['item_name'],
                $this->response['item_number'],
                $this->response['custom']
            );
            $stmt->execute();
        } catch (\mysqli_sql_exception $e) {
            throw new \Exception($e->getMessage());
        }
        $driver->report_mode = $default_driver; // Restore the default error reporting mode.
        \Database::disconnect();
    }

    /**
     * Generates unique tracking code.
     *
     * @return string
     */
    private function generateTrackingCode() {
        $token = \Security\Security::uniqueToken();
        $_SESSION['paypal']['token'] = $token;

        return $token;
    }

    /**
     * Unset all paypal session data.
     */
    public function unsetSessionVars() {
        unset($_SESSION['paypal']);
    }
}