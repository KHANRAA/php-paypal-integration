<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 26-02-2018
 * Time: 21:29
 */

define("HOST", "localhost"); // MySQL Host
define("DBUSER", "root"); // MySQL user
define("DBPWD", ""); // MySQL password
define("DBNAME", "paypal_demo"); // MySQL database name
define("TIMEZONE", "+05:30"); // Timezone

define("ENV", "development"); // or production
define("BASEURL", "https://donate.cyberticks.com"); // URL of your website. Do NOT put trailing slash

// Redirect URLs after payment
define("PAYMENT_SUCCESS_URL", "https://donate.cyberticks.com/payment_success");
define("PAYMENT_FAILURE_URL", "https://donate.cyberticks.com/payment_failure");
define("PAYMENT_NOTIFY_URL", "https://donate.cyberticks.com/payment_paypal_cnf");

// Paypal RESTful API configuration
define("SANDBOX_ENDPOINT", "https://www.sandbox.paypal.com");
define("LIVE_ENDPOINT", "https://www.paypal.com");

// Paypal business account email ID
define("MERCHANT_EMAIL", ""); // Your Paypal email ID