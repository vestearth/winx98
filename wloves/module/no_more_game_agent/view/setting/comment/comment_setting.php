<?php
if ($_POST) {
  if (isset($_POST['submit_add_topic'])) {
    $is_have_rating = isset($_POST['is_have_rating']) ? $_POST['is_have_rating'] : '0';
    $is_have_detail = isset($_POST['is_have_detail']) ? $_POST['is_have_detail'] : '0';
    $is_have_file = isset($_POST['is_have_file']) ? $_POST['is_have_file'] : '0';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $data = [
      'comment_group_id' => $_GET['id'],
      'title_name' => $_POST['title_name'],
      'description' => $description,
      'is_have_rating' => $is_have_rating,
      'is_have_detail' => $is_have_detail,
      'is_have_file' => $is_have_file,
    ];
    $result = nga_management::addNewCommentTitle($code, $data);
  } else if (isset($_POST['submit_edit_topic'])) {
    $is_have_rating = isset($_POST['is_have_rating']) ? $_POST['is_have_rating'] : '0';
    $is_have_detail = isset($_POST['is_have_detail']) ? $_POST['is_have_detail'] : '0';
    $is_have_file = isset($_POST['is_have_file']) ? $_POST['is_have_file'] : '0';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $data = [
      'comment_group_id' => $_GET['id'],
      'title_name' => $_POST['title_name'],
      'description' => $description,
      'is_have_rating' => $is_have_rating,
      'is_have_detail' => $is_have_detail,
      'is_have_file' => $is_have_file,
    ];

    $result = nga_management::updateCommentTitle($code, $_POST['id'], $data);
  } else if (isset($_POST['submit_delete_topic'])) {
    $result = nga_management::deleteCommentTitleByID($code, $_POST['id']);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};

$get_comment_group = nga_management::getCommentGroupByID($code, $_GET['id']);
?>
<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">ตั้งค่าหัวข้อความคิดเห็น | <span class="text-primary font-SemiBold"><?= $get_comment_group['group_name']; ?></span>
    </div>
    <div class="font-15px text-secondary">จัดการหัวข้อความคิดเห็นและแบบฟอร์มความคิดเห็นของลูกค้า</div>
  </div>
  <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'pl-20px pr-20px mr-15px'], ['type' => 'button', 'text' => '+ เพิ่มหัวข้อ', 'modal_id' => 'add_topic', 'modal_data' => []]); ?>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="comment_setting" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('comment_setting', '?c=' . $_GET['c'] . '&comment_group_id=' . $_GET['id'], '', 'หัวข้อความคิดเห็น',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th nowrap data-sort="title_name" data-filter="<?= Homepagify::dataFilter('title_name', 'text') ?>">หัวข้อความคิดเห็น</th>
            <th nowrap data-sort="description" data-filter="<?= Homepagify::dataFilter('description', 'text') ?>">แบบฟอร์ม</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>
<?php Tiwdal::startModal('add_topic', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title text-uppercase">เพิ่มหัวข้อ</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group mt-10px">
      <div class="form-row align-items-center">
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            หัวข้อ<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('text', '', ['name' => 'title_name', 'placeholder' => 'กรอก', 'required' => 'true'], []); ?>
          </div>
        </div>
        <div class="col-lg-3 mt--20px">
          <div class=" font-14px font-Medium mb-10px py-5px">
            รายละเอียดหรือคำแนะนำ
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('textarea', '', ['name' => 'description', 'placeholder' => 'กรอก', 'class' => 'min-h-60px'], []); ?>
          </div>
        </div>
        <div class="col-lg-3 mt--20px">
          <div class=" font-14px font-Medium mb-10px py-5px">
            แบบฟอร์ม
          </div>
        </div>
        <div class="col-lg-9">
          <?php
          TiwForm::normal('checkbox', '1', ['name' => 'is_have_rating'], ['style' => '3', 'label' => 'ให้คะแนนความพึงพอใจ']);
          TiwForm::normal('checkbox', '1', ['name' => 'is_have_detail'], ['style' => '3', 'label' => 'ช่องระบุรายละเอียด']);
          TiwForm::normal('checkbox', '1', ['name' => 'is_have_file'], ['style' => '3', 'label' => 'ไฟล์แนบ (หากมี)']);
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_add_topic', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('edit_reward', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title text-uppercase">แก้ไขหัวข้อ</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group mt-10px">
      <div class="form-row align-items-center">
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            หัวข้อ<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('text', '', ['name' => '{title_name}', 'placeholder' => 'กรอก', 'required' => true], []); ?>
          </div>
        </div>
        <div class="col-lg-3 mt--20px">
          <div class=" font-14px font-Medium mb-10px py-5px">
            รายละเอียดหรือคำแนะนำ
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('textarea', '', ['name' => '{description}', 'placeholder' => 'กรอก', 'class' => 'min-h-60px'], []); ?>
          </div>
        </div>
        <div class="col-lg-3 mt--20px">
          <div class=" font-14px font-Medium mb-10px py-5px">
            แบบฟอร์ม
          </div>
        </div>
        <div class="col-lg-9">
          <?php
          TiwForm::normal('checkbox', '1', ['name' => '{is_have_rating}'], ['style' => '3', 'label' => 'ให้คะแนนความพึงพอใจ']);
          TiwForm::normal('checkbox', '1', ['name' => '{is_have_detail}'], ['style' => '3', 'label' => 'ช่องระบุรายละเอียด']);
          TiwForm::normal('checkbox', '1', ['name' => '{is_have_file}'], ['style' => '3', 'label' => 'ไฟล์แนบ (หากมี)']);
          ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_topic', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('delete_reward', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<form method="post">

  <div class="modal-body mt-30px">
    <h3 class="text-center font-16px font-SemiBold text-uppercase">ลบหัวข้อ</h3>
    <p class="mb-5px text-center">
      คุณต้องการ <span class="text-danger text-uppercase"> “ลบหัวข้อ”</span> นี้ใช่หรือไม่
    </p>
  </div>
  <div class="modal-footer d-flex justify-content-end">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ยกเลิก</button>
    <button type="submit" class="btn btn-danger w-100px" name="submit_delete_topic">ยืนยัน</button>
  </div>
</form>
<?php Tiwdal::endModal() ?>