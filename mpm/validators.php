<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 

function test_input($data,$empty=false){
  if(empty($data) && $empty==true) {
    return true;
  }
  elseif(!empty($data)) {
  $data = trim($data);
  $data = htmlspecialchars($data);
  $data = stripslashes($data);
  return $data;
} else {
  return false;
}
}

function checklength($data,$length,$fixed=false) {
  if($fixed === true && strlen($data)!=$length) {
    return false;
  }else {
    if(strlen($data) <= $length) {
      return true;
    } elseif(strlen($data)>$length) {
      return false;
    }
  }
}

function checkemail($email){
  if(filter_var($email,FILTER_VALIDATE_EMAIL)){
    return true;
  }else {
   return false;
  }
}

function checkequal($data1,$data2){
  return ($data1===$data2)?true:false;
}

function checkregex($data,$regex){
  
}

function cleaned_data($data){
  $cleaned_data = array();
  foreach($data as $key=>$value){
    $cleaned_data[$key] = test_input($value);
  }
  return $cleaned_data;
}

?>