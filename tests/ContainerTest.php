<?php

namespace Tests;

use LoneCat\PSR11\Container;
use LoneCat\PSR11\ContainerAware\ContanerAwareInterface;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{

    public function testPuttedObjectGet() {
        $container = Container::instance();

        $container[$key1 = 'abc'] = new MyClass();
        $container[$key2 = 'def'] = new TestClass();

        self::assertTrue($container[$key1] instanceof MyClass);
        self::assertTrue($container[$key2] instanceof ContanerAwareInterface);
    }

    public function testSingleCreation() {
        $container = Container::instance();

        $container[$key1 = 'abcd'] = new MyClass();
        $container[$key2 = 'abcde'] = function ($container) {
            return new MyClass();
        };

        $myClass1 = $container[$key1];
        $myClass2 = $container[$key1];

        self::assertTrue($myClass1 === $myClass2);

        $myClass1 = $container[$key2];
        $myClass2 = $container[$key2];

        self::assertTrue($myClass1 === $myClass2);
    }

    public function testAutowiring() {
        $container = Container::instance();

        $object = $container[self::class];

        self::assertTrue($object instanceof self);
    }

    public function testAutowiringComplex() {
        $container = Container::instance();

        $object = $container[SpecialClass::class];

        self::assertTrue($object->getContainer() === $container);
        self::assertTrue($object->getMyClass() instanceof MyClass);
        self::assertTrue(is_null($object->getMyClass2()));
        self::assertTrue($object->getMyVar1() === 54);
        self::assertTrue($object->getMyVar2() === ['alex']);
    }


}