<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$current_user = User::getCurrentUserID();
$user_permission = User::getUserByID($current_user);
$count_refresh = isset($_GET['times']) ? $_GET['times'] : 1;
$get_auto_refresh = nga_management::getAutoRefreshPage($code);


if ($_POST) {
  if (isset($_POST['submit_add_customer'])) {
    $member_code = isset($_POST['member_code']) ? $_POST['member_code'] : '';
    $alliance_id = isset($_POST['alliance_id']) ? $_POST['alliance_id'] : '';
    $data = [
      'name' => $_POST['name'],
      'surname' => $_POST['surname'],
      'password' => $_POST['password'],
      'username' => $_POST['tel_no'],
      'line_id' => $_POST['line_id'],
      'bank_abb' => $_POST['bank_abb'],
      'bank_number' => $_POST['bank_number'],
      'bank_name' => $_POST['bank_name'],
      'member_code' => $member_code,
      'alliance_id' => $alliance_id,
    ];
    $force_register = isset($_POST['force_register']) ? $_POST['force_register'] : false;

    $result = nga_user::addNewUser($code, $data, false, $force_register);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $result['response_data']['insert_id'],
        'action' => 'add_user',
        'detail' => 'เพิ่มลูกค้า',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_deposit_customer'])) {
    $data = [
      'user_id' => $_POST['id'],
      'transaction_type' => 'deposit',
      'credit_amount' => $_POST['credit_amount'],
      'transaction_by_user_id' => $current_user,
      'remark' => $_POST['remark'],
      'web_bank_bot_list_id' => $_POST['web_bank_bot_list_id'],
      'status' => 'completed',
      'transaction_by' => 'admin',
      'is_credit' => '1'
    ];
    $img_file = $_FILES['img'];
    $result = nga_user::addUserCreditTransaction($code, $data, $img_file);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['id'],
        'action' => 'add_deposit',
        'detail' => 'เพิ่มเครดิตลูกค้า ' . $_POST['credit_amount'] . ' เครดิต สาเหตุ :' . $_POST['remark'],
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_withdraw_customer'])) {
    $data = [
      'user_id' => $_POST['id'],
      'transaction_type' => 'withdraw',
      'credit_amount' => $_POST['credit_amount'],
      'transaction_by_user_id' => $current_user,
      'remark' => $_POST['remark'],
      'status' => 'completed',
      'transaction_by' => 'admin',
      'is_credit' => '1'
    ];
    $result = nga_user::addUserCreditTransaction($code, $data);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['id'],
        'action' => 'add_withdraw',
        'detail' => 'ลดเครดิตลูกค้า ' . $_POST['credit_amount'] . ' เครดิต สาเหตุ :' . $_POST['remark'],
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_change_pass'])) {
    $result = User::changePassword($_POST['id'], $_POST['old_pass'], $_POST['new_pass']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['id'],
        'action' => 'edit_user',
        'detail' => 'เปลี่ยนรหัสผ่านลูกค้า',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['summit_add_point'])) {
    $point = $_POST['point'];
    $result = nga_user::addPoint($code, $_POST['id'], $point);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['id'],
        'action' => 'edit_user',
        'detail' => 'เพิ่มโบนัสให้ลูกค้า ' . $point . ' แต้ม',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_auto_refresh'])) {
    $is_refresh = isset($_POST['is_refresh']) && $_POST['is_refresh'] ? 1 : 0;
    $data = [
      'is_refresh_customer' => $is_refresh
    ];
    $result = nga_management::updateAutoRefreshPage($code, $get_auto_refresh['id'], $data);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};

$select_bot_bank = nga_management_bot::selectBotGroupList($code);
$bank_name_options = [
  'is_search' => true,
  'list' => [],
];

foreach ($select_bot_bank as $value) {
  $bank_name_options['list'][] = [
    'value' => $value['id'],
    'name' => $value['bank_account_name'] . ', ' . $value['bank_account_no'],
    'img' => $value['bank_image'],
  ];
}

$status_list = [
  [
    'value' => 'confirm',
    'text' => 'สำเร็จ'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'ยกเลิก'
  ],
];
$bank = Bank::select();
$bank_list = [];

foreach ($bank as $data) {
  $bank_list[] = [
    'value' => $data['abb'],
    'text' => $data['name_th'],
  ];
}

// Marketing list 
$where = [
  'is_active' => '1',
];
$alliance_list = nga_management::selectAlliance($code, $where);

$arr_remark = ['เติมเครดิตผิดยูสเซอร์', 'เติมเครดิตซ้ำ', 'เติมเครดิตโดยที่ไม่ได้แนบสลิป', 'เติมเครดิตแนบสลิปผิดยูสเซอร์', 'ลูกค้ามีสองยูสเซอร์ ทำให้เครดิตเข้าผิดยูสเซอร์', 'เลขบัญชี 4 ตัวท้ายตรงกับบัญชีฝากหน้าเว็บ', 'เลขบัญชีลูกค้า 4 ตัวท้ายเหมือนกัน ทำให้เครดิตเข้าผิดยูสเซอร์',];
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

  <div class="w-loves-card border-radius-0">
    <div class="d-flex justify-content-between mb-10px  ">
      <div>
        <div class="font-16px font-SemiBold">ลูกค้า</div>
        <div class="font-14px">ข้อมูลรายละเอียดลูกค้า</div>
      </div>
      <div class="d-flex align-items-center">
        <div class="text-primary font-16px font-SemiBold mr-10px"><span id="timing">60</span> S</div>
        <?= file_get_contents('assets/icon/icon-cooldown.svg') ?>
        <form method="post" class="event_auto_refresh my-auto">
          <?php
          $checked_refresh = ($get_auto_refresh['is_refresh_customer'] == 1) ? 'checked' : '';
          TiwForm::normal('checkbox', 1, ['name' => 'is_refresh', 'class' => 'event_stop_refresh ml-10px', 'checked' => $checked_refresh], ['style' => '1', 'is_on_off' => true, 'label' => 'รีเฟรชอัตโนมัติ', 'text_on' => 'เปิด', 'text_off' => 'ปิด']);
          ?>
          <input type="hidden" name="submit_auto_refresh">
        </form>
        <?php if ($user_permission['is_permission_add_user']) { ?>
          <button class="btn btn-primary w-100px font-Medium font-14px ml-10px" <?= Tiwdal::register('create_customer'); ?>>+ สร้างลูกค้า</button>
        <?php } ?>
        <input type="hidden" class="count_counter" value="<?= $count_refresh; ?>">
      </div>
    </div>
    <hr class="mx--15px">
    <?php /* 
    <div class="d-flex align-items-center mb-15px">
      <div class="mr-30px font-italic font-14px font-Bold">เลือกดูการสร้าง</div>
      <div class="d-flex align-items-center mr-20px">
        <?php TiwForm::normal('checkbox', 1, ['name' => ''], ['style' => '3']) ?>
        <div class="d-flex align-items-center ml-10px">
          <div class="mr-5px">สำเร็จ</div>
          ( <div class="pb-5px px-5px"> <?= file_get_contents('assets/icon/icon-check.svg') ?> </div>)
        </div>
      </div>
      <div class="d-flex align-items-center">
        <?php TiwForm::normal('checkbox', 1, ['name' => ''], ['style' => '3']) ?>
        <div class="d-flex align-items-center ml-10px">
          <div class="mr-5px">ไม่สำเร็จ</div>
          ( <div class="pb-5px px-5px"> <?= file_get_contents('assets/icon/icon-cancel.svg') ?> </div>)
        </div>
      </div>
    </div>
    */ ?>
    <div id="customer_list" class="container-pagination mx--15px no-border-radius" <?= Homepagify::createHomepagify('customer_list', '?c=' . $code, '', 'ลูกค้า') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search">
          <thead>
            <tr>
              <th nowrap data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วัน/เวลา</th>
              <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">ยูสเซอร์ (agent)</th>
              <th nowrap data-filter="<?= Homepagify::dataFilter('member_code', 'text') ?>">รหัสแนะนำเพื่อน</th>
              <th nowrap data-filter="<?= Homepagify::dataFilter('user_code', 'text') ?>">รหัสสมาชิก</th>
              <th nowrap data-sort="bank_name_number" data-filter="<?= Homepagify::dataFilter('bank_name_number', 'text') ?>">ธนาคาร</th>
              <th nowrap>การตลาด</th>
              <th nowrap>รหัสผู้แนะนำ</th>
              <th nowrap>รายละเอียด</th>
              <?php /* 
              <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">โอนเงิน</th>
              */ ?>
              <th nowrap data-sort="status">โอนเงิน</th>
              <th nowrap class="thin-cell"></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>


  <?php Tiwdal::startModal('create_customer', 'modal-md'); ?>
  <form method="post" class="">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">สร้าง User</h5>
      </div>
      <div class="modal-body">
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">ชื่อ</label>
          </div>
          <div class="col-md-8">
            <?= TiwForm::normal('text', '', ['name' => 'name', 'placeholder' => 'กรอก', 'class' => '']) ?>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">นามสกุล</label>
          </div>
          <div class="col-md-8">
            <?= TiwForm::normal('text', '', ['name' => 'surname', 'placeholder' => 'กรอก']) ?>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">รหัสผ่าน</label>
          </div>
          <div class="col-md-8 form-group">
            <?= TiwForm::normal('password', '', ['name' => 'password', 'placeholder' => '0000000', 'class' => 'show-pass']) ?>
            <span class="field-icon"><img src="assets/icon/hide-eye.png" class="password-img"></span>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">ยูสเซอร์ (agent)</label>
          </div>
          <div class="col-md-8">
            <?= TiwForm::normal('number', '', ['name' => 'tel_no', 'placeholder' => 'Ex.098-XXXXXXX']) ?>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">Line ID</label>
          </div>
          <div class="col-md-8">
            <?= TiwForm::normal('text', '', ['name' => 'line_id', 'placeholder' => 'กรอก']) ?>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">ธนาคาร</label>
          </div>
          <div class="col-md-8">
            <?php
            $bank_list = [
              'list' => [
                [
                  'value' => '',
                  'name' => 'เลือกธนาคาร',
                  'img' => '',
                  'disabled' => true
                ]
              ]
            ];
            foreach ($bank as $bank_data) {
              $bank_list['list'][] = [
                'value' => $bank_data['abb'],
                'name' => $bank_data['name_th'],
                'img' => $bank_data['image'],
              ];
            }
            ?>
            <?= TiwForm::normal('select-img', '', ['name' => 'bank_abb', 'placeholder' => 'กรุณาเลือก'], $bank_list) ?>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">ชื่อบัญชีธนาคาร</label>
          </div>
          <div class="col-md-8">
            <?= TiwForm::normal('text', '', ['name' => 'bank_name', 'placeholder' => 'กรอก']) ?>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">เลขที่บัญชีธนาคาร</label>
          </div>
          <div class="col-md-8">
            <?= TiwForm::normal('number', '', ['name' => 'bank_number', 'placeholder' => '0000-0000-000']) ?>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">รหัสเเนะนำเพื่อน</label>
          </div>
          <div class="col-md-8">
            <?= TiwForm::normal('text', '', ['name' => 'member_code', 'placeholder' => 'กรอก', 'class' => 'event_friend_market']) ?>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">การตลาด</label>
          </div>
          <div class="col-md-8">
            <?php
            $ally_list = [
              'list' => [
                [
                  'value' => '',
                  'name' => 'เลือกการตลาด',
                  'img' => '',
                  'disabled' => true
                ]
              ]
            ];
            foreach ($alliance_list as $ally_data) {
              $ally_list['list'][] = [
                'value' => $ally_data['id'],
                'name' => $ally_data['name'],
              ];
            }
            ?>
            <?= TiwForm::normal('select', '', ['name' => 'alliance_id', 'placeholder' => 'กรุณาเลือก', 'class' => 'event_group_market'], $ally_list) ?>
          </div>
        </div>
        <div class="form-row mb-10px">
          <div class="col-md-4">
            <label class="font-Medium font-14px mt-7px">เงื่อนไขบัญชีธนาคาร</label>
          </div>
          <div class="col-md-8">
            <div class=" mt-3px mr-5px">
              <?= TiwForm::normal('checkbox', 1, ['name' => 'force_register', 'checked' => false, 'class' => ''], ['style' => '3', 'label' => 'ไม่เช็กบัญชีธนาคาร']); ?>
            </div>
          </div>
          <div class="col-12">
            <span class="text-secondary font-14px">
              *** กรณีสมัครยูสไม่ได้ให้ติ๊กถูกตรงนี้ ระบบจะทำการสมัครสมาชิกให้ แต่จะไม่เช็กว่าบัญชีนี้มีอยู่จริงไหม รวมถึงจะไม่เช็คเงื่อนไขชื่อบัญชีซ้ำ Admin ต้องทำการตรวจสอบข้อมูลของยูสอื่นก่อนว่ามีอยู่ในระบบหรือไม่เพื่อกันไม่ให้มียูสซ้ำ
            </span>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_add_customer', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('deposit_credit_customer', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มเครดิตลูกค้า</h5>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-lg-4 my-auto pb-10px">
            เครดิต
          </div>
          <div class="col-lg-8  pb-10px">
            <div class="form-row">
              <div class="col-5">
                <?php TiwForm::normal('number', '', ['name' => 'credit_amount', 'class' => '', 'placeholder' => '0']); ?>
              </div>
              <div class="col-2 my-auto">
                เครดิต
              </div>
            </div>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            ยูสเซอร์ (agent)
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <div name="{username}">89bvia9378</div>
          </div>
          <div class="col-lg-4 mt-7px pb-10px">
            เหตุผล
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <?php TiwForm::normal('textarea', '', ['name' => 'remark', 'class' => 'min-h-70px', 'placeholder' => 'กรอก']); ?>
          </div>
          <div class="col-lg-4 mt-7px pb-10px">
            จากธนาคาร
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <?php TiwForm::normal('select-img', '', ['name' => 'web_bank_bot_list_id'], $bank_name_options); ?>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            รูปภาพ
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <?php
            $options_image = [
              'width' => '200px',
              'height' => '100%',
              'bg-img' => 'assets/image/bg_upload.png',
            ];
            TiwForm::normal('upload-img', '', ['name' => 'img'], $options_image); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <input type="hidden" name="{id}">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_deposit_customer', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('withdraw_credit_customer', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลดเครดิตลูกค้า</h5>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-lg-4 my-auto pb-10px">
            เครดิต
          </div>
          <div class="col-lg-8  pb-10px">
            <div class="form-row">
              <div class="col-5">
                <?php TiwForm::normal('number', '', ['name' => 'credit_amount', 'class' => '', 'placeholder' => '0']); ?>
              </div>
              <div class="col-2 my-auto">
                เครดิต
              </div>
            </div>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            ยูสเซอร์ (agent)
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <div name="{username}">89bvia9378</div>
          </div>
          <div class="col-lg-4 mt-7px pb-10px">
            เหตุผล
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <fieldset>
              <input list="remark_withdraw_credit_customer" type="text" name="remark" class="form-select form-datalist" autocomplete="off">
              <datalist id="remark_withdraw_credit_customer">
                <?php foreach ($arr_remark as $value) { ?>
                  <option value="<?= $value ?>">
                  <?php } ?>
              </datalist>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <input type="hidden" name="{id}">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_withdraw_customer', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('add_bonus_customer', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มโบนัสให้ลูกค้า</h5>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-lg-4 my-auto pb-10px">
            โบนัส
          </div>
          <div class="col-lg-8  pb-10px">
            <div class="form-row">
              <div class="col-5">
                <?php TiwForm::normal('number', '', ['name' => 'point', 'oninput' => 'limitDecimalPlaces(event, 2)', 'placeholder' => '0']); ?>
              </div>
              <div class="col-2 my-auto">
                โบนัส
              </div>
            </div>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            ยูสเซอร์ (agent)
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <span name="{username}"></span>
          </div>
          <!-- <div class="col-lg-4 mt-7px pb-10px">
            เหตุผล
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <?php TiwForm::normal('textarea', '', ['name' => '', 'class' => 'min-h-70px', 'placeholder' => 'กรอก']); ?>
          </div> -->
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <input type="hidden" name="{id}">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'summit_add_point', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('change_password_customer', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เปลี่ยนรหัสผ่าน</h5>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-lg-4 my-auto">
            รหัสผ่านเดิม <span class="text-danger">*</span>
          </div>
          <div class="col-lg-8 my-auto form-group">
            <?php
            TiwForm::normal('password', '', ['name' => 'old_pass', 'required' => 'true', 'class' => 'show-pass']);
            ?>
            <span class="field-icon"><img src="assets/icon/hide-eye.png" class="password-img"></span>
          </div>
          <div class="col-lg-4 my-auto">
            รหัสผ่านใหม่ <span class="text-danger">*</span>
          </div>
          <div class="col-lg-8 my-auto form-group">
            <?php
            TiwForm::normal('password', '', ['name' => 'new_pass', 'required' => 'true', 'class' => 'show-pass event_new_pass']);
            ?>
            <span class="field-icon"><img src="assets/icon/hide-eye.png" class="password-img"></span>
          </div>
          <div class="col-lg-4 my-auto">
            ยืนยันรหัสผ่านใหม่ <span class="text-danger">*</span>
          </div>
          <div class="col-lg-8 my-auto form-group">
            <?php
            TiwForm::normal('password', '', ['name' => 'new_pass_re', 'required' => 'true', 'class' => 'show-pass event_new_pass_re']);
            ?>
            <span class="field-icon"><img src="assets/icon/hide-eye.png" class="password-img"></span>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <input type="hidden" name="{id}">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_change_pass', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary scope_btn_change_pass', 'disabled' => true], ['text' => 'บันทึก']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
  <?php Aww::loadAsset('assets/js/force_logout.js'); ?>


</body>

</html>

<script>
  $(document).ready(function() {
    var count_times = $('.count_counter').val();
    if (count_times == 30) {
      forceLogout();
    }
    var code = '<?= $code; ?>'
    var call_timing = $('#timing').html();
    var checked_refresh = '<?= $get_auto_refresh['is_refresh_customer']; ?>'
    if (checked_refresh == 1) {
      timeCount(call_timing);
    }
    $(document).on('click', '.field-icon', function(e) {
      var form = $(this).parent('.form-group');
      var input = form.find('.show-pass');
      input.toggleClass('active');
      var hasClass = input.hasClass('active');
      input.attr('type', 'password');
      form.find('.password-img').attr("src", "assets/icon/hide-eye.png");
      if (hasClass) {
        input.attr('type', 'text');
        form.find('.password-img').attr("src", "assets/icon/open-eye.png");
      }
    });

    $(document).on('keyup', '.event_new_pass , .event_new_pass_re', function() {
      var pass = $('.event_new_pass').val();
      var pass_re = $('.event_new_pass_re').val();
      checkMatchPass(pass, pass_re);
    });

    // select event_group_market  has value disabled input event_friend_market 
    $(document).on('change', '.event_group_market', function() {
      $('.event_friend_market').attr('disabled', true);
    });

    // input event_friend_market has value disabled select event_group_market 
    $(document).on('change', '.event_friend_market', function() {
      var value = $(this).val();
      if (value != '') {
        $('.event_group_market').attr('disabled', true);
      } else {
        $('.event_group_market').attr('disabled', false);
      }
    });

    $(document).on('change', '.event_stop_refresh input', function(e) {
      $('.event_auto_refresh').submit();
    });

    function timeCount(timing) {
      var counter = $('.count_counter').val();
      // var myTimer, timing = 60;
      var myTimer = timing;
      // $('#timing').html(timing);
      myTimer = setInterval(function() {
        --timing;
        $('#timing').html(timing);
        if (timing === 0) {
          counter++;
          $('.count_counter').val(counter);

          clearInterval(myTimer);
          window.location = 'customer_list.php?c=' + code + '&times=' + counter;
        }
      }, 1000);

      // Pause the timer when the modal is open
      $('#create_customer').on('show.bs.modal', function(e) {
        clearInterval(myTimer);
      });

      // $(document).on('change', '.event_stop_refresh input', function(e) {
      //   var last_timing = $('#timing').html();
      //   if ($(this).is(':checked')) {
      //     clearInterval(myTimer);
      //     $(this).removeClass('event_stop_refresh').addClass('event_continue_refresh');
      //   } else {
      //     timeCount(last_timing);
      //     $(this).removeClass('event_continue_refresh').addClass('event_stop_refresh');
      //   }
      // });


      // Resume the timer when the modal is closed
      $('#create_customer').on('hide.bs.modal', function(e) {
        myTimer = setInterval(function() {
          --timing;
          $('#timing').html(timing);
          if (timing === 0) {
            counter++;
            $('.count_counter').val(counter);

            clearInterval(myTimer);
            window.location = 'customer_list.php?c=' + code + '&times=' + counter;
          }
        }, 1000);
      });
    }

    function forceLogout() {
      window.location.href = "../../module_main/login/logout.php";
    }

    function checkMatchPass(pass, pass_re) {
      if (pass == pass_re) {
        $('.scope_btn_change_pass').attr('disabled', false);
      } else {
        $('.scope_btn_change_pass').attr('disabled', true);
      }
    }

  });
</script>