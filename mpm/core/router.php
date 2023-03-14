<?php
namespace Mpm\Core;

if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 

class Router {
  
  public static function process($url,$urlpatterns){
    if(substr(trim($url),-1)!='/') $url.='/';

    $paths = array_column($urlpatterns,'path');
    $pattern_matching_process_string = "";
    for($i = 0;$i<count($urlpatterns);$i++) {
      if(empty(trim($urlpatterns[$i]['path'])))
        $urlpatterns[$i]['path'] = "/";
      $j = $i+1;
      $pattern_matching_process_string .= ("$j. ".$urlpatterns[$i]['path']."<br>");
      $pattern = "@^".$urlpatterns[$i]['path']."$@";
      
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
      if(DEBUG===true)
        echo(render($_SERVER,"mpm/templates/debug.php", array("no_reverse_match"=>true,'url'=>$url,'data'=>$pattern_matching_process_string))); 
      else redirect(reverse('404'));
    }
  }
}