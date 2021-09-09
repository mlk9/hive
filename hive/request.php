<?php

//======================================================================
// Request System
//======================================================================

namespace Hive;

use Hive\Obj;
use Hive\Types\SingletonStaticClass;

class Request extends SingletonStaticClass
{

    public static $query;

    /* read header queries as class */
    public static function read()
    {
        $other = [
            'previous' =>  isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
            'system' => $_SERVER['HTTP_USER_AGENT'],
            'ip' => $_SERVER['REMOTE_ADDR'],
        ];
        $query = [];
        if (isset($_SERVER['QUERY_STRING'])) {   
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
