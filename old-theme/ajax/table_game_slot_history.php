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
  'page_size'   =>  $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$call_api = nga_management::selectRandomSlotHistory($code, $where, $options);
$list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($list as $game_slot_history) { ?>
    <tr>
      <td class="text-white"><?= Aww::formatDate($game_slot_history['insert_date_time'], 'd/m/Y, H:i'); ?></td>
      <td class="text-white text-nowrap">
        <?php if ($game_slot_history['recive_type'] == 'reward') { ?>
          <?= Ty::get('special') ?>
        <?php } else {
          if ($game_slot_history['recive_type'] == 'credit') {
            $unit = Ty::get('credit');
          } else if ($game_slot_history['recive_type'] == 'point') {
            $unit = Ty::get('point');
          }
        ?>
          <?= number_format($game_slot_history['recive_amount'], 2) . ' ' . $unit; ?>
        <?php } ?>
      </td>
      <td class="text-end">
        <?php if ($game_slot_history['status'] == 'confirm') {
          echo '<span class="text-success">' . Ty::get('creditreceived', [], ["case" => "ucfirst"]) . '</span>';
        } else {
          echo '<span class="text-danger">' . Ty::get('credit_not', [], ["case" => "ucfirst"]) . '</span>';
        }
        ?>

      </td>
    </tr>
  <?php } ?>
</tbody>