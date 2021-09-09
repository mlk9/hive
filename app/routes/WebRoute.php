<?php
namespace App\Routes;

use App\Controllers\AppController;
use Hive\Route\Route;
use Hive\Route\RouteInterface;

/*
* This is web route
* you can add route like get,any,post
* example : Route::get('/user/{user_id}', UserController::class, 'show');
*/
class WebRoute implements RouteInterface
{
    public function register()
    {
        Route::get('/', AppController::class, 'hello_world');
        Route::get('/language/{language}', AppController::class, 'lang');
    }
}

