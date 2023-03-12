<?php
/** This is Index file
*  DON'T EDIT THIS 
**/
define("SECURE",true);
require_once 'config/settings.php';
require_once 'mpm/sessions.php';
require_once 'mpm/database_handler.php';
require_once 'config/urls.php';
require_once 'mpm/functions.php';
require_once 'mpm/utils.php';
require_once 'mpm/validators.php';
foreach(APPS as $app) {require_once(glob("$app/views.php")[0]);};

$url = $_SERVER['REQUEST_URI'];

if(substr(trim($url),-1)!='/') $url.='/';
$paths = array_column($urlpatterns,'path');
for($i = 0;$i<count($urlpatterns);$i++) {
 // echo $url. '   :   '.$urlpatterns[$i]['path']."<br>";
  $pattern = "@^".$urlpatterns[$i]['path']."@";
  if(preg_match($pattern, $url,$matches)){
    $groups = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
     $view_name = $urlpatterns[$i]['view'];
     break;
  }
}

if(isset($view_name)){
  if(count($groups)>0){
    $view = $view_name;
    echo($view($_SERVER,$groups));
  } else{
    $view = $view_name;
    echo($view($_SERVER));
  }
} else {
  redirect(reverse('404'));
}