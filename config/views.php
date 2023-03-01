<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); 

function home($server){
  return render($server,'templates/home.php');
}