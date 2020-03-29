<?php

namespace LoneCat\PSR11\Container;

use Psr\Container\NotFoundExceptionInterface;

class NotFoundException
    extends ContainerException
    implements NotFoundExceptionInterface
{

}