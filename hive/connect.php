<?php

//======================================================================
// Connect (PDO) System
//======================================================================

namespace Hive;

use PDO;
use PDOException;

class Connect
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

    public static function start($host, $name, $user, $password)
    {
        try {
            self::$PDO = new PDO("mysql:host={$host};dbname={$name}", $user, $password);
            self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function get()
    {
        return self::$PDO;
    }

    public static function close()
    {
        self::$PDO = null;
        self::$object = null;
    }

    public static function getTables()
    {
        $data = self::$PDO->prepare('SHOW TABLES');
        $data->execute();
        $res = $data->setFetchMode(PDO::FETCH_ASSOC);
        return $data->fetchAll();
    }
}
