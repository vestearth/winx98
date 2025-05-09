<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'name' => $_POST['name'],
  'description' => $_POST['description'],
  'point_use' => $_POST['point_use'],
  'start_date' => $_POST['start_date'],
  'end_date' => $_POST['end_date'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management::selectReward($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) { ?>
    <tr class="tr-link cursor-pointer" data-link="">
      <td class="font-16px font-Medium" nowrap>
        <div class="reward-img">
          <img src="<?= $data['reward_img'] ?>">
        </div>
      </td>
      <td class="font-16px font-SemiBold" nowrap><?= $data['name'] ?></td>
      <td class="font-16px font-Regular" nowrap align="left"><?= Aww::limitString($data['description'], 70); ?></td>
      <td class="font-16px font-Medium text-primary" nowrap align="right"><?= number_format($data['point_use']); ?></td>
      <td class="font-16px font-Regular" nowrap align="left"><?= Aww::formatDate($data['start_date'], 'd/m/Y'); ?></td>
      <td class="font-16px font-Regular" nowrap align="left"><?= Aww::formatDate($data['end_date'], 'd/m/Y'); ?></td>
      <td class="font-16px font-Medium text-primary" nowrap align="left">
        <?php
        $is_active_txt = ($data['is_active']) ? 'เปิดใช้งาน' : 'ปิดการใช้งาน';
        ?>
        <span class="<?= ($data['is_active']) ? 'text-success' : 'text-danger'; ?>"><?= $is_active_txt; ?></span>
      </td>
      <td>
        <div class="d-flex">
          <?php
          TiwForm::normal('btn', '', ['name' => 'edit_reward', 'type' => 'button'], ['text' => '', 'type' => 'edit', 'modal_id' => 'edit_reward', 'modal_data' => $data, 'prefix' => '../../../']);
          TiwForm::normal('btn', '', ['name' => '', 'type' => 'button'], ['text' => '', 'type' => 'delete', 'modal_id' => 'delete_reward', 'modal_data' => $data, 'prefix' => '../../../']);
          ?>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>