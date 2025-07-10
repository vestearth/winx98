<?php
require_once '.framework/import.php';
require_once 'layout/footer_nav.php';
require_once 'layout/navbanner.php';

$user_data['money_balance'] = 0;

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
    $user_data = User::getCurrent();
    $user_info = nga_user::getUserByID($code, $user_data['id']);
    $alliance_data = nga_management::getAllianceByID($code, $user_data['alliance_id']);
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้าถอนเงิน',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $customer_data = nga_user::getUserByID($code, $user_data['id']);
    $get_auto_wd = nga_management::getAutoDepositWithdraw($code);

    $check_bank_allow = nga_user::getBankNameByBankNo($code, $user_data['bank_abb'], $user_data['bank_number']);
    $user_group = nga_management::getUserGroupByID($code, $user_data['user_group_id']);
    $is_kbank = isset($user_group['withdraw_bank_abb']) ? $user_group['withdraw_bank_abb'] : false;

    $check_withdraw = nga_bank_pg_withdraw_api::checkWithdraw($code, $user_data['id']);
    $check_withdraw_response = isset($check_withdraw['response_data']) ? $check_withdraw['response_data'] : [];
    // Aww::display($check_withdraw_response);
    // die();
    if ($_POST) {
      if (isset($_POST['submit_withdraw'])) {
        $data = [
          'user_id' => $user_data['id'],
          'credit_amount' => $_POST['credit_amount'],
        ];
        $result = nga_bank_pg_withdraw_api::addWithdraw($code, $data);
        // Aww::display($result);
        // die();
        // } else if (isset($_POST['submit_withdraw_cancel'])) {
        //   $result = nga_bank_pg_withdraw_api::cancelWithdraw($code, $user_data['id']);
      }
      if (isset($result)) {
        $response_message = isset($response_message) ? $response_message : $result['response_message'];
        $response_status = $result['response_status'] ? 'success' : 'error';
        $response_redirect = isset($response_redirect) ? $response_redirect : '';

        Aww::notification($response_message, $response_status);
        Aww::redirect($response_redirect);
      }
    }
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>
  <?php include 'layout/winx98_bg.php'; ?>
  <?php renderFooterNav($alliance_data['line_link']); ?>
  <?php renderBannerUser(); ?>
  <div class="container position-relative mt-100px">

    <div class="row">
      <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item">
              <a href="index.php"><?= Ty::get('home') ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('withdraw') ?></li>
          </ol>
        </nav>
      </div>
      <div class="col-12">
        <div class="wallet-section">
          <div class="balance-card">
            <div class="balance-left">
              <p class="balance-label">ฝาก-ถอน</p>
              <p class="phone-number"><?= $user_info['username'] ?></p>
            </div>
            <div class="balance-right">
              <img src="assets/img/icon/coins.svg" alt="Coins" class="coins-icon">
              <div class="balance-amount">
                <?php $money = number_format($user_info['money_balance'], 2); ?>
                <?php
                $money_parts = explode('.', $money);
                $main_amount = $money_parts[0];
                $decimal_part = isset($money_parts[1]) ? $money_parts[1] : '00';
                ?>
                <span class="amount-main"><?= $main_amount ?></span>
                <span class="amount-decimal">.<?= $decimal_part ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <? navDepositWithdraw('withdraw'); ?>
      <div class="col-md-6">
        <div class="mt-20px mb-15px">
          <div class="tltle-page d-flex justify-content-center">
            <?= "ถอนเงินจากกระเป๋า" ?>
          </div>
          <div class="sub-title-page d-flex justify-content-center">
            ระบบจะโอนเงินไปยังเลขบัญชีที่คุณสมัครไว้
          </div>
        </div>
        <div class="card-content mb-20px pb-0 have-bg min-h-200px">
          <div class="card-content-body text-center">
            <div class="d-flex justify-content-lg-center align-items-center">
              <span class="text-white mb-10px"><?= Ty::get('moneycanwithdraw', [], ["case" => "ucfirst"]) ?></span>
            </div>
            <div class="d-flex justify-content-lg-center align-items-center">
              <h1 class="font-30px mb-10px">฿ <?= number_format($user_data['money_balance'], 2); ?></h1>
            </div>
            <?php
            $get_auto_wd['is_withdraw_active'] = true; // For testing purposes, set to true to show the withdraw button
            ?>
            <form id="withdraw_form" method="post">
              <input type="number" name="credit_amount" class="input-custom mb-15px event_text_data event_check_int" placeholder="<?= Ty::get('fillamountofmoney', [], ["case" => "ucfirst"]) ?>" min="<?= 1 ?>" max="<?= 200000 ?>" step="any">
              <?php /*
            <input type="number" class="input-custom mb-15px event_text_data event_check_int" placeholder="<?= Ty::get('fillamountofmoney', [], ["case" => "ucfirst"]) ?>" min="<?= 1 //$get_auto_wd['withdraw_minimum']?>" max="<?= 2 //number_format($get_auto_wd['withdraw_maximum'], 2);?>" step="any">
             */
              ?>
              <?php if ($check_withdraw_response['step'] == 0) { ?>
                <button type="button" class="btn-main btn-withdraw max-w-305px event_send_data " <?php Tiwdal::register('modal_confirm_withdraw', []); ?>>
                  <?= Ty::get('confirm2') ?>
                </button>
                <input type="hidden" name="submit_withdraw" value="1">
              <?php } else { ?>
                <button type="button" class="btn btn-main max-w-305px " <?php Tiwdal::register('modal_show_withdraw_condition', []); ?>>
                  <?= Ty::get('confirm2') ?>
                </button>
              <?php } ?>
            </form>
          </div>
        </div>

        <div class="detail max-w-305px m-auto mt-15px">
          <span class="text-gold"><?= Ty::get('note', [], ["case" => "ucfirst"]) ?></span>
          <ul>
            <li><?= Ty::get('min_withdraw', [], ["case" => "ucfirst"]) ?> <?= 100; ?> <?= Ty::get('baht') ?></li>
          </ul>
        </div>
        <?php /*
        <div class="card-turnover  mt-35px">
          <div class="w-100">
            <p class="font-14px font-SemiBold text-gold mb-5px"><?= Ty::get('turnover') ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <?php
              // $cal_turn_over = $user_data['turn_over_for_withdraw'] - $user_data['current_turn_over_for_withdraw'];
              // $cal_turn_over = ($cal_turn_over > 0) ? $cal_turn_over : '0';
              ?>
              <div class="ml-5px font-16px"> ฿ <?= number_format(1234, 2); ?> | <?= number_format(1234, 2); ?></div>
              <div>ดูรายละเอียด</div>
            </div>
          </div>
        </div>
         */ ?>
      </div>
      <div class="col-md-6 mb-75px">
        <div class="title-table">
          <?= Ty::get('withdrawal_history') ?>
        </div>
        <div id="withdraw_list" class="container-pagination table-custom" <?= Homepagify::createHomepagify('withdraw_list', '', '', 'รายการฝาก', ''); ?>>
          <div class="table-responsive">
            <table class="table table-sort table-theme">
              <thead>
                <tr>
                  <th nowrap class="text-gold" data-sort=""><?= Ty::get('dateandtime') ?></th>
                  <th nowrap class="text-gold thin-cell text-end" data-sort=""><?= Ty::get('amount') ?></th>
                  <th nowrap class="text-gold text-end no-sort" data-sort=""><?= Ty::get('status') ?></th>
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
      <p class="text-gold font-22px"><?= Ty::get('withdraw_done') ?>!</p>
      <div class="lottie-box">
        <lottie-player src="assets/images/lottie/success.json" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
      <div class="detail">
        <p class="font-18px">
          <?= Ty::get('trans_check') ?> <br>
          <?= Ty::get('trans_bank') ?>
        </p>
      </div>
    </div>
  </div>

  <?php Tiwdal::startModal('modal_confirm_withdraw', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <div class="title text-center text-pink-2">
      <?= Ty::get('confirm') ?>
    </div>
    <p class="detail text-center font-18px">
      <span>
        <?= Ty::get('trans_to', [], ["case" => "ucfirst"]) ?>
      </span>
    </p>
    <p class="detail text-center mb-0 font-18px"><?= Ty::get('withdraw_bal', [], ["case" => "strtolower"]) ?> <span class="event_number_input"></span> <?= Ty::get('baht', [], ["case" => "strtolower"]) ?></p>
  </div>
  <div class="modal-footer">
    <button dtype="submit" class="btn btn-main event_confirm_withdraw" data-bs-dismiss="modal" aria-label="Close">
      <?= Ty::get('confirm2') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('modal_detail', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <div class="title ">
      <?= Ty::get('time_withdraw') ?>
    </div>
    <p class="detail font-18px">
      <span name="{date_trans}"></span>
    </p>
    <div class="title">
      <?= Ty::get('trans_to', [], ["case" => "ucfirst"]) ?>
    </div>
    <p class="detail font-18px">
      <span name="{transfer_data}"></span>
    </p>
    <div class="title">
      <?= Ty::get('withdraw_bal') ?>
    </div>
    <p class="detail font-18px">
      <span name="{credit_amount}"></span>
      <?= Ty::get('baht') ?>
    </p>
    <div class="title">
      <?= Ty::get('status') ?>
    </div>
    <p class="detail text-success mb-0 font-18px">
      <span name="{status_complete}"></span>
    </p>
    <p class="detail text-warning mb-0 font-18px">
      <span name="{status_waiting}"></span>
    </p>
    <p class="detail text-danger mb-0 font-18px">
      <span name="{status_cancel}"></span>
    </p>
    <div class="title mt-12px">
      <?= Ty::get('reason') ?>
    </div>
    <p class="detail font-18px">
      <span name="{remark_data}"></span>
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main rounded">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>


  <?php Tiwdal::startModal('modal_show_withdraw_condition', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <p class="detail font-16px text-center" style="white-space: pre-line">
      <?= $get_auto_wd['withdraw_condition']; ?>
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main rounded">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('modal_kbank_condition', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <p class="detail font-16px text-center" style="white-space: pre-line">
      ไม่สามารถถอนเงินได้ในขณะนี้ เนื่องจากเว็บธนาคารใช้งานไม่ได้ ขออภัยในความไม่สะดวก
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('modal_maintenance', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <h5 class="text-center">ขออภัยในความไม่สะดวก</h5>
    <p class="detail font-16px text-center" style="white-space: pre-line">
      ธนาคารไทยพานิชณ์ (SCB) จะทำการปิดปรับปรุงการใช้บริการเพื่อพัฒนาระบบระหว่าง
      วันศุกร์ที่ 9 มิถุนายน 2556 เวลา 20:00 น.
      ถึงเวลา
      วันเสาร์ 10 มิถุนายน 2556 เวลา 03:00 น.
    </p>
    <p class="text-danger text-center" style="white-space: pre-line">
      ลูกค้าจะไม่สามารถทำรายการฝาก - ถอนเงิน
      ผ่าน SCB ได้ตามช่วงเวลาที่ระบุ ทั้งนี้
      <u>ลูกค้าสามารถติดต่อแอดมิน</u>
      เพื่อทำรายการได้ตามปกติ
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>


  <!-- <div class="menu-fix-right">
    <a href="<?= $system_line['line_link'] ?>" target="_blank">
      <div class="menu-line">
        <div class="box-close event_close_fix_menu">
          <?= file_get_contents('assets/icon/close.svg') ?>
        </div>
      </div>
    </a>
  </div> -->


  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/main.js');
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

  <script>
    $(document).on('click', '.event_confirm_withdraw', function() {
      $('#withdraw_form').submit();
    });

    $(document).ready(function() {
      var currentTime = new Date(); // Get the current time
      var currentHour = currentTime.getHours(); // Get the current hour
      // Check if the current time is within the specified range
      if ((currentHour >= 16 && currentHour <= 23) || (currentHour >= 0 && currentHour <= 6)) {
        // Disable the button
        // $('#modal_maintenance').modal('show');
      }

      var bank_run = '<?= $check_bank_allow['account_name']; ?>';
      var is_kbank = '<?= $is_kbank; ?>';
      if (!bank_run && is_kbank == 'KBANK') {
        $('#modal_kbank_condition').modal('show');
      }
      $(document).on('keypress', '.event_check_int', function(event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
          event.preventDefault();
        }
      });
      $(document).on('click', '.event_close_fix_menu', function(e) {
        e.preventDefault();
        $(this).parents('a').fadeOut(300, function() {
          $(this).remove();
        });
      });

      $(document).on("click", ".event_refresh", function(e) {
        location.reload();
      });
      $(document).on("click", ".event_send_data", function(e) {
        var price = $('.event_text_data').val();
        $(".event_number_input").text(Aww.formatMoney(price, 2));
        $(".event_number_input").attr('data-amount', price);
      });
      $(document).on("click", ".event_confirm", function(e) {
        $(this).attr("disabled", true);
        var modal = $(this).parents(".modal-content");
        var credit_amount = modal.find(".event_number_input").data('amount');
        params = {
          "credit_amount": credit_amount,
        };
        $.post('ajax/ajax_send_withdraw.php', params)
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
              Aww.notification('error', result.response_message);
              setTimeout(() => {
                location.reload();
              }, 1000);
            }
          });
      });
      $('script').remove();
    });
  </script>
</body>

</html>