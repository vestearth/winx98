<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$prefix = '../../../';
$code = $_GET['c'];
$user_group_id = isset($_GET['user_group_id']) ? $_GET['user_group_id'] : null;
$is_have_first_time_deposit = isset($_POST['first_time_deposit']) && $_POST['first_time_deposit'] != ''  ? true : false;

$where = [
  'user_group_id' => $user_group_id,
  'insert_date' => isset($_POST['insert_date']) ? $_POST['insert_date'] : '',
  'bank_name' => isset($_POST['bank_name']) ? $_POST['bank_name'] : '',
  'username' => isset($_POST['username']) ? $_POST['username'] : '',
  'bank_number' => isset($_POST['bank_number']) ? $_POST['bank_number'] : '',
  'member_code' => isset($_POST['member_code']) ? $_POST['member_code'] : '',
];

if ($is_have_first_time_deposit) {
  $where['first_time_deposit'] = $_POST['first_time_deposit'];
} else {
  unset($where['first_time_deposit']);
}
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$select = nga_user::selectUser($code, $where, $options);
?>
<tbody data-total_count="<?= $select['total_count'] ?>">
  <?php foreach ($select['list'] as $value) { ?>
    <tr class="tr-link cursor-pointer" data-link="customer_details.php?c=<?= $code ?>&id=<?= $value['id'] ?>&user_group_id=<?= $_GET['user_group_id'] ?>&is_from_user_group=true">
      <td class="font-15px font-Medium min-w-200px" nowrap><?= Aww::formatDate($value['insert_date_time'], 'd/m/Y, H:i'); ?></td>
      <td class="font-15px font-Medium min-w-150px" nowrap><?= hidePhoneNumber($value['username']) ?></td>
      <td class="font-15px font-Medium min-w-150px" nowrap><?= $value['bank_name'] ?></td>
      <td class="font-15px font-Medium min-w-250px" nowrap>
        <img src="<?= $value['bank_image'] ?>" class="w-25px" style="border-radius: 5px;"> <?= $value['bank_number'] ?>
      </td>
      <td class="font-15px font-Medium" nowrap><?= number_format($value['first_time_deposit'], 2) ?></td>
      <td class="font-15px font-Medium" nowrap><?= $value['member_code'] ?></td>
      <td class="font-15px font-Medium text-center" nowrap><img src="assets/icon/icon-check.svg" class="w-20px"></td>
      <td nowrap class="">
        <div class="text-right svg-py-auto size-30px"><?= file_get_contents('../assets/icon/icon-arrow-right.svg') ?></div>
      </td>
    </tr>
  <?php } ?>
</tbody>