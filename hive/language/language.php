<?php

//======================================================================
// Language System
//======================================================================

namespace Hive;

class Language
{
    protected static $object;
    protected static $PDO =null;

    public static function __callStatic($name, $arguments)
    {
        if (!static::$object) {
            static::$object = new static();
        }

        return static::$object;
    }

    public static function select($langClass)
    {
        
    }
}