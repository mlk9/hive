<?php

//======================================================================
// Launch this App
//======================================================================

namespace Hive;

use Hive\App;
use App\Routes\WebRoute;

/**
 * you can add route like : App::addRoutes('user'); in dir 'app/routes/user.php'
 */
App::addRoutes(WebRoute::class);
App::start();
