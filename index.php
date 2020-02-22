<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 21/02/2020
 * Time: 23:16
 */
require "autoload.php";
require "DI.php";

$pathInfo = $_SERVER['PATH_INFO'];

$routes = [
    '/payments/validate' => 'Controllers\PaymentController@validate',
];

$convertedRoutes = [];
foreach ($routes as $index => $route) {
    $newIndex = str_replace('/', '\/', $index);
    $newIndex = str_replace('{id}', '(\d+)', $newIndex);
    $newIndex = "/^{$newIndex}$/";
    $convertedRoutes[$newIndex] = $route;
}

$parameters = null;
$route = null;
foreach ( $convertedRoutes as $index => $convertedRoute) {
    $isMatch = preg_match($index, $pathInfo, $matches);
    if ($isMatch) {
        $parameters = array_slice($matches, 1);
        $route = $convertedRoute;
        break;
    }
}

if (is_null($route)) {
    echo "Not found";
    die();
}

[$controller, $action] = explode('@', $route);

try {
    $di = new DI();
    if (class_exists($controller)) {
        $ctlInstance = $di->make($controller);

        if (method_exists($ctlInstance, $action)) {
            $ctlInstance->{$action}(...$parameters);
        }
    } else {
        echo 'Not found Controller';
    }
} catch (Throwable $t) {
    switch (get_class($t)) {
        case \Exceptions\MethodNotAllowed::class:
            http_response_code(405);
            echo $t->getMessage();
            break;

        default:
            http_response_code(500);
    }
}


/**
 * /items/{id} => /^\/items\/\d+$/
 * / => \/
 * {id} => (\d+)
 *
 */