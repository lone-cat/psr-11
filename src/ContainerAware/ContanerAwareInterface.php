<?php

namespace LoneCat\PSR11\ContainerAware;

use Psr\Container\ContainerInterface;

interface ContanerAwareInterface
{
    public function setContainer(ContainerInterface $container);
}