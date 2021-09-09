<?php

//======================================================================
// Route System
//======================================================================

namespace Hive\Route;

use Hive\Request;

class Route
{
    protected static $object;
    protected static $routes = [];

    public static function __callStatic($name, $args)
    {
        if (!static::$object) {
            static::$object = new static();
        }
        /* singleton pattern design */
        return static::$object;
    }


    /* add a route to static */
    private static function add($method, $route, $function, $call=null)
    {
        $request = Request::get();
        $thisRoute = ['uri'=>$route,'method'=>$method,'call'=>$call, 'function'=> function () use ($function, $call, $request, $route) {
            $uri = urldecode(
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            );

            $regex = preg_replace(['/\/{([[:word:]]+)}/sm','/\//sm'], ['/([[:word:]]+)','\/'], $route);
            $data = [];

            if (!preg_match('/^'.$regex.'(\/|\/\/)$/sm', $uri.'/', $data) && $uri!=$route) {
                return abort(404);
            }

            if (is_null($call)) {
                switch (count($data)) {
                    case 2:
                        return $function($request);
                    break;
                    case 3:
                        return $function($request, $data[1]);
                    break;
                    case 4:
                        return $function($request, $data[1], $data[2]);
                    break;
                    case 5:
                        return $function($request, $data[1], $data[2], $data[3]);
                    break;
                    case 6:
                        return $function($request, $data[1], $data[2], $data[3], $data[4]);
                    break;
                }
            } else {
                $func = new $function();

                switch (count($data)) {
                    case 2:
                        return $func->$call($request);
                    break;
                    case 3:
                        return $func->$call($request, $data[1]);
                    break;
                    case 4:
                        return $func->$call($request, $data[1], $data[2]);
                    break;
                    case 5:
                        return $func->$call($request, $data[1], $data[2], $data[3]);
                    break;
                    case 6:
                        return $func->$call($request, $data[1], $data[2], $data[3], $data[4]);
                    break;
                }
            }
        }];
        if (!in_array($thisRoute, self::$routes)) {
            self::$routes[] = $thisRoute;
        }
    }
    /**
    * get method send to a function
    *
    * @param string $route (require)
    * @param object $function (can be class-require)
    * @param object $function (require in class)
    */
    public static function get($route, $function, $call=null)
    {
        self::add('GET', $route, $function, $call);
    }
    /**
    * post method send to a function
    *
    * @param string $route (require)
    * @param object $function (can be class-require)
    * @param object $function (require in class)
    */
    public static function post($route, $function, $call=null)
    {
        self::add('POST', $route, $function, $call);
    }
    /**
    * any method send to a function
    *
    * @param string $route (require)
    * @param object $function (can be class-require)
    * @param object $function (require in class)
    */
    public static function any($route, $function, $call=null)
    {
        self::add('ANY', $route, $function, $call);
    }
    /* find now route and run this */
    public static function start()
    {
        foreach (self::$routes as $route) {
            $uri = urldecode(
                parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
            );
            $regex = preg_replace(['/\/{([[:word:]]+)}/sm','/\//sm'], ['/([[:word:]]+)','\/'], $route['uri']);
            if (($uri == $route['uri'] || ($route['uri']!=$uri && $regex!='\/' && preg_match('/^'.$regex.'(\/|\/\/)$/sm', $uri.'/'))) && ($route['method']=='ANY' || $route['method']==$_SERVER['REQUEST_METHOD'])) {
                if (is_null($route['call'])) {
                    print_r(call_user_func($route['function']));
                    return null;
                } else {
                    print_r(call_user_func($route['function']));
                    return null;
                }
            }
        }

        return abort(404);
    }
}
