<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 27-02-2018
 * Time: 02:37
 */

// TODO: Design the page to look good.

if (isset($_SESSION['paypal']['token'])) {
    $paypalClient = new \Paypal\Paypal();

    $token = $_SESSION['paypal']['token'];
    $details = fetchTransactionDetail($token);

    print_r($details);

    $paypalClient->unsetSessionVars();
} else {
    // Invalid request. Redirect the user to the homepage (or anywhere you'd like to).
}