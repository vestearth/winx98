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

if (!empty($_COOKIE['ref_marketing'])) {
  $ref_marketing = $_COOKIE['ref_marketing'];
} else {
  $ref_marketing = 'z0e380297';
}
$getAlliasRef = nga_management::getAllianceByRefLink($code, $ref_marketing);


if ($is_login) {
  Aww::redirectOG('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  Aww::loadAsset('assets/css/custom.css');
  ?>
  <!-- <link rel="canonical" href="https://mvpshot.com/landing.php"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body>
  <section>
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
    <div class="container-fluid">
      <?php renderBannerLanding(); ?>
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
        <div class="row">
          <div class="col-12">
            <div class="img-intro d-flex justify-content-center w-100 mt-20px">
              <img src="assets/img/first-landing.png" alt="Full Size Banner" class="">
            </div>
          </div>
        </div>
        <div class="features-card-container">
          <div class="features-card-row">
            <div class="features-card-icon">
              <img src="assets/img/deposit-icon.svg" alt="" />
            </div>
            <div class="features-card-content">
              <div class="features-card-title">ฝาก-ถอน 10 วินาที</div>
              <div class="features-card-desc">ระบบอัตโนมัติ รวดเร็วทันใจ</div>
            </div>
          </div>
          <div class="features-card-row">
            <div class="features-card-icon">
              <img src="assets/img/wallet-icon.svg" alt="" />
            </div>
            <div class="features-card-content">
              <div class="features-card-title">จ่ายจริง ได้รับเงินแน่นอน</div>
              <div class="features-card-desc">ยืนยันการชนะทันที ไม่มีล็อคยูส</div>
            </div>
          </div>
          <div class="features-card-row">
            <div class="features-card-icon">
              <img src="assets/img/game-icon.svg" alt="" />
            </div>
            <div class="features-card-content">
              <div class="features-card-title">เกมใหม่ทุกสัปดาห์</div>
              <div class="features-card-desc">อัปเดตจากค่ายเกมชั้นนำ</div>
            </div>
          </div>
          <div class="features-card-row">
            <div class="features-card-icon">
              <img src="assets/img/trophy-icon.svg" alt="" />
            </div>
            <div class="features-card-content">
              <div class="features-card-title">อัตราต่อรอง & คอมฯ ดี</div>
              <div class="features-card-desc">ตอบโจทย์นักเดิมพันกีฬา</div>
            </div>
          </div>
          <div class="features-card-row">
            <div class="features-card-icon">
              <img src="assets/img/lottery-icon.svg" alt="" />
            </div>
            <div class="features-card-content">
              <div class="features-card-title">หวยครบทุกประเภท</div>
              <div class="features-card-desc">หวยไทย หวยต่างประเทศ ที่เดียวครบ</div>
            </div>
          </div>
        </div>

        <div class="jackpot-swiper">
          <div class="d-flex justify-content-center align-items-center mt-20px mb-10px">
            <img src="assets/img/text-customer.svg">
          </div>
          <div class="swiper swiperJackpot">
            <div class="swiper-wrapper">
              <!-- Slide 1 -->
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
              <!-- Slide 2 -->
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
              <!-- Add more slides as needed -->
            </div>
            <!-- Pagination Dots -->
            <div class="swiper-pagination"></div>
          </div>
        </div>

        <div class="example-game-swiper">
          <div class="d-flex justify-content-center align-items-center mt-20px mb-10px">
            <img src="assets/img/example-game-text.svg">
          </div>
          <div class="swiper swiper1">
            <div class="swiper-wrapper">
              <div class="swiper-slide"><img class="example-game-img" src="assets/img/forge-olympus.png" alt="Logo 1"></div>
              <div class="swiper-slide"><img class="example-game-img" src="assets/img/forge-olympus.png" alt="Logo 2"></div>
              <div class="swiper-slide"><img class="example-game-img" src="assets/img/forge-olympus.png" alt="Logo 3"></div>
              <div class="swiper-slide"><img class="example-game-img" src="assets/img/green-chilli.png" alt="Logo 4"></div>
              <div class="swiper-slide"><img class="example-game-img" src="assets/img/green-chilli.png" alt="Logo 5"></div>
              <div class="swiper-slide"><img class="example-game-img" src="assets/img/big-bass.png" alt="Logo 6"></div>
              <div class="swiper-slide"><img class="example-game-img" src="assets/img/big-bass.png" alt="Logo 7"></div>
            </div>
          </div>
          <div class="d-flex justify-content-center align-items-center mt-20px mb-10px">
            <button class="thai-button">ดูเกมทั้งหมด</button>
          </div>
        </div>

        <div class="casino-banner">
          <div class="banner-image">
            <div class="casino-logo"><img src="assets/img/winx98.svg" alt="seo"></div>
            <div class="casino-scene">
              <img src="assets/img/seo-img.png" alt="seo">
            </div>
          </div>

          <div class="banner-content">
            <h2 class="main-title">วิธีเล่นบาคาร่าให้ชนะทุกครั้ง</h2>
            <p class="description">เทคนิคสำคัญที่จะช่วยให้คุณเป็นฝ่ายได้เปรียบในโต๊ะบา...</p>
            <a href="#" class="read-more">
              อ่านต่อ
              <span class="arrow">→</span>
            </a>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="text-center my-25px">
              <img src="assets/img/banner-line.png" alt="suggest-promo" class="img-responsive">
            </div>
          </div>
          <div class="col-12">
            <div class="text-center mb--15px">
              <img src="assets/img/faq.svg" alt="">
            </div>
            <div class="text-center mb-25px">
              <img src="assets/img/faq-th.svg" alt="">
            </div>
            <div class="faq-section">
              <div class="faq-item">
                <div class="faq-question">
                  <span class="arrow">▶</span>
                  <span class="question-text">จับสามารถสมัครสมาชิกได้อย่างไร ?</span>
                </div>
                <div class="faq-answer">
                  <p>คุณสามารถสมัครสมาชิกได้โดยคลิกที่ปุ่ม "สมัครสมาชิก" ที่หน้าหลัก แล้วกรอกข้อมูลส่วนตัวให้ครบถ้วน</p>
                </div>
              </div>

              <div class="faq-item">
                <div class="faq-question">
                  <span class="arrow">▶</span>
                  <span class="question-text">ถอนเงินขั้นต่ำเท่าไหร่ ?</span>
                </div>
                <div class="faq-answer">
                  <p>การถอนเงินขั้นต่ำเริ่มต้นที่ 100 บาท และสามารถถอนได้สูงสุด 50,000 บาทต่อครั้ง</p>
                </div>
              </div>

              <div class="faq-item">
                <div class="faq-question">
                  <span class="arrow">▶</span>
                  <span class="question-text">ใช้เวลาในการฝาก - ถอนนานแค่ไหน ?</span>
                </div>
                <div class="faq-answer">
                  <p>การฝากเงินจะเข้าระบบทันที ส่วนการถอนเงินใช้เวลาประมาณ 1-5 นาทีในการดำเนินการ</p>
                </div>
              </div>

              <div class="faq-item">
                <div class="faq-question">
                  <span class="arrow">▶</span>
                  <span class="question-text">มีเคมจากค่ายไหนบ้าง ?</span>
                </div>
                <div class="faq-answer">
                  <p>เรามีเกมจากค่ายชั้นนำมากมาย เช่น PG Soft, Pragmatic Play, Joker Gaming, Live22 และอีกมากมาย</p>
                </div>
              </div>

              <div class="faq-item">
                <div class="faq-question">
                  <span class="arrow">▶</span>
                  <span class="question-text">ติดต่อทีมงานอย่างไร ?</span>
                </div>
                <div class="faq-answer">
                  <p>สามารถติดต่อทีมงานได้ผ่าน Live Chat 24 ชั่วโมง หรือ Line ID: @support</p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="text-center my-25px">
              <img src="assets/img/condition-web.svg" alt="">
            </div>
            <ul class="thai-list">
              <li>ผู้เล่นต้องมีอายุ 18 ปีบริบูรณ์ขึ้นไปเท่านั้น</li>
              <li>ข้อมูลส่วนบุคคลต้องเป็นความจริงและครบถ้วน</li>
              <li>การฝาก - ถอนทุกรายการต้องผ่านระบบกำหนดเท่านั้น</li>
              <li>การใช้งานต้องปฏิบัติตกฎหมายที่องค์มมองผู้เล่น</li>
              <li>บริบักสงวนสิทธิ์ในการปรับเปลี่ยนข้อกำหนดโดยไม่ต้องแจ้งล่วงหน้า</li>
            </ul>
          </div>
        </div>
        <div class="intro">
          <div class="row mt-30px">
            <div class="col-lg-12">
              <div class="d-flex justify-content-center align-items-center promote-auto">
                <img src="assets/img/promote-auto.png" class="">
              </div>
            </div>
          </div>
          <div class="intro2">
            <div class="d-flex justify-content-center">
              <img src="assets/img/winx98x2.svg" alt="">
            </div>
            <span class="content text-center">
              WinX98 เจ้าแรกในไทย ให้บริการผ่านเว็บตรง ที่มี
              เกมสล็อตมากกว่า 1,000 เกมกับ 21 ค่ายชื่อดัง รวมเกม
              แตกบ่อย ที่หลายเว็บไม่มีให้เล่น ทุกอย่างครบจบภายใน
              กระเป๋าเดียว ไม่ต้องโยกเงินให้เสียเวลา ระบบอัตโนมัติทุก
              ขั้นตอน สมัครสมาชิก ฝาก -ถอนไว ใช้เวลาทำธุรกรรม
              เพียง 3 วินาที รับฟรีสิทธิพิเศษสำหรับลูกค้า
            </span>
          </div>
          <div class="menu-additional">
            <img src="assets/img/winx98-line.png" alt="line" class="img-responsive">
          </div>
          <div class="my-25px">
            <img src="assets/img/sponsor-game.svg" alt="">
          </div>

          <div class="sponsor-game-swiper">
            <div class="swiper swiper2">
              <div class="swiper-wrapper">
                <div class="swiper-slide"><img class="spon-img" src="assets/img/sponsor-game/amb.svg" alt="Logo A"></div>
                <div class="swiper-slide"><img class="spon-img" src="assets/img/sponsor-game/gameplay.svg" alt="Logo B"></div>
                <div class="swiper-slide"><img class="spon-img" src="assets/img/sponsor-game/sa.svg" alt="Logo C"></div>
                <div class="swiper-slide"><img class="spon-img" src="assets/img/sponsor-game/pg.svg" alt="Logo D"></div>
                <div class="swiper-slide"><img class="spon-img" src="assets/img/sponsor-game/sbo.svg" alt="Logo E"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="footer text-center">
    <div class="container">
      <div class="row">
        <div class="footer-detail text-center">
          <span>
            WinX98 ดำเนินการโดย<br>
            Omega Sports Solutions N.V.
          </span>
          <p class="font-gold">
            WinX98 ได้รับอนุญาตและอยู่ภายใต้การกำกับดูแลของ<br>
            Curacao Gaming Control Board<br>
            สงวนลิขสิทธิ์โดย WinX98
          </p>
          <p class="mb-0">
            Curacao Gaming Control Board
          </p>
          <hr>
        </div>
        <div class="footer-img">
          <div class="d-flex justify-content-center">
            <div class="text-nowrap">
              <span class="font-16px ml-25px">มั่นคงปลอดภัย <span class="soft-pink-text">100%</span></span>
              <p class="font-12px mb-0">บริการ <span class="soft-pink-text">24</span> ชม. ฝาก-ถอนภายใน <span class="soft-pink-text">1</span> นาที</p>
            </div>
            <img src="source/bank-list.png?v=2" alt="footer" class="ml-20px">
          </div>
        </div>
      </div>
    </div>
  </section>


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
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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

      const swiper = new Swiper('.swiperJackpot', {
        slidesPerView: 3,
        spaceBetween: 16,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        loop: true,
        autoplay: {
          delay: 3000,
          disableOnInteraction: false
        },
        breakpoints: {
          0: {
            slidesPerView: 1
          },
          992: {
            slidesPerView: 3
          }
        }
      });

      const swiper1 = new Swiper('.swiper1', {
        slidesPerView: 2.5,
        spaceBetween: 20,
        breakpoints: {
          0: {
            slidesPerView: 2.5
          },
          992: {
            slidesPerView: 4
          }
        }
      });
      // Initialize second swiper
      const swiper2 = new Swiper('.swiper2', {
        slidesPerView: 1.5,
        spaceBetween: 20,
        loop: true,
        autoplay: {
          delay: 3000
        },
        breakpoints: {
          0: {
            slidesPerView: 1.5
          },
          992: {
            slidesPerView: 4
          }
        }
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