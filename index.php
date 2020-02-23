<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 21/02/2020
 * Time: 23:16
 */
require "autoload.php";
require "DI.php";

define('SECRET', "secret"); // for simple mvc

$app = new App();

$app->setRoutes([
    '/payments/validate' => [
        'post' => [
            'action' => 'Controllers\PaymentController@validate',
            'middleware' => [
                \Middleware\Authenticate::class
            ]
        ]
    ],
]);

$app->boot();