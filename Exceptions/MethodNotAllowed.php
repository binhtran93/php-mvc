<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 12:46
 */

namespace Exceptions;

class MethodNotAllowed extends HttpException
{

    function output()
    {
        http_response_code(405);
        echo $this->getMessage();
    }
}