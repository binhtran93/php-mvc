<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 14:38
 */

namespace Utils;


class CreditCard
{
    /**
     * @param $number
     * @return bool
     */
    public static function checkValidNumber($number) {
        // remove space
        $number = str_replace(' ', '', $number);
        $length = strlen($number);
        $count = 0;
        for ($index = 0; $index < $length; $index++) {
            if (!is_numeric($number[$index])) {
                return false;
            }

            $digit = (int) $number[$index];
            if ($index % 2 !== 0) {
                $count += $digit;
            } else {
                $count += array_sum(str_split($digit * 2));
            }
        }

        return $count % 10 === 0;
    }
}