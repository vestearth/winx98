<?php
$_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'loss_win_with_alliance'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : null;

$where = [
  // 'insert_date' => $_POST['insert_date'],
  'name' => $_POST['name'],
  // 'count_deposit_first_time' => $_POST['count_deposit_first_time'],
  // 'sum_deposit_first_time' => $_POST['sum_deposit_first_time'],
  'user_count' => $_POST['user_count'],
];
// if ($_POST['count_deposit_first_time'] == '') {
//   unset($where['count_deposit_first_time']);
// }
// if ($_POST['sum_deposit_first_time'] == '') {
//   unset($where['sum_deposit_first_time']);
// }
if ($_POST['user_count'] == '') {
  unset($where['user_count']);
}

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']

];

$data_list = nga_management::selectAlliance($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($list as $data) { ?>
    <tr class="tr-link cursor-pointer" data-link="loss_win_with_alliance_detail.php?c=<?= $code ?>&id=<?= $data['id'] ?>">
      <?php
      /* 
      <td nowrap>
        <div><?= Aww::formatDate($data['insert_date_time'], 'd/m/Y'); ?></div>
      </td>
        */ ?>
      <td nowrap>
        <div class="text-primary"><?= $data['name']; ?></div>
      </td>
      <td nowrap class="text-primary text-right"><?= number_format($data['user_count']); ?></td>
      <td nowrap class="text-success text-right"><?= number_format($data['count_deposit_first_time']); ?></td>
      <td nowrap class="text-primary text-right"><?= number_format($data['count_deposit_first_time_percent'], 0); ?>%</td>
      <td nowrap class="text-right"><?= number_format($data['sum_deposit_first_time'], 2); ?></td>
      <td nowrap>
        <div class="text-right svg-py-auto size-30px"><?= file_get_contents('../assets/icon/icon-arrow-right.svg') ?></div>
      </td>
    </tr>
  <?php } ?>
</tbody>