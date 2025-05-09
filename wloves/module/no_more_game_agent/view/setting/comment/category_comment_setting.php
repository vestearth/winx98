<?php
if ($_POST) {
  if (isset($_POST['submit_add_category_comment'])) {
    $data = [
      'group_name' => $_POST['group_name'],
      'description' => $_POST['description'],
    ];
    $result = nga_management::addNewCommentGroup($code, $data);
  } else if (isset($_POST['submit_edit_category_comment'])) {
    $data = [
      'group_name' => $_POST['group_name'],
      'description' => $_POST['description'],
    ];

    $result = nga_management::updateCommentGroup($code, $_POST['id'], $data);
  } else if (isset($_POST['submit_delete_category'])) {
    $result = nga_management::deleteCommentGroupByID($code, $_POST['id']);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};
?>
<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">ตั้งค่าความคิดเห็น
    </div>
    <div class="font-15px text-secondary">จัดการหมวดหมู่และแบบฟอร์มความคิดเห็นของลูกค้า</div>
  </div>
  <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'pl-20px pr-20px mr-15px'], ['type' => 'button', 'text' => '+ เพิ่มหมวดหมู่', 'modal_id' => 'add_reward', 'modal_data' => []]); ?>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="category_comment_setting" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('category_comment_setting', '?c=' . $_GET['c'], '', 'หมวดหมู่',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th nowrap data-sort="group_name" data-filter="<?= Homepagify::dataFilter('group_name', 'text') ?>">ชื่อหมวดหมู่</th>
            <th nowrap data-sort="description" data-filter="<?= Homepagify::dataFilter('description', 'text') ?>">คำอธิบาย</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php Tiwdal::startModal('add_reward', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title text-uppercase">เพิ่มหมวดหมู่</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group mt-10px">
      <div class="form-row align-items-center">
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            ชื่อหมวดหมู่<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('text', '', ['name' => 'group_name', 'placeholder' => 'กรอก', 'required' => 'true'], []); ?>
          </div>
        </div>
        <div class="col-lg-3 mt--20px">
          <div class=" font-14px font-Medium mb-10px py-5px">
            คำอธิบาย<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('textarea', '', ['name' => 'description', 'placeholder' => 'กรอก', 'class' => 'min-h-60px', 'required' => 'true'], []); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_add_category_comment', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('edit_reward', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title text-uppercase">แก้ไขหมวดหมู่</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group mt-10px">
      <div class="form-row align-items-center">
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            ชื่อหมวดหมู่<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('text', '', ['name' => '{group_name}', 'placeholder' => 'กรอก', 'required' => true], []); ?>
          </div>
        </div>
        <div class="col-lg-3 mt--20px">
          <div class=" font-14px font-Medium mb-10px py-5px">
            คำอธิบาย
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('textarea', '', ['name' => '{description}', 'placeholder' => 'กรอก', 'class' => 'min-h-60px', 'required' => true], []); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_category_comment', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('delete_reward', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<form method="post">

  <div class="modal-body mt-30px">
    <h3 class="text-center font-16px font-SemiBold text-uppercase">ลบหมวดหมู่</h3>
    <p class="mb-5px text-center">
      คุณต้องการ <span class="text-danger text-uppercase"> “ลบหมวดหมู่”</span> นี้ใช่หรือไม่
    </p>
  </div>
  <div class="modal-footer d-flex justify-content-end">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ยกเลิก</button>
    <button type="submit" class="btn btn-danger w-100px" name="submit_delete_category">ยืนยัน</button>
  </div>
</form>
<?php Tiwdal::endModal() ?>