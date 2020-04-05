<?php

namespace Tests;

use LoneCat\PSR11\Container\ContainerAwareTrait;
use LoneCat\PSR11\Container\ContanerAwareInterface;

class TestClass implements ContanerAwareInterface
{
    use ContainerAwareTrait;
}