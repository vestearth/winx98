<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'history_admin_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
// Decode the base64 string

if ($_GET['work_list_data'] != 'none') {
  $jsonString = base64_decode($_GET['work_list_data']);
  $action = json_decode($jsonString, true);
} else {
  $action = [];
}
$where = [
  'admin_id' => $_GET['admin_id'],
  'user_username' => $_POST['user_username'],
  'action' => $action,
  'ip' => $_POST['ip'],
  'action_date_from' => $from_date,
  'action_date_to' => $to_date,
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];
if (empty($action)) {
  unset($where['action']);
}


$data_list = nga_user::selectAdminActionLog($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;

$status_action_options = [
  [
    'value' => 'login',
    'text' => 'เข้าใช้งานระบบ',
  ],
  [
    'value' => 'add_deposit',
    'text' => 'ทำรายการฝากมือ',
  ],
  [
    'value' => 'add_withdraw',
    'text' => 'ทำรายการถอนมือ',
  ],
  [
    'value' => 'edit_user',
    'text' => 'แก้ไขข้อมูลลูกค้า',
  ],
  [
    'value' => 'edit_self',
    'text' => 'แก้ไขข้อมูลตนเอง',
  ],
  [
    'value' => 'add_user',
    'text' => 'สมัครให้ลูกค้า',
  ],
];
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($list as $data) {
    $actionToCheck = $data['action'];
  ?>
    <tr>
      <td nowrap class=""><?= Aww::formatDate($data['action_date_time'], 'd/m/Y H:i'); ?></td>
      <td nowrap class="font-SemiBold"><?= $data['admin_username'] ?></td>
      <td nowrap class="font-SemiBold text-capitalize">
        <?php
        foreach ($status_action_options as $status_action) {
          if ($status_action['value'] === $actionToCheck) {
            echo $status_action['text'];
            break;
          }
        }
        ?>
      </td>
      <td nowrap class="font-SemiBold"><?= $data['ip'] ?></td>
      <td nowrap class="font-SemiBold">
        <?= $data['user_username'] ? hidePhoneNumber($data['user_username']) : '-'; ?>
      </td>
      <td nowrap class="font-SemiBold">
        <?= $data['detail'] ? $data['detail'] : '-'; ?>
      </td>
    </tr>
  <?php } ?>
</tbody>