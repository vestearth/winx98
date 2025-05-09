<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../../.framework/import.php';
$code = (isset($_GET['c']) && $_GET['c']) ? $_GET['c'] : null;
$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : 0;
$balance_bot = nga_bank_hold_money_api::getBalanceKbank($code, $id);
if ($balance_bot['accountNo']) {
  $balance_bot_data = $balance_bot;
  $totalAvailableBalance = isset($balance_bot_data['availableBalance']) && $balance_bot_data['availableBalance'] ? $balance_bot_data['availableBalance'] : '';
} else {
  $balance_bot_data = [];
  $totalAvailableBalance = '';
}
echo json_encode([
  'amount' => $totalAvailableBalance
]);
