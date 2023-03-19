<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 

function staticfile($staticfile){
  $dirs = STATICFILES["DIRS"];
    $dirs = array_merge($dirs,APPS);
    //AUTOLOAD_STATICFILES["DIRS"],
    $i = 0;
    foreach($dirs as $dir){
      $a =  glob($dir."/static/$staticfile");
      if(count($a)>0) return (substr($a[0],0,1)=="/"?$a[0]:"/".$a[0]);
      $i++;
    }
  return "";
}