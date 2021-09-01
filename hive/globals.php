<?php

//just moment

use Hive\View;

function abort($code=403, $detail='')
{
    echo View::render('@hive/error.html', ['errorCode'=>$code,'errorDetail'=>$detail]);
    return null;
}

function env($key)
{
    return $_ENV[$key];
}

function session($key)
{
    return $_SESSION[$key];
}

function cookie($key)
{
    return $_COOKIE[$key];
}

function redirect($slug)
{
    return header('Location: '.$slug);
    die();
}

function public_dir($file=null)
{
    if (is_null($file)) {
        return '/';
    } else {
        return '/'.$file;
    }
}

function arrayFindString($needle, $array)
{
    foreach ($array as $item) {
        if (strpos(strtolower($item), strtolower($needle))>-1) {
            return $item;
        }
    }
    return false;
}

function response($code, $data=[])
{
    http_response_code($code);
    header('Content-Type: application/json');
    return json_encode($data);
}
