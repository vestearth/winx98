<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$customer_id = $_GET['user_id'];
$where = [
  'user_id' => $customer_id,
  // 'game_name' => $_POST['game_name'],
  'transaction_date' => $_POST['transaction_date'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : [
    'transaction_date_time' => 'DESC',
  ]
];

$data_list = nga_api_seamless_sbobet::selectBetSbobetHistory($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($list as $data_history) {
  ?>
    <tr>
      <td nowrap class="thin-cell"><?= Aww::formatDate($data_history['transaction_date_time'], 'd/m/Y'); ?></td>
      <td nowrap class="thin-cell"><?= Aww::formatDate($data_history['transaction_date_time'], 'H:i'); ?></td>
      <td nowrap><?= 'SBOBET' ?></td>
      <td nowrap><?= $data_history['round_id'] ?></td>
      <td nowrap><?= number_format($data_history['amount'], 2) ?></td>
      <td nowrap class="thin-cell font-SemiBold">
        <?php if ($data_history['result']) { ?>
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
        <?php } else { ?>
          <div class="min-w-300px text-secondary">
            <?= '-' ?>
          </div>
        <?php } ?>
      </td>
      <td>
        <?php
        if ($data_history['result']) {
          echo '<div class="min-w-300px text-info">
        ออกผล
      </div>';
        } else {
          echo  '<div class="min-w-300px text-secondary">
        รอผล
      </div>';
        }
        ?>
      </td>
      <td nowrap>
        <form method="post">
          <input type="hidden" name="id_sbo" value="<?= $data_history['id'] ?>">
          <button type="submit" name="submit_detail_sbo" class="btn btn-primary btn-sm">ดูรายละเอียด</button>
        </form>
      </td>
    </tr>
  <?php } ?>
</tbody>