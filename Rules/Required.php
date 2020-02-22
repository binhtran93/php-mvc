<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 14:39
 */

namespace Rules;

class Required extends Rule
{

    /**
     * @return boolean
     */
    function isValid()
    {
        return $this->value !== '' && $this->value !== null;
    }

    function message()
    {
        return "$this->key is required";
    }
}