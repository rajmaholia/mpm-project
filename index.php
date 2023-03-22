<?php
define("SECURE",true);
/**
 * This is Index file
 *  DON'T EDIT THIS 
**/
<<<<<<< HEAD
define("SECURE",true);
require_once 'config/autoload.php';
=======
require_once 'config/autoload.php';
use Mpm\Core\Request;
use Mpm\Core\Router;
>>>>>>> origin/master

Router::process(Request::captureUri(),$urlpatterns);
