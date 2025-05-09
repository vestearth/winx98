<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'user_id' => $_GET['id'],
];

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];
$call_api = nga_user::selectUserRedemtionHistory($code, $where, $options);
$list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php
  if ($list) {
    foreach ($list as $point_list) {
  ?>
      <tr>
        <td><?= Aww::formatDate($point_list['insert_date_time'], 'd/m/Y, H:i'); ?></td>
        <td>
          ใช้ <span class="text-primary"><?= number_format($point_list['point_use'], 0) ?></span> แต้ม แลกของรางวัล : <span class="text-primary"><?= $point_list['reward_name'] ?></span>
        </td>
      </tr>
  <?php }
  } ?>
</tbody>