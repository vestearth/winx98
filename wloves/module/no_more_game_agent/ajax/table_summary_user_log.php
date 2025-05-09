<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'history_user_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

$where = [
  'username' => $_GET['user_id'],
  'action_date_from' => $from_date,
  'action_date_to' => $to_date,
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];

$data_list = nga_user::selectUserLog($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
$list2 = [];
$total_countsep = 0;
foreach ($list as $key => $data) {
  if ($data['action_date'] >= $from_date && $data['action_date'] <= $to_date) {
    $total_count_sep = $key + 1;
    $list2[$key]['username'] =  $data['username'];
    $list2[$key]['action_date'] =  $data['action_date'];
    $list2[$key]['detail'] =  $data['detail'];
  }
}
$status_action_options = [
  [
    'value' => 'login',
    'text' => 'เข้าใช้งานระบบ',
  ],
  [
    'value' => 'add_deposit',
    'text' => 'ทำรายการฝากมือ',
  ],
  [
    'value' => 'add_withdraw',
    'text' => 'ทำรายการถอนมือ',
  ],
  [
    'value' => 'edit_user',
    'text' => 'แก้ไขข้อมูลลูกค้า',
  ],
  [
    'value' => 'edit_self',
    'text' => 'แก้ไขข้อมูลตนเอง',
  ],
  [
    'value' => 'add_user',
    'text' => 'สมัครให้ลูกค้า',
  ],
];
?>
<tbody data-total_count="<?= $total_count_sep; ?>">
  <?php foreach ($list2 as $data) {
    $detail = json_decode($data['detail'], true);
    if ($data['action_date'] >= $from_date && $data['action_date'] <= $to_date) {
  ?>
      <tr>
        <td nowrap class=""><?= Aww::formatDate($data['action_date'], 'd/m/Y'); ?></td>
        <td nowrap class="font-SemiBold"><?= $data['username'] ?></td>
        <td nowrap class="font-SemiBold">
          <?php foreach ($detail as $key => $detail_data) { ?>
            <p class="mb-0"><?= $detail_data; ?></p>
          <?php } ?>
          <? // $data['detail'] ? $data['detail'] : '-'; 
          ?>
        </td>
      </tr>
  <?php }
  } ?>
</tbody>