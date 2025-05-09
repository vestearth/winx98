<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'user_id' => $_GET['id'],
];

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];
$call_api = nga_management::selectRandomSlotHistory($code, $where, $options);
$list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($list as $game_card_history) { ?>
    <tr>
      <td class=""><?= Aww::formatDate($game_card_history['insert_date_time'], 'd/m/Y, H:i'); ?></td>
      <td class=" text-nowrap">
        <?php if ($game_card_history['recive_type'] == 'reward') { ?>
          รางวัลพิเศษ
        <?php } else {
          if ($game_card_history['recive_type'] == 'credit') {
            $unit = 'เครดิต';
          } else if ($game_card_history['recive_type'] == 'point') {
            $unit = 'แต้ม';
          }
        ?>
          <?= 'ได้รับ ' . number_format($game_card_history['recive_amount'], 2) . ' ' . $unit; ?>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>