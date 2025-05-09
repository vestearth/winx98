<?php
$_WLOVES['no_check_permission'] = 1;
// $_PAGE['permission'] = ['no_more_game_agent', 'management', 'hold_money'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);

$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : 0;

$where = [
  'bot_name' => $_POST['bot_name'],
  'bank_account_no' => $_POST['bank_account_no'],
  'bank_abb' => 'KBANK',
];

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$bot_hold_money = nga_management_bot::selectBotHoldMoneyList($_GET['c'], $where, $options);
$data_list = isset($bot_hold_money['list']) ? $bot_hold_money['list'] : 0;
$total_count = isset($bot_hold_money['total_count']) ? $bot_hold_money['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($data_list as $bot_hold_money) { ?>
    <tr class="<?= ($id == $bot_hold_money['id']) ? 'active' : ''; ?>">
      <td class="text-primary font-SemiBold">
        <?= $bot_hold_money['bot_name']; ?>
      </td>
      <td class="">
        <div class="d-flex align-items-center">
          <div class="bank-img small-size mr-5px">
            <img src="<?= $bot_hold_money['bank_image']; ?>">
          </div>
          <div class="font-SemiBold"><?= $bot_hold_money['bank_name_th']; ?></div>
        </div>
        <div class="font-16px"><?= $bot_hold_money['bank_account_no']; ?></div>
        <div class="font-14px"><?= $bot_hold_money['bank_account_name']; ?></div>
      </td>
      <td class="py-5px px-5px thin-cell">
        <a href="?c=<?= $_GET['c'] ?>&id=<?= $bot_hold_money['id']; ?>" class="d-flex align-items-center justify-content-center w-35px h-80px">
          <?= file_get_contents('../assets/icon/icon-arrow-right.svg') ?>
        </a>
      </td>
    </tr>
  <?php } ?>
</tbody>