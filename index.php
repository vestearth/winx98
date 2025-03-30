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
  }
  ?>
  <?php include 'layout/menu.php'; ?>
  <?php include 'layout/nmg_bg.php'; ?>
  <!-- layout mobile -->
  <div class="container index-container position-relative ">

    <?php if ($runnertext) { ?>
      <div class="jackpot">
        <div class="jackpot-frame">
          <div class="jackpot-move">
            <!-- <img src="assets/images/jackpot.png" alt=""> -->
            <img src="source/jackpot-wrap.png" alt="">
            <span>
              <?// = $runnertext['full_text']; ?>
            <?php
            $text = "ยินดีกับเบอร์ 089 919XXXX ได้รับ Jackpot 20,000.00 บาท";
            $text = preg_replace('/(\d{3} \d{3}XXXX|\d{1,3}(?:,\d{3})*(?:\.\d{2})?)/', '<span class="gold-text">$1</span>', $text);
            echo $text;
            ?>
            </span>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="row">
      <div class="col-12">
        <div class="full-size-banner">
          <img src="source/full_banner.png" alt="Full Size Banner" class="">
        </div>
      </div>
      <div class="col-lg-12 mt-15px">
        <div class="profile border unset-bottom-radius">
          <div class="profile-detail">
            <div class="profile-name">
              <p><?= "Dev Earth" ?> <span class="text-pink-2"><?= 'user_group_name' ?></span></p>
            </div>
            <div class="profile-balance">
              <p><?= Ty::get('walletbalance') ?></p>
              <p class="text-white font-26px">฿ <?= number_format(1231231312, 2) ?></p>
              <div class="refresh-time event_refresh">
                <img src="assets/icon/refresh.svg" alt="refresh" class="cursor-pointer">
                <span><?= date('d/m/Y, H:i') ?></span>
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
            <div class="profile style2 unset-top-radius border">
              ฝากเงิน
            </div>
          </div>
          <div class="col-6">
            <div class="profile style2 unset-top-radius border">
                ถอนเงิน
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 ">
        <div class="flex-all-center mb-15px show-mobile-flex">
          <lottie-player src="assets/images/lottie/pink_arrow.json" class="arrow-move" background="transparent" speed="1" loop autoplay></lottie-player>
          <div class="menu-item preloader-link border custom-width mx-15px" link="deposit.php">
            <img src="assets/icon/menu/deposit.svg" alt="deposit">
            <span><?= Ty::get('deposit') ?></span>
          </div>
          <lottie-player src="assets/images/lottie/pink_arrow.json" class="arrow-move flip" background="transparent" speed="1" loop autoplay></lottie-player>
        </div>
        <div class="flex-start-center mb-15px show-mobile-flex">
          <div class="menu-frame">
            <div class="menu-item preloader-link border" link="withdraw.php">
              <img src="assets/icon/menu/withdraw.svg" alt="withdraw">
            </div>
            <span class="font-14px"><?= Ty::get('withdraw') ?></span>
          </div>
          <div class="menu-frame mx-10px">
            <div class="menu-item preloader-link custom-width border" link="games.php">
              <img src="assets/icon/menu/game_logo.png" alt="game" class="zoom-img-2point">
            </div>
            <span class="font-16px"><?= Ty::get('playgame') ?></span>
          </div>
          <div class="menu-frame">
            <div class="menu-item preloader-link border" link="user.php">
              <img src="assets/icon/menu/money_bag.svg" alt="profile">
            </div>
            <span class="font-14px"><?= Ty::get('profile') ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php /* 

  <div class="container-fluid index-container hide-mobile max-w-1690px">
    <div class="row  mb-5px">
      <div class="col-2 d-flex align-items-center justify-content-end">
        <lottie-player src="assets/images/lottie/pink_arrow.json" class="arrow-move" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
      <div class="col">
        <div class="menu-item preloader-link border h-100px layout-position" link="deposit.php">
          <img src="assets/icon/menu/deposit.svg" alt="deposit">
          <span class="ml-10px font-20px"><?= Ty::get('deposit') ?></span>
        </div>
      </div>
      <div class="col">
        <div class="menu-item preloader-link border h-100px layout-position" link="games.php">
          <img src="assets/icon/menu/game_logo.png" alt="games" class="zoom-img">
          <span class="ml-10px font-20px"><?= Ty::get('playgame') ?></span>
        </div>
      </div>
      <div class="col">
        <div class="menu-item preloader-link border h-100px layout-position" link="withdraw.php">
          <img src="assets/icon/menu/withdraw.svg" alt="withdraw" class="zoom-img">
          <span class="ml-10px font-20px"><?= Ty::get('withdraw') ?></span>
        </div>
      </div>
      <div class="col-2 d-flex align-items-center ">
        <lottie-player src="assets/images/lottie/pink_arrow.json" class="arrow-move flip" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
    </div>
  </div>
  */ ?>
  <?php /* 
  <div class="container index-container">
    <div class="row">
      <div class="col-md-12">
        <div class="row-sub-menu index-layout">
          <?php foreach ($menu_sub as $key => $menu_sub_list) { ?>
            <div class="menu-frame col-sub-menu <?= $key == 0 ? 'd-none' : ''  ?> <?= !$menu_sub_list['is_mobile'] ? 'hide-mobile-flex' : ''  ?>">
              <div class="menu-item border" link="<?= $menu_sub_list['url'] ?>">
                <?php
                if (isset($menu_sub_list['count']) && $menu_sub_list['count'] > 0) {
                  echo '<div class="count">' . $menu_sub_list['count'] . '</div>';
                }
                if ($menu_sub_list['title'] == 'ติดต่อเรา' || $menu_sub_list['title'] == 'Contact us') {
                  $class_add = 'set-img-height';
                } else {
                  $class_add = '';
                }
                ?>
                <img src="<?= $menu_sub_list['image'] ?>" alt="<?= $menu_sub_list['title'] ?>" class="zoom-img-1point <?= $class_add; ?>">
              </div>
              <span class="text-nowrap"><?= $menu_sub_list['title'] ?></span>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-12 banner">
        <div class="outlaw-swiper">
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
    </div>
  </div>
      */ ?>

  <?php /* 
  <footer class="max-w-375px">
    <div class="row align-self-center">
      <?php foreach ($menu_footer as $key => $footer) {
        if ($footer['image'] == 'assets/icon/menu/purple.svg') {
          $class_add = 'set-img-height';
        } else {
          $class_add = '';
        }
      ?>

        <div class="col px-0">
          <div class="menu-footer  <?= ($key == 2) ? 'center' : '' ?> <?= ($key == 0) ? 'active' : '' ?>" link="<?= $footer['url'] ?>">
            <div class="icon-footer <?= ($key == 0) ? 'home' : '' ?>">
              <img src="<?= $footer['image'] ?>" alt="" class="<?= $class_add; ?>">
            </div>
            <div class="text"><?= $footer['title'] ?></div>
          </div>
        </div>
      <?php } ?>
    </div>
  </footer>
  */ ?>
<?php renderFooterNav(); ?>

  <!-- footer index -->
   <?php /* 
  <div class="bottom-menu-container">
    <div class="bottom-menu-body">
      <?php foreach ($menu_footer as $key => $footer) {
        if ($footer['image'] == 'assets/icon/menu/line_purple.svg') {
          $class_add = 'set-img-height';
        } else {
          $class_add = '';
        }
      ?>
        <a href="<?= $footer['url'] ?>" class="<?= ($key == 2) ? 'd-none' : 'bottom-menu-item' ?> preloader-link" <?= ($key == 0) ? 'active' : '' ?>>
          <div class="menu-box <?= $class_add; ?>">
            <!-- check if file img == svg  or png  -->
            <?php if (strpos($footer['image'], '.svg') !== false) { ?>
              <?= file_get_contents($footer['image']) ?>
            <?php } else { ?>
              <img src="<?= $footer['image']; ?>" alt="">
            <?php } ?>
          </div>
          <div class="menu-name"><?= $footer['title'] ?></div>
        </a>
      <?php } ?>
    </div>
  </div>
  */ ?>

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
    <a href="<?= $system_line['line_link'] ?>" target="_blank">
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