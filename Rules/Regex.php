<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 13:53
 */

namespace Rules;


class Regex extends Rule
{

    /**
     * @param array $args
     * @return boolean
     */
    public function isValid()
    {
        if ($this->value === null) {
            return true;
        }

        $pattern = $this->args[0];
        return preg_match($pattern, $this->value);
    }
}