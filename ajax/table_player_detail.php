<?php
require_once '../.framework/import.php';
Structure::loadMetaForAjax('../');
$code = Aww::API_CODE['nmg'];
$user_data = User::getCurrent();
// $where = [
//   'upline_user_id' => $user_data['id'],
// ];
// $options = [
//   'total_count' => true,
//   'page_no'     => $_POST['page_no'],
//   'page_size'   => $_POST['page_size'],
//   'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
// ];

$user_earning = nga_user::selectUserDownlineLevel($code, $user_data['id']);
$data_list = isset($user_earning['list']) ? $user_earning['list'] : [];
$total_count = isset($user_earning['total_count']) ? $user_earning['total_count'] : 0;
?>
<tbody data-total_count="<?= count($user_earning); ?>">
  <?php
  foreach ($user_earning as $list) {
  ?>
    <tr>
      <td nowrap class="text-white">
        <?= $list['level']; ?>
      </td>
      <td nowrap class="text-white">
        <?= number_format($list['count_downline'], 0) ?>
      </td>
      <td nowrap class="text-white">
        <?= number_format($list['sum_win'] - $list['sum_lose'], 2) ?>
      </td>
    </tr>
  <?php } ?>
</tbody>