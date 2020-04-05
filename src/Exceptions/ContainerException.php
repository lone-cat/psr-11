<?php

namespace LoneCat\PSR11\Exceptions;

use Exception;
use Psr\Container\ContainerExceptionInterface;

class ContainerException
    extends Exception
    implements ContainerExceptionInterface
{

}