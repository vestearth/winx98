<?php
if (isset($_GET['action']) && $_GET['action'] == 'welcome') {
  $active_menu['icon'] = '';
  $active_menu['name'] = 'Welcome!';
} else if (strpos($_SERVER['REQUEST_URI'], 'module_main/core/profile.php') !== false || strpos($_SERVER['REQUEST_URI'], 'module_main/core/profile_dev.php') !== false) {
  $active_menu['icon'] = 'structure/image/icon/general/user.svg';
  $active_menu['name'] = 'Profile';
}
if (isset($_GET['c']) && $_GET['c'] == 'uwklw') {
  $user_data = User::getCurrent();
  $where = [
    'user_id' => $user_data['id'],
    // 'is_read' => "'0'"
  ];
  $options = [
    'sort' => ['id' => 'DESC']
  ];
  $notification_list = User_Notification::selectNotification($_GET['c'], $where, $options);
  $where_count = [
    'user_id' => $user_data['id'],
    'is_read' => "'0'"
  ];
  $count_notification_list = User_Notification::selectNotification($_GET['c'], $where_count);
  $count_noti = count($count_notification_list);
}

?>

<div id="nav-x-top">
  <div class="nav-x-left">
    <div class="nav-x-header <?= $mini_menu ?>">
      <div class="nav-x-logo">
        <?php if (strpos($logo_image, '/placeholder/')  === false) { ?>
          <img src="<?= $logo_image ?>" class="fix-img">
        <?php  } else { ?>
          <?= _file_get_contents('structure/image/logo/wloves-x.svg'); ?>
        <?php } ?>
      </div>
      <div class="nav-x-chevron-arrow">
        <?= _file_get_contents('structure/image/layout/icon-menu-arrow.svg'); ?>
      </div>
      <div class="nav-x-menu">
        <div class="icon">
          <?= _file_get_contents('structure/image/etc/menu.svg'); ?>
        </div>
        <div class="icon-hover">
          <?= _file_get_contents('structure/image/layout/icon-menu-arrow.svg'); ?>
        </div>
      </div>
    </div>
    <?php if ($active_menu['name']) { ?>
      <div class="nav-x-module-active">
        <?php if (isset($active_menu['icon']) && $active_menu['icon']) { ?>
          <div class="nav-x-icon">
            <?= _file_get_contents($active_menu['icon']); ?>
          </div>
        <?php } ?>
        <div class="nav-x-name-active"><?= $active_menu['name'] ?></div>
      </div>
    <?php } ?>
  </div>

  <div class="nav-x-center">
    <?php if ($favorite && $count_menu > 0) { ?>
      <div class="nav-x-slash"></div>
      <div class="nav-x-favorite">
        <?php foreach ($favorite as $code => $data) {
          $code_module = explode('_', $code)[0];
          if (isset($permissions[$code]) || ($code_module == 'core' && $is_dev)) {
        ?>
            <div class="nav-x-favorite-list-group">
              <a href="<?= $data['page'] ?>">
                <div class="nav-x-favorite-list">
                  <span><?= $data['name'] ?></span>
                  <div class="btn-delete-nav-x-favorite" data-code="<?= $code ?>">
                    <?= _file_get_contents('structure/image/etc/delete.svg') ?>
                  </div>
                </div>
              </a>
              <div class="nav-x-slash"></div>
            </div>
        <?php
          }
        }
        ?>
      </div>
    <?php } ?>
    <?php if ($count_menu > 0) { ?>
      <div class="btn-nav-x-add">
        <?= _file_get_contents('structure/image/etc/icon-plus.svg'); ?>
        <span class="nav-x-text">Add Page</span>
      </div>
    <?php } ?>
  </div>

  <div class="nav-x-right">
    <div class="nav-x-slash"></div>
    <div class="nav-x-aleat nmg-nav-panel">
      <?php
      if (isset($_GET['c']) && $_GET['c'] == 'uwklw') {
      ?>
        <div class="dropdown d-xl-block">
          <a class="nav-icon notification_event read_noti_event" type="button" id="notiDropdown" data-toggle="dropdown">
            <?php
            if ($count_noti != 0) {
            ?>
              <span class="badge badge-danger badge-custom noti_count">
                <?= ($count_noti <= 99) ? $count_noti : '99+'; ?>
              </span>
            <?php
            }
            ?>
            <?= _file_get_contents('structure/image/etc/bell.svg') ?>
          </a>

          <div class="dropdown-menu p-0 m-0 dropdown-menu-right" aria-labelledby="notiDropdown" id="noti-dropdown">
            <div class="card noti-card">
              <div class="card-header">
                <h5 class="font-Medium font-16px mb-0">รายการแจ้งเตือน (<?= number_format($count_noti, 0); ?>)</h5>
              </div>
              <div class="noti-body">
                <?php foreach ($notification_list as $noti_list) {
                  $slide_text = explode(" ", $noti_list['type']);
                ?>
                  <div class="noti-item">
                    <div class="noti-img-box">
                      <?= _file_get_contents('structure/image/etc/icon-notification.svg') ?>
                    </div>
                    <div class="noti-info-box">
                      <div class="noti-header"><?= $noti_list['topic']; ?></div>
                      <div class="noti-info">
                        <?= $slide_text['0'] . ' ' . $slide_text['1']; ?>
                        <span class="amount"><?= $slide_text['2']; ?></span>
                        <?= $slide_text['3'] . ' ' . $slide_text['4']; ?>
                        <span class="by-user"><?= $slide_text['5']; ?></span>
                      </div>
                      <div class="noti-timestamp"><?= Aww::formatDate($noti_list['insert_date_time'], 'd/m/Y, H:i'); ?></div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>

        </div>
      <?php } ?>
    </div>

    <div class="nav-x-slash"></div>
    <div class="log <?= ($_PAGE['permission'][1] == 'core_log') ? 'active' : ''; ?>">
      <a href="../../module_main/core/log.php">
        <?php
        if ($is_dev && $log) {
          btnlogSvg($log);
        }
        ?>
      </a>
    </div>

    <?php if ($is_dev) { ?>
      <div class="nav-x-slash"></div>
    <?php } ?>
    <div class="nav-x-profile">
      <div class="nav-x-btn-profile">
        <?php if ($is_user) { ?>
          <div class="nav-x-profile-user">
            <img src="<?= $user_info['profile_image']; ?>">
          </div>
        <?php } ?>
        <?php if ($is_dev) { ?>
          <div class="nav-x-profile-dev <?= $is_user_dev ? 'ml--15px' : ''; ?>">
            <div class="nav-x-profile-image">
              <img src="<?= $dev_info['profile_image']; ?>">
            </div>
            <?= _file_get_contents('structure/image/etc/development.svg') ?>
          </div>
        <?php } ?>
      </div>
      <div class="nav-x-profile-dropdown  <?= $is_dev ? 'max-w-400px' : 'max-w-200px'; ?>">
        <?php if ($is_user) { ?>
          <div class="nav-x-profile-dropdown-user">
            <div class="nav-x-user-name"><?= $user_info['username']; ?></div>
            <div class="nav-x-user-id">ID: <?= $user_info['id'] ?>, <?= $user_info['user_type'] ?></div>
            <hr>
            <a href="../../module_main/core/profile.php?c=">
              <div class="nav-x-edit-profile">
                <div class="nax-x-profile-name">
                  <?= _file_get_contents('structure/image/etc/user.svg') ?>
                  <span>Profile</span>
                </div>
                <div class="arrow-right">
                  <?= _file_get_contents('structure/image/etc/icon-arrow.svg') ?>
                </div>
              </div>
            </a>
            <hr>
            <div class="nav-x-logout" data-toggle="modal" data-target="#logout_user_popup">Log out</div>
          </div>
        <?php } else { ?>
          <div class="nav-x-profile-dropdown-user pb-10px">
            <div class="nav-x-profile-user-login-msg">Some data dev can’t view please log in User ID for get permission</div>
            <div class="nav-x-btn-user-login-area">
              <a href="../../module_main/login" class="nav-x-btn-user-login">Log in User ID</a>
            </div>
          </div>
        <?php } ?>

        <?php if ($is_dev) { ?>
          <div class="nav-x-profile-dropdown-dev <?= $is_dev ? 'is-border' : ''; ?>">
            <div class="nav-x-user-name"><?= $dev_info['username']; ?></div>
            <div class="nav-x-user-id">ID: <?= $dev_info['id']; ?>, Dev</div>
            <div class="switch-color-mode">
              <div class="icon-mode">
                <?= _file_get_contents('structure/image/icon/icon-light-mode.svg') ?>
                <?= _file_get_contents('structure/image/icon/icon-dark-mode.svg') ?>
              </div>
              <?php TiwForm::normal('checkbox', '', ['name' => '', 'class' => 'event-switch-color-mode'], ['style' => '1']);  ?>
            </div>
            <hr>
            <a href="../../module_main/core/profile_dev.php?c=">
              <div class="nav-x-edit-profile">
                <div class="nax-x-profile-name">
                  <?= _file_get_contents('structure/image/etc/user.svg') ?>
                  <span>Dev Profile</span>
                </div>
                <div class="arrow-right">
                  <?= _file_get_contents('structure/image/etc/icon-arrow.svg') ?>
                </div>
              </div>
            </a>
            <hr>
            <div class="nav-x-logout" data-toggle="modal" data-target="#logout_popup">Log out</div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('.notification_event').on('click', function() {
      $('.noti_count').html(0);
    });
    $(document).on('click', '.read_noti_event', function(e) {
      var url = 'ajax/ajax_noti.php';
      var params = {
        'submit_read_noti': '',
        'code': '<?= $_GET['c']; ?>'
      };

      $.post(url, params).done(function(data) {
        if (data) {} else {}
      }).fail(function(xhr, status, error) {
        console.log(error);
      });
    });
  });
</script>