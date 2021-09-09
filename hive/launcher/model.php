<?php

namespace Hive\Launcher;

use Hive\Types\SingletonStaticClass;

class Model extends SingletonStaticClass
{
    

    public static function boot($name)
    {
        $fileName = basename($name);
        $mainPath = str_replace('/', '\\', dirname('Models/'.$name.'.php'));
        $path = __DIR__.'/../../app/models/'.$name.'.php';
        $source = "<?php\n\nnamespace App\\".$mainPath.";\n\nuse Hive\Model;\n\nclass {$fileName} extends Model\n{\n\n}\n";
        if (file_exists($path)) {
            echo "\e[41m{$fileName} model exist!\e[49m";
            return null;
        }
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
            return null;
        }
        $controllerFile = fopen($path, "w") or die("Unable to open file!");
        fwrite($controllerFile, $source);
        fclose($controllerFile);
        echo "\e[42m{$fileName} model created.\e[49m";
    }
}
