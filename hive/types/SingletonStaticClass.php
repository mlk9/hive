<?php 

namespace Hive\Types;

class SingletonStaticClass
{
    protected static $object;
    public static function __callStatic($name, $args)
    {
        if (!static::$object) {
            static::$object = new static();
        }
        return static::$object;
    }
}