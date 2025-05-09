<?php
function phase_2($msg1, $num_range, $msg2, $class1 = '', $class2 = '', $class = '', $modal_key = '')
{
  $num = (12 - $num_range);
  echo  '<div class="form-row py-5px font-14px ' . $class . '">
  <div class="col-lg-' . $num_range . ' font-Medium text-grey ' . $class1 . '">
  ' . $msg1 . '
  </div>
  <div class="col-lg-' . $num . ' ' . $class2 . ' text-header">
  <span name=' . $modal_key . '>
  ' . $msg2 . '
  </span>
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

$status_list = [
  [
    'value' => 'completed',
    'text' => 'สำเร็จแล้ว'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'กำลังโอนเงิน'
  ],
];
?>

<div class='bg-whites pb-10px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">
    <div class="msg col-lg-6">
      <div class='topic'>
        รายการฝาก-ถอน (Wallet) </div>
      <div class="font-14px text-sub ">
        จัดการข้อมูลรายละเอียดรายการฝาก-ถอน (Wallet)
      </div>
    </div>
  </div>
</div>

<div class="bg-whites">
  <div class="form-row px-15px">
    <div class="col-lg-3">
      <div class="mb-10px">
        <div class="card-header-success  font-SemiBold font-14px">
          ยอดฝากรวม (ปัจจุบัน)
        </div>
        <div class="card-white px-15px py-10px font-Medium">
          <div class=" font-14px">
            <span class="font-20px font-Bold text-success"><?= number_format($customer_data['sum_transaction_deposit'], 2); ?></span>
            บาท
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="mb-10px">
        <div class="card-header-danger  font-SemiBold font-14px">
          ยอดถอนรวม (ปัจจุบัน)
        </div>
        <div class="card-white px-15px py-10px font-Medium">
          <div class=" font-14px">
            <span class="font-20px font-Bold text-danger"><?= number_format($customer_data['sum_transaction_withdraw'], 2); ?></span> บาท
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="wallet_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('wallet_list', '?c=' . $code . '&id=' . $id, '', 'รายการ') ?>>
  <div class="table-responsive">
    <table class="table table-sort table-search ">
      <thead>
        <tr>
          <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
          <th nowrap data-sort="transaction_type" data-filter="<?= Homepagify::dataFilter('transaction_type', 'select', $type_list) ?>">ประเภท</th>
          <th nowrap data-sort="credit_amount" data-filter="<?= Homepagify::dataFilter('credit_amount', 'number') ?>">จำนวนเงิน</th>
          <th nowrap data-sort="credit_before">เครดิต (ก่อน)</th>
          <th nowrap data-sort="credit_after">เครดิต (หลัง)</th>
          <th nowrap class="thin-cell">ธนาคาร</th>
          <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>
          <th nowrap data-sort="remark" data-filter="<?= Homepagify::dataFilter('remark', 'text') ?>">เหตุผล</th>
          <th></th>
        </tr>
      </thead>
    </table>
  </div>
</div>


<?php Tiwdal::startModal('detail_modal', 'modal-lg'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title font-16px font-SemiBold">ข้อมูลการ<span name="{modal_type_msg}"></span></h5>
    </div>
    <div class="modal-body pt-0 px-5px">
      <div class="form-row border-bottom px-15px  ">
        <div class="col-lg-6 border-right pb-10px">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดลูกค้า
          </div>
          <div class="form-row pb-10px">
            <div class="col-3">
              <img src="./assets/image/scb-large.png">
            </div>
            <div class="col-9">
              <div class="text-primary font-18px">
                เกศรินทร์ เหล็กคำ
              </div>
              <div>
                000-0-0000-0
              </div>
            </div>
          </div>
          <?= Phase_2('รหัสสมาชิก', 6, '89bvia9367', '', '', '', '{customer_username}') ?>
          <?= Phase_2('เบอร์โทร', 6, '0844644816', '', '', '', '{customer_username}') ?>
          <?= Phase_2('กลุ่มลูกค้า', 6, 'Bronze', '', '', '', '{customer_group_name}') ?>

        </div>
        <div class="col-lg-6">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดการ<span name="{modal_type_msg}"></span>
          </div>
          <?= Phase_2('วัน/เวลา', 5, '14/06/2022, 07:49', '', '', '', '{date_trans}') ?>
          <?= Phase_2('ยอดเงิน', 5, '57.00', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('สถานะ', 5, 'สำเร็จแล้ว', '', 'font-14px', '', '{status_th}') ?>
          <?= Phase_2('เหตุผล', 5, 'ถอนเงินผ่านธนาคารไทยพาณิชย์ เลขบัญชี 411-1-01708-3', '', '', '', '{remark}') ?>

        </div>
      </div>
      <div class="form-row px-15px">
        <div class="col-lg-8 ">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายการโอน
          </div>
          <?= Phase_2('วันที่โอน', 6, '', '', '', '', '{complete_date_trans}') ?>
          <?= Phase_2('ยอดเงิน', 6, '57.00', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('เลขบัญชี', 6, '<div>บัญชีเว็บ: <span name="{web_bank_no}">829-2-65515-6</span></div>
                                    <div> บัญชีลูกค้า: <span name="{customer_bank_no}">411-1-01708-3</span></div>') ?>
          <?= Phase_2('สถานะ', 6, 'โอนเงินเเล้ว', '', '', '', '{status_th}') ?>
          <?= Phase_2('ก่อนโอน', 6, '200.00', '', '', '', '{credit_before_txt}') ?>
          <?= Phase_2('หลังโอน', 6, '143.00', '', '', '', '{credit_after_txt}') ?>
          <?= Phase_2('หมายเหตุ', 6, 'สำเร็จ', '', '', '', '{remark}') ?>
          <?= Phase_2('โอนโดย', 6, '<img src="assets/image/bot-auto.png">', '', '', '', '{confirm_by}') ?>
        </div>
      </div>

    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="{id}" class="event_clone_id">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <button type="button" class="btn min-w-120px btn btn-danger m-5px event_btn_cancel" <?= Tiwdal::register('confirm_cancel_complete_modal', []); ?>>
      ยกเลิกรายการถอนเงิน
    </button>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('complete_modal', 'modal-lg'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title font-16px font-SemiBold">ข้อมูลการ<span name="{modal_type_msg}"></h5>
    </div>
    <div class="modal-body pt-0 px-5px">
      <div class="form-row border-bottom px-15px  ">
        <div class="col-lg-6 border-right pb-10px">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดลูกค้า
          </div>
          <div class="form-row pb-10px">
            <div class="col-3">
              <img src="./assets/image/scb-large.png">
            </div>
            <div class="col-9">
              <div class="text-primary font-18px" name="{customer_bank_name}">
              </div>
              <div>
                <span name="{customer_bank_no}">
                </span>
              </div>
            </div>
          </div>
          <?= Phase_2('รหัสสมาชิก', 6, '89bvia9367', '', '', '', '{customer_username}') ?>
          <?= Phase_2('เบอร์โทร', 6, '0844644816', '', '', '', '{customer_username}') ?>
          <?= Phase_2('กลุ่มลูกค้า', 6, 'Bronze', '', '', '', '{customer_group_name}') ?>

        </div>
        <div class="col-lg-6">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดการ<span name="{modal_type_msg}">
          </div>
          <?= Phase_2('วัน/เวลา', 5, '', '', '', '', '{date_trans}') ?>
          <?= Phase_2('ยอดเงิน', 5, '', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('สถานะ', 5, '', '', 'font-14px', '', '{status_th}') ?>
          <?= Phase_2('เหตุผล', 5, '', '', '', '', '{remark}') ?>

        </div>
      </div>
      <div class="form-row px-15px">
        <div class="col-lg-8 ">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายการโอน
          </div>
          <?= Phase_2('วันที่โอน', 6, '', '', '', '', '{complete_date_trans}') ?>
          <?= Phase_2('ยอดเงิน', 6, '', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('เลขบัญชี', 6, '<div>บัญชีเว็บ: <span name="{web_bank_no}">829-2-65515-6</span></div>
                                    <div> บัญชีลูกค้า: <span name="{customer_bank_no}">411-1-01708-3</span></div>') ?>
          <?= Phase_2('สถานะ', 6, 'โอนเงินเเล้ว', '', '', '', '{status_th}') ?>
          <?= Phase_2('ก่อนโอน', 6, '200.00', '', '', '', '{credit_before_txt}') ?>
          <?= Phase_2('หลังโอน', 6, '143.00', '', '', '', '{credit_after_txt}') ?>
          <?= Phase_2('หมายเหตุ', 6, 'สำเร็จ', '', '', '', '{remark}') ?>
          <?= Phase_2('โอนโดย', 6, '<img src="assets/image/bot-auto.png">', '', '', '', '{confirm_by}') ?>
          <div class="form-row">
            <div class="col-lg-6 font-Medium text-grey">
              รูปภาพ
            </div>
            <div class="col-lg-6">
              <div class="w-100">
                <img src="assets/image/placeholder_square.jpg" class="w-100 border-radius-10px" name="{admin_confirm_image}">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('complete_no_img_modal', 'modal-lg'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title font-16px font-SemiBold">ข้อมูลการ<span name="{modal_type_msg}"></h5>
    </div>
    <div class="modal-body pt-0 px-5px">
      <div class="form-row border-bottom px-15px  ">
        <div class="col-lg-6 border-right pb-10px">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดลูกค้า
          </div>
          <div class="form-row pb-10px">
            <div class="col-3">
              <img src="./assets/image/scb-large.png">
            </div>
            <div class="col-9">
              <div class="text-primary font-18px" name="{customer_bank_name}">
              </div>
              <div>
                <span name="{customer_bank_no}">
                </span>
              </div>
            </div>
          </div>
          <?= Phase_2('รหัสสมาชิก', 6, '89bvia9367', '', '', '', '{customer_username}') ?>
          <?= Phase_2('เบอร์โทร', 6, '0844644816', '', '', '', '{customer_username}') ?>
          <?= Phase_2('กลุ่มลูกค้า', 6, 'Bronze', '', '', '', '{customer_group_name}') ?>

        </div>
        <div class="col-lg-6">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดการ<span name="{modal_type_msg}">
          </div>
          <?= Phase_2('วัน/เวลา', 5, '', '', '', '', '{date_trans}') ?>
          <?= Phase_2('ยอดเงิน', 5, '', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('สถานะ', 5, '', '', 'font-14px', '', '{status_th}') ?>
          <?= Phase_2('เหตุผล', 5, '', '', '', '', '{remark}') ?>

        </div>
      </div>
      <div class="form-row px-15px">
        <div class="col-lg-8 ">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายการโอน
          </div>
          <?= Phase_2('วันที่โอน', 6, '', '', '', '', '{complete_date_trans}') ?>
          <?= Phase_2('ยอดเงิน', 6, '', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('เลขบัญชี', 6, '<div>บัญชีเว็บ: <span name="{web_bank_no}">829-2-65515-6</span></div>
                                    <div> บัญชีลูกค้า: <span name="{customer_bank_no}">411-1-01708-3</span></div>') ?>
          <?= Phase_2('สถานะ', 6, 'โอนเงินเเล้ว', '', '', '', '{status_th}') ?>
          <?= Phase_2('ก่อนโอน', 6, '200.00', '', '', '', '{credit_before_txt}') ?>
          <?= Phase_2('หลังโอน', 6, '143.00', '', '', '', '{credit_after_txt}') ?>
          <?= Phase_2('หมายเหตุ', 6, 'สำเร็จ', '', '', '', '{remark}') ?>
          <?= Phase_2('โอนโดย', 6, '<img src="assets/image/bot-auto.png">', '', '', '', '{confirm_by}') ?>
        </div>
      </div>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('complete_withdraw_modal', 'modal-lg'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title font-16px font-SemiBold">ข้อมูลการ<span name="{modal_type_msg}"></h5>
    </div>
    <div class="modal-body pt-0 px-5px">
      <div class="form-row border-bottom px-15px  ">
        <div class="col-lg-6 border-right pb-10px">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดลูกค้า
          </div>
          <div class="form-row pb-10px">
            <div class="col-3">
              <img src="./assets/image/scb-large.png">
            </div>
            <div class="col-9">
              <div class="text-primary font-18px" name="{customer_bank_name}">
              </div>
              <div>
                <span name="{customer_bank_no}">
                </span>
              </div>
            </div>
          </div>
          <?= Phase_2('รหัสสมาชิก', 6, '89bvia9367', '', '', '', '{customer_username}') ?>
          <?= Phase_2('เบอร์โทร', 6, '0844644816', '', '', '', '{customer_username}') ?>
          <?= Phase_2('กลุ่มลูกค้า', 6, 'Bronze', '', '', '', '{customer_group_name}') ?>
        </div>
        <div class="col-lg-6">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดการ<span name="{modal_type_msg}">
          </div>
          <?= Phase_2('วัน/เวลา', 5, '', '', '', '', '{date_trans}') ?>
          <?= Phase_2('ยอดเงิน', 5, '', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('สถานะ', 5, '', '', 'font-14px', '', '{status_th}') ?>
          <?= Phase_2('เหตุผล', 5, '', '', '', '', '{remark}') ?>
        </div>
      </div>
      <div class="form-row px-15px">
        <div class="col-lg-8 ">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายการโอน
          </div>
          <?= Phase_2('วันที่โอน', 6, '', '', '', '', '{complete_date_trans}') ?>
          <?= Phase_2('ยอดเงิน', 6, '', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('เลขบัญชี', 6, '<div>บัญชีเว็บ: <span name="{web_bank_no}">829-2-65515-6</span></div>
                                    <div> บัญชีลูกค้า: <span name="{customer_bank_no}">411-1-01708-3</span></div>') ?>
          <?= Phase_2('สถานะ', 6, 'โอนเงินเเล้ว', '', '', '', '{status_th}') ?>
          <?= Phase_2('ก่อนโอน', 6, '200.00', '', '', '', '{credit_before_txt}') ?>
          <?= Phase_2('หลังโอน', 6, '143.00', '', '', '', '{credit_after_txt}') ?>
          <?= Phase_2('หมายเหตุ', 6, 'สำเร็จ', '', '', '', '{remark}') ?>
          <?= Phase_2('โอนโดย', 6, '<img src="assets/image/bot-auto.png">', '', '', '', '{confirm_by}') ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="{id}" class="event_clone_id">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <button type="button" class="btn min-w-120px btn btn-danger m-5px event_btn_cancel" <?= Tiwdal::register('confirm_cancel_complete_modal', []); ?>>
      ยกเลิกรายการถอนเงิน
    </button>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('confirm_cancel_complete_modal', 'modal-md'); ?>
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
    <?php TiwForm::normal('hidden', '', ['name' => 'id', 'class' => 'event_take_clone_id'], []); ?>
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ปิด</button>
    <button type="submit" class="btn btn-danger w-100px" name="submit_complete_cancel_transfer">ยืนยัน</button>
  </div>
</form>
<?php Tiwdal::endModal(); ?>

<script>
  $(document).ready(function() {
    clone_id = 0;
    $(document).on('click', '.event_btn_cancel', function() {
      clone_id = $('.event_clone_id').val();
      $('#complete_withdraw_modal').modal('hide');
      $('#detail_modal').modal('hide');
      $('.event_take_clone_id').val(clone_id);
    });
  });
</script>