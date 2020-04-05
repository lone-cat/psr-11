<?php

namespace LoneCat\PSR11\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

class NotFoundException
    extends ContainerException
    implements NotFoundExceptionInterface
{

}