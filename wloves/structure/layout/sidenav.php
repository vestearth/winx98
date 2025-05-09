<?php

$is_full = Aww::cookie('_menu_style') ? 'is-full' : '';
$count_menu = 0;
$active_menu = [
  'icon' => '',
  'name' => '',
];

function sidenavMenu()
{
  global $_GET, $_POST, $_PAGE, $is_full, $count_menu, $active_menu;

  $has_sidenav = true;

  $menu_name = (isset($_POST['menu_name'])) ? $_POST['menu_name'] : '';

  $is_user = F_User::isLoginUser();
  $is_dev = F_User::isDev();
  $is_user_dev = $is_user && $is_dev;
  $user_info = F_User::getCurrentUser();
  $dev_info = F_User::getCurrentDev();
  $log = F_Log::$log_list;

  $favorite_list     = [];
  $permissions       = User_Permission::getUserPermissionList($user_info['id']);
  $program_name      = F_WLoves::getProgramName();
  $logo_image        = File::getPath('logo_image');
  $mobile_logo_image = File::getPath('mobile_logo_image');
  $modules           = F_Permission::$functions_available;

  $mini_menu = Aww::cookie('_menu_style') ? 'is-hide' : '';
  $favorite = Aww::cookie('_page_favorite');
  $favorite = $favorite ? json_decode($favorite, true) : [];

  function _file_get_contents($icon_path)
  {
    if ($icon_path) {
      return file_get_contents('../../' . $icon_path);
    }
    return "";
  }

  //วาด menu log
  function btnlogSvg($log)
  {
    echo '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
            <g id="Group_59431" data-name="Group 59431" transform="translate(-75 -610)">
              <g id="Group_59428" data-name="Group 59428" transform="translate(-165 80)">
                <path id="Subtraction_2" data-name="Subtraction 2" d="M-1419,10h-3V5a2,2,0,0,0-2-2h-5V0h7a3,3,0,0,1,3,3v7Z" transform="translate(1679 530)" fill="' . $log['backend_log']['color'] . '"/>
                <path id="Rectangle_75953" data-name="Rectangle 75953" d="M0,0H4A1,1,0,0,1,5,1V5A0,0,0,0,1,5,5H0A0,0,0,0,1,0,5V0A0,0,0,0,1,0,0Z" transform="translate(250 535)" fill="' . $log['backend_log']['color'] . '"/>
              </g>
              <g id="Group_59429" data-name="Group 59429" transform="translate(85 620)">
                <path id="Subtraction_2-2" data-name="Subtraction 2" d="M7,10H0V7H5A2,2,0,0,0,7,5V0h3V7A3,3,0,0,1,7,10Z" transform="translate(0 0)" fill="' . $log['frontend_log']['color'] . '"/>
                <path id="Rectangle_75953-2" data-name="Rectangle 75953" d="M0,0H5A0,0,0,0,1,5,0V4A1,1,0,0,1,4,5H0A0,0,0,0,1,0,5V0A0,0,0,0,1,0,0Z" transform="translate(0)" fill="' . $log['frontend_log']['color'] . '"/>
              </g>
              <g id="Group_59427" data-name="Group 59427" transform="translate(-165 80)">
                <path id="Subtraction_3" data-name="Subtraction 3" d="M7,10H0V7H5A2,2,0,0,0,7,5V0h3V7A3,3,0,0,1,7,10Z" transform="translate(250 540) rotate(180)" fill="' . $log['sql_log']['color'] . '"/>
                <path id="Rectangle_75954" data-name="Rectangle 75954" d="M1,0H5A0,0,0,0,1,5,0V5A0,0,0,0,1,5,5H0A0,0,0,0,1,0,5V1A1,1,0,0,1,1,0Z" transform="translate(244.999 535)" fill="' . $log['sql_log']['color'] . '"/>
              </g>
              <g id="Group_59430" data-name="Group 59430" transform="translate(75 620)">
                <path id="Subtraction_3-2" data-name="Subtraction 3" d="M10,10H7V5A2,2,0,0,0,5,3H0V0H7a3,3,0,0,1,3,3v7Z" transform="translate(10 10) rotate(180)" fill="' . $log['web_log']['color'] . '"/>
                <path id="Rectangle_75954-2" data-name="Rectangle 75954" d="M0,0H5A0,0,0,0,1,5,0V5A0,0,0,0,1,5,5H1A1,1,0,0,1,0,4V0A0,0,0,0,1,0,0Z" transform="translate(5)" fill="' . $log['web_log']['color'] . '"/>
              </g>
            </g>
          </svg>';
  }

  function navbarWolvesX($favorite = false, $_PAGE = [], $modules, $is_dev, $permissions)
  {
    global $count_menu, $active_menu;
    $module_user_position = Module::getUserMngPostion();
    $program_info = WLoves::getProgramSetup();

    echo '<div class="nav-x-container">';
    //menu module core
    include 'template_core_menu.php';
    if ($module_user_position == 'top') {
      //menu module User
      include 'template_user_menu.php';
    }

    //menu module other
    if (isset($program_info['module_sidebar_mode']) && $program_info['module_sidebar_mode'] == 'single') {
      include 'template_other_single_menu.php';
    } else {
      if (isset($modules) && $modules) {
        include 'template_other_menu.php';
      }
    }

    if ($module_user_position == 'bottom') {
      //menu module User
      include 'template_user_menu.php';
    }
    echo '</div>';
  }
?>

  <!-- left menu -->
  <div id="nav-x" class="<?= $mini_menu ?>">
    <?= navbarWolvesX(false, $_PAGE, $modules, $is_dev, $permissions) ?>
    <div class="x-version">Version 3.0</div>
  </div>

  <!-- top menu -->
  <?php
  include_once 'top_menu.php';
  ?>

  <!-- favorite menu -->
  <div id="nav-x-favorite-menu">
    <div class="x-top-detail">Select Page for add to top bar.</div>
    <?= navbarWolvesX(true, $_PAGE, $modules, $is_dev, $permissions) ?>
  </div>

<?php
} //end function sidenavMenu

sidenavMenu();
?>

<script>
  var hoverTimeoutX;
  var nav_x_hide = true;
  var hoverTimeoutProfileX;
  var nav_x_profile_hide = true;
  $(function() {
    //show hide nav cateogry
    $(document).on('click', '.nav_x_category_event', function(e) {
      $(this).parents('.nav-x-list-area').toggleClass('is-hide');
    });

    // menu full and mini
    $(document).on('click', '.nav-x-chevron-arrow', function(e) {
      $(this).parents('.nav-x-header').toggleClass('is-hide');
      $('#nav-x').toggleClass('is-hide');
      $('#content-x').toggleClass('is-full');
      $('#nav-x').removeClass('is-hover');
      saveFullminiMenuEvent();
    });

    // menu full and mini
    $(document).on('click', '.nav-x-menu', function(e) {
      $(this).parents('.nav-x-header').toggleClass('is-hide');
      $('#nav-x').toggleClass('is-hide');
      $('#content-x').toggleClass('is-full');
      saveFullminiMenuEvent();
    });

    //animation menu
    $('.nav-x-menu').hover(
      function() {
        // if ($('#nav-x').hasClass('is-hide')) {
        nav_x_hide = true;
        $('#nav-x').addClass('is-hover');
        clearTimeout(hoverTimeoutX);
        // }
      },
      function() {
        // if ($('#nav-x').hasClass('is-hide')) {
        hoverTimeoutX = setTimeout(function() {
          if (nav_x_hide) {
            $('#nav-x').removeClass('is-hover');
          }
        }, 500);
        // }
      }
    );
    $('#nav-x').hover(
      function() {
        nav_x_hide = false;
        $('#nav-x').addClass('is-hover');
      },
      function() {
        $('#nav-x').removeClass('is-hover');
      }
    );

    //animation profile
    $('.nav-x-btn-profile').hover(
      function() {

        nav_x_profile_hide = true;
        $('.nav-x-profile-dropdown').addClass('active');
        clearTimeout(hoverTimeoutProfileX);

      },
      function() {

        hoverTimeoutProfileX = setTimeout(function() {
          if (nav_x_profile_hide) {
            $('.nav-x-profile-dropdown').removeClass('active');
          }
        }, 500);

      }
    );
    $('.nav-x-profile-dropdown').hover(
      function() {
        nav_x_profile_hide = false;
        $('.nav-x-profile-dropdown').addClass('active');
      },
      function() {
        $('.nav-x-profile-dropdown').removeClass('active');
      }
    );

    //animation favorite
    $('.btn-nav-x-add').hover(
      function() {
        nav_x_profile_hide = true;
        $('#nav-x-favorite-menu').addClass('active');
        clearTimeout(hoverTimeoutProfileX);

      },
      function() {
        hoverTimeoutProfileX = setTimeout(function() {
          if (nav_x_profile_hide) {
            $('#nav-x-favorite-menu').removeClass('active');
          }
        }, 500);
      }
    );
    $('#nav-x-favorite-menu').hover(
      function() {
        nav_x_profile_hide = false;
        $('#nav-x-favorite-menu').addClass('active');
      },
      function() {
        $('#nav-x-favorite-menu').removeClass('active');
      }
    );

    //scrollbar favotirt menu
    $(".nav-x-favorite").mousewheel(function(event, delta) {
      this.scrollLeft -= (delta * 30);
      event.preventDefault();
    });

    //scrollbar top menu
    // $("#nav-x-top").mousewheel(function(event, delta) {
    //   this.scrollLeft -= (delta * 30);
    //   event.preventDefault();
    // });

    //delete favorite
    $(document).on('click', '.btn-delete-nav-x-favorite', function(e) {
      e.preventDefault()
      var scope = $(this).parents('.nav-x-favorite-list-group');
      scope.remove();
      var code = $(this).attr('data-code');
      var url = '../../structure/layout/ajax/ajax_delete_favorite.php';
      $.post(url, {
        'code': code
      }).done(function(data) {});
    });

    //add favorite
    $(document).on('click', '.nav-x-add-favorite', function(e) {
      var name = $(this).attr('data-name');
      var page = $(this).attr('data-url');
      var code = $(this).attr('data-code');
      var url = '../../structure/layout/ajax/ajax_add_favorite.php';
      var params = {
        'code': code,
        'page': page,
        'name': name,
      }
      $.post(url, params).done(function(data) {
        $('.nav-x-favorite').html(data);
      });
    });
  });

  function saveFullminiMenuEvent() {
    var is_mini = $('#nav-x').hasClass('is-hide');
    var url = '../../structure/layout/ajax/ajax_menu_style.php';
    $.post(url, {
      'is_mini': is_mini
    }).done(function(data) {});
  }
</script>

<div id="content-x" class="content-wrap <?= $is_full ?>">
  <?php
  if (isset($_GET['c']) && $_GET['c'] == 'uwklw') {
    $get_invoice =  nga_agent::getMyInvoiceMonthly($_GET['c']);
    if ($get_invoice) {
  ?>
      <div class="alert-auto-billing d-flex justify-content-between">
        <div class="text-detail d-flex">
          <div class="mr-10px">
            <?= _file_get_contents('structure/image/etc/icon-announcement.svg') ?>
          </div>
          <div>
            เรียนท่านเจ้าของเว็บ ขออนุญาตส่งบิลเรียกเก็บเงินค่าระบบออโต้ (ดูใบเรียกเก็บเงินตามเดือน) <a href="agent_monthly.php?c=<?= $_GET['c'] ?>" target="_blank" class="text-link"><u>คลิกเพื่อดูรายละเอียด</u></a> กรณีที่ชำระเงินแล้ว ยังมีข้อความนี้แสดงอยู่ กรุณาส่งหลักฐานการโอนเงินที่ Line กลุ่มของท่าน พร้อมแจ้งชื่อเว็บไซต์ของท่าน
          </div>
        </div>
        <button class="btn" onclick="closeAlertAutoBilling()">
          <?= _file_get_contents('structure/image/etc/icon-x-close.svg') ?>
        </button>
      </div>
      <script>
        function closeAlertAutoBilling() {
          $('.alert-auto-billing').remove();
        }
      </script>

  <?php }
  } ?>