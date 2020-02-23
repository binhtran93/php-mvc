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
            return false;
        }

        $date = $this->getDateTimeInstance();
        $date->setTime(00, 00, 00);
        $now = new DateTime();

        return $date->getTimestamp() >= $now->getTimestamp();
    }

    /**
     * @return mixed
     */
    public function message()
    {
        return "$this->key is expired";
    }
}