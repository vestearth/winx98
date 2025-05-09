<?php
$code = isset($_GET['c']) ? $_GET['c'] : '';

//ดึงไฟล์ config ของแต่ละ module ว่ามี page อะไรบ้าง
foreach ($modules as $function) {
  F_WLoves::setConfigMenuList($function['module'], '../../');
}
$file_menu_list = F_Config::$menu_list;
//check permission and create menu list array
$sidenav_menu = [];
foreach ($modules as $function) {
  // [20220609] ใช้ key แยกตามโมดูลที่เปิดจริงๆ ทำให้เปิดซ้ำได้
  $i_module_key = "{$function['module']}_{$function['code']}";
  $menu = array_key_exists($function['module'], $file_menu_list) ? $file_menu_list[$function['module']] : '';
  if (!$menu) {
    continue;
  }

  //module list
  if (!$active_menu['name'] && $_PAGE['permission'][0] == strtolower($function['module'])) {
    $active_menu = [
      'icon' => isset($menu['icon']) ? $menu['icon'] : '../../structure/image/sidenav/default_icon.svg',
      'name' => $function['name'],
    ];
  }
  if ($function['module'] != 'User') {
    $main_icon = isset($menu['icon']) ? $menu['icon'] : '../../structure/image/sidenav/default_icon.svg';
    $sidenav_menu[$i_module_key] = [
      'icon' => $main_icon,
      // 'is_hide_o' => (!$favorite && ($_PAGE['permission'][0] != strtolower($function['module'])) && ($function['code'] != $_GET['c'])) ? 1 : 0,
      'is_hide' => (!$favorite && ($function['code'] != $code)) ? 1 : 0,
      'name' => $function['name'],
      'code' => $function['code'],
      'count' => 0,
    ];
    //submenu
    foreach ($menu['menu_items'] as $menu_items) {
      $sidenav_menu[$i_module_key]['sub_menu'][$menu_items['page_name']] = [
        'name' => $menu_items['title'],
        'list' => [],
      ];
      //menu
      if (isset($menu_items['sub_menu']) && $menu_items['sub_menu']) {
        foreach ($menu_items['sub_menu'] as $sub_menu) {

          $condition = $sub_menu['url'] && ($sub_menu['page_name'] && isset($permissions[$function['code'] . '_' . $sub_menu['page_name']]));
          if ($condition) {
            $count_menu++;
            $page_url = '../../module/' . $menu['page_name'] . '/' . $sub_menu['url'] . '?c=' . $function['code'];
            $active = (($_PAGE['permission'][2] == $sub_menu['page_name'] && $function['code'] == $code && !$favorite) ? 'active' : '');
            $sidenav_menu[$i_module_key]['count']++;
            $sidenav_menu[$i_module_key]['sub_menu'][$menu_items['page_name']]['list'][] = [
              'key'  => $sub_menu['page_name'],
              'icon' => 'structure/image/etc/ellipse.svg',
              'name' => $sub_menu['title'],
              'url' => $page_url,
              'active' => $active,
            ];
          }
        } //end foreach submenu
      }
    } //end foreach menu_items
    $hidden_menu =  F_WLoves::rederMenuHiddenFixPermission($function['code']);
    if ($hidden_menu) {
      $sidenav_menu[$i_module_key]['sub_menu'][$hidden_menu['page_name']] = [
        'name' => $hidden_menu['title'],
        'list' => [],
      ];
      if (isset($hidden_menu['sub_menu']) && $hidden_menu['sub_menu']) {
        foreach ($hidden_menu['sub_menu'] as $sub_menu) {
          $hidden_permission = F_WLoves::$hidden_menu_permissions;
          $condition = $sub_menu['url'] && ($sub_menu['page_name'] && isset($hidden_permission[$function['code'] . '_' . $sub_menu['page_name']]));
          if ($condition) {
            $count_menu++;
            $page_url = '../../module/' . $menu['page_name'] . '/' . $sub_menu['url'] . '?c=' . $function['code'];
            $active = (($_PAGE['permission'][2] == $sub_menu['page_name'] && $function['code'] == $code && !$favorite) ? 'active' : '');
            $sidenav_menu[$i_module_key]['count']++;
            $sidenav_menu[$i_module_key]['sub_menu'][$hidden_menu['page_name']]['list'][] = [
              'key'  => $sub_menu['page_name'],
              'icon' => 'structure/image/etc/ellipse.svg',
              'name' => $sub_menu['title'],
              'url' => $page_url,
              'active' => $active,
            ];
          }
        } //end foreach submenu
      }
    }
  }
} //end foreach F_permission


//create menu
foreach ($sidenav_menu as $module_key => $module) {
  if ($module['count']) {
    //module
?>
    <div data-layout-name="othermenu" class="nav-x-list-area <?= ($module['is_hide']) ? 'is-hide' : ''; ?>">
      <div class="nav-x-category <?= !$favorite ? 'nav_x_category_event' : ''; ?>">
        <div class="nav-x-logo">
          <?= _file_get_contents($module['icon']) ?>
          <span class="nav-x-project-name <?= ($module['icon']) ? '' : 'pl-0' ?>"><?= $module['name'] ?></span>
        </div>
        <?= !$favorite ? '<div class="nav-x-chevron-expand">' . _file_get_contents("structure/image/etc/icon-arrow.svg") . '</div>' : ''; ?>
      </div>
      <?php
      //submenu
      foreach ($module['sub_menu'] as $sub_menu) {
        if ($sub_menu['list']) {
          //sub menu
      ?>
          <div class="nav-x-menu-list">
            <div class="nav-x-sub-category"><?= $sub_menu['name'] ?></div>
            <div class="nav-x-list-group">
              <?php
              foreach ($sub_menu['list'] as $menu) {
                if (!$favorite) {
                  echo '<a href="' . $menu['url'] . '">';
                }
                //menu
              ?>
                <div class="nav-x-list <?= $menu['active'] ?> <?= $favorite ? 'nav-x-add-favorite' : '' ?>" data-name="<?= $menu['name'] ?>" data-url="<?= $menu['url'] ?>" data-code="<?= $module['code'] ?>_<?= $menu['key'] ?>">
                  <?= _file_get_contents($menu['icon']); ?>
                  <span class="nav-x-page-name"><?= $menu['name'] ?></span>
                </div>
                <?php
                if (!$favorite) {
                  echo '</a>';
                } ?>
              <?php
              } //end foreach submenu
              ?>
            </div>
          </div>
      <?php
        } //end if $sub_menu['list']
      } //end foreach sub_menu
      ?>
    </div>
<?php
  } //end if count
} //end foreach sidenav_menu