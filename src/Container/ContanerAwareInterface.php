<?php

namespace LoneCat\PSR11\Container;

use Psr\Container\ContainerInterface;

interface ContanerAwareInterface
{
    public function setContainer(ContainerInterface $container);
}