<?php
namespace mpm\auth\urls;
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 

$urlpatterns = [
 array(
   'path'=>'/auth/login/',
   'view'=>'login',
   'name'=>'login'
   ),
 array(
   'path'=>'/auth/signup/',
   'view'=>'signup',
   'name'=>'signup'
   ),
  array(
   'path'=>'/auth/logout/',
   'view'=>'logout',
   'name'=>'logout'
   ),
  array(
   'path'=>'/404/',
   'view'=>'page_not_found',
   'name'=>'404'
   ),
  array(
   'path'=>'/permission-denied/',
   'view'=>'permission_denied',
   'name'=>'permission_denied'
   ),
];