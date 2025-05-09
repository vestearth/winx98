<?php
$_WLOVES['no_check_permission'] = 1;
// $_PAGE['permission'] = ['no_more_game_agent', 'management', 'hold_money'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);

$code = (isset($_GET['c']) && $_GET['c']) ? $_GET['c'] : null;
$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : 0;
$statement_list = nga_bank_hold_money_api::getStatementKbank($code, $id);
if ($statement_list['response_status']) {
  $statement_data = $statement_list['response_data'];
} else {
  $statement_data = [];
}

?>
<?php foreach ($statement_data['activityList'] as $statement) {
  if (in_array($statement['transactionDescription'], ['โอนเงิน', 'Withdrawal'])) {
    $withdraw_deposit = 'ถอนเงิน';
  } else if ($statement['transactionDescription'] == 'รับโอนเงิน') {
    $withdraw_deposit = 'ฝากเงิน';
  }
  if (isset($statement['transactionUxDate']) && $statement['transactionUxDate']) {
    $statement['date_time'] = date('Y-m-d H:i:s', $statement['transactionUxDate']);
  } else {
    $statement['date_time'] = '';
  }
?>
  <tr>
    <td nowrap>
      <?= (isset($statement['date_time']) && $statement['date_time']) ? $statement['date_time'] : ''; ?>
    </td>
    <td nowrap>
      <?php if ($withdraw_deposit == 'ถอนเงิน') { ?>
        <?= (isset($statement['transactionDescription']) && $statement['transactionDescription']) ? $statement['transactionDescription'] : ''; ?>
        <?= (isset($statement['toAccountNo']) && $statement['toAccountNo']) ? ' - ' . $statement['toAccountNo'] : ''; ?>
        <?= (isset($statement['anyIDValue']) && $statement['anyIDValue']) ? ' - ' . $statement['anyIDValue'] : ''; ?>
      <?php } else { ?>
        <?= (isset($statement['transactionDescription']) && $statement['transactionDescription']) ? $statement['transactionDescription'] : ''; ?>
        <?= (isset($statement['fromAccountNo']) && $statement['fromAccountNo']) ? ' - ' . $statement['fromAccountNo'] : ''; ?>
      <?php } ?>
    </td>
    <td nowrap>
      <?php if ($withdraw_deposit == 'ฝากเงิน') { ?>
        <span class="text-success">ฝากเงิน</span>
      <?php } else if ($withdraw_deposit == 'ถอนเงิน') { ?>
        <span class="text-danger">ถอนเงิน</span>
      <?php } ?>
    </td>
    <td nowrap class="text-right">
      <?= (isset($statement['amount']) && $statement['amount']) ? number_format($statement['amount'], 2) : ''; ?>
    </td>
  </tr>
<?php } ?>