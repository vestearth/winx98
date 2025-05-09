<?php
if ($_POST) {
  if (isset($_POST['submit_add_reward'])) {
    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : '0';
    $data = [
      'name' => $_POST['name'],
      'description' => $_POST['description'],
      'point_use' => $_POST['point_use'],
      'is_active' => $is_active,
      'start_date' => $_POST['start_date'],
      'end_date' => $_POST['end_date'],
    ];
    $result = nga_management::addNewReward($code, $data, $_FILES['img']);
  } else if (isset($_POST['submit_edit_reward'])) {
    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : '0';
    $data = [
      'name' => $_POST['name'],
      'description' => $_POST['description'],
      'point_use' => $_POST['point_use'],
      'is_active' => $is_active,
      'start_date' => $_POST['start_date'],
      'end_date' => $_POST['end_date'],
    ];

    $result = nga_management::updateReward($code, $_POST['id'], $data, $_FILES['img']);
  } else if (isset($_POST['submit_delete_reward'])) {
    $result = nga_management::deleteRewardByID($code, $_POST['id']);
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
    <div class="font-18px text-info font-SemiBold">จัดการของรางวัล
    </div>
    <div class="font-15px text-secondary">จัดการของรางวัล แต้ม และการใช้งาน</div>
  </div>
  <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'pl-20px pr-20px mr-15px'], ['type' => 'button', 'text' => '+ เพิ่มของรางวัล', 'modal_id' => 'add_reward', 'modal_data' => []]); ?>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="reward_setting" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('reward_setting', '?c=' . $_GET['c'], '', 'ของรางวัล',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th>รูปภาพ</th>
            <th nowrap data-sort="name" data-filter="<?= Homepagify::dataFilter('name', 'text') ?>">หัวข้อ</th>
            <th nowrap data-sort="description" data-filter="<?= Homepagify::dataFilter('description', 'text') ?>">รายละเอียด</th>
            <th class="th-right" nowrap data-sort="point_use" data-filter="<?= Homepagify::dataFilter('point_use', 'text') ?>">แต้มที่ต้องใช้</th>
            <th nowrap data-sort="start_date" data-filter="<?= Homepagify::dataFilter('start_date', 'date') ?>">วันที่เริ่ม</th>
            <th nowrap data-sort="end_date" data-filter="<?= Homepagify::dataFilter('end_date', 'date') ?>">วันที่สิ้นสุด</th>
            <th nowrap data-sort="is_active">สถานะ</th>
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
  <h5 class="modal-title text-uppercase">เพิ่มของรางวัล</h5>
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
            <?php TiwForm::normal('text', '', ['name' => 'name', 'placeholder' => 'กรอก', 'required' => 'true'], []); ?>
          </div>
        </div>
        <div class="col-lg-3 mt--20px">
          <div class=" font-14px font-Medium mb-10px py-5px">
            รายละเอียด<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('textarea', '', ['name' => 'description', 'placeholder' => 'กรอก', 'class' => 'min-h-60px', 'required' => 'true'], []); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            แต้มที่ต้องใช้แลก<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('number', '', ['name' => 'point_use', 'placeholder' => '0', 'required' => 'true'], []); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            ระยะเวลาเริ่ม<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('date', '', ['name' => 'start_date', 'required' => 'true'], []); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            ระยะเวลาสิ้นสุด<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('date', '', ['name' => 'end_date', 'required' => 'true'], []); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            สถานะ
          </div>
        </div>
        <div class="col-lg-9 label-custom">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('checkbox', '1', ['name' => 'is_active', 'checked' => true], ['style' => '1', 'label' => 'เปิดใช้งาน', 'is_on_off' => true]); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            รูปภาพ<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9 label-custom">
          <div class="ml-5px font-16px font-Medium">
            <?php
            $options = [
              'width' => '200px',
              'height' => '100%',
              'bg-img' => 'assets/image/bg_upload.png',
            ];
            TiwForm::normal('upload-img', '', ['name' => 'img', 'required' => true], $options); ?>
          </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-9 mt-5px">
          <p>ไฟล์ .png หรือ .jpg สัดส่วน 1080x1080 px</p>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_add_reward', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('edit_reward', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title text-uppercase">แก้ไขของรางวัล</h5>
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
            <?php TiwForm::normal('text', '', ['name' => '{name}', 'placeholder' => 'กรอก', 'required' => true], []); ?>
          </div>
        </div>
        <div class="col-lg-3 mt--20px">
          <div class=" font-14px font-Medium mb-10px py-5px">
            รายละเอียด<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('textarea', '', ['name' => '{description}', 'placeholder' => 'กรอก', 'class' => 'min-h-60px', 'required' => true], []); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            แต้มที่ต้องใช้แลก<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('number', '', ['name' => '{point_use}', 'placeholder' => '0', 'required' => true], []); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            ระยะเวลาเริ่ม<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('date', '', ['name' => '{start_date}', 'required' => 'true'], []); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            ระยะเวลาสิ้นสุด<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('date', '', ['name' => '{end_date}', 'required' => 'true'], []); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            สถานะ<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9 label-custom">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('checkbox', '1', ['name' => '{is_active}', 'checked' => true], ['style' => '1', 'label' => 'เปิดใช้งาน', 'is_on_off' => true]); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            รูปภาพ<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9 label-custom">
          <div class="ml-5px font-16px font-Medium">
            <?php
            $options_reward = [
              'width' => '200px',
              'height' => '100%',
              'bg-img' => 'assets/image/bg_upload.png',
              'preview_name' => '{reward_img}',
            ];
            TiwForm::normal('upload-img', '', ['name' => 'img'], $options_reward); ?>
          </div>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-9 mt-5px">
          <p>ไฟล์ .png หรือ .jpg 1080x1080 px</p>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_reward', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('delete_reward', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<form method="post">

  <div class="modal-body mt-30px">
    <h3 class="text-center font-16px font-SemiBold text-uppercase">ลบของรางวัล</h3>
    <p class="mb-5px text-center">
      คุณต้องการ <span class="text-danger text-uppercase"> “ลบของรางวัล”</span> นี้ใช่หรือไม่
    </p>
  </div>
  <div class="modal-footer d-flex justify-content-between">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-danger w-100px" name="submit_delete_reward">Delete</button>
  </div>
</form>
<?php Tiwdal::endModal() ?>