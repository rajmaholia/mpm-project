<?php
if(!defined('SECURE')) exit('<h1>Access Denied</h1>');
<<<<<<< HEAD

  require_once 'config/settings.php';
  require_once 'mpm/core/global_settings.php';
  require_once 'mpm/sessions.php';
  require_once 'mpm/database_handler.php';
  require_once 'config/urls.php';
  require_once 'mpm/functions.php';
  require_once 'mpm/utils.php';
  require_once 'mpm/validators.php';
  require_once 'mpm/core/router.php';
  foreach(APPS as $app) {require_once(glob("$app/views.php")[0]);};
}
=======
require_once 'config/settings.php';
require_once 'mpm/core/global_settings.php';
require_once 'mpm/sessions.php';
require_once 'mpm/database_handler.php';
require_once 'config/urls.php';
require_once 'mpm/functions.php';
require_once 'mpm/utils.php';
require_once 'mpm/validators.php';
require_once 'mpm/core/router.php';
require_once 'mpm/core/request.php';
require_once 'mpm/static/static.php';
foreach(APPS as $app) {require_once(glob("$app/views.php")[0]);};
>>>>>>> origin/master
