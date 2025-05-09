<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'bot_statement_log'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$id_select = isset($_GET['id']) ? $_GET['id'] : '';
$where = [
  'bot_name' => $_POST['bot_name'],
  'bank_account_name' => $_POST['bank_account_name'],
  // 'tel_no' => $_POST['tel_no'],
];
$code = $_GET['c'];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$call_api = nga_management_bot::selectBotGroupList($code, $where, $options);
$data_list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($data_list as $bot_statement) {
    if ($id_select == $bot_statement['id']) {
      $table_active = 'active';
    } else {
      $table_active = '';
    }
  ?>
    <tr class="tr-link cursor-pointer <?= $table_active; ?>" data-link="bot_statement_log.php?c=<?= $code; ?>&id=<?= $bot_statement['id']; ?>">
      <td nowrap>
        <div class="text-primary"><?= $bot_statement['bot_name']; ?></div>
      </td>
      <td nowrap class="">
        <div class="d-flex aligns-items-center">
          <div class="bank-img small-size">
            <img src="<?= $bot_statement['bank_image']; ?>">
          </div>
          <div class="ml-5px font-SemiBold"><?= $bot_statement['bank_name_th']; ?></div>
        </div>
        <p class="mb-0"><?= $bot_statement['bank_account_no']; ?></p>
        <p class="mb-0 text-secondary font-14px"><?= $bot_statement['bank_account_name']; ?></p>
        <p class="mb-0 text-secondary font-14px">ยอดคงเหลือ : <?= number_format($bot_statement['current_balance'], 2); ?></p>
      </td>
      <td><?= file_get_contents('../assets/icon/icon-arrow-right.svg'); ?> </td>
    </tr>
  <?php } ?>
</tbody>