<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 16:09
 */

namespace Exceptions;


abstract class HttpException extends \Exception
{
    abstract function output();
}