<?php
if(!defined('SECURE') && php_sapi_name()!='cli') exit('<h1>Access Denied</h1>');
require_once 'mpm/utils.php';
//if(php_sapi_name()!='cli') require_once 'config/settings.php';

$database_settings = DATABASE;

function db_connect($database=true){
  global $database_settings;
  $username = $database_settings['username'];
  $password = $database_settings['password'];
  $host     = $database_settings['host'];
  $port     = $database_settings['port'];
  $dbname   = $database_settings['database'];
  if($database==true) 
    $conn  = mysqli_connect("$host:$port",$username,$password,$dbname);
  else $conn  = mysqli_connect("$host:$port",$username,$password);
  if(!$conn) {
    echo "<h1>Database Could not sync </h1>";
    echo mysqli_error($conn);
  }
  return $conn;
}

function db_insert($table,array $data) {
  $conn = db_connect();
  $keys = join(',',array_keys($data));
  $values = array_map("quote",array_values($data));
  $values = join(',',array_values($values));
  $sql = "INSERT INTO $table ($keys) values($values)";
  if(!mysqli_query($conn,$sql)){
    echo mysqli_error($conn);
  };
  $insertId =  mysqli_insert_id($conn);
  mysqli_close($conn);
  return $insertId;
}

function db_read($table,$data=array(),array $filter=array(),$filterOperator='AND',$order_array=array(),$returnType=MYSQLI_ASSOC) {
  $conn = db_connect();
  /** Set Restrictions or Filers **/
  $restrictions = ' ';//Where Rules
  $operation = ' ';//Filter operation
  foreach ($filter as $key=>$value){
    $restrictions .= $operation." $key = '$value' ";
    $operation = $filterOperator;
  }
  
  /*** Data to get **/
  $fields = ' ';
  $seperation = ' ';
  foreach ($data as $key=>$value){
    $fields .= $seperation." $value ";
    $seperation = ' , ';
  }
 
  /** Order Output **/
  $order_by_string = ' ';
  $order_by_seperator = ' ';
  foreach ($order_array as $key=>$value){
    $order_by_string .= $order_by_seperator." $key $value ";
    $order_by_seperator = ',';
  }
  
  $where = ($filter!=null && count($filter)>0)?"WHERE":" ";
  $order_by = ($order_array!=null && count($order_array)>0)?"ORDER BY":" ";
  $dataFields = ($data!=null && count($data)>0)?$fields:" * ";
  $sql = "SELECT $dataFields FROM $table $where $restrictions $order_by $order_by_string";
  $result = mysqli_query($conn,$sql);
  if(!$result){
    return false;
  }
  $data =  mysqli_fetch_all($result,$returnType);
  mysqli_close($conn);
  return $data;
}


function db_update($table,array $data,array $filter = array(),$filterOperator = 'AND'){
  $conn = db_connect();
  $modifications = '';//update Data String
  $seperation = ' ';//Comma 
  $restrictions = ' ';//Where Rules
  $operation = ' ';//Filter operation
  foreach ($data as $key=>$value){
    $modifications .= $seperation."$key = '$value' ";
    $seperation = ',';
  }
  foreach ($filter as $key=>$value){
    $restrictions .= $operation." $key = '$value' ";
    $operation = $filterOperator;
  }
  $where = ($filter!=null && count($filter)>0)?"WHERE":" ";
  $sql = "UPDATE $table SET $modifications $where $restrictions";
  $response = mysqli_query($conn,$sql);
  mysqli_close($conn);
  return $response;
}


function db_delete($table,array $filter=array(),$operator='AND') {
  $conn = db_connect();
  $law = '';
  $operation = '';
  foreach ($filter as $key=>$value){
    $law .= $operation." $key = '$value' ";
    $operation = $operator;
  }
  $where = ($filter!=null && count($filter)>0)?"WHERE":" ";
  $sql = "DELETE FROM $table $where $law";
  $response =  mysqli_query($conn,$sql);
  mysqli_close($conn);
  return $response;
}

function db_fetch_sql($sql){
  $conn = db_connect();
  $result = mysqli_query($conn,$sql);
  $data =  mysqli_fetch_all($result,MYSQLI_ASSOC);
  mysqli_close($conn);
  return $data;
}

function db_sql($sql){
  $conn = db_connect();
  $result = mysqli_query($conn,$sql);
  mysqli_close($conn);
  return $result;
}



function db_column_exists($table,$data){
 $row =  db_read($table,filter:$data);
  if(count($row)>0) {
    return true;
  } else {
    return false;
  }
}

function table_exists($db,$table) {
  $conn = db_connect(database:false);
  $result = mysqli_query($conn,"SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='$db' AND TABLE_NAME='$table'");
  $res =  mysqli_num_rows($result)>0?true:false;
  mysqli_close($conn);
  return $res;
}