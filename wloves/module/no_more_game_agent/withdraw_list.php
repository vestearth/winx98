<?php
// use Mpdf\Tag\S;
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'manage_withdraw'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$current_user = User::getCurrentUserID();

if ($_POST) {
  if (isset($_POST['submit_cancel_transfer'])) {
    $result = nga_user::cancelWithdraw($code, $_POST['id'], $_POST['remark_cancel']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_withdraw',
        'detail' => 'ยกเลิกรายการถอนเงิน สาเหตุ :' . $_POST['remark_cancel'],
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


$select_bot_bank = nga_management_bot::selectBotGroupList($code);
$bank_name_options = [
  'is_search' => true,
  'list' => [],
];
$bank_name_options['list'][] = [
  'value' => '',
  'name' => 'ไม่มีธนาคาร',
  'img' => 'http://159.223.33.6:8003/system/resource/placeholder/placeholder_square.jpg',
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

function create_bank_card($color, $bank, $name_bank, $name, $number)
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

  // [
  //   'value' => 'admin_add_manual_with_turn_over ',
  //   'text' => 'รายการฝากเงินไม่เข้า'
  // ],
  // [
  //   'value' => 'admin_add_manual_not_turn_over ',
  //   'text' => 'เพิ่มการฝากด้วยมือ'
  // ],
  [
    'value' => 'bot_auto_match',
    'text' => 'รายการถอนเงินอัตโนมัติ'
  ],
  [
    'value' => 'admin_add_manual',
    'text' => 'รายการอนุมัติโดยแอดมิน'
  ],
  [
    'value' => 'admin_confirm_manual',
    'text' => 'รายการถอนอนุมัติโดยแอดมิน'
  ],
  [
    'value' => 'admin_cancel_manual',
    'text' => 'รายการถอนยกเลิกโดยแอดมิน'
  ],
  [
    'value' => 'bot_cancel',
    'text' => 'รายการถอนยกเลิกโดยบอท'
  ],
];

$status_list = [
  [
    'value' => 'completed',
    'text' => 'สำเร็จแล้ว'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'กำลังโอนเงิน'
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
          รายการถอน (เงินสดเท่านั้น) </div>
        <div class="font-14px text-sub ml-10px">
          รายการประวัติการถอนเงิน
        </div>
      </div>
    </div>

  </div>
  <div id="withdraw_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('withdraw_list', '?c=' . $code . '&type=withdraw', '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
            <th nowrap data-sort="transaction_type">ประเภท</th>
            <th nowrap data-sort="customer_username" data-filter="<?= Homepagify::dataFilter('customer_username', 'text') ?>">ยูสเซอร์ (agent)</th>
            <th nowrap data-sort="customer_bank_name" data-filter="<?= Homepagify::dataFilter('customer_bank_name', 'text') ?>">บัญชีลูกค้า</th>
            <th nowrap data-sort="web_bank_name" data-filter="<?= Homepagify::dataFilter('web_bank_name', 'text') ?>">บัญชีเว็บ</th>
            <?php /* 
            <th nowrap data-sort="admin_add_manual_date_time" data-filter="<?= Homepagify::dataFilter('admin_add_manual_date', 'date') ?>">วันที่ฝาก</th>
            */ ?>
            <th nowrap data-sort="credit_amount" data-filter="<?= Homepagify::dataFilter('credit_amount', 'text') ?>" class="thin-cell">จำนวน</th>
            <th nowrap data-sort="credit_before" class="thin-cell">เครดิต (ก่อน)</th>
            <th nowrap data-sort="credit_after" class="thin-cell">เครดิต (หลัง)</th>
            <th class="th-right" nowrap>ยอดเงินก่อนถอน</th>
            <th class="th-right" nowrap>ยอดเงินหลังถอน</th>
            <th nowrap data-sort="receive_from" data-filter="<?= Homepagify::dataFilter('receive_from', 'select', $receive_from_list) ?>">ประเภท</th>
            <th nowrap data-sort="confirm_cancel_admin_id" data-filter="<?= Homepagify::dataFilter('confirm_cancel_admin_id', 'select', $admin_list) ?>">แอดมิน</th>
            <th nowrap data-sort="status" width="10%" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>
            <th nowrap data-sort="remark" data-filter="<?= Homepagify::dataFilter('remark', 'text') ?>" class="thin-cell">หมายเหตุ</th>
            <?php /* 
            <th nowrap data-sort="admin_add_manual_remark" data-filter="<?= Homepagify::dataFilter('admin_add_manual_remark', 'text') ?>" class="thin-cell">หมายเหตุแอดมิน</th>
            */ ?>
            <th nowrap class="thin-cell">รูปสลิป</th>
            <th nowrap class="thin-cell">QR code</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
  </div>

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

  <?php Tiwdal::startModal('preview_qr_code', 'modal-sm'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-body mt-30px">
    <div class="w-100 d-flex align-items-center justify-content-center">
      <img src="" name="{qr_code_img}">
    </div>
  </div>
  <?php Tiwdal::endModal(); ?>
</body>

</html>

<script>
  $(document).ready(function() {
    timeCount();
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