<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'bot_statement_log'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'insert_date' => $_POST['insert_date'],
  'bot_name' => $_POST['bot_name'],
  'log_text' => $_POST['log_text'],
];
$code = $_GET['c'];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$call_api = nga_management_bot::selectBotLog($code, $where, $options);
$data_list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;
// Aww::display($data_list);
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($data_list as $bot_log) { ?>
    <tr>
      <td nowrap>
        <?php
        echo Aww::formatDate($bot_log['insert_date_time'], 'd/m/Y H:i');
        ?>
      </td>
      <td> <?= $bot_log['bot_name']; ?> </td>
      <td> <?= $bot_log['log_text']; ?> </td>
    </tr>
  <?php } ?>
</tbody>