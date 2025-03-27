<?php
require_once '.framework/import.php';
$system_line  = nga_management::getGeneralWebsite($code);
$menu_landing = [
  [
    'image' => 'assets/icon/menu_landing/home.svg',
    'title' => Ty::get('home'),
    'url'   => 'index.php',
  ],
  [
    'image' => 'assets/icon/menu_landing/register.svg',
    'title' => Ty::get('register'),
    'url'   => 'signup.php',
  ],
  [
    'image' => 'assets/icon/menu_landing/login.svg',
    'title' => Ty::get('playgame'),
    'url'   => 'login.php',
  ],
  [
    'image' => 'assets/icon/menu_landing/contact.svg',
    'title' => Ty::get('contact_us'),
    'url'   => 'landing.php',
    'link'  => $system_line['line_link'],
  ],
];
$banner_download_landing = (isset($_COOKIE['banner_download_landing']) && $_COOKIE['banner_download_landing']) ? $_COOKIE['banner_download_landing'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
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
      <div class="row">
        <div class="hide-mobile">
          <div class="d-flex align-items-center justify-content-between py-10px">
            <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo" class="w-90px">
            <div class="d-flex align-items-center">
              <a href="login.php" class="btn-parallelogram-pink  w-200px text-center mr-10px"><?= Ty::get('login') ?></a>
              <a href="signup.php" class="btn-parallelogram-pink  w-200px text-center "><?= Ty::get('register') ?></a>
            </div>
          </div>
        </div>
        <div class="show-mobile">
          <div class="logo">
            <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo">
          </div>
        </div>
      </div>
      <div class="girl">
        <img src="assets/images/landing/girl-01.webp?v=2">
      </div>
      <div class="detail">
        <h1>ALL in One <span class="text-pink">bet</span> </h1>
        <p>
          <?= Ty::get('sign_bonus') ?>
        </p>
        <a href="signup.php" class="btn-parallelogram-pink mt-25px w-100 arrow"><?= Ty::get('register') ?></a>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="content-img">
            <img src="assets/images/landing/content-01.webp?v=2" alt="">
          </div>
        </div>
        <div class="col-md-6 pt-30px my-auto">
          <div class="detail">
            <p class="font-22px mb-5px"><?= Ty::get('onlinebet') ?></p>
            <p class="font-22px text-pink  mb-5px"> <?= Ty::get('autodeposit') ?></p>
            <p>
              <?= Ty::get('sign_now') ?>
            </p>
          </div>
          <div class="list-content">
            <div class="list-content-item">
              <img src="assets/images/landing/neon-card.svg" alt="">
              <p><?= Ty::get('auto_syst') ?></p>
            </div>
            <div class="list-content-item">
              <img src="assets/images/landing/neon-coin.svg" alt="">
              <p><?= Ty::get('vip_service') ?></p>
            </div>
            <div class="list-content-item">
              <img src="assets/images/landing/neon-slot.svg" alt="">
              <p><?= Ty::get('profession') ?></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="game text-center">
    <div class="container">
      <div class="row flex-column">
        <h2 class="text-pink mt-30px"><?= Ty::get('allbetting') ?></h2>
        <p> <?= Ty::get('easyplay') ?></p>
        <div class="list-game">
          <div class="list-game-items game-01">
            <p><?= Ty::get('cardmillionaire') ?></p>
          </div>
          <div class="list-game-items game-02">
            <p><?= Ty::get('boardgames') ?></p>
          </div>
          <div class="list-game-items game-03">
            <p><?= Ty::get('slots') ?></p>
          </div>
          <div class="list-game-items game-04">
            <p><?= Ty::get('landofarcade') ?></p>
          </div>
          <div class="list-game-items game-05">
            <p><?= Ty::get('onlinefishing') ?></p>
          </div>
          <div class="list-game-items game-06">
            <p><?= Ty::get('sport') ?></p>
          </div>
          <div class="list-game-items game-07">
            <p><?= Ty::get('onlinecasino') ?></p>
          </div>
          <div class="list-game-items game-08">
            <p><?= Ty::get('lottery') ?></p>
          </div>
          <div class="list-game-items game-09">
          </div>
        </div>
        <a href="login.php" class="btn-parallelogram-pink mt-25px arrow mx-auto"><?= Ty::get('tryforfree') ?></a>
      </div>
    </div>
  </section>
  <section class="footer text-center mb-30px">
    <div class="container">
      <div class="row">
        <div class="logo">
          <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo">
        </div>
        <p class="footer-detail">
          WEBSITE NAME <?= Ty::get('center_online') ?>
        </p>
        <div class="footer-img">
          <img src="assets/images/landing/footer-01.webp?v=2" alt="footer">
          <img src="assets/images/landing/footer-02.webp?v=2" alt="footer">
          <img src="assets/images/landing/footer-03.webp?v=2" alt="footer">
          <img src="assets/images/landing/footer-04.webp?v=2" alt="footer">
        </div>
      </div>
    </div>
  </section>
  <div class="footer-landing">
    <div class="row-items">
      <?php foreach ($menu_landing as $key => $footer) { ?>
        <?php if (isset($footer['link']) && $footer['link']) { ?>
          <a href="<?= $footer['link'] ?>" target="_blank" class="underline-unset">
            <div class="items">
              <div class="icon-box">
                <img src="<?= $footer['image'] ?>">
              </div>
              <div class="title"><?= $footer['title'] ?></div>
            </div>
          </a>
        <?php } else { ?>
          <a href="<?= $footer['url'] ?>" class="underline-unset">
            <div class="items">
              <div class="icon-box">
                <img src="<?= $footer['image'] ?>">
              </div>
              <div class="title"><?= $footer['title'] ?></div>
            </div>
        <?php }
      } ?>
    </div>
  </div>

  <!-- backup footer  -->
  <?php /* 
<footer class="max-w-375px footer-landing">
    <div class="row align-self-center">
      <?php foreach ($menu_landing as $key => $footer) {?>
        <div class="col px-0">
          <?php if (isset($footer['link']) && $footer['link']) {?>
            <a class="menu-footer" target="_blank" href="<?=$footer['link']?>">
              <div class="icon-footer">
                <img src="<?=$footer['image']?>" alt="">
              </div>
              <div class="text"><?=$footer['title']?></div>
            </a>
          <?php } else {?>
            <div class="menu-footer" link="<?=$footer['url']?>">
              <div class="icon-footer">
                <img src="<?=$footer['image']?>" alt="">
              </div>
              <div class="text"><?=$footer['title']?></div>
            </div>
          <?php }?>
        </div>
      <?php }?>
    </div>
  </footer>

*/ ?>

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