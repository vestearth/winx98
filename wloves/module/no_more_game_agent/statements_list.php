<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'statements_hidden'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$status_list = [
  [
    'value' => 'confirm',
    'text' => 'ได้รับเครดิตแล้ว'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'กำลังโอนเงิน'
  ],
];

$transection_type_list = [
  [
    'value' => 'withdraw',
    'text' => 'รายการถอน'
  ],
  [
    'value' => 'deposit',
    'text' => ' รายการฝาก'
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

  <div class='bg-white mb-15px pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">
      <div class="msg col-lg-6">
        <div class='topic ml-10px'>
          Statements </div>
        <div class="font-14px text-sub ml-10px">
          รายการประวัติการเงิน
        </div>
      </div>
    </div>
  </div>
  <div class="bg-white">
    <div id="statements_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('statements_list', '?c=' . $code, '', 'ประวัติการเงิน') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>" class="thin-cell">วัน/เวลา</th>
              <th nowrap data-sort="transaction_amount" data-filter="<?= Homepagify::dataFilter('transaction_amount', 'number') ?>">ยอดเงิน</th>
              <th nowrap>รายละเอียดบัญชี</th>
              <th nowrap data-sort="customer_bank_name" data-filter="<?= Homepagify::dataFilter('customer_bank_name', 'text') ?>">ธนาคาร</th>
              <th nowrap data-sort="transaction" data-filter="<?= Homepagify::dataFilter('transaction', 'select', $transection_type_list) ?>">ประเภทรายการ</th>
              <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

  <?php Tiwdal::ajaxModal('statement_detail', 'modal-md'); ?>
</body>

</html>
<?php Aww::loadAsset('assets/js/force_logout.js'); ?>