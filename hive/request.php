<?php

//======================================================================
// Request System
//======================================================================

namespace Hive;

use Hive\Obj;

class Request
{
    protected static $object;
    public static $query;

    public static function __callStatic($name, $arguments)
    {
        if (!static::$object) {
            static::$object = new static();
        }
        /* singleton pattern design */
        return static::$object;
    }

    /* read header queries as class */
    public static function read()
    {
        $other = [
            'previous' =>  isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
            'system' => $_SERVER['HTTP_USER_AGENT'],
            'ip' => $_SERVER['REMOTE_ADDR'],
        ];
        if (isset($_SERVER['QUERY_STRING'])) {
            $query = [];
            parse_str($_SERVER['QUERY_STRING'], $query);
        }
        self::$query = new Obj(array_merge(['visitor'=>$other],$query));
    }

    /* return header queries */
    public static function get()
    {
        return self::$query;
    }
}
