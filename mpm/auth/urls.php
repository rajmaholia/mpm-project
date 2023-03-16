<?php
namespace mpm\auth\urls;
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 

$urlpatterns = [
  path(
    url:'/auth/login/',
    view:'login',
    name:'login'
     ),
  path(
    url:'/auth/signup/',
    view:'signup',
    name:'signup'
   ),
  path(
    url:'/auth/logout/',
    view:'logout',
    name:'logout'
   ),
  path(
    url:'/auth/password-change/',
    view:'password_change',
    name:'password_change'
   ),
  path(
    url:'/404/',
    view:'page_not_found',
    name:'404'
   ),
  path(
    url:'/permission-denied/',
    view:'permission_denied',
    name:'permission_denied'
   ),
];