<?php
$_WLOVES['no_check_permission'] = 1;
$prefix = '../../../';
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');

$code = $_POST['code'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
$result = nga_management_bot::getBotGroupByID($code, $id);

$bot_list = [
  'prefix' => $prefix
];
$bot_list_api = (isset($result['bot_group_list'])) ? $result['bot_group_list'] : [];
foreach ($bot_list_api as $bot_data) {
  $bot_list['list'][] = [
    'value' => $bot_data['id'],
    'name' => $bot_data['bank_account_name'] . ' / ' . $bot_data['bank_account_no'],
    'img' => $bot_data['bank_image']
  ];
}
?>

<?php foreach ($bot_list_api as $key => $bot_api) {
  $keys = $key + 1;
?>
  <div class="form-row align-items-center">
    <div class="col-lg-3">
      <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">ธนาคารสำหรับการฝากอัตโนมัติ
        <span class="text-danger">*</span>
      </label>
    </div>
    <div class="col-lg-5 font-16px font-Medium">
      <?php
      TiwForm::normal('select-img', '', ['name' => 'deposit_bot_group_list_id[]', 'required' => true], $bot_list);
      ?>
    </div>
    <div class="col-lg-4 d-flex align-items-center">
      <div class="mr-10px ml-10px">
        <?= TiwForm::normal('checkbox', '', ['name' => 'is_show_all_deposit_account_' . $keys], ['style' => '3']); ?>
      </div>
      <div class=" font-16px font-Medium">
        แสดงเลขบัญชีทั้งหมด
      </div>
    </div>
  </div>

<?php } ?>