<?php

namespace LoneCat\PSR11\ContainerTraits;

trait AliasesTrait
{
    protected array $aliases = [];

    protected function aliasExists($id): bool {
        $lcase_id = $this->processId($id);

        return array_key_exists($lcase_id, $this->aliases);
    }

    protected function getAlias($id): string {
        return $this->aliases[$this->processId($id)];
    }

    public function setAlias(string $from, string $to) {
        $this->aliases[$this->processId($from)] = $to;
    }

}