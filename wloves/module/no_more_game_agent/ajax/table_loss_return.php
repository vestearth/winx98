<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'user_username' => $_POST['user_username'],
  'user_bank_name' => $_POST['user_bank_name'],
  'turn_over_date' => $_POST['turn_over_date'],
  'sum_loss_amount' => $_POST['sum_loss_amount'],
  'sum_turn_over' => $_POST['sum_turn_over'],
  'sum_turn_over_received' => $_POST['sum_turn_over_received'],
  'sum_turn_over_outstanding' => $_POST['sum_turn_over_outstanding'],
  'status' => $_POST['status'],
];
if ($_POST['status'] == 'all') {
  unset($where['status']);
}
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['turn_over_date' => 'DESC']
];

$data_list = nga_user::selectUserTurnOver($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
?>
<tbody data-total_count="<?= $total_count ?> ">
  <?php foreach ($list as $key => $data) { ?>
    <tr>
      <td nowrap><?= Aww::formatDate($data['turn_over_date'], 'd/m/Y'); ?></td>
      <td nowrap><?= hidePhoneNumber($data['user_username']) ?></td>
      <td nowrap class="text-primary"><?= $data['user_bank_name'] ?></td>
      <td nowrap class="thin-cell text-right "><?= number_format($data['sum_loss_amount'], 2) ?></td>
      <td nowrap class="text-right"><?= number_format($data['sum_turn_over'], 2) ?></td>
      <td nowrap class="text-right"><?= number_format($data['sum_turn_over_received'], 2) ?></td>
      <td nowrap class="text-right"><?= number_format($data['sum_turn_over_outstanding'], 2) ?></td>
      <td nowrap class="thin-cell">
        <div class="form-row pr-40px">
          <div class="col-2">
            <div class=' pr-10px'>
              <?php
              if ($data['status'] == 'wait_confirm') {
                echo  file_get_contents("./../assets/icon/icon-dot-yellow.svg");
              } else if ($data['status'] == 'confirm') {
                echo  file_get_contents("./../assets/icon/icon-dot-green.svg");
              } else if ($data['status'] == 'cancel') {
                echo  file_get_contents("./../assets/icon/icon-dot-red.svg");
              }
              ?>
            </div>
          </div>
          <div class="col-10">
            <div class="pl-5px">
              <?php
              if ($data['status'] == 'wait_confirm') {
                echo  'รอรับ (เงินสด)';
              } else if ($data['status'] == 'confirm') {
                echo  'ได้รับแล้ว (เงินสด)';
              } else if ($data['status'] == 'cancel') {
                echo  'ยอดเงินไม่ได้กดรับ';
              }
              ?>
            </div>
          </div>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>