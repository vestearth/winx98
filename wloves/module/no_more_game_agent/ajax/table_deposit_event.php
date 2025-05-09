<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$prefix = '../../../';
$code = $_GET['c'];
$where = [
  'event_type' => $_POST['event_type'],
  'status' => $_POST['status'],
];
if ($_POST['event_type'] == 'all') {
  unset($where['event_type']);
}
if ($_POST['status'] == 'all') {
  unset($where['status']);
}
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management::selectEventDeposit($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) { ?>
    <tr class="tr-link">
      <td class="font-15px font-Medium min-w-200px" nowrap>
        <?php if ($data['event_type'] == 'short_term') { ?>
          <?= Aww::formatDate($data['from_date_time'], 'd/m/Y'); ?>
          -
          <?= Aww::formatDate($data['to_date_time'], 'd/m/Y'); ?>
        <?php } else { ?>
          <?= Aww::formatDate($data['from_date_time'], 'd/m/Y'); ?>
          -
          <?= Aww::formatDate($data['to_date_time'], 'd/m/Y'); ?>
        <?php } ?>
      </td>
      <td class="font-16px font-SemiBold" nowrap>
        <?php if ($data['event_type'] == 'short_term') { ?>
          <?= 'Short term 7 วัน' ?>
        <?php } else { ?>
          <?= 'Long term 30 วัน' ?>
        <?php } ?>
      </td>
      <td class="font-15px font-Medium">
        <?php if ($data['status'] == 'expire') { ?>
          <span class="text-secondary"><?= 'หมดเขตแล้ว' ?></span>
          <?php } else if ($data['status'] == 'pending') {
          $from_date_time = strtotime($data['from_date_time']);
          $today = strtotime(date('Y-m-d'));
          if ($from_date_time < $today) { ?>
            <span class="text-danger"><?= 'ปิดใช้งาน' ?></span>
          <?php } else { ?>
            <span class="text-warning"><?= 'ตั้งเวลาเปิดล่วงหน้า' ?></span>
          <?php } ?>
        <?php } else { ?>
          <span class="text-success"><?= 'เปิดใช้งานอยู่' ?></span>
        <?php } ?>
      </td>
      <td>
        <div class="d-flex">
          <?php
          $options = [
            'is_ajax' => true, //ถ้ามีตัวแปรนี้จะเป็น Ajax Modal
          ];
          ?>
          <?php
          TiwForm::normal('btn', '', ['name' => 'deposit_edit_data', 'type' => 'button'], ['text' => '', 'type' => 'edit', 'modal_id' => 'deposit_edit_data', 'modal_data' => $data, 'prefix' => '../../../', 'is_ajax' => true, 'ajax_prefix' => '']);
          TiwForm::normal('btn', '', ['name' => 'delete_deposit_activity', 'type' => 'button'], ['text' => '', 'type' => 'delete', 'modal_id' => 'delete_deposit_activity', 'modal_data' => $data, 'prefix' => '../../../']);
          ?>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>