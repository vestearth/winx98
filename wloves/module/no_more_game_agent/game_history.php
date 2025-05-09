<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'game_history'];
require_once '../../.framework/import.php';

$code = $_GET['c'];

$type_game = [
  [
    'value' => 'CARD',
    'text' => 'เปิดไพ่'
  ],
  [
    'value' => 'BOARD',
    'text' => 'บอร์ดเกม'
  ],
  [
    'value' => 'SLOT',
    'text' => 'สล็อตเสี่ยงโชค'
  ],
  [
    'value' => 'ARCADE',
    'text' => 'ตู้เกม Arcade'
  ],
  [
    'value' => 'CASINOLIVE',
    'text' => 'คาสิโน'
  ],
  [
    'value' => 'FISHING',
    'text' => 'เกมตกปลา'
  ],
  [
    'value' => 'SPORT',
    'text' => 'เกมกีฬา'
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

  <div class=' bg-card mb-10px pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">

      <div class="msg col-lg-6">
        <div class='topic ml-10px'>
          ประวัติการเล่นเกม </div>
        <div class="font-14px text-sub ml-10px">
          รายละเอียดประวัติการเล่นเกม
        </div>
      </div>
    </div>

  </div>
  <div id="game_history" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('game_history', '?c=' . $code, '', 'ประวัติการเล่นเกม') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="transaction_date" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วันที่</th>
            <th nowrap data-sort="game_type" data-filter="<?= Homepagify::dataFilter('game_type', 'select', $type_game) ?>">ประเภทเกม</th>
            <th nowrap data-sort="game_name" data-filter="<?= Homepagify::dataFilter('game_name', 'text') ?>">ชื่อเกม</th>
            <th class="th-right" nowrap data-sort="count_user" data-filter="<?= Homepagify::dataFilter('count_user', 'text') ?>">จำนวนผู้เล่นทั้งหมด</th>
            <th nowrap data-sort="sum_win" data-filter="<?= Homepagify::dataFilter('sum_win', 'text') ?>">Win (บาท)</th>
            <th nowrap data-sort="sum_lose" data-filter="<?= Homepagify::dataFilter('sum_lose', 'text') ?>">Loss (บาท)</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

  </div>
</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>