<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$customer_id = $_GET['user_id'];
$where = [
  'user_id' => $customer_id,
  'lotto_type' => $_POST['lotto_type'],
  'bet_type' => $_POST['bet_type'],
  'bet_date' => $_POST['bet_date'],
  'bet_number' => $_POST['bet_number'],
  'bet_amount' => $_POST['bet_amount'],
  'status' => $_POST['status'],
];
if ($_POST['lotto_type'] == 'all') {
  unset($where['lotto_type']);
}
if ($_POST['bet_type'] == 'all') {
  unset($where['bet_type']);
}
if ($_POST['status'] == 'all') {
  unset($where['status']);
}
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : [
    // 'transaction_date_time' => 'DESC',
    'bet_date_time' => 'DESC',
  ]
];
$key_type = [
  'thailotto' => 'หวยไทย',
  'laolotto' => 'หวยลาว',
  'hanoylotto' => 'หวยฮานอย',
  'hanoylottovip' => 'หวยฮานอย(วีไอพี)',
  'baaclotto' => 'หวย ธกส.',
  'gsblotto' => 'ออมสิน',
  'pingponglotto' => 'หวยปิงปอง',
  'laoslotto_set' => 'หวยลาว(แบบชุด)',
  'yeekeelotto' => 'หวยยี่กี',
  'malaylotto' => 'หวยมาเลย์',
  'hanoylotto_set' => 'หวยฮานอย(แบบชุด)',
  'hanoylottovip_set' => 'หวยฮานอยวีไอพี(แบบชุด)',
  'hanoylottospecial_set' => 'หวยฮานอยพิเศษ(แบบชุด)',
  'malaylotto_set' => 'หวยมาเลย์(แบบชุด)',
  'hanoylottospecial' => 'หวยฮานอย(พิเศษ)',
  'stockkorea' => 'หวยหุ้นเกาหลี',
  'stockchina' => 'หวยหุ้นจีน',
  'stockdowjones' => 'หวยหุ้นดาวโจนส์',
  'stocktaiwan' => 'หวยหุ้นไต้หวัน',
  'stockengland' => 'หวยหุ้นอังกฤษ',
  'stockindia' => 'หวยหุ้นอินเดีย',
  'stockhangseng' => 'หวยหุ้นฮั่งเส็ง',
  'stockegypt' => 'หวยหุ้นอียิปต์',
  'stocknikkei' => 'หวยหุ้นนิเคอิ',
  'stocksingapore' => 'หวยหุ้นสิงค์โปร',
  'stockthai' => '	หวยหุ้นไทย',
  'stockgerman' => 'หวยหุ้นเยอรมัน',
  'stockrussia' => 'หวยหุ้นรัสเซีย',
  'stock' => 'รวบหวยหุ้น(ใช้ประเภทนี้ในการตั้งค่าเท่านั้น)',
];

$key_bet_type = [
  'top6' => '6 ตัวบน',
  'top5' => '5 ตัวบน',
  'top4' => '4 ตัวบน',
  'top3' => '3 ตัวบน',
  'top2' => '2 ตัวบน',
  'top1' => '1 ตัวบน',
  'bottom1' => '1 ตัวล่าง',
  'bottom2' => '2 ตัวล่าง',
  'bottom3' => '3 ตัวล่าง',
  'row4' => '4 ตัวโต๊ด',
  'row3' => '3 ตัวโต๊ด',
  'row2' => '2 ตัวโต๊ด',
  'back2' => '2 ตัวหลัง',
  'front2' => '2 ตัวหน้า',
  'lottoset' => 'หวยชุด',
];

$data_list = nga_user::selectUserBetLottoHistory($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($list as $data_history) {
    $lotto_type = $key_type[$data_history['lotto_type']];
    $bet_type = $key_bet_type[$data_history['bet_type']];
    $round_lotto = (in_array($data_history['lotto_type'], ['pingponglotto', 'yeekeelotto']) ? $data_history['lotto_draw_name'] : '');
    if (in_array($data_history['lotto_type'], ['pingponglotto', 'yeekeelotto'])) {
      $parts = explode("Round", $round_lotto);
      $round_no = trim($parts[1]);
      $round = ' รอบที่ ' . $round_no;
    } else {
      $round = '';
    }
  ?>
    <tr>
      <td nowrap class="thin-cell"><?= Aww::formatDate($data_history['bet_date_time'], 'd/m/Y'); ?></td>
      <td nowrap class="thin-cell"><?= Aww::formatDate($data_history['bet_date_time'], 'H:i'); ?></td>
      <td nowrap><?= $lotto_type . $round; ?></td>
      <td nowrap><?= $bet_type; ?></td>
      <td nowrap><?= $data_history['bet_number']; ?></td>
      <td nowrap><?= number_format($data_history['bet_amount'], 2); ?></td>
      <td nowrap class="text-right font-14px font-Regular thin-cell">
        <?php if ($data_history['status'] == 'payout') { ?>
          <span class="">ออกผลแล้ว</span>
        <?php } else if ($data_history['status'] == 'pending') { ?>
          <span class="">รอผล</span>
        <?php } else if ($data_history['status'] == 'success') { ?>
          <span class="text-success">ได้รางวัล</span>
        <?php } else if ($data_history['status'] == 'cancel') { ?>
          <span class="text-danger">ยกเลิก</span>
        <?php } ?>
      </td>
      <td nowrap class="thin-cell ">
        <?php if ($data_history['status'] == 'success') { ?>
          <div class="min-w-300px text-success">
            <?= number_format($data_history['payout_amount'], 2) ?>
          </div>
        <?php } else { ?>
          <?php if ($data_history['result'] == 'win') { ?>
            <div class="min-w-300px text-success">
              +<?= number_format($data_history['money_diff'], 2) ?>
            </div>
          <?php } else if ($data_history['result'] == 'lose') { ?>
            <div class="min-w-300px text-danger">
              -<?= number_format($data_history['money_diff'], 2) ?>
            </div>
          <?php } else { ?>
            <div class="min-w-300px text-secondary">
              <?= number_format($data_history['money_diff'], 2) ?>
            </div>
        <?php }
        } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>