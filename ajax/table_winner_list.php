<?php
require_once '../.framework/import.php';
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
<?php

// ตัวอย่างข้อมูลใหม่: ยอดรับไม่ลงท้ายด้วย 000, อัตราชนะ % สลับกัน
$mockup_data = [
  ['no' => 1, 'tel_no' => '0867890123', 'amount' => 153420.75, 'rate' => 25, 'game' => 'Royal 777'],
  ['no' => 2, 'tel_no' => '0878901234', 'amount' => 121580.50, 'rate' => 30, 'game' => 'Fortune Gems 4'],
  ['no' => 3, 'tel_no' => '0889012345', 'amount' => 95820.25,  'rate' => 20, 'game' => 'Dancing Lion'],
  ['no' => 4, 'tel_no' => '0890123456', 'amount' => 80310.90,  'rate' => 30, 'game' => 'Shark Bay'],
  ['no' => 5, 'tel_no' => '0801234567', 'amount' => 65235.60,  'rate' => 15, 'game' => 'Mega Fortune'],
  ['no' => 6, 'tel_no' => '0812345678', 'amount' => 60210.80,  'rate' => 30, 'game' => 'Baccarat Deluxe'],
  ['no' => 7, 'tel_no' => '0823456789', 'amount' => 55345.10,  'rate' => 20, 'game' => 'Dragon Tiger'],
  ['no' => 8, 'tel_no' => '0834567890', 'amount' => 50780.55,  'rate' => 25, 'game' => 'Sic Bo'],
  ['no' => 9, 'tel_no' => '0845678901', 'amount' => 45790.35,  'rate' => 30, 'game' => 'Blackjack'],
  ['no' => 10, 'tel_no' => '0856789012', 'amount' => 40123.45,  'rate' => 20, 'game' => 'Poker Holdem'],
];
?>
<tbody data-total_count="10">
  <?php foreach ($mockup_data as $list) { ?>
    <tr class="cursor-pointer" <?php Tiwdal::register('modal_detail', $list); ?>>
      <td>
        <div class="text-left text-white"><?= $list['no']; ?></div>
      </td>
      <td nowrap class="text-white">
        <div>
          <?= substr($list['tel_no'], 0, -4) . 'XXXX'; ?>
        </div>
      </td>
      <td nowrap class="text-end text-white">
        <span class="blink-amount"><?= number_format($list['amount'], 2); ?></span>
      </td>
      <td nowrap width="25%" class="text-end text-white"><?= $list['rate']; ?>%</td>
      <td nowrap class="text-white"><?= $list['game']; ?></td>
    </tr>
  <?php } ?>
</tbody>
<style>
  @keyframes blink {
    0% {
      opacity: 1;
    }

    50% {
      opacity: 0.3;
    }

    100% {
      opacity: 1;
    }
  }

  .blink-amount {
    animation: blink 1.5s infinite;
    color: #ffd700;
    font-weight: bold;
  }
</style>