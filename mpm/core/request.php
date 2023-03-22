<?php
namespace Mpm\Core;
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 


class Request {
  public static function captureUri(){
    return $_SERVER["REQUEST_URI"];
  }
}