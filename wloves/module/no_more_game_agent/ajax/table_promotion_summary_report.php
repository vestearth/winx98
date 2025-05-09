<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'promotion_summary_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$formula_type = isset($_GET['formula_type']) ? $_GET['formula_type'] : '';
$where = [
  'from_date' => isset($_GET['from_date']) ? $_GET['from_date'] : '',
  'to_date' => isset($_GET['to_date']) ? $_GET['to_date'] : '',
  'promotion_id' => isset($_GET['cal_type']) ? $_GET['cal_type'] : '',
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$data_list = nga_statistic::selectSummaryPromotion($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2 border-table">
  <tr>
    <td nowrap colspan='3' class="text-white font-SemiBold text-center bg-blue-1">ยอดรวม</td>
    <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($data_list[0]['user_bank_name'], 0); ?> ราย</td>

    <?php if ($formula_type == 'deposit') { ?>
      <td nowrap class="text-right bg-blue-2 font-SemiBold">
        <?= number_format($data_list[0]['deposit_amount'], 2); ?>
      </td>
    <?php } else if ($formula_type == 'excess_lost') { ?>

      <td nowrap class="text-right bg-blue-2 font-SemiBold thin-cell"><?= number_format($data_list[0]['current_excess_lost'], 2); ?>
      </td>
    <?php } else if ($formula_type == 'play_game') { ?>
      <td nowrap class="text-right bg-blue-2 font-SemiBold thin-cell">
        <?= number_format($data_list[0]['game_play_count'], 2); ?>
      </td>
    <?php } else if ($formula_type == 'birthday') { ?>
      <td nowrap class="text-right bg-blue-2 font-SemiBold thin-cell">
      </td>
    <?php } ?>

    <td nowrap class="text-right bg-blue-2 font-SemiBold thin-cell"><?= number_format($data_list[0]['credit_point_receive'], 2); ?></td>
  </tr>
  <?php
  if (isset($data_list['list'])) {
    foreach ($data_list['list'] as $promotion_list) { ?>
      <tr class="tr-link cursor-pointer" data-link="customer_details.php?c=<?= $code ?>&id=<?= $promotion_list['user_id'] ?>&page=1">
        <td nowrap class="font-SemiBold "><?= Aww::formatDate($promotion_list['user_register_date_time'], 'd/m/Y'); ?></td>
        <td nowrap class="font-SemiBold "><?= Aww::formatDate($promotion_list['insert_date_time'], 'd/m/Y'); ?></td>
        <td nowrap class="font-SemiBold "><?= hidePhoneNumber($promotion_list['username']); ?></td>
        <td nowrap class="font-SemiBold"><?= $promotion_list['user_bank_name']; ?></td>
        <?php if ($formula_type == 'deposit') { ?>
          <td nowrap class="text-right font-SemiBold"><?= number_format($promotion_list['deposit_amount'], 2); ?></td>
        <?php } else if ($formula_type == 'excess_lost') { ?>
          <td nowrap class="text-right font-SemiBold"><?= number_format($promotion_list['current_excess_lost'], 2); ?></td>
        <?php } else if ($formula_type == 'play_game') { ?>
          <td nowrap class="text-right font-SemiBold"><?= number_format($promotion_list['game_play_count'], 0); ?></td>
        <?php } else if ($formula_type == 'birthday') { ?>
          <td nowrap class="text-right font-SemiBold"><?= Aww::formatDate($promotion_list['insert_date_time'], 'd/m/Y'); ?></td>
        <?php } ?>
        <td nowrap class="text-right font-SemiBold"><?= number_format($promotion_list['credit_point_receive'], 2); ?></td>
      </tr>
    <?php }
  } else { ?>
    <tr>
      <td colspan="5" class="text-center">ไม่มีข้อมูล</td>
    </tr>
  <?php } ?>
</tbody>