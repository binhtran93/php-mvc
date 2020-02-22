<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 12:28
 */

namespace Requests;

interface IRequest
{
    /**
     * Retrieve all of input data
     *
     * @return mixed
     */
    function all();

    /**
     * get body data by name
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    function input($name, $default=null);

    /**
     * get query data by name
     *
     * @param $name
     * @param null $default
     * @return mixed
     */
    function query($name, $default=null);
}