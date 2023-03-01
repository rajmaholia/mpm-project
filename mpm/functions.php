<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 

function render($server,$filename, $vars = null) {
  if (is_array($vars) && !empty($vars)) {
    extract($vars);
  }
  ob_start();
  require($filename);
  return ob_get_clean();
}

function restrict(){
  if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
  header( 'HTTP/1.0 403 Forbidden', TRUE, 403 );
  die( header( '' ) );
  }
}

function redirect($path) {
  if(substr($path,0,1)=="/") {
    $path = substr($path,1);
  }
  header("Location:".BASE_URL.$path);
}

function http_redirect($url) {
  header("Location:".$url);
}

function reverse($name,$arguments=array()){
  //return absolute url of url_name;
  global $urlpatterns;
  $path = array_column($urlpatterns,'path','name')[$name];
  $arra = preg_split("@/@",$path,-1,PREG_SPLIT_NO_EMPTY);
  $pattern = "/[(].*?[)]/";
  $count=0;
  foreach($arra as $key=>&$value) {
    if(preg_match($pattern,$value)){
      $value = $arguments[$count];
      $count++;
    }
  }
  $url = implode('/',$arra);
  $url = substr(trim($path),0,1)=="/"?"/".$url:$url;
  $url = substr(trim($path),-1,1)=="/"?$url."/":$url;
  return $url;
}