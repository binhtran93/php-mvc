<?php
/**
 * Created by PhpStorm.
 * User: binh
 * Date: 22/02/2020
 * Time: 13:49
 */

/**
 * Simple dependency injection that mimics laravel
 */

class DI
{
    /**
     * @param $concrete
     * @param $method
     * @param array $constructParams
     * @param array $methodParams
     * @return object
     * @throws ReflectionException
     * @throws Exception
     */
    public function call($concrete, $method, $constructParams=[], $methodParams=[]) {
        if (!class_exists($concrete)) {
            throw new \Exception("Cannot resolve no-exists class");
        }

        $reflector = new ReflectionClass($concrete);
        if (!$reflector->isInstantiable()) {
            throw new \Exception("Cannot instantiable");
        }

        $instance = $this->make($concrete, $constructParams);

        $method = $reflector->getMethod($method);
        if (is_null($method)) {
            throw new \Exception("Method is not existed");
        }

        $parameters = $method->getParameters();

        if (count($parameters) === 0) {
            return $instance->{$method->name}();
        }

        $dependencies = $this->resolveParameters($parameters, $methodParams);

        return $instance->{$method->name}(...$dependencies);
    }

    /**
     * Simple make function
     *
     * @param $concrete
     * @param array $constructParams
     * @return object
     * @throws ReflectionException
     * @throws Exception
     */
    public function make($concrete, $constructParams=[]) {
        if (!class_exists($concrete)) {
            throw new \Exception("Cannot resolve no-exists class");
        }

        $reflector = new ReflectionClass($concrete);
        if (!$reflector->isInstantiable()) {
            throw new \Exception("Cannot instantiable");
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            return $reflector->newInstance();
        }

        $parameters = $constructor->getParameters();

        if (count($parameters) === 0) {
            return $reflector->newInstance();
        }

        $dependencies = $this->resolveParameters($parameters);

        return $reflector->newInstanceArgs($dependencies);
    }

    /**
     * @param ReflectionParameter[] $parameters
     * @param array $customDefaultValues
     * @return array
     * @throws ReflectionException
     * @throws Exception
     */
    private function resolveParameters($parameters, $customDefaultValues=[]) {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $class = $parameter->getClass();
            if (!is_null($class)) {
                $dependencies[] = $this->make($class->getName());
                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
                continue;
            }

            if (!count($customDefaultValues) === 0) {
                throw new \Exception("Cannot resolve class $class");
            }

            $dependencies[] = array_shift($customDefaultValues);
        }

        return $dependencies;
    }
}

