<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'transaction_date' => $_POST['transaction_date'],
];


$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  // 'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : ['bet_date_time' => 'DESC']
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$key_bet_type = [
  '1' => 'Handicap',
  '2' => 'Odd/Even',
  '3' => 'Over/Under',
  '4' => 'Correct Score',
  '5' => '1x2',
  '6' => 'Total Goal',
  '7' => 'First Half Hdp',
  '8' => 'First Half 1x2',
  '9' => 'First Half O/U',
  '10' => 'HT/FT',
  '11' => 'Money Line',
  '12' => 'First Half O/E',
  '13' => 'First Goal/Last Goal',
  '14' => 'First Half CS',
  '15' => 'Double Chance',
  '16' => 'Live Score',
  '17' => 'First Half Live Score',
  '39' => 'Outright',
  '40' => 'Mix Parley',
];

$key_status = [
  'waiting' => 'รอดำเนินการ',
  'running' => 'กำลังดำเนินการ',
  'rejected' => 'บิลถูกปฏิเสธ',
  'cancelled' => 'ยกเลิก',
  'done' => 'รายการเสร็จสิ้น',
];

$key_result = [
  'win' => 'ชนะ',
  'half_win' => 'ชนะครึ่งเดียว',
  'draw ' => 'เสมอ',
  'half_lose' => 'แพ้ครึ่งเดียว',
  'lose' => 'แพ้',
];

$arr_options = [
  'home' => 'ทีมเหย้า',
  'away' => 'ทีมเยือน',
  'over' => 'สูง',
  'under' => 'ต่ำ',
  'draw' => 'เสมอ',
  'odd' => 'คี่',
  'even' => 'คู่',
];

$data_list = nga_api_seamless_sbobet::selectBetSbobetHistory($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($list as $data_history) { ?>
    <tr>
      <td nowrap class="thin-cell font-SemiBold"><?= Aww::formatDate($data_history['transaction_date_time'], 'd/m/Y'); ?></td>
      <td nowrap class="thin-cell"><?= Aww::formatDate($data_history['transaction_date_time'], 'H:i'); ?></td>
      <td nowrap><?= $data_history['username']; ?></td>
      <td nowrap><?= 'SBOBET' ?></td>
      <td nowrap><?= $data_history['round_id'] ?></td>
      <td nowrap><?= number_format($data_history['amount'], 2) ?></td>
      <td nowrap class="thin-cell font-SemiBold">
        <?php if ($data_history['result']) { ?>
          <?php if ($data_history['result'] == 'win') { ?>
            <div class="min-w-300px text-success">
              +<?= number_format($data_history['money_diff'], 2) ?>
            </div>
          <?php } else if ($data_history['result'] == 'lose') { ?>
            <div class="min-w-300px text-danger">
              -<?= number_format($data_history['money_diff'], 2) ?>
            </div>
          <?php } else { ?>
            <div class="min-w-300px text-secondary">
              <?= number_format($data_history['money_diff'], 2) ?>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="min-w-300px text-secondary">
            <?= '-' ?>
          </div>
        <?php } ?>
      </td>
      <td>
        <?php
        if ($data_history['result']) {
          echo '<div class="min-w-300px text-info">
        ออกผล
      </div>';
        } else {
          echo  '<div class="min-w-300px text-secondary">
        รอผล
      </div>';
        }
        ?>
      </td>
      <td nowrap>
        <form method="post">
          <input type="hidden" name="id_sbo" value="<?= $data_history['id'] ?>">
          <input type="hidden" name="user_id" value="<?= $data_history['user_id'] ?>">
          <button type="submit" name="submit_detail_sbo" class="btn btn-primary btn-sm">ดูรายละเอียด</button>
        </form>
      </td>
    </tr>
  <?php } ?>
</tbody>