<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
$prefix = '../../../';
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$where = [
  'manage_bot_group_id' => $id,
  'bank_account_no' => $_POST['bank_account_no'],
  'bank_account_name' => $_POST['bank_account_name'],
  'user_name' => $_POST['user_name'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  // 'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['sort_order_id' => 'ASC']
];

$data_list = nga_management_bot::selectBotGroupList($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
$bot_group_count = count($list);
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $key => $data) {
    $up_id = '';
    $down_id = '';
    if (isset($list[($key - 1)]['id'])) {
      $up_id = $list[($key - 1)]['id'];
    }
    if (isset($list[($key + 1)]['id'])) {
      $down_id = $list[($key + 1)]['id'];
    }
  ?>
    <tr>
      <td>
        <div class="d-flex align-items-center mr-10px">
          <form method="post">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <input type="hidden" name="move_to_id" value="<?= $down_id ?>">
            <button type="submit" name="submit_swap_bot_list" class="btn p-0 border-0 shadow-none" <?= ($key + 1) == $bot_group_count ? 'disabled' : '' ?>>
              <?= file_get_contents('../assets/icon/icon-down.svg') ?>
            </button>
          </form>
          <form method="post">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <input type="hidden" name="move_to_id" value="<?= $up_id ?>">
            <button type="submit" name="submit_swap_bot_list" class="btn p-0 border-0 shadow-none" <?= $key == 0 ? 'disabled' : '' ?>>
              <?= file_get_contents('../assets/icon/icon-up.svg') ?>
            </button>
          </form>
        </div>
      </td>
      <td class="font-15px font-Medium" nowrap>
        <div class="d-flex align-items-center">
          <div class="bank-img small-size">
            <img src="<?= $data['bank_image']; ?>">
          </div>
          <div class="ml-5px"><?= $data['bank_account_no']; ?></div>
        </div>
      </td>
      <td class="font-15px font-Medium" nowrap>
        <?= $data['bank_account_name']; ?>
      </td>
      <td class="font-15px font-Medium" nowrap>
        <?= $data['user_name']; ?>
      </td>
      <td class="font-15px font-Medium min-w-200px text-primary" nowrap>
        <div class="d-flex align-items-center">
          <?= file_get_contents('../assets/icon/check-circle.svg'); ?>
          <div class="ml-5px">มียอดฝากเกิน <?= number_format($data['sum_money_swap_bank']); ?></div>
        </div>
      </td>
      <td class="font-15px font-Medium min-w-200px text-primary">
        <?= number_format($data['current_transaction_deposit_count'], 0); ?>
        /
        <?= number_format($data['transaction_count_swap_bank'], 0); ?>
      </td>
      <td class="thin-cell">
        <div class="d-flex align-items-center justify-content-center">
          <?php /* 
          $api = [
            'api' => 'nga_management_bot::setBotGroupListSwitchApi',
            'params' => [
              'code' => $code,
              'id' => $data['id'],
              'is_switch_api' => '{is_switch_api}',
            ]
          ];

          $options = [
            'type'      => 1,
            'is_on_off' => 1,
            'class'     => 'blue mr-10px is_enabled_status_event',
          ];
          TiwForm::liveForm('checkbox', 'is_switch_api', $data['is_switch_api'], $api, $options);
          */ ?>
          <?php
          if ($data['bank_abb'] == 'SCB') {
            if ($data['is_switch_api']) {
              echo '<h5 class="mb-0 line-height-unset"><span class="badge badge-success">เชื่อมต่อ Line Connect</span></h5>';
            } else {
              echo '<h5 class="mb-0 line-height-unset"><span class="badge badge-danger">ยังไม่ได้เชื่อมต่อ Line Connect</span></h5>';
            }
          }
          ?>
        </div>
      </td>
      <td class="thin-cell">
        <div class="d-flex align-items-center">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit', 'prefix' => $prefix, 'modal_id' => 'edit_bot_bank', 'modal_data' => $data]);
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => ''], ['text' => '', 'type' => 'delete', 'prefix' => $prefix, 'modal_id' => 'delete_bot_bank', 'modal_data' => $data]);
          ?>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>