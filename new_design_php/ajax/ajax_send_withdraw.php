<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../.framework/import.php';

$user_data = User::getCurrent();
$get_auto_wd = nga_management::getAutoDepositWithdraw($code);
if ($get_auto_wd['is_withdraw_active']) {
  $data = [
    'user_id' => $user_data['id'],
    'transaction_type' => 'withdraw',
    'credit_amount' => $_POST['credit_amount'],
    'transaction_by' => 'user',
    'transaction_by_user_id' => $user_data['id'],
    'remark' => '',
    'status' => 'wait_confirm',
  ];
  $result =  nga_user::addUserCreditTransaction($code, $data);
  if ($result['response_status']) {
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'ทำการขอถอนเงินจำนวน ' . number_format($_POST['credit_amount'], 2) . ' บาท',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
  }
} else {
  $result = [
    'response_status' => false,
    'response_message' => $get_auto_wd['withdraw_condition'],
    'withdraw_condition' => 1,
  ];
}

echo json_encode($result, true);
