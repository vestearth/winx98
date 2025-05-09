<?php
// use Mpdf\Tag\S;
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'deposit_withdraw'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$current_user = User::getCurrentUserID();
$get_auto_refresh = nga_management::getAutoRefreshPage($code);

if ($_POST) {
  if (isset($_POST['submit_deposit_turnover'])) {
    $data = [
      'user_id' => $_POST['agent_id'],
      'transaction_type' => 'deposit',
      'credit_amount' => $_POST['credit_amount'],
      'transaction_by_user_id' => $current_user,
      'remark' => $_POST['remark'],
      'admin_add_manual_remark' => $_POST['admin_add_manual_remark'],
      'web_bank_bot_list_id' => $_POST['web_bank_bot_list_id'],
      'admin_add_manual_date_time' => $_POST['admin_add_manual_date_time'],
      'status' => 'completed',
      'transaction_by' => 'admin',
      'is_wallet' => '1',
      'is_calculate_turn_over' =>  '1',
      'is_add_point_card_slot' =>  isset($_POST['is_add_point_card_slot']) ? $_POST['is_add_point_card_slot'] : '0',
    ];
    $result = nga_user::addUserCreditTransaction($code, $data, $_FILES['img']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['agent_id'],
        'action' => 'add_deposit',
        'detail' => 'เพิ่มรายการฝากเงินไม่เข้า ' . $_POST['credit_amount'] . ' สาเหตุ :' . $_POST['remark'],
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_add_deposit'])) {
    $data = [
      'user_id' => $_POST['agent_id'],
      'transaction_type' => 'deposit',
      'credit_amount' => $_POST['credit_amount'],
      'transaction_by_user_id' => $current_user,
      'web_bank_bot_list_id' => $_POST['web_bank_bot_list_id'],
      'remark' => $_POST['remark'],
      'admin_add_manual_remark' => $_POST['admin_add_manual_remark'],
      'admin_add_manual_date_time' => $_POST['admin_add_manual_date_time'],
      'status' => 'completed',
      'transaction_by' => 'admin',
      'is_add_point_card_slot' =>  isset($_POST['is_add_point_card_slot']) ? $_POST['is_add_point_card_slot'] : '0',
    ];
    $result = nga_user::addUserCreditTransaction($code, $data, $_FILES['img']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['agent_id'],
        'action' => 'add_deposit',
        'detail' => 'เพิ่มรายการฝากเงิน ' . $_POST['credit_amount'] . ' สาเหตุ :' . $_POST['remark'],
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_cancel_transfer'])) {
    $result = nga_user::cancelWithdraw($code, $_POST['id'], $_POST['remark_cancel']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'ยกเลิกรายการถอนเงิน สาเหตุ :' . $_POST['remark_cancel'],
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_admin_allow'])) {
    $result = nga_user::confirmDepositTransaction($code, $_POST['id']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'อนุมัติรายการฝากเงิน',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_admin_cancel'])) {
    $result = nga_user::cancelDepositTransaction($code, $_POST['id']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'ยกเลิกรายการฝากเงิน',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_topup_cancel'])) {
    $result = nga_user::cancelDepositTransaction($code, $_POST['id']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'ยกเลิกรายการเติมเครดิต',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_topup_bot_cancel'])) {
    $result = nga_user::cancelDepositTransaction($code, $_POST['id']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'ยกเลิกรายการเติมเครดิต',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_confirm_from_cancel'])) {
    $result = nga_user::confirmDepositTransactionFromCancel($code, $_POST['id']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_deposit',
        'detail' => 'เปลี่ยนรายการยกเลิกเป็นสำเร็จ',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_auto_refresh'])) {
    $is_refresh = isset($_POST['is_refresh']) && $_POST['is_refresh'] ? 1 : 0;
    $data = [
      'is_refresh_deposit' => $is_refresh,
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
$bank_name_options['list'][] = [
  'value' => '',
  'name' => 'ไม่มีธนาคาร',
  'img' => 'assets/image/placeholder_square.jpg',
];
foreach ($select_bot_bank as $value) {
  $bank_name_options['list'][] = [
    'value' => $value['id'],
    'name' => $value['bank_account_name'] . ', ' . $value['bank_account_no'],
    'img' => $value['bank_image'],
  ];
}

function phase_2f($msg1, $num_range, $option = ['type' => 'text', 'value' => '', 'name' => '', 'placeholder' => 'enter', 'class' => ''], $class1 = '', $class2 = '', $class = '')
{
  if ($option['value'] == '') {
    $option['value'] = '0';
  };
  if ($option['placeholder'] == '') {
    $option['placeholder'] = 'Enter';
  }

  $num = (12 - $num_range);
  echo  '<div class="form-row px-15px py-5px font-14px ' . $class . '">
  <div class="col-lg-' . $num_range . ' font-Medium text-grey ' . $class1 . '">
  ' . $msg1 . '
  </div>
  <div class="col-lg-' . $num . ' ' . $class2 . ' ">';
  $options = ['name' => $option['name'], 'placeholder' =>  $option['placeholder'], 'class' =>  $option['class']];
  echo " <?php TiwForm::normal(" . $option['type'] . ", " . $option['value'] . ",";
  echo  "['name'=>" . $options['name'] . " 'placeholder'=>" . $options['placeholder'] . "'class'=>" . $options['class'] . "]  ); ?>";


  echo '</div>
  </div>';
}

function create_bank_card($color, $bank, $name_bank, $name, $number, $status, $balance, $last_balance)
{
  $colors = './assets/icon/icon-dot-' . $color . '.svg';
  $content_color = file_get_contents($colors);
  // $banks = file_get_contents("./assets/icon/icon-" . $bank . ".svg");
  echo '<div class="card-bank form-row">
  <div class="col-2 text-vertical-center my-auto pl-10px">
    <div class="text-vertical-center my-auto">';
  echo $content_color;
  echo  '</div>
  </div>
  <div class="col-10">
    <div class="form-row">
      <div class="col-2 d-flex justify-content-end">
      <div class="bank-img small-size">
       <img src="' . $bank . '" />
       </div>
      ';

  echo ' </div>
      <div class="col-10">' .
    $name_bank
    . '</div>
      <div class="col-2">
      </div>
      <div class="col-10  text-sub">
     ' . $name . '
      </div>
      <div class="col-2">
      </div>
      <div class="col-10  text-sub">
      ' . $number . '
      </div>
      <div class="col-2">
      </div>
      <div class="col-10  text-sub">
      Status : ' . $status . '
      </div>
      <div class="col-2">
      </div>
      <div class="col-10  text-sub">
      ยอดคงเหลือ : ' . $balance . '
      </div>
      <div class="col-2">
      </div>
      <div class="col-10  text-sub">
      อัพเดทล่าสุด : ' . $last_balance . '
      </div>
    </div>
  </div>
</div>';
}

// $type_list = [

//   [
//     'value' => 'deposit',
//     'text' => 'ฝากเงิน'
//   ],
//   [
//     'value' => 'withdraw',
//     'text' => 'ถอนเงิน'
//   ],
// ];

$receive_from_list = [

  [
    'value' => 'admin_add_manual_with_turn_over',
    'text' => 'รายการฝากเงินไม่เข้า'
  ],
  [
    'value' => 'admin_add_manual_not_turn_over',
    'text' => 'เพิ่มการฝากด้วยมือ'
  ],
  [
    'value' => 'bot_auto_match',
    'text' => 'รายการฝากเงินอัตโนมัติ'
  ],
  [
    'value' => 'admin_match',
    'text' => 'รายการอนุมัติโดยแอดมิน'
  ],
  // [
  //   'value' => 'admin_confirm_manual',
  //   'text' => 'รายการถอนอนุมัติโดยแอดมิน'
  // ],
  // [
  //   'value' => 'admin_cancel_manual',
  //   'text' => 'รายการฝากยกเลิกโดยแอดมิน'
  // ],
];

$status_list = [
  [
    'value' => 'completed',
    'text' => 'สำเร็จแล้ว'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'กำลังโอนเงิน/รอแอดมิน'
  ],
  [
    'value' => 'cancel',
    'text' => 'ยกเลิก'
  ],
];
$option_event = [
  'list' => [
    [
      'value' => '0',
      'text' => 'ไม่สามารถทำรายการได้'
    ],
  ]
];

$options_user = [
  'selected_fields' => ['id', 'username'],
];
$user_data = nga_user::selectUser($code, [], $options_user);
$user_list = [
  'is_search' => true,
  'list' => [
    [
      'value' => '0',
      'name' => 'เลือกผู้ใช้'
    ],
  ]
];

foreach ($user_data as $user_data_list) {
  // $full_name = ($user_data_list['full_name']) ? '- ' . $user_data_list['full_name'] : '';
  $user_list['list'][] = [
    'value' => $user_data_list['id'],
    'name' => $user_data_list['username'],
    // 'name' => hidePhoneNumber($user_data_list['username']),
  ];
}

$options_user = [
  'selected_fields' => ['id', 'username'],
];
$call_admin_list = User::selectUser('dvjdb', [], $options_user);
$admin_list = [];


foreach ($call_admin_list as $admin_data_list) {
  $admin_list[] = [
    'value' => $admin_data_list['id'],
    'text' => $admin_data_list['username'],
  ];
}

$bot_list = nga_management_bot::selectBotGroupList($code, []);

$arr_remark_deposit = ['ลูกค้าแจ้งสลิปหลังวันที่โอนเงิน', 'ถอนแล้วเครดิตไม่เข้า', 'การตลาดทำคลิปยิงแอด', 'เทสระบบเกมส์', 'ระบบยกเลิกรายการถอนลูกค้า', 'ระบบยกเลิกรายการถอนลูกค้าเนื่องจาก', 'ลูกค้าถอนยอดเท่ากันต่อเนื่อง'];
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

  <div class='bg-white mb-15px pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">

      <div class="msg col-lg-6">
        <div class='topic ml-10px'>
          รายการฝาก (เงินสดเท่านั้น) </div>
        <div class="font-14px text-sub ml-10px">
          รายการประวัติการฝากเงิน
        </div>
      </div>

      <div class="button-panel col-lg-6 d-flex justify-content-end">
        <div class="refresh-auto d-flex text-blue my-auto">
          <span id="timing">60</span> s
          <a class="mr-15px ml-5px"><?= file_get_contents('./assets/icon/Icon-refresh-cw.svg') ?></a>
        </div>
        <form method="post" class="event_auto_refresh my-auto">
          <?php
          $checked_refresh = ($get_auto_refresh['is_refresh_deposit'] == 1) ? 'checked' : '';
          TiwForm::normal('checkbox', 1, ['name' => 'is_refresh', 'class' => 'event_stop_refresh', 'checked' => $checked_refresh], ['style' => '1', 'is_on_off' => true, 'label' => 'รีเฟรชอัตโนมัติ', 'text_on' => 'เปิด', 'text_off' => 'ปิด']);
          ?>
          <input type="hidden" name="submit_auto_refresh">
        </form>
        <button class="btn-red mx-5px w-180px" <?= Tiwdal::register('cannot') ?>>ฝากเงินไม่เข้า</button>
        <button class="btn-blue mx-5px w-180px" <?= Tiwdal::register('add_modal') ?>>+ เพิ่มรายการฝาก</button>
        <!-- <button class="btn-yellow mx-5px w-180px" disabled>ล้างรายการถอนค้าง</button> -->
      </div>

    </div>

  </div>
  <div class='bank-panel bg-white py-10px d-flex'>
    <?php foreach ($bot_list as $bot_active) {
      if ($bot_active['last_update_balance']) {
        $last_update_balance = Aww::formatDate($bot_active['last_update_balance'], 'd/m/Y H:i');
      } else {
        $last_update_balance = 'ยังไม่มีการอัพเดท';
      }
    ?>
      <?php create_bank_card($bot_active['status_color'], $bot_active['bank_image'], $bot_active['bank_name_th'], $bot_active['bank_account_name'], $bot_active['bank_account_no'], $bot_active['status_code'], $bot_active['current_balance'], $last_update_balance); ?>
    <?php } ?>
  </div>
  <div id="deposit_withdraw" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('deposit_withdraw', '?c=' . $code, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
            <th nowrap data-sort="transaction_type">ประเภท</th>
            <th nowrap data-sort="customer_username" data-filter="<?= Homepagify::dataFilter('customer_username', 'text') ?>">ยูสเซอร์ (agent)</th>
            <th nowrap data-sort="customer_bank_name" data-filter="<?= Homepagify::dataFilter('customer_bank_name', 'text') ?>">บัญชีลูกค้า</th>
            <th nowrap data-sort="web_bank_name" data-filter="<?= Homepagify::dataFilter('web_bank_name', 'text') ?>">บัญชีเว็บ</th>
            <th nowrap data-sort="admin_add_manual_date_time" data-filter="<?= Homepagify::dataFilter('admin_add_manual_date', 'date') ?>">วันที่ฝาก</th>
            <th nowrap data-sort="credit_amount" data-filter="<?= Homepagify::dataFilter('credit_amount', 'text') ?>" class="thin-cell">จำนวน</th>
            <th nowrap data-sort="credit_before" class="thin-cell">เครดิต (ก่อน)</th>
            <th nowrap data-sort="credit_after" class="thin-cell">เครดิต (หลัง)</th>
            <th nowrap data-sort="receive_from" data-filter="<?= Homepagify::dataFilter('receive_from', 'select', $receive_from_list) ?>">ประเภท</th>
            <th nowrap data-sort="confirm_cancel_admin_id" data-filter="<?= Homepagify::dataFilter('confirm_cancel_admin_id', 'select', $admin_list) ?>">แอดมิน</th>
            <th nowrap data-sort="status" width="10%" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>
            <th nowrap data-sort="remark" data-filter="<?= Homepagify::dataFilter('remark', 'text') ?>" class="thin-cell">หมายเหตุ</th>
            <th nowrap data-sort="admin_add_manual_remark" data-filter="<?= Homepagify::dataFilter('admin_add_manual_remark', 'text') ?>" class="thin-cell">หมายเหตุแอดมิน</th>
            <th nowrap data-sort="" class="thin-cell">รูปสลิป</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
  </div>
  <?php Tiwdal::startModal('add_modal', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">เพิ่มการฝากด้วยมือ</h5>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-lg-4 my-auto pb-10px">
            เครดิต
          </div>
          <div class="col-lg-8  pb-10px">
            <div class="form-row">
              <div class="col-5">
                <?php TiwForm::normal('number', '0', ['name' => 'credit_amount', 'class' => '']); ?>
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
            <?php TiwForm::normal('select', '', ['name' => 'agent_id', 'class' => ''], $user_list); ?>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            เหตุผล (ลูกค้าเห็น)
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <fieldset>
              <input list="remark_add_customer" type="text" name="remark" class="form-select form-datalist" autocomplete="off">
              <datalist id="remark_add_customer">
                <?php foreach ($arr_remark_deposit as $value) { ?>
                  <option value="<?= $value ?>">
                  <?php } ?>
              </datalist>
            </fieldset>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            เหตุผล (จากแอดมิน)
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <fieldset>
              <input list="remark_add_admin" type="text" name="admin_add_manual_remark" class="form-select form-datalist" autocomplete="off">
              <datalist id="remark_add_admin">
                <?php foreach ($arr_remark_deposit as $value) { ?>
                  <option value="<?= $value ?>">
                  <?php } ?>
              </datalist>
            </fieldset>
          </div>
          <div class="col-lg-4 mt-7px pb-10px">
            จากธนาคาร
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <?php TiwForm::normal('select-img', '', ['name' => 'web_bank_bot_list_id'], $bank_name_options); ?>
          </div>
          <div class="col-lg-4 mt-7px pb-10px">
            วันที่ฝาก
          </div>
          <div class="col-lg-8">
            <?php
            TiwForm::normal('datetime', '', ['name' => 'admin_add_manual_date_time'], []);
            ?>
          </div>
          <div class="col-lg-4 mt-7px pb-10px">
            สิทธิ์กิจกรรม
          </div>
          <div class="col-lg-8 mt-7px pb-10px">
            <?php
            TiwForm::normal('checkbox', '1', ['name' => 'is_add_point_card_slot'], ['style' => '3', 'label' => 'ให้สิทธิ์']);
            ?>
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
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn min-w-80px btn-cancels', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_add_deposit', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'เพิ่มการฝาก']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>


  <?php Tiwdal::startModal('cannot', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ฝากเงินไม่เข้า</h5>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-lg-4 my-auto pb-10px">
            เครดิต
          </div>
          <div class="col-lg-8 pb-10px">
            <div class="form-row">
              <div class="col-5">
                <?php TiwForm::normal('number', '0', ['name' => 'credit_amount', 'class' => '']); ?>
              </div>
              <div class="col-2 my-auto">
                เครดิต
              </div>
            </div>
          </div>
          <div class="col-lg-4 my-auto pb-10px">
            ยูสเซอร์ (agent)
          </div>
          <div class="col-lg-8 pb-10px">
            <?php TiwForm::normal('select', '', ['name' => 'agent_id', 'class' => ''], $user_list); ?>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            เหตุผล (ลูกค้าเห็น)
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <fieldset>
              <input list="remark_customer_cannor" type="text" name="remark" class="form-select form-datalist" autocomplete="off">
              <datalist id="remark_customer_cannor">
                <option value=" เติมเครดิตมือ เนื่องจากระบบไม่ดึงยอดฝาก">
              </datalist>
            </fieldset>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            เหตุผล (จากแอดมิน)
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <fieldset>
              <input list="remark_admin_cannot" type="text" name="admin_add_manual_remark" class="form-select form-datalist" autocomplete="off">
              <datalist id="remark_admin_cannot">
                <option value=" เติมเครดิตมือ เนื่องจากระบบไม่ดึงยอดฝาก">
              </datalist>
            </fieldset>
          </div>
          <div class="col-lg-4 mt-7px pb-10px">
            จากธนาคาร
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <?php TiwForm::normal('select-img', '', ['name' => 'web_bank_bot_list_id', 'class' => 'event_select_data_bank'], $bank_name_options); ?>
          </div>
          <div class="col-lg-4 mt-7px pb-10px scope_show_current_balance" style="display:none">
            ยอดเงินคงเหลือ
          </div>
          <div class="col-lg-8  my-auto pb-10px  scope_show_current_balance" style="display:none">
            <?php foreach ($select_bot_bank as $value) { ?>
              <div class="scope_current_balance" data-id="<?= $value['id'] ?>" style="display:none">
                <?= number_format($value['current_balance'], 2) . ' บาท' ?>
              </div>
            <?php } ?>
          </div>
          <div class="col-lg-4 mt-7px pb-10px">
            วันที่ฝาก
          </div>
          <div class="col-lg-8">
            <?php
            TiwForm::normal('datetime', '', ['name' => 'admin_add_manual_date_time'], []);
            ?>
          </div>
          <div class="col-lg-4 mt-7px pb-10px">
            สิทธิ์กิจกรรม
          </div>
          <div class="col-lg-8 mt-7px pb-10px">
            <?php
            TiwForm::normal('checkbox', '1', ['name' => 'is_add_point_card_slot'], ['style' => '3', 'label' => 'ให้สิทธิ์']);
            ?>
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
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-cancels min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_deposit_turnover', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'เพิ่มเครดิต']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('detail_preview_img', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title font-16px font-SemiBold">รูปภาพ</h5>
    </div>
    <div class="modal-body pt-0 px-15px">
      <div class="row">
        <div class="col-12 d-flex justify-content-center">
          <div class="w-100 d-flex justify-content-center">
            <img src="" name="{admin_confirm_image}" class="w-500px border-bottom-radius-10px object-fit-contain">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-cancels min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ปิด']); ?>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('cancel_transfer_money', 'modal-md'); ?>
  <form method="post">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    <div class="modal-body mt-30px">
      <h3 class="text-center font-16px font-SemiBold text-uppercase"><span name="{type_text}">ยกเลิกรายการถอนเงิน</span></h3>
      <p class="mb-5px text-center">
        คุณต้องการ <span class="text-danger text-uppercase"> “<span name="{type_text}">ยกเลิกรายการถอนเงิน</span>”</span> นี้ใช่หรือไม่
      </p>
      <div class="form-group mt-10px">
        <div class="form-row d-flex justify-content-center align-items-center">
          <div class="col-lg-12">
            <div class="font-14px font-Medium mb-10px py-5px">
              หมายเหตุการยกเลิก
            </div>
            <div class="ml-5px font-16px font-Regular">
              <?php TiwForm::normal('textarea', '', ['name' => 'remark_cancel', 'placeholder' => 'Enter', 'class' => 'min-h-50px']); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer d-flex justify-content-between">
      <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
      <?php TiwForm::normal('hidden', '', ['name' => '{user_id}'], []); ?>
      <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ปิด</button>
      <button type="submit" class="btn btn-danger w-100px" name="submit_cancel_transfer">ยืนยัน</button>
    </div>
  </form>
  <?php Tiwdal::endModal(); ?>

  <?php Tiwdal::startModal('allow_admin_manual_accept', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <form method="post">
    <div class="modal-body mt-30px">
      <h3 class="text-center font-16px font-SemiBold text-uppercase">อนุมัติรายการฝาก</h3>
      <p class="mb-5px text-center">
        คุณต้องการ <span class="text-primary text-uppercase"> “อนุมัติรายการฝาก”</span> นี้ใช่หรือไม่
      </p>
    </div>
    <div class="modal-footer d-flex justify-content-between">
      <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
      <?php TiwForm::normal('hidden', '', ['name' => '{user_id}'], []); ?>
      <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ปิด</button>
      <button type="submit" class="btn btn-primary w-100px" name="submit_admin_allow">ยืนยัน</button>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('cancel_admin_manual_accept', 'modal-md'); ?>
  <form method="post">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    <div class="modal-body mt-30px">
      <h3 class="text-center font-16px font-SemiBold text-uppercase">ปฏิเสธรายการฝาก</h3>
      <p class="mb-5px text-center">
        คุณต้องการ <span class="text-danger text-uppercase"> “ปฏิเสธรายการฝาก”</span> นี้ใช่หรือไม่
      </p>
    </div>
    <div class="modal-footer d-flex justify-content-between">
      <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
      <?php TiwForm::normal('hidden', '', ['name' => '{user_id}'], []); ?>
      <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ปิด</button>
      <button type="submit" class="btn btn-danger w-100px" name="submit_admin_cancel">ยืนยัน</button>
    </div>
  </form>
  <?php Tiwdal::endModal(); ?>

  <?php Tiwdal::startModal('cancel_topup_admin', 'modal-md'); ?>
  <form method="post">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    <div class="modal-body mt-30px">
      <h3 class="text-center font-16px font-SemiBold text-uppercase">ยกเลิกรายการเติมเครดิต</h3>
      <p class="mb-5px text-center">
        คุณต้องการ <span class="text-danger text-uppercase"> “ยกเลิกรายการเติมเครดิต”</span> นี้ใช่หรือไม่
      </p>
    </div>
    <div class="modal-footer d-flex justify-content-between">
      <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
      <?php TiwForm::normal('hidden', '', ['name' => '{user_id}'], []); ?>
      <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ปิด</button>
      <button type="submit" class="btn btn-danger w-100px" name="submit_topup_cancel">ยืนยัน</button>
    </div>
  </form>
  <?php Tiwdal::endModal(); ?>

  <?php Tiwdal::startModal('cancel_topup_bot', 'modal-md'); ?>
  <form method="post">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    <div class="modal-body mt-30px">
      <h3 class="text-center font-16px font-SemiBold text-uppercase">ยกเลิกรายการเติมเครดิต</h3>
      <p class="mb-5px text-center">
        คุณต้องการ <span class="text-danger text-uppercase"> “ยกเลิกรายการเติมเครดิต”</span> นี้ใช่หรือไม่
      </p>
    </div>
    <div class="modal-footer d-flex justify-content-between">
      <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
      <?php TiwForm::normal('hidden', '', ['name' => '{user_id}'], []); ?>
      <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ปิด</button>
      <button type="submit" class="btn btn-danger w-100px" name="submit_topup_bot_cancel">ยืนยัน</button>
    </div>
  </form>
  <?php Tiwdal::endModal(); ?>

  <?php Tiwdal::startModal('confirm_from_cancel', 'modal-md'); ?>
  <form method="post">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    <div class="modal-body mt-30px">
      <h3 class="text-center font-16px font-SemiBold text-uppercase"><span name="">เปลี่ยนยกเลิกเป็นสำเร็จ</span></h3>
      <p class="mb-5px text-center">

        คุณแน่ใจหรือไม่!! ที่จะเปลี่ยนรายการในสถานะ <br><span class="text-danger text-uppercase"><span name=""> "ยกเลิก" เป็น "สำเร็จแล้ว"</span></span><br> และจะไม่สามารถกลับเป็นสถานะเดิมได้แล้ว
      </p>
      <?php /* 
      <div class="form-group mt-10px">
        <div class="form-row d-flex justify-content-center align-items-center">
          <div class="col-lg-12">
            <div class="font-14px font-Medium mb-10px py-5px">
              หมายเหตุการยกเลิก
            </div>
            <div class="ml-5px font-16px font-Regular">
              <?php TiwForm::normal('textarea', '', ['name' => 'remark_cancel', 'placeholder' => 'Enter', 'class' => 'min-h-50px']); ?>
            </div>
          </div>
        </div>
      </div>
              */ ?>
    </div>
    <div class="modal-footer d-flex justify-content-between">
      <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
      <?php TiwForm::normal('hidden', '', ['name' => '{user_id}'], []); ?>
      <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ปิด</button>
      <button type="submit" class="btn btn-danger w-100px" name="submit_confirm_from_cancel">ยืนยัน</button>
    </div>
  </form>
  <?php Tiwdal::endModal(); ?>

</body>

</html>

<script>
  var intervalID;
  var timing = 60;
  var current_timing;
  var checked_refresh = '<?= $get_auto_refresh['is_refresh_deposit']; ?>';
  $(document).ready(function() {
    if (checked_refresh == 1) {
      startInterval(timing);
    }
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
    $("#add_modal , #cannot , #detail_preview_img, #cancel_transfer_money").on('show.bs.modal', function() {
      stopInterval()
    });
    $("#add_modal , #cannot , #detail_preview_img, #cancel_transfer_money").on('hidden.bs.modal', function() {
      startInterval(current_timing)
    });

    $(document).on('change', '.event_stop_refresh input', function(e) {
      $('.event_auto_refresh').submit();
    });

    // $(document).on('click', '.event_stop_refresh', function(e) {
    //   stopInterval();
    //   $('.event_stop_refresh').addClass('event_continue_refresh');
    // });

    // $(document).on('click', '.event_continue_refresh', function(e) {
    //   $('.event_stop_refresh').removeClass('event_continue_refresh');
    //   startInterval(current_timing);
    // });
  });

  function timeCount(timing) {
    $('#timing').html(timing);
    if (timing === 0) {
      window.location = "";
    }
  }

  function startInterval(timing) {
    intervalID = setInterval(function() {
      current_timing = timing
        --timing;
      timeCount(timing);
    }, 1000);
  }

  function stopInterval() {
    clearInterval(intervalID);
  }
</script>