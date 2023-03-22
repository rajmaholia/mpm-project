<?php

namespace Mpm\Helpers;

class Autoload {
  private $files;
  public function __construct($files){
    $this->files = $files;
  }
  
  public function load(){
    foreach($files as $file) {
      require_once $file;
    }
  }
}