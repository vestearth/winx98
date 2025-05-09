<?php
$promotion_status_list = [
  [
    'value' => 'confirm',
    'text' => 'ได้รับเครดิตแล้ว'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'ยังไม่ได้รับเครดิต'
  ],
];
?>
<div class='bg-whites mb-1px pb-10px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">
    <div class="msg col-lg-6">
      <div class='topic'>
        ประวัติการรับโปรโมชั่น </div>
      <div class="font-14px text-sub ">
        จัดการข้อมูลรายละเอียดการรับโปรโมชั่น
      </div>
    </div>
  </div>
</div>
<div class="bg-whites">
  <div id="promotion" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('promotion', '?c=' . $code . '&id=' . $id, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วันที่ฝาก</th>
            <th nowrap data-sort="credit_point_receive" data-filter="<?= Homepagify::dataFilter('credit_point_receive', 'number') ?>">จำนวนเงิน</th>
            <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $promotion_status_list) ?>">สถานะ</th>
            <th nowrap data-sort="promotion_name" data-filter="<?= Homepagify::dataFilter('promotion_name', 'text') ?>">โปรโมชั่น</th>
            <!-- <th nowrap>จำนวน</th>
            <th nowrap>เปอร์เซ็น</th>
            <th nowrap class="thin-cell">โบนัส (จำนวน + เปอร์เซ็น)</th> -->
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>