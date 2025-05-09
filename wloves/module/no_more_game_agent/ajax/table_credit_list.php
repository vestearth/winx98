<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'user_id' => $_GET['id'],
  'transaction_date' => $_POST['transaction_date'],
  'credit_amount' => $_POST['credit_amount'],
  'remark' => $_POST['remark'],
  'is_credit' => 1,
];
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
      $list['status_th'] = 'ดำเนินการ';
      $list['confirm_by'] = '';
    } else if ($list['status'] == 'cancel') {
      $list['complete_date_trans'] = '';
      $list['status_th'] = 'ยกเลิก';
      $list['confirm_by'] = $list['cancel_admin_username'];
    }

    if ($list['transaction_type'] == 'withdraw') {
      $type_msg = 'ถอนเงิน';
      $type_class_text = 'text-danger';
    } else if ($list['transaction_type'] == 'deposit') {
      if ($list['receive_from'] == 'promotion') {
        $type_msg = 'โปรโมชั่น';
        $type_class_text = 'text-primary';
      } else if ($list['receive_from'] == 'admin_add_manual') {
        $type_msg = 'ฝากเงิน';
        $type_class_text = 'text-success';
      } else if ($list['receive_from'] == 'bot_auto_match') {
        $type_msg = 'ฝากเงิน';
        $type_class_text = 'text-success';
      } else if ($list['receive_from'] == 'event_deposit') {
        $type_msg = 'ฝากเงิน';
        $type_class_text = 'text-success';
      } else if ($list['receive_from'] == 'play_card' || $list['receive_from'] == 'play_slot') {
        $type_msg = 'ฝากเงิน';
        $type_class_text = 'text-success';
      }
    } else {
      $type_class_text = '';
    }
  ?>
    <tr class="cursor-pointer" <?= Tiwdal::register('detail_modal', $list); ?>>
      <td nowrap>
        <div>
          <?php echo Aww::formatDate($list['transaction_date_time'], 'd/m/Y,H:i'); ?>
        </div>
      </td>
      <td nowrap class="text-right <?= $type_class_text ?>"><?= isset($type_msg) ? $type_msg : '' ?></td>
      <td nowrap class="text-right"><?= number_format($list['credit_amount'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($list['credit_before'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($list['credit_after'], 2); ?></td>

      <td nowrap>
        <div class="form-row ">
          <div class="col-lg-5">
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
          <?php if ($list['transaction_by'] == 'bot') { ?>
            <div class="col-lg-7">
              <img src="assets/image/bot-auto.png" />
            </div>
          <?php } else { ?>
            <?php if ($list['status'] == 'cancel') {
            ?>
              <div class="col-lg-7">
                โดย <?= $list['cancel_admin_username']; ?>
              </div>
            <?php } else if ($list['status'] != 'wait_confirm') {
              if ($list['confirm_transaction_by_user_id']) {
                $admin_or_bot = 'โดย ' . $list['admin_username'];
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

      <td nowrap><?= $list['remark']; ?></td>
      <td class="disabled-link">
        <?php if ($list['receive_from'] == 'admin_add_manual') {
          // hide image src placeholder 
          $placeholder_img_check = strpos($list['admin_confirm_image'], '/placeholder');
          if ($placeholder_img_check == false) {
        ?>
            <div class="img-slip">
              <img src="<?= $list['admin_confirm_image'] ?>" class="img-responsive">
            </div>
        <?php }
        } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>