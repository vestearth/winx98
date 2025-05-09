<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../../.framework/import.php';

$code = isset($_POST['code']) ? $_POST['code'] : '';
$data = [
  'is_read' => 1
];
$user_data = User::getCurrent();
$where = [
  'user_id' => $user_data['id'],
  'is_read' => "'0'"
];
$notification = User_Notification::selectNotification($code, $where);

if (isset($_POST['submit_read_noti'])) {
  foreach ($notification as $key => $value) {
    $ref_id[] = $value['ref_id'];
    $data = [
      'is_read' => 1
    ];
    User_Notification::updateNotification($code, $value['id'], $data);
  }
}
