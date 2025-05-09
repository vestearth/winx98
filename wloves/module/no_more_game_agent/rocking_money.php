<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'rocking_money'];
require_once '../../.framework/import.php';

$code = $_GET['c'];

$status_list = [

  [
    'value' => 'confirm',
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

if ($_POST) {
  if (isset($_POST['submit_add_transfer_bank'])) {
    $data = [
      'bot_group_list_id' => $_POST['bot_group_list_id'],
      'transaction_to_bank_abb' => $_POST['transaction_to_bank_abb'],
      'transaction_to_bank_no' => $_POST['transaction_to_bank_no'],
      'amount' => $_POST['amount'],
      'remark' =>  $_POST['remark'],
      'admin_pin' => $_POST['admin_pin'],
    ];
    $result = nga_management_bot::addNewBotTransferMoNey($code, $data);
  } else if (isset($_POST['submit_cancel_transfer'])) {
    $result = nga_management_bot::cancelBotTransferMoney($code, $_POST['id'], $_POST['remark_cancel']);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};
$group_bot_list = nga_management_bot::selectBotGroupList($code, []);

function create_bank_card($color, $bank, $name_bank, $name, $number, $status, $balance) {
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
    </div>
  </div>
</div>';
}

$bank = Bank::select();
$bank_list = [];
$bot_list = [];

foreach ($bank as $data) {
  $bank_list['list'][] = [
    'value' => $data['abb'],
    'name' => $data['name_th'],
  ];
}
$where_bank = [
  'is_open' => true
];
$bot_list_api = nga_management_bot::selectBotGroupList($code, $where_bank);

foreach ($bot_list_api as $bot_data) {
  $bot_list['list'][] = [
    'value' => $bot_data['id'],
    'name' => $bot_data['bot_name'],
  ];
}

$count_transfer = nga_management_bot::countBotTransferMoney($code);

$options_remarks = ['โยกเงินจากบัญชีฝากไปบัญชีถอน', 'โยกเงินจากบัญชีถอนไปบัญชีพัก'];
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
  <div class=' bg-card mb-10px pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">

      <div class="msg col-lg-6">
        <div class='topic ml-10px'>
          การโยกเงิน </div>
        <div class="font-14px text-sub ml-10px">
          ข้อมูลรายละเอียดการโยกเงิน
        </div>
      </div>
      <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'pl-20px pr-20px mr-15px'], ['type' => 'button', 'text' => '+ สร้างการโยกเงิน', 'modal_id' => 'add_rocking_money', 'modal_data' => []]); ?>
    </div>

  </div>
  <div class="bg-card">
    <div class="form-row px-15px align-items-center">

      <div class="col-lg-3 pt-10px">
        <div class="mb-10px">
          <div class="card-header-success py-10px  font-SemiBold font-14px color-dark">
            ยอดโยกเงินทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-success"><?= number_format($count_transfer['sum_transfer_amount'], 2); ?></span> บาท
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 pt-10px">
        <div class="mb-10px">
          <div class="card-header-success  font-SemiBold font-14px color-dark">
            ยอดโยกเงินอัตโนมัติทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-success"><?= number_format($count_transfer['sum_confirm_amount'], 2); ?> </span>บาท
            </div>

          </div>
        </div>
      </div>
      <div class="col-lg-3 pt-10px">
        <div class="mb-10px">
          <div class="card-header-danger py-10px font-SemiBold font-14px color-dark">
            ยกเลิกทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-danger"><?= number_format($count_transfer['cancel_count']); ?> </span>รายการ
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class='bank-panel bg-white py-10px d-flex'>
    <?php foreach ($group_bot_list as $bot_active) { ?>
      <?php
      $bot_active['bank_account_no'] = isset($bot_active['bank_account_no']) ? $bot_active['bank_account_no'] : '';
      create_bank_card($bot_active['status_color'], $bot_active['bank_image'], $bot_active['bank_name_th'], $bot_active['bank_account_name'], $bot_active['bank_account_no'], $bot_active['status_code'], $bot_active['current_balance']);
      ?>
    <?php } ?>
  </div>

  <div id="rocking_money" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('rocking_money', '?c=' . $code, '', 'รายการโยกเงิน') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="insert_date" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วัน/เวลา</th>
            <th nowrap>ประเภท</th>
            <th class="th-right" nowrap data-sort="amount" data-filter="<?= Homepagify::dataFilter('amount', 'text') ?>">ยอดเงิน</th>
            <th class="th-right" nowrap>ยอดเงินก่อนโยก</th>
            <th class="th-right" nowrap>ยอดเงินหลังโยก</th>
            <th nowrap data-sort="remark" data-filter="<?= Homepagify::dataFilter('remark', 'text') ?>">เหตุผล</th>
            <th nowrap data-sort="transaction_to_bank_no" data-filter="<?= Homepagify::dataFilter('transaction_to_bank_no', 'text') ?>">บัญชีที่โอน</th>
            <th nowrap data-sort="transaction_from_bank_no" data-filter="<?= Homepagify::dataFilter('transaction_from_bank_no', 'text') ?>">บัญชีเว็บ</th>
            <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <?php Tiwdal::startModal('add_rocking_money', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-header">
    <h5 class="modal-title text-uppercase">สร้างการโยกเงิน</h5>
  </div>
  <form method="post" autocomplete="off" class="form-loading">
    <div class="modal-body">
      <div class="form-group mt-10px">
        <div class="form-row align-items-center">
          <div class="col-lg-3">
            <div class=" font-14px font-Medium mb-10px py-5px">
              บัญชีธนาคารฝากถอน
            </div>
          </div>
          <div class="col-lg-9">
            <div class="ml-5px font-16px font-Medium">
              <?php
              TiwForm::normal('select', '', ['name' => 'bot_group_list_id', 'class' => 'font-16px font-Medium event_select_data_bank'], $bot_list); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mt-10px scope_show_current_balance">
        <div class="form-row align-items-center">
          <div class="col-lg-3">
            <div class=" font-14px font-Medium mb-10px py-5px">
              ยอดเงินคงเหลือ
            </div>
          </div>
          <div class="col-lg-9">
            <div class="ml-5px font-16px font-Medium">
              <?php foreach ($bot_list_api as $key => $value) { ?>
                <div class="scope_current_balance" data-id="<?= $value['id'] ?>" style="<?= $key != 0 ? 'display:none' : '' ?> ">
                  <?= number_format($value['current_balance'], 2) . ' บาท' ?>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mt-10px">
        <div class="form-row align-items-center">
          <div class="col-lg-3">
            <div class="font-14px font-Medium mb-10px py-5px">
              ธนาคารที่จะโอน
            </div>
          </div>
          <div class="col-lg-9">
            <div class="ml-5px font-16px font-Regular">
              <?php
              TiwForm::normal('select', '', ['name' => 'transaction_to_bank_abb', 'class' => 'font-16px font-Regular event_bank_id'], $bank_list); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mt-10px">
        <div class="form-row align-items-center">
          <div class="col-lg-3">
            <div class="font-14px font-Medium mb-10px py-5px">
              เลขบัญชีที่จะโอน
            </div>
          </div>
          <div class="col-lg-9">
            <div class="ml-5px font-16px font-Regular">
              <?php
              TiwForm::normal('number', '', ['name' => 'transaction_to_bank_no', 'placeholder' => 'Enter', 'class' => 'event_bank_account']); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mt-10px">
        <div class="form-row align-items-center">
          <div class="col-lg-3">
            <div class="font-14px font-Medium mb-10px py-5px">
              ชื่อบัญชีที่จะโอน
            </div>
          </div>
          <div class="col-lg-9">
            <div class="ml-5px mt--10px font-16px font-Regular scope_account_name">

            </div>
          </div>
        </div>
      </div>
      <div class="form-group mt-10px">
        <div class="form-row align-items-center">
          <div class="col-lg-3">
            <div class="font-14px font-Medium mb-10px py-5px">
              จำนวนเงิน
            </div>
          </div>
          <div class="col-lg-9">
            <div class="ml-5px font-16px font-Regular">
              <?php
              TiwForm::normal('number', '', ['name' => 'amount', 'placeholder' => 'Enter']); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mt-10px">
        <div class="form-row align-items-center">
          <div class="col-lg-3 align-self-start">
            <div class="font-14px font-Medium mb-10px pt-10px">
              เหตุผล
            </div>
          </div>
          <div class="col-lg-9">
            <div class="ml-5px font-16px font-Regular">
              <fieldset>
                <input list="remark" type="text" name="remark" class="form-select form-datalist" autocomplete="off">
                <datalist id="remark">
                  <?php foreach ($options_remarks as $value) { ?>
                    <option value="<?= $value ?>">
                    <?php } ?>
                </datalist>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group mt-10px">
        <div class="form-row align-items-center">
          <div class="col-lg-3">
            <div class="font-14px font-Medium mb-10px py-5px">
              PIN
            </div>
          </div>
          <div class="col-lg-9">
            <div class="ml-5px">
              <?= TiwForm::normal('number', '', ['name' => 'admin_pin', 'class' => 'password-style', 'autocomplete' => 'off'], []); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ยกเลิก</button>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_add_transfer_bank', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('detail_rocking_money', 'modal-lg'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-header">
    <h5 class="modal-title text-uppercase font-16px font-SemiBold">ข้อมูลการโยกเงิน</h5>
  </div>
  <form method="post">
    <div class="modal-body">
      <div class=" font-14px font-SemiBold">
        <i>รายละเอียดบัญชี</i>
      </div>
      <div class="d-flex">
        <img style="width: 55px; height:55px; border-radius:50px;" name="{transaction_from_bank_image}" class="mt-15px mr-15px" src="./assets/icon/icon-customer-scb.svg" alt="">
        <div class="d-flex flex-column">
          <div class=" text-primary font-18px font-Medium mt-10px" name="{transaction_from_bank_name}">
            เกศรินทร์ เหล็กคำ
          </div>
          <div class=" font-16px font-Medium" name="{transaction_from_bank_name_th}">
            ธนาคารไทยพาณิชย์
          </div>
          <div class=" font-16px font-Medium" name="{transaction_from_bank_no}">
            000-0-0000-0
          </div>
        </div>
      </div>
      <hr>
      <div class=" font-14px font-SemiBold">
        <i>รายละเอียดการโยกเงิน</i>
      </div>
      <div class="d-flex mt-15px align-items-center">
        <div class="col-lg-3 font-14px font-Medium p-0">
          วัน/เวลา
        </div>
        <div class="col-lg-9 font-16px font-Medium p-0">
          <span name="{date_data}">
            14/06/2022, 07:49
          </span>
        </div>
      </div>
      <div class="d-flex mt-15px align-items-center">
        <div class="col-lg-3 font-14px font-Medium p-0">
          ยอดเงิน
        </div>
        <div class="col-lg-9 font-16px font-Medium p-0" name="{amount_format}">
          100.00
        </div>
      </div>
      <div class="d-flex mt-15px align-items-center">
        <div class="col-lg-3 font-14px font-Medium p-0">
          บัญชีเว็บ
        </div>
        <div class="col-lg-9 font-16px font-Medium p-0">
          <span name="{account_web}"></span> |
          <span name="{account_web2}"></span> |
          <span name="{account_web3}"></span>
        </div>
      </div>
      <div class="d-flex mt-15px align-items-center">
        <div class="col-lg-3 font-14px font-Medium p-0">
          สถานะ
        </div>
        <div class="col-lg-9 font-14px font-Medium p-0">
          <div class="text-success" name="{confirm_txt}">ได้รับเงินแล้ว</div>
          <div class="text-warning" name="{waiting_txt}">ได้รับเงินแล้ว</div>
          <div class="text-danger" name="{cancel_txt}">ได้รับเงินแล้ว</div>
        </div>
      </div>
      <hr>
      <div class="d-flex">
        <div class="col-lg-6 p-0">
          <div class=" font-14px font-SemiBold">
            <i>รายการโอน</i>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              วันที่โอน
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0" name="{confirm_date}">
              14/06/2022, 07:49
            </div>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              ยอดเงิน
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0" name="{amount_format}">
              100.00
            </div>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              สถานะ
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0" name="{transfer_status}">
              โอนเงินเเล้ว
            </div>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              หมายเหตุ
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0" name="{remark}">
              สำเร็จ
            </div>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              ยกเลิกรายการ
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0" name="{remark_cancel}">
            </div>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              โอนโดย
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0">
              <img src="./assets/image/bot-auto.png" name="{img_transfer}">
            </div>
          </div>
        </div>
        <div class="col-lg-6 p-0 d-flex justify-content-center align-items-center">
          <!-- <img src="./assets/image/qrcode.png" alt="" style="width: 231px; height:231px"> -->
        </div>
      </div>
      <hr>
      <div class="d-flex">
        <div class="col-lg-6 p-0">
          <div class=" font-14px font-SemiBold">
            <i>รายละเอียด</i>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              ยอดเงินก่อนโยก
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0" name="{money_before}"></div>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              ยอดเงินหลังโยก
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0" name="{money_after}"></div>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              บัญชีต้นทาง
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0">
              <div class="d-flex">
                <div class="bank-img small-size mr-5px">
                  <img src="" name="{transaction_from_bank_image}">
                </div>
                <div class=" d-flex flex-column">
                  <div name="{transaction_from_bank_name}"></div>
                  <div name="{transaction_from_bank_no}"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              บัญชีปลายทาง
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0">
              <div class="d-flex">
                <div class="bank-img small-size mr-5px">
                  <img src="" name="{transaction_to_bank_image}">
                </div>
                <div class=" d-flex flex-column">
                  <div name="{transaction_to_bank_name_th}"></div>
                  <div name="{transaction_to_bank_no}"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex mt-15px align-items-center">
            <div class="col-lg-6 font-14px font-Medium p-0">
              QR Code
            </div>
            <div class="col-lg-6 font-16px font-Medium p-0">
              <img src="" name="{img_qr_code}">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ปิด']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('cancel_transfer_money', 'modal-md'); ?>
  <form method="post" class="form-loading">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    <div class="modal-body mt-30px">
      <h3 class="text-center font-16px font-SemiBold text-uppercase">ยกเลิกการโยกรายการ</h3>
      <p class="mb-5px text-center">
        คุณต้องการ <span class="text-danger text-uppercase"> “ยกเลิกการโยก”</span> นี้ใช่หรือไม่
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

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
  <?php Aww::loadAsset('assets/js/force_logout.js'); ?>
  <script>
    $(document).ready(function() {
      $(document).on('change', '.event_select_data_bank', function(e) {
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

      // Ajax ตอนกรอกเลขบัญชี
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
            console.log(result);
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
    });
  </script>
</body>

</html>