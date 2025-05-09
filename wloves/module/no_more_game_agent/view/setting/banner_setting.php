<?php
if ($_POST) {
  if (isset($_POST['submit_add_banner'])) {
    $data = [
      'banner_name' => $_POST['name']
    ];
    $result = nga_management::addNewBanner($code, $data, $_FILES['img_landing']);
  } else if (isset($_POST['submit_delete_banner'])) {
    $result = nga_management::deleteBannerByID($code, $_POST['id']);
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
    <div class="font-18px text-info font-SemiBold">จัดการภาพ Banner
    </div>
    <div class="font-15px text-secondary">จัดการภาพ (Banner) ที่จะแสดงเมื่อลูกค้าเข้ามายังหน้าเว็บไซต์</div>
  </div>
  <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'h-40px'], ['type' => 'button', 'text' => '+ เพิ่มภาพ', 'modal_id' => 'add_data', 'modal_data' => []]); ?>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="banner_setting" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('banner_setting', '?c=' . $_GET['c'], '', 'ภาพ Banner',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th nowrap class="thin-cell">รูปภาพ</th>
            <th nowrap data-sort="name" data-filter="<?= Homepagify::dataFilter('name', 'text') ?>">ชื่อภาพ</th>
            <th nowrap class="thin-cell" data-sort="upload_date" data-filter="<?= Homepagify::dataFilter('upload_date', 'date') ?>">วันที่อัพโหลด</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>
<?php Tiwdal::startModal('delete_banner', 'modal-md'); ?>
<form method="post">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-body mt-30px">
    <h3 class="text-center font-16px font-SemiBold text-uppercase">ลบภาพ Banner</h3>
    <p class="mb-5px text-center">
      คุณต้องการ <span class="text-danger text-uppercase"> “ลบภาพ Banner”</span> นี้ใช่หรือไม่
    </p>
  </div>
  <div class="modal-footer d-flex justify-content-between">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-danger w-100px" name="submit_delete_banner">Delete</button>
  </div>
</form>
<?php Tiwdal::endModal(); ?>


<?php Tiwdal::startModal('add_data', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">เพิ่มภาพ Banner</h5>
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
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ภาพ<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-9 d-flex align-items-center">
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
          <div class="d-flex mt-10px">ขนาดรูปภาพที่แนะนำ : สัดส่วน 1340x536 px</div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_add_banner">บันทึก</button>
    </div>
</form>
<?php Tiwdal::endModal(); ?>