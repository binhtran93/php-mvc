<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 11:57
 */

namespace Rules;
use DateTime;

class ExpiredDate extends Date
{
    private $message;

    /**
     * @return boolean
     * @throws \Exception
     */
    public function isValid()
    {
        if ($this->value === null) {
            return true;
        }

        $isValid = parent::isValid();
        if (!$isValid) {
            $this->message = "$this->key is not valid";
            return false;
        }

        $expiredDate = new DateTime();
        [$month, $year] = $this->getMonthYear();
        $expiredDate->setDate($year, $month, 1);
        $expiredDate->setTime(00, 00, 00);

        $now = new DateTime();

        $isExpired = $expiredDate->getTimestamp() <= $now->getTimestamp();
        if ($isExpired) {
            $this->message = "$this->key is expired";
        }

        return !$isExpired;
    }

    /**
     * @return mixed
     */
    public function message()
    {
        return $this->message;
    }
}