<?php

namespace Tests;

use LoneCat\PSR11\ContainerAwareTrait;
use LoneCat\PSR11\ContanerAwareInterface;

class TestClass implements ContanerAwareInterface
{
    use ContainerAwareTrait;
}