<?php
if ($is_dev) {
  if ($_PAGE['permission'][0] == 'core') {
    $active_menu = [
      'icon' => 'structure/image/icon/icon-core.svg',
      'name' => 'CORE',
    ];
  }
?>
  <div class="nav-x-list-area <?= (!$favorite && $_PAGE['permission'][0] != 'core') ? 'is-hide' : ''; ?>">
    <div class="nav-x-category <?= !$favorite ? 'nav_x_category_event' : ''; ?>">
      <div class="nav-x-logo">
        <?= _file_get_contents('structure/image/icon/icon-core.svg') ?>
        <span class="nav-x-project-name">CORE</span>
      </div>
      <?= !$favorite ? '<div class="nav-x-chevron-expand">' . _file_get_contents("structure/image/etc/icon-arrow.svg") . '</div>' : ''; ?>
    </div>
    <?php
    foreach (F_Config::$menu_core_list as $menu) {
      foreach ($menu['menu_items'] as $menu_items) {
    ?>
        <div class="nav-x-menu-list">
          <div class="nav-x-sub-category"><?= $menu_items['title'] ?></div>
          <div class="nav-x-list-group">
            <?php
            foreach ($menu_items['sub_menu'] as $sub_menu) {
              $count_menu++;
              $core_url = ($sub_menu['page_name'] == 'core_dev_database' && isLocalhost()) ? dirname(dirname(dirname(F_BRIDGE_API_URL))) . '/wloves/module_main/core/' . $sub_menu['url'] : '../../module_main/core/' . $sub_menu['url'];
              $active = (($_PAGE['permission'][2] == $sub_menu['page_name'] && !$favorite) ? 'active' : '');
              $target_blank = ($sub_menu['title'] == 'Database') ? 'target="_blank"' : '';

              if (!$favorite) {
                echo '<a href="' . $core_url . '" ' . $target_blank . '>';
              }
            ?>
              <div class="nav-x-list <?= $active ?> <?= $favorite ? 'nav-x-add-favorite' : '' ?>" data-name="<?= $sub_menu['title'] ?>" data-url="<?= $core_url ?>" data-code="<?= $sub_menu['page_name'] ?>">
                <?= _file_get_contents('structure/image/etc/ellipse.svg'); ?>
                <span class="nav-x-page-name"><?= $sub_menu['title'] ?></span>
              </div>
              </a>
            <?php
              if (!$favorite) {
                echo '</a>';
              }
            } //end foreach $menu_items['sub_menu']
            ?>
          </div>
        </div>
    <?php
      } //end foreach $menu['menu_items']
    } //end foreach F_Config::$menu_core_list
    ?>
  </div>
<?php } ?>