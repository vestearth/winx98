<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../.framework/import.php';

if ($_POST['type'] == 'special') {
  $result = nga_management::receivePromotionSpecialDay($code, $_POST['user_id']);
  if ($result['response_status']) {
    $data = [
      'user_id' => $_POST['user_id'],
      'detail' => 'รับโปรโมชั่นวันพิเศษ',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
  }
} else if ($_POST['type'] == 'lucky') {
  $result = nga_management::receivePromotionMonthly($code, $_POST['user_id']);
  if ($result['response_status']) {
    $data = [
      'user_id' => $_POST['user_id'],
      'detail' => 'รับโปรโมชั่นรายเดือน',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
  }
}
echo json_encode($result, true);
