<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'friend_invite_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'username' => $_POST['username'],
  'bank_name' => $_POST['bank_name'],
  'downline_count' => $_POST['downline_count'],
  // 'count_downline_deposit_firsttime' => $_POST['count_downline_deposit_firsttime'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$user_customer = nga_statistic::selectSummaryUserDownline($code, $where, $options);
$data_list = isset($user_customer['list']) ? $user_customer['list'] : [];
$total_count = isset($user_customer['total_count']) ? $user_customer['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2 border-table">
  <?php
  foreach ($data_list as $list) {
    if ($list['bank_name'] == 'ยอดรวม') {
  ?>
      <tr>
        <td nowrap colspan='2' class="text-white text-right bg-blue-1">ยอดรวม</td>
        <td nowrap class="bg-blue-2 text-right"><?= number_format($list['downline_count'], 0); ?></td>
        <td nowrap class="bg-blue-2 text-right"><?= number_format($list['count_downline_deposit_firsttime'], 0); ?></td>
      </tr>
    <?php } else { ?>
      <tr class="tr-link cursor-pointer" data-link="customer_details.php?c=<?= $code ?>&id=<?= $list['id'] ?>&page=6">
        <td nowrap class=""><?= hidePhoneNumber($list['username']); ?></td>
        <td nowrap class=""><?= $list['bank_name']; ?></td>
        <td nowrap class="text-right"><?= number_format($list['downline_count'], 0); ?></td>
        <td nowrap class="text-right"><?= number_format($list['count_downline_deposit_firsttime'], 0); ?></td>
        <!-- <td nowrap colspan='4' class="text-center">ไม่มีข้อมูล</td> -->
      </tr>
  <?php }
  } ?>

</tbody>