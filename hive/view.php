<?php

//======================================================================
// View System
//======================================================================

namespace Hive;

use Hive\Types\SingletonStaticClass;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Twig\TwigFunction;

class View extends SingletonStaticClass
{
    protected static $twig;
    protected static $loader;


    /* reads views files */
    public static function start()
    {
        self::$loader = new FilesystemLoader(__DIR__.'/../app/views/');
        /* this is Hive's views */
        self::$loader->addPath(__DIR__.'/views/', 'hive');
        self::$twig = new Environment(self::$loader);
    }

    /**
    * rendering a view
    *
    * @param string $name (require)
    * @param array $arguments
    * @return html page
    */
    public static function render($name, $arguments=[])
    {
        return self::$twig->render($name, $arguments);
    }

    /**
    * add function to twig system
    *
    * @param string $name (require)
    * @param array $func (require)
    */
    public static function addFunction($name, $func)
    {
        return self::$twig->addFunction(new TwigFunction($name, $func));
    }
}
