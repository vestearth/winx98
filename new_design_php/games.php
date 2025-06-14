<?php
require_once '../.framework/import.php';
require_once 'layout/footer_nav.php';
require_once 'layout/navbanner.php';

$type_game = [
  [
    'name' => Ty::get('slotgames'),
    'img'  => 'assets/images/games/type_slot.png'
  ],
  [
    'name' => Ty::get('card_game'),
    'img' => 'assets/images/games/type_card.png'
  ],
  [
    'name' => Ty::get('sport'),
    'img' => 'assets/images/games/type_sport.png'
  ],
  [
    'name' => Ty::get('lottery'),
    'img' => 'assets/images/games/type_lotto.png'
  ],
  [
    'name' => Ty::get('trading'),
    'img' => 'assets/images/games/type_trading.png'
  ],
];
$type_game_template = [
  'HITGAME' => [
    'name' => 'เกมฮิต',
    'typeName' => 'HITGAME',
    'img' => 'assets/img/icon/hit-game.png',
    'ordering' => 1
  ],
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
// if ($get_game_setting['is_open_sport_game'] == 0 && $get_game_setting['is_open_sportbook_game'] == 0) {
//   unset($type_game_template['SPORTBOOK']);
// }
if ($get_game_setting['is_open_lotto'] == 0) {
  unset($type_game_template['LOTTO']);
}

if ($get_game_setting['is_open_sportbook_game'] == 0) {
  // unset($type_game_template['SOCCER']);
  unset($type_game_template['SPORTBOOK']);
}

$temp_type = '';
foreach ($type_game_template as $key => $value) {
  if (!$temp_type) {
    $temp_type = $key;
    break;
  }
}
$type = isset($_GET['type']) ? $_GET['type'] : $temp_type;
if (!isset($type_game_template[$type])) {
  $type = $temp_type;
}
$firm = isset($_GET['firm_name']) ? $_GET['firm_name'] : '';
$user_data = User::getCurrent();

if (empty($firm) && $type) {
  $data = [
    'user_id' => $user_data['id'],
    'detail' => 'เข้าหน้าเข้าเล่นเกม',
  ];
  $user_log = nga_user::addNewUserLog($code, $data);
} else if ($firm && $type) {
  $data = [
    'user_id' => $user_data['id'],
    'detail' => 'หน้าเข้าเล่นเกม หมวด ' . $type . ' ค่าย ' . $firm,
  ];
  $user_log = nga_user::addNewUserLog($code, $data);
}

if ($_POST) {
  if (isset($_POST['submit_select_game'])) {
    $data = [
      'product_id' => $_POST['product_id'],
      'game_type' => $_POST['game_type'],
      'game_code' => $_POST['game_code'],
    ];
    $result =  nga_api_seamless::loginMemberSession($code, $data);
    if ($result['response_status']) {
      $data = [
        'user_id' => $user_data['id'],
        'detail' => 'เข้าเล่นเกม ' . $_POST['game_type'] . ' ' . $_POST['product_id'] . ' ' . $_POST['game_code'],
      ];
      $user_log = nga_user::addNewUserLog($code, $data);
      Aww::redirect($result['response_data']['url']);
      // }
    } else {
      Aww::redirect('');
    }
  }
  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

if ($firm) {
  $select_game = nga_api_seamless::selectGameListByProductIDAndType($code, $firm, $type);
} else {
  if ($type == 'HITGAME') {
    $type = 'CASINOLIVE'; // Default to SLOT for HITGAME
  }
  $game_group = nga_api_seamless::selectProductIDByType($code, $type);
}

$system_line =  nga_management::getGeneralWebsite($code);
$alliance_data = nga_management::getAllianceByID($code, $user_data['alliance_id']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  Aww::loadAsset('assets/css/custom.css');
  ?>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
</head>

<body>
  <?php include 'layout/winx98_bg.php'; ?>
  <?php renderBannerUser(); ?>

  <div class="container position-relative">
    <div class="row">
      <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item">
              <a href="index.php" class="preloader-link"><?= Ty::get('home') ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('join_game') ?></li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-12">

        <div class="game-slider d-none">
          <swiper-container id="gameSlider" class="mySwiper" slides-per-view="2" navigation="true" space-between="10" free-mode="true" clickable="true">
            <?php foreach ($type_game_template as $key => $type_games) { ?>
              <swiper-slide class="<?= $key == $type ? 'swiper-slide-active' : '' ?>">
                <div class="game-item">
                  <img src="<?= $type_games['img'] ?>" alt="Game 1">
                  <span><?= $type_games['name']; ?></span>
                </div>
              </swiper-slide>
            <?php } ?>
          </swiper-container>
        </div>

      </div>
      <div class="col-md-12">

        <div class="game-menu-responsive show-on-desktop mt-100px">
          <div class="game-menu-group">
            <?php
            // Sort the $type_game_template array by the 'ordering' key in ascending order
            // usort($type_game_template, function ($a, $b) {
            //   return $a['ordering'] <=> $b['ordering'];
            // });

            foreach ($type_game_template as $key => $type_games) {
            ?>
              <a href="?type=<?= $key; ?>" class="<?= $key == $type ? 'active' : '' ?> preloader-link text-decoration-none">
                <div class="game-category-item">
                  <div class="game-category-card mr-15px">
                    <img src="<?= $type_games['img'] ?>" alt="Fish Game" class="game-category-image">
                  </div>
                  <span class="game-category-label"><?= $type_games['name'] ?></span>
                </div>
              </a>
            <?php } ?>
          </div>
        </div>

        <!-- <div class="game-menu-group row pt-0"> -->
        <?php //foreach ($type_game_template as $key => $type_games) { 
        ?>
        <!-- <div class="col-3 mt-10px"> -->
        <div class="game-menu-responsive show-on-mobile mt-50px">
          <div class="game-menu-group row pt-0 flex-nowrap overflow-auto" style="flex-wrap: nowrap; overflow-x: auto; -webkit-overflow-scrolling: touch;">
            <?php foreach ($type_game_template as $key => $type_games) { ?>
              <div class="col-md-3 col-2 mt-10px px-5px" style="flex: 0 0 auto;">
                <a href="?type=<?= $key; ?>" class="<?= $key == $type ? 'active' : '' ?> preloader-link text-decoration-none">
                  <div class="game-category-item">
                    <div class="game-category-card mr-15px">
                      <img src="<?= $type_games['img'] ?>" alt="Fish Game" class="game-category-image">
                    </div>
                    <span class="game-category-label"><?= $type_games['name'] ?></span>
                  </div>
                </a>
              </div>
            <?php } ?>
          </div>
        </div>

      </div>
      <?php if (!$firm) {
        if ($type != 'LOTTO' && $type != 'SOCCER') {
      ?>
          <div class="col-md-12">
            <div class="text-white">
              <div class="row mb-100px mx-auto" style="max-width: 700px;">
                <?php
                $game_no = 1;
                $game_list = array(
                  "JILI",
                  "SPINIX",
                  "UPG",
                  "ASKMEBET",
                  "PGSOFT2",
                  "WMSLOT",
                  "MANNA",
                  "AGGAME",
                  "REDTIGER",
                  "DRAGONGAMING",
                  "ALLBET",
                  "AMBPOKER",
                  "BETGAME",
                  "CQ9V2",
                  "KINGMAKER2",
                  "MICRO",
                  "SIMPLEPLAY",
                  "918KISS",
                  "ACE333",
                  "AMBSLOT2",
                  "AMEBA",
                  "DREAM2",
                  // "EBET",
                  "EVOPLAY",
                  // "FUNKY",
                  "JOKER",
                  "NETENT2",
                  "NINJA",
                  "PRETTY",
                  "SAGAME",
                  "SLOTXO",
                  "SPADE",
                  "SEXY",
                  "XTREME",
                  "YGGDRASIL",
                  "COCKFIGHT",
                  "PRAGMATIC_LIVECASINO",
                  "PRAGMATIC_SLOT",
                  // "CG",
                );
                // if ($type != 'SPORT') {
                foreach ($game_group as $key => $game) {
                  $condition_key = $key + 1;
                  $loading = ($condition_key >= 2) ? 'eager' : 'lazy';
                  $col = ($game_no % 2 == 0) ? 'col-md-3 col-6' : 'col-md-3 col-6';
                  $game_img_webp = 'assets/images/firm_cover/' . $game . '/' . $game . '.webp';
                  $game_img_png = 'assets/images/firm_cover/' . $game . '/' . $game . '.png';
                  // $game_img_webp = "";
                  // $game_img_png = "";
                  $forForceCSS = '';
                  // Check if the image file exists, use mockup image if not
                  if (file_exists($game_img_png)) {
                    $game_img = $game_img_png;
                    $forForceCSS = 'custom-cover-firm';
                  } else if (file_exists($game_img_webp)) {
                    $game_img = $game_img_webp;
                  } else {
                    $game_img = 'assets/images/firm_game/DEFAULT.webp';
                    $forForceCSS = 'set-mockup-img';
                  }
                ?>
                  <div class="<?= $col; ?>">
                    <div class="w-100 d-flex justify-content-center">
                      <div class="firm-game-list-img even_firm_lists cursor-pointer mb-10px <?= $forForceCSS; ?>" firm_name="<?= $game; ?>">
                        <img src="<?= $game_img; ?>" class="img-responsive" loading="<?= $loading; ?>" alt="<?= $game; ?>">
                        <?php if ($forForceCSS) { ?>
                          <div class="txt-preview">
                            <?= $game; ?>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                <?php
                }
                // }
                ?>
                <?php /* if ($type == 'SPORT' && $get_game_setting['is_open_sportbook'] == 1) {
                  $soccer_callback = nga_api_seamless_sbobet::loginSbobetSession($code);
                  $soccer_data = isset($soccer_callback['response_data']) ? $soccer_callback['response_data'] : [];
                ?>
                  <div class="col-6 pl-0">
                    <div class="w-100 d-flex justify-content-center">
                      <a href="<?= $soccer_data['url'] ?>" class="preloader-link">
                        <div class="firm-game-list-img cursor-pointer">
                          <img src="assets/images/firm_game/<?= 'soccer'; ?>.webp?v=2" class="img-responsive" loading="<?= 'lazy'; ?>">
                        </div>
                      </a>
                    </div>
                  </div>
                <?php } */ ?>
              </div>
            </div>
          </div>
        <?php } else if ($type == 'LOTTO') {
          $lotto_callback = nga_api_lotto_seamless::loginLottoMember($code, $user_data['id']);
          $lotto_call = isset($lotto_callback['response_data']) ? $lotto_callback['response_data'] : [];
          $lotto_data = isset($lotto_call['data']) ? $lotto_call['data'] : [];
        ?>
          <div class="col-md-12">
            <div class="row text-white">
              <div class="col-6">
                <div class="w-100 d-flex justify-content-center">
                  <a href="<?= $lotto_data['urlFullPage'] ?>" target="_blank" class="preloader-link">
                    <div class="firm-game-list-img cursor-pointer">
                      <img src="assets/images/firm_game/<?= 'lotto'; ?>.webp" class="img-responsive" loading="<?= 'lazy'; ?>">
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php } else if ($type == 'SOCCER') {
          $soccer_callback = nga_api_seamless_sport::loginMemberSport($code, $user_data['id']);
          $soccer_data = isset($soccer_callback['response_data']) ? $soccer_callback['response_data'] : [];
        ?>
          <div class="col-md-12">
            <div class="row text-white">
              <div class="col-6">
                <div class="w-100 d-flex justify-content-center">
                  <a href="<?= $soccer_data['url'] ?>" class="preloader-link">
                    <div class="firm-game-list-img cursor-pointer">
                      <img src="assets/images/firm_game/<?= 'soccer'; ?>.webp" class="img-responsive" loading="<?= 'lazy'; ?>">
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      <?php } else { ?>
        <div class="col-md-12">
          <?php
          $popular_game_list = array(
            "Fortune Dragon",
            "Dragon Hatch2",
            "Werewolf's Hunt",
            "Tsar Treasures",
            "Mafia Mayhem",
            "Forge of Wealth",
          );
          $show_header = false;
          foreach ($select_game as $key => $game_list) {
            $feature_game[$game_list['name']] = $game_list;
            if (in_array($game_list['name'], $popular_game_list)) {
              $show_header = true;
            }
          }
          ?>
          <div class="text-white">
            <?php if ($show_header) { ?>
              <div class="text-gold mb-10px">เกมใหม่ยอดนิยม</div>
            <?php } ?>
            <div class="row">
              <?php
              foreach ($popular_game_list as $key => $game_name) {
                if (isset($feature_game[$game_name])) {
                  $game_list = $feature_game[$game_name];

                  if (isset($game_list['webp_path']) && $game_list['webp_path'] != '') {
                    $game_image = $game_list['webp_path'];
                  } else {
                    $game_image = $game_list['img'];
                  }
                  $game_image = $game_list['img'];
              ?>
                  <div class="col-lg-2 col-4 mb-5px">
                    <div class="w-100 d-flex justify-content-center">
                      <div class="game-list-img even_game_lists cursor-pointer" product_id="<?= $game_list['product_id'] ?>" game_type="<?= $game_list['type'] ?>" game_code="<?= $game_list['code'] ?>">
                        <img src="<?= $game_image; ?>" class="img-responsive" loading="lazy" alt="<?= $game_list['product_id']; ?>">
                      </div>
                    </div>
                    <p class="game-name"><?= $game_list['name']; ?></p>
                  </div>
              <?php }
                // }
              }
              ?>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="text-white">
            <div class="text-gold mb-10px">เกมทั้งหมด</div>
            <div class="row">
              <?php foreach ($select_game as $key => $game_list) {

                $condition_key = $key + 1;
                $loading = ($condition_key >= 4) ? 'eager' : 'lazy';
                // if (isset($game_list['webp_path']) && $game_list['webp_path'] != '') {
                //   $game_image = $game_list['webp_path'];
                // } else {
                //   $game_image = $game_list['img'];
                // }
                $game_image = $game_list['img'];

                $avoid_game_list = [
                  'Baccarat Deluxe'
                ];
                if (in_array($game_list['name'], $avoid_game_list)) {
                  continue;
                }
              ?>
                <div class="col-lg-2 col-4 mb-5px">
                  <div class="w-100 d-flex justify-content-center">
                    <div class="game-list-img even_game_lists cursor-pointer" product_id="<?= $game_list['product_id'] ?>" game_type="<?= $game_list['type'] ?>" game_code="<?= $game_list['code'] ?>">
                      <img src="<?= $game_image; ?>" class="img-responsive" loading="lazy" alt="<?= $game_list['product_id']; ?>">
                    </div>
                  </div>
                  <p class="game-name"><?= $game_list['name']; ?></p>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="my-50px"></div>
  <?php renderFooterNav(); ?>

  <div class="scope_firm_form d-none">
    <form method="get">
      <input type="hidden" name="firm_name" class="scope_firm_name" value="<?= $firm; ?>">
      <input type="hidden" name="type" class="scope_category_game" value="<?= $type; ?>">
      <button class="scope_submit_select_firm">submit</button>
    </form>
  </div>

  <div class="scope_form d-none">
    <form method="post">
      <input type="hidden" name="product_id" class="scope_product_id">
      <input type="hidden" name="game_type" class="scope_game_type">
      <input type="hidden" name="game_code" class="scope_game_code">
      <button class="scope_submit_select_game" name="submit_select_game"></button>
    </form>
  </div>

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/main.js');
  Aww::loadAsset('assets/js/jquery.mousewheel.min.js');
  ?>
</body>

</html>

<script>
  // function showPreloader() {
  //   var preloader = document.querySelector(".preloader");
  //   preloader.style.display = "flex"; // Show the preloader
  // }

  // function hidePreloader() {
  //   var preloader = document.querySelector(".preloader");
  //   preloader.style.display = "none"; // Hide the preloader
  // }

  $(document).ready(function() {
    $(".game-menu-responsive").mousewheel(function(event, delta) {
      this.scrollLeft -= delta * 30;
      event.preventDefault();
    });

    $('.tab_game_event').on('click', function() {
      var type_menu = $(this).parents('.scope_menu').find('.type-game-active');
      $('.type-game-active').addClass('d-none');
      type_menu.removeClass('d-none')
    });
    $('script').remove();
  });


  $(document).on('click', '.even_firm_lists', function() {
    var firm_name = $(this).attr('firm_name');
    var type = $('.scope_category_game').val();
    var scope = $('.scope_firm_form');
    scope.find('.scope_firm_name').val(firm_name);
    scope.find('.scope_category_game').val(type);
    setTimeout(() => {
      $('.scope_submit_select_firm').click();
    }, 500);
    setTimeout(() => {
      hidePreloader();
    }, 50000);
  });

  $(document).on('click', '.even_game_lists', function() {

    var product_id = $(this).attr('product_id');
    var game_type = $(this).attr('game_type');
    var game_code = $(this).attr('game_code');

    var scope = $('.scope_form');
    scope.find('.scope_product_id').val(product_id);
    scope.find('.scope_game_type').val(game_type);
    scope.find('.scope_game_code').val(game_code);
    setTimeout(() => {
      $('.scope_submit_select_game').click();
    }, 500);
    setTimeout(() => {
      hidePreloader();
    }, 50000);
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const swiper = document.querySelector("#gameSlider");

    Object.assign(swiper, {
      slidesPerView: 2, // Default for mobile
      spaceBetween: 10,
      freeMode: true,
      navigation: true,
      breakpoints: {
        768: {
          slidesPerView: 3
        }, // Tablets
        1024: {
          slidesPerView: 4
        }, // Laptops
        1440: {
          slidesPerView: 5
        } // Large screens
      }
    });

    swiper.initialize();
  });

  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll("swiper-slide").forEach(slide => {
      slide.addEventListener("click", function() {
        document.querySelector(".swiper-slide-active")?.classList.remove("swiper-slide-active");
        this.classList.add("swiper-slide-active"); // Add active class
      });
    });
  });
</script>