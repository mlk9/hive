<?php
/**
 * require to hive core
 */
require_once __DIR__.'/../vendor/autoload.php';
$hive_file = __DIR__.'/../hive/init.php';
if (file_exists($hive_file)) {
    require_once $hive_file;
} else {
    throw new \Exception('Hive core not found!');
}
