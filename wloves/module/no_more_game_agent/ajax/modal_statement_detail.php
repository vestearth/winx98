<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'statements'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];

if ($_POST['transaction'] == 'withdraw') {
  $transaction_type_msg = 'แจ้งถอนจาก';
  $transaction_type = '<span class="text-danger">รายการถอน</span>';
  $title = 'รายการถอน';
} elseif ($_POST['transaction'] == 'deposit') {
  $transaction_type_msg = 'รับโอนจาก';
  $transaction_type = '<span class="text-primary">รายการฝาก</span>';
  $title = 'รายการฝาก';
} else {
  $transaction_type_msg = '';
  $transaction_type = '';
  $title = '';
}

if ($_POST['status'] == 'confirm') {
  $status_msg = 'ได้รับเครดิตแล้ว';
  $status_class = 'text-success';
} else {
  $status_msg = 'รอดำเนินการ';
  $status_class = 'text-warning';
}
?>

<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">STATEMENT</h5>
  </div>
  <div class="modal-body px-0 text-header">
    <div class="border-bottom"">
          <div class=" form-row px-15px ">
            <div class=" col-lg-4 my-auto pb-10px font-italic font-14px font-SemiBold">
      รายละเอียด
    </div>
    <div class="col-lg-8  pb-10px">
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      วัน/เวลา
    </div>
    <div class="col-lg-8  pb-10px">
      <?= Aww::formatDate($_POST['transaction_date_time'], 'd/m/Y, H:i'); ?>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      จำนวนเงิน
    </div>
    <div class="col-lg-8  pb-10px">
      <?= number_format($_POST['transaction_amount'], 2) ?>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      รายละเอียดบัญชี
    </div>
    <div class="col-lg-8  pb-10px">
      <?= $transaction_type_msg . ' ' . $_POST['transaction_from_bank_abb'] . ' ' . $_POST['transaction_from_bank_no'] ?>
    </div>
  </div>
</div>
<div class="">
  <div class="form-row px-15px">
    <div class=" col-lg-4 my-auto pb-10px font-italic font-14px font-SemiBold">
      <?= $title ?>
    </div>
    <div class="col-lg-8  pb-10px">
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      วัน/เวลา(สร้าง)
    </div>
    <div class="col-lg-8  pb-10px">
      <?= Aww::formatDate($_POST['credit_transaction_date_time'], 'd/m/Y, H:i'); ?>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      วัน/เวลา(โอน)
    </div>
    <div class="col-lg-8  pb-10px">
      <?= Aww::formatDate($_POST['transaction_date_time'], 'd/m/Y, H:i'); ?>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      ยอดเงิน
    </div>
    <div class="col-lg-8  pb-10px">
      <?= number_format($_POST['transaction_amount'], 2) ?>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      สถานะ
    </div>
    <div class="col-lg-8  pb-10px">
      <div class="<?= $status_class ?>">
        <?= $status_msg ?>
      </div>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      รหัสลูกค้า
    </div>
    <div class="col-lg-8  pb-10px">
      <?= $_POST['customer_username'] ?>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      ชื่อลูกค้า
    </div>
    <div class="col-lg-8 text-blue pb-10px">
      <?= $_POST['customer_bank_name'] ?>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      บัญชีลูกค้า
    </div>
    <div class="col-lg-6 pb-10px">
      <div class="form-row">
        <div class="col-1">
          <img class="w-25px border-radius-15px" src="<?= $_POST['customer_bank_image'] ?>">
        </div>
        <div class="col-8 pl-10px">
          <?= $_POST['customer_bank_no'] ?>
        </div>
      </div>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      บัญชีเว็บ
    </div>
    <div class="col-lg-6 pb-10px">
      <div class="form-row">
        <div class="col-1">
          <img class="w-25px border-radius-15px" src="<?= $_POST['web_bank_image'] ?>">
        </div>
        <div class="col-8 pl-10px">
          <?= $_POST['web_bank_no'] ?>
        </div>
      </div>
    </div>
    <div class="col-lg-4 my-auto pb-10px">
      สร้างโดย
    </div>
    <div class="col-lg-8  pb-10px">
      <div class="capsule-blue">
        <span class="my-auto"><?= file_get_contents('../assets/icon/icon-person.svg') ?></span> <?= $_POST['bot_group_name'] ?>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<div class="modal-footer justify-content-end">
  <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-cancels min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
</div>