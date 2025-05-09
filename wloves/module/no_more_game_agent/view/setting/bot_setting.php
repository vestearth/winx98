<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">ตั้งค่า BOT
    </div>
    <div class="font-15px text-secondary">จัดการกลุ่ม BOT, ธนาคาร และการใช้งาน</div>
  </div>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="bot_setting" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('bot_setting', '?c=' . $_GET['c'], '', 'BOT',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th nowrap data-sort="name" data-filter="<?= Homepagify::dataFilter('name', 'text') ?>">ชื่อ BOT</th>
            <th nowrap data-sort="bank" data-filter="<?= Homepagify::dataFilter('bank', 'select', []) ?>">ธนาคาร</th>
            <th nowrap data-sort="usage" data-filter="<?= Homepagify::dataFilter('usage', 'select', []) ?>">การใช้งาน</th>
            <th nowrap data-sort="vpn" data-filter="<?= Homepagify::dataFilter('vpn', 'select', []) ?>">VPN</th>
            <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', []) ?>">สถานะ</th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>