<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 12:00
 */

/**
 * @param $number
 * @return bool
 */
function luhnAlgorithm($number) {
    // remove space
    $number = str_replace(' ', '', $number);
    $length = strlen($number);
    $count = 0;
    for ($index = 0; $index < $length; $index++) {
        $digit = (int) $number[$index];
        if ($index % 2 !== 0) {
            $count += $digit;
        } else {
            $count += array_sum(str_split($digit * 2));
        }
    }

    return $count % 10 === 0;
}

$number = '3379 5135 6110 8795';
var_dump(luhnAlgorithm($number));