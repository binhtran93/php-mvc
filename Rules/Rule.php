<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 14:39
 */

namespace Rules;

abstract class Rule
{
    /** @var String $key */
    protected $key;

    /** @var String $value */
    protected $value;

    /**
     * Rule constructor.
     * @param $key
     * @param $value
     */
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @param array $args
     * @return boolean
     */
    abstract function isValid();

    /**
     * @return string
     */
    abstract function message();
}