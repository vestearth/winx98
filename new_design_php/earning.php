<?php
require_once '../.framework/import.php';
$type = isset($_GET['type']) ? $_GET['type'] : 'receive';
$summary_type = isset($_GET['sum_type']) ? $_GET['sum_type'] : 'player_detail';
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
    $get_commission = nga_management::getGameUserCommissionSetting($code);
    $outstand_commission = nga_user::getOuststandingCommission($code);
    // $system_line =  nga_management::getGeneralWebsite($code);
    $alliance_data = nga_management::getAllianceByID($code, $user_data['alliance_id']);
    $get_earning = nga_user::getUserEarning($code, $user_data['id']);
  } else {
    // Aww::redirectOG('landing.php');
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
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('earnmoney') ?></li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="card-earning">
          <div class="card-earning-tap">
            <a href="?type=receive" class="<?= $type == 'receive' ? 'active' : '' ?>"><?= Ty::get('link') ?></a>
            <a href="?type=income" class="<?= $type == 'income' ? 'active' : '' ?>"><?= Ty::get('income') ?></a>
            <a href="?type=summary" class="<?= $type == 'summary' ? 'active' : '' ?>"><?= Ty::get('total_result', [], ['case' => 'ucfirst']) ?></a>
          </div>
          <div class="card-earning-body">
            <?php if ($type == 'receive') { ?>
              <div class="d-flex align-items-center justify-content-between mb-15px earning-position">
                <div class="link">
                  <?php
                  $url = "http://$_SERVER[HTTP_HOST]";
                  $url = $url . '/signup.php';
                  $target = $url . '?ref=' . $user_data['member_code'];
                  ?>
                  <?= $target; ?>
                </div>
                <button class="btn-main rounded event_get_link">
                  <img src="assets/icon/copy-w.svg" alt="">
                  <?= Ty::get('copy_link') ?>
                </button>
              </div>
              <p class="mt-15px">
                <?= Ty::get('earn_foryou') ?> <span class="text-pink-2"><?= Ty::get('hundred_month') ?></span> <?= Ty::get('recommend_nmg') ?>
              </p>
              <div class="d-flex justify-content-center align-items-center">
                <img src="assets/icon/user-gold.svg" alt="">
                <span class="font-Bold font-22px text-gold ml-5px"> <?= number_format($user_data['downline_count']); ?></span>
              </div>
            <?php } else if ($type == 'income') { ?>
              <div class="d-flex justify-content-center align-items-center">
                <span class="text-white"><?= Ty::get('income_friend') ?></span>
                <img src="assets/icon/refresh-2.svg" alt="refresh" class="ml-5px event_refresh cursor-pointer">
              </div>
              <h1 class="font-30px my-10px text-gold">฿ <?= number_format($outstand_commission['outstanding_commission'], 2); ?></h1>
              <button class="btn-main rounded event_confirm">
                <?= Ty::get('claim') ?>
              </button>
              <div class="d-flex justify-content-center align-items-center mt-25px">
                <span class="text-white"><?= Ty::get('income_friend_3', [], ["case" => "ucfirst"]) ?></span>
                <img src="assets/icon/refresh-2.svg" alt="refresh" class="ml-5px event_refresh cursor-pointer">
              </div>
              <div class="d-flex justify-content-center align-items-center mx-15px">
                <h1 class="font-30px my-10px text-gold">฿ <?= number_format($outstand_commission['outstanding_commission'], 2); ?></h1>
              </div>
              <button class="btn-main event_ladder_confirm">
                <?= Ty::get('claim') ?>
              </button>
            <?php } else if ($type == 'summary') { ?>
              <div class="row justify-content-center align-items-center">
                <div class="col-md-6"><span class="text-white font-24px"><?= Ty::get('summary_players', [], ['case' => 'ucfirst']) ?></span></div>
              </div>
            <?php } ?>
          </div>
        </div>
        <?php if ($type == 'receive') {
          $version = (nga_management::getGameUserCommissionSetting($code))['is_active_new'] ? 'new' : 'old';
        ?>
          <div class="card-earning-2 mt-15px font-16px" style="white-space: normal;">
            <ul>
              <?php if ($version == 'new') { ?>
                <p class="mb-10px"><?= Ty::get('com_play_3') ?></p>
                <li class="mb-10px"><?= Ty::get('1stcomm') ?></li>
                <li class="mb-10px"><?= Ty::get('2ndcomm') ?></li>
                <li class="mb-10px"><?= Ty::get('3ndcomm') ?></li>
              <?php } else { ?>
                <p class="mb-10px"><?= Ty::get('com_play') ?></p>
                <li class="mb-10px"><?= Ty::get('old1stcomm') ?></li>
                <li class="mb-10px"><?= Ty::get('old2ndcomm') ?></li>
              <?php } ?>
            </ul>
          </div>
        <?php } ?>
        <?php if ($type == 'summary') { ?>
          <div class="row">
            <div class="col-4">
              <div class="card-earning mt-10px py-20px">
                <?= number_format($get_earning['downline_total_count'], 0) ?> / <?= number_format($get_earning['downline_total_deposit'], 0) ?>
              </div>
              <div class="text-gold text-center">
                <?= Ty::get('total_player_deposit') ?>
              </div>
            </div>
            <div class="col-4">
              <div class="card-earning mt-10px py-20px">
                <?= number_format($get_earning['downline_today'], 0) ?> / <?= number_format($get_earning['downline_today_bet'], 0) ?>
              </div>
              <div class="text-gold text-center">
                <?= Ty::get('today_player_bet') ?>
              </div>
            </div>
            <div class="col-4">
              <div class="card-earning mt-10px py-20px">
                <?= number_format($get_earning['downline_new'], 0) ?> / <?= number_format($get_earning['downline_new_deposit'], 0) ?>
              </div>
              <div class="text-gold text-center">
                <?= Ty::get('new_player_deposit') ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="col-lg-6">
        <?php if ($type == 'receive') { ?>
          <div class="title-table">
            <?= Ty::get('incomesummary') ?>
          </div>
          <div id="income_summary" class="container-pagination table-custom" <?= Homepagify::createHomepagify('income_summary', '', '', Ty::get('incomesummary'), ''); ?>>
            <div class="table-responsive">
              <table class="table table-sort table-theme">
                <thead>
                  <tr>
                    <th nowrap class="text-white"><?= Ty::get('dateandtime') ?></th>
                    <th nowrap class="text-white text-right thin-cell"><?= Ty::get('income') ?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        <?php } else if ($type == 'income') { ?>
          <div class="title-table">
            <?= Ty::get('income_history') ?>
          </div>
          <div id="withdraw_income" class="container-pagination  table-custom" <?= Homepagify::createHomepagify('withdraw_income', '', '', Ty::get('income_history'), ''); ?>>
            <div class="table-responsive">
              <table class="table table-sort table-theme">
                <thead>
                  <tr>
                    <th nowrap class="text-white"><?= Ty::get('dateandtime') ?></th>
                    <th nowrap class="text-white text-right"><?= Ty::get('amount') ?></th>
                    <th nowrap class="text-white text-right thin-cell"><?= Ty::get('status') ?></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        <?php } else if ($type == 'summary') { ?>
          <div class="row card-earning-summary-right">
            <div class="col-md-4">
              <div class="btn-switch-table">
                <a href="?type=summary&sum_type=player_detail" class="btn <?= $summary_type == 'player_detail' ? 'active' : '' ?>"><?= Ty::get('player_detail') ?></a>
              </div>
            </div>
            <div class="col-md-4">
              <div class="btn-switch-table">
                <a href="?type=summary&sum_type=player_list" class="btn <?= $summary_type == 'player_list' ? 'active' : '' ?>"><?= Ty::get('player_list') ?></a>
              </div>
            </div>
            <div class="col-md-4">
              <div class="btn-switch-table">
                <a href="?type=summary&sum_type=deposit_withdraw" class="btn <?= $summary_type == 'deposit_withdraw' ? 'active' : '' ?>"><?= Ty::get('deposit_withdraw') ?></a>
              </div>
            </div>
          </div>
          <?php if ($summary_type == 'player_detail') { ?>
            <div class="title-table mb-0">
              <div class="font-16px font-SemiBold py-10px px-15px bg-table border-top-radius-10">
                <?= Ty::get('player_detail') ?>
              </div>
            </div>
            <div id="player_detail" class="container-pagination  table-custom" <?= Homepagify::createHomepagify('player_detail', '', '', Ty::get('player_detail'), ''); ?>>
              <div class="table-responsive">
                <table class="table table-sort table-theme">
                  <thead>
                    <tr>
                      <th nowrap class="text-white no-sort"><?= 'ระดับ' ?></th>
                      <th nowrap class="text-white no-sort"><?= 'จำนวนผู้เล่น' ?></th>
                      <th nowrap class="text-white text-right no-sort"><?= 'ยอดชนะ/แพ้ทั้งหมด' ?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          <?php } else if ($summary_type == 'player_list') { ?>
            <div class="title-table mb-0">
              <div class="font-16px font-SemiBold py-10px px-15px bg-table border-top-radius-10">
                <?= Ty::get('player_list') ?>
              </div>
            </div>
            <div id="player_list" class="container-pagination  table-custom" <?= Homepagify::createHomepagify('player_list', '', '', Ty::get('player_list'), ''); ?>>
              <div class="table-responsive">
                <table class="table table-sort table-theme">
                  <thead>
                    <tr>
                      <th nowrap class="text-white"><?= Ty::get('name') ?></th>
                      <th nowrap class="text-white"><?= Ty::get('first_last_name') ?></th>
                      <th nowrap class="text-white"><?= Ty::get('register_date') ?></th>
                      <th nowrap class="text-white text-right"><?= Ty::get('deposit') ?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          <?php } else if ($summary_type == 'deposit_withdraw') { ?>
            <div class="title-table mb-0">
              <div class="font-16px font-SemiBold py-10px px-15px bg-table border-top-radius-10">
                <?= Ty::get('aff_deposit_withdraw') ?>
              </div>
            </div>
            <div id="deposit_withdraw" class="container-pagination  table-custom" <?= Homepagify::createHomepagify('deposit_withdraw', '', '', Ty::get('aff_deposit_withdraw'), ''); ?>>
              <div class="table-responsive">
                <table class="table table-sort table-theme">
                  <thead>
                    <tr>
                      <th nowrap class="text-white"><?= Ty::get('name') ?></th>
                      <th nowrap class="text-white"><?= Ty::get('first_last_name') ?></th>
                      <th nowrap class="text-white"><?= Ty::get('sum_date') ?></th>
                      <th nowrap class="text-white text-right"><?= Ty::get('deposit') ?></th>
                      <th nowrap class="text-white text-right"><?= Ty::get('withdraw') ?></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>

  <div class="backdrop-claim" style="display: none;">
    <div class="claim-container max-w-400px">
      <p class="text-gold font-22px text-uppercase"><?= Ty::get('credit_received') ?></p>
      <div class="lottie-box">
        <lottie-player src="assets/images/lottie/success.json" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
      <div class="detail">
        <p class="font-18px ">
          <?= Ty::get('money_invite', ['money' => '<span class="scope_receive">5000</span>']) ?>
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
    $(document).on("click", ".event_get_link", function(e) {
      copyToClipboard($(".link"));
      Aww.notification("success", "Copied");
    });

    $(document).on("click", ".event_refresh", function(e) {
      location.reload();
    });

    $(document).on('click', '.event_confirm', function() {
      var params = {};
      $.post('ajax/ajax_confirm_receive.php', params)
        .done(function(data) {
          var result = JSON.parse(data);
          if (result.response_status) {
            var money = result.response_data.money_upline_receive;
            money = Aww.formatMoney(money, 2);
            $('.backdrop-claim').find('.scope_receive').text(money);
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
    });

    $(document).on('click', '.event_ladder_confirm', function() {
      var params = {};
      $.post('ajax/ajax_confirm_ladder_receive.php', params)
        .done(function(data) {
          var result = JSON.parse(data);
          if (result.response_status) {
            var money = result.response_data.money_upline_receive;
            money = Aww.formatMoney(money, 2);
            $('.backdrop-claim').find('.scope_receive').text(money);
            setTimeout(() => {
              $('.backdrop-claim').fadeIn('fast', function() {
                setTimeout(() => {
                  $('.backdrop-claim').fadeOut();
                }, 2000);
                setTimeout(() => {
                  location.reload();
                }, 2000);
              });
            }, 1000);
          } else {
            Aww.notification('error', result.response_message)
          }
        })
    });
  </script>
</body>

</html>