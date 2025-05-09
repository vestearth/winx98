<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'auto_withdraw'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];

$where = [
  'transaction_date' => $_POST['transaction_date'],
  'customer_username' => $_POST['customer_username'],
  'credit_amount' => $_POST['credit_amount'],
  'customer_bank_name' => $_POST['customer_bank_name'],
  'web_bank_name' => $_POST['web_bank_name'],
  'status' => 'wait_confirm',
  'is_wallet' => 1,
  'transaction_type' => 'withdraw',
  'is_can_withdraw_over_limit' => 0,
];

// if ($_POST['transaction_type'] == 'all') {
//   $where['transaction_type'] = ['withdraw'];
// }
$options = [
  'total_count' => true,
  'show_bot_not_withdraw' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['transaction_date_time' => 'DESC']
];

$call_api = nga_user::selectuserCreditTransaction($code, $where, $options);
$data_list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($data_list as $bot_statement) { ?>
    <tr class="cursor-pointer" <?php Tiwdal::register('auto_withdraw_detail', $bot_statement, ['prefix' => '', 'modal_id' => 'auto_withdraw_detail', 'is_ajax' => true]); ?>>
      <td nowrap>
        <div class="">
          <?php echo Aww::formatDate($bot_statement['transaction_date_time'], 'd/m/Y, H:i'); ?>
        </div>
        <div class="text-blue">
          <?php
          if ($bot_statement['bot_update_status_date_time']) {
            echo Aww::formatDate($bot_statement['bot_update_status_date_time'], 'd/m/Y, H:i');
          }
          ?>
        </div>
      </td>
      <td nowrap class="">
        <?php if ($bot_statement['transaction_type'] == 'withdraw') { ?>
          <span class="text-red">
            ถอนเงิน
          </span>
        <?php } else if ($bot_statement['transaction_type'] == 'deposit') { ?>
          <span class="text-green">
            ฝากเงิน
          </span>
        <?php } ?>
      </td>

      <td nowrap><?= hidePhoneNumber($bot_statement['customer_username']); ?></td>
      <td nowrap>
        <div class="d-flex">
          <?php if ($bot_statement['customer_bank_image']) { ?>
            <div class="bank-img small-size">
              <img src="<?= $bot_statement['customer_bank_image']; ?>" class='ml-5px'>
            </div>
          <?php } ?>
          <div class="ml-10px">
            <span class="text-blue"> <?= $bot_statement['customer_bank_name']; ?></span>
            <p class="mb-0"><?= $bot_statement['customer_bank_no']; ?></p>
          </div>
        </div>
      </td>
      <td nowrap>
        <div class="d-flex">
          <?php if ($bot_statement['web_bank_image']) { ?>
            <div class="bank-img small-size">
              <img src="<?= $bot_statement['web_bank_image']; ?>" class='ml-5px'>
            </div>
          <?php } ?>
          <div class="ml-10px">
            <span class="text-blue"> <?= $bot_statement['web_bank_name']; ?></span>
            <p class="mb-0"><?= $bot_statement['web_bank_no']; ?></p>
          </div>
        </div>
      </td>
      <td nowrap class="text-right"><?= number_format($bot_statement['credit_amount'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($bot_statement['credit_before'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($bot_statement['credit_after'], 2); ?></td>

      <td nowrap class="thin-cell">
        <div class="form-row ">
          <div class="col-lg-12">
            <div class="form-row">
              <?php if ($bot_statement['status'] == 'completed') { ?>
                <div class="col-2 ">
                  <div class="mb-5px">
                    <?= file_get_contents("./../assets/icon/icon-dot-green.svg"); ?>
                  </div>
                </div>
                <div class="col-10 ">
                  <div class="pl-5px">
                    สำเร็จแล้ว
                  </div>

                </div>
              <?php } else if ($bot_statement['status'] == 'wait_confirm') { ?>
                <div class="col-2 ">
                  <div class="mb-5px">
                    <?= file_get_contents("./../assets/icon/icon-dot-yellow.svg"); ?>
                  </div>
                </div>
                <div class="col-10 ">
                  <div class="pl-5px">
                    ดำเนินการ
                  </div>
                </div>
              <?php } else { ?>
                <div class="col-2 ">
                  <div class="mb-5px">
                    <?= file_get_contents("./../assets/icon/icon-dot-red.svg"); ?>
                  </div>
                </div>
                <div class="col-10 ">
                  <div class="pl-5px">
                    ยกเลิก
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
          <?php if ($bot_statement['transaction_by'] == 'bot') { ?>
            <div class="col-lg-12">
              <img src="assets/image/bot-auto.png" />
            </div>
          <?php } else { ?>
            <?php if ($bot_statement['status'] == 'cancel') {
            ?>
              <div class="col-lg-7">
                โดย <?= $bot_statement['cancel_admin_username']; ?>
              </div>
            <?php } else if ($bot_statement['status'] != 'wait_confirm') {
              if ($bot_statement['confirm_transaction_by_user_id']) {
                $admin_or_bot = 'โดย ' . $bot_statement['admin_username'];
              } else {
                $admin_or_bot = '<img src="assets/image/bot-auto.png">';
              }
            ?>
              <div class="col-lg-7">
                <?= $admin_or_bot; ?>
              </div>
            <?php
            } ?>
          <?php } ?>
        </div>
      </td>

    </tr>
  <?php } ?>
</tbody>