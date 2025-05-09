<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../../.framework/import.php';
$code = (isset($_GET['c']) && $_GET['c']) ? $_GET['c'] : null;
$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : 0;
$balance_bot = nga_bank_hold_money_api::getBalanceBotSCB($code, $id);
if ($balance_bot['response_status']) {
  $balance_bot_data = $balance_bot['response_data'];
  $totalAvailableBalance = isset($balance_bot_data['totalAvailableBalance']) && $balance_bot_data['totalAvailableBalance'] ? $balance_bot_data['totalAvailableBalance'] : '';
} else {
  $balance_bot_data = [];
  $totalAvailableBalance = '';
}
echo json_encode([
  'amount' => $totalAvailableBalance
]);
