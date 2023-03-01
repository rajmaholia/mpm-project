<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Flashkart</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Expires" content="0" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
</head>
<body>
<div class="container">
 <div class="form-container ">
   <h1>Register</h1>
     <form action="" class="fk-form" method="post">
      <?php echo $form->render_form();?>
    <button type="submit" class="fk-btn fk-btn-theme">Register</button>
    
     </form>
     <p>Already have an account <a href="<?php echo reverse('login');?>">Login</a></p>
 </div>
  </div>
</body>
</html>