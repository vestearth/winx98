<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$customer_id = $_GET['user_id'];
$where = [
  'user_id' => $customer_id,
  'insert_date' => $_POST['insert_date'],
  'log_text' => $_POST['log_text'],
  'admin_username' => $_POST['admin_username'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];

$data_list = nga_user::selectUserEditLog($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($list as $edit_log_list) { ?>
    <tr>
      <td nowrap><?= Aww::formatDate($edit_log_list['insert_date_time'], 'd/m/Y,H:i'); ?></td>
      <td nowrap><?= $edit_log_list['log_text']; ?></td>
      <td nowrap><?= $edit_log_list['admin_username']; ?></td>
    </tr>
  <?php } ?>
</tbody>