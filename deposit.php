<?php
require_once '.framework/import.php';
require_once 'layout/footer_nav.php';
require_once 'layout/navbanner.php';

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

    // $customer_data = nga_user::getUserByID($code, $user_data['id']);
    // $get_auto_wd = nga_management::getAutoDepositWithdraw($code);

    // $check_bank_allow = nga_user::getBankNameByBankNo($code, $user_data['bank_abb'], $user_data['bank_number']);
    // $user_group = nga_management::getUserGroupByID($code, $user_data['user_group_id']);
    // $is_kbank = isset($user_group['withdraw_bank_abb']) ? $user_group['withdraw_bank_abb'] : false;

    // New API 
    $check_deposit = nga_bank_pg_deposit_api::checkDeposit($code, $user_data['id']);
    $check_deposit_response = isset($check_deposit['response_data']) ? $check_deposit['response_data'] : [];
    $transaction_status = is_array($check_deposit_response) && isset($check_deposit_response['transaction_status']) ? $check_deposit_response['transaction_status'] : '';

    if (!isset($check_deposit_response['step'])) {
      $check_deposit_response['step'] = -1;
    }

    if ($check_deposit['response_status'] == false) {
      Aww::notification($check_deposit['response_message'], 'error');
      Aww::redirect('');
    }
    if ($_POST) {
      if (isset($_POST['submit_deposit'])) {
        $data = [
          'user_id' => $user_data['id'],
          'credit_amount' => $_POST['credit_amount'],
        ];
        $result = nga_bank_pg_deposit_api::addDeposit($code, $data);
      } else if (isset($_POST['submit_image'])) {
        $upload_image = isset($_FILES['upload_image']) ? $_FILES['upload_image'] : false;
        $result = nga_bank_pg_deposit_api::verifyDeposit($code, $user_data['id'], $upload_image);
        // Aww::display($result);
        // die();
      } else if (isset($_POST['submit_cancel_image'])) {
        $result = nga_bank_pg_deposit_api::cancelDeposit($code, $user_data['id']);
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
    // Aww::redirectOG('login.php');
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
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('deposit') ?></li>
          </ol>
        </nav>
      </div>
      <div class="col-12">
        <div class="wallet-section">
          <div class="balance-card">
            <div class="balance-left">
              <p class="balance-label">กระเป๋าเงิน</p>
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
      <? navDepositWithdraw('deposit'); ?>
      <div class="col-md-6">
        <div class="mt-20px mb-15px">
          <div class="tltle-page d-flex justify-content-center">
            <?= Ty::get('banktransfer') ?>
          </div>
          <div class="sub-title-page d-flex justify-content-center">
            *<?= Ty::get('plsuseregistered') ?>
          </div>
        </div>
        <!-- <form method="post" enctype="multipart/form-data">
        </form> -->

        <?php
        if ($check_deposit_response['step'] == 1) {
          $bank_data = $check_deposit_response['transaction_pg_get_bank'];
        ?>
          <div class="card-content mb-20px pb-0 have-bg min-h-200px">
            <div class="card-content-body text-center mb-20px">
              <div class="card-bank">
                <div class="icon-bank">
                  <img src="https://winx98.com/system/resource/bank/<?= $bank_data['bank_code'] ?>.png" alt="" class="rounded">
                </div>
                <p class="text-white mb-5px"><?= $bank_data['bank_name'] ?></p>
                <h2 class="font-24px mb-10px font-Bold"><?= textFormat($bank_data['bank_account_number'], '___-_-_____-_', '-'); ?></h2>
                <span class="d-none number_copy"><?= $bank_data['bank_account_number']; ?></span>
                <p class="text-white mb-5px"><?= Ty::get('accountname') ?>: <?= $bank_data['account_name']; ?></p>
                <p class="text-white mb-5px">กรุณาโอนภายใน <?= Aww::formatDate($bank_data['expired_date'], 'd-M-Y H:i:s'); ?></p>
                <button class="btn btn-copy-code border event_btn_copy">
                  <img src="assets/icon/copy.svg" alt="copy">
                  <?= Ty::get('copyaccuntnmb') ?>
                </button>
              </div>
            </div>
          </div>
          <div class="card-content mb-20px pb-0 have-bg min-h-200px">
            <div class="card-content-body text-center">
              <form method="post" enctype="multipart/form-data">
                <p class="font-24px" style="color: #fff; text-shadow: 0 0 8px #76060B , 0 0 16px #76060B , 0 0 24px #76060B ; border-radius: 8px; padding: 8px 0;"><strong>คำเตือน !! โปรดอัพสลิปภายใน 15 นาที </strong></p>
                <div class="d-flex justify-content-lg-center align-items-center">
                  <span class="text-white mb-10px"><?= "อัพโหลดรูปภาพ" ?></span>
                </div>
                <input type="file" name="upload_image" class="input-custom mb-5px" accept="image/*" required>
                <button name="submit_image" type="submit" class="btn-main btn-withdraw max-w-305px">
                  <?= 'อัพโหลดสลิป'; ?>
                </button>
              </form>
              <form method="post">
                <div class="d-flex justify-content-center align-items-center mt-10px">
                  <button name="submit_cancel_image" type="submit" class="btn-main btn-cancel btn-withdraw max-w-305px event_refresh">
                    <?= 'ยกเลิกการอัพโหลด'; ?>
                  </button>
                </div>
              </form>
            </div>
          </div>
        <?php } else if ($check_deposit_response['step'] == 0) { ?>
          <form id="deposit_form" method="post" enctype="multipart/form-data">
            <div class="card-content mb-20px pb-0 have-bg min-h-200px">
              <div class="card-content-body text-center">
                <div class="d-flex justify-content-lg-center align-items-center">
                  <span class="text-white mb-10px"><?= "จำนวนเงินที่ต้องการฝาก" ?></span>
                </div>
                <input type="number" name="credit_amount" class="input-custom mb-15px event_text_data event_check_int" placeholder="<?= Ty::get('fillamountofmoney', [], ["case" => "ucfirst"]) ?>" min="<?= 100; ?>" step="any">
                <!-- event_send_data -->
                <button type="button" class="btn-main btn-withdraw max-w-305px event_submit_deposit" <?php Tiwdal::register('modal_confirm_deposit', []); ?>
                  <?= $check_deposit['response_status'] == false ? 'disabled' : '' ?>>
                  <?= Ty::get('confirm2') ?>
                </button>
                <input type="hidden" name="submit_deposit" value="1">
              </div>
            </div>

            <div class="detail max-w-305px m-auto mt-15px">
              <span class="text-gold"><?= Ty::get('note', [], ["case" => "ucfirst"]) ?></span>
              <ul>
                <li>ฝากเงินขั้นต่ำ 100 บาท
                </li>
                <li>กรุณาคัดลอกเลขที่บัญชีใหม่ทุกครั้งก่อนทำรายการโอนเงิน</li>
                <li>ห้ามใช้เลขบัญชีจากประวัติการโอนเด็ดขาด</li>
                <li>เนื่องจากระบบใช้เลขบัญชีแบบ ครั้งเดียวเท่านั้น</li>
                <li>หากลูกค้าโอนเงินซ้ำโดยใช้เลขบัญชีเดิม บริษัทจะไม่รับผิดชอบในทุกกรณี</li>
              </ul>
            </div>
          </form>
        <?php } else if ($check_deposit_response['step'] == 2) { ?>
          <div class="card-content mb-20px pb-0 have-bg min-h-200px d-flex align-items-center justify-content-between">
            <div class="card-content-body text-center mb-20px w-100 font-18px">
              กรุณารอการทำรายการ
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="col-md-6 mb-75px">
        <div class="title-table">
          <?= Ty::get('withdrawal_history') ?>
        </div>
        <div id="deposit_list" class="container-pagination table-custom" <?= Homepagify::createHomepagify('deposit_list', '', '', 'รายการถอน', ''); ?>>
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

  <?php Tiwdal::startModal('modal_confirm_deposit', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <div class="title text-center text-pink-2">
      <?= 'ยืนยันการฝาก'; ?>
    </div>
    <p class="detail text-center font-18px">
      <span>
        <?= "ฝากเข้าบัญชี"; ?>
      </span>
    </p>
    <p class="detail text-center mb-0 font-18px"><?= "ยอดฝาก" ?> <span class="event_number_input"></span> <?= Ty::get('baht', [], ["case" => "strtolower"]) ?></p>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-main event_confirm_deposit" data-bs-dismiss="modal" aria-label="Close">
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
      <? // $get_auto_wd['withdraw_condition'] 
      ?>
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


  <div class="menu-fix-right">
    <a href="<?= 'https://line.me/R/ti/p/@152kglax?oat_content=url&ts=05140244'; ?>" target="_blank">
      <div class="menu-line">
        <div class="box-close event_close_fix_menu">
          <?= file_get_contents('assets/icon/close.svg') ?>
        </div>
      </div>
    </a>
  </div>


  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/main.js');
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

  <script>
    $(document).on('click', '.event_confirm_deposit', function() {
      $('#deposit_form').submit();
    });
    $(document).ready(function() {
      var currentTime = new Date(); // Get the current time
      var currentHour = currentTime.getHours(); // Get the current hour
      // Check if the current time is within the specified range
      if ((currentHour >= 16 && currentHour <= 23) || (currentHour >= 0 && currentHour <= 6)) {
        // Disable the button
        // $('#modal_maintenance').modal('show');
      }

      // var bank_run = '<? // $check_bank_allow['account_name']; 
                          ?>';
      // var is_kbank = '<? // $is_kbank; 
                          ?>';
      // if (!bank_run && is_kbank == 'KBANK') {
      //   $('#modal_kbank_condition').modal('show');
      // }
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

      $(document).on("click", ".event_btn_copy", function(e) {
        copyToClipboard($(".number_copy"));
        Aww.notification("success", "Copied");
      });

      $(document).on("click", ".event_send_data", function(e) {
        var price = $('.event_text_data').val();
        $(".event_number_input").text(Aww.formatMoney(price, 2));
        $(".event_number_input").attr('data-amount', price);
      });


      $(document).on("click", ".event_submit_deposit", function(e) {
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

  <script>
    $(document).ready(function() {
      // Handle button clicks
      $('.nav-button').on('click', function() {
        const $button = $(this);
        const buttonId = $button.attr('id');

        // Remove active class from all buttons
        $('.nav-button').removeClass('active');

        // Add active class to clicked button
        $button.addClass('active');

        // Add loading state
        $button.addClass('loading');

        // Handle different button actions
        switch (buttonId) {
          case 'downloadBtn':
            handleDownload($button);
            break;
          case 'loginBtn':
            handleLogin($button);
            break;
        }
      });

      // Handle download action
      function handleDownload($button) {
        console.log('Download button clicked');

        // Simulate download process
        setTimeout(() => {
          $button.removeClass('loading');
          showNotification('เริ่มดาวน์โหลดแล้ว', 'success');
        }, 1500);

        // You can add actual download logic here
        // For example: window.open('path/to/file.zip', '_blank');
      }

      // Handle login action
      function handleLogin($button) {
        console.log('Login button clicked');

        // Simulate login process
        setTimeout(() => {
          $button.removeClass('loading');
          showNotification('กำลังเข้าสู่ระบบ...', 'info');

          // Redirect to login page or show login modal
          // window.location.href = '/login';
        }, 1000);
      }

      // Notification system
      function showNotification(message, type = 'info') {
        // Remove existing notifications
        $('.notification').remove();

        const notification = $(`
            <div class="notification notification-${type}">
                <i class="fas fa-${getNotificationIcon(type)}"></i>
                <span>${message}</span>
            </div>
        `);

        $('body').append(notification);

        // Show notification
        setTimeout(() => {
          notification.addClass('show');
        }, 100);

        // Hide notification after 3 seconds
        setTimeout(() => {
          notification.removeClass('show');
          setTimeout(() => {
            notification.remove();
          }, 300);
        }, 3000);
      }

      // Get notification icon based on type
      function getNotificationIcon(type) {
        switch (type) {
          case 'success':
            return 'check-circle';
          case 'error':
            return 'exclamation-circle';
          case 'warning':
            return 'exclamation-triangle';
          default:
            return 'info-circle';
        }
      }

      // Keyboard accessibility
      $('.nav-button').on('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          $(this).click();
        }
      });

      // Add ARIA attributes for accessibility
      $('.nav-button').attr({
        'role': 'button',
        'tabindex': '0',
        'aria-pressed': 'false'
      });

      // Update aria-pressed when button becomes active
      $('.nav-button').on('click', function() {
        $('.nav-button').attr('aria-pressed', 'false');
        $(this).attr('aria-pressed', 'true');
      });
    });
  </script>
</body>

</html>