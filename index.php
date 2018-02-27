<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 26-02-2018
 * Time: 21:49
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/includes/Database.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/Session.php';
require_once __DIR__ . '/includes/Security.php';
require_once __DIR__ . '/includes/Load.php';
require_once __DIR__ . '/Paypal/Paypal.php';

$load = new \Load\Load();
$session = new \Session\Session();

$session->init_session(); // Start the session

$data = array(
    'session' => $session
);

if (! isset($_GET['page'])) {
    $load->view('home', $data);
} else {
    $page = $_GET['page'];

    switch($page) {
        case 'home':
            $load->view('home', $data);
            break;
        case 'payment_paypal_cnf':
            $load->view('paymentCnf', $data);
            break;
        case 'payment_failure':
            $load->view('paymentFailure', $data);
            break;
        case 'payment_success':
            $load->view('paymentSuccess', $data);
            break;
        case 'makepayment':
            $load->view('makepayment', $data);
            break;
        default:
            header('HTTP/1.0 404 Not Found');
            $load->view('404');
    }
}