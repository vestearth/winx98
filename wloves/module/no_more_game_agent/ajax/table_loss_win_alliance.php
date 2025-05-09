<?php
$_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'loss_win_alliance'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : null;

$where = [
  'id' => $id,
  'deposit_first_time_date' => $_POST['deposit_first_time_date'],
  'user_register_count' => $_POST['user_register_count'],
  'user_count_by_first_time_date' => $_POST['user_count_by_first_time_date'],
  'count_deposit_first_time_percent' => $_POST['count_deposit_first_time_percent'],
  'count_user_active' => $_POST['count_user_active'],
  'count_user_active_percent' => $_POST['count_user_active_percent'],
];

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management::selectAllianceStatistics($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($list as $data) { ?>
    <tr class="tr-link cursor-pointer" data-link="loss_win_alliance_detail.php?c=<?= $code ?>&id=<?= $data['id'] ?>&date_data=<?= $data['deposit_first_time_date'] ?>">
      <td nowrap>
        <div>
          <?php
          if ($data['deposit_first_time_date']) {
            echo Aww::formatDate($data['deposit_first_time_date'], 'd/m/Y');
          } else {
            echo '-';
          }
          ?></div>
      </td>
      <td nowrap>
        <div class="text-primary text-right">
          <?= isset($data['user_register_count']) ? number_format($data['user_register_count'], 0) : ''; ?>
        </div>
      </td>
      <td nowrap class="text-success text-right"><?= number_format($data['user_count_by_first_time_date']); ?></td>
      <td nowrap class="text-primary text-right"><?= number_format($data['count_deposit_first_time_percent']); ?>%</td>
      <td nowrap class="text-success text-right"><?= number_format($data['count_user_active']); ?></td>
      <td nowrap class="text-primary text-right"><?= number_format($data['count_user_active_percent']); ?>%</td>
      <td nowrap>
        <div class="text-right svg-py-auto size-30px"><?= file_get_contents('../assets/icon/icon-arrow-right.svg') ?></div>
      </td>
    </tr>
  <?php } ?>
</tbody>