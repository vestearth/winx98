<?php
require_once '../.framework/import.php';
Structure::loadMetaForAjax('../');
$code = Aww::API_CODE['winx'];
$user_data = User::getCurrent();
$where = [
  'user_id' => $user_data['id'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];

$user_earning = nga_user::selectUserCommissionHistory($code, $where, $options);
$data_list = isset($user_earning['list']) ? $user_earning['list'] : [];
$total_count = isset($user_earning['total_count']) ? $user_earning['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($data_list as $list) {
  ?>
    <tr>
      <td nowrap class="text-white">
        <?= Aww::formatDate($list['insert_date_time'], 'd/m/Y, H:i'); ?>
      </td>
      <td nowrap class="text-white text-end">
        <?= number_format($list['commission_amount'], 2) ?>
      </td>
      <td nowrap class="text-white text-end">
        <?php if ($list['status'] == 'completed') {  ?>
          <span class="text-success"><?= Ty::get('creditreceived', [], ["case" => "ucfirst"]) ?></span>
        <?php } else { ?>
          <span class="text-danger"><?= Ty::get('credit_not', [], ["case" => "ucfirst"]) ?></span>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>