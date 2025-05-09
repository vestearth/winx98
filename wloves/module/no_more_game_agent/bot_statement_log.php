<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'bot_statement_log'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav', 'brandnote']);
$code = $_GET['c'];
$date_checked = '';
$current_user = User::getCurrentUserID();

if ($_POST) {
  if (isset($_POST['submit_deposit_bot'])) {
    $data = [
      'bot_statement_id' => $_POST['id'],
      'user_id' => $_POST['user_id'],
      'admin_user_id' => User::getCurrentUserID()
    ];
    $alias_checked = isset($_POST['alias_saved']) && $_POST['alias_saved'] ? 1 : 0;
    if ($alias_checked) {
      $add_allias = nga_user::addNewUserBankAlias($code, $_POST['user_id'], $_POST['transaction_from_bank_no_num']);
    }
    $result = nga_management_bot::matchDepositBotStatement($code, $data, $_FILES['upload_img']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'แมทช์รายการฝากให้ลูกค้า',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_withdraw_bot'])) {
    $data = [
      'bot_statement_id' => $_POST['id'],
      'credit_transaction_id' => $_POST['customer_bank_no'],
      'admin_user_id' => User::getCurrentUserID()
    ];
    $result = nga_management_bot::matchWithdrawBotStatement($code, $data, $_FILES['upload_img']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'แมทช์รายการถอนให้ลูกค้า',
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

$code = $_GET['c'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$id_select = isset($_GET['id']) ? $_GET['id'] : '';
if ($id_select) {
  $data_date_checked = nga_management_bot::getBotListLastCheck($code, $id_select);
  if ($data_date_checked['last_check_date']) {
    $date_checked = Aww::formatDate($data_date_checked['last_check_date'], 'd/m/Y,H:i');
  } else {
    $date_checked = '';
  }
}

$data_nav = [
  'param_name'  => 'page',
  'class' => 'bg-whites',
  'list' => [
    [
      'id'  => 1,
      'name'  => 'BOT Statements',
    ],
    [
      'id'  => 2,
      'name'  => 'BOT Log History',
    ]
  ]
];
$link = 'bot_statement_log.php?c=' . $_GET['c'];

$order_bot_options = [
  [
    'value' => 'withdraw',
    'text' => 'โอนอัตโนมัติ',
  ],
  [
    'value' => 'deposit',
    'text' => 'ฝากเงิน',
  ],
];

$status_bot_options = [
  [
    'value' => 'confirm',
    'text' => 'สำเร็จแล้ว',
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'ไม่สำเร็จ',
  ],
];
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
    <div class='bg-white pb-10px'>
      <div class="d-flex top-tap justify-content-between pt-10px align-items-center">
        <div class="msg col-lg-6">
          <div class='topic ml-10px'>
            BOT Statements </div>
          <div class="font-14px text-sub ml-10px">
            รายการประวัติการเงินตามการทำงานของ BOT
          </div>
        </div>
        <div class="d-flex align-items-center pr-10px">
          <span class="text-primary mr-10px">Last Checked : <?= $date_checked; ?></span>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-md-4">
        <div class="bg-white">
          <div id="bot_statements_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('bot_statements_list', '?c=' . $code . '&id=' . $id_select, '', 'บัญชีธนาคาร') ?>>
            <div class="table-responsive">
              <table class="table table-sort table-search ">
                <thead>
                  <tr>
                    <th nowrap data-sort="bot_name" data-filter="<?= Homepagify::dataFilter('bot_name', 'text') ?>">ชื่อ BOT</th>
                    <th nowrap data-sort="bank_account_name" data-filter="<?= Homepagify::dataFilter('bank_account_name', 'text') ?>">บัญชี</th>
                    <th class="thin-cell"></th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php if ($id_select) { ?>
        <div class="col-md-8">
          <div class="bg-white">
            <div id="bot_statements_detail" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('bot_statements_detail', '?c=' . $code . '&id=' . $id_select, '', 'Statement') ?>>
              <div class="table-responsive">
                <table class="table table-sort table-search ">
                  <thead>
                    <tr>
                      <th nowrap class="thin-cell" data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
                      <th nowrap data-sort="transaction" data-filter="<?= Homepagify::dataFilter('transaction', 'select', $order_bot_options) ?>">รายการ</th>
                      <th nowrap data-sort="transaction_amount" data-filter="<?= Homepagify::dataFilter('transaction_amount', 'text') ?>">จำนวน</th>
                      <th nowrap data-sort="balance" data-filter="<?= Homepagify::dataFilter('balance', 'text') ?>">ยอดคงเหลือ</th>
                      <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_bot_options) ?>">สถานะ</th>
                      <th class="thin-cell"></th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  <?php } else if ($page == 2) { ?>
    <div class='bg-white mb-15px pb-10px'>
      <div class="d-flex top-tap justify-content-between pt-10px align-items-center">
        <div class="msg col-lg-6">
          <div class='topic ml-10px'>
            Log History ของ BOT
          </div>
        </div>
      </div>
    </div>
    <div class="bg-white">
      <div id="bot_log_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('bot_log_list', '?c=' . $code, '', 'Log History ของ BOT ในระบบ') ?>>
        <div class="table-responsive">
          <table class="table table-sort table-search ">
            <thead>
              <tr>
                <th nowrap width="20%" data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วัน/เวลา</th>
                <th nowrap data-sort="bot_name" data-filter="<?= Homepagify::dataFilter('bot_name', 'text') ?>">ชื่อ BOT</th>
                <th nowrap data-sort="log_text" data-filter="<?= Homepagify::dataFilter('log_text', 'text') ?>">รายละเอียด</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>

<?php Tiwdal::startModal('deal_with', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<form method="post" enctype="multipart/form-data">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">ไม่พบรายการในระบบ กรุณาตรวจสอบข้อมูลใหม่</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-4 my-auto pb-10px">
          ลูกค้า
        </div>
        <div class="col-lg-8  pb-10px">
          <div class="form-row">
            <div class="col-12">
              <?php
              $options = [
                'selected_fields' => ['id', 'username', 'bank_name'],
              ];
              $user_customer = nga_user::selectUser($code, [], $options);
              // $user_customer = nga_user::selectUser($code, []);

              $user_customer_list = [
                'is_search' => true,
                'list' => []
              ];
              if ($user_customer) {
                foreach ($user_customer as $value) {
                  $user_customer_list['list'][] = [
                    'value' => $value['id'],
                    'name' => $value['username'] . ', ' . $value['bank_name'],
                  ];
                }
              }

              TiwForm::normal('select', '', ['name' => 'user_id'], $user_customer_list);
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4  my-auto pb-15px">
          หลักฐาน (รูป)
        </div>
        <div class="col-lg-8  my-auto pb-15px">
          <?php
          $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
            'title' => 'ทดสอบ title', //title จะไปแสดงด้านล่างของรูป
            'is_btn' => 0, //ไม่เอาปุ่มทั้งหมด
            'is_view' => 1, //ไม่เอาปุ่ม view
            'is_delete' => 1, //ไม่เอาปุ่ม ลบ
          ];
          TiwForm::normal('upload-img', 'assets/image/bg_upload.png', ['name' => 'upload_img', 'title' => 'แนบไฟล์รูปภาพ'], $options);
          ?>
        </div>
        <div class="col-lg-4 my-auto pb-10px">บันทึกบัญชีสำหรับการฝากเงินครั้งถัดไป</div>
        <div class="col-lg-8 my-auto pb-10px">
          <?= TiwForm::normal('checkbox', '1', ['name' => 'alias_saved'], ['style' => '3', 'label' => 'บันทึก']); ?>
          <input type="hidden" name="{transaction_from_bank_no_num}">
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="{id}">
    <button data-dismiss="modal" aria-label="Close" class="btn btn-close-modal min-w-80px">ยกเลิก</button>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_deposit_bot', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>


<?php Tiwdal::startModal('withdraw_deal', 'modal-md'); ?>
<form method="post" enctype="multipart/form-data">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">ไม่พบรายการในระบบ กรุณาตรวจสอบข้อมูลใหม่</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-4 my-auto pb-10px">
          ลูกค้า
        </div>
        <div class="col-lg-8  pb-10px">
          <div class="form-row">
            <div class="col-12">
              <?php
              $where_bank = [
                'transaction_type' => 'withdraw',
                'status' => 'wait_confirm',
              ];
              $user_credit1 = nga_user::selectuserCreditTransaction($code, $where_bank);
              $options_bank = [
                'is_search' => true,
                'list' => []
              ];
              if ($user_credit1) {
                foreach ($user_credit1 as $value) {
                  $options_bank['list'][] = [
                    'value' => $value['id'],
                    'name' => $value['customer_bank_no'] . ', ' . $value['customer_bank_name'] . ', ' . $value['credit_amount'],
                  ];
                }
              }
              TiwForm::normal('select', '', ['name' => 'customer_bank_no'], $options_bank);
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-4  my-auto pb-10px">
          หลักฐาน (รูป)
        </div>
        <div class="col-lg-8  my-auto pb-10px">
          <?php
          $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
            'is_btn' => 0,
            'is_view' => 1,
            'is_delete' => 1,
          ];
          TiwForm::normal('upload-img', 'assets/image/bg_upload.png', ['name' => 'upload_img', 'title' => 'แนบไฟล์รูปภาพ'], $options);
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="{id}">
    <input type="hidden" name="{user_id}">
    <button data-dismiss="modal" aria-label="Close" class="btn btn-close-modal min-w-80px">ยกเลิก</button>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_withdraw_bot', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>