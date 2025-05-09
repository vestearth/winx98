<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'game_history'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'transaction_date' => $_POST['transaction_date'],
  'game_type' => $_POST['game_type'],
  'game_name' => $_POST['game_name'],
  'count_user' => $_POST['count_user'],
  'sum_win' => $_POST['sum_win'],
  'sum_lose' => $_POST['sum_lose'],
];
if ($_POST['game_type'] == 'all') {
  unset($where['game_type']);
}
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['transaction_date' => 'DESC']
];
$data_list = nga_statement::selectBetHistoryStatistics($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php
  foreach ($list as $history_stat) {
    if ($history_stat['game_type'] == 'CARD') {
      $game_type = 'เปิดไพ่';
    } else if ($history_stat['game_type'] == 'SLOT') {
      $game_type = 'สล็อตเสี่ยงโชค';
    } else if ($history_stat['game_type'] == 'ARCADE') {
      $game_type = 'ตู้เกม Arcade';
    } else if ($history_stat['game_type'] == 'BOARD') {
      $game_type = 'บอร์ดเกม';
    } else if ($history_stat['game_type'] == 'FISHING') {
      $game_type = 'เกมตกปลา';
    } else if ($history_stat['game_type'] == 'CASINOLIVE') {
      $game_type = 'คาสิโน';
    } else if ($history_stat['game_type'] == 'SPORT') {
      $game_type = 'กีฬา';
    } else {
      $game_type = 'ไม่ระบุ';
    }
  ?>
    <tr>
      <td nowrap>
        <div class=" font-16px font-Medium"><?= Aww::formatDate($history_stat['transaction_date'], 'd/m/Y'); ?></div>
      </td>
      <td nowrap>
        <div class="font-16px font-Regular">
          <?= $game_type; ?>
        </div>
      </td>
      <td nowrap class="font-16px font-Medium"> <?= $history_stat['game_name']; ?></td>
      <td nowrap class="text-right font-16px font-Regular thin-cell"><?= number_format($history_stat['count_user'], 0); ?></td>
      <td nowrap class="text-right font-16px font-Medium text-success"><?= number_format($history_stat['sum_win'], 2); ?></td>
      <td nowrap class="text-right font-16px font-Medium text-danger"><?= number_format($history_stat['sum_lose'], 2); ?></td>
    </tr>
  <?php
  }
  ?>


</tbody>