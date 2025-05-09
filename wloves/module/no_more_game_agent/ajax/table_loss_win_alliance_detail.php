<?php
$_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'loss_win_alliance'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$alliance_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : null;
$insert_date = (isset($_GET['date_data']) && $_GET['date_data']) ? $_GET['date_data'] : null;

$where = [
  'alliance_id' => $alliance_id,
  'first_time_deposit_date' => $insert_date,
  'username' => $_POST['username'],
  'bank_name' => $_POST['bank_name'],
  'first_time_deposit' => $_POST['first_time_deposit'],
  'count_deposit_time' => $_POST['count_deposit_time'],
  'is_have_last_online' => $_POST['is_have_last_online'],
  // 'first_time_deposit_date' => $_POST['first_time_deposit_date'],
  // 'sum_deposit' => $_POST['sum_deposit'],
];
if ($_POST['is_have_last_online'] == 'all') {
  unset($where['is_have_last_online']);
}
$options = [
  'total_count' => true,
  'sum_deposit' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_user::selectUser($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$slicedArray = array_slice($list, 1);
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;

?>
<tbody data-total_count="<?= $total_count; ?>">
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td class="text-right font-Bold font-16px text-primary"><?= number_format($list['list'][0]['sum_all_first_time_deposit'], 2) ?></td>
    <td></td>
    <td class="text-right font-Bold font-16px text-primary"><?= number_format($list['list'][0]['sum_count_deposit_time'], 0) ?></td>
    <td class="text-right font-Bold font-16px text-primary"><?= number_format($list['list'][0]['sum_all_deposit'], 2) ?></td>
    <td class="text-right font-Bold font-16px text-primary"><?= number_format($list['list'][0]['sum_all_win_lost'], 2) ?></td>
    <td></td>
  </tr>
  <?php foreach ($list['list'] as $key => $ally_data) {
    if ($key != 0) {
  ?>
      <tr>
        <td nowrap>
          <div><?= $ally_data['username']; ?></div>
        </td>
        <td nowrap>
          <div><?= Aww::formatDate($ally_data['insert_date_time'], 'd/m/Y'); ?></div>
        </td>
        <td nowrap class="text-primary"><?= $ally_data['bank_name']; ?></td>
        <td nowrap class="text-right"><?= number_format($ally_data['first_time_deposit'], 2); ?></td>
        <td nowrap class="text-right"><?= ($ally_data['first_time_deposit'] == 0) ? '-' : Aww::formatDate($ally_data['first_time_deposit_date'], 'd/m/Y') ?>
        </td>
        <td nowrap class="text-right"><?= number_format($ally_data['count_deposit_time'], 0); ?></td>
        <td nowrap class="text-right"><?= number_format($ally_data['sum_deposit'], 2); ?></td>
        <?php
        if ($ally_data['sum_win_lost'] >= 1) {
          $style_td = 'text-success';
        } else if ($ally_data['sum_win_lost'] < 0) {
          $style_td = 'text-danger';
        } else {
          $style_td = '';
        }
        ?>
        <td nowrap class="<?= $style_td; ?> text-right">
          <?= number_format($ally_data['sum_win_lost'], 2); ?>
          </span>
        </td>
        <td nowrap>
          <div class="d-flex align-items-center">
            <?php if ($ally_data['is_have_last_online']) { ?>
              <?= file_get_contents('../assets/icon/icon-circle-green.svg') ?>
              <span class="ml-5px">Active</span>
            <?php } else { ?>
              <?= file_get_contents('../assets/icon/icon-circle-red.svg') ?>
              <span class="ml-5px">Non Active</span>
            <?php } ?>
          </div>
        </td>
      </tr>
  <?php }
  } ?>
</tbody>