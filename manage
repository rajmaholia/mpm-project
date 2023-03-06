<?php
if(php_sapi_name()!='cli' && isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']=="/manage") {
  exit("<h1>Access Denied </h1> ");
}

require_once 'mpm/core/command_line.php';
execute_from_command_line($argv);
?>