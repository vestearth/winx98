<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$customer_id = $_GET['user_id'];
$where = [
  'user_id' => $customer_id,
  'game_name' => $_POST['game_name'],
  'transaction_date' => $_POST['transaction_date'],
  // 'money_diff' => $_POST['money_diff'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : [
    'transaction_date_time' => 'DESC',
  ]
];

$data_list = nga_user::selectUserBetHistory($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($list as $data_history) { ?>
    <tr>
      <td nowrap class="thin-cell"><?= Aww::formatDate($data_history['transaction_date_time'], 'd/m/Y'); ?></td>
      <td nowrap class="thin-cell"><?= Aww::formatDate($data_history['transaction_date_time'], 'H:i'); ?></td>
      <td nowrap><?= $data_history['game_name']; ?></td>
      <td nowrap class="thin-cell ">
        <?php if ($data_history['result'] == 'win') { ?>
          <div class="min-w-300px text-success">
            +<?= number_format($data_history['money_diff'], 2) ?>
          </div>
        <?php } else if ($data_history['result'] == 'lose') { ?>
          <div class="min-w-300px text-danger">
            -<?= number_format($data_history['money_diff'], 2) ?>
          </div>
        <?php } else { ?>
          <div class="min-w-300px text-secondary">
            <?= number_format($data_history['money_diff'], 2) ?>
          </div>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>