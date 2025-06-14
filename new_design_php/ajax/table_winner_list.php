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
    ['tel_no' => '123456', 'amount' => 150000.00, 'rate' => 30, 'game' => 'สล็อต Lucky Gems'],
    ['tel_no' => '789012', 'amount' => 120000.00, 'rate' => 30, 'game' => 'บาคาร่า LiveVIP'],
    ['tel_no' => '345678', 'amount' => 95500.00, 'rate' => 30, 'game' => 'รูเล็ต European'],
    ['tel_no' => '901234', 'amount' => 80000.00, 'rate' => 30, 'game' => 'เกมยิงปลา Shark Bay'],
    ['tel_no' => '567890', 'amount' => 65000.00, 'rate' => 30, 'game' => 'สล็อต Mega Fortune'],
    // ['tel_no' => '0867890123', 'amount' => 4100.00],
    // ['tel_no' => '0878901234', 'amount' => 675.50],
    // ['tel_no' => '0889012345', 'amount' => 2950.25],
    // ['tel_no' => '0890123456', 'amount' => 1225.00],
    // ['tel_no' => '0801234567', 'amount' => 3500.75]
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
      <td nowrap width="25%" class="text-end text-white"><?= $list['rate']; ?>%</td>
      <td nowrap class="text-white"><?= $list['game']; ?></td>
    </tr>
  <?php } ?>
</tbody>