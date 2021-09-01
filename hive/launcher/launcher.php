<?php

namespace Hive\Launcher;

use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;
use Hive\Launcher\Controller;
use Hive\Launcher\Model;
use Hive\Route;

class LauncherApp extends CLI
{
    protected static $object;
    protected static $routes = [];
    public static function __callStatic($name, $arguments)
    {
        if (!static::$object) {
            static::$object = new static();
        }

        return static::$object;
    }

    /**
     * Register options and arguments on the given $options object
     *
     * @param Options $options
     * @return void
     */
    protected function setup(Options $options)
    {
        $options->setHelp("\e[33mWelcome to Hive launcher v1.0.1\e[39m");

        $options->registerCommand('start-server', "\e[92mStart Server \e[39m (default:http://localhost:8000)");
        $options->registerArgument('host', "\e[33mChange Host\e[39m", false, 'start-server');
        $options->registerArgument('port', "\e[33mChange Post\e[39m", false, 'start-server');

        $options->registerCommand('make', "\e[92mMake automatically Models, Controllers \e[39m (example:php launcher make controller <Controller Name>)");
        $options->registerArgument('type', "\e[33mCan be model or controller\e[39m", true, 'make');
        $options->registerArgument('name', "\e[33mFile name or address+name\e[39m", true, 'make');

        // $options->registerCommand('routes', "\e[92mCan see routes list \e[39m");
    }

    /**
    * Your main program
    *
    * Arguments and options have been parsed when this is run
    *
    * @param Options $options
    * @return void
    */
    protected function main(Options $options)
    {
        switch ($options->getCmd()) {
                    case 'start-server':
                        echo "\e[92mServer started \e[39m";
                        $host = isset($options->getArgs()[0]) ? $options->getArgs()[0] : 'localhost';
                        $port = isset($options->getArgs()[1]) ? $options->getArgs()[1] : '8000';
                        shell_exec("php -S {$host}:{$port} -t public_html");
                        break;

                    case 'make':
                        switch ($options->getArgs()[0]) {
                            case 'controller':
                                Controller::boot($options->getArgs()[1]);
                                break;
                            case 'model':
                                Model::boot($options->getArgs()[1]);
                                break;
                        }
                        break;

                    default:
                        $this->error('No known command was called, we show the default help instead:');
                        echo $options->help();
                        exit;
                }
    }

    public static function start()
    {
        static::$object = new static();
        static::$object->run();
    }
}
