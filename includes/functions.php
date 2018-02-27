<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 26-02-2018
 * Time: 22:56
 */

function sanitize($arg) {
    return filter_var($arg, FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * @param array $arr
 * @return bool
 */
function isAssoc(array $arr) {
    if (array() === $arr) return false;
    return array_keys($arr) !== range(0, count($arr) - 1);
}

function fetchTransactionDetail($token) {
    $db = Database::connect();
    $query = "SELECT paypal_txn_id, payment_amount, payment_currency, payment_status, payer_email FROM payments WHERE tracking_id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($txnId, $amount, $curr, $status, $email);
    $stmt->fetch();
    Database::disconnect();

    return array(
        'transaction_id' => $txnId,
        'payment_amount' => $amount,
        'payment_currency' => $curr,
        'payment_status' => $status,
        'payer_email' => $email
    );
}