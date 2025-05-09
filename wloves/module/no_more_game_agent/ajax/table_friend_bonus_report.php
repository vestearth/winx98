<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'friend_invite_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'from_date' => $_GET['from_date'],
  'to_date' => $_GET['to_date'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['transaction_date' => 'DESC']
];
$user_customer = nga_statistic::selectSummaryUserDownlineCommission($code, $where, $options);
$data_list = isset($user_customer['list']) ? $user_customer['list'] : [];
$total_count = isset($user_customer['total_count']) ? $user_customer['total_count'] : 0;

?>
<tbody data-total_count="<?= $total_count ?>" class="border-table">
  <?php
  foreach ($data_list as $list) {
    if ($list['transaction_date'] == 'ยอดรวม') {
  ?>
      <tr>
        <td nowrap class="text-white font-SemiBold text-right bg-blue-1">ยอดรวม</td>
        <td nowrap class="text-right bg-blue-2 text-primary font-SemiBold"><?= number_format($list['sum_commission'], 2); ?></td>
        <td nowrap class="text-right bg-blue-2 text-success font-SemiBold"><?= number_format($list['sum_commission_received'], 2); ?></td>
        <td nowrap class="text-right bg-blue-2 text-warning font-SemiBold"><?= number_format($list['sum_commission_outstanding'], 2); ?></td>
      </tr>
    <?php } else { ?>
      <tr>
        <td nowrap class="font-SemiBold"><?= Aww::formatDate($list['transaction_date'], 'd/m/Y'); ?></td>
        <td nowrap class="text-right "><?= number_format($list['sum_money_upline'], 2); ?></td>
        <td nowrap class="text-right "><?= number_format($list['money_upline_received'], 2); ?></td>
        <td nowrap class="text-right "><?= number_format($list['money_upline_outstanding'], 2); ?></td>
      </tr>
  <?php }
  } ?>
</tbody>