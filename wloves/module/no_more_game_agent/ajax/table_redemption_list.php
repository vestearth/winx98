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
  'status' => 'wait_confirm',
];
// if ($_POST['status'] == 'all') {
//   unset($where['status']);
// }
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];

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
    <?php if ($data_reward['status'] == 'wait_confirm') { ?>

      <!-- <tr class="cursor-pointer" <?= Tiwdal::register('detail', $data_reward); ?>> -->
      <tr>
      <?php } else { ?>
      <tr class="cursor-pointer">
      <?php } ?>
      <td class="disabled-link">
        <?php
        if ($data_reward['status'] == 'wait_confirm') {
          Homepagify::createCheckboxTBody('checkbox_' . $data_reward['id'], $data_reward['id'], ['data-id' => $data_reward['id']]);
        }
        ?>
      </td>
      <td nowrap>
        <div><?= Aww::formatDate($data_reward['insert_date_time'], 'd/m/Y,H:i'); ?></div>
      </td>
      <td nowrap>
        <?= $data_reward['reward_name']; ?>
      </td>
      <td nowrap class="thin-cell ">
        <div class="pr-15px">
          <?= hidePhoneNumber($data_reward['username']); ?>
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
      </tr>
    <?php } ?>
</tbody>