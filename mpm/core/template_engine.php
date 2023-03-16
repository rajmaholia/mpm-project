<?php
namespace Mpm\Core;

if(!defined('SECURE')) exit('<h1>Access Denied</h1>');


class TemplateEngine {
  public static function resolve($template){
    $dirs = TEMPLATES["DIRS"];
    $dirs = array_merge($dirs,APPS);
    foreach($dirs as $dir){
      $a =  glob($dir."/templates/$template");
      if(count($a)>0) return $a[0];
    }
  }
}