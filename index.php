<?php
/**
 * This is Index file
 *  DON'T EDIT THIS 
**/
define("SECURE",true);
require_once 'config/autoload.php';

$url = $_SERVER['REQUEST_URI'];

Mpm\Core\Router::process($url,$urlpatterns);
