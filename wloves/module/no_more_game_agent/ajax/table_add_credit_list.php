<?php
$_PAGE['permission'] = ['no_more_game_agent', 'wallet', 'add_credit_list'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];

$where = [
  'transaction_type' => 'deposit',
  'transaction_by' => ['admin', 'bot'],
  'transaction_date' => isset($_POST['transaction_date']) ? $_POST['transaction_date'] : '',
  'credit_amount' => isset($_POST['credit_amount']) ? $_POST['credit_amount'] : '',
  'customer_username' => isset($_POST['customer_username']) ? $_POST['customer_username'] : '',
  'credit_before' => isset($_POST['credit_before']) ? $_POST['credit_before'] : '',
  'credit_after' => isset($_POST['credit_after']) ? $_POST['credit_after'] : '',
  'remark' => isset($_POST['remark']) ? $_POST['remark'] : '',
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['transaction_date_time' => 'DESC'],
  'selected_fields' => ['credit_amount', 'transaction_date_time', 'receive_from', 'promotion_calculate_type', 'transaction_by', 'customer_username', 'credit_amount', 'credit_before', 'credit_after', 'web_bank_no', 'web_bank_name', 'admin_username', 'remark'],
];
$select = nga_user::selectuserCreditTransaction($code, $where, $options);
?>
<tbody data-total_count="<?= $select['total_count'] ?>">
  <?php
  foreach ($select['list'] as $value) {
    $value['credit_amount'] = number_format($value['credit_amount'], 2);
    $value['transaction_date_time'] = Aww::formatDate($value['transaction_date_time'], 'd/m/Y, H:i');
    if ($value['receive_from'] == 'promotion') {
      if ($value['promotion_calculate_type'] == 'invite_friend') {
        $type_msg = 'ชวนเพื่อน';
      } else if ($value['promotion_calculate_type'] == 'deposit') {
        $type_msg = 'มียอดฝาก';
      } else if ($value['promotion_calculate_type'] == 'excess_lost') {
        $type_msg = 'โปรโมชั่น';
      } else if ($value['promotion_calculate_type'] == 'play_game') {
        $type_msg = 'เข้าเล่นเกม';
      } else if ($value['promotion_calculate_type'] == 'new_user') {
        $type_msg = 'สมัครสมาชิกใหม่';
      } else {
        $type_msg = '';
      }
    } else {
      $type_msg = 'รายการฝาก';
    }
  ?>
    <tr class="cursor-pointer" <?php ($value['transaction_by'] == 'admin' && $value['receive_from'] != 'admin_match') ? Tiwdal::register('detail_preview_img', $value) : '' ?>>
      <td nowrap>
        <?= $value['transaction_date_time'] ?>
      </td>
      <td nowrap><?= $type_msg ?></td>
      <td nowrap><?= hidePhoneNumber($value['customer_username']) ?></td>
      <td nowrap class="text-right">
        <?= $value['credit_amount'] ?>
      </td>
      <td nowrap class="text-right">
        <?= number_format($value['credit_before'], 2) ?>
      </td>
      <td nowrap class="text-right">
        <?= number_format($value['credit_after'], 2) ?>
      </td>
      <td nowrap>
        <div class="d-flex">
          <div class="w-30px align-self-center">
            <img src="<?= $value['web_bank_image'] ?>" class="w-100 border-radius-5px">
          </div>
          <div class="pl-5px">
            <p class="mb-0"><?= $value['web_bank_no'] ?></p>
            <p class="mb-0"><?= $value['web_bank_name'] ?></p>
          </div>
        </div>
      </td>
      <td nowrap>
        <div class="form-row ">
          <div class="col-lg-5">
            <div class="d-flex">
              <div class="pr-5px">
                <?= file_get_contents("./../assets/icon/icon-dot-green.svg"); ?>
              </div>
              ได้รับแล้ว
            </div>
          </div>
          <div class="col-lg-7">
            <div class="pl-5px">
              โดย <?= ($value['admin_username']) ?  $value['admin_username'] : 'BOT' ?>
            </div>
          </div>
        </div>
      </td>
      <td>
        <?= $value['remark'] ?>
      </td>
      <td class="cursor-pointer">
        <div class="w-50px">
          <?= ($value['transaction_by'] == 'admin' && $value['receive_from'] != 'admin_match') ? '<img class="w-100 border-radius-5px" src="' . $value['admin_confirm_image'] . '">' : '' ?>
          <?php
          if ($value['transaction_by'] == 'admin' && $value['receive_from'] == 'admin_match') {
            if (strpos($value['transaction_by'], '/placeholder') != false) {
              echo '<img class="w-100 border-radius-5px" src="' . $value['admin_confirm_image'] . '">';
            }
          }
          ?>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>