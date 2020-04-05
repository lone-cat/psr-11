<?php

namespace LoneCat\PSR11;

use Exception;
use Psr\Container\ContainerExceptionInterface;

class ContainerException
    extends Exception
    implements ContainerExceptionInterface
{

}