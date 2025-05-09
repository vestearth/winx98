<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'credit_discount'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];

$where = [
  'transaction_type' => 'withdraw',
  'transaction_by' => 'admin',
  'transaction_date' => isset($_POST['transaction_date']) ? $_POST['transaction_date'] : '',
  'credit_amount' => isset($_POST['credit_amount']) ? $_POST['credit_amount'] : '',
  'customer_username' => isset($_POST['customer_username']) ? $_POST['customer_username'] : '',
  'credit_before' => isset($_POST['credit_before']) ? $_POST['credit_before'] : '',
  'credit_after' => isset($_POST['credit_after']) ? $_POST['credit_after'] : '',
  'remark' => isset($_POST['remark']) ? $_POST['remark'] : '',
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['transaction_date_time' => 'DESC']
];
$select = nga_user::selectuserCreditTransaction($code, $where, $options);
?>
<tbody data-total_count="<?= $select['total_count'] ?>">
  <?php foreach ($select['list'] as $value) { ?>
    <tr>
      <td nowrap>
        <?= Aww::formatDate($value['transaction_date_time'], 'd/m/Y, H:i'); ?>
      </td>
      <td nowrap class="text-right">
        <?= number_format($value['credit_amount'], 2) ?>
      </td>
      <td nowrap>
        <?= hidePhoneNumber($value['customer_username']) ?>
      </td>
      <td nowrap class="text-right"><?= number_format($value['credit_before'], 2) ?></td>
      <td nowrap class="text-right"><?= number_format($value['credit_after'], 2) ?></td>
      <td nowrap class="thin-cell">
        <div class="form-row px-15px">
          <div class="d-flex justify-content-center align-items-center">
            <?= file_get_contents("./../assets/icon/icon-dot-green.svg"); ?>
            <span class="ml-5px">สำเร็จแล้ว</span>
          </div>
          <!-- ซ่อนไว้ก่อน
          <div class="col-2">
          </div>
          <div class="col-10">
            <img src="./assets/image/bot-auto.png" />
          </div> 
        -->
          <div class="col-2">
          </div>
          <div class="col-10">
            โดย <?= $value['admin_username'] ?>
          </div>
        </div>
      </td>
      <td>
        <?= $value['remark'] ?>
      </td>
    </tr>
  <?php } ?>
</tbody>