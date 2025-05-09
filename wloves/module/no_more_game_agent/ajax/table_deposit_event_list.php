<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'promotion_summary_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'event_id' => isset($_GET['event_id']) ? $_GET['event_id'] : '',
  'username' => isset($_POST['username']) ? $_POST['username'] : '',
  'user_bank_name' => isset($_POST['user_bank_name']) ? $_POST['user_bank_name'] : '',
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$data_list = nga_statistic::selectSummaryEventDeposit($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2 border-table">
  <?php
  if (isset($list)) {
    foreach ($list as $event_list) { ?>
      <?php if ($event_list['username'] == 'ยอดรวม') { ?>
        <tr>
          <td nowrap class="text-white font-SemiBold text-right bg-blue-1">ยอดรวม</td>
          <td nowrap colspan='4' class="text-right bg-blue-2 font-SemiBold"><?= number_format($event_list['sum_deposit_event_amount'], 2); ?></td>
        </tr>
      <?php } else { ?>
        <tr>
          <td nowrap class="font-SemiBold"><?= hidePhoneNumber($event_list['username']); ?></td>
          <td nowrap class="font-SemiBold "><?= $event_list['user_bank_name']; ?></td>
          <td nowrap class="text-right font-SemiBold">
            <?php if ($event_list['status'] == 'ได้โบนัสแล้ว') { ?>
              <span class="text-success">
                <?= number_format($event_list['count_pass_condition'], 0); ?>
              </span>
              /
              <?= number_format($event_list['count_compare_date'], 0); ?>
            <?php } else if ($event_list['status'] == 'กำลังฝากต่อเนื่อง') { ?>
              <span class="text-primary">
                <?= number_format($event_list['count_pass_condition'], 0); ?>
              </span>
              /
              <?= number_format($event_list['count_compare_date'], 0); ?>
            <?php } else if ($event_list['status'] == 'ตัดสิทธิ์แล้ว') { ?>
              <span class="text-danger">
                <?= number_format($event_list['count_pass_condition'], 0); ?>
              </span>
              /
              <?= number_format($event_list['count_compare_date'], 0); ?>
            <?php } ?>
          </td>
          <td nowrap class="font-SemiBold">
            <?php if ($event_list['status'] == 'ได้โบนัสแล้ว') { ?>
              <div class="d-flex align-items-center">
                <img src="assets/icon/icon-dot-green.svg" class="mr-5px">
                <span>ได้โบนัสแล้ว</span>
              </div>
            <?php } else if ($event_list['status'] == 'กำลังฝากต่อเนื่อง') { ?>
              <div class="d-flex align-items-center">
                <img src="assets/icon/icon-dot-blue.svg" class="mr-5px">
                <span>กำลังฝากต่อเนื่อง</span>
              </div>
            <?php } else if ($event_list['status'] == 'ตัดสิทธิ์แล้ว') { ?>
              <div class="d-flex align-items-center">
                <img src="assets/icon/icon-dot-red.svg" class="mr-5px">
                <span>ตัดสิทธิ์แล้ว</span>
              </div>
            <?php } ?>
          </td>
          <td nowrap class="text-right font-SemiBold"><?= number_format($event_list['sum_deposit_event_amount'], 2); ?></td>
        </tr>
      <?php } ?>
    <?php }
  } else { ?>
    <tr>
      <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
    </tr>
  <?php } ?>
</tbody>