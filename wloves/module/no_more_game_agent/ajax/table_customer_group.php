<?
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'name' => $_POST['name'],
  'deposit_time' => $_POST['deposit_time'],
  'sum_deposit' => $_POST['sum_deposit'],
  'deposit_bot_name' => $_POST['deposit_bot_name'],
  'withdraw_bot_name' => $_POST['withdraw_bot_name'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management::selectUserGroup($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>

<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $user_group) {
    $first_bot_deposit_detail = isset($user_group['first_bot_deposit_detail']) ? $user_group['first_bot_deposit_detail'] : [];
    $first_bot_withdraw_detail = isset($user_group['first_bot_withdraw_detail']) ? $user_group['first_bot_withdraw_detail'] : [];
  ?>
    <tr class="tr-link cursor-pointer" data-link="system_database.php?c=<?= $code ?>&id=<?= $user_group['id'] ?>&page=2&is_info=1">
      <td class="font-16px font-Medium" nowrap>
        <div class="user-group-img">
          <img src="<?= $user_group['user_group_image'] ?>">
        </div>
      </td>
      <td class="font-16px font-SemiBold" nowrap><?= $user_group['name']; ?></td>
      <td class="font-16px font-Medium" nowrap align="right"><?= number_format($user_group['deposit_time']); ?></td>
      <td class="font-16px font-Medium" nowrap align="right"><?= number_format($user_group['sum_deposit'], 2); ?></td>
      <td class="font-14px font-Medium" nowrap>
        <div class="d-flex">
          <div class="mr-5px bank-img small-size">
            <img src="<?= $user_group['deposit_bank_image'] ?>">
          </div>
          <div class="d-flex flex-column">
            <div class="text-primary">
            </div>
            <div>
              <?= $user_group['deposit_bot_name'] ?>
              <p class="mb-0">
                <?= $first_bot_deposit_detail[0]['bank_account_name'] ?>
              </p>
            </div>
          </div>
        </div>
      </td>
      <td class="font-14px font-Medium" nowrap>
        <div class="d-flex">
          <div class="mr-5px bank-img small-size">
            <img src="<?= $user_group['withdraw_bank_image']; ?>">
          </div>
          <div class="d-flex flex-column">
            <div class="">
              <div>
                <?= $user_group['withdraw_bot_name']; ?>
                <p class="mb-0">
                  <?= isset($first_bot_withdraw_detail[0]['bank_account_name']) ? $first_bot_withdraw_detail[0]['bank_account_name'] : ''; ?>
                </p>
              </div>
            </div>
          </div>
      </td>
      <td class="font-16px font-Medium" nowrap align="right"><?= number_format($user_group['count_user']); ?></td>
      <td class="font-16px font-Medium thin-cell" nowrap align="center">
        <?php if ($user_group['is_auto_group_shift']) { ?>
          <img src="assets/icon/icon-check.svg">
        <?php } else { ?>
          <img src="assets/icon/icon-cancel.svg">
        <?php } ?>
      </td>
      <td class="font-16px font-Medium thin-cell" nowrap align="center">
        <img src="assets/icon/icon-arrow-right.svg">
      </td>
    </tr>
  <?php } ?>
</tbody>