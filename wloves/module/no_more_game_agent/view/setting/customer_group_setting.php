<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">จัดการกลุ่มลูกค้า
    </div>
    <div class="font-15px text-secondary">จัดการกลุ่มลูกค้าเพื่อใช้จัดกลุ่มลูกค้าภายในระบบ</div>
  </div>
  <?php /* 
  <a href="system_database.php<?= $link ?>&page=2&is_add=1" class="btn btn-primary pl-20px pr-20px mr-15px">+ เพิ่มกลุ่มลูกค้า</a>
  */ ?>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="customer_group" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('customer_group', '?c=' . $_GET['c'], '', 'กลุ่มลูกค้า',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th>ไอคอน</th>
            <th nowrap data-sort="name" data-filter="<?= Homepagify::dataFilter('name', 'text') ?>">ชื่อกลุ่ม</th>
            <th nowrap data-sort="deposit_time" data-filter="<?= Homepagify::dataFilter('deposit_time', 'text') ?>">ครั้งที่ฝาก</th>
            <th nowrap data-sort="sum_deposit" data-filter="<?= Homepagify::dataFilter('sum_deposit', 'text') ?>">ยอดฝากทั้งหมด</th>
            <th nowrap data-sort="deposit_bot_name" data-filter="<?= Homepagify::dataFilter('deposit_bot_name', 'text') ?>">ธนาคารฝาก</th>
            <th nowrap data-sort="withdraw_bot_name" data-filter="<?= Homepagify::dataFilter('withdraw_bot_name', 'text') ?>">ธนาคารถอน</th>
            <th nowrap data-sort="amount_customer" data-filter="<?= Homepagify::dataFilter('', 'text') ?>">จำนวนลูกค้า</th>
            <th class="thin-cell">เลื่อนกลุ่มอัตโนมัติ</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>