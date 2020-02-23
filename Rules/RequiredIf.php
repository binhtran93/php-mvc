<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 11:03
 */

namespace Rules;


class RequiredIf extends Rule
{

    /**
     * @param array $args
     * @return boolean
     */
    function isValid()
    {
        $targetKey = $this->args[0];
        $targetValue = $this->args[1];

        if ($this->data[$targetKey] === $targetValue) {
            if ($this->value === null || $this->value === '') {
                return false;
            }
        }

        return true;
    }

    /**
     * @return string
     */
    function message()
    {
        return "$this->key is required when type is {$this->args[1]}";
    }
}