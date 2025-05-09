<?php
// $_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'summary_with_alliance'];
$_WLOVES['no_check_permission'] = 1;
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$alliance_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : null;
$count_deposit_time = (isset($_GET['count_deposit_time']) && $_GET['count_deposit_time']) ? $_GET['count_deposit_time'] : null;
$register_from_date = (isset($_GET['register_from_date']) && $_GET['register_from_date']) ? $_GET['register_from_date'] : null;
$register_to_date = (isset($_GET['register_to_date']) && $_GET['register_to_date']) ? $_GET['register_to_date'] : null;
// $deposit_from_date = (isset($_GET['deposit_from_date']) && $_GET['deposit_from_date']) ? $_GET['deposit_from_date'] : null;
// $deposit_to_date = (isset($_GET['deposit_to_date']) && $_GET['deposit_to_date']) ? $_GET['deposit_to_date'] : null;

$where = [
  'alliance_id' => $alliance_id,
  'count_deposit_time' => $count_deposit_time,
  'register_from_date' => $register_from_date,
  'register_to_date' => $register_to_date,
  // 'deposit_from_date' => $deposit_from_date,
  // 'deposit_to_date' => $deposit_to_date,
  'username' => $_POST['username'],
  'bank_name' => $_POST['bank_name'],
  'first_time_deposit' => $_POST['first_time_deposit'],
  'last_online_date_time' => $_POST['last_online_date_time'],
];

if ($_POST['last_online_date_time'] == 'all') {
  unset($where['last_online_date_time']);
}
$options = [
  'total_count' => true,
  'sum_deposit' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
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
    <td class="text-right font-Bold font-16px text-primary"><?= number_format($list[0]['sum_all_first_time_deposit'], 2) ?></td>
    <td></td>
    <td></td>
    <td class="text-right font-Bold font-16px text-primary"><?= number_format($list[0]['sum_all_deposit'], 2) ?></td>
    <td class="text-right font-Bold font-16px text-primary"><?= number_format($list[0]['sum_all_withdraw'], 2) ?></td>
    <td class="text-right font-Bold font-16px text-primary"><?= number_format($list[0]['sum_all_win_lost'], 2) ?></td>
    <td></td>
  </tr>
  <?php foreach ($slicedArray as $ally_data) {
  ?>
    <tr class="tr-link cursor-pointer" data-link="customer_details.php?c=<?= $code ?>&id=<?= $ally_data['id'] ?>&page=6">
      <td nowrap>
        <div><?= Aww::formatDate($ally_data['insert_date_time'], 'd/m/Y'); ?></div>
      </td>
      <td nowrap>
        <div><?= $ally_data['username']; ?></div>
      </td>
      <td nowrap class="text-primary"><?= $ally_data['bank_name']; ?></td>
      <td nowrap class="text-right"><?= number_format($ally_data['first_time_deposit'], 2); ?></td>
      <td nowrap>
        <?php if ($ally_data['first_time_deposit_date']) {
          echo Aww::formatDate($ally_data['first_time_deposit_date'], 'd/m/Y');
        } else {
          echo '-';
        }
        ?>
      </td>
      <td nowrap class="text-right"><?= number_format($ally_data['count_deposit_time'], 0); ?></td>
      <td nowrap class="text-right text-success"><?= number_format($ally_data['sum_deposit'], 2); ?></td>
      <td nowrap class="text-right text-danger"><?= number_format($ally_data['sum_withdraw'], 2); ?></td>
      <?php
      if ($ally_data['sum_win_lost'] >= 1) {
        $style_td = 'text-success';
      } else if ($ally_data['sum_win_lost'] < 0) {
        $style_td = 'text-danger';
      } else {
        $style_td = '';
      }
      ?>
      <td nowrap class="text-right <?= $style_td; ?>">
        <?= number_format($ally_data['sum_win_lost'], 2); ?>
      </td>
      <td nowrap>
        <div class="d-flex align-items-center">
          <?php if ($ally_data['last_online_date_time']) { ?>
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
  ?>
</tbody>