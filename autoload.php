<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 12:54
 */

/**
 * @param $class
 */
function autoloader($class)
{
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register('autoloader');