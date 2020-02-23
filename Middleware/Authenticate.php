<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 23/02/2020
 * Time: 18:47
 */
namespace Middleware;

use Exceptions\Unauthorized;
use Utils\JWT;

class Authenticate implements IMiddleware {

    /**
     * @return bool
     */
    function tryToNext() {
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        preg_match('/Bearer\s(\S+)/', $authorization, $matches);
        $token = $matches[1];
        $secret = get_defined_constants()['SECRET'];
        // sample for valid token cHVibGlj.W10.MTU4MjQ2MDU4MQ.3X4WqamhJu4R_Mjyzn-rwnmiNPilM7h1lR5DagBSEBM
        return JWT::verify($token, $secret);
    }

    /**
     * @throws Unauthorized
     */
    function handle()
    {
        throw new Unauthorized('You are not authorized');
    }
}