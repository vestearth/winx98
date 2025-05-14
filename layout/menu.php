<?php
require_once 'layout/navbanner.php';
if ($_POST) {
  if (isset($_POST['submit_logout'])) {
    $result = User::logout();
    unset($_SESSION['check_first']);
    session_unset();
    session_destroy();
  } else if (isset($_POST['language_value'])) {
    if ($_POST['language_value'] == 'th') {
      Ty::setLg('en');
    } else {
      Ty::setLg('th');
    }
    Aww::redirect('');
  }
  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};
$count_notification = isset($notification) ? count($notification) : 0;
$user_data = User::getCurrent();

$this_page = isset($this_page) ? 'index' : '';

$domain = $_SERVER['HTTP_HOST'];
$telegramChannels = array(
  "masanook.com" => "https://t.me/+jnMkSbT9RdIxNGZl",
  "lucky-royal.com" => "https://t.me/+IZigR_I3tspkNzQ1",
  "mvpshot.com" => "https://t.me/+V8kbibFOnjg0YmY1",
  "localhost:8100" => '#',
);
$telegram_domain = '';
foreach ($telegramChannels as $channelDomain => $channelUrl) {
  if ($domain == $channelDomain) {
    $telegram_domain = $channelUrl;
    break;
  }
}


$menu_sub = [
  [
    'image' => 'assets/images/profile.png',
    'title' => Ty::get('home'),
    'url' => 'index.php',
    'is_mobile' => false
  ],
  [
    'image' => 'assets/icon/menu/money_bag.svg',
    'title' =>  Ty::get('profile'),
    'url' => 'user.php',
    'is_mobile' => false
  ],
  [
    'image' => 'assets/icon/menu/promotion.svg',
    'title' => Ty::get('promotions'),
    'url' => 'promotion.php',
    'count' => $count_notification,
    'is_mobile' => true
  ],
  [
    'image' => 'assets/icon/menu/refund.svg',
    'title' => Ty::get('lossreturn'),
    'url' => 'refund.php',
    'is_mobile' => true
  ],
  [
    'image' => 'assets/icon/menu/earning.svg',
    'title' => Ty::get('earnmoney'),
    'url' => 'earning.php',
    'is_mobile' => true
  ],
  [
    'image' => 'assets/icon/menu/event.svg',
    'title' => Ty::get('event'),
    'url' => 'event.php',
    'is_mobile' => true
  ],
  [
    'image' => 'assets/icon/menu/rewards.svg',
    'title' => Ty::get('rewards'),
    'url' => 'rewards.php',
    'is_mobile' => false
  ],
  [
    'image' => 'assets/icon/menu/purple-line.svg',
    'title' => Ty::get('website'),
    // 'url' => $system_line['line_link'],
    'url' => 'winx.com',
    'is_mobile' => true
  ],
  [
    'image' => 'assets/icon/menu/purple-telegram.svg',
    'title' => Ty::get('telegram-contact'),
    'url' => $telegram_domain,
    'is_mobile' => false
  ],
  [
    'image' => 'assets/icon/menu/comment.svg',
    'title' => Ty::get('comment'),
    'url' => 'comment.php',
    'is_mobile' => false
  ],
];

$menu_footer = [
  [
    'image' => 'assets/icon/menu/home.svg',
    'title' => Ty::get('home'),
    'url' => 'index.php',
  ],
  [
    'image' => 'assets/icon/menu/money_bag.svg',
    'title' => Ty::get('profile'),
    'url' => 'user.php',
  ],
  [
    'image' => 'assets/icon/menu/game_logo.png',
    'title' => Ty::get('playgame'),
    'url' => 'games.php',
  ],
  [
    'image' => 'assets/icon/menu/line_purple.svg',
    'title' => Ty::get('website'),
    // 'url' => $system_line['line_link'],
    'url' => 'winx.com',
  ],
  [
    'image' => 'assets/icon/menu/comment.svg',
    'title' => Ty::get('comment'),
    'url' => 'comment.php',
  ],
];
$banner_download_web = (isset($_COOKIE['banner_download_web']) && $_COOKIE['banner_download_web']) ? $_COOKIE['banner_download_web'] : null;
$lhb_style = 'style-web-close-banner';

?>
<?php
if (!$banner_download_web) { ?>
  <div class="landing-header-download">
    <div class="pos-rel">
      <div class="app-close pos-ab">
        <button type="button" class="custom-btn-top-close" id="closeModalWeb">
          <?= file_get_contents('assets/icon/cross.svg') ?>
        </button>
      </div>
      <img src=" assets/images/landing/app_banner.png?gen=<?= rand(0.1, 1111); ?>" class="event_view_load_app" alt="logo">
    </div>
  </div>
<?php } else {
  // landing-header-body stype top:0px
  $lhb_style = 'style-web-close-banner';
} ?>

<div class="container position-relative custom-header-layout <?= $lhb_style; ?> <?= ($this_page) ? 'index-container' : ''; ?>">
  <div class="hamburger" onclick="menuToggle(this)">
    <div></div>
    <div></div>
    <div></div>
  </div>
  <div class="row header-mobile position-relative">
    <?php if (!isset($page)) { ?>
      <img src="assets/images/arrow-left.png" class="arrow-left" onclick="backHistory()">
    <?php } ?>
    <?php renderBannerBorder($user_data['money_balance']); ?>
  </div>
  <div class="header-web <?= $this_page ?>">
    <?php renderBannerBorder($user_data['money_balance']); ?>
    <?php /* 
    <div class="container-menu">
      <div class="logo cursor-pointer" data-link="index.php" onclick="redirectHref()">
        <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo">
      </div>
      <ul class="nav-menu">
        <li class="nav-link preloader-link" data-link="index.php" onclick="redirectHref()"><?= Ty::get('home') ?></li>
        <li class="nav-link preloader-link" data-link="user.php" onclick="redirectHref()"><?= Ty::get('profile') ?></li>
        <li class="nav-link preloader-link" data-link="<?= $system_line['line_link']; ?>" onclick="redirectHref()"><?= Ty::get('website') ?></li>
        <li class="nav-link preloader-link" data-link="comment.php" onclick="redirectHref()"><?= Ty::get('comment') ?></li>
      </ul>
      <div class="renew-header">
        <div class="menu-card-main">
          <div class="menu-card-body">
            <div class="d-flex justify-content-between align-items-center text-white text-nowrap">
              <span class="title"><?= Ty::get('walletbalance') ?></span>
              <span class="ml-25px amount">฿ <?= number_format($user_data['money_balance'], 2); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="game-play ml-10px" data-link="games.php" onclick="redirectHref()">
        <div class="play">
          <div class="btn-body" data-link="index.php" onclick="redirectHref()">
            <div class="label"><?= Ty::get('playgame') ?></div>
          </div>
        </div>
      </div>
      <form action="" method="post" class="d-flex align-items-center">
        <input type="hidden" name="language_value" value="<?= Ty::getLg() ?>">
        <button class=" btn btn-lang border-0" type="submit">
          <img src="assets/icon/lang.svg" alt="">
        </button>
      </form>
    </div>
    */ ?>
  </div>
</div>


<div class="menu" id="menu">
  <div class="container max-w-375px position-relative h-100">
    <form action="" method="post" class="d-flex align-items-center">
      <input type="hidden" name="language_value" value="<?= Ty::getLg() ?>">
      <button class=" btn btn-lang border-0" type="submit">
        <img src="assets/icon/lang.svg" alt="">
      </button>
    </form>
    <div class="row">
      <div class="logo">
        <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo">
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="d-flex justify-content-center align-items-center mb-15px">
          <lottie-player src="assets/images/lottie/pink_arrow.json" class="arrow-move" background="transparent" speed="1" loop autoplay></lottie-player>
          <div class="menu-item border w-160px mx-15px" link="deposit.php">
            <img src="assets/icon/menu/deposit.svg" alt="deposit">
            <span><?= Ty::get('deposit') ?></span>
          </div>
          <lottie-player src="assets/images/lottie/pink_arrow.json" class="arrow-move flip" background="transparent" speed="1" loop autoplay></lottie-player>
        </div>
        <div class="d-flex justify-content-center align-items-start mb-15px">
          <div class="menu-frame">
            <div class="menu-item preloader-link" link="withdraw.php">
              <img src="assets/icon/menu/withdraw.svg" alt="withdraw">
            </div>
            <span class="font-14px"><?= Ty::get('withdraw') ?></span>
          </div>
          <div class="menu-frame mx-10px">
            <div class="menu-item w-160px preloader-link" link="games.php">
              <img src="assets/icon/menu/game_logo.png" alt="game" class="zoom-img-2point">
            </div>
            <span class="font-16px"><?= Ty::get('playgame') ?></span>
          </div>
          <div class="menu-frame">
            <div class="menu-item preloader-link" link="user.php">
              <img src="assets/icon/menu/money_bag.svg" alt="profile">
            </div>
            <span class="font-14px"><?= Ty::get('profile') ?></span>
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row-sub-menu">
          <?php foreach ($menu_sub as $key => $menu_sub_list) { ?>
            <div class="menu-frame col-sub-menu <?= $key == 1 ? 'd-none' : '' ?>">
              <div class="menu-item preloader-link" link="<?= $menu_sub_list['url'] ?>">
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
              <span class="font-12px"><?= $menu_sub_list['title'] ?></span>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <button class="btn btn-logout bottom" <?php Tiwdal::register('modal_logout', []); ?>>
      <?= Ty::get('Logout') ?>
    </button>
  </div>
</div>

<div class="preloader">
  <div class="loader"></div>
</div>

<?php Tiwdal::startModal('modal_logout', 'modal-sm modal-no-more modal-dialog-centered m-auto'); ?>
<form method="post">
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <div class="text-center mt-10px">
      <span class="text-danger font-20px font-SemiBold">
        <?= Ty::get('Logout') ?>
      </span>
      <p class="mb-0 font-16px mt-25px"><?= Ty::get('want_logout') ?></p>
    </div>
  </div>
  <div class="modal-footer">
    <button class="btn btn-logout h-40px" name="submit_logout"><?= Ty::get('Logout') ?></button>
  </div>
</form>
<?php Tiwdal::endModal() ?>




<script>
  function redirectHref() {
    window.location.href = event.currentTarget.dataset.link;
  }

  function backHistory() {
    window.history.back();
  }
  document.addEventListener('click', getLink);

  function getLink(e) {
    if (e.target.closest('.menu-item')) {
      const link = e.target.closest('.menu-item').getAttribute('link');
      window.location.href = link;
    }
    if (e.target.closest('.menu-footer')) {
      const link = e.target.closest('.menu-footer').getAttribute('link');
      window.location.href = link;
    }
  }
</script>