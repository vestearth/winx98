<?php
$_WLOVES['no_check_permission'] = 1;
// $_PAGE['permission'] = ['no_more_game_agent', 'management', 'hold_money'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);

$code = (isset($_GET['c']) && $_GET['c']) ? $_GET['c'] : null;
$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : 0;
$statement_list = nga_bank_hold_money_api::getStatementBotSCBByPageNum($code, $id, 10);
if ($statement_list['response_status']) {
  $statement_data = $statement_list['response_data'];
} else {
  $statement_data = [];
}
?>
<?php foreach ($statement_data as $statement) {
  $type = (isset($statement['txnCode']) && $statement['txnCode']) ? $statement['txnCode'] : [];
  if (in_array($type['description'], ['ถอนเงิน', 'Withdrawal'])) {
    $withdraw_deposit = 'ถอนเงิน';
  } else if ($type['description'] == 'ฝากเงิน') {
    $withdraw_deposit = 'ฝากเงิน';
  }
?>
  <tr>
    <td nowrap>
      <?= (isset($statement['txnDateTime']) && $statement['txnDateTime']) ? Aww::formatDate($statement['txnDateTime'], 'd/m/Y H:i:s') : ''; ?>
    </td>
    <td nowrap>
      <?= (isset($statement['txnRemark']) && $statement['txnRemark']) ? $statement['txnRemark'] : ''; ?>
    </td>
    <td nowrap>
      <?php if ($withdraw_deposit == 'ฝากเงิน') { ?>
        <span class="text-success">ฝากเงิน</span>
      <?php } else if ($withdraw_deposit == 'ถอนเงิน') { ?>
        <span class="text-danger">ถอนเงิน</span>
      <?php } ?>
    </td>
    <td nowrap class="text-right">
      <?= (isset($statement['txnAmount']) && $statement['txnAmount']) ? number_format($statement['txnAmount'], 2) : ''; ?>
    </td>
  </tr>
<?php } ?>