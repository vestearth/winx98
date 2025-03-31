<?php
require_once '.framework/import.php';


function textFormat($text = '', $pattern = '', $ex = '')
{
  $cid = ($text == '') ? '0000000000000' : $text;
  $pattern = ($pattern == '') ? '_-____-_____-__-_' : $pattern;
  $p = explode('-', $pattern);
  $ex = ($ex == '') ? '-' : $ex;
  $first = 0;
  $last = 0;
  for ($i = 0; $i <= count($p) - 1; $i++) {
    $first = $first + $last;
    $last = strlen($p[$i]);
    $returnText[$i] = substr($cid, $first, $last);
  }

  return implode($ex, $returnText);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  Aww::loadAsset('assets/css/custom.css');
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <?php
  if ($is_login) {
    $user_data = User::getCurrent();
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้าฝากเงิน',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $bank_data = nga_management_bot::getBankForTransfer($code, $user_data['id']);
    $get_auto_wd = nga_management::getAutoDepositWithdraw($code);
    $system_line =  nga_management::getGeneralWebsite($code);

    $check_bank_allow = nga_user::getBankNameByBankNo($code, $user_data['bank_abb'], $user_data['bank_number']);
    $user_group = nga_management::getUserGroupByID($code, $user_data['user_group_id']);
    $is_kbank = isset($user_group['deposit_bank_abb']) ? $user_group['deposit_bank_abb'] : false;

    $where = [
      'user_id' => $user_data['id'],
      'is_read' => "'0'"
    ];
    $options = [
      'sort'        => ['insert_date_time' => 'DESC']
    ];
    $notification = User_Notification::selectNotification($code, $where);
    $promotion_list = nga_management::selectUserPromotion($code, $user_data['id'], $options);
    $promo_rank_first_depo = nga_management::selectPromotionDepositForUser($code, $user_data['id']);

    $ref_id = [];
    if ($notification) {
      foreach ($notification as $key => $value) {
        $ref_id[] = $value['ref_id'];
        $data = [
          'is_read' => 1
        ];
        User_Notification::updateNotification($code, $value['id'], $data);
      }
    }
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
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('deposit') ?></li>
          </ol>
        </nav>
      </div>
      <div class="col-md-6">
        <div class="mt-20px mb-15px">
          <div class="tltle-page d-flex justify-content-center">
            <?= Ty::get('banktransfer') ?>
          </div>
          <div class="sub-title-page d-flex justify-content-center">
            *<?= Ty::get('plsuseregistered') ?>
          </div>
        </div>
        <div class="card-content mb-10px m-height-unset">
          <div class="card-content-body text-center">
            <div class="card-bank">
              <div class="icon-bank">
                <img src="source/mock_bank.png" class="rounded">
                <!-- <img src="<?= $bank_data['image'] ?>" alt="" class="rounded"> -->
              </div>
              <p class="text-white mb-5px"><?= "ธนาคาร ไทยพาณิชย์ จำกัด (มหาชน)" //$bank_data['name_th'] ?></p>
              <h2 class="font-24px mb-10px font-Bold number_copy"><?= "123-4-56789-0" //textFormat($bank_data['bank_account_no'], '___-_-_____-_', '-'); ?></h2>
              <p class="text-white mb-5px"><?= Ty::get('accountname') ?>: <?= "testestest" //$bank_data['bank_account_name']; ?></p>
              <button class="btn btn-copy-code border event_btn_copy">
                <img src="assets/icon/copy.svg" alt="copy">
                <?= Ty::get('copyaccuntnmb') ?>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="title-table">
          <?= Ty::get('deposithistory') ?>
        </div>
        <div id="deposit_list" class="container-pagination table-custom" <?= Homepagify::createHomepagify('deposit_list', '', '', 'รายการถอน', ''); ?>>
          <div class="table-responsive">
            <table class="table table-sort table-theme">
              <thead>
                <tr>
                  <th nowrap class="text-white" data-sort=""><?= Ty::get('dateandtime') ?></th>
                  <th nowrap class="text-white thin-cell text-end" data-sort=""><?= Ty::get('amount') ?></th>
                  <th nowrap class="text-white text-end no-sort" data-sort=""><?= Ty::get('status') ?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php Tiwdal::startModal('modal_detail', 'modal-sm modal-no-more modal-dialog-centered'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <div class="title">
      <?= Ty::get('trans_time', [], ["case" => "ucfirst"]) ?>
    </div>
    <p class="detail">
      <span name="{date_trans}"></span>
    </p>
    <div class="title">
      <?= Ty::get('transfer_acc', [], ["case" => "ucfirst"]) ?>
    </div>
    <p class="detail">
      <span name="{transfer_data}"></span>
    </p>
    <div class="title">
      <?= Ty::get('dep_balance') ?>
    </div>
    <p class="detail">
      <span name="{credit_amount}"></span>
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
    <div class="title">
      <?= Ty::get('reason') ?>
    </div>
    <p class="detail">
      <span name="{remark}"></span>
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn-main rounded ">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <div class="menu-fix-right">
    <a href="<?= $system_line['line_link'] ?>" target="_blank">
      <div class="menu-line">
        <div class="box-close event_close_fix_menu">
          <?= file_get_contents('assets/icon/close.svg') ?>
        </div>
      </div>
    </a>
  </div>

  <?php Tiwdal::startModal('modal_kbank_condition', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <p class="detail font-16px text-center" style="white-space: pre-line">
      ขณะนี้ไม่สามารถดึงรายการฝากได้ เนื่องจากเว็บธนาคารใช้งานไม่ได้ ขออภัยในความไม่สะดวก
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

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

  <script>
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

      $(document).on('click', '.event_close_fix_menu', function(e) {
        e.preventDefault();
        $(this).parents('a').fadeOut(300, function() {
          $(this).remove();
        });
      });

      $(document).on("click", ".event_btn_copy", function(e) {
        copyToClipboard($(".number_copy"));
        Aww.notification("success", "Copied");
      });

      $(document).on('click', '.event_confirm', function() {
        var user_id = $(this).attr('user_id');
        var promotion_id = $(this).attr('promotion_id');
        var promotion_name = $(this).attr('promotion_name');
        var type = $(this).attr('unit_type');
        var amount = $(this).attr('amount');
        if (type == 'credit') {
          var type_msg = '<?= Ty::get('credit', [], ['case' => 'ucfirst']) ?>';
          var currency = '<?= Ty::get('baht', [], ['case' => 'ucfirst']) ?>';
        } else {
          var type_msg = '<?= Ty::get('point', [], ['case' => 'ucfirst']) ?>';
          var currency = '<?= Ty::get('point', [], ['case' => 'ucfirst']) ?>';
        }

        var params = {
          user_id: user_id,
          promotion_id: promotion_id,
          promotion_name: promotion_name,
        };

        $.post('ajax/ajax_promotion_redemption.php', params)
          .done(function(data) {
            var result = JSON.parse(data);
            if (result.response_status) {
              $('.backdrop-claim').find('.scope_type').text(type_msg)
              $('.backdrop-claim').find('.scope_amount_receive').text(Aww.formatMoney(amount) + ' ' + currency);

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

      $(document).on('click', '.event_confirm_deposit', function() {
        var user_id = $(this).attr('user_id');
        var promotion_id = $(this).attr('promotion_id');
        var type = $(this).attr('unit_type');
        var amount = $(this).attr('amount');
        var type_msg = '<?= Ty::get('credit', [], ['case' => 'ucfirst']) ?>';
        var currency = '<?= Ty::get('baht', [], ['case' => 'ucfirst']) ?>';

        var params = {
          user_id: user_id,
          promotion_id: promotion_id,
        };

        $.post('ajax/ajax_promotion_deposit.php', params)
          .done(function(data) {
            var result = JSON.parse(data);
            if (result.response_status) {
              $('.backdrop-claim').find('.scope_type').text(type_msg)
              $('.backdrop-claim').find('.scope_amount_receive').text(Aww.formatMoney(amount) + ' ' + currency);

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
    });
  </script>
</body>

</html>