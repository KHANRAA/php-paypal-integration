<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 27-02-2018
 * Time: 02:36
 */

$paypalClient = new \Paypal\Paypal();
$paypalClient->readIPNResponse();

try {
    $status = $paypalClient->validatePayment();
} catch(Exception $e) {
    // TODO: Handle failure.
}

if ($status === TRUE) {
    try {
        $paypalClient->updatePaymentStatus();
    } catch (Exception $e) {
        // Read tracking ID from $_POST['custom'] and log a request against this ID to notify the admin.
    }
} else {
    // When an invalid response is received.
    header('Location: .');
}