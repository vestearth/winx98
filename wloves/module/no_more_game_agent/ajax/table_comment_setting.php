<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$comment_group_id = $_GET['comment_group_id'];
$where = [
  'comment_group_id' => $comment_group_id,
  'title_name' => $_POST['title_name'],
  'description' => $_POST['description'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management::selectCommentTitle($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) { ?>
    <tr class="tr-link">
      <td class="font-16px font-SemiBold" nowrap><?= $data['title_name'] ?></td>
      <td class="font-16px font-Regular" nowrap align="left"><?= Aww::limitString($data['description'], 70); ?></td>
      <td>
        <div class="d-flex align-items-center">
          <?php
          TiwForm::normal('btn', '', ['name' => 'edit_reward', 'type' => 'button'], ['text' => '', 'type' => 'edit', 'modal_id' => 'edit_reward', 'modal_data' => $data, 'prefix' => '../../../']);
          TiwForm::normal('btn', '', ['name' => '', 'type' => 'button'], ['text' => '', 'type' => 'delete', 'modal_id' => 'delete_reward', 'modal_data' => $data, 'prefix' => '../../../']);
          ?>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>