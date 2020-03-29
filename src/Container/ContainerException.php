<?php

namespace LoneCat\PSR11\Container;

use Exception;
use Psr\Container\ContainerExceptionInterface;

class ContainerException
    extends Exception
    implements ContainerExceptionInterface
{

}