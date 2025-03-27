<?php
require_once '.framework/import.php';

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
    $user_data = User::getCurrent();
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้าประวัติกิจกรรมเปิดไพ่',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>
  <?php include 'layout/menu.php'; ?>
  <?php include 'layout/nmg_bg.php'; ?>
  <div class="container position-relative">

    <div class="row">
      <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item">
              <a href="index.php"><?= Ty::get('home') ?></a>
            </li>
            <li class="breadcrumb-item">
              <a href="event.php"><?= Ty::get('event') ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('cardofmillionaire') ?></li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="title-table">
          <?= Ty::get('reward_history') ?>
        </div>
        <div id="game_card_history" class="container-pagination table-custom" data-page_size="15" <?= Homepagify::createHomepagify('game_card_history', '', '', Ty::get('card_reward'), ''); ?>>
          <div class="table-responsive">
            <table class="table table-sort table-theme">
              <thead>
                <tr>
                  <th nowrap class="text-white"><?= Ty::get('play_time', [], ["case" => "ucfirst"]) ?></th>
                  <th nowrap class="text-white thin-cell"><?= Ty::get('rewards') ?></th>
                  <th nowrap class="text-white text-end"><?= Ty::get('status') ?></th>
                </tr>
              </thead>
            </table>
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
  ?>
</body>

</html>