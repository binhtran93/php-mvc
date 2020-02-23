<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 16:25
 */

class App {
    private $routes = [];

    /**
     * @param array $routes
     */
    public function setRoutes($routes=[]) {
        $this->routes = $routes;
    }

    /**
     */
    public function boot() {
        try {
            $pathInfo = $_SERVER['PATH_INFO'];
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            $patternRoues = $this->getPatternRoutes($this->routes);

            // The first pattern matched will be served
            [$patternResolves, $parameters] = $this->getRouteAndParameters($patternRoues, $pathInfo);
            if (is_null($patternResolves)) {
                throw new \Exceptions\NotFound('Route not found');
            }

            $foundPatternResolve = null;
            foreach ($patternResolves as $resolvedRequestMethod => $patternResolve) {
                if ($requestMethod === strtoupper($resolvedRequestMethod)) {
                    $foundPatternResolve = $patternResolve;
                    break;
                }
            }

            if (is_null($foundPatternResolve)) {
                throw new \Exceptions\NotFound("Route not found");
            }

            $action = $foundPatternResolve['action'] ?? null;
            if (is_null($action)) {
                throw new \Exceptions\NotFound("Must provide action");
            }

            [$controller, $method] = explode('@', $action);

            if (is_null($controller )&& is_null($method)) {
                throw new \Exceptions\NotFound("Route not found");
            }

            if (!class_exists($controller) || !method_exists($controller, $method)) {
                throw new \Exceptions\NotFound("Controller or method not found");
            }

            // simple for middleware
            $middlewareList = $foundPatternResolve['middleware'] ?? [];
            $this->executeMiddleware($middlewareList);

            // call the action using dependency injection
            $di = new DI();
            $di->call($controller, $method, [], $parameters);

        } catch (Throwable $t) {
            if (is_subclass_of($t, Exceptions\HttpException::class)){
                /** @var Exceptions\HttpException $t */
                $t->output();
            } else {
                syslog(LOG_ERR, $t);
                echo 'Server error';
            }
            die();
        }
    }

    /**
     * Convert to regex pattern routes
     * @param $routes
     * @return array
     */
    private function getPatternRoutes($routes) {
        $patternRoutes = [];
        foreach ($routes as $route => $resolved) {
            $patternRoute = str_replace('/', '\/', $route);
            $patternRoute = str_replace('{id}', '(\d+)', $patternRoute);
            $patternRoute = "/^{$patternRoute}$/";
            $patternRoutes[$patternRoute] = $resolved;
        }

        return $patternRoutes;
    }

    /**
     * @param $patternRoues
     * @param $pathInfo
     * @return array
     */
    private function getRouteAndParameters($patternRoues, $pathInfo) {
        foreach ($patternRoues as $patternRoute => $patternResolves) {
            $isMatch = preg_match($patternRoute, $pathInfo, $matches);
            if ($isMatch) {
                $parameters = array_slice($matches, 1);
                return [$patternResolves, $parameters];
            }
        }

        return [null, []];
    }

    /**
     * Simple middleware
     * @param $middlewareList
     */
    private function executeMiddleware($middlewareList) {
        foreach ($middlewareList as $middlewareClass) {
            /** @var \Middleware\IMiddleware $middleware */
            $middleware = new $middlewareClass();
            $tryToNext = $middleware->tryToNext();
            if (!$tryToNext) {
                $middleware->handle();
                die();
            }
        }
    }
}