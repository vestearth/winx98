<?php
require_once '.framework/import.php';
require_once 'layout/navbanner.php';
require_once 'layout/footer_nav_landing.php';

$system_line  = nga_management::getGeneralWebsite($code);

$menu_landing = [
  [
    'url' => 'index.php',
    'image' => 'source/icon-home.svg',
    'title' => Ty::get('home')
  ],
  [
    'url' => 'signup.php',
    'image' => 'source/icon-signup.svg',
    'title' => Ty::get('register'),
  ],
  [
    'url' => 'login.php',
    'image' => 'source/icon-login.svg',
    'title' => Ty::get('login')
  ],
  [
    'url' => 'https://line.me/R/ti/p/@152kglax?oat_content=url&ts=05140244',
    'image' => 'source/icon-contact.svg',
    'title' => Ty::get('contact_us'),
  ]
];
$banner_download_landing = (isset($_COOKIE['banner_download_landing']) && $_COOKIE['banner_download_landing']) ? $_COOKIE['banner_download_landing'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  Aww::loadAsset('assets/css/custom.css');
  ?>
  <link rel="canonical" href="https://mvpshot.com/landing.php">
</head>

<body>

  <section class="banner">
    <?php
    if (!$banner_download_landing) { ?>
      <div class="landing-header-download">
        <div class="pos-rel">
          <div class="app-close pos-ab">
            <button type="button" class="custom-btn-top-close" id="closeModal">
              <?= file_get_contents('assets/icon/cross.svg') ?>
            </button>
          </div>
          <img src="assets/images/landing/app_banner.png?gen=<?= rand(0.1, 1111); ?>" class="event_view_load_app" alt="logo">
        </div>
      </div>
    <?php } else {
      // landing-header-body stype top:0px
      $lhb_style = 'style-close-banner';
    } ?>
    <div class="container">
      <?php renderBannerBorder(); ?>
      <div class="row">
        <div class="col-12">
          <div class="img-intro d-flex justify-content-center w-100 mt-20px">
            <img src="source/first-landing.png" alt="Full Size Banner" class="">
          </div>
        </div>
      </div>
      <div class="intro">
        <p>
          <span class="gold-txt">WinX98</span> เว็บเดิมพันออนไลน์ คาสิโนครบ
          วงจร มาพร้อมระบบและบริการที่ยอดเยี่ยมถึงใจ
          สมัครรับโบนัสฟรี <span class="gold-txt">100%</span>
        </p>
        <p>
          ถ้าพูดถึงเว็บพนันออนไลน์ WinX98 ที่ดีและได้รับ
          มาตรฐานสากลต้อง WinX98 เท่านั้นเพราะเป็นเว็บ
          betflik ทางเข้า พนันออนไลน์ที่ได้รับ ลิขสิทธิ์แท้จากต่าง
          ประเทศ ถูกต้องของแท้แน่นอน...อ่านทั้งหมด
        </p>
        <div class="img-intro w-100">
          <img src="source/intro-landing.png" class="">
        </div>
        <div class="easy-register mt-20px">
          <p class="mb-0 font-24px">
            <span class="gold-txt font-24px">สมัครง่าย</span> เพียง 3 ขั้นตอน
          </p>
          <p class="mb-0 font-18px">
            สมัครฟรี!! ไม่มีค่าบริการ ปลอดภัย 100%
          </p>
          <div class="icon-regis mt-20px mb-30px">
            <div class="row">
              <div class="col-4">
                <img src="source/game-regis1.png" alt="">
                <p class="gold-txt mb-0 font-18px">สมัครสมาชิก</p>
                <span>ง่าย ๆ ผ่านหน้าเว็บ</span>
              </div>
              <div class="col-4">
                <img src="source/game-regis2.png" alt="">
                <p class="gold-txt mb-0 font-18px">ฝากเงิน</p>
                <span>ฝาก-ถอนเร็ว
                  เพียง 2 วินาที!!</span>
              </div>
              <div class="col-4">
                <img src="source/game-regis3.png" alt="">
                <p class="gold-txt mb-0 font-18px">สนุกไปกับเกม</p>
                <span>มากกว่า 50 ค่าย</span>
              </div>
            </div>
          </div>
          <div>
            <button type="submit" name="submit_register" class="btn btn-sub w-100">
              <?= "สมัครสมาชิกเลย"; ?>
            </button>
          </div>
        </div>
        <div class="row mt-30px">
          <div class="col-lg-12 mb-20px mb-lg-0">
            <div class="d-flex justify-content-center align-items-center promote-join">
              <img src="source/promote-join.png" class="">
            </div>
          </div>
          <div class="col-lg-12">
            <div class="d-flex justify-content-center align-items-center promote-auto">
              <img src="source/promote-auto.png" class="">
            </div>
          </div>
        </div>
        <div class="intro2">
          <div class="d-flex title">
            <img src="source/icon-mockup.png" alt="">
            <div class="text">
              WinX98
            </div>
          </div>
          <span class="content">
            WinX98 เจ้าแรกในไทย ให้บริการผ่านเว็บตรง ที่มี
            เกมสล็อตมากกว่า 1,000 เกมกับ 21 ค่ายชื่อดัง รวมเกม
            แตกบ่อย ที่หลายเว็บไม่มีให้เล่น ทุกอย่างครบจบภายใน
            กระเป๋าเดียว ไม่ต้องโยกเงินให้เสียเวลา ระบบอัตโนมัติทุก
            ขั้นตอน สมัครสมาชิก ฝาก -ถอนไว ใช้เวลาทำธุรกรรม
            เพียง 3 วินาที รับฟรีสิทธิพิเศษสำหรับลูกค้า
          </span>
        </div>
        <hr>
        <div class="menu-additional">
          <div class="row">
            <!-- <div class="col-6 col-md-3 d-none d-md-block"></div> -->
            <div class="col-6 col-md-6">
              <div class="title d-none">
                <div>
                  เมนูเพิ่มเติม
                </div>
                <ul class="menu-ul">
                  <?php
                  $menu_items = [
                    ['text' => 'WinX98'],
                    ['text' => 'ฝากถอน'],
                    ['text' => 'โปรโมชั่น'],
                    ['text' => 'กิจกรรม'],
                    ['text' => 'รีวิวลูกค้า'],
                  ];

                  foreach ($menu_items as $item) {
                    echo '<li><span class="gen-icon"></span>' . $item['text'] . '</li>';
                  }
                  ?>
                </ul>
              </div>
            </div>
            <div class="col-6 col-md-6">
              <div class="border-gradient border-gradient-second w-100">
                <div class="d-flex justify-content-center align-items-center">
                  <img src="source/red-line.png" class="line-icon mr-10px">
                  <div>
                    แอดตรงผ่านไลน์
                    <p class="mb-0">WINX98</p>
                  </div>
                </div>
                <div class="qr-code-section">
                  <div class="qr-box">
                    <!-- <img src="source/qr-code.png" alt=""> -->
                    <img src="source/qrcode.jpg" alt="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <hr>
      </div>
    </div>
  </section>
  <section class="footer text-center">
    <div class="container">
      <div class="row">
        <p class="footer-detail">
          WEBSITE NAME <?= Ty::get('center_online') ?>
        </p>
        <div class="footer-img">
          <div class="d-flex justify-content-center">
            <div class="text-nowrap">
              <span class="font-16px ml-25px">มั่นคงปลอดภัย <span class="soft-pink-text">100%</span></span>
              <p class="font-12px mb-0">บริการ <span class="soft-pink-text">24</span> ชม. ฝาก-ถอนภายใน <span class="soft-pink-text">1</span> นาที</p>
            </div>
            <img src="source/bank-list.png?v=2" alt="footer" class="ml-20px">
          </div>
          <img src="source/spon1.png?v=2" alt="footer">
          <img src="source/spon2.png" alt="footer">
          <img src="source/spon3.png" alt="footer">
        </div>
      </div>
    </div>
  </section>

  <?php renderFooterLanding($menu_landing); ?>

  <?php Tiwdal::startModal('modal_download_app', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <h5 class="text-center">Select Device</h5>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main event_show_android mx-5px">
      <?= 'Android' ?>
    </button>
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main event_show_ios mx-5px">
      <?= 'IOS' ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('modal_android_download_app', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <img src="assets/images/landing/android_download.png?v=4" class="img-responsive">
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('modal_ios_download_app', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <img src="assets/images/landing/ios_download.png?v=4" class="img-responsive">
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>


  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  ?>

  <script>
    $(document).ready(function() {
      $(document).on('click', '.event_view_load_app', function(e) {
        $('#modal_download_app').modal('show');
      });
      $(document).on('click', '.event_show_android', function(e) {
        $('#modal_android_download_app').modal('show');
      });
      $(document).on('click', '.event_show_ios', function(e) {
        $('#modal_ios_download_app').modal('show');
      });

      $(document).on('click', '#closeModal', function(e) {
        $('.landing-header-download').remove('');
        $('.landing-header-body').css('top', '0px');
        $.cookie("banner_download_landing", "close_landing", {
          expires: 7
        });
      });
    });

    document.addEventListener('click', getLink);

    function getLink(e) {
      if (e.target.closest('div.menu-footer')) {
        const link = e.target.closest('div.menu-footer').getAttribute('link');
        window.location.href = link;
      }
    }
  </script>
</body>

</html>