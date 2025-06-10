<?php
require_once '../../.framework/import.php';
Structure::loadMetaForAjax('../');
$code = Aww::API_CODE['winx'];
$user_data = User::getCurrent();
// $where = [
//   'user_id' => $user_data['id'],
//   'transaction_type' => 'deposit',
//   'is_wallet' => 1
// ];
// $options = [
//   'total_count' => true,
//   'page_no'     => $_POST['page_no'],
//   'page_size'   => $_POST['page_size'],
//   'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : [
//     'transaction_date_time' => 'DESC'
//   ]
// ];
// $user_customer = nga_user::selectuserCreditTransaction($code, $where, $options);
// $data_list = isset($user_customer['list']) ? $user_customer['list'] : [];
// $total_count = isset($user_customer['total_count']) ? $user_customer['total_count'] : 0;
?>
<tbody data-total_count="10">
  <?php
  $mockup_data = [
    ['tel_no' => '0812345678', 'amount' => 1500.00],
    ['tel_no' => '0823456789', 'amount' => 2750.50],
    ['tel_no' => '0834567890', 'amount' => 850.25],
    ['tel_no' => '0845678901', 'amount' => 3200.00],
    ['tel_no' => '0856789012', 'amount' => 1875.75],
    ['tel_no' => '0867890123', 'amount' => 4100.00],
    ['tel_no' => '0878901234', 'amount' => 675.50],
    ['tel_no' => '0889012345', 'amount' => 2950.25],
    ['tel_no' => '0890123456', 'amount' => 1225.00],
    ['tel_no' => '0801234567', 'amount' => 3500.75]
  ];

  foreach ($mockup_data as $list) {
  ?>
    <tr class="cursor-pointer" <?php Tiwdal::register('modal_detail', $list); ?>>
      <td nowrap class="text-white">
        <div>
          <?= substr($list['tel_no'], 0, -4) . 'XXXX'; ?>
        </div>
      </td>
      <td nowrap class="text-end text-white"><?= number_format($list['amount'], 2); ?></td>
    </tr>
  <?php } ?>
</tbody>