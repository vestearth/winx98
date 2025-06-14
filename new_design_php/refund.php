<?php
require_once '.framework/import.php';
require_once 'layout/footer_nav.php';

$list_games = [
  [
    'name' => Ty::get('cardgames'),
    'is_open' => 'is_open_card_game',
    'commission' => 'card_commission',
    'commission_player' => 'card_commission_player',
  ],
  [
    'name' => Ty::get('boardgames'),
    'is_open' => 'is_open_board_game',
    'commission' => 'board_commission',
    'commission_player' => 'board_commission_player',
  ],
  [
    'name' => Ty::get('fortunesslot'),
    'is_open' => 'is_open_slot_game',
    'commission' => 'slot_commission',
    'commission_player' => 'slot_commission_player',
  ],
  [
    'name' => Ty::get('landofarcade'),
    'is_open' => 'is_open_arcade_game',
    'commission' => 'arcade_commission',
    'commission_player' => 'arcade_commission_player',
  ],
  [
    'name' => Ty::get('onlinefishing'),
    'is_open' => 'is_open_fishing_game',
    'commission' => 'fishing_commission',
    'commission_player' => 'fishing_commission_player',
  ]
];

$page = isset($_GET['page']) ? $_GET['page'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  Aww::loadAsset('assets/css/custom.css');
  ?>
</head>

<body>
  <?php
  if ($is_login) {
    $turn_over = nga_user::getUserTurnOverOustanding($code);
    $get_turn_over = nga_user::getUserByID($code, User::getCurrentUserId());
    $user_data = User::getCurrent();
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้าคืนยอดเสีย',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>
  <?php include 'layout/winx98_bg.php'; ?>
  <?php require_once 'layout/navbanner.php'; ?>
  <?php require_once 'layout/footer_nav.php'; ?>
  <?php renderFooterNav(); ?>
  <?php renderBannerUser(); ?>
  <div class="container position-relative">
    <div class="row mt-75px">
      <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item">
              <a href="index.php"><?= Ty::get('home') ?></a>
            </li>
            <?php if ($page == 'table') { ?>
              <li class="breadcrumb-item">
                <a href="refund.php"><?= Ty::get('lossreturn') ?></a>
              </li>
              <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('lossreturnhistory') ?></li>
            <?php } else { ?>
              <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('lossreturn') ?></li>
            <?php } ?>
          </ol>
        </nav>
      </div>
      <div class="col-md-6 <?= ($page == 'table') ? 'hide-mobile' : '' ?>">
        <div class="card-content mb-20px mt-35px  have-bg min-h-200px">
          <div class="card-content-body text-center">
            <div class="d-flex justify-content-center align-items-center mb-10px">
              <span class="text-white font-16px"><?= Ty::get('lossingcreditreturnedtoday') ?></span>
              <img src="assets/icon/refresh-2.svg" alt="refresh" class="ml-5px event_refresh cursor-pointer">
            </div>
            <h1 class="font-30px mb-10px">฿ <?= number_format($turn_over['sum_turn_over_outstanding'], 2); ?></h1>
            <?php if ($turn_over['is_today_received'] && $turn_over['sum_turn_over_outstanding'] == 0) { ?>
              <button type="button" class="btn btn-main max-w-305px " disabled>
                <?= Ty::get('claim') ?>
              </button>
            <?php } else { ?>
              <button type="button" class="btn btn-main max-w-305px event_confirm" <?= $turn_over['sum_turn_over_outstanding'] >= 0 ? '' : 'disabled'; ?>>
                <?= Ty::get('claim') ?>
              </button>
            <?php } ?>
            <a href="?page=table" class="text-gold my-10px show-mobile"><?= Ty::get('lossreturnhistory') ?></a>
            <div class="max-w-350px m-auto mt-15px text-gold font-14px">
              <?= Ty::get('creditwillbecutdaily') ?>
            </div>
          </div>
        </div>
        <h3 class="font-16px text-gold"><?= Ty::get('termsandconditions') ?></h3>
        <ul>
          <li>
            <?= Ty::get('loss_promotion') ?> <?= $get_turn_over['turn_over_percent_customer']; ?>%
          </li>
          <li>
            <?php if ($get_turn_over['minimum_turn_over'] && $get_turn_over['maximum_turn_over']) { ?>
              <?= Ty::get('min_amount') ?> <?= $get_turn_over['minimum_turn_over']; ?> <?= Ty::get('and') ?> <?= $get_turn_over['maximum_turn_over']; ?> <?= Ty::get('maximum') ?>
            <?php } else { ?>
              <?= Ty::get('no_min') ?>
            <?php } ?>
            <?= Ty::get('moreplay_moredis') ?>
          </li>
          <li>
            <?= Ty::get('mock_key_1') ?>
          </li>
        </ul>
      </div>
      <div class="col-md-6 <?= ($page != 'table') ? 'hide-mobile' : '' ?>">
        <div class="title-table">
          <?= Ty::get('lossreturnhistory') ?>
        </div>
        <div id="refund_list" class="container-pagination table-custom" <?= Homepagify::createHomepagify('refund_list', '', '', Ty::get('dep_trans'), ''); ?>>
          <div class="table-responsive">
            <table class="table table-sort table-theme">
              <thead>
                <tr>
                  <th nowrap class="text-white" data-sort=""><?= Ty::get('dateandtime') ?></th>
                  <th nowrap class="text-white thin-cell" data-sort=""><?= Ty::get('amount') ?></th>
                  <th nowrap class="text-white text-end no-sort" data-sort=""><?= Ty::get('status') ?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="backdrop-claim" style="display: none;">
    <div class="claim-container">
      <p class="text-gold font-22px"><?= Ty::get('credit_received') ?></p>
      <div class="lottie-box">
        <lottie-player src="assets/images/lottie/success.json" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
      <div class="detail">
        <p class="font-18px">
          <?= Ty::get('credit_loss') ?> <?= number_format($turn_over['sum_turn_over_outstanding'], 2); ?> <?= Ty::get('baht') ?> <br>
          <?= Ty::get('to_credit') ?>
        </p>
      </div>
    </div>
  </div>

  <?php Tiwdal::startModal('modal_detail', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <div class="title text-center">
      <?= Ty::get('time_withdraw') ?>
    </div>
    <p class="detail">
      <span name="{date_trans}">23/06/2022, 15:25</span>
    </p>
    <div class="title">
      <?= Ty::get('trans_to') ?>
    </div>
    <p class="detail">
      <span name="{transfer_data}">111-1–XXXXX1, ธนาคารกสิกรไทย</span>
    </p>
    <div class="title">
      <?= Ty::get('withdraw_bal') ?>
    </div>
    <p class="detail">
      <span name="{credit_amount}">300.00</span>
      <?= Ty::get('baht') ?>
    </p>
    <div class="title">
      <?= Ty::get('status') ?>
    </div>
    <p class="detail text-success">
      <span name="{status_complete}"></span>
    </p>
    <p class="detail text-warning">
      <span name="{status_waiting}"></span>
    </p>
    <p class="detail text-danger">
      <span name="{status_cancel}"></span>
    </p>
    <div class="title">
      <?= Ty::get('reason') ?>
    </div>
    <p class="detail">
      <span name="{remark_data}"></span>
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main rounded">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>






  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

  <script>
    $(document).ready(function() {
      $(document).on('click', '.event_confirm', function() {
        $.post('ajax/ajax_refund_turnover.php', {})
          .done(function(data) {
            var result = JSON.parse(data);
            if (result.response_status) {
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
      $(document).on("click", ".event_refresh", function(e) {
        location.reload();
      });
    });
  </script>
</body>

</html>