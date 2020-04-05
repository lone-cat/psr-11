<?php

namespace LoneCat\Tests\Container;

use LoneCat\Tests\TestClass;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    public function testConstructor(): void
    {
        $class = mb_strtolower(MyClass::class);
        $a = new $class;
        self::assertEquals(1,1);
        \var_dump(class_exists(MyClass::class));
        exit;
        $container = \LoneCat\PSR11\Container\Container::instance();
        //$a = new MyClass();
        $a = $container[MyClass::class];
        self::assertTrue($a instanceof MyClass);
        //$a = $container[TestClass::class];
        //self::assertTrue($a instanceof TestClass);
    }

}