<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'vendor_history'];
require_once '../../.framework/import.php';

$code = $_GET['c'];

$type_game = [
  [
    'value' => 'AMBPOKER',
    'text' => 'AMBPOKER'
  ],
  [
    'value' => 'AMBSLOT2',
    'text' => 'AMBSLOT2'
  ],
  [
    'value' => 'PRAGMATIC',
    'text' => 'PRAGMATIC'
  ],
  [
    'value' => 'HABANERO',
    'text' => 'HABANERO'
  ],
  [
    'value' => 'EVOPLAY',
    'text' => 'EVOPLAY'
  ],
  [
    'value' => 'YGGDRASIL',
    'text' => 'YGGDRASIL'
  ],
  [
    'value' => 'SPADE',
    'text' => 'SPADE'
  ],
  [
    'value' => 'PGSOFT2',
    'text' => 'PGSOFT2'
  ],
  [
    'value' => 'MICRO',
    'text' => 'MICRO'
  ],
  [
    'value' => 'JILI',
    'text' => 'JILI'
  ],
  [
    'value' => 'SIMPLEPLAY',
    'text' => 'SIMPLEPLAY'
  ],
  [
    'value' => 'AMEBA',
    'text' => 'AMEBA'
  ],
  [
    'value' => 'ALLBET',
    'text' => 'ALLBET'
  ],
  [
    'value' => 'BETGAME',
    'text' => 'BETGAME'
  ],
  [
    'value' => 'EBET',
    'text' => 'EBET'
  ],
  [
    'value' => 'KINGMAKER2',
    'text' => 'KINGMAKER2'
  ],
  [
    'value' => 'MANNA',
    'text' => 'MANNA'
  ],
  [
    'value' => 'NETENT2',
    'text' => 'NETENT2'
  ],
  [
    'value' => 'UPG',
    'text' => 'UPG'
  ],
  [
    'value' => 'CQ9V2',
    'text' => 'CQ9V2'
  ],
  [
    'value' => 'HOTGRAPH',
    'text' => 'HOTGRAPH'
  ],
  [
    'value' => 'SLOTXO',
    'text' => 'SLOTXO'
  ],
  [
    'value' => 'JOKER',
    'text' => 'JOKER'
  ],
  [
    'value' => 'DREAM2',
    'text' => 'DREAM2'
  ],
  [
    'value' => 'SAGAME',
    'text' => 'SAGAME'
  ],
  [
    'value' => 'AGGAME',
    'text' => 'AGGAME'
  ],
  [
    'value' => 'LIVE22',
    'text' => 'LIVE22'
  ],
  [
    'value' => 'ASKMEBET',
    'text' => 'ASKMEBET'
  ],
  [
    'value' => 'ACE333',
    'text' => 'ACE333'
  ],
  [
    'value' => 'XTREME',
    'text' => 'XTREME'
  ],
  [
    'value' => 'SEXY',
    'text' => 'SEXY'
  ],
  [
    'value' => 'PRETTY',
    'text' => 'PRETTY'
  ],
  [
    'value' => 'FUNKY',
    'text' => 'FUNKY'
  ],
  [
    'value' => 'BIGGAME',
    'text' => 'BIGGAME'
  ],
  [
    'value' => 'WMSLOT',
    'text' => 'WMSLOT'
  ],
  [
    'value' => '918KISS',
    'text' => '918KISS'
  ],
  [
    'value' => 'DRAGONGAMING',
    'text' => 'DRAGONGAMING'
  ],
  [
    'value' => 'NINJA',
    'text' => 'NINJA'
  ],
  [
    'value' => 'SPINIX',
    'text' => 'SPINIX'
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
          สถิติการเล่นเกมแยกรายผู้ให้บริการ </div>
        <div class="font-14px text-sub ml-10px">
          รายละเอียดประวัติสถิติการเล่นเกมแยกรายผู้ให้บริการ
        </div>
      </div>
    </div>

  </div>
  <div id="vendor_history" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('vendor_history', '?c=' . $code, '', 'สถิติการเล่นเกมแยกรายผู้ให้บริการ') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="transaction_date" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วันที่</th>
            <th nowrap data-sort="product_id" data-filter="<?= Homepagify::dataFilter('product_id', 'select', $type_game) ?>">ค่ายเกม</th>
            <th nowrap data-sort="count_game" data-filter="<?= Homepagify::dataFilter('count_game', 'text') ?>">จำนวนเกม</th>
            <th class="th-right" nowrap data-sort="count_user" data-filter="<?= Homepagify::dataFilter('count_user', 'text') ?>">จำนวนผู้เล่นทั้งหมด</th>
            <th nowrap data-sort="sum_win" data-filter="<?= Homepagify::dataFilter('sum_win', 'text') ?>">Win (บาท)</th>
            <th nowrap data-sort="sum_lose" data-filter="<?= Homepagify::dataFilter('sum_lose', 'text') ?>">Loss (บาท)</th>
            <th nowrap>ส่วนต่าง W/L</th>
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