<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'cash_flow_summary_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$id_select = isset($_GET['id']) ? $_GET['id'] : '';
$where = [
  'from_date' => $_GET['from_date'],
  'to_date' => $_GET['to_date'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$call_api = nga_statistic::selectSummaryBotTransferMoney($code, $where, $options);
$data_list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;
// Aww::display($data_list);

?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2">
  <?php foreach ($data_list as $sum_list) {
    if ($sum_list['transaction_to_bank_no'] == 'ยอดรวม') {
  ?>
      <tr>
        <td nowrap colspan="3" class="text-white font-SemiBold text-right bg-blue-1">ยอดรวม</td>
        <td nowrap class="text-right bg-blue-2 "><?= number_format($sum_list['amount'], 2); ?></td>
      </tr>
    <?php } else { ?>
      <tr>
        <td nowrap class="font-SemiBold"><?= Aww::formatDate($sum_list['confirm_date_time'], 'd/m/Y, H:i'); ?></td>
        <td nowrap class=" "><?= $sum_list['transaction_from_bank_name_th']; ?> | <?= $sum_list['transaction_from_bank_name']; ?></td>
        <td nowrap class=" "><?= $sum_list['transaction_to_bank_name_th']; ?> | <?= $sum_list['transaction_to_bank_no']; ?></td>
        <td nowrap class="text-right "><?= number_format($sum_list['amount'], 2); ?></td>
      </tr>
  <?php }
  } ?>
  <!-- <tr>
    <td nowrap class="font-SemiBold">20/06/2022, 12:38</td>
    <td nowrap class=" "> ไทยพานิชย์ | พัชรพล ณ เรืองผล</td>
    <td nowrap class=" ">ไทยพานิชย์ | สุภัค ศรีมุกดา</td>
    <td nowrap class="text-right ">151,843.00</td>
    <td nowrap class="text-right ">76,250.00</td>
  </tr> -->
</tbody>