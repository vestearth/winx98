<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'insert_date' => $_POST['insert_date'],
  'full_text' => $_POST['full_text'],
  'admin_username' => $_POST['admin_username'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management::selectRunnerTextHistory($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) { ?>
    <tr>
      <td class="font-16px font-SemiBold" nowrap><?= Aww::formatDate($data['insert_date_time'], 'd/m/Y, H:i'); ?></td>
      <td class="font-16px font-Regular" nowrap>
        <?= $data['full_text'] ?>
      </td>
      <td>
        <?= $data['admin_username'] ?>
      </td>
    </tr>
  <?php } ?>
</tbody>