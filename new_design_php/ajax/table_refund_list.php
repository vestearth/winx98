<?php
require_once '../.framework/import.php';
Structure::loadMetaForAjax('../');
$code = Aww::API_CODE['winx'];
$user_data = User::getCurrent();
$where = [
  'user_id' => $user_data['id'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : [
    'turn_over_date' => 'DESC'
  ]
];

$user_turnover = nga_user::selectUserTurnOver($code, $where, $options);
$data_list = isset($user_turnover['list']) ? $user_turnover['list'] : [];
$total_count = isset($user_turnover['total_count']) ? $user_turnover['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($data_list as $list) { ?>
    <tr>
      <td nowrap class="text-white">
        <div>
          <?php echo Aww::formatDate($list['turn_over_date'], 'd/m/Y, H:i'); ?>
        </div>
      </td>
      <td nowrap class="text-end text-white"><?= number_format($list['sum_turn_over'], 2); ?></td>
      <td nowrap class="text-center">
        <?php if ($list['status'] == 'confirm') { ?>
          <div class="text-success text-end">
            <?= Ty::get('creditreceived', [], ["case" => "ucfirst"]) ?>
          </div>
        <?php } else if ($list['status'] == 'cancel') { ?>
          <div class="text-danger text-end">
            <?= Ty::get('cancel', [], ["case" => "ucfirst"]) ?>
          </div>
        <?php } else { ?>
          <div class="text-warning text-end">
            <?= Ty::get('waitingtobeprocessed', [], ["case" => "ucfirst"]) ?>
          </div>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>