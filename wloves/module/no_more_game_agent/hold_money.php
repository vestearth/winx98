<?php
$_WLOVES['no_check_permission'] = 1;
$_PAGE['permission'] = ['no_more_game_agent', 'management_hold_money', 'hold_money'];
require_once '../../.framework/import.php';
$code = $_GET['c'];
$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : 0;
$current_user = User::getCurrent();

if ($_POST) {
  if (isset($_POST['submit_create_hold_money'])) {

    // Aww::display($current_user);
    // Aww::display($_POST);
    // die();
    if ($current_user['pin'] == $_POST['pin']) {
      $result = nga_bank_hold_money_api::transferMoneyBotSCB($code, $id, $_POST['amount'], $_POST['to_bank_abb'], $_POST['to_bank_account_no']);
    } else {
      $result = [
        'response_status' => false,
        'response_message' => 'รหัส PIN ไม่ถูกต้อง',
      ];
    }
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('../../');
  Aww::loadAsset('assets/css/no_more_gaming.css');
  ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php include_once '../../structure/layout/header-default.php'; ?>
  <?php
  F_WLoves::checkHiddenPermission();
  ?>
  <div class="bg-card mb-10px pb-10px pt-10px">
    <div class='topic ml-10px'>การพักเงิน</div>
    <div class="font-14px text-sub ml-10px">
      เลือกบัญชีที่คุณต้องการเพื่อสร้างรายการโอนเงิน
    </div>
  </div>

  <div class="form-row">
    <div class="col-xl-5">
      <div id="hold_money_account" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('hold_money_account', '?c=' . $_GET['c'] . '&id=' . $id, '', 'บัญชีธนาคาร') ?>>
        <div class="table-responsive">
          <table class="table table-sort table-search ">
            <thead>
              <tr>
                <th nowrap data-sort="bot_name" data-filter="<?= Homepagify::dataFilter('bot_name', 'text') ?>">ชื่อ BOT</th>
                <th nowrap data-sort="bank_account_no" data-filter="<?= Homepagify::dataFilter('bank_account_no', 'text') ?>">บัญชี</th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <?php if ($id) {
      // เรียกลิสต์ธนาคาร 
      $bank = Bank::select();
      $bank_list = [];

      foreach ($bank as $data) {
        $bank_list['list'][] = [
          'value' => $data['abb'],
          'name' => $data['name_th'],
        ];
      }

      // หัวตารางขวา 
      $get_detail_bot = nga_management_bot::getBotHoldMoneyByID($code, $id);
      // ยอดเงินคงเหลือ -> 
      $balance_bot = nga_bank_hold_money_api::getBalanceBotSCB($code, $id);
      if ($balance_bot['response_status']) {
        $balance_bot_data = $balance_bot['response_data'];
      } else {
        $balance_bot_data = [];
      }
      // Statement 100 รายการล่าสุด
      $statement_list = nga_bank_hold_money_api::getStatementBotSCBByPageNum($code, $id, 10);
      if ($statement_list['response_status']) {
        $statement_data = $statement_list['response_data'];
      } else {
        $statement_data = [];
      }
    ?>
      <div class="col-xl-7">
        <div class="bg-card">
          <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="py-10px px-15px">
              <div class="font-16px font-SemiBold">รายการเดินบัญชี | <span class="text-primary"><?= $get_detail_bot['bot_name']; ?> / <?= $get_detail_bot['bank_name_th']; ?> / <?= $get_detail_bot['bank_account_no']; ?></span></div>
              <div class="font-14px font-Regular">รายการประวัติการเงินตามการทำงานของ BOT</div>
            </div>
            <div class="py-10px px-15px">
              <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'pl-20px pr-20px'], ['type' => 'button', 'text' => '+ สร้างรายการโอนเงิน', 'modal_id' => 'create_hold_money', 'modal_data' => []]); ?>
            </div>
          </div>
          <hr class="my-0">
          <div class="p-15px">
            <div class="card-header-primary py-10px font-SemiBold font-14px text-info d-flex align-items-center justify-content-between">
              <div class="">ยอดเงินคงเหลือ</div>
              <div class="btn-cooldown __update_summary">
                <div class="cooldown-icon">
                  <?= file_get_contents('assets/icon/icon-cooldown.svg') ?>
                </div>
                <div class="cooldown-text balance_txt">อัปเดตข้อมูล</div>
              </div>
            </div>
            <div class="card-white px-15px py-10px font-Medium">
              <div class="d-flex align-items-center justify-content-between">
                <div class="font-20px text-primary font-Bold">
                  <span class="__summary_amount"><?= (isset($balance_bot_data['totalAvailableBalance']) && $balance_bot_data['totalAvailableBalance']) ? number_format($balance_bot_data['totalAvailableBalance'], 2) : ''; ?></span> <span class="font-14px font-Medium text-secondary">บาท</span>
                </div>
                <div class="font-15px text-secondary">อัปเดตเมื่อ <span class="__summary_datetime"><?= Aww::formatDate(date('Y-m-d H:i:s'), 'd/m/Y, H:i'); ?></span></div>
              </div>
            </div>
          </div>
          <hr class="my-0">
          <div class="d-flex align-content-center justify-content-between px-15px py-10px">
            <div class="font-16px font-SemiBold">Statement 100 รายการล่าสุด</div>
            <div class="font-15px font-Regular text-placeholder d-flex align-items-center">
              <span class="pr-10px">
                อัปเดตเมื่อ <span class="__statement_datetime"><?= Aww::formatDate(date('Y-m-d H:i:s'), 'd/m/Y, H:i'); ?></span>
              </span>
              <div class="btn-cooldown __update_statement">
                <div class="cooldown-icon">
                  <?= file_get_contents('assets/icon/icon-cooldown.svg') ?>
                </div>
                <div class="cooldown-text statement_txt">อัปเดตข้อมูล</div>
              </div>
            </div>
          </div>
          <hr class="my-0">
          <div id="hold_money_statement" class="bg-white">
            <div class="table mb-0 table-striped">
              <div class="table-responsive">
                <table class="table table-sort table-search">
                  <thead>
                    <tr>
                      <th nowrap>วัน/เวลา</th>
                      <th nowrap>รายละเอียด</th>
                      <th nowrap>ประเภทรายการ</th>
                      <th nowrap>ยอดเงิน (บาท)</th>
                    </tr>
                  </thead>
                  <tbody class="refresh_data_event">
                    <?php foreach ($statement_data as $statement) {
                      $type = (isset($statement['txnCode']) && $statement['txnCode']) ? $statement['txnCode'] : [];
                      if (in_array($type['description'], ['ถอนเงิน', 'Withdrawal'])) {
                        $withdraw_deposit = 'ถอนเงิน';
                      } else if ($type['description'] == 'ฝากเงิน') {
                        $withdraw_deposit = 'ฝากเงิน';
                      }
                    ?>
                      <tr>
                        <td nowrap>
                          <?= (isset($statement['txnDateTime']) && $statement['txnDateTime']) ? Aww::formatDate($statement['txnDateTime'], 'd/m/Y H:i:s') : ''; ?>
                        </td>
                        <td nowrap>
                          <?= (isset($statement['txnRemark']) && $statement['txnRemark']) ? $statement['txnRemark'] : ''; ?>
                        </td>
                        <td nowrap>
                          <?php if ($withdraw_deposit == 'ฝากเงิน') { ?>
                            <span class="text-success">ฝากเงิน</span>
                          <?php } else if ($withdraw_deposit == 'ถอนเงิน') { ?>
                            <span class="text-danger">ถอนเงิน</span>
                          <?php } ?>
                        </td>
                        <td nowrap class="text-right">
                          <?= (isset($statement['txnAmount']) && $statement['txnAmount']) ? number_format($statement['txnAmount'], 2) : ''; ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      </div>
    <?php } ?>
  </div>

  <?php Tiwdal::startModal('create_hold_money', 'modal-md'); ?>
  <form method="post" autocomplete="off" class="form-loading">
    <?php
    $total_amount = (isset($balance_bot_data['totalAvailableBalance']) && $balance_bot_data['totalAvailableBalance']) ? number_format($balance_bot_data['totalAvailableBalance'], 2) : 0;
    ?>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    <div class="modal-header">
      <h5 class="font-16px font-SemiBold text-info">สร้างรายการโอนเงิน</h5>
    </div>
    <div class="modal-body">
      <div class="form-row mb-15px">
        <div class="col-sm-4 font-14px font-Medium text-secondary">
          บัญชีต้นทาง
        </div>
        <div class="col-sm-8">
          <div class="d-flex">
            <div class="bank-img small-size mr-5px">
              <img src="<?= $get_detail_bot['bank_image']; ?>">
            </div>
            <div class="d-flex flex-column text-primary">
              <div class="font-16px font-SemiBold"><?= $get_detail_bot['bank_name_th']; ?></div>
              <div class="font-16px"><?= $get_detail_bot['bank_account_no']; ?></div>
              <div class="font-14px"><?= $get_detail_bot['bank_account_name']; ?></div>
            </div>
          </div>
        </div>
      </div>
      <div class="form-row mb-15px">
        <div class="col-sm-4 font-14px font-Medium text-secondary">
          ยอดเงินคงเหลือ
        </div>
        <div class="col-sm-8 font-16px font-Regular text-info"><?= $total_amount; ?> บาท</div>
      </div>
      <div class="form-row mb-15px">
        <div class="col-sm-4 font-14px font-Medium text-secondary pt-7px">
          บัญชีธนาคารปลายทาง<span class="text-danger">*</span>
        </div>
        <div class="col-sm-8">
          <?php
          $bank_key = [
            'value' => 'abb',
            'name' => 'name_th',
          ];
          $bank_options = TiwForm::generateSelectData($bank, $bank_key, ['is_search' => true]);
          TiwForm::normal('select', '', ['name' => 'to_bank_abb', 'class' => 'mb-0 event_bank_id', 'placeholder' => 'เลือกธนาคาร', 'required' => true], $bank_list);
          ?>
        </div>
      </div>
      <div class="form-row mb-15px">
        <div class="col-sm-4 font-14px font-Medium text-secondary pt-7px">
          เลขที่บัญชี<span class="text-danger">*</span>
        </div>
        <div class="col-sm-8">
          <?= TiwForm::normal('number', '', ['name' => 'to_bank_account_no', 'class' => 'mb-0 event_bank_account', 'placeholder' => 'กรอก', 'required' => true]) ?>
        </div>
      </div>
      <div class="form-row mb-15px">
        <div class="col-sm-4 font-14px font-Medium text-secondary">
          ชื่อบัญชี
        </div>
        <div class="col-sm-8 font-16px font-Regular text-info scope_account_name"></div>
      </div>
      <div class="form-row mb-15px">
        <div class="col-sm-4 font-14px font-Medium text-secondary pt-7px">
          จำนวนเงิน (บาท)<span class="text-danger">*</span>
        </div>
        <div class="col-sm-8">
          <div class="d-flex align-items-center flex-wrap">
            <?= TiwForm::normal('number', '', ['name' => 'amount', 'class' => 'mb-0 max-w-200px', 'placeholder' => '0.00', 'required' => true, 'max' => $total_amount]) ?>
            <div class="text-danger pl-10px">สูงสุด <?= $total_amount; ?></div>
          </div>
        </div>
      </div>
      <div class="form-row mb-15px">
        <div class="col-sm-4 font-14px font-Medium text-secondary pt-7px">
          PIN<span class="text-danger">*</span>
        </div>
        <div class="col-sm-8">
          <?= TiwForm::normal('number', '', ['name' => 'pin', 'class' => 'mb-0 max-w-200px password-style', 'placeholder' => 'กรอก', 'required' => true]) ?>
        </div>
      </div>

    </div>
    <div class="modal-footer justify-content-end">
      <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ยกเลิก</button>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_create_hold_money', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'สร้าง']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>


  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

  <?php if ($id) { ?>
    <script>
      $(function() {
        $(document).on('click', '.__update_summary', function() {
          $('.balance_txt').text('กำลังโหลดข้อมูล...')
          //reload summary amount
          var url = 'ajax/ajax_summary_hold_money.php?c=<?= $_GET['c'] ?>&id=<?= $id ?>';
          var params = {};
          $.post(url, params).done(function(data) {
            var result = JSON.parse(data);
            var amount = parseFloat(result.amount);
            $('.balance_txt').text('อัปเดตข้อมูล')
            $('.__summary_amount').html(Aww.formatMoney(amount, 2));
          });

          //reload datetime
          var datetime = dateTimeNow();
          $('.__summary_datetime').html(datetime);
        });

        $(document).on('click', '.__update_statement', function() {
          //reload table
          $('.statement_txt').text('กำลังโหลดข้อมูล...')
          var url = 'ajax/table_hold_money_statement.php?c=<?= $_GET['c'] ?>&id=<?= $id ?>';
          var params = {};
          $.post(url, params).done(function(data) {
            $('.refresh_data_event').html(data);
            $('.statement_txt').text('อัปเดตข้อมูล')
          });
          //reload datetime
          var datetime = dateTimeNow();
          $('.__statement_datetime').html(datetime);
        });

        $(document).on('change', '.event_bank_account', function() {
          var bank_id = $('.event_bank_id').val();
          var $scopeAccount = $('.scope_account_name');
          var text = $(this).val();
          var count = text.length;
          var bank_account = '';
          if (count < 10 || count > 14) {
            $('.scope_account_name').text('กรุณากรอกเลขบัญชีให้มีความยาว 10-14 หลัก');
          } else {
            $('.scope_account_name').text('กรุณารอสักครู่...');
            var bank_account = text;
          }
          var params = {
            code: '<?= $code ?>',
            bank_id: bank_id,
            bank_account: bank_account,
          };
          $.post('ajax/ajax_check_bank.php', params)
            .done(function(data) {
              var result = JSON.parse(data);
              if (result.is_found) {
                $scopeAccount.text(result.account_name);
              } else {
                $scopeAccount.text('ไม่พบข้อมูล');
              }
            })

        })

        // Ajax ตอนเลือกธนาคาร
        $(document).on('change', '.event_bank_id', function() {
          var bank_id = $(this).val();
          var text = $('.event_bank_account').val();
          var count = text.length;
          var $scopeAccount = $('.scope_account_name');
          var bank_account = '';

          if (count < 10 || count > 14) {
            $('.scope_account_name').text('กรุณากรอกเลขบัญชีให้มีความยาว 10-14 หลัก');
          } else {
            $('.scope_account_name').text('กรุณารอสักครู่...');
            var bank_account = text;
          }
          var params = {
            code: '<?= $code ?>',
            bank_id: bank_id,
            bank_account: bank_account,
          };
          console.log(params);

          $.post('ajax/ajax_check_bank.php', params)
            .done(function(data) {
              var result = JSON.parse(data);
              console.log(result);
              if (result.is_found) {
                $scopeAccount.text(result.account_name);
              } else {
                $scopeAccount.text('ไม่พบข้อมูล');
              }
            })
        })

      });

      function dateTimeNow() {
        var date_now = new Date();
        var datetime = pad(date_now.getDate(), 2) + '/' +
          pad((date_now.getMonth() + 1), 2) + '/' +
          date_now.getFullYear() + ', ' +
          pad(date_now.getHours(), 2) + ':' +
          pad(date_now.getMinutes(), 2);
        return datetime;
      }

      function pad(num, size) {
        var s = "000000000" + num;
        return s.substr(s.length - size);
      }
    </script>
  <?php } ?>

  </div>
</body>

</html>