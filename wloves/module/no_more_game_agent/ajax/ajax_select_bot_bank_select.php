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

$html = TiwForm::normal('select-img', '', ['name' => $_POST['name']], $bot_list);

echo $html;
