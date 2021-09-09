<?php

//======================================================================
// Language System
//======================================================================

namespace Hive\Language;

use Hive\Types\SingletonStaticClass;

class Language extends SingletonStaticClass
{

    protected static $PDO =null;
    protected static $language;

    /* select language */
    public static function select($langClass='English')
    {
        $_SESSION['language'] = $langClass;
        $path = "\\App\\Languages\\{$langClass}Language";
        self::$language = new $path();
        self::$language->phrases();
        self::$language->words();
    }

    public static function getPhrase($key,$arguments=[])
    {
        if(!key_exists($key,self::$language->phrases))
            return $key;
        $translate = self::$language->phrases[$key];
        foreach ($arguments as $key=>$argument) {
            $translate = str_replace("{{$key}}",$argument,$translate);
        }
        return $translate;
    }

    public static function getWord($key)
    {
        if(!key_exists($key,self::$language->words))
            return $key;
        return self::$language->words[$key];
    }
}