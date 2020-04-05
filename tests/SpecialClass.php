<?php

namespace Tests;

use LoneCat\PSR11\Container;

class SpecialClass
{
    protected Container $container;
    protected MyClass $myclass;
    protected ?MyClass $myclass2;
    protected int $var1;
    protected array $var2;

    public function __construct(Container $container, MyClass $myclass, ?MyClass $myclass2, int $var1 = 54, array $var2 = ['alex'])
    {

        $this->container = $container;
        $this->myclass = $myclass;
        $this->myclass2 = $myclass2;
        $this->var1 = $var1;
        $this->var2 = $var2;
    }

    public function getContainer() {
        return $this->container;
    }

    public function getMyClass() {
        return $this->myclass;
    }

    public function getMyClass2() {
        return $this->myclass2;
    }

    public function getMyVar1() {
        return $this->var1;
    }

    public function getMyVar2() {
        return $this->var2;
    }
}