<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'customer_summary_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'username' => $_POST['username'],
  'bank_name' => $_POST['bank_name'],
  'first_time_deposit' => $_POST['first_time_deposit'],
  'first_time_deposit_date' => $_POST['first_time_deposit_date'],
  'count_deposit_time' => $_POST['count_deposit_time'],
  'sum_deposit' => $_POST['sum_deposit'],
  'sum_withdraw' => $_POST['sum_withdraw'],
  'money_balance' => $_POST['money_balance'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_user::selectUser($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;

$options_user = [
  'selected_fields' => ['first_time_deposit', 'count_deposit_time', 'sum_deposit', 'sum_withdraw', 'money_balance'],
];
$data_for_count = nga_user::selectUser($code, [], $options_user);
$total_first_deposit = 0;
$total_count_deposit_time = 0;
$total_sum_deposit = 0;
$total_sum_withdraw = 0;
$count_sum_profit = 0;
$total_sum_profit = 0;
$total_money_balance = 0;
foreach ($data_for_count as $for_count) {
  $total_first_deposit += $for_count['first_time_deposit'];
  $total_count_deposit_time += $for_count['count_deposit_time'];
  $total_sum_deposit += $for_count['sum_deposit'];
  $total_sum_withdraw += $for_count['sum_withdraw'];
  $count_sum_profit = $for_count['sum_withdraw'] - $for_count['sum_deposit'];
  $total_sum_profit  += $count_sum_profit;
  $total_money_balance += $for_count['money_balance'];
}
?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2 border-table">
  <?php if ($list) { ?>
    <tr>
      <td nowrap colspan="3" class="text-white font-SemiBold text-right bg-blue-1">ยอดรวม</td>
      <td nowrap class="text-right bg-blue-2 "><?= number_format($total_first_deposit, 2); ?></td>
      <td nowrap class="text-right bg-blue-2"><?= number_format($total_count_deposit_time, 2); ?></td>
      <td nowrap class="text-right bg-blue-2"><?= number_format($total_sum_deposit, 2); ?></td>
      <td nowrap class="text-right bg-blue-2"><?= number_format($total_sum_withdraw, 2); ?></td>
      <td nowrap class="text-right bg-blue-2"><?= number_format($total_sum_profit, 2); ?></td>
      <td nowrap class="text-right bg-blue-2"><?= number_format($total_money_balance, 2); ?></td>
    </tr>
    <?php
    foreach ($list as $key => $user_data) {
    ?>
      <tr>
        <td nowrap class=""><?= hidePhoneNumber($user_data['username']); ?></td>
        <td nowrap class=""><?= $user_data['bank_name']; ?></td>
        <td nowrap class=""><?= Aww::formatDate($user_data['first_time_deposit_date'], 'd/m/Y'); ?></td>
        <td nowrap class="text-right"><?= number_format($user_data['first_time_deposit'], 2); ?></td>
        <td nowrap class="text-right"><?= number_format($user_data['count_deposit_time']); ?></td>
        <td nowrap class="text-right"><?= number_format($user_data['sum_deposit'], 2); ?></td>
        <td nowrap class="text-right"><?= number_format($user_data['sum_withdraw'], 2); ?></td>
        <td nowrap class="text-right">
          <?php
          $sum_profit = $user_data['sum_withdraw'] - $user_data['sum_deposit'];
          ?>
          <?= number_format($sum_profit, 2); ?>
        </td>
        <td nowrap class="text-right"><?= number_format($user_data['money_balance'], 2); ?></td>
      </tr>
    <?php
    }
  } else { ?>
    <tr>
      <td colspan="9" class="text-center">ไม่มีข้อมูล</td>
    </tr>
  <?php } ?>
</tbody>