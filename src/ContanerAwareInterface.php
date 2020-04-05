<?php

namespace LoneCat\PSR11;

use Psr\Container\ContainerInterface;

interface ContanerAwareInterface
{
    public function setContainer(ContainerInterface $container);
}