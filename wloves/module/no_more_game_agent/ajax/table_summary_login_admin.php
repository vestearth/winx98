<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'history_admin_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$from_date = '2022-10-1';
$to_date = '2022-10-14';
$where = [
  'username' => $_POST['username'],
  'full_name' => $_POST['full_name']
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$admin_data = User::selectUser('dvjdb', $where, $options);
$data_list = isset($admin_data['list']) ? $admin_data['list'] : [];
$total_count = isset($admin_data['total_count']) ? $admin_data['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php
  foreach ($data_list as $list) {
  ?>
    <tr>
      <td nowrap class="font-SemiBold"><?= $list['username']; ?></td>
      <td nowrap class=""><?= $list['full_name']; ?></td>
      <td nowrap class=""><?= Aww::formatDate($list['last_online_date_time'], 'd/m/Y H:i'); ?></td>
      <td nowrap class=""><?= $list['last_online_ip']; ?></td>
      <td nowrap class="text-right "><?= number_format($list['count_add_deposit'], 0); ?></td>
      <td nowrap class="text-right "><?= number_format($list['count_add_withdraw'], 0); ?></td>
      <td nowrap class="text-right "><?= number_format($list['count_edit_user'], 0); ?></td>
      <td nowrap class="text-right "><?= number_format($list['count_edit_self'], 0); ?></td>
      <td nowrap class="text-right "><?= number_format($list['count_add_user'], 0); ?></td>
    </tr>
  <?php } ?>
</tbody>