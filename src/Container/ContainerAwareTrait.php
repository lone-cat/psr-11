<?php

namespace LoneCat\PSR11\Container;

use Psr\Container\ContainerInterface;

trait ContainerAwareTrait
{
    protected ContainerInterface $container;

    public function setContainer(ContainerInterface $container) {
        $this->container = $container;
    }

}