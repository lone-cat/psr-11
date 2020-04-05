<?php

namespace LoneCat\PSR11;

use Psr\Container\NotFoundExceptionInterface;

class NotFoundException
    extends ContainerException
    implements NotFoundExceptionInterface
{

}