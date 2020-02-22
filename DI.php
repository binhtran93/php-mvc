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
     * Simple make function
     *
     * @param $concrete
     * @param array $parameters
     * @return object
     * @throws Exception
     */
    public function make($concrete) {
        if (!class_exists($concrete)) {
            throw new \Exception("Cannot resolve no-exists class");
        }

        $reflector = new ReflectionClass($concrete);
        if (!$reflector->isInstantiable()) {
            throw new \Exception("Cannot instantiable ");
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
     * @return array
     * @throws Exception
     */
    private function resolveParameters($parameters) {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $class = $parameter->getClass();
            if (is_null($class)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new \Exception("Cannot resolve class $class");
                }
            } else {
                $dependencies[] = $this->make($class->getName());
            }
        }

        return $dependencies;
    }
}

