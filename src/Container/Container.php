<?php

namespace LoneCat\PSR11\Container;

use ArrayAccess;
use Closure;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionType;

class Container
    implements ContainerInterface,
               ArrayAccess
{

    protected static ?self $container = null;
    protected array $definitions = [];
    protected array $results = [];
    protected array $aliases = [];

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    protected function __wakeup()
    {
    }

    public static function instance(): self
    {
        if (!(static::$container instanceof static))
            static::$container = new static();
        return static::$container;
    }

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function has($id): bool
    {
        return
            array_key_exists($this->processId($id), $this->results)
            || array_key_exists($this->processId($id), $this->definitions)
            || class_exists($id);
    }

    protected function processId(string $id): string
    {
        return mb_strtolower($id);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    protected function aliasExists($id): bool {
        $lcase_id = $this->processId($id);

        return array_key_exists($lcase_id, $this->aliases);
    }

    protected function getAlias($id): string {
        return $this->aliases[$this->processId($id)];
    }

    public function get($id)
    {

        if ($this->aliasExists($id))
            $id = $this->getAlias($id);

        $lcase_id = $this->processId($id);

        if (array_key_exists($lcase_id, $this->results))
            return $this->results[$lcase_id];

        if (array_key_exists($lcase_id, $this->definitions)) {
            $definition = $this->definitions[$lcase_id];

            if ($definition instanceof Closure) {
                $this->results[$lcase_id] = $definition($this);
            }
            else {
                $this->results[$lcase_id] = $definition;
            }
        }
        else {
            if (!class_exists($id))
                throw new NotFoundException('Unknown service "' . $id . '"');
            try {
                $reflection = new ReflectionClass($id);
            }
            catch (ReflectionException $e) {
                throw new ContainerException($e->getMessage(), $e->getCode(), $e);
            }
            $arguments = [];
            $constructor = $reflection->getConstructor() ?? null;
            if ($constructor instanceof ReflectionMethod) {
                foreach ($constructor->getParameters() as $parameter) {
                    if ($parameter->isDefaultValueAvailable()) {
                        $argument = $parameter->getDefaultValue();
                    }
                    elseif ($parameter->getClass()) {
                        $argument = $this->get($parameter->getClass()
                                                         ->getName());
                    }
                    elseif ($parameter->isOptional()) {
                        break;
                    }
                    elseif ($parameter->allowsNull()) {
                        $argument = null;
                    }
                    /*
                    elseif ($parameter->isArray()) {
                        $argument = [];
                    }
                    elseif ($parameter->getType() instanceof ReflectionType) {
                        $paramType = $parameter->getType()
                                               ->getName()
                        ;
                        if ($paramType === 'string')
                            $argument = '';
                        elseif ($paramType === 'int')
                            $argument = 0;
                        elseif ($paramType === 'float')
                            $argument = .0;
                        elseif ($paramType === 'bool')
                            $argument = false;
                        else
                            throw new NotFoundException('Unable to resolve "' . $parameter->getName() . '"" in service "' . $id . '"');
                    }
                    */
                    else
                        throw new NotFoundException('Unable to resolve "' . $parameter->getName() . '"" in service "' . $lcase_id . '"');

                    $arguments[] = $argument;
                }
            }
            $object = $reflection->newInstanceArgs($arguments);
            if ($object instanceof ContanerAwareInterface) $object->setContainer($this);
            $this->results[$lcase_id] = $object;
        }

        return $this->results[$lcase_id];
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function set($id, $value): void
    {
        $id = $this->processId($id);

        $this->definitions[$id] = $value;
        unset ($this->results[$id]);
    }

    public function setAlias(string $from, string $to) {
        $this->aliases[$this->processId($from)] = $to;
    }

    public function offsetUnset($offset)
    {
        unset($this->definitions[$offset], $this->results[$offset]);
    }
}