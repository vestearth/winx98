<?php
$prefix = '../../../';
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'auto_withdraw'];
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];

$transaction_type_msg = '';
$transaction_type = '';
$title = '';

if ($_POST['status'] == 'confirm') {
  $status_msg = 'ได้รับเครดิตแล้ว';
  $status_class = 'text-success';
} else {
  $status_msg = 'รอดำเนินการ';
  $status_class = 'text-warning';
}

$select_bot_bank = nga_management_bot::selectBotGroupList($code);
$bank_name_options = [
  'prefix' => '../../../',
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
?>
<form method="post" enctype="multipart/form-data">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">ข้อมูลการถอนเงิน</h5>
    </div>
    <div class="modal-body px-0 text-header">
      <div class="border-bottom">
        <div class="form-row modal-card-custom">
          <div class="col-6 section-left">
            <div class="form-row px-15px ">
              <div class="col-lg-4 my-auto py-10px font-italic font-14px font-SemiBold">
                รายละเอียดลูกค้า
              </div>
              <div class="col-lg-8  pb-10px"></div>
              <div class="col-lg-6 my-auto pb-10px">
                <div class="d-flex align-items-center">
                  <div class="modal-bank-img">
                    <img src="<?= $_POST['customer_bank_image']; ?>">
                  </div>
                  <div class="ml-10px">
                    <span class="text-primary"><?= $_POST['customer_bank_name']; ?></span>
                    <p class="mb-0"><?= $_POST['customer_bank_no']; ?></p>
                  </div>
                </div>
              </div>
              <div class="col-lg-6  pb-10px"></div>
              <div class="col-lg-4 my-auto pb-10px">
                รหัสสมาชิก
              </div>
              <div class="col-lg-8  pb-10px">
                <?= $_POST['customer_username']; ?>
              </div>
              <div class="col-lg-4 my-auto pb-10px">
                กลุ่มลูกค้า
              </div>
              <div class="col-lg-8  pb-10px">
                <?= $_POST['customer_group_name']; ?>
              </div>
            </div>
          </div>
          <div class="col-6">
            <div class="form-row px-15px">
              <div class=" col-lg-8 my-auto py-10px font-italic font-14px font-SemiBold">
                <?= 'รายละเอียดรายการถอนเงิน' ?>
              </div>
              <div class="col-lg-4 pb-10px">
              </div>
              <div class="col-lg-4 my-auto pb-10px">
                วันที่เวลาแจ้งถอนเงิน
              </div>
              <div class="col-lg-8  pb-10px">
                <?= Aww::formatDate($_POST['transaction_date_time'], 'd/m/Y, H:i'); ?>
              </div>
              <div class="col-lg-4 my-auto pb-10px">
                จำนวน
              </div>
              <div class="col-lg-8 pb-10px text-primary">
                <?= number_format($_POST['credit_amount'], 2) ?>
              </div>
              <div class="col-lg-4 my-auto pb-10px">
                เครดิต (ก่อน)
              </div>
              <div class="col-lg-8  pb-10px">
                <?= number_format($_POST['credit_before'], 2) ?>
              </div>
              <div class="col-lg-4 my-auto pb-10px">
                เครดิต (หลัง)
              </div>
              <div class="col-lg-8  pb-10px">
                <?= number_format($_POST['credit_after'], 2); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row py-20px">
          <?php /* 
          <div class="col-12">
            <div class="form-row">
              <div class="col-md-3 px-15px d-flex align-items-center">
                เลือกบัญชีธนาคารสำหรับถอน
              </div>
              <div class="col-md-5">
                <?php
                $where_bank = ['is_withdraw' => true];
                $bank = nga_management_bot::selectBotGroupList($code, $where_bank);
                $bank_list = [
                  'prefix' => $prefix,
                ];
                foreach ($bank as $bank_data) {
                  $bank_list['list'][] = [
                    'value' => $bank_data['id'],
                    'name' => $bank_data['bank_account_name'] . ' / ' . $bank_data['bank_account_no'],
                    'img' => $bank_data['bank_image'],
                  ];
                }
                TiwForm::normal('select-img', '', ['name' => 'bank_abb', 'placeholder' => 'กรุณาเลือก', 'required' => 'true'], $bank_list) ?>
              </div>
            </div>
          </div>
          */ ?>
          <div class="col-12">
            <div class="form-row">
              <div class="col-md-3 px-15px">หมายเหตุ (ถ้ามี)</div>
              <div class="col-md-5">
                <?= TiwForm::normal('textarea', '', ['name' => 'remark', 'class' => 'form-control min-h-50px', 'placeholder' => 'กรอก'], []); ?>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="form-row">
              <div class="col-lg-3 px-15px">
                จากธนาคาร
              </div>
              <div class="col-lg-5">
                <?php TiwForm::normal('select-img', '', ['name' => 'bot_group_list_id', 'class' => 'event_select_data_bank'], $bank_name_options); ?>
              </div>
            </div>
          </div>
          <div class="col-12 scope_show_current_balance" style="display:none">
            <div class="form-row">
              <div class="col-lg-3 px-15px">
                ยอดเงินคงเหลือ
              </div>
              <div class="col-lg-5">
                <?php foreach ($select_bot_bank as $value) { ?>
                  <div class="scope_current_balance" data-id="<?= $value['id'] ?>" style="display:none">
                    <?= number_format($value['current_balance'], 2) . ' บาท' ?>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
          <?php /* 
          <div class="col-12">
            <div class="form-row">
              <div class="col-md-3 px-15px">
                อัพโหลดรูป
              </div>
              <div class="col-md-5">
                <div class="d-flex align-items-center custom_color">
                  <?php $options = [
                    'width' => '200px',
                    'height' => '100%',
                    'bg-img' => 'assets/image/bg_upload.png',
                  ];
                  TiwForm::normal('upload-img', '', ['name' => 'img_file'], $options); ?>
                </div>
              </div>
            </div>
          </div>
          */ ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-between">
    <div>
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-cancels min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    </div>
    <div class="d-flex">
      <?php
      TiwForm::normal('btn', '', ['name' => 'submit_deny', 'type' => 'submit', 'class' => 'btn btn-danger min-w-100px mr-10px'], ['text' => 'ไม่อนุมัติ', 'type' => '']);
      TiwForm::normal('btn', '', ['name' => 'submit_accept', 'type' => 'submit', 'class' => 'btn btn-success min-w-100px'], ['text' => 'อนุมัติ', 'type' => '']);
      ?>
    </div>
  </div>
  <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
  <input type="hidden" name="user_id" value="<?= $_POST['user_id'] ?>">
</form>