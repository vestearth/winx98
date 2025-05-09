<?php
$_WLOVES['no_check_permission'] = 1;

if (isset($_GET['page_name']) && isset($_GET['page_name_sub']) && isset($_GET['c'])) {
  require_once '.framework/import.php';
} else {
  if (file_exists('../system/installation.php')) {
    require_once '../system/installation.php';
    require_once '.framework/import.php';
  
    if (!Installation::hasConfigFile($root_path)) {
      Aww::redirect('installation.php');
    }
  } else {
    // require_once '../system/installation.php';
    require_once '.framework/import.php';
  }
}

$installation_result = isset($_GET['result']) ? $_GET['result'] : '';

if (isset($_GET['page_name']) && isset($_GET['page_name_sub']) && isset($_GET['c'])) {
  F_Permission::redirectToPageInsidePermission($_GET['page_name'], $_GET['page_name_sub'], $_GET['c']);
}

if ($installation_result == 'ready') {
  Aww::notification('ตั้งค่าเสร็จเเล้ว', 'success');
  Aww::redirect('module_main/login/index.php?success');
}

if (F_User::isLogin()) {
  if (F_User::isDev()) {
    Aww::redirect('module_main/core/log.php');
  }

  F_Permission::redirectToFirstModuleAvailable();
}

Aww::redirect('module_main/login/index.php?error=permission_denied');
