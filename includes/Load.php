<?php
/**
 * Created by PhpStorm.
 * User: Faisal Alam
 * Date: 26-02-2018
 * Time: 22:57
 */

namespace Load;

/**
 * Class Load
 */
class Load
{
    function __construct()
    {}

    /**
     * Loads a page from page/ directory.
     *
     * @param string $page
     * @param array $vars
     * @throws \Exception
     */
    public function view($page, array $vars = array())
    {
        if (! empty($vars) or ! isAssoc($vars)) {
            throw new \Exception('The second argument expects an array containing name and value pair.');
        }

        foreach ($vars as $var => $val) {
            ${$var} = $val;
        }

        include(__DIR__ . "/../views/" . $page . ".php");
    }
}