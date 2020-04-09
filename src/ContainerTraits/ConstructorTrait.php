<?php

namespace LoneCat\PSR11\ContainerTraits;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;

trait ConstructorTrait
{

    /**
     * @param string $class_name
     * @return object
     */
    protected function constructObject(string $class_name): ?object {
        if (!class_exists($class_name)) {
            return null;
        }

        try {
            $reflection = new ReflectionClass($class_name);
        } catch (ReflectionException $e) {
            return null;
        }

        $constructor = $reflection->getConstructor();
        $arguments = [];
        if ($constructor instanceof ReflectionMethod) {

            if (!$constructor->isPublic()) {
                if (in_array(SingletonTrait::class,$reflection->getTraitNames() ?? [],true)) {
                    return $class_name::instance();
                }
                return null;
            }

            $arguments = $this->getParamsFromConstructor($constructor);
            if (is_null($arguments))
                return null;
        }

        return $reflection->newInstanceArgs($arguments);
    }

    protected function getParamsFromConstructor(ReflectionMethod $constructor): ?array {
        $arguments = [];
        foreach ($constructor->getParameters() as $parameter) {
            if ($parameter->isOptional()) {
                break;
            }
            elseif ($parameter->allowsNull()) {
                $argument = null;
            }
            elseif (
                $parameter->getClass()
                && $this->has($parameter->getClass()->getName())
            ) {
                $argument = $this->get($parameter->getClass()->getName());
            }
            else
                return null;

            $arguments[] = $argument;
        }

        return $arguments;
    }

}