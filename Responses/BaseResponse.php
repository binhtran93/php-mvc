<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 12:42
 */
namespace Responses;

class BaseResponse implements IResponse
{

    public function code($code)
    {
        return http_response_code($code);
    }

    function toJson($data, $code=200) {
        http_response_code($code);
        header('Content-Type: application/json');

        return json_encode($data);
    }

    function toXml($data) {

    }
}