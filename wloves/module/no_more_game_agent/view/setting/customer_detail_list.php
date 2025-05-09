<?php
$get_data = nga_management::getUserGroupByID($code, $id);
?>
<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">รายชื่อลูกค้าในกลุ่ม - <span class="text-primary"><?= $get_data['name'] ?></span>
    </div>
    <div class="font-15px text-secondary">ดูรายชื่อลูกค้าที่อยู่ในกลุ่มนี้</div>
  </div>

</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="customer_info_list" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('customer_info_list', '?c=' . $_GET['c'] . '&user_group_id=' . $_GET['id'], '', 'ลูกค้า',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search aim_lock">
        <thead>
          <tr>
            <th nowrap class="thin-cell" data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วันที่สมัคร</th>
            <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">ID ลูกค้า</th>
            <th nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อบัญชี</th>
            <th nowrap data-sort="bank_number" data-filter="<?= Homepagify::dataFilter('bank_number', 'text') ?>">ธนาคาร</th>
            <th nowrap data-sort="first_time_deposit" data-filter="<?= Homepagify::dataFilter('first_time_deposit', 'text') ?>">ฝากครั้งแแรก</th>
            <th nowrap data-sort="member_code" data-filter="<?= Homepagify::dataFilter('member_code', 'text') ?>">รหัสผู้แนะนำ</th>
            <th nowrap>สร้างสำเร็จ</th>
            <th nowrap></th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>