<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'data_revision_history'];
require_once '../../.framework/import.php';
$code = $_GET['c'];
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 1;
$status_list = [

  [
    'value' => 'success',
    'text' => 'สำเร็จแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ดำเนินการ'
  ],
];

$edit_list = [
  [
    'value' => 'Bud',
    'text' => 'Bud'
  ],
];

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
    <div class="d-flex align-items-center justify-content-between my-5px mx-15px">
      <div class="my-5px">
        <div class="font-16px text-info font-SemiBold">ประวัติการแก้ไขข้อมูลลูกค้า
        </div>
        <div class="font-14px text-secondary font-Regular">รายละเอียดประวัติการแก้ไขข้อมูลลูกค้า</div>
      </div>
    </div>
    <div class=" min-h-10px bg-colorr">

    </div>
    <div class="editable-card core-new border-radius-0 mb-50px">
      <div id="data_revision_history" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('data_revision_history', '?c=' . $_GET['c'] . '&id=' . $id, '', 'ประวัติการแก้ไข',) ?>>
        <div class="table-responsive">
          <table class="table table-sort table-search">
            <thead>
              <tr>
                <th class="" nowrap data-sort="toptic" data-filter="<?= Homepagify::dataFilter('', 'date') ?>">วัน/เวลา</th>
                <th class=" " nowrap data-sort="detail" data-filter="<?= Homepagify::dataFilter('', 'text') ?>">ลูกค้า</th>
                <th class=" " nowrap data-sort="score_use" data-filter="<?= Homepagify::dataFilter('', 'text') ?>">ยูสเซอร์ (agent)</th>
                <th class="" nowrap data-sort="score_use" data-filter="<?= Homepagify::dataFilter('', 'text') ?>">การเปลี่ยนเเปลง</th>
                <th class=" " nowrap data-sort="score_use" data-filter="<?= Homepagify::dataFilter('', 'text') ?>">หมายเหตุ</th>
                <th class="" nowrap data-sort="score_use" data-filter="<?= Homepagify::dataFilter('', 'select', $edit_list) ?>">เเก้ไขโดย</th>
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

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>