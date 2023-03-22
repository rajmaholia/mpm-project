<?php
namespace Mpm\Session;

if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 

session_start();
$base_url = isset($_SERVER['HTTPS'])&& $_SERVER['HTTPS']==='on' ? "https":"http"."://".$_SERVER['HTTP_HOST'].'/';
define("BASE_URL",$base_url);

function addTransaction(){
  $url = getCurrentUrl();
  if(getVar('transactions')==null) {
    $transactions = array();
    array_push($transactions,$url);
  }else {
    $transactions = getVar('transactions');
    $lastUrl = $transactions[array_key_last($transactions)];
    if($lastUrl!=$url) {
      array_push($transactions,$url);
    }
  }
  setVar('transactions',$transactions);
}

function getPreviousUrl() {
  if(getVar('transactions')!=null && count(getVar('transactions'))>1){
    $transactionsArr = getVar('transactions');
    $lastKey = array_key_last($transactionsArr); 
    array_splice($transactionsArr,$lastKey,1);
    $purl =  array_pop($transactionsArr);
    setVar('transactions',$transactionsArr);
  } else {
    $purl = BASE_URL;
  }
  return $purl;
}

function setUser($usr){
  $_SESSION['user'] = $usr;
}
function setUserId($usrID){
  $_SESSION['userID'] = $usrID;
}

function getUser(){
  if(isset($_SESSION['user'])) {
    return $_SESSION['user'];
  } else {
    return null;
  }
}
function getUserId(){
  if(isset($_SESSION['userID'])) {
    return $_SESSION['userID'];
  } else {
    return null;
  }
}

function setVar($var,$value){
  $_SESSION[$var] = $value;
}

function getVar($var){
  if(isset($_SESSION[$var])) {
   return  $_SESSION[$var];
   } else {
     return null;
   }
}

function getVarArray($arr,$key){
  $arr = isset($_SESSION[$arr])?$_SESSION[$arr]:null;
  return ($arr==null)?null:(isset($arr[$key])?$arr[$key]:null);
}

function unsetVar($var) {
  unset($_SESSION[$var]);
}

function getCurrentUrl(){
  return BASE_URL.$_SERVER['REQUEST_URI'];
}

class User {
  public $id,$username,$password,$email,$is_staff,$joined_on,$mobile_number,$fullname;
  public function  __construct(){
    $this->id = getVarArray('user','id');
    $this->username = getVarArray('user','username');
    $this->password = getVarArray('user','password');
    $this->is_staff = getVarArray('user','is_staff');
    $this->joined_on = getVarArray('user','joined_on');
    $this->mobile_number = getVarArray('user','mobile_number');
    $this->fullname = getVarArray('user','fullname');
 }
}
$user = new User();
