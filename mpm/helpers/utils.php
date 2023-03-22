<?php
if(!defined('SECURE') && php_sapi_name()!="cli") exit('<h1>Access Denied</h1>'); 

function truncate($string, $limit, $pad = "...")
{
  if(strlen($string) <= $limit){
    return $string;
  } else {
      $string = substr($string,0 ,$limit) . $pad;
    return $string;
  }
}

function quote($d){
  return "'".$d."'";
}