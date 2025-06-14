<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../.framework/import.php';

$result =  nga_management::randomCard($_POST['code'], $_POST['user_id']);
if ($result['response_status']) {
  $data = [
    'user_id' => $_POST['user_id'],
    'detail' => 'ทำการแลกของรางวัลเปิดไพ่',
  ];
  $user_log = nga_user::addNewUserLog($code, $data);
}
echo json_encode($result);
