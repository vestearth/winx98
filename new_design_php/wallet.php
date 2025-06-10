<?php
require_once '../.framework/import.php';
require_once 'layout/footer_nav.php';
require_once 'layout/navbanner.php';
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
    $alliance_data = nga_management::getAllianceByID($code, $user_current['alliance_id']);
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
    Aww::redirectOG('login.php');
  }
  ?>
  <?php include 'layout/winx98_bg.php'; ?>
  <?php renderFooterNav($alliance_data['line_link']); ?>
  <?php renderBannerUser(); ?>
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
        <!-- Wallet Section -->
        <div class="wallet-section">
          <div class="balance-card">
            <div class="balance-left">
              <p class="balance-label">กระเป๋าเงิน</p>
              <p class="phone-number"><?= $user_info['username'] ?></p>
            </div>
            <div class="balance-right">
              <img src="assets/img/icon/coins.svg" alt="Coins" class="coins-icon">
              <div class="balance-amount">
                <?php $money = number_format($user_info['money_balance'], 2); ?>
                <?php
                $money_parts = explode('.', $money);
                $main_amount = $money_parts[0];
                $decimal_part = isset($money_parts[1]) ? $money_parts[1] : '00';
                ?>
                <span class="amount-main"><?= $main_amount ?></span>
                <span class="amount-decimal">.<?= $decimal_part ?></span>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
          <button class="action-btn deposit-btn" onclick="window.location.href='deposit.php'">
            <img src="assets/img/icon/deposit.svg" alt="Deposit" class="btn-icon">
            <span>ฝากเงิน</span>
          </button>
          <button class="action-btn withdraw-btn" onclick="window.location.href='withdraw.php'">
            <img src="assets/img/icon/withdraw.svg" alt="Withdraw" class="btn-icon">
            <span>ถอนเงิน</span>
          </button>
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