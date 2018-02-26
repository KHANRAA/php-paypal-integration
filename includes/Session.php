<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 27-02-2018
 * Time: 00:04
 */

namespace Session;

class Session
{
    function __construct()
    {}

    public function init_session() {
        session_start();
        $this->unset_flashdata();
    }

    /**
     * Set flash session variable which is valid until the next request, and automatically gets destroyed afterwards.
     *
     * @param string $key
     * @param $value
     * @return bool
     */
    public function set_flashdata($key, $value) {
        $_SESSION[$key] = $value;
        $_SESSION['flashdata'][$key] = 'new';

        return TRUE;
    }

    /**
     * Destroys the flash session data.
     *
     * @return bool
     */
    function unset_flashdata() {
        if (! empty($_SESSION['flashdata'])) {

            $current_time = time();

            foreach ($_SESSION['flashdata'] as $key => $value) {
                if ($value === 'new') {
                    $_SESSION['flashdata'][$key] = 'old';
                }
                elseif ($value < $current_time) {
                    unset($_SESSION['flashdata'][$key], $_SESSION[$key]);
                }
            }

            if (empty($_SESSION['flashdata'])) {
                unset($_SESSION['flashdata']);
            }
        }

        return TRUE;
    }
}