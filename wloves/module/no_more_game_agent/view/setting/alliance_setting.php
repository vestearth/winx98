<?php
if ($_POST) {
  if (isset($_POST['submit_add_alliance'])) {
    unset($_POST['submit_add_alliance']);
    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : '0';
    $line_image = isset($_FILES['line_image']) ? $_FILES['line_image'] : null;
    $data = [
      'name' => $_POST['name'],
      'leader_name' => $_POST['leader_name'],
      'line_name' => $_POST['line_name'],
      'line_link' => $_POST['line_link'],
      'line_image' => $line_image,
      'username' => $_POST['username'],
      'password' => $_POST['password'],
      'alliance_type' => $_POST['alliance_type'],
      'is_active' => $is_active,
    ];
    $result = nga_management::addNewAlliance($_GET['c'], $data);
  } else if (isset($_POST['submit_edit_alliance'])) {
    unset($_POST['submit_edit_alliance']);
    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : '0';
    $line_image = isset($_FILES['line_image']) ? $_FILES['line_image'] : null;
    $data = [
      'name' => $_POST['name'],
      'leader_name' => $_POST['leader_name'],
      'line_name' => $_POST['line_name'],
      'line_link' => $_POST['line_link'],
      'line_image' => $line_image,
      'password' => $_POST['password'],
      'is_active' => $is_active,
      // 'alliance_type' => $_POST['alliance_type'],
    ];
    $result = nga_management::updateAlliance($_GET['c'], $_POST['id'], $data);
  } else if (isset($_POST['submit_delete_alliance'])) {
    $result = nga_management::deleteAllianceByID($_GET['c'], $_POST['id']);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

$table_ally_options = [
  [
    'value' => 'เปิดการใช้งาน',
    'name' => 'เปิดการใช้งาน',
  ],
  [
    'value' => 'ปิดการใช้งาน',
    'name' => 'ปิดการใช้งาน',
  ],
];
$table_alliance_options = [
  [
    'value' => 'monthly',
    'text' => 'แบบรายเดือน',
  ],
  [
    'value' => 'lifetime',
    'text' => 'แบบสะสมระยะยาว',
  ],
];

function messageTemplate($class = '')
{
?>
  <div class="<?= $class ?> mt--10px mb-10px hidden">
    <div class="d-flex align-items-center">
      <?= file_get_contents('assets/image/icon/exclmation_mark.svg') ?>
      <span class="font-13px text-danger ml-5px"></span>
    </div>
  </div>
<?php
}
?>
<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">ตั้งค่าพันธมิตร
    </div>
    <div class="font-15px text-secondary">จัดการข้อมูลพันธมิตร</div>
  </div>
  <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'h-40px'], ['type' => 'button', 'text' => '+ เพิ่มพันธมิตร', 'modal_id' => 'add_data', 'modal_data' => '']); ?>

</div>

<div class="editable-card core-new border-radius-0 mb-50px">

  <div id="alliance_setting" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('alliance_setting', '?c=' . $_GET['c'], '', 'พันธมิตร',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th nowrap data-sort="name" data-filter="<?= Homepagify::dataFilter('name', 'text') ?>">ชื่อ</th>
            <th nowrap data-sort="ref_link">Username</th>
            <!-- <th nowrap data-sort="line_name">รหัสเพิ่มเพื่อนไลน์</th>
            <th nowrap data-sort="line_link">Link สำหรับกดแอดเพื่อนไลน์</th> -->
            <th nowrap data-sort="ref_link">ลิงก์</th>
            <th nowrap data-sort="alliance_type" data-filter="<?= Homepagify::dataFilter('alliance_type', 'select', $table_alliance_options) ?>">ประเภท</th>
            <th nowrap data-sort="category_detail" data-filter="<?= Homepagify::dataFilter('is_active', 'select', $table_ally_options) ?>">สถานะ</th>
            <th nowrap class="thin-cell"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<?php Tiwdal::startModal('add_data', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">เพิ่มพันธมิตร</h5>
</div>
<form method="post" enctype="multipart/form-data" id="form_add_data">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ชื่อพันธมิตร<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ชื่อหัวหน้าพันธมิตร<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => 'leader_name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">รหัสเพิ่มเพื่อนไลน์<br>ที่มี @ นำหน้า<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => 'line_name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">Link สำหรับกด<br>แอดเพื่อนไลน์<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => 'line_link', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">QR สำหรับการเพิ่มเพื่อนไลน์<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9 d-flex align-items-center">
          <?php
          $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
          ];
          TiwForm::normal('upload-img', '', ['name' => 'line_image'], $options);
          ?>
        </div>
        <!-- <div class="col-md-3"></div>
        <div class="col-md-9">
          <div class="d-flex mt-10px">ขนาดรูปภาพที่แนะนำ : สัดส่วน 1340x536 px</div>
        </div> -->
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ประเภทพันธมิตร<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?php
          $alliance_type_options = [
            'list' => [
              [
                'value' => 'monthly',
                'name' => 'แบบรายเดือน',
              ],
              [
                'value' => 'lifetime',
                'name' => 'แบบสะสมระยะยาว',
              ],
            ],
          ];
          ?>
          <?php
          TiwForm::normal('select', '', ['name' => 'alliance_type', 'required' => true], $alliance_type_options);
          ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3">
          <label class="text-secondary font-14px mt-7px font-SemiBold">Username<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => 'username', 'placeholder' => 'Enter', 'required' => 'required', 'class' => 'check_username_event']); ?>
          <?= messageTemplate('msg_username_event'); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3">
          <label class="text-secondary font-14px mt-7px font-SemiBold">
            <?= 'Password'; ?>
            <span class="text-danger">*</span>
          </label>
        </div>
        <div class="col-md-9 mb-10px">
          <?php
          TiwForm::normal('password', '', ['name' => 'password', 'placeholder' => 'Password', 'class' => 'set_check_password event_check_password', 'required' => true]);
          ?>
          <p class="mb-0 event_text_font text-danger">ขั้นต่ำต้องมีอย่างน้อย 8 ตัวอักษร</p>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">สถานะ</label>
        </div>
        <div class="col-md-9 text-primary pt-7px"><?= TiwForm::normal('checkbox', '1', ['name' => 'is_active', 'checked' => true], ['style' => '1', 'label' => 'เปิดใช้งาน', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px btn_add_user_event" name="submit_add_alliance">สร้าง</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>




<?php Tiwdal::startModal('edit_data', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<div class="modal-header">
  <h5 class="modal-title">แก้ไขพันธมิตร</h5>
</div>
<form method="post" id="form_edit_data" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ชื่อ<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => '{name}', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ชื่อหัวหน้าพันธมิตร<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => '{leader_name}', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">รหัสเพิ่มเพื่อนไลน์<br>ที่มี @ นำหน้า<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => '{line_name}', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">Link สำหรับกด<br>แอดเพื่อนไลน์<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => '{line_link}', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">QR สำหรับการเพิ่มเพื่อนไลน์<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9 d-flex align-items-center">
          <?php
          $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
            'preview_name' => '{line_image}',
          ];
          TiwForm::normal('upload-img', '', ['name' => 'line_image'], $options);
          ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ประเภทพันธมิตร</label>
        </div>
        <div class="col-md-9 d-flex align-items-center">
          <div name="{alliance_type}"></div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3">
          <label class="font-SemiBold text-secondary font-14px mt-7px">Username</label>
        </div>
        <div class="col-md-9 d-flex align-items-center">
          <div name="{username}"></div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3">
          <label class="text-secondary font-14px mt-7px font-SemiBold">
            <?= 'Password'; ?>
          </label>
        </div>
        <div class="col-md-9 d-flex align-items-center">
          <!-- ********* -->
          <?php
          TiwForm::normal('text', '', ['name' => 'password', 'placeholder' => 'Password', 'class' => 'event_hide_password', 'required' => true]);
          ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">สถานะ</label>
        </div>
        <div class="col-md-9 text-primary pt-7px"><?= TiwForm::normal('checkbox', '1', ['name' => '{is_active}', 'checked' => true,], ['style' => '1', 'label' => 'เปิดใช้งาน', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>

  </div>
  <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
</form>
<div class="modal-footer justify-content-end">
  <button type="button" class="btn btn-close-modal w-100px" data-dismiss="modal">ยกเลิก</button>
  <button type="submit" name="submit_edit_alliance" form="form_edit_data" class="btn btn-primary w-120px ">บันทึก</button>
</div>
<?php Tiwdal::endModal() ?>


<?php Tiwdal::startModal('delete_data', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<form action="" method="post" id="form_delete_data">
  <div class="modal-body border-radius-10-10-0-0px">
    <div class="form-row align-items-center">
      <div class="col-12 form-group text-center">
        <p class="text-info mb-5px mt-20px font-SemiBold font-16px text-uppercase">ลบพันธมิตร</p>
        <p class="text-info mb-0 font-14px my-20px">คุณต้องการ <span class="text-danger"> “ลบพันธมิตร” </span> ใช่หรือไม่</p>
      </div>
    </div>
  </div>
  <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
</form>
<div class="modal-footer">
  <button type="button" class="btn btn-close-modal w-100px" data-dismiss="modal">Cancel</button>
  <button type="submit" name="submit_delete_alliance" form="form_delete_data" class="btn btn-danger w-120px">DELETE</button>
</div>
<?php Tiwdal::endModal() ?>


<script>
  $(document).ready(function() {
    $(document).on('keyup change', '.event_check_password', function(e) {
      var password = $(this).val();
      let count = password.length;
      if (count > 7) {
        $('.btn_add_user_event').attr('disabled', false);
        $('.event_text_font').removeClass('text-danger');
        $('.event_text_font').addClass('text-success');
      } else {
        $('.btn_add_user_event').attr('disabled', true);
        $('.event_text_font').removeClass('text-success');
        $('.event_text_font').addClass('text-danger');
      }
    });
    $(document).on('focus', '.event_hide_password', function() {
      $(this).prop('type', 'text');
    }).on('blur', '.event_hide_password', function() {
      $(this).prop('type', 'password');
    });
  });
</script>