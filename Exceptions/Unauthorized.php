<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 15:23
 */

namespace Exceptions;


class Unauthorized extends HttpException
{

    function output()
    {
        http_response_code(401);
        echo $this->getMessage();
    }
}