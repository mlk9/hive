<?php

use App\Controllers\AppController;
use Hive\Route;

/*
* This is web route
* you can add route like get,any,post
* example : Route::get('/user/{user_id}', UserController::class, 'show');
*/

Route::get('/', AppController::class, 'hello_world');

Route::get('/language/{language}', AppController::class, 'lang');