<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'deposit_withdraw'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$type = isset($_GET['type']) ? $_GET['type'] : 'deposit';
$where = [
  'transaction_date' => $_POST['transaction_date'],
  'transaction_type' => $type,
  'customer_username' => $_POST['customer_username'],
  'credit_amount' => $_POST['credit_amount'],
  'customer_bank_name' => $_POST['customer_bank_name'],
  'web_bank_name' => $_POST['web_bank_name'],
  'remark' => $_POST['remark'],
  'status' => $_POST['status'],
  'receive_from' => $_POST['receive_from'],
  'confirm_cancel_admin_id' => $_POST['confirm_cancel_admin_id'],
  'is_wallet' => 1,
];
if ($_POST['receive_from'] == 'all' || $_POST['receive_from'] == '') {
  unset($where['receive_from']);
} else if ($_POST['receive_from'] == 'admin_add_manual_not_turn_over') {
  $where['receive_from'] = [
    'admin_add_manual_not_turn_over',
    'admin_add_manual'
  ];
}
if ($type == 'deposit') {
  $where['admin_add_manual_date'] = $_POST['admin_add_manual_date'];
  $where['admin_add_manual_remark'] = $_POST['admin_add_manual_remark'];
}

if ($_POST['status'] == 'all') {
  unset($where['status']);
}

if ($_POST['confirm_cancel_admin_id'] == 'all') {
  unset($where['confirm_cancel_admin_id']);
}

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['transaction_date_time' => 'DESC'],
  'selected_fields' => ['id', 'transaction_date_time', 'transaction_type', 'customer_bank_name', 'customer_bank_no', 'web_bank_name', 'credit_amount', 'remark', 'status', 'admin_add_manual_date', 'admin_add_manual_remark', 'admin_confirm_date', 'bot_transaction_date_time'],
];
$call_api = nga_user::selectuserCreditTransactionNoView($code, $where, $options);
$data_list = isset($call_api['list']) ? $call_api['list'] : [];
$total_count = isset($call_api['total_count']) ? $call_api['total_count'] : 0;

$get_user = User::getCurrent();
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($data_list as $bot_statement) {
    $img_check = strpos($bot_statement['admin_confirm_image'], '/placeholder');
    if ($bot_statement['transaction_type'] == 'withdraw') {
      $bot_statement['type_text'] = 'ยกเลิกรายการถอนเงิน';
    } else {
      $bot_statement['type_text'] = 'ยกเลิกรายการฝากเงิน';
    }
  ?>
    <tr>
      <td nowrap>
        <div class="">
          <?php echo Aww::formatDate($bot_statement['transaction_date_time'], 'd/m/Y, H:i'); ?>
        </div>
        <div class="text-blue">
          <?php
          if ($bot_statement['bot_transaction_date_time']) {
            echo Aww::formatDate($bot_statement['bot_transaction_date_time'], 'd/m/Y, H:i');
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

      <td nowrap>
        <div class="d-flex align-items-center">
          <img src="<?= $bot_statement['user_group_image'] ?>" alt="" class="w-40px h-40px mr-10px">
          <div>
            <?= hidePhoneNumber($bot_statement['customer_username']); ?>
            <br>
            <a href="customer_details.php?c=<?= $code ?>&id=<?= $bot_statement['user_id'] ?>" class="font-12px">
              ดูรายละเอียด
            </a>
          </div>
        </div>

      </td>
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
          <?php if ($bot_statement['web_bank_bot_list_id'] != -1) { ?>
            <?php if ($bot_statement['web_bank_image']) { ?>
              <div class="bank-img small-size">
                <img src="<?= $bot_statement['web_bank_image']; ?>" class='ml-5px'>
              </div>
            <?php } ?>
            <div class="ml-10px">
              <?php if ($bot_statement['web_bank_name']) { ?>
                <span class="text-blue"> <?= $bot_statement['web_bank_name']; ?></span>
                <p class="mb-0"><?= $bot_statement['web_bank_no']; ?></p>
              <?php } else { ?>
                <div class="ml-10px">-</div>
              <?php } ?>
            </div>
          <?php } else { ?>
            <div class="ml-10px">-</div>
          <?php } ?>
        </div>
      </td>
      <?php if ($type == 'deposit') {  ?>
        <td nowrap>
          <?= ($bot_statement['admin_add_manual_date_time']  ? Aww::formatDate($bot_statement['admin_add_manual_date_time'], 'd/m/Y, H:i') :  ' - ') ?>
        </td>
      <?php } ?>
      <td nowrap class="text-right"><?= number_format($bot_statement['credit_amount'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($bot_statement['credit_before'], 2); ?></td>
      <td nowrap class="text-right">
        <?php
        $remark = trim($bot_statement['remark']);
        $rmk_substring = explode("-", $remark)[0];
        $rmk_substring = trim($rmk_substring);
        ?>
        <?php
        // if ($type == 'deposit' && $rmk_substring != 'แอดมินทำรายการล่าสุด' && $bot_statement['status'] == 'completed') {
        if ($type == 'deposit' && $bot_statement['status'] == 'completed') {
          echo  number_format($bot_statement['credit_after'], 2);
        } else if ($rmk_substring != 'แอดมินทำรายการล่าสุด') {
          echo  number_format($bot_statement['credit_after'], 2);
        }
        ?>
      </td>
      <td nowrap class="">
        <?php
        if ($type == 'deposit') {
          $txt_dep_with = 'ฝาก';
        } else {
          $txt_dep_with = 'ถอน';
        }
        if ($bot_statement['receive_from'] == 'admin_add_manual_with_turn_over') {
          echo 'รายการ' . $txt_dep_with . 'เงินไม่เข้า';
        } else if ($bot_statement['receive_from'] == 'admin_add_manual_not_turn_over' || $bot_statement['receive_from'] == 'admin_add_manual') {
          echo 'เพิ่มการ' . $txt_dep_with . 'ด้วยมือ';
        } else if ($bot_statement['receive_from'] == 'bot_auto_match') {
          echo 'รายการ' . $txt_dep_with . 'เงินอัตโนมัติ';
          // } else if ($bot_statement['receive_from'] == 'admin_match' || $bot_statement['receive_from'] == 'admin_add_manual') {
          //   echo 'รายการอนุมัติโดยแอดมิน';
        } else if ($bot_statement['receive_from'] == 'admin_match') {
          echo 'รายการอนุมัติโดยแอดมิน';
        } else if ($bot_statement['receive_from'] == 'admin_confirm_manual') {
          echo 'รายการ' . $txt_dep_with . 'อนุมัติโดยแอดมิน';
        } else if ($bot_statement['receive_from'] == 'admin_cancel_manual') {
          echo 'รายการ' . $txt_dep_with . 'ยกเลิกโดยแอดมิน';
        } ?>
      </td>
      <td nowrap class="thin-cell">
        <span class="text-capitalize">
          <?php
          echo ($bot_statement['status'] == 'wait_confirm') ? $bot_statement['cancel_admin_username'] : $bot_statement['admin_username'];
          ?>
        </span>
      </td>
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
                    <?= ($type == 'deposit') ? 'รอแอดมิน' : 'กำลังโอนเงิน'; ?>
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
              <?php
              $substring = explode("-", $bot_statement['remark'])[0];
              $substring = trim($substring);
              if ($substring && $bot_statement['status'] == 'completed') {
                echo 'โดย ' . $bot_statement['admin_username'];
              } else if ($bot_statement['status'] == 'cancel') {
                echo 'โดย ' . $bot_statement['cancel_admin_username'];
              } else {
                echo '<img src="assets/image/bot-auto.png" />';
              }
              ?>
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
      <td nowrap><?= $bot_statement['remark']; ?></td>
      <?php if ($type == 'deposit') {  ?>
        <td nowrap><?= $bot_statement['admin_add_manual_remark']; ?></td>
      <?php } ?>
      <td class="disabled-link cursor-pointer">
        <?php
        // hide image src placeholder 
        $placeholder_img_check = strpos($bot_statement['admin_confirm_image'], '/placeholder');
        if ($placeholder_img_check == false) {
        ?>
          <div class="img-slip" <?php Tiwdal::register('detail_preview_img', $bot_statement) ?>>
            <img src="<?= $bot_statement['admin_confirm_image'] ?>" class="img-responsive">
          </div>
        <?php }
        ?>
      </td>
      <?php if ($type == 'withdraw') {  ?>
        <td class="disabled-link align-middle">
          <div class="d-flex justify-content-center align-items-center">
            <button class="btn" <?php Tiwdal::register('cancel_transfer_money', $bot_statement) ?>>
              <img src="assets/icon/icon-cancel.svg" alt="">
            </button>
          </div>
        </td>
      <?php } ?>
      <td class="disabled-link" class="thin-cell">
        <?php
        $recheck_admin =  preg_match('/แอดมินทำรายการล่าสุด/', $bot_statement['remark']);
        if ($bot_statement['status'] == 'cancel' && $recheck_admin) {
        ?>
          <div class="d-flex align-items-center">
            <button class="form-btn-icon p-5px" <?php Tiwdal::register('confirm_from_cancel', $bot_statement) ?>>
              <img src="assets/icon/correct_1.svg" class="img-responsive">
            </button>
          </div>
        <?php } ?>
        <?php if ($bot_statement['status'] == 'wait_confirm') {  ?>
          <div class="d-flex justify-content-center align-items-center">
            <button class="form-btn-icon p-5px" <?php Tiwdal::register('allow_admin_manual_accept', $bot_statement) ?>>
              <img src="assets/icon/icon-check-green.svg" class="img-responsive">
            </button>
            <button class="form-btn-icon p-5px" <?php Tiwdal::register('cancel_admin_manual_accept', $bot_statement) ?>>
              <img src="assets/icon/icon-cross-red.svg" class="img-responsive">
            </button>
          </div>
        <?php } ?>

        <?php
        if ($bot_statement['receive_from'] == 'admin_add_manual_with_turn_over' || $bot_statement['receive_from'] == 'admin_add_manual') {
          if ($get_user['is_permission_cancel_deposit'] == 1 && $bot_statement['transaction_type'] == 'deposit' && $bot_statement['status'] == 'completed') {
        ?>
            <div class="d-flex align-items-center">
              <button class="form-btn-icon p-5px" <?php Tiwdal::register('cancel_topup_admin', $bot_statement) ?>>
                <img src="assets/icon/icon-cross-red.svg" class="img-responsive">
              </button>
            </div>
          <?php
          }
        } else if ($bot_statement['receive_from'] == 'bot_auto_match') {
          if ($bot_statement['transaction_type'] == 'deposit' && $bot_statement['status'] == 'completed') {
          ?>
            <div class="d-flex align-items-center">
              <button class="form-btn-icon p-5px" <?php Tiwdal::register('cancel_topup_bot', $bot_statement) ?>>
                <img src="assets/icon/icon-cross-red.svg" class="img-responsive">
              </button>
            </div>
        <?php }
        } ?>
      </td>

    </tr>
  <?php } ?>
</tbody>