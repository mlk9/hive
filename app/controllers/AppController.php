<?php

namespace App\Controllers;

use Hive\Language\Language;
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

    public function lang($request, $language)
    {
        switch ($language) {
            case 'en':
                Language::select('English');
                break;
            case 'fa':
                Language::select('Persian');
                break;
        }

        return back();
    }
}
