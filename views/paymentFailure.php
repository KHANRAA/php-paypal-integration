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
    $paypalClient->unsetSessionVars();

    echo "Payment was failed!";
} else {
    // Invalid request. Redirect the user to the homepage (or anywhere you'd like to).
    header('Location: .');
}