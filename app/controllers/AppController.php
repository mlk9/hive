<?php

namespace App\Controllers;

use Hive\Request;
use Hive\View;

class AppController
{
    /*
    * example controller
    * you can resolve ($request,$argument1,$argument2,$argument3,...)
    */
    public function hello_world($request)
    {
        return View::render('hello-world.html');
    }
}
