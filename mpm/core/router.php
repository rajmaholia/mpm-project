<?php
namespace Mpm\Core;

if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 

class Router {
  
  public static function process($url,$urlpatterns){
    if(substr(trim($url),-1)!='/') $url.='/';

    $paths = array_column($urlpatterns,0);
    $pattern_matching_process_string = "";
    for($i = 0;$i<count($urlpatterns);$i++) {
      //handler key=>$value pairs alternation in path
      $current_url = $urlpatterns[$i][0];
      
      if(empty(trim($current_url)))
        $current_url = "/";
      $j = $i+1;
      $pattern_matching_process_string .= ("$j. ".$current_url."<br>");
      $pattern = "@^".$current_url."$@";
      
      if(preg_match($pattern, $url,$matches)){
        $groups = array_filter($matches, "is_string", ARRAY_FILTER_USE_KEY);
        $url_matched = $urlpatterns[$i];
        $view_name = $urlpatterns[$i][1];
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