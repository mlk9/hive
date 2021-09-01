<?php

namespace Hive\Launcher;

class Controller
{
    protected static $object;
    public static function __callStatic($name, $arguments)
    {
        if (!static::$object) {
            static::$object = new static();
        }

        return static::$object;
    }

    public static function boot($name)
    {
        $fileName = basename($name);
        $mainPath = str_replace('/', '\\', dirname('Controllers/'.$name.'.php'));
        $path = __DIR__.'/../../app/controllers/'.$name.'.php';
        $source = "<?php\n\nnamespace App\\".$mainPath.";\n\nuse Hive\View;\n\nclass {$fileName}\n{\n   public function hello_world()\n  {\n        return View::render('hello_world.html');\n  }\n}\n";
        if (file_exists($path)) {
            echo "\e[41m{$fileName} exist!\e[49m";
            return null;
        }
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
            return null;
        }
        $controllerFile = fopen($path, "w") or die("Unable to open file!");
        fwrite($controllerFile, $source);
        fclose($controllerFile);
        echo "\e[42m{$fileName} created.\e[49m";
    }
}
