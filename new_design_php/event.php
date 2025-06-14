<?php
require_once '.framework/import.php';

$list_event = [
  [
    'name' => Ty::get('cardofmillionaire'),
    'image' => 'assets/images/games/event-001.png',
    'url' => 'game_card.php',
  ],
  [
    'name' => Ty::get('fortunesslot'),
    'image' => 'assets/images/games/event-002.png',
    'url' => 'game_slot.php',
  ]
];

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
  <?php
  if ($is_login) {
    $system_line =  nga_management::getGeneralWebsite($code);
    $where = [
      'status' => 'active'
    ];
    $user_data = User::getCurrent();
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้ากิจกรรม',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $event_deposit = nga_management::selectEventDeposit($code, $where);
    foreach ($event_deposit as $key => $event_value) {
      $text = Ty::get('_days', ['day' => '30']);
      $img = 'assets/images/games/event-30day.png';
      if ($event_value['event_type'] == 'short_term') {
        $text = Ty::get('_days', ['day' => '7']);
        $img = 'assets/images/games/event-7day.png';
      }
      $list_event[] = [
        'name' => Ty::get('fixed_deposit ') . $text,
        'image' => $img,
        'url' => 'game_daily_deposit.php?id=' . $event_value['id'],
      ];
    }
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>
  <?php include 'layout/menu.php'; ?>
  <?php include 'layout/winx98_bg.php'; ?>
  <div class="container position-relative">

    <div class="row">
      <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item">
              <a href="index.php"><?= Ty::get('home') ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('event') ?></li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <?php foreach ($list_event as $key => $event) { ?>
        <div class="col-lg-4 col-sm-6 mb-15px">
          <h1 class="title-event"><?= $event['name'] ?></h1>
          <div class="card-event">
            <a href="<?= $event['url'] ?>" class="img-4by3 holder">
              <img src="<?= $event['image'] ?>" alt="<?= $event['name'] ?>">
            </a>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>



  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

</body>

</html>