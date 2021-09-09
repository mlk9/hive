<?php

//======================================================================
// App System
//======================================================================

namespace Hive;

use Dotenv\Dotenv;
use Hive\Route\Route;
use Hive\View;
use Hive\Connect;
use Hive\Request;
use Hive\Language\Language;

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
        require_once __DIR__.'/../app/config/functions.php';

        //load language
        if (!isset($_SESSION['language'])) {
            $_SESSION['language'] = env('APP_LANGUAGE');
        }
        Language::select($_SESSION['language']);

        //Load routes
        foreach (self::$routes as $route) {
            if(class_exists($route))
            {
                $objectRoute = new $route();
                $objectRoute->register(); 
            }else{
                throw new \Exception("This route not found : {$route}");
            }
        }

        Route::start();

        Connect::close();
    }
}
