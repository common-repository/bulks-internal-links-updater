
<?php
  ob_start();

  $page_title = "NEW UPDATES";
  require_once MBULET_ILU_PLUGIN_DIR . "admin/views/loader.php";
  require_once MBULET_ILU_PLUGIN_DIR . "admin/views/page-header.php";
  require_once MBULET_ILU_PLUGIN_DIR . "admin/views/menu_new-updates.php";
  
  ob_get_contents();

?>