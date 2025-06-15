<?php
ini_set("memory_limit", "32M");
require_once '.framework/import.php';
// error_reporting(0);
$page = 'games';
$type_game_template = [
  'CARD' => [
    'name' => 'เกมไพ่',
    'img' => 'assets/images/games/game-001.png'
  ],
  'BOARD' => [
    'name' => 'บอร์ดเกม',
    'img' => 'assets/images/games/game-002.png'
  ],
  'SLOT' => [
    'name' => 'สล็อต',
    'img' => 'assets/images/games/game-003.png'
  ],
  'CASINOLIVE' => [
    'name' => 'คาสิโน',
    'img' => 'assets/images/games/game-006.webp'
  ],
  'ARCADE' => [
    'name' => 'ตู้เกม',
    'img' => 'assets/images/games/game-004.png'
  ],
  'FISHING' => [
    'name' => 'เกมตกปลา',
    'img' => 'assets/images/games/game-005.png'
  ],
];


if ($is_login) {
  $select_type_game =  nga_api_seamless::selectGameList($code);
  $get_game_setting = nga_management::getGameActiveStatus($code);
} else {
  Aww::redirect('login.php');
}

if ($get_game_setting['is_open_card_game'] == 0) {
  unset($select_type_game['CARD']);
}
if ($get_game_setting['is_open_board_game'] == 0) {
  unset($select_type_game['BOARD']);
}
if ($get_game_setting['is_open_slot_game'] == 0) {
  unset($select_type_game['SLOT']);
}
if ($get_game_setting['is_open_arcade_game'] == 0) {
  unset($select_type_game['ARCADE']);
}
if ($get_game_setting['is_open_casinolive_game'] == 0) {
  unset($select_type_game['CASINOLIVE']);
}
if ($get_game_setting['is_open_fishing_game'] == 0) {
  unset($select_type_game['FISHING']);
}

$temp_type = '';
foreach ($select_type_game as $key => $value) {
  if (!$temp_type) {
    $temp_type = $key;
    break;
  }
}
$type = isset($_GET['type']) ? $_GET['type'] : $temp_type;
$user_data = User::getCurrent();

if ($_POST) {
  if (isset($_POST['submit_select_game'])) {
    $data = [
      'product_id' => $_POST['product_id'],
      'game_type' => $_POST['game_type'],
      'game_code' => $_POST['game_code'],
    ];
    $result =  nga_api_seamless::loginMemberSession($code, $data);
    if ($result['response_status']) {
      Aww::redirect($result['response_data']['url']);
    } else {
      Aww::redirect('');
    }
  }
}
$menu_footer = [
  [
    'title' => 'หน้าหลัก',
    'link' => 'index.php',
    'page' => 'index',
    'img' => 'assets/icon/menu/dice.svg',
  ],
  [
    'title' => 'ข้อมูลส่วนตัว',
    'link' => 'user.php',
    'page' => 'profile',
    'img' => 'assets/icon/menu/profile.svg'
  ],
  [
    'title' => 'เข้าสู่เกม',
    'link' => 'games.php',
    'page' => 'games',
    'img' => 'assets/icon/menu/play_game2.svg'
  ],
  [
    'title' => 'เว็บไซต์',
    'link' => 'landing.php',
    'page' => 'landing',
    'img' => 'assets/icon/menu/web.svg'
  ],
  [
    'title' => 'ความคิดเห็น',
    'link' => 'comment.php',
    'page' => 'comment',
    'img' => 'assets/icon/menu/comment2.svg'
  ],
];

$menu_footer = [
  [
    'title' => 'หน้าหลัก',
    'link' => 'index.php',
    'page' => 'index',
    'img' => 'assets/icon/menu/dice.svg',
  ],
  [
    'title' => 'ข้อมูลส่วนตัว',
    'link' => 'profile.php',
    'page' => 'profile',
    'img' => 'assets/icon/menu/profile.svg'
  ],
  [
    'title' => 'เข้าสู่เกม',
    'link' => 'games.php',
    'page' => 'games',
    'img' => 'assets/icon/menu/play_game2.svg'
  ],
  [
    'title' => 'เว็บไซต์',
    'link' => 'landing.php',
    'page' => 'landing',
    'img' => 'assets/icon/menu/web.svg'
  ],
  [
    'title' => 'ความคิดเห็น',
    'link' => 'comment.php',
    'page' => 'comment',
    'img' => 'assets/icon/menu/comment2.svg'
  ],
];

// create a function that converts a PNG image to WebP format using PHP
function convert_img_to_webp($original_image_path, $converted_image_path)
{
  //  check type of image
  $type = exif_imagetype($original_image_path);
  if ($type == IMAGETYPE_PNG) {
    $img_type = 'png';
  } else if ($type == IMAGETYPE_JPEG) {
    $img_type = 'jpg';
  } else if ($type == IMAGETYPE_GIF) {
    $img_type = 'gif';
  }
  //  check type of image
  if ($img_type == 'png') {
    $original_image = imagecreatefrompng($original_image_path);
  } else if ($img_type == 'jpg') {
    $original_image = imagecreatefromjpeg($original_image_path);
  } else if ($img_type == 'gif') {
    $original_image = imagecreatefromgif($original_image_path);
  }
  // Load the original image
  // $original_image = imagecreatefrompng($original_image_path);
  imagepalettetotruecolor($original_image);
  imagealphablending($original_image, true);
  imagesavealpha($original_image, true);
  // Convert the image to WebP format
  imagewebp($original_image, $converted_image_path);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  ?>
</head>

<body>
  <?php include 'layout/menu.php'; ?>
  <div class="container position-relative">
    <div class="row">
      <div class="col-md-12">
        <div class="card-price-frame game-page">
          <h2 class="mb-0">ยอดเงินในกระเป๋า</h2>
          <h1>฿ <?= number_format($user_data['money_balance'], 2); ?></h1>
        </div>
        <div class="game-row justify-content-center">
          <?php
          foreach ($select_type_game as $key => $type_games) {
          ?>
            <div class="game-col">
              <a href="?type=<?= $key ?>" class="game-menu <?= $key == $type ? 'active' : '' ?>">
                <div class="sort-responsive scope_menu">
                  <div class="pos-rel">
                    <div class="d-flex justify-content-center align-items-center tab_game_event mb-10px service-img game-image">
                      <img src="<?= '' . $type_game_template[$key]['img'] ?>" loading="lazy">
                    </div>
                  </div>
                  <div class="game-name">
                    <?= $type_game_template[$key]['name'] ?>
                  </div>
                </div>
              </a>
            </div>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-12">
        <div class="text-white">
          <div class="row">
            <?php
            foreach ($select_type_game[$type] as $game) {
              // Path to the original image
              $original_image_path = $game['img'];
              // explode original 
              $original_image_path_explode = explode('.', $original_image_path);
              // get type of image
              $img_type = end($original_image_path_explode);
              $converted_image_path = 'assets/images/webp/' . $game['product_id'] . '_' . $game['code'] . '.webp';
              if (!file_exists($converted_image_path)) {
                convert_img_to_webp($original_image_path, $converted_image_path, $img_type);
              }
            ?>
              <div class="col-lg-2 col-md-4 col-6 mb-10px">
                <div class="w-100 d-flex justify-content-center">
                  <div class="game-list-img even_game_lists cursor-pointer" product_id="<?= $game['product_id'] ?>" game_type="<?= $game['type'] ?>" game_code="<?= $game['code'] ?>">
                    <!-- ** check if webp file exist ** -->
                    <?php if (file_exists($converted_image_path)) { ?>
                      <img src="<?= $converted_image_path ?>" loading="lazy" class="img-responsive">
                    <?php } else { ?>
                      <img src="<?= $game['img'] ?>" loading="lazy" class="img-responsive">
                    <?php } ?>
                  </div>
                </div>
              </div>
            <?php }
            // $i++;
            // }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="scope_form d-none">
    <form method="post">
      <input type="hidden" name="product_id" class="scope_product_id">
      <input type="hidden" name="game_type" class="scope_game_type">
      <input type="hidden" name="game_code" class="scope_game_code">
      <button class="scope_submit_select_game" name="submit_select_game"></button>
    </form>
  </div>

  <footer>
    <div class="row">
      <?php foreach ($menu_footer as $key => $footer) { ?>
        <div class="col px-0">
          <div class="menu-footer <?= ($key == 2) ? 'center' : '' ?> <?= ($footer['page'] == $page) ? 'active' : '' ?>" data-link="<?= $footer['link'] ?>" onclick="redirectHref()">
            <div class="icon-footer">
              <?= file_get_contents($footer['img']) ?>
            </div>
            <div class="text"><?= $footer['title'] ?></div>
          </div>
        </div>
      <?php } ?>
    </div>
  </footer>

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  ?>
</body>

</html>

<script>
  $(document).ready(function() {
    $('.tab_game_event').on('click', function() {
      var type_menu = $(this).parents('.scope_menu').find('.type-game-active');
      $('.type-game-active').addClass('d-none');
      type_menu.removeClass('d-none')
    });
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
  });
</script>