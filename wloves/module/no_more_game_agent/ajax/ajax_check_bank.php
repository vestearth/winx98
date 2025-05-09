<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../../.framework/import.php';

$result = nga_user::getBankNameByBankNo($_POST['code'], $_POST['bank_id'], $_POST['bank_account']);
echo json_encode($result, true);
