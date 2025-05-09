<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'bot_statement_log'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$prefix = '../../../';
$code = $_GET['c'];
$id = isset($_GET['id']) ? $_GET['id'] : '';
$where = [
  'bot_group_list_id' => $id,
  'transaction_date' => $_POST['transaction_date'],
  'transaction' => $_POST['transaction'],
  'transaction_amount' => $_POST['transaction_amount'],
  'balance' => $_POST['balance'],
  'status' => $_POST['status'],
];

if ($_POST['transaction'] == 'all') {
  unset($where['transaction']);
}
if ($_POST['status'] == 'all') {
  unset($where['status']);
}

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['transaction_date_time' => 'DESC']
];
$call_api = nga_management_bot::selectBotStatement($code, $where, $options);
$data_list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;
// Aww::console($data_list);
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($data_list as $bot_statement) {
    $tr_style = '';
    $change_account = '';
    if ($bot_statement['transaction'] == 'change_account') {
      $tr_style = 'table-bot-change-acc';
      $change_account = 'd-none';
    }
    // explode transaction_from_bank_no keep only number 
    if ($bot_statement['transaction'] == 'deposit' && $bot_statement['status'] == 'wait_confirm') {
      // strreplace remove x 
      $bot_statement['transaction_from_bank_no_num'] = str_replace('x', '', $bot_statement['transaction_from_bank_no']);
      // if (preg_match('/(\d+)$/', $bot_statement['transaction_from_bank_no'], $matches)) {
      //   $numbers = $matches[1];
      //   $bot_statement['transaction_from_bank_no_num'] = $numbers;
      // } else {
      //   $bot_statement['transaction_from_bank_no_num'] = '';
      // }
    }



  ?>
    <tr class="<?= $tr_style; ?>">
      <td nowrap>
        <div class="">
          <?= isset($bot_statement['transaction_date_time']) ? Aww::formatDate($bot_statement['transaction_date_time'], 'd/m/Y H:i') : ''; ?>
        </div>
        <div class="text-primary <?= $change_account; ?>">
          <?php
          if ($bot_statement['update_status_date_time']) {
            echo Aww::formatDate($bot_statement['update_status_date_time'], 'd/m/Y H:i');
          }
          ?>
        </div>
      </td>
      <td nowrap class="">
        <?php if (isset($bot_statement['transaction'])) { ?>
          <?php if ($bot_statement['transaction'] == 'withdraw') { ?>
            <span class="text-danger">
              โอนอัตโนมัติ
            </span>
            <?php
            if ($bot_statement['ref_transaction'] == 'API_TRANSFER' && $bot_statement['status'] == 'wait_confirm') {
              echo '<span class="ml-5px">(โยกเงิน)</span>';
            }
            ?>
          <?php } else if ($bot_statement['transaction'] == 'deposit') { ?>
            <span class="text-success">
              ฝากเงิน
            </span>
            <?php
            if ($bot_statement['status'] == 'confirm') {
              // && $bot_statement['confirm_by'] == 'admin'
            ?>
              <p class="mb-0"><?= isset($bot_statement['customer_bank_abb']) ? $bot_statement['customer_bank_abb'] : '-'; ?></p>
              <p class="mb-0"> <?= isset($bot_statement['customer_bank_no']) ? $bot_statement['customer_bank_no'] : '-'; ?></p>
            <?php
            }
            ?>
            <p class="mb-0">
              <?php
              if ($bot_statement['status'] == 'wait_confirm') {
                echo isset($bot_statement['transaction_from_bank_no']) ? $bot_statement['transaction_from_bank_no'] : '-';
              }
              ?>
            </p>
            <?php
            if ($bot_statement['ref_transaction'] == 'API_TRANSFER' && $bot_statement['status'] == 'wait_confirm') {
              echo '<span class="ml-5px">(โยกเงิน)</span>';
            }
            ?>
          <?php } else { ?>
            <span class="">
              เปลี่ยนบัญชีธนาคาร
            </span>
        <?php }
        } ?>
      </td>
      <td nowrap class="thin-cell">
        <span class="<?= $change_account; ?>">
          <?= isset($bot_statement['transaction_amount']) ? number_format($bot_statement['transaction_amount'], 2) : ''; ?>
        </span>
      </td>
      <td nowrap class="thin-cell">
        <span class="<?= $change_account; ?>">
          <?= isset($bot_statement['balance']) ? number_format($bot_statement['balance'], 2) : ''; ?>
        </span>
      </td>
      <td class="thin-cell">
        <div class="d-flex align-items-center">
          <?php if ($bot_statement['status'] == 'wait_confirm') { ?>
            <span class="status-dot danger mr-5px"></span>
            <span>ไม่สำเร็จ</span>
          <?php } else if ($bot_statement['status'] == 'confirm') { ?>
            <span class="status-dot success mr-5px"></span>
            <span>สำเร็จแล้ว</span>
          <?php } else { ?>
            <span class="<?= $change_account; ?>"></span>
          <?php } ?>
        </div>
        <?php if ($bot_statement['confirm_by'] == 'bot') { ?>
          <img src="./assets/image/bot-auto.png" class="<?= $change_account; ?>">
        <?php } else if ($bot_statement['confirm_by'] == 'admin') { ?>
          <div class="d-flex align-items-center">
            <img src="./assets/icon/admin-icon.svg" class="<?= $change_account; ?>">
            <span class="text-primary font-14px font-Regular ml-5px"> Admin</span>
          </div>
        <?php } ?>
      </td>
      <td class="thin-cell align-middle">
        <div class="d-flex">
          <?php if ($bot_statement['status'] == 'wait_confirm' && $bot_statement['transaction'] == 'deposit') { ?>
            <div class="d-flex align-items-center">
              <div class="mr-5px btn-admin-danger cursor-pointer" <?= Tiwdal::register('deal_with', $bot_statement); ?>>
                <img src="assets/icon/icon-warning.svg">
              </div>
            </div>
          <?php } else if ($bot_statement['status'] == 'wait_confirm' && $bot_statement['transaction'] == 'withdraw' && $bot_statement['ref_transaction'] != 'API_TRANSFER') { ?>
            <div class="d-flex align-items-center">
              <div class="mr-5px btn-admin-danger cursor-pointer" <?= Tiwdal::register('withdraw_deal', $bot_statement); ?>>
                <img src="assets/icon/icon-warning.svg">
              </div>
            </div>
          <?php } ?>
          <div class="d-flex align-items-center">
            <?php /*
              <div class="mr-5px btn-admin-danger cursor-pointer" <?= Tiwdal::register('withdraw_deal', $bot_statement); ?>>
            */ ?>
            <?php if ($bot_statement['status'] != 'confirm') { ?>
              <div class="mr-5px btn-admin-danger cursor-pointer <?= $change_account ?>">
                <img src="assets/icon/icon-new-refresh.svg">
              </div>
            <?php } ?>
          </div>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>