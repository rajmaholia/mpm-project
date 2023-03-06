<?php
if(php_sapi_name()!='cli' && isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']=="/manage") {
  exit("<h1>Access Denied </h1> ");
}
require_once 'config/settings.php';
require_once 'mpm/core/sql_reader.php';
function execute_from_command_line($arguments)
{
switch($arguments[1]) {
  case 'serve':
    exec('php -S localhost:8080');
    break;
    
  case 'migrate':
   $db = DATABASE;
    list($username,$password,$server,$dbname) = array($db['username'],$db['password'],$db['host'],$db['database']);
    $conn = mysqli_connect($server,$username,$password);
    if(!$conn){
      exit("Couldn't connect to database server");
    }
    if(empty($dbname)) exit("[ERROR] Database name not set in config/settings.php\n");
    
    if(!mysqli_query($conn,"CREATE DATABASE IF NOT EXISTS $dbname"))
    {
      exit("Can't Create Database ".$dbname);
    } else {
      mysqli_query($conn,"Use ".$dbname);
      foreach($db['load_files'] as $file){
        read_from_file($conn,$file);//foreach reading file line be line
      }//for each to get files
    }//else of create database
    mysqli_close($conn);
    break;
  
  case 'createadmin':
    if(!isset($arguments[2]) || !isset($arguments[3]) || !isset($arguments[4])){
        exit("\nUsage : php manage createadmin <username> <password> <email>\n\n");
    }
    $admin_username = $arguments[2];
    $admin_password = $arguments[3];
    $admin_password = password_hash($admin_password, PASSWORD_DEFAULT);
    $admin_email = $arguments[4];
    $db = DATABASE;
    list($username,$password,$server,$dbname) = array($db['username'],$db['password'],$db['host'],$db['database']);
    $conn = mysqli_connect($server,$username,$password);
   
    if(!$conn){
      exit("Couldn't connect to database");
    }
    if(mysqli_num_rows(mysqli_query($conn," select schema_name from information_schema.schemata where schema_name = '$dbname'"))>0) {
      mysqli_query($conn,"Use ".$dbname);
      echo (mysqli_query($conn,"insert into User (username,password,email,is_staff) values('$admin_username','$admin_password','$admin_email',b'1')"))?"\nSuperUser Created \n":"\nCould not create Super User\n";
      exit();
    } else {
      echo "\nMigration Not Applied \n";
      echo "Please Run `php manage migrate` Command\n\n";
    }
    break;
  
  case 'makemigrations':
    echo "\n";
    $app_name = $arguments[2];
    if(!isset($app_name)) exit("Usage :  `php manage makemigrations <app>\n");
    $db = DATABASE;
    try{
      $conn = mysqli_connect($db['host'],$db['username'],$db['password'],$db['database']);
    }catch(Exception $e) {
      exit("Database not configured Properly\n");
    }
    $migrations = glob($app_name."/migrations/*.php");
    if(count($migrations)==0) exit("migrations not available for '$app_name'\n\n");
    
    foreach($migrations as $file){
      require_once($file);
      $sql = trim($sql);
      echo "Running Migration for  ".$file." . . .\n";
      try {
        read_query($conn,$sql);
        echo("Success  : Migrations ".$file." Applied\n\n");
      } catch(Exception $e) {
        echo "Error : ".mysqli_error($conn)."\n\n";
      }//try catch
    }
    echo "\n";
  mysqli_close($conn);
  break;
  
  case 'createapp':
    echo "\n";
    $app_name = $arguments[2];
    if(!isset($app_name)) exit("Usage :  `php manage createapp <app>\n");
    try {
      mkdir("$app_name/");
      $file_data_common = "<?php \n if(!defined('SECURE')) exit('<h1>Access Denied</h1>');\n\n";
      mkdir("{$app_name}/migrations");
      $files = ["views.php","forms.php","urls.php","migrations/initial.php"];
      foreach($files as $file) {
        $extra=($file=="urls.php")?"\$urlpatterns = [\n\n ];":"";
        if($file=="migrations/initial.php") {
          $file_data_common = "<?php \n if(php_sapi_name()!='cli' && !defined('SECURE')) exit('<h1>Access Denied</h1>');\n\n";
          $extra = "\$sql = \" \n\n \";";
        }
        $file = fopen("$app_name/$file","w+");
        fwrite($file,$file_data_common.$extra);
        fclose($file);
      }
      
      echo "App `{$app_name}` Created Successfully \n";
    } catch(Exception $e) {
      echo $e->getMessage();
    }
    break;
    
  default:
    exit("Command not found : ".$arguments[1]."\n");
}//switch
}//function