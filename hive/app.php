<?php

//======================================================================
// App System
//======================================================================

namespace Hive;

use Dotenv\Dotenv;
use Hive\Route;
use Hive\View;
use Hive\Connect;
use Hive\Request;

class App
{
    protected static $object;
    protected static $routes = [];
    public static function __callStatic($name, $args)
    {
        if (!static::$object) {
            static::$object = new static();
        }

        return static::$object;
    }

    public static function addRoutes($name)
    {
        static::$routes[] = $name;
    }

    public static function start()
    {
        //Start Session
        session_start();

        Request::read();
        //Load .Env
        $dotenv = Dotenv::createImmutable(__DIR__.'/../');
        $dotenv->safeLoad();
        //Load global functions
        require_once __DIR__.'/globals.php';



        //laod database
        Connect::start(env('DB_HOST'), env('DB_NAME'), env('DB_USER'), env('DB_PASS'));

        //load Twig
        View::start();
        //Load global functions
        require_once __DIR__.'/twig/globals.php';


        //Load controllers
        $dirControllers = __DIR__.'/../app/controllers';
        if ($handle = opendir($dirControllers)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && strpos($entry, "Controller.php")>-1) {
                    require_once $dirControllers.'/'.$entry;
                }
            }

            closedir($handle);
        }
        //Load routes
        foreach (self::$routes as $route) {
            $url = __DIR__.'/../app/routes/'.$route.'.php';
            if (file_exists($url)) {
                require_once $url;
            }
        }

        Route::start();
        Connect::close();
    }
}
