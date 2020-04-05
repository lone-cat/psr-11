<?php

namespace Tests\Container;

use LoneCat\PSR11\Container\Container;
use LoneCat\PSR11\Container\ContanerAwareInterface;
use Tests\TestClass;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testConstructor(): void
    {
        $container = Container::instance();
        $container->setAlias('abc', MyClass::class);
        //$a = new MyClass();
        $a = $container['abc'];
        self::assertTrue($a instanceof MyClass);
        $a = $container[TestClass::class];
        self::assertTrue($a instanceof ContanerAwareInterface);
    }

}