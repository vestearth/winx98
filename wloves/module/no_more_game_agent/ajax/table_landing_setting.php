<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$prefix = '../../../';
$code = $_GET['c'];
$where = [
  'name' => $_POST['name'],
  'description' => $_POST['description'],
  'upload_date' => $_POST['upload_date'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management::selectLandingPage($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) { ?>
    <tr class="tr-link">
      <td class="font-15px font-Medium" nowrap>
        <img src="<?= $data['landing_page_img']; ?>" class="w-40px" style="border-radius: 5px;">
      </td>
      <td class="font-15px font-Medium" nowrap><?= $data['name']; ?></td>
      <td class="font-15px font-Medium"><?= Aww::limitString($data['description'], 80); ?></td>
      <td>
        <div class="d-flex text-nowrap">
          <?php
          $arr = [];
          foreach ($data['landing_page_user_group'] as $key => $landing_page_user_group) {
            if ($landing_page_user_group['is_active']) {
              array_push($arr, $landing_page_user_group['user_group_name']);
            }
          }
          echo implode(", ", $arr);
          ?>
        </div>
      </td>
      <td class="font-15px font-Medium min-w-200px" nowrap><?= Aww::formatDate($data['insert_date_time'], 'd/m/Y'); ?></td>
      <td>
        <?php
        TiwForm::normal('btn', '', ['name' => 'delete_landing', 'type' => 'button'], ['text' => '', 'type' => 'delete', 'modal_id' => 'delete_landing', 'modal_data' => $data, 'prefix' => '../../../']);
        ?>
      </td>
    </tr>
  <?php } ?>
</tbody>