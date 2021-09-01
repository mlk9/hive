<?php

//======================================================================
// Launch this App
//======================================================================

namespace Hive;

use Hive\App;

/**
 * you can add route like : App::addRoutes('user'); in dir 'app/routes/user.php'
 */
App::addRoutes('web');
App::start();
