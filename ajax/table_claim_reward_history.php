<?php
require_once '../.framework/import.php';
Structure::loadMetaForAjax('../');
$code = Aww::API_CODE['nmg'];
$user_data = User::getCurrent();

$where = [
  'user_id' => $user_data['id']
];

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : [
    'insert_date_time' => 'DESC'
  ]
];

$select = nga_user::selectUserRedemtionHistory($code, $where, $options);
$list = $select['list'];
?>
<tbody data-total_count="<?= $select['total_count'] ?>">
  <?php foreach ($list as $val) {
    if ($val['status'] == 'confirm') {
      $status = Ty::get('reward_claimed', [], ["case" => "ucfirst"]);
      $status_class = '#13AE4B';
    } else if ($val['status'] == 'wait_confirm') {
      $status = Ty::get('checking', [], ["case" => "ucfirst"]);
      $status_class = '#FFFF9F';
    } else if ($val['status'] == 'rejected') {
      $status = Ty::get('disapprove', [], ["case" => "ucfirst"]);
      $status_class = '#FF4746';
    } else {
      $status = '-';
      $status_class = '#FFFFFF';
    }
  ?>
    <tr>
      <td nowrap class="text-white">
        <?= Aww::formatDate($val['insert_date_time'], 'd/m/Y, H:i'); ?>
      </td>
      <td nowrap class="text-white">
        <span style="color:<?= $status_class ?>;"><?= $status ?></span>
      </td>
      <td nowrap class="text-white text-end">
        <?= number_format($val['point_use'], 0) ?>
      </td>
      <td nowrap class="text-white">
        <?= $val['reward_name'] ?>
      </td>
    </tr>
  <?php } ?>
</tbody>