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
    Aww::redirectOG('landing.php');
  }
  ?>
  <?php include 'layout/menu.php'; ?>
  <?php include 'layout/nmg_bg.php'; ?>
  <!-- layout mobile -->
  <div class="container index-container position-relative main">

    <?php if ($runnertext) { ?>
      <div class="jackpot">
        <div class="jackpot-frame">
          <div class="jackpot-move">
            <!-- <img src="assets/images/jackpot.png" alt=""> -->
            <img src="source/jackpot-wrap.png" alt="">
            <span>
              <? // = $runnertext['full_text']; 
              ?>
              <?php
              $text = $runnertext['full_text'];
              // $text = "ยินดีกับเบอร์ 089 919XXXX ได้รับ Jackpot 20,000.00 บาท";
              $text = preg_replace('/(\d{3} \d{3}XXXX|\d{1,3}(?:,\d{3})*(?:\.\d{2})?)/', '<span class="gold-text">$1</span>', $text);
              echo $text;
              ?>
            </span>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="row">
      <div class="col-md-12 banner">
        <div class="outlaw-swiper full-size-banner">
          <div class="swiper bannerSwiper pos-rel mt-0">
            <div class="swiper-wrapper">
              <?php
              if ($banner) {
                foreach ($banner as $banner_index) {
              ?>
                  <div class="swiper-slide">
                    <img src="<?= $banner_index['banner_image']; ?>">
                  </div>
              <?php
                }
              }
              ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <!-- <div class="swiper-pagination"></div> -->
          </div>
        </div>
      </div>
      <!-- <div class="col-12">
        <div class="full-size-banner">
          <img src="source/full_banner.png" alt="Full Size Banner" class="">
        </div>
      </div> -->
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
            <?php /* 
              <p class="text-white font-26px">฿ <?= number_format($user_info['money_balance'], 2) ?></p>
            */
            ?>
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
      <!-- <div class="col-12">
        <div class="games-slide-list-container">
          <div class="games-slide-list-header">
            <div class="type-list">
              <img src="source/game-casino-chip.png" alt="">
              <div class="title">CASINO</div>
            </div>
            <div class="d-flex align-items-center justify-content-end">
              <a href="games.php" class="text-decoration-none">
                <div class="icon-total">
                  ดูทั้งหมด
                </div>
              </a>
              <div class="button icon-button-next">
                <a href="#">
                  <?= file_get_contents('source/arrow-left.svg'); ?>
                </a>
              </div>
              <div class="icon-button-prev">
                <a href="#">
                  <?= file_get_contents('source/arrow-right.svg'); ?>
                </a>
              </div>
            </div>
          </div>
          <div class="games-slide-list-body">
            <div class="game-list">
              <img src="source/mockup-game.png" class="game-list-gradient" alt="">
            </div>
          </div>
        </div>
      </div> -->
    </div>
  </div>
  <?php renderFooterNav(); ?>

  <?php
  if (!isset($_SESSION['check_first']) && !isset($landing_page['response_message'])) {
    $_SESSION['check_first'] = 1;
  ?>
    <div class="landing-page">
      <div class="landing-page-container">
        <div class="close-modal event_close_landing_page">
          <?= file_get_contents('assets/icon/X.svg') ?>
        </div>
        <div class="swiper mySwiper">
          <div class="swiper-wrapper">
            <?php
            foreach ($landing_page as $value) {
            ?>
              <div class="swiper-slide">
                <?php if ($value['type'] == 'picture') { ?>
                  <div class="img-16by9 holder">
                    <img src="<?= $value['landing_page_img'] ?>" class="landing-img">
                  </div>
                  <?php if ($value['button_link']) { ?>
                    <div class="button-container">
                      <?php if ($value['button_link']) { ?>
                        <a href="<?= $value['button_link'] ?>" target="_blank" class="btn btn-main"><?= $value['button_name'] ?></a>
                      <?php } else { ?>
                        <button class="btn btn-main event_close_landing_page"><?= $value['button_name'] ?></button>
                      <?php } ?>
                    </div>
                  <?php } ?>
                <?php } else { ?>
                  <div class="landing-text">
                    <span> <?= $value['description'] ?></span>
                  </div>
                  <?php if ($value['button_name']) { ?>
                    <div class="button-container">
                      <?php if ($value['button_link']) { ?>
                        <a href="<?= $value['button_link'] ?>" target="_blank" class="btn btn-main"><?= $value['button_name'] ?></a>
                      <?php } else { ?>
                        <button class="btn btn-main event_close_landing_page"><?= $value['button_name'] ?></button>
                      <?php } ?>
                    </div>
                  <?php } ?>
                <?php } ?>
              </div>
            <?php } ?>
          </div>
          <div class="swiper-pagination swiper-popup"></div>
        </div>
      </div>
    </div>
  <?php
  }
  ?>
  <div class="menu-fix-right">
    <a href="<?= $alliance_data['line_link'] ?>" target="_blank">
      <div class="menu-line">
        <div class="box-close event_close_fix_menu">
          <?= file_get_contents('assets/icon/close.svg') ?>
        </div>
      </div>
    </a>
  </div>

  <?php Tiwdal::startModal('modal_maintenance', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <h5 class="text-center">ขออภัยในความไม่สะดวก</h5>
    <p class="detail font-16px text-center" style="white-space: pre-line">
      ธนาคารไทยพานิชณ์ (SCB) จะทำการปิดปรับปรุงการใช้บริการเพื่อพัฒนาระบบระหว่าง
      วันศุกร์ที่ 9 มิถุนายน 2556 เวลา 20:00 น.
      ถึงเวลา
      วันเสาร์ 10 มิถุนายน 2556 เวลา 03:00 น.
    </p>
    <p class="text-danger text-center" style="white-space: pre-line">
      ลูกค้าจะไม่สามารถทำรายการฝาก - ถอนเงิน
      ผ่าน SCB ได้ตามช่วงเวลาที่ระบุ ทั้งนี้
      <u>ลูกค้าสามารถติดต่อแอดมิน</u>
      เพื่อทำรายการได้ตามปกติ
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  Aww::loadAsset('assets/js/main.js');

  ?>
  <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

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