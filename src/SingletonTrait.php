<?php

namespace LoneCat\PSR11;

trait SingletonTrait
{
    protected static ?self $instance = null;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    protected function __wakeup()
    {
    }

    public static function instance(): self
    {
        if (!(static::$instance instanceof static))
            static::$instance = new static();
        return static::$instance;
    }
}