<?php
$_PAGE['permission'] = ['no_more_game_agent', 'agent', 'agent'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$agent_id = $_GET['agent_id'];
$where = [
  'insert_date' => $_POST['insert_date'],
  'status' => $_POST['status'],
  'from_date' => $from_date,
  'to_date' => $to_date,
];
if ($_POST['status'] == 'all') {
  unset($where['status']);
}
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$data_list = nga_agent::selectCommissionBill($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2">
  <?php foreach ($list as $commission_bill) { ?>
    <tr class="tr-link cursor-pointer" data-link="history_detail.php?c=<?= $code ?>&id=<?= $commission_bill['id'] ?>&from_date=<?= $from_date; ?>&to_date=<?= $to_date; ?>&agent_id=<?= $agent_id; ?>">
      <td nowrap>
        <?php if ($commission_bill['status'] == 'waiting') {
          $status_colour = 'text-warning';
          $status_text = 'รอชำระเงิน';
        } else if ($commission_bill['status'] == 'completed') {
          $status_colour = 'text-success';
          $status_text = 'ชำระเงินแล้ว';
        } else {
          $status_colour = 'text-danger';
          $status_text = 'ยกเลิก';
        } ?>
        <span class="<?= $status_colour; ?>">
          <?= $status_text; ?>
        </span>
      </td>
      <td nowrap><?= Aww::formatDate($commission_bill['insert_date_time'], 'd/m/Y H:i'); ?></td>
      <td nowrap class="text-right text-success font-Bold font-18px">
        <?php
        if ($commission_bill['sum_income'] > 0) {
          echo number_format($commission_bill['sum_income'], 2);
        } else {
          echo '-';
        }
        ?>
      </td>
      <td nowrap class="text-right text-danger font-Bold font-18px">
        <?php
        if ($commission_bill['sum_loss'] > 0) {
          echo number_format($commission_bill['sum_loss'], 2);
        } else {
          echo '-';
        }
        ?>
      </td>
    </tr>
  <?php } ?>
</tbody>