<?php
namespace Mpm\Core;
if(php_sapi_name()!='cli' && !defined('SECURE')) exit('<h1>Access Denied</h1>'); 

define('AUTOLOAD_TEMPLATES',[
  'DIRS'=>array("mpm/Exceptions"),
]);


