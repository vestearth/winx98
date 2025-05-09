<div class='bg-whites mb-1px pb-10px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">

    <div class="msg col-lg-6">
      <div class='topic'>
        วงล้อ / เปิดไพ่ / สะสมแต้ม </div>
      <div class="font-14px text-sub ">
        จัดการข้อมูลรายละเอียดวงล้อ / เปิดไพ่ / สะสมแต้ม
      </div>
    </div>
    <div class="col-lg-6">
      <!-- <div class="d-flex justify-content-end">
        <button type="button" class="m-5px btn btn-success w-120px" <?= Tiwdal::register('add_point_game'); ?>>
          เพิ่ม Point (สำหรับทดสอบ)
        </button>
      </div> -->
    </div>
  </div>
</div>
<div class="bg-whites form-row px-15px ">
  <!-- วงล้อนำโชค -->
  <div class="col-lg-4 my-10px">
    <div class="card-header-primary font-SemiBold font-18px">
      สล็อตเสี่ยงโชค
    </div>
    <div id="customer_slot_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('customer_slot_list', '?c=' . $code . '&id=' . $id, '', 'รายการ') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="insert_date_time">วันที่</th>
              <th nowrap>รายละเอียด
              </th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <!-- เปิดไพ่ -->
  <div class="col-lg-4 my-10px">
    <div class="card-header-primary font-SemiBold font-18px">
      เปิดไพ่
    </div>
    <div id="customer_card_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('customer_card_list', '?c=' . $code . '&id=' . $id, '', 'รายการ') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="insert_date_time">วันที่</th>
              <th nowrap>รายละเอียด
              </th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <!-- แต้มสะสม -->
  <div class="col-lg-4 my-10px">
    <div class="card-header-primary font-SemiBold font-18px d-flex justify-content-between">
      <div>
        <?= isset($customer_data['point_balance']) ? 'แต้มสะสม' : ''; ?>
        <span class="text-primary">
          <?= isset($customer_data['point_balance']) ? number_format($customer_data['point_balance'], 2) : ''; ?>
        </span>
        แต้ม
      </div>
    </div>
    <div id="customer_point_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('customer_point_list', '?c=' . $code . '&id=' . $id, '', 'รายการ') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="insert_date_time">วันที่</th>
              <th nowrap>รายละเอียด
              </th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<?php Tiwdal::startModal('history', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title font-SemiBold font-16px">ประวัติการแลกของรางวัล</h5>
  </div>
  <div class="modal-body px-0 pt-0">
    <table class="table p-100 table-in-card table-striped-1">
      <thead class="table-strip">
        <tr>
          <th class="col-4">วันที่</th>
          <th class="col-8">รายละเอียด</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>14/06/2022 10:52</td>
          <td>คุณได้รับ ทอง <span class="text-primary">1</span> สลึง</td>
        </tr>
        <tr>
          <td>14/06/2022 10:52</td>
          <td>คุณได้รับ <span class="text-primary">10</span> เครดิต</td>
        </tr>
        <tr>
          <td>14/06/2022 10:52</td>
          <td>คุณได้รับ <span class="text-primary">50</span> เครดิต</td>
        </tr>
        <tr>
          <td>14/06/2022 10:52</td>
          <td>คุณได้รับ <span class="text-primary">100</span> เครดิต</td>
        </tr>
      </tbody>
    </table>

  </div>
</div>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('add_point_game', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">เพิ่ม Point</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-4 my-auto pb-10px">
          Point
        </div>
        <div class="col-lg-8  pb-10px">
          <div class="form-row">
            <div class="col-5">
              <?php TiwForm::normal('number', '', ['name' => 'point_amount', 'class' => '', 'placeholder' => '0']); ?>
            </div>
            <div class="col-2 my-auto">
              Point
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_add_point_game', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>