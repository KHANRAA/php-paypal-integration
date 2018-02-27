<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 27-02-2018
 * Time: 01:38
 */

namespace Security;

class Security
{
    function __construct()
    {}

    public static function uniqueToken() {
        $secretKey = "3W7ed3v9m21nQGYoNI9I"; // Any random string
        $sessionId = session_id();
        $randomKey = bin2hex(openssl_random_pseudo_bytes(10));

        return hash('sha512', $secretKey . $sessionId . $randomKey);
    }
}