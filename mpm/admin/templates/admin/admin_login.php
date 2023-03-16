<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>');
 require_once 'mpm/admin/components/header_code.php'; ?>
<?php require_once 'mpm/admin/components/nav.php'; ?>
<div class="container">
  <form action="" method="post">
    <?php echo $form->render_form();?>
    <button class="btn btn-primary">Login</button>
  </form>
</div>
<?php require_once 'mpm/admin/components/footer_code.php'; ?>