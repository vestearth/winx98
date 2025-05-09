<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'statements'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];

$where = [
  'transaction_date' => isset($_POST['transaction_date']) ? $_POST['transaction_date'] : '',
  'transaction_amount' => isset($_POST['transaction_amount']) ? $_POST['transaction_amount'] : '',
  'transaction' => isset($_POST['transaction']) ? $_POST['transaction'] : '',
  'status' => isset($_POST['status']) ? $_POST['status'] : '',
  'customer_bank_name' => isset($_POST['customer_bank_name']) ? $_POST['customer_bank_name'] : '',
];

if ($_POST['transaction'] == 'all') {
  $where['transaction'] = ['withdraw', 'deposit'];
}

if ($_POST['status'] == 'all') {
  unset($where['status']);
}

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['transaction_date_time' => 'DESC']
];
$select = nga_management_bot::selectBotStatement($code, $where, $options);
?>
<tbody data-total_count="<?= $select['total_count'] ?>">
  <?php
  foreach ($select['list'] as $value) {
    if ($value['transaction'] == 'withdraw') {
      $transaction_type_msg = 'แจ้งถอนจาก';
      $transaction_type = '<span class="text-danger">รายการถอน</span>';
    } else if ($value['transaction'] == 'deposit') {
      $transaction_type_msg = 'รับโอนจาก';
      $transaction_type = '<span class="text-primary">รายการฝาก</span>';
    } else {
      $transaction_type_msg = '';
      $transaction_type = '';
    }

    if ($value['status'] == 'confirm') {
      $status_msg = 'ได้รับเครดิตแล้ว';
      $status_img = 'green';
    } else {
      $status_msg = 'กำลังโอนเงิน';
      $status_img = 'yellow';
    }
  ?>
    <tr class="cursor-pointer" <?php Tiwdal::register('statement_detail', $value, ['prefix' => '', 'modal_id' => 'statement_detail', 'is_ajax' => true]); ?>>
      <td nowrap>
        <div><?= Aww::formatDate($value['transaction_date_time'], 'd/m/Y, H:i'); ?></div>
      </td>
      <td nowrap class="thin-cell text-right">
        <?= number_format($value['transaction_amount'], 2) ?>
      </td>
      <td nowrap>
        <?= $transaction_type_msg . ' ' . $value['transaction_from_bank_abb'] . ' ' . $value['transaction_from_bank_no'] . ' รหัสสมาชิก : ' . $value['customer_username'] ?>
      </td>
      <td nowrap class="thin-cell">
        <div class="form-row pr-40px">
          <div class="col-4 "><img class="w-25px border-raduis-15px" src="<?= $value['web_bank_image'] ?>"></div>
          <div class=" col-8 "><?= $value['web_bank_abb'] ?></div>
          <div class="col-4"></div>
          <div class=" col-8"><?= $value['web_bank_no'] ?></div>
        </div>
      </td>
      <td nowrap class="thin-cell text-blue">
        <?= $transaction_type ?>
      </td>
      <td nowrap class="thin-cell vertical-center">
        <div class="form-row pr-40px">
          <div class="col-2">
            <?= file_get_contents("./../assets/icon/icon-dot-" . $status_img . ".svg"); ?>
          </div>
          <div class="col-10 pl-10px"><?= $status_msg ?></div>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>