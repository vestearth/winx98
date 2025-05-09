<?php
$_PAGE['permission'] = ['no_more_game_agent', 'wallet', 'bonus_invite_daily'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'transaction_date' => $_POST['transaction_date'],
  'member_code' => $_POST['member_code'],
  'bank_name' => $_POST['bank_name'],
  'username' => $_POST['username'],
  'sum_money_diff' => $_POST['sum_money_diff'],
  'sum_money_upline' => $_POST['sum_money_upline'],
  'money_upline_received' => $_POST['money_upline_received'],
  'money_upline_outstanding' => $_POST['money_upline_outstanding'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$call_api = nga_statistic::selectSummaryUserCommissionByDate($code, $where, $options);
$list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($list as $summarize) { ?>
    <tr>
      <td nowrap>
        <div><?= Aww::formatDate($summarize['transaction_date'], 'd/m/Y H:i'); ?></div>
      </td>
      <td nowrap>
        <div><?= $summarize['member_code']; ?></div>
      </td>
      <td nowrap>
        <?= hidePhoneNumber($summarize['username']); ?>
      </td>
      <td nowrap class="text-primary"><?= $summarize['bank_name']; ?></td>
      <td nowrap class="text-right">
        <?php if ($summarize['sum_money_diff'] > 0) { ?>
          <span class="text-success">
            <?= number_format($summarize['sum_money_diff'], 2); ?>
          </span>
        <?php } else { ?>
          <span class="text-danger">
            <?= number_format($summarize['sum_money_diff'], 2); ?>
          </span>
        <?php } ?>
      </td>
      <td nowrap class="text-right"><?= number_format($summarize['sum_money_upline'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($summarize['money_upline_received'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($summarize['money_upline_outstanding'], 2); ?></td>
    </tr>
  <?php } ?>
</tbody>