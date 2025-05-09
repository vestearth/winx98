<?php
if ($_POST) {
  if (isset($_POST['submit_add_data'])) {
    $user_group_temp = [];
    foreach ($select_user_group as $key => $value) {
      $user_group_temp[$key] = [
        'user_group_id' => $value['id'],
        'is_active' => (in_array($value['id'], $_POST['user_group_promotion'])) ? 1 : 0
      ];
    }
    $data = [
      'name' => $_POST['name'],
      'type' => $_POST['type_landing'],
      'button_link' => $_POST['button_link'],
      'button_name' => $_POST['button_name'],
      'description' => $_POST['text_landing'],
      'landing_page_user_group' => $user_group_temp,
    ];
    $result = nga_management::addNewLandingPage($code, $data, $_FILES['img_landing']);
  } else if (isset($_POST['submit_delete_landing'])) {
    $result = nga_management::deleteLandingPageByID($code, $_POST['id']);
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
    <div class="font-18px text-info font-SemiBold">จัดการภาพ Landing page
    </div>
    <div class="font-15px text-secondary">จัดการภาพที่จะแสดงเมื่อลูกค้าเข้ามายังหน้าเว็บไซต์</div>
  </div>
  <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'h-40px'], ['type' => 'button', 'text' => '+ เพิ่มภาพ', 'modal_id' => 'add_data', 'modal_data' => []]); ?>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="landing_setting" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('landing_setting', '?c=' . $_GET['c'], '', 'ภาพ Landing page',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th nowrap class="thin-cell">รูปภาพ</th>
            <th nowrap data-sort="name" data-filter="<?= Homepagify::dataFilter('name', 'text') ?>">ชื่อภาพ</th>
            <th data-sort="name" data-filter="<?= Homepagify::dataFilter('description', 'text') ?>">ข้อความ</th>
            <th>กลุ่มลูกค้า</th>
            <th nowrap class="thin-cell" data-sort="upload_date" data-filter="<?= Homepagify::dataFilter('upload_date', 'date') ?>">วันที่อัพโหลด</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>
<?php Tiwdal::startModal('delete_landing', 'modal-md'); ?>
<form method="post">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-body mt-30px">
    <h3 class="text-center font-16px font-SemiBold text-uppercase">ลบภาพ Landing page</h3>
    <p class="mb-5px text-center">
      คุณต้องการ <span class="text-danger text-uppercase"> “ลบภาพ Landing page”</span> นี้ใช่หรือไม่
    </p>
  </div>
  <div class="modal-footer d-flex justify-content-between">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-danger w-100px" name="submit_delete_landing">Delete</button>
  </div>
</form>
<?php Tiwdal::endModal(); ?>


<?php Tiwdal::startModal('add_data', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">เพิ่มภาพ LANDING PAGE</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ชื่อภาพ<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3">
          <label class="font-15px font-SemiBold">
            รูปแบบ<span class="text-danger">*</span>
          </label>
        </div>
        <div class="col-md-9">
          <div class="d-flex">
            <?php
            TiwForm::normal('radio', 'picture', ['name' => 'type_landing', 'checked' => 'true', 'class' => 'event_type_landing'], ['style' => '2', 'label' => 'รูปภาพ']);
            ?>
            <?php
            TiwForm::normal('radio', 'text', ['name' => 'type_landing', 'class' => 'event_type_landing ml-15px'], ['style' => '2', 'label' => 'ข้อความ']);
            ?>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group mt-10px scope_image_upload">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ภาพ<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9 d-flex align-items-center w-100">
          <?php
          $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
          ];
          TiwForm::normal('upload-img', '', ['name' => 'img_landing', 'required' => true], $options);
          ?>
        </div>
        <div class="col-md-3"></div>
        <div class="col-md-9">
          <p>ไฟล์ .png หรือ .jpg สัดส่วน 1120x600 px</p>
        </div>
      </div>
    </div>
    <div class="form-group scope_text_box pb-10px">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ข้อความ<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('textarea', '', ['name' => 'text_landing', 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-row my-15px scope_row_group_user">
      <div class="col-lg-3">
        <label class="font-15px font-SemiBold">
          กลุ่มลูกค้า
        </label>
      </div>
      <div class="col-lg-9 d-flex mt--7px">
        <div class="row w-100 pos-rel">
          <div class="user-group-screen d-none"></div>
          <div class="col-4 pl-5px font-14px font-Medium d-flex align-items-center">
            <div class=" mt-3px mr-5px">
              <?= TiwForm::normal('checkbox', '', ['name' => 'event_check_all', 'checked' => false, 'class' => 'event_check_all'], ['style' => '3', 'label' => 'ทั้งหมด']); ?>
            </div>
          </div>
          <?php foreach ($select_user_group as $value) { ?>
            <div class="col-4 pl-5px font-14px font-Medium d-flex align-items-center">
              <div class=" mt-3px mr-5px">
                <?= TiwForm::normal('checkbox', $value['id'], ['name' => 'user_group_promotion[]', 'checked' => false, 'class' => 'scope_user_group_check'], ['style' => '3', 'label' => $value['name']]); ?>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ชื่อปุ่ม</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => 'button_name', 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ลิงก์ปุ่ม</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => 'button_link', 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_add_data">บันทึก</button>
    </div>
</form>
<?php Tiwdal::endModal(); ?>

<script>
  $(document).ready(function() {
    $('.scope_text_box').hide();
    $(document).on('change', '.event_type_landing input', function() {
      if ($(this).val() == 'text') {
        $('.scope_image_upload').hide();
        $('.scope_text_box').show();
        $('.scope_text_box textarea').attr('required', true);
        $('.scope_image_upload input').attr('required', false);
      } else if ($(this).val() == 'picture') {
        $('.scope_text_box').hide();
        $('.scope_image_upload').show();
        $('.scope_text_box textarea').attr('required', false);
        $('.scope_image_upload input').attr('required', true);
      }
    });

    $(document).on('change', 'input[name="event_check_all"]', function() {
      if ($(this).prop("checked") == true) {
        $('.scope_user_group_check').find('input').prop('checked', true);
      } else if ($(this).prop("checked") == false) {
        $('.scope_user_group_check').find('input').prop('checked', false);
      }
    });

    $(document).on('change', 'input[name="user_group_promotion[]"]', function() {
      $('.user-group-screen').removeClass('d-none');
      var scope = $(this).parents('.modal');
      var count = scope.find('input[name="user_group_promotion[]"]').length;
      var i = 0;
      $('input[name="user_group_promotion[]"]').each(function(index) {
        if ($(this).prop("checked") == true) {
          i += 1;
        }
      });
      if (i == count) {
        $('input[name="event_check_all"]').prop('checked', true);
      } else {
        $('input[name="event_check_all"]').prop('checked', false);
      }
      setTimeout(() => {
        $('.user-group-screen').addClass('d-none');
      }, 500);
    });
  });
</script>