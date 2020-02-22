<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 21/02/2020
 * Time: 23:16
 */
require "autoload.php";
require "DI.php";

$app = new App();

$app->setRoutes([
    '/payments/validate' => 'Controllers\PaymentController@validate',
]);

$app->boot();