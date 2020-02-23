<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 14:08
 */

namespace Rules;


class Email extends Rule {

    /**
     * @param array $args
     * @return boolean
     */
    public function isValid()
    {
        if (is_null($this->value)) {
            return true;
        }

        $email = filter_var($this->value, FILTER_SANITIZE_EMAIL);
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}