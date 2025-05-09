<?php
$user_type_menu = Module::selectUserModule();
$basic_setting_menu = User_Basic_Setting::selectMenu();

//check permission and create menu list array
$sidenav_menu = [
  'list' => [
    'name' => 'USER LIST',
    'list' => [],
  ],
  'manage' => [
    'name' => 'USER TYPE MANAGE',
    'list' => [],
  ],
];
//setting user list menu
foreach ($user_type_menu as $sub_menu) {
  $condition = (isset($permissions[$sub_menu['code'] . '_user']));
  if ($condition) {
    $count_menu++;
    $page_url = '../../module/user/manage_user.php?c=' . $sub_menu['code'];

    $code = (isset($_GET['c'])) ? $_GET['c'] : '';
    $active = (($code == $sub_menu['code'] && !$favorite) ? 'active' : '');

    if ($active) {
      $active_menu = [
        'icon' => 'structure/image/icon/general/user.svg',
        'name' => 'User',
      ];
    }

    $sidenav_menu['list']['list'][] = [
      'code' => $sub_menu['code'],
      'key' => $sub_menu['code'] . '_user',
      'name' => $sub_menu['name'],
      'icon' => 'structure/image/etc/ellipse.svg',
      'url' => $page_url,
      'active' => $active,
    ];
  } //end if $condition
} //end foreach submenu

$basic_array = [
  'permission_template' => 'permission_template',
  'has_category' => 'category',
  'has_team' => 'team',
  'has_tag' => 'tag',
];
//menu basic setting
foreach ($basic_setting_menu as $key => $module) {
  foreach ($module['setting_list'] as $basic_key => $basic_value) {
    $map_key = isset($basic_array[$basic_key]) ? $basic_array[$basic_key] : '';
    if (isset($permissions['user_type_' . $module['user_type_id'] . '_' . $map_key])) {
      if (!isset($sidenav_menu['manage']['list'][$key])) {
        $sidenav_menu['manage']['list'][$key] = [
          'user_type_id' => $module['user_type_id'],
          'name' => $module['name'],
          'url' => '../../module/user/user_basic_setting.php?c=',
          'permission' => [],
        ];
      }
      $sidenav_menu['manage']['list'][$key]['permission'][$basic_key] = $basic_value;
    }
  }
}
?>

<?php if ($sidenav_menu['list']['list'] || $sidenav_menu['manage']['list']) { ?>
  <div class="nav-x-list-area <?= (!$favorite && $_PAGE['permission'][0] != 'user') ? 'is-hide' : ''; ?>">
    <div class="nav-x-category <?= !$favorite ? 'nav_x_category_event' : ''; ?>">
      <div class="nav-x-logo">
        <?= _file_get_contents('structure/image/icon/general/user.svg') ?>
        <span class="nav-x-project-name">User</span>
      </div>
      <?= !$favorite ? '<div class="nav-x-chevron-expand">' . _file_get_contents("structure/image/etc/icon-arrow.svg") . '</div>' : ''; ?>
    </div>
    <?php if ($sidenav_menu['list']['list']) { ?>
      <div class="nav-x-menu-list">
        <div class="nav-x-sub-category">USER LIST</div>
        <div class="nav-x-list-group">
          <?php
          //menu
          foreach ($sidenav_menu['list']['list'] as $menu) {
            $count_menu++;
            if (!$favorite) {
              echo '<a href="' . $menu['url'] . '">';
            }
          ?>
            <div class="nav-x-list <?= $menu['active'] ?> <?= $favorite ? 'nav-x-add-favorite' : '' ?>" data-name="<?= $menu['name'] ?>" data-url="<?= $menu['url'] ?>" data-code="<?= $menu['code'] ?>_<?= $sub_menu['name'] ?>">
              <?= _file_get_contents($menu['icon']); ?>
              <span class="nav-x-page-name"><?= $menu['name'] ?> List</span>
            </div>
            <?php
            if (!$favorite) {
              echo '</a>';
            }
            ?>
          <?php
          } //end foreach submenu
          ?>
        </div>
      </div>
    <?php } ?>

    <?php if ($sidenav_menu['manage']['list']) { ?>
      <div class="nav-x-menu-list">
        <div class="nav-x-sub-category"><?= $sidenav_menu['manage']['name'] ?></div>
        <div class="nav-x-list-group">
          <?php
          $page_url = '../../module/user/user_basic_setting.php?c=';
          $active = (strpos($_SERVER['REQUEST_URI'], 'module/user/user_basic_setting.php') !== false ? 'active' : '');
          if ($active) {
            $active_menu = [
              'icon' => 'structure/image/icon/general/user.svg',
              'name' => 'User',
            ];
          }
          if (!$favorite) {
            echo '<a href="' . $page_url . '">';
          }
          ?>
          <div class="nav-x-list <?= $active ?> <?= $favorite ? 'nav-x-add-favorite' : '' ?>" data-name="User Basic Setting" data-url="<?= $page_url ?>" data-code="manage_user">
            <?= _file_get_contents('structure/image/etc/ellipse.svg'); ?>
            <span class="nav-x-page-name">User Basic Setting</span>
          </div>
          <?php
          if (!$favorite) {
            echo '</a>';
          }
          ?>
        </div>
      </div>
    <?php } ?>
  </div>
<?php } ?>