<?php
require_once '../.framework/import.php';
require_once 'layout/navbanner.php';
require_once 'layout/footer_nav.php';
$page = 'index';


$system_line =  nga_management::getGeneralWebsite($code);
$options = [
  'on_time' => true,
];
$runnertext = nga_management::getRunnerText($code, $options);
$this_page = 'index';

$type_game_template = [
  'CASINOLIVE' => [
    'name' => Ty::get('casino'),
    'typeName' => 'CASINOLIVE',
    'img' => 'assets/img/icon/casino-game.png',
    'ordering' => 1
  ],
  'SLOT' => [
    'name' => Ty::get('slot'),
    'typeName' => 'SLOT',
    'img' => 'assets/img/icon/slot-game.png',
    'ordering' => 2,
  ],
  'SPORTBOOK' => [
    'name' => Ty::get('sport'),
    'typeName' => 'SPORTBOOK',
    'img' => 'assets/img/icon/sport-game.png',
    'ordering' => 3
  ],
  'FISHING' => [
    'name' => Ty::get('fishing'),
    'typeName' => 'FISHING',
    'img' => 'assets/img/icon/fish-game.png',
    'ordering' => 4
  ],
  'CARD' => [
    'name' => Ty::get('card'),
    'typeName' => 'CARD',
    'img' => 'assets/img/icon/card-game.png',
    'ordering' => 6
  ],
  'BOARD' => [
    'name' => Ty::get('board'),
    'typeName' => 'BOARD',
    'img' => 'assets/img/icon/other-game.png',
    'ordering' => 7
  ],
  'LOTTO' => [
    'name' => Ty::get('lottery'),
    'typeName' => 'LOTTO',
    'img' => 'assets/img/icon/lotto-game.png',
    'ordering' => 8
  ],
  'ARCADE' => [
    'name' => 'ARCADE',
    'typeName' => 'ARCADE',
    'img' => 'assets/img/icon/esport-game.png',
    'ordering' => 8
  ],
];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  Aww::loadAsset('assets/css/custom.css');
  ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

    $get_game_setting = nga_management::getGameActiveStatus($code);

    if ($get_game_setting['is_open_card_game'] == 0) {
      unset($type_game_template['CARD']);
    }
    if ($get_game_setting['is_open_board_game'] == 0) {
      unset($type_game_template['BOARD']);
    }
    if ($get_game_setting['is_open_slot_game'] == 0) {
      unset($type_game_template['SLOT']);
    }
    if ($get_game_setting['is_open_casinolive_game'] == 0) {
      unset($type_game_template['CASINOLIVE']);
    }
    if ($get_game_setting['is_open_arcade_game'] == 0) {
      unset($type_game_template['ARCADE']);
    }
    if ($get_game_setting['is_open_fishing_game'] == 0) {
      unset($type_game_template['FISHING']);
    }
    if ($get_game_setting['is_open_lotto'] == 0) {
      unset($type_game_template['LOTTO']);
    }

    if ($get_game_setting['is_open_sportbook_game'] == 0) {
      unset($type_game_template['SPORTBOOK']);
    }
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>
  <?php renderFooterNav($alliance_data['line_link']); ?>
  <div class="container-fluid mb-200px">
    <?php renderBannerUser(); ?>
    <div class="row">
      <div class="col-12">
        <!-- Popup Banner Suggest Install APP -->
        <div id="app-install-banner d-none" class="bg-granit" style="display:none; position:relative; z-index:1050; box-shadow:0 2px 12px rgba(0,0,0,0.15); padding:18px 24px 18px 54px; min-width:260px; max-width:100vw;">
          <button id="close-app-install-banner" style="position:absolute; left:10px; top:0px; background:transparent; border:none; font-size:50px; color:white; cursor:pointer;">&times;</button>
          <div class="justify-content-between" style="display:flex; align-items:center;">
            <div>
              <div style="font-weight:bold; font-size:16px; color:#FFFFFF;">เพิ่ม WinX98 ไปยัง หน้าแรก</div>
              <div style="font-size:13px; color:#F3D17C;">เข้าเว็บง่าย ผ่านมือถือ</div>
            </div>
            <div>
              <button class="btn btn-light event_view_load_app" style="margin-top:8px; padding:4px 16px; font-size:14px;">
                <div class="my-12px mx-15px text-nowrap">
                  <img src="assets/img/app-install.svg" alt="App Install" style="width:20px; height:20px; margin-right:8px;">
                  <span class="font-16px" style="font-weight: 600;">
                    APP INSTALL
                  </span>
                </div>
              </button>
            </div>
          </div>
        </div>
        <script>
          $(function() {
            // Show banner if not closed before
            if (!$.cookie('close_app_install_banner')) {
              $('#app-install-banner').fadeIn();
            }
            $('#close-app-install-banner').on('click', function() {
              $('#app-install-banner').fadeOut();
              $.cookie('close_app_install_banner', '1', {
                expires: 7
              });
            });
          });
        </script>
      </div>
    </div>
    <div class="mx-auto" style="max-width: 700px;">
      <div class="casino-app">
        <!-- Header Section -->
        <div class="header-section">
          <img src="assets/img/indexPromo.png" alt="Casino Banner" class="header-background-image">
        </div>

        <!-- News Ticker -->
        <div class="border-top-gradient"></div>
        <div class="news-ticker">
          <div class="ticker-content">
            <span class="ticker-label">ประกาศ</span>
            <div class="ticker-text">
              <?php
              $text = $runnertext['full_text'];
              $text = preg_replace('/(\d{3} \d{3}XXXX|\d{1,3}(?:,\d{3})*(?:\.\d{2})?)/', '<span class="gold-text">$1</span>', $text);
              ?>
              <span>
                <?= $text; ?>
              </span>
            </div>
          </div>
        </div>
        <div class="border-top-gradient"></div>

        <!-- Wallet Section -->
        <!-- <div class="wallet-section">
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
        </div> -->

        <!-- Action Buttons -->
        <!-- <div class="action-buttons">
          <button class="action-btn deposit-btn" onclick="window.location.href='deposit.php'">
            <img src="assets/img/icon/deposit.svg" alt="Deposit" class="btn-icon">
            <span>ฝากเงิน</span>
          </button>
          <button class="action-btn withdraw-btn" onclick="window.location.href='withdraw.php'">
            <img src="assets/img/icon/withdraw.svg" alt="Withdraw" class="btn-icon">
            <span>ถอนเงิน</span>
          </button>
        </div>
      </div> -->

        <div class="user-main-menu-container">
          <div class="user-main-menu-header">
            <h2 class="user-main-menu-title">เมนูหลัก</h2>
          </div>

          <div class="user-main-menu-grid">
            <!-- Row 1 -->
            <div class="user-main-menu-item" onclick="window.location.href='games.php'">
              <div class="user-main-menu-icon">
                <img src="assets/img/icon/main-game.svg" alt="">
              </div>
              <span class="user-main-menu-label">เล่นเกม</span>
            </div>

            <div class="user-main-menu-item" onclick="window.location.href='wallet.php'">
              <div class="user-main-menu-icon">
                <img src="assets/img/icon/main-wallet.svg" alt="">
              </div>
              <span class="user-main-menu-label">กระเป๋าเงิน</span>
            </div>

            <div class="user-main-menu-item" onclick="window.location.href='<?= $alliance_data['line_link']; ?>'">
              <div class="user-main-menu-icon">
                <img src="assets/img/icon/main-line.svg" alt="">
              </div>
              <span class="user-main-menu-label">ติดต่อเรา</span>
            </div>

            <div class="user-main-menu-item" onclick="window.location.href='refund.php'">
              <div class="user-main-menu-icon">
                <img src="assets/img/icon/main-refund.svg" alt="">
              </div>
              <span class="user-main-menu-label">คืนยอดเสีย</span>
            </div>

            <!-- Row 2 -->
            <div class="user-main-menu-item" onclick="window.location.href='user.php'">
              <div class="user-main-menu-icon">
                <img src="assets/img/icon/main-profile.svg" alt="">
              </div>
              <span class="user-main-menu-label">โปรไฟล์</span>
            </div>

            <div class="user-main-menu-item">
              <div class="user-main-menu-icon user-main-menu-icon--blockout">
                <img src="assets/img/icon/main-promotion.svg" alt="">
              </div>
              <span class="user-main-menu-label">โปรโมชั่น</span>
            </div>


            <div class="user-main-menu-item">
              <div class="user-main-menu-icon user-main-menu-icon--blockout">
                <img src="assets/img/icon/main-comment.svg" alt="">
              </div>
              <span class="user-main-menu-label">ความคิดเห็น</span>
            </div>

            <div class="user-main-menu-item">
              <div class="user-main-menu-icon user-main-menu-icon--blockout">
                <img src="assets/img/icon/main-review.svg" alt="">
              </div>
              <span class="user-main-menu-label">รีวิว</span>
            </div>

            <div class="user-main-menu-item">
              <div class="user-main-menu-icon user-main-menu-icon--blockout">
                <img src="assets/img/icon/main-vip.svg" alt="">
              </div>
              <span class="user-main-menu-label">VIP</span>
            </div>

            <div class="user-main-menu-item">
              <div class="user-main-menu-icon user-main-menu-icon--blockout">
                <img src="assets/img/icon/main-dices.svg" alt="">
              </div>
              <span class="user-main-menu-label">มินิเกมส์</span>
            </div>

            <div class="user-main-menu-item">
              <div class="user-main-menu-icon user-main-menu-icon--blockout">
                <img src="assets/img/icon/main-event.svg" alt="">

              </div>
              <span class="user-main-menu-label">กิจกรรม</span>
            </div>

            <div class="user-main-menu-item">
              <div class="user-main-menu-icon user-main-menu-icon--blockout">
                <img src="assets/img/icon/main-aff.svg" alt="">
              </div>
              <span class="user-main-menu-label">แนะนำเพื่อน</span>
            </div>
          </div>
        </div>

        <div class="jackpot-swiper unset-height">
          <div class="d-flex justify-content-center align-items-center mt-20px mb-10px">
            <img src="assets/img/text-customer.svg">
          </div>
          <div class="swiper swiperJackpot">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="jackpot-title">
                  <img src="assets/img/jackpot-img.png" alt="">
                </div>
                <div class="jackpot-card">
                  <div class="jackpot-message">
                    ยินดีกับลูกค้า 089 919 XXXX<br>
                    แตกแจ็คพอต <b>5,000฿</b>
                  </div>
                </div>
              </div>
              <div class="swiper-slide">
                <div class="jackpot-title">
                  <img src="assets/img/jackpot-img.png" alt="">
                </div>
                <div class="jackpot-card">
                  <div class="jackpot-message">
                    ยินดีกับลูกค้า 086 777 XXXX<br>
                    แตกแจ็คพอต <b>3,200฿</b>
                  </div>
                </div>
              </div>
              <!-- Add more slides as needed -->
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>

        <div class="text-center my-25px">
          <img src="assets/img/game-text.svg" alt="">
        </div>

        <div class="game-categories-container">
          <div class="game-categories-grid">
            <?php foreach ($type_game_template as $gameType => $gameData): ?>
              <div class="game-category-item" onclick="window.location.href='games.php?type=<?= $gameData['typeName'] ?>'">
                <div class="game-category-card">
                  <img src="<?= $gameData['img'] ?>" alt="<?= $gameData['name'] ?>" class="game-category-image">
                </div>
                <span class="game-category-label"><?= $gameData['name'] ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  Aww::loadAsset('assets/js/main.js');
  Aww::loadAsset('assets/js/notification.js');

  ?>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

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
    var swiper = new Swiper('.swiperJackpot', {
      slidesPerView: 3,
      spaceBetween: 16,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      loop: true,
      // autoplay: {
      //   delay: 3000,
      //   disableOnInteraction: false
      // },
      breakpoints: {
        0: {
          slidesPerView: 1
        },
        992: {
          slidesPerView: 3
        }
      }
    });
  </script>
</body>

</html>