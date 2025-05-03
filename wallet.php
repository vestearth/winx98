<?php
require_once '.framework/import.php';
require_once 'layout/footer_nav.php'; // Include the file containing renderBannerBorder
$page = 'index';


$system_line =  nga_management::getGeneralWebsite($code);
$options = [
  'on_time' => true,
];
$runnertext = nga_management::getRunnerText($code, $options);
$this_page = 'index';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  Aww::loadAsset('assets/css/custom.css');
  ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
</head>

<body>
  <?php
  if ($is_login) {
    $user_current = User::getCurrent();
    $data = [
      'user_id' => $user_current['id'],
      'detail' => 'เข้าหน้าแรก',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $user_info = nga_user::getUserByID($code, $user_current['id']);
    $get_card = nga_management::getCardSetting($code);
    $get_slot = nga_management::getSlotSetting($code);
    $banner = nga_management::selectBanner($code);
    $where = [
      'user_id' => $user_current['id'],
      'is_read' => "'0'"
    ];
    $notification = User_Notification::selectNotification($code, $where);
    $user_group_id = $user_info['user_group_id'];
    $landing_page =  nga_management::selectLandingPageByUserGroup($code, $user_group_id);
  } else {
    // Aww::redirectOG('landing.php');
    Aww::redirectOG('login.php');
  }
  ?>
  <?php include 'layout/menu.php'; ?>
  <?php include 'layout/nmg_bg.php'; ?>
  <!-- layout mobile -->
  <div class="container index-container position-relative main">
    <div class="row">
      <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item">
              <a href="index.php"><?= Ty::get('home') ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?= 'กระเป๋า'; ?></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-12 mt-15px">
        <div class="profile border unset-bottom-radius">
          <div class="profile-detail">
            <div class="profile-name">
              <p><?= $user_info['username'] ?><span class="text-pink-2"><?= $user_info['user_group_name'] ?></span></p>
            </div>
            <div class="profile-balance">
              <div class="box-cash">
                <img src="source/wallet-profile.svg" alt="">
                <p class="text-white font-17px">฿ <?= number_format($user_info['money_balance'], 2) ?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="row g-1">
          <div class="col-6">
            <a href="deposit.php" class="preloader-link text-decoration-none">
              <div class="profile style2 unset-top-radius border">
                ฝากเงิน
              </div>
            </a>
          </div>
          <div class="col-6">
            <a href="withdraw.php" class="preloader-link text-decoration-none">
              <div class="profile style2 unset-top-radius border">
                ถอนเงิน
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php renderFooterNav(); ?>



  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  Aww::loadAsset('assets/js/main.js');
  ?>

  <script>
    $(function() {
      var currentTime = new Date(); // Get the current time
      var currentHour = currentTime.getHours(); // Get the current hour
      // Check if the current time is within the specified range
      if ((currentHour >= 16 && currentHour <= 23) || (currentHour >= 0 && currentHour <= 6)) {
        // Disable the button
        // $('#modal_maintenance').modal('show');
      }

      $(document).on('click', '.event_close_fix_menu', function(e) {
        e.preventDefault();
        $(this).parents('a').fadeOut(300, function() {
          $(this).remove();
        });
      });

      $(document).on('click', '.event_refresh', function() {
        location.reload();
      });

      $(document).on('click', '.event_close_landing_page', function() {
        $('.landing-page').fadeOut();
        $('body').removeClass('no-scroll');
      });
      $('script').remove();
    });
    var swiper = new Swiper(".bannerSwiper", {
      pagination: {
        el: ".swiper-pagination",
      },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
    });
    var swiper = new Swiper(".mySwiper", {
      pagination: {
        el: ".swiper-popup",
      },
    });
  </script>
</body>

</html>