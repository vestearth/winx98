<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'summarize_returns'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$where = [
  'from_date' => $from_date,
  'to_date' => $to_date
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['turn_over_date' => 'DESC']
];
$turn_over_list = nga_statistic::selectSummaryTurnOverHistory($code, $where, $options);
$data_list = isset($turn_over_list['list']) ? $turn_over_list['list'] : [];
$total_count = isset($turn_over_list['total_count']) ? $turn_over_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2">
  <?php
  foreach ($data_list as $list) {
    if ($list['turn_over_date'] == 'ยอดรวม') {
  ?>
      <tr>
        <td nowrap class="text-white text-right bg-blue-1 font-SemiBold"><?= $list['turn_over_date']; ?></td>
        <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($list['sum_turn_over'], 2); ?></td>
        <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($list['sum_turn_over_received'], 2); ?></td>
        <td nowrap class="text-right text-success bg-blue-2 font-SemiBold"><?= number_format($list['sum_turn_over_outstanding'], 2); ?></td>
      </tr>
    <?php } else { ?>
      <tr>
        <td nowrap class="font-SemiBold"><?= Aww::formatDate($list['turn_over_date'], 'd/m/Y'); ?></td>
        <td nowrap class="text-right"><?= number_format($list['sum_turn_over'], 2); ?></td>
        <td nowrap class="text-right"><?= number_format($list['sum_turn_over_received'], 2); ?></td>
        <td nowrap class="text-right text-success"><?= number_format($list['sum_turn_over_outstanding'], 2); ?></td>
      </tr>
  <?php }
  } ?>
</tbody>