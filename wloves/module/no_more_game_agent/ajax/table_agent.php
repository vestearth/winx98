<?php
$_PAGE['permission'] = ['no_more_game_agent', 'agent', 'agent'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_agent::selectSummaryAgentList($code, $where, $options);
$list_agent = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2">
  <?php
  foreach ($list_agent as $list) {
    if ($list['agent_name'] == 'ยอดรวม') {
  ?>
      <tr>
        <td nowrap class="text-white text-right bg-blue-1 font-SemiBold"><?= $list['agent_name']; ?></td>
        <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($list['user_count']); ?></td>
        <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($list['user_first_time_deposit'], 2); ?></td>
        <td nowrap class="text-right bg-blue-2 font-SemiBold">
          <?php if ($list['total_lose'] > 0) {
            $style_user = 'text-success';
          } else {
            $style_user = 'text-danger';
          } ?>
          <span class="<?= $style_user ?>">
            <?= number_format($list['total_lose'], 2); ?>
          </span>
        </td>
        <td nowrap class="text-right bg-blue-2 font-SemiBold">
          <?= number_format($list['agent_downline_count']); ?>
        </td>
        <td nowrap class="text-right bg-blue-2 font-SemiBold">
          <?php if ($list['percent_commission']) {
            echo number_format($list['percent_commission']) . '%';
          } ?>
        </td>
        <td nowrap class="text-right bg-blue-2 font-SemiBold">
          <?php if ($list['total_income'] > 0) {
            $style_total = 'text-success';
          } else {
            $style_total = 'text-danger';
          } ?>
          <span class="<?= $style_total; ?>"><?= number_format($list['total_income'], 2); ?></span>
        </td>
        <td nowrap class="text-right bg-blue-2 pl-50px font-SemiBold"></td>
        <td nowrap class="bg-blue-2 font-SemiBold"></td>
      </tr>
    <?php } else { ?>
      <tr class="tr-link cursor-pointer" data-link="agent_detail.php?c=<?= $code ?>&id=<?= $list['id'] ?>">
        <td nowrap class="font-SemiBold"> <?= $list['agent_name']; ?></td>
        <td nowrap class="text-right "><?= number_format($list['user_count']); ?></td>
        <td nowrap class="text-right "><?= number_format($list['user_first_time_deposit']); ?></td>
        <td nowrap class="text-right">
          <?php if ($list['total_lose'] > 0) {
            $style_user = 'text-success';
          } else {
            $style_user = 'text-danger';
          } ?>
          <span class="<?= $style_user ?>">
            <?= number_format($list['total_lose'], 2); ?>
          </span>
        </td>
        <td nowrap class="text-right "> <?= number_format($list['agent_downline_count']); ?></td>
        <td nowrap class="text-right ">
          <?php if ($list['percent_commission']) {
            echo number_format($list['percent_commission']) . '%';
          } ?>
        </td>
        <td nowrap class="text-right text-success ">
          <?php if ($list['total_income'] > 0) {
            $style_total = 'text-success';
          } else {
            $style_total = 'text-danger';
          } ?>
          <span class="<?= $style_total; ?>"><?= number_format($list['total_income'], 2); ?></span>
        </td>
        <td nowrap class=""><?= $list['status_remark']; ?></td>
        <td nowrap class="">
          <div class="text-right svg-py-auto size-30px"><?= file_get_contents('../assets/icon/icon-arrow-right.svg') ?></div>
        </td>
      </tr>
  <?php }
  } ?>


</tbody>