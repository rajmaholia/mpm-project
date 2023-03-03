<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>');
require_once 'config/admin.php';
require_once 'mpm/functions.php';

foreach(APPS as $app) {
  if(count(glob($app."/forms.php"))>0) {
    require_once($app."/forms.php");
  };
}

function admin_dashboard($server){
  global $user;
  if($user->is_staff!=1)
  redirect(reverse('admin_login'));
  return render($server,'mpm/admin/templates/dashboard.php', array('groups'=>MODEL_GROUPS));
}


function admin_login($server){
  global $user;
  $form = new UserLoginForm();
  if($server["REQUEST_METHOD"]=="POST"){
    $form->fill_form($_POST);
    if(count($form->get_errors())==0){
      $form_data = cleaned_data($_POST);
      $staff = db_read('User',filter:array('is_staff'=>1));
      $staff_users = array_column($staff,"username");
      if(in_array($form_data["username"],$staff_users)) {
        $row = db_read("User",filter: array("username"=>$form_data["username"]))[0];
        if(password_verify($form_data["password"],$row["password"])){
          $_SESSION['user'] = array();
          foreach($row as $key=>$value) {
           $_SESSION['user'][$key] = $value;
          }//set user data in session
        redirect(reverse('admin_dashboard'));
        } else {
          $form->error_list["password"]=array("Password is not correct");
        }//check password verify 
      } else {
        $form->error_list["username"]=array("Username is not correct");
      }//check user exist in staff
    }//check errors
  }//if post
  return render($server,'mpm/admin/templates/admin_login.php', array('form'=>$form,'user'=>$user));
}//login()

function object_list($server, $arguments){
  global $user;
  if($user->is_staff!=1)
  redirect(reverse('admin_login'));
  
  $table = $arguments['table'];
  $table_data = MODEL_METADATA[$table];
  if(in_array($table,SITE_MODELS)) return render($server,'mpm/admin/templates/object_list.php',array('table'=>$table,'table_data'=>$table_data,'user'=>$user));
  else return render($server,'templates/404.php');
}

function object_detail($server){
  global $user;
  if($user->is_staff!=1)
  redirect(reverse('admin_login'));
  return render($server,'mpm/admin/templates/object_detail.php',array('user'=>$user));
}


function create_user($server){
  global $user;
  if($user->is_staff!=1)
  redirect(reverse('admin_login'));
  $form = new UserCreationForm();
  if($server['REQUEST_METHOD'] == "POST") {
    $form->fill_form($_POST);
  if(count($form->get_errors())==0){
    $passwordEqual = checkequal(test_input($_POST['password']),test_input($_POST['confirm_password']));
    if($passwordEqual==false){
     $form->error_list['confirm_password']=array("Both passwords Must be same");
    } else {
      $data = cleaned_data($_POST);
      $fields = UserCreationForm::$fields;
      $data_array = array();
      foreach($fields as $key=>$value) {
        $data_array[$value] = $data[$value];
      }
      $data_array['password'] = password_hash($data_array['password'], PASSWORD_DEFAULT);
     $res =  db_column_exists('User',data:array('username'=>$data_array['username']))?$form->error_list['username']=array("Username already exists"):db_insert('User',data:$data_array);
     if(is_int($res)){
      redirect(reverse('object_list', array("User")));
     }
    }
  }
  }//If POST
  return render($server,'mpm/admin/templates/object_create.php', array('form'=>$form,'table'=>"User",'user'=>$user));
}


function object_create($server,$arguments){
  global $user;
  if($user->is_staff!=1)
  redirect(reverse('admin_login'));
  $table = $arguments['table'];
  //$table_data = MODEL_METADATA[$table];
  if(!in_array($table,SITE_MODELS))  return render($server,'templates/404.php');
  if($table == "User") $formClass = "UserCreationForm";
  else $formClass=$table."Form";
  $form = new $formClass();
  if($server['REQUEST_METHOD']=="POST") {
    $form->fill_form($_POST);
    if(count($form->get_errors())==0){
      $data = cleaned_data($_POST);
      //$data['author'] = $user->id;
      db_insert($table,data:$data);
      redirect(reverse('object_list', arguments:array($table)));
    }
  }
  return render($server,'mpm/admin/templates/object_create.php', array('table'=>$table,'form'=>$form,'user'=>$user));
}

function object_edit($server,$arguments){
  global $user;
  if($user->is_staff!=1)
  redirect(reverse('admin_login'));
  $table = $arguments['table'];
  //$table_data = MODEL_METADATA[$table];
  if(!in_array($table,SITE_MODELS))  return render($server,'templates/404.php');
  if($table == "User") $formClass = $table."ChangeForm";
  else $formClass=$table."Form";
  $form = new $formClass();
  $id = $arguments['id'];
  $data = db_read($table,filter:array('id'=>$id))[0];
  $form->fill_form($data);
  if($server['REQUEST_METHOD']=="POST") {
    $form->fill_form($_POST);
    if(count($form->get_errors())==0){
      $data = cleaned_data($_POST);
      //$data['author'] = $user->id;
      db_update($table,data:$data,filter: array('id'=>$id));
      redirect(reverse('object_list', arguments:array($table)));
    }
  }
  return render($server,'mpm/admin/templates/object_edit.php', array('table'=>$table,'id'=>$id,'form'=>$form,'user'=>$user));
}

function object_delete($server){
  global $user;
  if($user->is_staff!=1)
  redirect(reverse('admin_login'));
  return render($server,'mpm/admin/templates/object_delete.php',array('user'=>$user));
}
