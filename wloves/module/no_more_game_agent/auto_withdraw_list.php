<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'auto_withdraw'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav']);

$code = $_GET['c'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$count = nga_user::countWaitDepositWithdraw($code);
$current_user = User::getCurrentUserID();
$data_nav = [
  'param_name'  => 'page',
  'class' => 'bg-whites',
  'list' => [
    [
      'id'  => 1,
      'name'  => 'รออนุมัติ (' . $count['wait_confirm'] . ')',
    ],
    [
      'id'  => 2,
      'name'  => 'ประวัติ',
    ]
  ]
];
$link = 'auto_withdraw_list.php?c=' . $_GET['c'];

$type_list = [

  [
    'value' => 'deposit',
    'text' => 'ฝากเงิน'
  ],
  [
    'value' => 'withdraw',
    'text' => 'ถอนเงิน'
  ],
];

$status_list = [
  [
    'value' => 'completed',
    'text' => 'สำเร็จแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ยกเลิก'
  ],
];

if ($_POST) {
  if (isset($_POST['submit_accept'])) {
    $result = nga_user::confirmWithdraw($code, $_POST['id'], $_POST['bot_group_list_id']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'อนุมัติถอนเงิน',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_deny'])) {
    $result = nga_user::cancelWithdraw($code, $_POST['id'], $_POST['remark']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'ยกเลิกถอนเงิน',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
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

  <div class="editable-card core-new border-radius-bottom-0 ">
    <div class="editable-card-header rounded-0 d-flex justify-content-between p-0 bg-whites nav-lines">
      <?= Boatnav::dinner($data_nav, $link); ?>
    </div>
  </div>
  <?php if ($page == 1) { ?>
    <div id="auto_withdraw" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('auto_withdraw', '?c=' . $code, '', 'รายการ') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
              <th nowrap data-sort="transaction_type">ประเภท</th>
              <th nowrap data-sort="customer_username" data-filter="<?= Homepagify::dataFilter('customer_username', 'text') ?>">ยูสเซอร์ (agent)</th>
              <th nowrap data-sort="customer_bank_name" data-filter="<?= Homepagify::dataFilter('customer_bank_name', 'text') ?>">บัญชีลูกค้า</th>
              <th nowrap data-sort="web_bank_name" data-filter="<?= Homepagify::dataFilter('web_bank_name', 'text') ?>">บัญชีเว็บ</th>
              <th nowrap data-sort="credit_amount" data-filter="<?= Homepagify::dataFilter('credit_amount', 'text') ?>" class="thin-cell">จำนวน</th>
              <th nowrap data-sort="credit_before" class="thin-cell">เครดิต (ก่อน)</th>
              <th nowrap data-sort="credit_after" class="thin-cell">เครดิต (หลัง)</th>
              <th nowrap data-sort="status" width="10%">สถานะ</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  <?php } else if ($page == 2) { ?>
    <div id="auto_withdraw_history" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('auto_withdraw_history', '?c=' . $code, '', 'รายการ') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
              <th nowrap data-sort="transaction_type">ประเภท</th>
              <th nowrap data-sort="customer_username" data-filter="<?= Homepagify::dataFilter('customer_username', 'text') ?>">ยูสเซอร์ (agent)</th>
              <th nowrap data-sort="customer_bank_name" data-filter="<?= Homepagify::dataFilter('customer_bank_name', 'text') ?>">บัญชีลูกค้า</th>
              <th nowrap data-sort="web_bank_name" data-filter="<?= Homepagify::dataFilter('web_bank_name', 'text') ?>">บัญชีเว็บ</th>
              <th nowrap data-sort="credit_amount" data-filter="<?= Homepagify::dataFilter('credit_amount', 'text') ?>" class="thin-cell">จำนวน</th>
              <th nowrap data-sort="credit_before" class="thin-cell">เครดิต (ก่อน)</th>
              <th nowrap data-sort="credit_after" class="thin-cell">เครดิต (หลัง)</th>
              <th nowrap data-sort="status">สถานะ</th>
              <th nowrap data-sort="remark" class="thin-cell">หมายเหตุ</th>
              <th></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  <?php } ?>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php
  Structure::loadFooter('../../');
  Aww::loadAsset('assets/js/force_logout.js');
  ?>
  </div>
  <?php Tiwdal::ajaxModal('auto_withdraw_detail', 'modal-xl'); ?>


  <?php Tiwdal::startModal('modal_bot_statement_detail', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title font-16px font-SemiBold">รูปภาพ</h5>
    </div>
    <div class="modal-body px-15px">
      <div class="row">
        <div class="col-12 d-flex justify-content-center">
          <div class="w-100 d-flex justify-content-center">
            <img src="assets/image/placeholder_square.jpg" name="{admin_confirm_image}" class="w-500px border-bottom-radius-10px object-fit-contain">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-cancels min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'กลับ']); ?>
  </div>
  <?php Tiwdal::endModal() ?>


</body>

</html>

<script>
  $(document).ready(function() {
    // timeCount();
    $(document).on('change', '.event_select_data_bank input[select_value]', function(e) {
      var select_id = $(this).val();
      var modal = $(this).closest('.modal');
      if (select_id) {
        modal.find('.scope_show_current_balance').show();
        modal.find('.scope_current_balance').hide();
        modal.find('.scope_current_balance[data-id=' + select_id + ']').show();
      } else {
        modal.find('.scope_show_current_balance').hide();
        modal.find('.scope_current_balance').hide();
      }
    });
  });

  function timeCount() {
    var myTimer, timing = 60;
    $('#timing').html(timing);
    myTimer = setInterval(function() {
      --timing;
      $('#timing').html(timing);
      if (timing === 0) {
        clearInterval(myTimer);
        window.location = "";
      }
    }, 1000);
  }
</script>