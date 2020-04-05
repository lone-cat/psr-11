<?php

namespace Tests;

use LoneCat\PSR11\ContainerAware\ContainerAwareTrait;
use LoneCat\PSR11\ContainerAware\ContanerAwareInterface;

class TestClass implements ContanerAwareInterface
{
    use ContainerAwareTrait;
}