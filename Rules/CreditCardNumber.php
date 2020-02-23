<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 14:17
 */

namespace Rules;
use Utils\CreditCard;

class CreditCardNumber extends Rule
{

    /**
     * @param array $args
     * @return boolean
     */
    public function isValid()
    {
        return CreditCard::checkValidNumber($this->value);
    }
}