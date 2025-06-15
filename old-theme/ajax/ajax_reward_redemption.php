<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../.framework/import.php';

$data = [
  'user_id' => $_POST['user_id'],
  'reward_id' => $_POST['reward_id'],
];
$result =  nga_user::addNewUserRedemption($code, $data);
if ($result['response_status']) {
  $data = [
    'user_id' => $_POST['user_id'],
    'detail' => 'ทำการแลกของรางวัล ',
  ];
  $user_log = nga_user::addNewUserLog($code, $data);
}

echo json_encode($result, true);
