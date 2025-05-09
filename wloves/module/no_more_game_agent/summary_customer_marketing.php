<?php
$_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'summary_customer_marketing'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$id = (isset($_GET['alliance']) && $_GET['alliance']) ? $_GET['alliance'] : null;
$amount = (isset($_GET['amount']) && $_GET['amount']) ? $_GET['amount'] : 1;
$total_cash = (isset($_GET['total_cash']) && $_GET['total_cash']) ? $_GET['total_cash'] : 1;
$start_date = (isset($_GET['start_date']) && $_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-7 days'));
$end_date = (isset($_GET['end_date']) && $_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
$status_list = [
  [
    'value' => '1',
    'text' => 'Active'
  ],
  [
    'value' => '0',
    'text' => 'Non Active'
  ],
];

$current_user = User::getCurrent();
if ($current_user['user_type_id'] == 3) {
  $ally_fixed = nga_management::getAllianceByUserID($code, $current_user['id']);
}
$data_list = nga_management::selectStatisticsAllianceCustomer($code, $start_date, $end_date, $amount, $total_cash);
$alliance_name = isset($data_list['alliance_name']) ? $data_list['alliance_name'] : [];
$list = isset($data_list['list']) ? $data_list['list'] : [];

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

  <div class='bg-whites pb-10px mb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px px-15px">
      <div class="msg ">
        <div class='topic'>สรุปพันธมิตรหาลูกค้า</div>
        <div class="font-14px text-sub">
          ข้อมูลสรุปพันธมิตรหาลูกค้า
        </div>
      </div>
    </div>
  </div>
  <div class="bg-whites pt-15px">
    <form method="get">
      <?= TiwForm::normal('hidden', $code, ['name' => 'c']); ?>
      <div class="form-row px-15px ">
        <div class="col-lg col-md-6">
          <label class="font-Bold">วันที่เริ่ม</label>
          <?= TiwForm::normal('date', $start_date, ['name' => 'start_date'], []); ?>
        </div>
        <div class="col-lg col-md-6">
          <label class="font-Bold">วันที่สิ้นสุด</label>
          <?= TiwForm::normal('date', $end_date, ['name' => 'end_date'], []); ?>
        </div>
        <div class="col-lg col-md-6">
          <label class="font-Bold">จำนวนครั้งที่ฝาก</label>
          <?= TiwForm::normal('number', $amount, ['name' => 'amount', 'min' => 1, 'disabled' => true], []); ?>
        </div>
        <div class="col-lg col-md-6">
          <label class="font-Bold">ฝากเงินทั้งหมด (มากกว่าหรือเท่ากับ)</label>
          <?= TiwForm::normal('number', $total_cash, ['name' => 'total_cash', 'min' => 1, 'disabled' => true], []); ?>
        </div>
        <div class="col-lg d-flex align-items-center">
          <?= TiwForm::normal('btn', '', ['name' => 'submit_report', 'type' => 'submit', 'class' => 'mt-10px'], ['text' => 'ค้นหา', 'type' => '']); ?>
        </div>
      </div>
    </form>
  </div>

  <div class="bg-white mt-10px">
    <div class="table-responsive">
      <table class="table mb-0 table-striped">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap>วันที่</th>
              <?php
              if ($current_user['user_type_id'] != 3) {
                foreach ($alliance_name as $marketing_ally) { ?>
                  <th nowrap><?= $marketing_ally; ?></th>
                  <?php }
              } else {
                foreach ($alliance_name as $marketing_ally) {
                  if ($marketing_ally == $ally_fixed['name']) {
                  ?>
                    <th nowrap><?= $marketing_ally; ?></th>
              <?php }
                }
              } ?>
              <th nowrap>ชวนเพื่อน</th>
              <th nowrap>ไม่ตรงเงื่อนไข</th>
              <th nowrap class="text-primary">รวมทั้งหมด</th>
            </tr>
          </thead>
          <tbody>
            <?php
            foreach ($list as $key => $market_data) {
              if ($market_data['date'] != 'sum') {
            ?>
                <tr class="">
                  <div>
                    <td nowrap>
                      <?= Aww::formatDate($market_data['date'], 'd/m/Y'); ?>
                  </div>
                  </td>
                  <?php
                  if ($current_user['user_type_id'] != 3) {
                    foreach ($alliance_name as $name_list) {  ?>
                      <td nowrap>
                        <div><?= $market_data[$name_list]; ?></div>
                      </td>
                      <?php }
                  } else {
                    foreach ($alliance_name as $name_list) {
                      if ($name_list == $ally_fixed['name']) {
                      ?>
                        <td nowrap>
                          <div><?= $market_data[$name_list]; ?></div>
                        </td>
                  <?php }
                    }
                  }
                  ?>
                  <td nowrap><?= number_format($market_data['invite_friend'], 0); ?></td>
                  <td nowrap><?= number_format($market_data['not_in_condidtion'], 0); ?></td>
                  <td nowrap class="thin-cell"><?= number_format($market_data['sum_user'], 0); ?></td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td class="font-SemiBold text-primary">รวมทั้งหมด</td>
                  <?php
                  if ($current_user['user_type_id'] != 3) {
                    foreach ($alliance_name as $name_list) {  ?>
                      <td nowrap class="font-SemiBold text-primary">
                        <div><?= $market_data[$name_list]; ?></div>
                      </td>
                      <?php }
                  } else {
                    foreach ($alliance_name as $name_list) {
                      if ($name_list == $ally_fixed['name']) {
                      ?>
                        <td nowrap class="font-SemiBold text-primary">
                          <div><?= $market_data[$name_list]; ?></div>
                        </td>
                  <?php }
                    }
                  }
                  ?>
                  <td nowrap class="font-SemiBold text-primary"><?= number_format($market_data['invite_friend'], 0); ?></td>
                  <td nowrap class="font-SemiBold text-primary"><?= number_format($market_data['not_in_condidtion'], 0); ?></td>
                  <td nowrap class="font-SemiBold text-primary thin-cell"><?= number_format($market_data['sum_user'], 0); ?></td>
                </tr>
            <?php }
            } ?>
          </tbody>
        </table>
      </table>
    </div>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>


</body>

</html>
<?php Aww::loadAsset('assets/js/force_logout.js'); ?>