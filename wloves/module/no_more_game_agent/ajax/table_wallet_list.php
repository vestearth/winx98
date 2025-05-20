<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'user_id' => $_GET['id'],
  'transaction_date' => $_POST['transaction_date'],
  'transaction_type' => $_POST['transaction_type'],
  'credit_amount' => $_POST['credit_amount'],
  'status' => $_POST['status'],
  'remark' => $_POST['remark'],
  'is_wallet' => 1,
  'is_bot_run_withdraw' => 1
];
if ($_POST['transaction_type'] == 'all') {
  unset($where['transaction_type']);
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
$user_customer = nga_user::selectuserCreditTransaction($code, $where, $options);
$data_list = isset($user_customer['list']) ? $user_customer['list'] : [];
$total_count = isset($user_customer['total_count']) ? $user_customer['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($data_list as $list) {
    $list['date_trans'] = Aww::formatDate($list['transaction_date_time'], 'd/m/Y, H:i');
    $list['credit_amount_txt'] = number_format($list['credit_amount'], 2);
    $list['credit_before_txt'] = number_format($list['credit_before'], 2);
    $list['credit_after_txt'] = number_format($list['credit_after'], 2);
    if ($list['status'] == 'completed') {
      if ($list['confirm_transaction_by_user_id']) {
        $list['confirm_by'] = $list['admin_username'];
      } else {
        $list['confirm_by'] = '<img src="assets/image/bot-auto.png">';
      }
      $list['complete_date_trans'] = Aww::formatDate($list['bot_transaction_date_time'], 'd/m/Y, H:i');
      $list['status_th'] = 'สำเร็จแล้ว';
    } else if ($list['status'] == 'wait_confirm') {
      $list['complete_date_trans'] = '';
      $list['status_th'] = 'กำลังโอนเงิน';
      $list['confirm_by'] = '';
    } else if ($list['status'] == 'cancel') {
      $list['complete_date_trans'] = '';
      $list['status_th'] = 'ยกเลิก';
      $list['confirm_by'] = $list['cancel_admin_username'];
    }
    $list['modal_type_msg'] = ($list['transaction_type'] == 'withdraw') ? 'ถอน' : 'ฝาก';

    $status = $list['status'];
    if ($status == 'waiting_user') {
      $text = 'รอผู้ใช้ทำรายการ';
      $textClass = 'text-warning';
    } else if ($status == 'waiting_system') {
      $text = 'รอระบบประมวลผล';
      $textClass = 'text-warning';
    } else if ($status == 'waiting_admin') {
      $text = 'รอแอดมินยืนยัน';
      $textClass = 'text-warning';
    } else if ($status == 'success') {
      $text = 'สำเร็จ';
      $textClass = 'text-success';
    } else if ($status == 'cancel') {
      $text = 'ยกเลิก';
      $textClass = 'text-danger';
    } else if ($status == 'expired') {
      $text = 'หมดอายุ';
      $textClass = 'text-danger';
    }
  ?>

    <?php if ($list['status'] == 'completed') { ?>
      <?php if ($list['transaction_type'] == 'deposit') { ?>
        <?php if ($list['transaction_by'] == 'bot') { ?>
          <tr class="cursor-pointer" <?= Tiwdal::register('complete_no_img_modal', $list) ?>>
          <?php } else { ?>
          <tr class="cursor-pointer" <?= Tiwdal::register('complete_modal', $list) ?>>
          <?php } ?>
        <?php } else { ?>
          <tr class="cursor-pointer" <?= Tiwdal::register('complete_withdraw_modal', $list) ?>>
          <?php } ?>
        <?php } else if ($list['status'] == 'wait_confirm') { ?>
          <tr class="cursor-pointer" <?= Tiwdal::register('detail_modal', $list) ?>>
          <?php } else { ?>
          <tr>
          <?php } ?>
          <td nowrap>
            <div>
              <?php echo Aww::formatDate($list['transaction_date_time'], 'd/m/Y,H:i'); ?>
            </div>
          </td>
          <td nowrap>
            <?php if ($list['transaction_type'] == 'deposit') { ?>
              <div class="text-green">
                ฝากเงิน
              </div>
            <?php } else { ?>
              <div class="text-danger">
                ถอนเงิน
              </div>
            <?php } ?>
          </td>
          <td nowrap class="text-right"><?= number_format($list['credit_amount'], 2); ?></td>
          <td nowrap class="text-right"><?= number_format($list['credit_before'], 2); ?></td>
          <td nowrap class="text-right"><?= number_format($list['credit_after'], 2); ?></td>
          <td nowrap>
            <div class="d-flex">
              <div class="w-30px align-self-center">
                <img src="<?= $list['web_bank_image'] ?>" class="w-100 border-radius-5px">
              </div>
              <div class="pl-5px">
                <p class="mb-0"><?= $list['web_bank_no'] ?></p>
                <p class="mb-0"><?= $list['web_bank_name'] ?></p>
              </div>
            </div>
          </td>
          <td nowrap>
            <div class="form-row ">
              <div class="col-lg-12">
                <div class="form-row">
                  <?php if ($list['status'] == 'completed') { ?>
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
                  <?php } else if ($list['status'] == 'wait_confirm') { ?>
                    <div class="col-2 ">
                      <div class="mb-5px">
                        <?= file_get_contents("./../assets/icon/icon-dot-yellow.svg"); ?>
                      </div>
                    </div>
                    <div class="col-10 ">
                      <div class="pl-5px">
                        กำลังโอนเงิน
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class="col-2">
                      <?php
                      if ($textClass == 'text-danger') {
                        echo file_get_contents("./../assets/icon/icon-dot-red.svg");
                      } else if ($textClass == 'text-warning') {
                        echo file_get_contents("./../assets/icon/icon-dot-yellow.svg");
                      } else if ($textClass == 'text-success') {
                        echo file_get_contents("./../assets/icon/icon-dot-green.svg");
                      }

                      ?>
                    </div>
                    <div class="col-10">
                      <div class="pl-5px">
                        <div class="<?= $textClass; ?>">
                          <?= $text; ?>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
              <?php
              // if ($list['transaction_by'] == 'bot') { 
              if ($list['receive_from'] == 'bot_auto_match') { ?>
                <div class="col-lg-12">
                  <img src="assets/image/bot-auto.png" />
                </div>
              <?php } else { ?>
                <?php if ($list['status'] == 'cancel') {
                  if ($list['receive_from'] == 'bot_auto_match') {
                ?>
                    <div class="col-lg-7">
                      โดย <?= '<img src="assets/image/bot-auto.png">'; ?>
                    </div>
                  <?php } else if ($list['receive_from'] == 'admin_confirm_manual') { ?>
                    <div class="col-lg-7">
                      <div class="badge badge-pill badge-danger" style="padding: 5px;width: 100px;font-size: 13px;font-weight: 300;display: flex;justify-content: center;">โดย <?= $bot_statement['cancel_admin_username']; ?></div>
                    </div>
                  <?php }
                } else if ($list['status'] != 'wait_confirm') {
                  if ($list['confirm_transaction_by_user_id']) {
                    $admin_or_bot = '<div class="badge badge-pill badge-primary" style="padding: 5px;width: 100px;font-size: 13px;font-weight: 300;display: flex;justify-content: center;">โดย ' . $list['admin_username'] . '</div>';
                  } else {
                    $admin_or_bot = '<img src="assets/image/bot-auto.png">';
                  }
                  ?>
                  <div class="col-lg-12">
                    <?= $admin_or_bot; ?>
                  </div>
                <?php
                } ?>
              <?php } ?>
            </div>
          </td>
          <td nowrap><?= $list['remark']; ?></td>
          <td class="nolink">
            <div class="w-50px">
              <?= ($list['transaction_type'] == 'withdraw' || $list['transaction_by'] == 'bot') ? '' : '<img class="w-100 border-radius-5px" src="' . $list['admin_confirm_image'] . '">' ?>
            </div>
          </td>
          </tr>
        <?php } ?>
</tbody>