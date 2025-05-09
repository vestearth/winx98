<?php
// use Mpdf\Tag\S;
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'deposit_withdraw'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$current_user = User::getCurrentUserID();

if ($_POST) {
  if (isset($_POST['submit_deposit_turnover'])) {
    $data = [
      'user_id' => $_POST['agent_id'],
      'transaction_type' => 'deposit',
      'credit_amount' => $_POST['credit_amount'],
      'transaction_by_user_id' => $current_user,
      'remark' => $_POST['remark'],
      'web_bank_bot_list_id' => $_POST['web_bank_bot_list_id'],
      'admin_add_manual_date_time' => $_POST['admin_add_manual_date_time'],
      'status' => 'completed',
      'transaction_by' => 'admin',
      'is_wallet' => '1',
      'is_calculate_turn_over' =>  '1',
    ];
    $result = nga_user::addUserCreditTransaction($code, $data, $_FILES['img']);
  } else if (isset($_POST['submit_add_deposit'])) {
    $data = [
      'user_id' => $_POST['agent_id'],
      'transaction_type' => 'deposit',
      'credit_amount' => $_POST['credit_amount'],
      'transaction_by_user_id' => $current_user,
      'web_bank_bot_list_id' => $_POST['web_bank_bot_list_id'],
      'remark' => $_POST['remark'],
      'admin_add_manual_date_time' => $_POST['admin_add_manual_date_time'],
      'status' => 'completed',
      'transaction_by' => 'admin',
      'is_wallet' => '1'
    ];
    $result = nga_user::addUserCreditTransaction($code, $data, $_FILES['img']);
  } else if (isset($_POST['submit_cancel_transfer'])) {
    $result = nga_user::cancelWithdraw($code, $_POST['id'], $_POST['remark_cancel']);
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

$receive_from_list = [

  [
    'value' => 'admin_add_manual_with_turn_over ',
    'text' => 'รายการฝากเงินไม่เข้า'
  ],
  [
    'value' => 'admin_add_manual_not_turn_over ',
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
  [
    'value' => 'admin_confirm_manual',
    'text' => 'รายการถอนอนุมัติโดยแอดมิน'
  ],
  [
    'value' => 'admin_cancel_manual',
    'text' => 'รายการฝากยกเลิกโดยแอดมิน'
  ],
];

$status_list = [
  [
    'value' => 'completed',
    'text' => 'สำเร็จแล้ว'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'ดำเนินการ'
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

$user_data = nga_user::selectUser($code, []);
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
          รายการฝาก / ถอน (เงินสดเท่านั้น) </div>
        <div class="font-14px text-sub ml-10px">
          รายการประวัติการฝาก - ถอนเงิน
        </div>
      </div>

      <div class="button-panel col-lg-6 d-flex justify-content-end">
        <div class="refresh-auto d-flex text-blue my-auto">
          <span id="timing">60</span> s
          <a class="mr-15px ml-5px"><?= file_get_contents('./assets/icon/Icon-refresh-cw.svg') ?></a>
        </div>
        <button class="btn-red mx-5px w-180px" <?= Tiwdal::register('cannot') ?>>ฝากเงินไม่เข้า</button>
        <button class="btn-blue mx-5px w-180px" <?= Tiwdal::register('add_modal') ?>>+ เพิ่มรายการฝาก</button>
        <!-- <button class="btn-yellow mx-5px w-180px" disabled>ล้างรายการถอนค้าง</button> -->
      </div>

    </div>

  </div>
  <div class='bank-panel bg-white py-10px d-flex'>
    <?php
    foreach ($bot_list as $bot_active) {
    ?>
      <?php create_bank_card($bot_active['status_color'], $bot_active['bank_image'], $bot_active['bank_name_th'], $bot_active['bank_account_name'], $bot_active['bank_account_no']); ?>
    <?php } ?>
  </div>
  <div id="deposit_withdraw" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('deposit_withdraw', '?c=' . $code, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
            <th nowrap data-sort="transaction_type" data-filter="<?= Homepagify::dataFilter('transaction_type', 'select', $type_list) ?>">ประเภท</th>
            <th nowrap data-sort="customer_username" data-filter="<?= Homepagify::dataFilter('customer_username', 'text') ?>">ยูสเซอร์ (agent)</th>
            <th nowrap data-sort="customer_bank_name" data-filter="<?= Homepagify::dataFilter('customer_bank_name', 'text') ?>">บัญชีลูกค้า</th>
            <th nowrap data-sort="web_bank_name" data-filter="<?= Homepagify::dataFilter('web_bank_name', 'text') ?>">บัญชีเว็บ</th>
            <th nowrap data-sort="admin_add_manual_date_time" data-filter="<?= Homepagify::dataFilter('admin_add_manual_date', 'date') ?>">วันที่ฝาก</th>
            <th nowrap data-sort="credit_amount" data-filter="<?= Homepagify::dataFilter('credit_amount', 'text') ?>" class="thin-cell">จำนวน</th>
            <th nowrap data-sort="credit_before" class="thin-cell">เครดิต (ก่อน)</th>
            <th nowrap data-sort="credit_after" class="thin-cell">เครดิต (หลัง)</th>
            <th nowrap data-sort="receive_from" data-filter="<?= Homepagify::dataFilter('receive_from', 'select', $receive_from_list) ?>">ประเภท</th>
            <th nowrap data-sort="status" width="10%" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>
            <th nowrap data-sort="remark" data-filter="<?= Homepagify::dataFilter('remark', 'text') ?>" class="thin-cell">หมายเหตุ</th>
            <th nowrap data-sort="credit_after" class="thin-cell">รูปสลิป</th>
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
            <?php TiwForm::normal('textarea', '', ['name' => 'remark', 'class' => '', 'placeholder' => 'กรอก']); ?>
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
            <?php TiwForm::normal('textarea', '', ['name' => 'remark', 'class' => '', 'placeholder' => 'กรอก']); ?>
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
      <h3 class="text-center font-16px font-SemiBold text-uppercase">ยกเลิกรายการถอนเงิน</h3>
      <p class="mb-5px text-center">
        คุณต้องการ <span class="text-danger text-uppercase"> “ยกเลิกรายการถอนเงิน”</span> นี้ใช่หรือไม่
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
      <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ปิด</button>
      <button type="submit" class="btn btn-danger w-100px" name="submit_cancel_transfer">ยืนยัน</button>
    </div>
  </form>
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