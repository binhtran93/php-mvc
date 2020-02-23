<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 19:02
 */

namespace Middleware;


interface IMiddleware
{
    function tryToNext();

    function handle();
}