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

    /** @var array $data */
    protected $data;

    /** @var array $args */
    protected $args;

    /**
     * Rule constructor.
     * @param $key
     * @param $value
     * @param $data
     * @param array $args
     */
    public function __construct($key, $value, $data, ...$args)
    {
        $this->key = $key;
        $this->value = $value;
        $this->data = $data;
        $this->args = $args;
    }

    /**
     * @param array $args
     * @return boolean
     */
    public abstract function isValid();

    /**
     * @return string
     */
    function message() {
        return "$this->key is not valid";
    }
}