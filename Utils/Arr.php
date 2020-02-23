<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 10:56
 */
namespace Utils;

class Arr
{
    public static function get($array, $key, $default=null) {
        return $array[$key] ?? $default;
    }
}