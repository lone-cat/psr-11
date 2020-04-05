<?php

namespace LoneCat\PSR11;

use ArrayAccess;
use Closure;
use LoneCat\PSR11\ContainerAware\ContanerAwareInterface;
use LoneCat\PSR11\ContainerTraits\AliasesTrait;
use LoneCat\PSR11\ContainerTraits\ArrayAccessTrait;
use LoneCat\PSR11\ContainerTraits\ConstructorTrait;
use LoneCat\PSR11\ContainerTraits\SingletonTrait;
use Psr\Container\ContainerInterface;

class Container
    implements ContainerInterface,
               ArrayAccess
{
    use ArrayAccessTrait,
        SingletonTrait,
        AliasesTrait,
        ConstructorTrait;

    protected array $definitions = [];
    protected array $results = [];


    public function has($id): bool
    {
        return
            array_key_exists($this->processId($id), $this->results)
            || array_key_exists($this->processId($id), $this->definitions)
            || !is_null($this->constructObject($id));
    }

    public function get($id)
    {
        if ($this->aliasExists($id))
            $id = $this->getAlias($id);

        if (!is_null($result = $this->getFromResults($id)) )
            return $result;

        if (!is_null($result = $this->getResultFromDefinitions($id))) {
            $this->setResult($id, $result);
            return $result;
        }

        $result = $this->constructObject($id);
        if (!is_null($result)) {
            if ($result instanceof ContanerAwareInterface) $result->setContainer($this);
            $this->setResult($id, $result);
            return $result;
        }

        throw new NotFoundException('Unknown service "' . $id . '"');
    }

    public function set(string $id, $value) {
        $this->setDefinition($id, $value);
    }

    protected function processId(string $id): string
    {
        return mb_strtolower($id);
    }

    protected function getFromResults(string $id) {
        $lcase_id = $this->processId($id);
        return $this->results[$lcase_id] ?? null;
    }

    protected function getFromDefinitions(string $id) {
        return $this->definitions[$this->processId($id)] ?? null;
    }

    protected function getResultFromDefinitions(string $id) {
        $definition = $this->getFromDefinitions($id);
        if (is_null($definition))
            return null;

        if ($definition instanceof Closure)
            return $definition($this);

        return $definition;
    }

    protected function setDefinition(string $id, $value): void
    {
        $lcase_id = $this->processId($id);

        $this->definitions[$lcase_id] = $value;
        unset ($this->results[$lcase_id]);
    }

    protected function setResult(string $id, $value) {
        $this->results[$this->processId($id)] = $value;
    }

}