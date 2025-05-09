<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$prefix = '../../../';
$code = $_GET['c'];
$where = [
  // 'name' => $_POST['name'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management_bot::selectBotGroup($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) { ?>
    <tr class="tr-link cursor-pointer" data-link="system_database.php?c=<?= $code ?>&page=8&is_info=1&id=<?= $data['id']; ?>">
      <td class="font-15px font-Medium" nowrap>
        <?= $data['bot_name']; ?>
      </td>
      <td class="font-15px font-Medium" nowrap>
        <div class="d-flex align-items-center">
          <div class="bank-img small-size">
            <img src="<?= $data['bank_image']; ?>">
          </div>
          <div class="ml-5px"><?= $data['bank_name_th']; ?></div>
        </div>
      </td>
      <td class="font-15px font-Medium min-w-200px text-primary" nowrap>
        <?php if ($data['is_deposit'] && $data['is_withdraw']) { ?>
          <div class="d-flex align-items-center">
            <?= file_get_contents('../assets/icon/check-circle.svg'); ?>
            <div class="ml-5px">ฝาก/ถอน</div>
          </div>
        <?php } else if ($data['is_deposit']) { ?>
          <div class="d-flex align-items-center">
            <?= file_get_contents('../assets/icon/check-circle.svg'); ?>
            <div class="ml-5px">ฝาก</div>
          </div>
        <?php } else if ($data['is_withdraw']) { ?>
          <div class="d-flex align-items-center">
            <?= file_get_contents('../assets/icon/check-circle.svg'); ?>
            <div class="ml-5px">ถอน</div>
          </div>
        <?php } ?>
      </td>
      <td class="font-15px font-Medium min-w-200px text-capitalize" nowrap>
        <?= $data['vpn']; ?>
      </td>
      <td class="font-15px font-Medium min-w-200px" nowrap>
        <?php if ($data['is_open']) { ?>
          <span class="text-success">เปิดใช้งาน</span>
        <?php } else { ?>
          <span class="">ปิดใช้งาน</span>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>