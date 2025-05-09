<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'redemption'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'insert_date' => $_POST['insert_date'],
  'reward_name' => $_POST['reward_name'],
  'username' => $_POST['username'],
  'bank_name' => $_POST['bank_name'],
  'status' => $_POST['status'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];
if ($_POST['status'] == 'all') {
  // unset($where['status']);
  $where['status'] = ['confirm', 'rejected'];
}
$data_list = nga_user::selectUserRedemtionHistory($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;

?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data_reward) {
    $data_reward['date_data'] = Aww::formatDate($data_reward['insert_date_time'], 'd/m/Y,H:i');
    $data_reward['status_send'] = 'confirm';

    $data_reward['username'] = hidePhoneNumber($data_reward['username']);
  ?>
    <tr>
      <td nowrap>
        <div><?= Aww::formatDate($data_reward['insert_date_time'], 'd/m/Y,H:i'); ?></div>
      </td>
      <td nowrap>
        <?= $data_reward['reward_name']; ?>
      </td>
      <td nowrap class="thin-cell ">
        <div class="pr-15px">
          <?= $data_reward['username']; ?>
        </div>
      </td>
      <td nowrap class="text-primary">
        <?= $data_reward['bank_name']; ?>
      </td>
      <td nowrap class="text-right">
        <?= number_format($data_reward['point_before'], 0); ?>
      </td>
      <td nowrap class="text-right">
        <?= number_format($data_reward['point_use'], 0); ?>
      </td>
      <td nowrap class="text-right">
        <?= number_format($data_reward['point_after'], 0); ?>
      </td>
      <td nowrap class="">
        <?php if ($data_reward['status'] == 'wait_confirm') { ?>
          <div class="form-row pr-30px">
            <div class="col-2">
              <?= file_get_contents("./../assets/icon/icon-dot-yellow.svg"); ?>
            </div>
            <div class="col-10">รอยืนยัน</div>
          </div>
        <?php } else if ($data_reward['status'] == 'confirm') { ?>
          <div class="form-row pr-30px">
            <div class="col-2">
              <?= file_get_contents("./../assets/icon/icon-dot-green.svg"); ?>
            </div>
            <div class="col-10">ยืนยันแล้ว</div>
          </div>
        <?php } else if ($data_reward['status'] == 'rejected') { ?>
          <div class="form-row pr-30px">
            <div class="col-2">
              <?= file_get_contents("./../assets/icon/icon-dot-red.svg"); ?>
            </div>
            <div class="col-10">ยกเลิก</div>
          </div>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>