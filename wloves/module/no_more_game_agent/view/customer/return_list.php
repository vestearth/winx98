<?php
$status_list = [
  [
    'value' => 'confirm',
    'text' => 'ได้รับแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ยอดเงินไม่ได้กดรับ'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'รอรับ'
  ],
];

//id = user_id
$statistics = nga_user::getUserTurnOverStatistics($code, $id);
?>


<div class='bg-whites mb-1px pb-10px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">

    <div class="msg col-lg-6">
      <div class='topic'>
        รายการคืนยอดเสีย </div>
      <div class="font-14px text-sub ">
        จัดการข้อมูลรายละเอียดรายการคืนยอดเสีย
      </div>
    </div>
  </div>
</div>
<div class='bg-whites mb-1px py-10px'>
  <div class="form-row">
    <div class="col-3 ml-15px mr-10px">
      <div class="card-header-green font-SemiBold font-14px ">
        ยอดการคืนยอดเสีย
      </div>
      <div class="card-white px-15px py-10px font-Medium">
        <span class="font-Bold text-success font-20px "><?= number_format($statistics['sum_turn_over'], 2) ?></span> บาท
      </div>
    </div>

    <div class="col-3 mx-10px">
      <div class="card-header-purple font-SemiBold font-14px ">
        ยอดเงินกดรับแล้ว
      </div>
      <div class="card-white px-15px py-10px font-Medium">
        <span class="font-Bold text-purple font-20px "><?= number_format($statistics['sum_turn_over_received'], 2) ?></span> บาท
      </div>
    </div>

    <div class="col-3 mx-10px">
      <div class="card-header-orange font-SemiBold font-14px ">
        ยอดเงินคงค้าง
      </div>
      <div class="card-white px-15px py-10px font-Medium">
        <span class="font-Bold text-orange font-20px "><?= number_format($statistics['sum_turn_over_outstanding'], 2) ?></span> บาท
      </div>
    </div>
  </div>
</div>

<div class="bg-whites">
  <div id="return_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('return_list', '?c=' . $code . '&user_id=' . $id, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="turn_over_date" data-filter="<?= Homepagify::dataFilter('turn_over_date', 'date') ?>">วัน</th>
            <th nowrap data-sort="sum_loss_amount" data-filter="<?= Homepagify::dataFilter('sum_loss_amount', 'number') ?>">ยอดเสีย</th>
            <th nowrap data-sort="sum_turn_over" data-filter="<?= Homepagify::dataFilter('sum_turn_over', 'number') ?>">จำนวนเงินคืนทั้งหมด</th>
            <th nowrap data-sort="sum_turn_over_received" data-filter="<?= Homepagify::dataFilter('sum_turn_over_received', 'number') ?>">ยอดเงินกดรับแล้ว</th>
            <th nowrap data-sort="sum_turn_over_outstanding" data-filter="<?= Homepagify::dataFilter('sum_turn_over_outstanding', 'number') ?>">จำนวนคงค้าง</th>
            <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะรับเงิน</th>
            <th nowrap></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>