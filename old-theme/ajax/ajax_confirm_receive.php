<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../.framework/import.php';

$user_data = User::getCurrent();
$result = nga_user::confirmUserReceiveCommission($code);
if ($result['response_status']) {
  $data = [
    'user_id' => $user_data['id'],
    'detail' => 'รับเครดิตรายได้จากเพื่อน',
  ];
  $user_log = nga_user::addNewUserLog($code, $data);
}
echo json_encode($result, true);
