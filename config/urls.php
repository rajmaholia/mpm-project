<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 
require_once('mpm/auth/urls.php');

/*patterns
array(
    'path'=>"/blog_detail/(?P<id>\d+)/",
    'view'=>'blog/blog_detail.php',
    'name'=>'blog_detail'
  ),*/

$urlpatterns =  [
  ...$urlpatterns,
   array(
    'path'=>'',
    'view'=>'home',
    'name'=>'home',
    ),
];

