<?php 
/***** Settings "********/
define("PROJECT_NAME","MPM_PROJECT");
define("UPLOAD_PATH",'uploads/');
/* Database  Configurations */
define('DATABASE',[
  'username' => "root",
  'password' => "root",
  'host'     => "0.0.0.0:3306",
  'database' => "Testdb",//databasse name;
  'load_files'=>array('mpm/auth/User.sql'),
]);

define("LOGIN_REDIRECT_URL","home");
define("LOGOUT_REDIRECT_URL","home");
define("AUTH_USER_MODEL","User");