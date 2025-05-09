<?php
//ดึงไฟล์ config ของแต่ละ module ว่ามี page อะไรบ้าง
foreach ($modules as $function) {
  F_WLoves::setConfigMenuList($function['module'], '../../');
}
$file_menu_list = F_Config::$menu_list;

//check permission and create menu list array
$sidenav_menu = [];
foreach ($modules as $function) {
  $menu = array_key_exists($function['module'], $file_menu_list) ? $file_menu_list[$function['module']] : '';
  if (!$menu) {
    continue;
  }

  //module list
  if (!$active_menu['name'] && $_PAGE['permission'][0] == strtolower($function['module'])) {
    $active_menu = [
      'icon' => isset($menu['icon']) ? $menu['icon'] : '',
      'name' => $function['name'],
    ];
  }
  if ($function['module'] != 'User') {
    $main_icon = isset($menu['icon']) ? $menu['icon'] : '';
    $sidenav_menu[$function['module']] = [
      'icon' => $main_icon,
      'name' => $function['name'],
      'code' => $function['code'],
      'count' => 0,
    ];
    //submenu
    foreach ($menu['menu_items'] as $menu_items) {
      $sub_icon = (isset($menu_items['icon']) && $menu_items['icon']) ? $menu_items['icon'] : '';
      $sidenav_menu[$function['module']]['sub_menu'][$menu_items['page_name']] = [
        'name' => $menu_items['title'],
        'icon' => $sub_icon,
        'list' => [],
      ];
      //menu
      if (isset($menu_items['sub_menu']) && $menu_items['sub_menu']) {
        foreach ($menu_items['sub_menu'] as $sub_menu) {

          $condition = $sub_menu['url'] && ($sub_menu['page_name'] && isset($permissions[$function['code'] . '_' . $sub_menu['page_name']]));
          if ($condition) {
            $count_menu++;
            $page_url = '../../module/' . $menu['page_name'] . '/' . $sub_menu['url'] . '?c=' . $function['code'];
            $active = (($_PAGE['permission'][2] == $sub_menu['page_name'] && $function['code'] == $_GET['c'] && !$favorite) ? 'active' : '');
            $sidenav_menu[$function['module']]['count']++;
            $sidenav_menu[$function['module']]['sub_menu'][$menu_items['page_name']]['list'][] = [
              'key'  => $sub_menu['page_name'],
              'icon' => ($sub_menu['icon']) ? $sub_menu['icon'] : 'structure/image/etc/ellipse.svg',
              'name' => $sub_menu['title'],
              'url' => $page_url,
              'active' => $active,
            ];
          }
        } //end foreach submenu
      }
    } //end foreach menu_items
  }
} //end foreach F_permission


//create menu
foreach ($sidenav_menu as $module_key => $module) {
  if ($module['count']) {
    //module
    //submenu
    foreach ($module['sub_menu'] as $module_sub_key => $sub_menu) {
      if ($sub_menu['list']) {
        //sub menu
?>
        <div class="nav-x-list-area <?= (!$favorite && $_PAGE['permission'][1] != strtolower($module_sub_key)) ? 'is-hide' : ''; ?>">
          <div class="nav-x-category <?= !$favorite ? 'nav_x_category_event' : ''; ?>">
            <div class="nav-x-logo">
              <?= _file_get_contents($sub_menu['icon']) ?>
              <span class="nav-x-project-name <?= ($sub_menu['icon']) ? '' : 'pl-0' ?>"><?= $sub_menu['name'] ?></span>
            </div>
            <?= !$favorite ? '<div class="nav-x-chevron-expand">' . _file_get_contents("structure/image/etc/icon-arrow.svg") . '</div>' : ''; ?>
          </div>
          <div class="nav-x-menu-list">
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
        </div>

    <?php
      } //end if $sub_menu['list']
    } //end foreach sub_menu
    ?>
<?php
  } //end if count
} //end foreach sidenav_menu