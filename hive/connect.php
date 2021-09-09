<?php

//======================================================================
// Connect (PDO) System
//======================================================================

namespace Hive;

use Hive\Types\SingletonStaticClass;
use PDO;
use PDOException;

class Connect extends SingletonStaticClass
{
    
    protected static $PDO =null;
    
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
