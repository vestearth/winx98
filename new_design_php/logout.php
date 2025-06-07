<?php
require_once '../.framework/import.php';
$user_data = User::getCurrent();
$data = [
  'user_id' => $user_data['id'],
  'detail' => 'ออกจากระบบ',
];
nga_user::addNewUserLog($code, $data);

User::logout();
Aww::redirect('index.php');
