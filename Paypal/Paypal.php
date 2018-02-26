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

    function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     *
     */
    public function buildQuery()
    {
        $this->queryString .= '?business=' . urlencode(MERCHANT_EMAIL) . '&';

        foreach ($this->data as $key => $value) {
            $value = urlencode(stripslashes($value));
            $this->queryString .= "$key=$value&";
        }

        $this->queryString .= 'return=' . urlencode(PAYMENT_SUCCESS_URL) . '&';
        $this->queryString .= 'cancel_return=' . urlencode(PAYMENT_FAILURE_URL) . '&';
        $this->queryString .= 'notify_url=' . urlencode(PAYMENT_NOTIFY_URL) . '&';

        $this->queryString .= 'custom=' . urlencode($this->generateTrackingCode());
    }

    public function redirect() {
        $url = ENV === 'development' ? SANDBOX_ENDPOINT : LIVE_ENDPOINT;
        header("Location: {$url}/cgi-bin/webscr" . $this->queryString);
    }

    private function generateTrackingCode() {
        $token = \Security\Security::CSRFtoken();
        $_SESSION['PAYPAL_TOKEN'] = $token;

        return $token;
    }
}