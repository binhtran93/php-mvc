<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 12:42
 */

namespace Responses;

interface IResponse
{
    function toJson($data);

    function toXml($data);

    function from($data);
}