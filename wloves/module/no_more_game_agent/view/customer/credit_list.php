<?php
function phase_2($msg1, $num_range, $msg2, $class1 = '', $class2 = '', $class = '', $modal_key = '')
{
  $num = (12 - $num_range);
  echo  '<div class="form-row py-5px font-14px ' . $class . '">
  <div class="col-lg-' . $num_range . ' font-Medium text-grey ' . $class1 . '">
  ' . $msg1 . '
  </div>
  <div class="col-lg-' . $num . ' ' . $class2 . ' text-header ">
  <span name=' . $modal_key . '>
  ' . $msg2 . '
  </span>
  </div>
  </div>';
}

$type_list = [

  [
    'value' => 'success',
    'text' => 'ฝากเงิน'
  ],
  [
    'value' => 'cancel',
    'text' => 'ถอนเงิน'
  ],
];

$status_list = [
  [
    'value' => 'success',
    'text' => 'สำเร็จแล้ว'
  ],

];
?>

<div class='bg-whites pb-10px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">
    <div class="msg col-lg-6">
      <div class='topic'>
        รายการกระเป๋า Credit </div>
      <div class="font-14px text-sub ">
        จัดการข้อมูลรายละเอียดรายการกระเป๋า Credit
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
            <span class="font-20px font-Bold text-success"><?= number_format($customer_data['sum_transaction_deposit'], 2); ?> </span>
            บาท
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="credit_list" class="container-pagination bg-white no-border-radius mt-10px" <?= Homepagify::createHomepagify('credit_list', '?c=' . $code . '&id=' . $id, '', 'รายการ') ?>>
  <div class="table-responsive">
    <table class="table table-sort table-search ">
      <thead>
        <tr>
          <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
          <th nowrap>ประเภท</th>
          <th nowrap data-sort="credit_amount" data-filter="<?= Homepagify::dataFilter('credit_amount', 'number') ?>">จำนวนเงิน</th>
          <th nowrap data-sort="credit_before" class="text-center">เครดิต (ก่อน)</th>
          <th nowrap data-sort="credit_after" class="text-center">เครดิต (หลัง)</th>
          <th nowrap>สถานะ</th>
          <th nowrap data-sort="remark" width="30%" data-filter="<?= Homepagify::dataFilter('remark', 'text') ?>">เหตุผล</th>
          <th nowrap>รูปสลิป</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<?php Tiwdal::startModal('detail_modal', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<form method="post" class="">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title font-16px font-SemiBold">ข้อมูลการฝาก</h5>
    </div>
    <div class="modal-body pt-0 px-5px">
      <div class="form-row border-bottom px-15px  ">
        <div class="col-lg-6 border-right pb-10px">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดลูกค้า
          </div>
          <?= Phase_2('รหัสสมาชิก', 6, '89bvia9367', '', '', '', '{customer_username}') ?>
          <?= Phase_2('เบอร์โทร', 6, '0844644816', '', '', '', '{customer_username}') ?>
          <?= Phase_2('กลุ่มลูกค้า', 6, 'Bronze', '', '', '', '{customer_group_name}') ?>

        </div>
        <div class="col-lg-6">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายละเอียดการฝาก
          </div>
          <?= Phase_2('วัน/เวลา', 5, '14/06/2022, 07:49', '', '', '', '{date_trans}') ?>
          <?= Phase_2('ยอดเงิน', 5, '57.00', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('สถานะ', 5, 'สำเร็จแล้ว', '', 'font-14px', '', '{status_th}') ?>
          <?= Phase_2('เหตุผล', 5, 'ฝากเงินผ่านธนาคารไทยพาณิชย์ เลขบัญชี 411-1-01708-3', '', '', '', '{remark}') ?>

        </div>
      </div>
      <div class="form-row px-15px">
        <div class="col-lg-8 ">
          <div class="font-italic font-14px font-SemiBold py-10px">
            รายการโอน
          </div>
          <?= Phase_2('ยอดเงิน', 6, '57.00', '', '', '', '{credit_amount_txt}') ?>
          <?= Phase_2('สถานะ', 6, 'สำเร็จเเล้ว') ?>
          <?= Phase_2('ก่อนโอน', 6, '200.00', '', '', '', '{credit_before_txt}') ?>
          <?= Phase_2('หลังโอน', 6, '143.00', '', '', '', '{credit_after_txt}') ?>
          <?= Phase_2('หมายเหตุ', 6, 'สำเร็จ', '', '', '', '{remark}') ?>
          <?= Phase_2('โอนโดย', 6, '<img src="assets/image/bot-auto.png">', '', '', '', '{confirm_by}') ?>
        </div>
      </div>
      <div class="form-row px-15px">
        <div class="col-4 font-Medium text-grey font-14px">รูปสลิป</div>
        <div class="col-5">
          <div class="img-slip modal-size">
            <img name="{admin_confirm_image}" class="img-responsive">
          </div>
        </div>
      </div>

    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>