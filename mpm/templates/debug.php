<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>'); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <main>
      <?php if($no_reverse_match==true){
        echo "<h1>No Reverse Match </h1>";
        echo $data;
       }
      ?>
    </main>
  </body>
</html>
