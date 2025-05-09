<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];

$where = [
  'name' => isset($_POST['name']) ? $_POST['name'] : '',
  'start_date' => isset($_POST['start_date']) ? $_POST['start_date'] : '',
  'end_date' => isset($_POST['end_date']) ? $_POST['end_date'] : '',
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$select =  nga_management::selectPromotion($code, $where, $options);
?>
<tbody data-total_count="<?= $select['total_count'] ?>">
  <?php
  foreach ($select['list'] as $value) {
    $data_modal = $value;
    $data_modal['type_modal'] = $value['type'] == 'credit' ? 'เครดิต' : 'แต้ม';
    $data_modal['receive_type_modal'] = $value['receive_type'] == 'auto' ? 'อัตโนมัติ' : 'กำหนดเอง';
  ?>
    <tr>
      <td nowrap>
        <div class="table-img-40px">
          <img src="<?= $value['promotion_image'] ?>" alt="">
        </div>
      </td>
      <td nowrap class="font-16px font-SemiBold"><?= $value['name'] ?></td>
      <td nowrap class="font-16px font-Medium"><?= Aww::formatDate($value['start_date_time'], 'd/m/Y, H:i'); ?></td>
      <td nowrap class="font-16px font-Medium"><?= Aww::formatDate($value['end_date_time'], 'd/m/Y, H:i'); ?></td>
      <td nowrap class="font-16px font-Medium">
        <div class="d-flex align-items-center">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-need-custom form-btn-icon   mr-5px'], ['text' => file_get_contents('../assets/icon/icon-edit.svg'), 'prefix' => '', 'modal_id' => 'edit_promotion', 'modal_data' => $data_modal, 'is_ajax' => true]);
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => ''], ['text' => '', 'type' => 'delete', 'prefix' => $prefix, 'modal_id' => 'delete_data', 'modal_data' => $data_modal]);
          ?>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>