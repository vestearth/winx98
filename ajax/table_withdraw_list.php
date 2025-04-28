<?php
require_once '../.framework/import.php';
Structure::loadMetaForAjax('../');
$code = Aww::API_CODE['winx'];
$user_data = User::getCurrent();
$where = [
  'user_id' => $user_data['id'],
  'transaction_type' => 'withdraw',
  'is_wallet' => 1,
  'is_bot_run_withdraw' => 1,
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

    if ($list['web_bank_no'] && $list['web_bank_abb']) {
      $list['transfer_data'] = $list['web_bank_no'] . ', ' . $list['web_bank_name_th'];
    } else {
      $list['transfer_data'] = '-';
    }

    $status = $list['status'];
    if ($status == 'waiting_user') {
      $text = 'รอผู้ใช้ทำรายการ';
      $textClass = 'text-warning';
    } else if ($status == 'waiting_system') {
      $text = 'รอระบบประมวลผล';
      $textClass = 'text-warning';
    } else if ($status == 'success') {
      $text = 'สำเร็จ';
      $textClass = 'text-success';
    } else if ($status == 'cancel') {
      $text = 'ยกเลิก';
      $textClass = 'text-danger';
    } else if ($status == 'expired') {
      $text = 'หมดอายุ';
      $textClass = 'text-danger';
    }

    // if ($list['status'] == 'completed') {
    //   $list['status_th'] = Ty::get('creditreceived', [], ["case" => "ucfirst"]);
    //   $list['status_complete'] = Ty::get('creditreceived', [], ["case" => "ucfirst"]);
    //   $list['status_waiting'] = '';
    //   $list['status_cancel'] = '';
    //   $list['remark_data'] = ($list['remark']) ? $list['remark'] : '-';
    // } else if ($list['status'] == 'cancel') {
    //   $list['status_th'] = Ty::get('cancel', [], ["case" => "ucfirst"]);
    //   $list['status_complete'] = '';
    //   $list['status_waiting'] = '';
    //   $list['status_cancel'] = Ty::get('cancel', [], ["case" => "ucfirst"]);
    //   $list['remark_data'] = ($list['cancel_remark']) ? $list['cancel_remark'] : '-';
    // } else {
    //   $list['status_th'] = Ty::get('waitingtobeprocessed', [], ["case" => "ucfirst"]);
    //   $list['status_complete'] = '';
    //   $list['status_waiting'] = Ty::get('waitingtobeprocessed', [], ["case" => "ucfirst"]);
    //   $list['status_cancel'] = '';
    //   $list['remark_data'] = ($list['remark']) ? $list['remark'] : '-';
    // }
    if (!($list['transaction_type'] == 'withdraw' && $list['transaction_by'] == 'admin' && $list['receive_from'] == 'admin_add_manual')) {
  ?>
      <tr <?php Tiwdal::register('modal_detail', $list); ?>>
        <td nowrap class="text-white">
          <div>
            <?php echo Aww::formatDate($list['transaction_date_time'], 'd/m/Y, H:i'); ?>
          </div>
        </td>
        <td nowrap class="text-end text-white"><?= number_format($list['credit_amount'], 2); ?></td>
        <td nowrap class="text-end">
          <div class="<?= $textClass; ?>">
            <?= $text; ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  <?php } ?>
</tbody>