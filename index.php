<?php
define("SECURE",true);
/**
 * This is Index file
 *  DON'T EDIT THIS 
**/
require_once 'config/autoload.php';
use Mpm\Core\Request;
use Mpm\Core\Router;

Router::process(Request::captureUri(),$urlpatterns);
