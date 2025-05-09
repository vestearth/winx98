<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../../.framework/import.php';

$result = nga_user::getUserSumProfitByID($_POST['code'], $_POST['id']);
echo json_encode($result, true);
