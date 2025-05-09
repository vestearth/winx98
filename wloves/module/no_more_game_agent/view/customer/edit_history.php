<div class='bg-white mb-1px pb-10px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">

    <div class="msg col-lg-6">
      <div class='topic ml-10px'>
        ประวัติการแก้ไข </div>
      <div class="font-14px text-sub ml-10px">
        จัดการข้อมูลรายละเอียดประวัติการแก้ไข
      </div>
    </div>
  </div>
</div>
<div class="bg-white">
  <div id="edit_history" class="container-pagination bg-white no-header no-border-radius" <?= Homepagify::createHomepagify('edit_history', '?c=' . $code . '&user_id=' . $customer_data['id'], '', '') ?>>
    <div class="table-responsive">
      <table class="table table-search ">
        <thead>
          <tr>
            <th nowrap data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วัน/เวลา</th>
            <th nowrap data-filter="<?= Homepagify::dataFilter('log_text', 'text') ?>">การเปลี่ยนแปลง</th>
            <th nowrap data-filter="<?= Homepagify::dataFilter('admin_username', 'text') ?>">แก้ไขโดย</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>