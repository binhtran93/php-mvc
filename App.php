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

            $patternRoues = $this->getPatternRoutes($this->routes);

            // The first pattern matched will be served
            [$patternResolved, $parameters] = $this->getRouteAndParameters($patternRoues, $pathInfo);
            if (is_null($patternResolved)) {
                throw new \Exceptions\NotFound('Route not found');
            }

            // Assume developer config correct route with `Controller@Action`
            [$controller, $action] = explode('@', $patternResolved);

            if (!class_exists($controller)) {
                throw new \Exception("Controller not found");
            }

            // call the action using dependency injection
            $di = new DI();
            $di->call($controller, $action, [], $parameters);

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
        foreach ($patternRoues as $patternRoute => $patternResolved) {
            $isMatch = preg_match($patternRoute, $pathInfo, $matches);
            if ($isMatch) {
                $parameters = array_slice($matches, 1);
                return [$patternResolved, $parameters];
            }
        }

        return [null, []];
    }
}