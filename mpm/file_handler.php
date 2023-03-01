<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>');

function upload_file_handler($files,$mimetypes=array()){
    //global UPLOAD_PATH;
    define('UPLOAD_KEY',rand(100,999)."".time());
    $response = array();
    /** This Code block Changes the valuea thE FILES Keys in array if only one file is to  uploaded **/
    if(!is_array($files['name'])) {
      $file_array = array();
      foreach($files as $key=>$value) {
        $file_array[$key] = array($value);
      }
      $files = $file_array;
    }
    /** Images Error Checking **/
  $errors = array();
  for($i = 0; $i<count($files["name"]);$i++){
    $targetfile = basename($files["name"][$i]);
    $fileType = strtolower(pathinfo(
    $targetfile,PATHINFO_EXTENSION));
    if(count($mimetypes)>0 && !in_array($fileType,$mimetypes)){
      array_push($errors,".$fileType files are not allowed ($targetfile)");
    }
  }
      
  if(count($errors)!=0){
    $response['error_list'] = $errors;
    return  $response;
  } 
  /** Images Error Checking END **/
    
/* Upload Files */
  $target_dir = UPLOAD_PATH;//Target Directory to store files 
  $filesarray = array();
  for($i = 0; $i<count($files["name"]);$i++){
    $targetFile = $target_dir .UPLOAD_KEY . basename($files["name"][$i]);
    if(file_exists($targetFile)) {
      $targetFile = $target_dir .UPLOAD_KEY."".mt_rand(10000,99999).basename($files["name"][$i]);
    }
     if(move_uploaded_file($files["tmp_name"][$i],$targetFile)){
       array_push($filesarray,basename($targetFile,'.$fileType'));
     } else {
       array_push($errors,"Error : Couldn't Upload ".basename($files["name"][$i]));
     }
  }//for-loop upload file one by one;
  
  $response['error_list'] = $errors;
  $response['files_json'] = json_encode($filesarray);
 return $response;
}//upload_file_handler