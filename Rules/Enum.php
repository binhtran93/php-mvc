<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 14:39
 */

namespace Rules;

class Enum extends Rule {
    /**
     * @return boolean
     */
    function isValid()
    {
        $values = $this->args;
        return in_array($this->value, $values);
    }

    function message()
    {
        return "$this->key is must be one of values " . implode(', ', $this->args);
    }
}