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
}