<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 26-02-2018
 * Time: 23:09
 */

$error = FALSE;

if (empty($_POST['first_name']) or
    empty($_POST['last_name']) or empty($_POST['email']) or empty($_POST['mobile']) or
    empty($_POST['amount']) or empty($_POST['item_name']) or empty($_POST['item_number']))
{
    $session->set_flashdata('error', 'Please fill all the required fields!');
    $error = TRUE;
} else {
    $fname = preg_replace('/\s+/', '', sanitize($_POST['first_name']));
    $lname = preg_replace('/\s+/', '', sanitize($_POST['last_name']));
    $email = sanitize($_POST['email']);
    $mobile = sanitize($_POST['mobile']);
    $amount = sanitize($_POST['amount']);
    $item_name = sanitize($_POST['item_name']);
    $item_number = sanitize($_POST['item_number']);

    if (! filter_var($email, FILTER_VALIDATE_EMAIL) or strlen($email) >= 255) {
        $session->set_flashdata('error', 'Please enter correct email ID!');
        $error = TRUE;
    }
    elseif (strlen($fname) > 50 or strlen($lname) > 50) {
        $session->set_flashdata('error', 'Please enter your correct full name!');
        $error = TRUE;
    }
    elseif (! preg_match("/^[7-9]{1}\d{9}$/", $mobile)) {
        $session->set_flashdata('error', 'Please enter correct mobile number!');
        $error = TRUE;
    }
    elseif (! preg_match("/^[1-9]+[0-9]*+(?:\.[0-9]{2})?$/", $amount) or strlen($amount) > 10) {
        $session->set_flashdata('error', 'Please enter correct amount!');
        $error = TRUE;
    } elseif (strlen($item_number) > 50 or ! is_numeric($item_number)) {
        $session->set_flashdata('error', 'Invalid request!');
        $error = TRUE;
    }
}

if ($error) {
    header('Location: .');
    die();
}

$paypalClient = new \Paypal\Paypal([
    'cmd' => '_xclick',
    'no_note' => '1',
    'lc' => 'IND',
    'currency_code' => 'USD',
    'bn' => 'PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest',
    'first_name' => $fname,
    'last_name' => $lname,
    'email' => $email,
    'mobile' => $mobile,
    'amount' => $amount,
    'item_name' => $item_name,
    'item_number' => $item_number
]);

try {
    $paypalClient->buildQuery();
    $paypalClient->initTransaction();
    $paypalClient->redirect();
} catch (Exception $e) {
    echo $e->getMessage();
}
