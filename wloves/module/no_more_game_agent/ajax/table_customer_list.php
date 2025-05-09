<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$where = [
  'insert_date' => $_POST['insert_date'],
  'username' => $_POST['username'],
  'bank_name_number' => $_POST['bank_name_number'],
  'member_code' => $_POST['member_code'],
  'user_code' => $_POST['user_code'],
  // 'upline_username' => $_POST['upline_username'],
];
// if ($_POST['bank_abb'] == 'all') {
//   unset($where['bank_abb']);
// }
$code = $_GET['c'];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : [],
  'selected_fields' => ['id', 'username', 'insert_date_time', 'bank_name', 'bank_number', 'first_time_deposit', 'alliance_id', 'upline1_user_id', 'user_group_id', 'bank_abb', 'member_code', 'user_code'],
];
if ($options['sort'] == []) {
  $options['sort'] = ['insert_date_time' => 'DESC'];
}
$user_customer = nga_user::selectUserNoView($code, $where, $options);
$data_list = isset($user_customer['list']) ? $user_customer['list'] : [];
$total_count = isset($user_customer['total_count']) ? $user_customer['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($data_list as $list) {
    if ($list == 2) {
      $agent_icon = file_get_contents('../assets/icon/icon-cancel.svg');
      $transfer_status = file_get_contents('../assets/icon/icon-circle-red.svg');
      $transfer_status_txt = 'ยกเลิก';
    } else {
      $agent_icon = file_get_contents('../assets/icon/icon-check.svg');
      $transfer_status = file_get_contents('../assets/icon/icon-circle-green.svg');
      $transfer_status_txt = 'สำเร็จ';
    }
  ?>
    <tr class="tr-link cursor-pointer" data-link="customer_details.php?c=<?= $code; ?>&id=<?= $list['id']; ?>">
      <td nowrap>
        <?= Aww::formatDate($list['insert_date_time'], 'd/m/Y H:i'); ?>
      </td>
      <td nowrap>
        <div class="d-flex align-items-center">
          <img src="<?= $list['user_group_image'] ?>" alt="" class="w-40px h-40px mr-10px">
          <div class="mr-10px"><?= hidePhoneNumber($list['username']); ?></div>
          <?= $agent_icon; ?>
        </div>
      </td>
      <td><?= isset($list['member_code']) ? $list['member_code'] : '-' ?></td>
      <td><?= isset($list['user_code']) ? $list['user_code']  : '-' ?></td>
      <td nowrap>
        <div class="d-flex align-items-center">
          <div class="bank-img small-size">
            <img src="<?= $list['bank_image']; ?>">
          </div>
          <div class="ml-5px"><?= $list['bank_name_th']; ?></div>
        </div>
        <div class="ml-30px"><?= $list['bank_name']; ?></div>
        <div class="ml-30px"><?= $list['bank_number']; ?></div>
      </td>
      <td>
        <div><?= ($list['alliance_name']) ?  $list['alliance_name'] : ' - ' ?></div>
      </td>

      <td nowrap>
        <div><?= ($list['upline_username']) ?  $list['upline_username'] : ' - ' ?></div>
      </td>
      <td nowrap class="disabled-link">
        <div>ฝากครั้งแรก :<?= number_format($list['first_time_deposit'], 2) ?></div>
        <div class="d-flex align-items-end">
          <div class="mr-5px" <?= Tiwdal::register('deposit_credit_customer', $list); ?>>
            <?= file_get_contents('../assets/icon/icon-credit-deposit.svg') ?>
          </div>
          <div class="mr-5px" <?= Tiwdal::register('withdraw_credit_customer', $list); ?>>
            <?= file_get_contents('../assets/icon/icon-credit-withdraw.svg') ?>
          </div>
          <div class="mr-5px" <?= Tiwdal::register('add_bonus_customer', $list); ?>>
            <?= file_get_contents('../assets/icon/icon-gift.svg') ?>
          </div>
          <div <?= Tiwdal::register('change_password_customer', $list); ?>>
            <?= file_get_contents('../assets/icon/icon-lock.svg') ?>
          </div>
        </div>
      </td>
      <td nowrap>
        <div class="d-flex align-items-center">
          <?= $transfer_status ?>
          <span class="ml-10px"><?= $transfer_status_txt; ?></span>
        </div>
      </td>
      <td class="vertical-center">
        <div class="text-right svg-py-auto size-30px"><?= file_get_contents('../assets/icon/icon-arrow-right.svg') ?></div>
      </td>
    </tr>
  <?php } ?>
</tbody>