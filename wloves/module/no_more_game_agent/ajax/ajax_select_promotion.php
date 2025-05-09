<?php
$_WLOVES['no_check_permission'] = 1;
$prefix = '../../../';
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');

$code = $_POST['code'];
$id = isset($_POST['id']) ? $_POST['id'] : '';
$cal_type = isset($_POST['promotion']) ? $_POST['promotion'] : '';
$where = [
  'calculate_type' => $id
];
$result = nga_management::selectPromotion($code, $where);
$promo_list = [
  'prefix' => $prefix
];
if (!$cal_type) {
  $default_select = $result[0]['id'];
} else {
  $default_select = $cal_type;
}

foreach ($result as $promotion_data) {
  $promo_list['list'][] = [
    'value' => $promotion_data['id'],
    'name' => $promotion_data['name'],
    'img' => $promotion_data['promotion_image']
  ];
}
?>

<div class="">
  <?php
  TiwForm::normal('select-img', $default_select, ['name' => 'promotion_id', 'required' => true, 'class' => 'event_find_promo_type'], $promo_list);
  ?>
</div>