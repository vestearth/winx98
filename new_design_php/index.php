<?php
require_once '../.framework/import.php';
require_once 'layout/navbanner.php';
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
  <?php renderUserFooterNav(); ?>
  <div class="container-fluid mb-200px">
    <?php renderBannerUser(); ?>
    <div class="row">
      <div class="col-12">
        <!-- Popup Banner Suggest Install APP -->
        <div id="app-install-banner" class="bg-granit" style="display:none; position:relative; z-index:1050; box-shadow:0 2px 12px rgba(0,0,0,0.15); padding:18px 24px 18px 54px; min-width:260px; max-width:100vw;">
          <button id="close-app-install-banner" style="position:absolute; left:10px; top:0px; background:transparent; border:none; font-size:50px; color:white; cursor:pointer;">&times;</button>
          <div class="justify-content-between" style="display:flex; align-items:center;">
            <div>
              <div style="font-weight:bold; font-size:16px; color:#FFFFFF;">เพิ่ม WinX98 ไปยัง หน้าแรก</div>
              <div style="font-size:13px; color:#F3D17C;">เข้าเว็บง่าย ผ่านมือถือ</div>
            </div>
            <div>
              <button class="btn btn-light event_view_load_app" style="margin-top:8px; padding:4px 16px; font-size:14px;">
                <div class="my-12px mx-15px">
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
              <span>สล็อต คาสิโน กีฬา หวย ครบจบในที่เดียว พร้อมโบนัสต้อนรับ 100%
              </span>
            </div>
          </div>
        </div>
        <div class="border-top-gradient"></div>

        <!-- Wallet Section -->
        <div class="wallet-section">
          <div class="balance-card">
            <div class="balance-left">
              <p class="balance-label">กระเป๋าเงิน</p>
              <p class="phone-number">089 919 9218</p>
            </div>
            <div class="balance-right">
              <img src="assets/img/icon/coins.svg" alt="Coins" class="coins-icon">
              <div class="balance-amount">
                <span class="amount-main">50,000</span>
                <span class="amount-decimal">.00</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
          <button class="action-btn deposit-btn">
            <img src="assets/img/icon/deposit.svg" alt="Deposit" class="btn-icon">
            <span>ฝากเงิน</span>
          </button>
          <button class="action-btn withdraw-btn">
            <img src="assets/img/icon/withdraw.svg" alt="Withdraw" class="btn-icon">
            <span>ถอนเงิน</span>
          </button>
        </div>
      </div>

      <div class="user-main-menu-container">
        <div class="user-main-menu-header">
          <h2 class="user-main-menu-title">เมนูหลัก</h2>
        </div>

        <div class="user-main-menu-grid">
          <!-- Row 1 -->
          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-game.svg" alt="">
            </div>
            <span class="user-main-menu-label">เล่นเกม</span>
          </div>

          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-wallet.svg" alt="">
            </div>
            <span class="user-main-menu-label">กระเป๋าเงิน</span>
          </div>

          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-promotion.svg" alt="">
            </div>
            <span class="user-main-menu-label">โปรโมชั่น</span>
          </div>

          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-refund.svg" alt="">
            </div>
            <span class="user-main-menu-label">คืนยอดเสีย</span>
          </div>

          <!-- Row 2 -->
          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-profile.svg" alt="">
            </div>
            <span class="user-main-menu-label">โปรไฟล์</span>
          </div>

          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-line.svg" alt="">
            </div>
            <span class="user-main-menu-label">ติดต่อเรา</span>
          </div>

          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-comment.svg" alt="">
            </div>
            <span class="user-main-menu-label">ความคิดเห็น</span>
          </div>

          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-review.svg" alt="">
            </div>
            <span class="user-main-menu-label">รีวิว</span>
          </div>

          <!-- Row 3 -->
          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-vip.svg" alt="">
            </div>
            <span class="user-main-menu-label">VIP</span>
          </div>

          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-dices.svg" alt="">
            </div>
            <span class="user-main-menu-label">มินิเกมส์</span>
          </div>

          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
              <img src="assets/img/icon/main-event.svg" alt="">

            </div>
            <span class="user-main-menu-label">กิจกรรม</span>
          </div>

          <div class="user-main-menu-item">
            <div class="user-main-menu-icon">
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
          <!-- Row 1 -->
          <div class="game-category-item">
            <div class="game-category-card">
              <img src="assets/img/icon/sport-game.png" alt="Fish Game" class="game-category-image">
            </div>
            <span class="game-category-label">กีฬา</span>
          </div>

          <div class="game-category-item">
            <div class="game-category-card">
              <img src="assets/img/icon/slot-game.png" alt="Slot Game" class="game-category-image">
            </div>
            <span class="game-category-label">สล็อต</span>
          </div>

          <div class="game-category-item">
            <div class="game-category-card">
              <img src="assets/img/icon/casino-game.png" alt="Casino Game" class="game-category-image">
            </div>
            <span class="game-category-label">คาสิโน</span>
          </div>

          <div class="game-category-item">
            <div class="game-category-card">
              <img src="assets/img/icon/card-game.png" alt="Card Game" class="game-category-image">
            </div>
            <span class="game-category-label">เกมไพ่</span>
          </div>

          <!-- Row 2 -->
          <div class="game-category-item">
            <div class="game-category-card">
              <img src="assets/img/icon/fish-game.png" alt="Fishing Game" class="game-category-image">
            </div>
            <span class="game-category-label">ยิงปลา</span>
          </div>

          <div class="game-category-item">
            <div class="game-category-card">
              <img src="assets/img/icon/lotto-game.png" alt="Lottery Game" class="game-category-image">
            </div>
            <span class="game-category-label">หวย</span>
          </div>

          <div class="game-category-item">
            <div class="game-category-card">
              <img src="assets/img/icon/cockfight-game.png" alt="Cockfight Game" class="game-category-image">
            </div>
            <span class="game-category-label">ไก่ชน</span>
          </div>

          <div class="game-category-item">
            <div class="game-category-card">
              <img src="assets/img/icon/esport-game.png" alt="Esport Game" class="game-category-image">
            </div>
            <span class="game-category-label">ESPORT</span>
          </div>

          <!-- Row 3 -->
          <div class="game-category-item">
            <div class="game-category-card">
              <img src="assets/img/icon/other-game.png" alt="Keno Game" class="game-category-image">
            </div>
            <span class="game-category-label">เกมอื่น ๆ</span>
          </div>

          <!-- Empty slots for future games -->
          <div class="game-category-item game-category-empty"></div>
          <div class="game-category-item game-category-empty"></div>
          <div class="game-category-item game-category-empty"></div>
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