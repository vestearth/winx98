<?php
require_once '../.framework/import.php';
Structure::loadMetaForAjax('../');
$code = Aww::API_CODE['winx'];
$user_data = User::getCurrent();
$where = [
  'user_id' => $user_data['id'],
  'transaction_type' => 'deposit',
  'is_wallet' => 1
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : [
    'transaction_date_time' => 'DESC'
  ]
];
$user_customer = nga_user::selectuserCreditTransaction($code, $where, $options);
$data_list = isset($user_customer['list']) ? $user_customer['list'] : [];
$total_count = isset($user_customer['total_count']) ? $user_customer['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($data_list as $list) {
    $list['date_trans'] = Aww::formatDate($list['transaction_date_time'], 'd/m/Y,H:i');
    $list['transfer_data'] = $list['customer_bank_no'] . ', ' . $list['customer_bank_name_th'];

    if (($list['customer_bank_no']) && $list['customer_bank_abb']) {
      $list['transfer_data'] = $list['customer_bank_no'] . ', ' . $list['customer_bank_name_th'];
    } else {
      $list['transfer_data'] = '-';
    }

    if ($list['status'] == 'completed') {
      $list['status_th'] = Ty::get('creditreceived', [], ["case" => "ucfirst"]);
      $list['status_complete'] = Ty::get('creditreceived', [], ["case" => "ucfirst"]);
      $list['status_waiting'] = '';
    } else {
      $list['status_th'] = Ty::get('waitingtobeprocessed', [], ["case" => "ucfirst"]);
      $list['status_complete'] = '';
      $list['status_waiting'] = Ty::get('waitingtobeprocessed', [], ["case" => "ucfirst"]);
    }
    $list['remark'] = ($list['remark']) ? $list['remark'] : '-';
  ?>
    <tr class="cursor-pointer" <?php Tiwdal::register('modal_detail', $list); ?>>
      <td nowrap class="text-white">
        <div>
          <?php echo Aww::formatDate($list['transaction_date_time'], 'd/m/Y, H:i'); ?>
        </div>
      </td>
      <td nowrap class="text-end text-white"><?= number_format($list['credit_amount'], 2); ?></td>
      <td nowrap class="text-end ">
        <?php if ($list['status'] == 'completed') { ?>
          <div class="text-success">
            <?= Ty::get('creditreceived', [], ["case" => "ucfirst"]) ?>
          </div>
        <?php } else if ($list['status'] == 'cancel') { ?>
          <div class="text-danger">
            <?= Ty::get('cancel', [], ['case' => 'ucfirst']) ?>
          </div>
        <?php } else { ?>
          <div class="text-warning">
            <?= Ty::get('waitingtobeprocessed', [], ["case" => "ucfirst"]) ?>
          </div>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>