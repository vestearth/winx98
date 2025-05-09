<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$prefix = '../../../';
$code = $_GET['c'];
$where = [
  'banner_name' => $_POST['name'],
  'upload_date' => $_POST['upload_date'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management::selectBanner($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) { ?>
    <tr class="tr-link">
      <td class="font-15px font-Medium" nowrap>
        <img src="<?= $data['banner_image']; ?>" class="w-40px" style="border-radius: 5px;">
      </td>
      <td class="font-15px font-Medium" nowrap><?= $data['banner_name']; ?></td>
      <td class="font-15px font-Medium min-w-200px" nowrap><?= Aww::formatDate($data['insert_date_time'], 'd/m/Y'); ?></td>
      <td>
        <?php
        TiwForm::normal('btn', '', ['name' => 'delete_banner', 'type' => 'button'], ['text' => '', 'type' => 'delete', 'modal_id' => 'delete_banner', 'modal_data' => $data, 'prefix' => '../../../']);
        ?>
      </td>
    </tr>
  <?php } ?>
</tbody>