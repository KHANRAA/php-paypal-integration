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