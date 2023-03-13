<?php
/** This is Index file
*  DON'T EDIT THIS 
**/
define("SECURE",true);
require_once 'config/settings.php';
require_once 'mpm/sessions.php';
require_once 'mpm/database_handler.php';
require_once 'config/urls.php';
require_once 'mpm/functions.php';
require_once 'mpm/utils.php';
require_once 'mpm/validators.php';
require_once 'mpm/core/router.php';
foreach(APPS as $app) {require_once(glob("$app/views.php")[0]);};

$url = $_SERVER['REQUEST_URI'];

Mpm\Core\Router::process($url,$urlpatterns);
