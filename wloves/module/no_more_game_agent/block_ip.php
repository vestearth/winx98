<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'block_ip'];
require_once '../../.framework/import.php';
$code = $_GET['c'];
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 1;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('../../');
  Aww::loadAsset('assets/css/no_more_gaming.css');
  ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php include_once '../../structure/layout/header-default.php'; ?>
  <div class="bg-white">
    <div class="d-flex align-items-center justify-content-between pt-10px mb-10px mx-15px">
      <div>
        <div class="font-16px text-info font-SemiBold">Block IP
        </div>
        <div class="font-14px text-secondary font-Regular">สร้างรายการ Block IP</div>
      </div>
      <div>
        <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'pl-20px pr-20px mr-15px'], ['type' => 'button', 'text' => '+ เพิ่ม BLOCK IP', 'modal_id' => 'add_block_ip', 'modal_data' => []]); ?>
      </div>
    </div>
    <div class=" min-h-10px bg-colorr">

    </div>
    <div class="editable-card core-new border-radius-0 mb-50px">
      <div id="block_ip" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('block_ip', '?c=' . $_GET['c'] . '&id=' . $id, '', 'รายการ Block IP',) ?>>
        <div class="table-responsive">
          <table class="table table-sort table-search">
            <thead>
              <tr>
                <th class=" thin-cell" nowrap data-sort="toptic" data-filter="<?= Homepagify::dataFilter('', 'date') ?>">วัน/เวลา</th>
                <th class=" thin-cell min-w-250px" nowrap data-filter="<?= Homepagify::dataFilter('', 'text') ?>">IP Address</th>
                <th class=" ">คำอธิบาย</th>
                <th class="" nowrap style="width: 100px">สร้างโดย</th>
                <th class=" thin-cell"></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>

<?php Tiwdal::startModal('add_block_ip', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<form action="" method="post" id="add_block_ip">
  <div class="modal-body border-radius-10-10-0-0px">
    <div class=" font-16px font-SemiBold mt-5px">
      <div>
        เพิ่ม Block IP
      </div>
    </div>
    <hr class=" mx--15px">
    <div class="form-group">
      <div class="form-row">
        <div class="col-lg-3 py-5px font-14px font-Medium mt-2px">
          IPS
        </div>
        <div class="col-lg-9">
          <?= TiwForm::normal('textarea', '', ['name' => '', 'placeholder' => 'ตัวอย่าง 154.150.4.176 , 22.199.8.91 , 59.6.33.110 , 
88.81.18.235 , 30.130.104.251', 'class' => 'mb-0 min-h-70px'], []); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-lg-3 py-5px font-14px font-Medium mt-2px">
          คำอธิบาย
        </div>
        <div class="col-lg-9">
          <?= TiwForm::normal('textarea', '', ['name' => '', 'placeholder' => 'กรอก', 'class' => 'mb-0 min-h-70px'], []); ?>
        </div>
      </div>
    </div>
  </div>
</form>
<div class="modal-footer d-flex justify-content-end">
  <button type="button" class="btn btn-close-modal w-100px" data-dismiss="modal">ยกเลิก</button>
  <button type="submit" name="submit_add_block_ip" form="add_block_ip" class="btn btn-primary w-120px">เพิ่ม</button>
</div>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('unblock_ip', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<form action="" method="post" id="unblock_ip">
  <div class="modal-body border-radius-10-10-0-0px">
    <div class="form-row align-items-center">
      <div class="col-12 form-group text-center">
        <p class="text-info mb-5px mt-20px font-SemiBold font-16px text-uppercase">ปลด Block IP</p>
        <p class="text-info mb-0 font-14px">คุณต้องการ <span class="text-danger">“ปลด Block IP”</span> ใช่หรือไม่</p>
      </div>
    </div>
  </div>
</form>
<div class="modal-footer d-flex justify-content-end">
  <button type="button" class="btn btn-close-modal w-100px" data-dismiss="modal">ยกเลิก</button>
  <button type="submit" name="submit_unblock_ip" form="unblock_ip" class="btn btn-danger w-120px">ยืนยัน</button>
</div>
<?php Tiwdal::endModal() ?>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>