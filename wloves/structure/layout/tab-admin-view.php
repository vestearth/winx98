<?php
if (isset($_GET['c'])) {
  // $has_permission = Module::isHasAdminPermission($_GET['c']);
  $has_permission = false;
  if ($has_permission) {
    if (isset($_POST['owner_id'])) {
      $user = User::getByID('*', $_POST['owner_id']);
      Aww::cookie('admin_owner_id', $_POST['owner_id']);
      Aww::cookie('admin_owner_name', $user['name'] . ' ' . $user['surname']);
      Aww::notification('เลือกมุมมองสำเร็จ', 'success');
      $menu          = array_key_exists(ucfirst($_PAGE['permission'][0]), F_Config::$menu_list) ? F_Config::$menu_list[ucfirst($_PAGE['permission'][0])] : '';
      $page_name_sub = '';
      foreach ($menu['menu_items'] as $checkfirst_page) {
        if ((!$page_name_sub && $checkfirst_page['page_name'] && isset(F_Permission::$has_permissions[$_GET['c'] . '_' . $checkfirst_page['page_name']]))) {
          $page_name_sub = $checkfirst_page['page_name'];
        }
      }
      Aww::redirect('../../index.php?c=' . $_GET['c'] . '&page_name=' . $_PAGE['permission'][0] . '&page_name_sub=' . (($menu['menu_items']) ? $page_name_sub : '') . '');
      unset($menu);
    }
  } else {
    Aww::removeCookie('admin_owner_id');
    Aww::removeCookie('admin_owner_name');
  }

  function adminView($link)
  {
    $html       = '';
    $user_admin = User::getCurrent();
    $name_admin = ($user_admin) ? $user_admin['name'] . ' ' . $user_admin['surname'] : '';
    $name       = (Aww::cookie('admin_owner_name')) ? Aww::cookie('admin_owner_name') : $name_admin;

    $has_permission = Module::isHasAdminPermission($_GET['c']);
    if ($user_admin) {
      if ($has_permission) {
        $html .= '<a href="' . $link . '" class="tab-admin-view">';
        $html .= '<span>You are now viewing the information in the admin view. <span class="text-name">' . $name . '</span> “Press this bar to return to the Select view page”</span>';
        $html .= '</a>';
      }
    }
    echo $html;
  }
}
