<?php
require_once '../.framework/import.php';
$id = isset($_GET['id']) ? $_GET['id'] : '';

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
      'detail' => 'เข้าหน้ารางวัล',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $reward_list = nga_management::selectRewardForRedemtion($code);
    $system_line =  nga_management::getGeneralWebsite($code);
    $alliance_data = nga_management::getAllianceByID($code, $user_data['alliance_id']);
    if ($id) {
      $reward_data = [];
      foreach ($reward_list as $key => $value) {
        if ($value['id'] == $id) {
          $reward_data = $value;
        }
      }
    }
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
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('rewards') ?></li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 mb-15px">
        <div class="card-price-frame card-price-frame-rewards">
          <h2><?= Ty::get('mypoint') ?></h2>
          <h1><?= number_format($user_data['point_balance'], 2); ?></h1>
        </div>
        <?php if ($reward_list) { ?>
          <?php
          foreach ($reward_list as $key => $list) {
            $text_rwd = ($list['point_use'] > $user_data['point_balance']) ? Ty::get('point_enough') : Ty::get('rewards');
            $btn_disabeld = ($list['point_use'] > $user_data['point_balance']) ? 'disabled' : '';
            $list['point_use_format'] = number_format($list['point_use'], 0);
            $list['point_use_format_1'] = number_format($list['point_use'], 0);
          ?>
            <div class="card-reward">
              <div class="card-reward-img">
                <img src="<?= $list['reward_img']; ?>" alt="reward">
                <div class="reward-point">
                  <?= Ty::get('use_point', [], ["case" => "ucfirst"]) ?> <span class="text-pink-2"><?= number_format($list['point_use'], 2) ?> <?= Ty::get('point') ?></span>
                </div>
              </div>
              <div class="card-reward-title">
                <?= $list['name']; ?>
              </div>
              <div class="card-reward-btn justify-content-center">
                <button class="btn btn-main <?= (Ty::getLg() != 'th') ? 'w-250px'  : 'w-150px' ?>  rounded mt-5px" <?php Tiwdal::register('confirm_reward',  $list) ?> <?= $btn_disabeld ?>><?= $text_rwd ?></button>
              </div>
              <div class="p-15px">
                <p class="font-18px text-gold mt-10px mb-0 "><?= Ty::get('terms_conds') ?></p>
                <div style="white-space: pre-line;" class="mt--20px">
                  <?= $list['description'] ?>
                  <a href="<?= $alliance_data['line_link'] ?>" target="_blank" class="text-success">
                    <?= $alliance_data['line_name'] ?>
                  </a>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="col-12">
            <p class="text-center my-20px font-23px"><?= Ty::get('reward_exchange') ?></p>
          </div>
        <?php } ?>
      </div>
      <div class="col-md-6">
        <div class="title-table">
          <?= Ty::get('rewardexchange') ?>
        </div>
        <div id="claim_reward_history" class="container-pagination table-custom" <?= Homepagify::createHomepagify('claim_reward_history', '', '', Ty::get('rewardexchange'), ''); ?>>
          <div class="table-responsive">
            <table class="table table-sort table-theme">
              <thead>
                <tr>
                  <th nowrap class="text-white"><?= Ty::get('dateandtime') ?></th>
                  <th nowrap class="text-white"><?= Ty::get('status') ?></th>
                  <th nowrap class="text-white text-end"><?= Ty::get('usedpoints', [], ["case" => "ucfirst"]) ?></th>
                  <th nowrap class="text-white"><?= Ty::get('rewards') ?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <?php Tiwdal::startModal('confirm_reward', 'modal-sm modal-no-more modal-dialog-centered m-auto'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body text-center">
    <div class="title text-pink-2">
      <?= Ty::get('reward_confirm', [], ["case" => "ucfirst"]) ?>
    </div>
    <div class="font-16px d-flex justify-content-center mt-15px">
      <p class="mb-0">
        <?= Ty::get('doyouwant') ?>
        <span name="{point_use_format_1}" class="mx-5px"></span>
        <?= Ty::get('point_reward') ?>
        <?= (Ty::getLg() != 'th') ? Ty::get('yes_no')  : '' ?>
      </p>
    </div>
    <p class="font-16px mb-0"><?= (Ty::getLg() == 'th') ? Ty::get('yes_no') : '' ?></p>
  </div>
  <input type="hidden" class="scope_point_use" name="{point_use_format}">
  <input type="hidden" class="scope_name" name="{name}">
  <input type="hidden" class="scope_id" name="{id}">
  <div class="modal-footer">
    <button type="button" class="btn-main event_confirm" data-bs-dismiss="modal" type="button">
      <?= Ty::get('confirm2') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>


  <div class="backdrop-claim" style="display: none;">
    <div class="claim-container">
      <p class="text-gold font-22px"><?= Ty::get('reward_succeed') ?>!</p>
      <div class="lottie-box">
        <lottie-player src="assets/images/lottie/success.json" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
      <div class="detail">
        <p class="font-22px">
          <?= Ty::get('you_used') ?> <span class="text-gold scope_point_use"></span> <?= Ty::get('point') ?> <br>
          <?= Ty::get('toexchange') ?> <br>
          <span class="text-gold scope_item_received"></span>
        </p>
        <p class="font-16px max-w-270px">
          <?= Ty::get('system_checking') ?>
          <a href="<?= $system_line['line_link'] ?>" target="_blank" class=" text-decoration-none ">
            <span class="text-theme"><?= $system_line['line_id'] ?></span>
          </a>
        </p>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

  <script>
    $(document).ready(function() {
      $(document).on('click', '.event_confirm', function() {
        var scope = $(this).parents('#confirm_reward');
        var user_id = '<?= $user_data['id'] ?>';
        var reward_id = scope.find('.scope_id').val();
        var params = {
          user_id: user_id,
          reward_id: reward_id,
        };

        $.post('ajax/ajax_reward_redemption.php', params)
          .done(function(data) {
            var result = JSON.parse(data);
            if (result.response_status) {
              var point_use = scope.find('.scope_point_use').val();
              var name = scope.find('.scope_name').val();

              var date = new Date();
              var day = date.getDate();
              var month = date.getMonth() + 1;
              var year = date.getFullYear();
              var hour = (date.getHours() < 9) ? '0' + date.getHours() : date.getHours();
              var minute = (date.getMinutes() < 9) ? '0' + date.getMinutes() : date.getMinutes();
              var time_result = day + '/' + month + '/' + year + ', ' + hour + ':' + minute;

              $('.backdrop-claim').find('.scope_point_use').text(point_use);
              $('.backdrop-claim').find('.scope_item_received').text('“' + name + '”');
              // $('.backdrop-claim').find('.scope_cur_date').text(time_result);
              setTimeout(() => {
                $('.backdrop-claim').fadeIn('fast', function() {
                  setTimeout(() => {
                    location.reload();
                  }, 2000);
                });
              }, 1000);
            } else {
              Aww.notification('error', result.response_message)
            }
          })

      })
    });
  </script>
</body>

</html>