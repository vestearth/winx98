<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'opinion'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'title_name' => $_POST['title_name'],
  'admin_username' => $_POST['admin_username'],
  'username' => $_POST['username'],
  'bank_name' => $_POST['bank_name'],
  'status' => $_POST['status'],
  'rating' => $_POST['rating'],
  'insert_date' => $_POST['insert_date'],
  'update_date' => $_POST['update_date'],
  'comment_group_id' => $_POST['comment_group_id'],
];
if ($_POST['status'] == 'all') {
  $where['status'] = ['waiting', 'pending'];
}
if ($_POST['rating'] == 'all') {
  unset($where['rating']);
}
if ($_POST['comment_group_id'] == 'all') {
  unset($where['comment_group_id']);
}

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];

$data_list =  nga_management::selectUserCommentHistory($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($list as $key => $data) {
    $data['username'] = hidePhoneNumber($data['username']);
  ?>
    <tr>
      <td>
        <?php
        Homepagify::createCheckboxTBody('checkbox_' . $data['id'], $data['id'], ['data-status' => $data['status']]);
        ?>
      </td>
      <td class=" font-SemiBold"><?= Aww::formatDate($data['insert_date_time'], 'd/m/Y, H:i'); ?></td>
      <td><?= $data['group_name'] ?></td>
      <td nowarp> <?= $data['title_name'] ?></td>
      <td class="thin-cell"> <?= $data['username'] ?></td>
      <td class="thin-cell"> <?= $data['bank_name'] ?></td>
      <td>
        <div class="d-flex justify-content-start align-items-center">
          <?php if ($data['rating'] == 1) { ?>
            <?= file_get_contents("./../assets/icon/icon-dot-red.svg"); ?>
            <span class="ml-5px">แย่มาก</span>
          <?php } else if ($data['rating'] == 2) { ?>
            <?= file_get_contents("./../assets/icon/icon-dot-yellow.svg");  ?>
            <span class="ml-5px">แย่</span>
          <?php } else if ($data['rating'] == 3) { ?>
            <?= file_get_contents("./../assets/icon/icon-dot-orange.svg"); ?>
            <span class="ml-5px">พอใช้</span>
          <?php } else if ($data['rating'] == 4) { ?>
            <?= file_get_contents("./../assets/icon/icon-dot-green.svg"); ?>
            <span class="ml-5px">ดี</span>
          <?php } else if ($data['rating'] == 5) { ?>
            <?= file_get_contents("./../assets/icon/icon-dot-blue.svg"); ?>
            <span class="ml-5px">ดีมาก</span>
          <?php } else { ?>
            -
          <?php  } ?>
        </div>
      </td>
      <td>
        <?php if ($data['status'] == 'waiting') { ?>
          <span class="text-secondary">ยังไม่ดำเนินการ</span>
        <?php } else if ($data['status'] == 'pending') { ?>
          <span class="text-warning">กำลังดำเนินการ</span>
        <?php } else if ($data['status'] == 'completed') { ?>
          <span class="text-success">เสร็จสิ้น</span>
        <?php } ?>
      </td>
      <td><?= ($data['admin_username']) ? $data['admin_username'] : '-'; ?></td>
      <td class=" font-SemiBold"><?= Aww::formatDate($data['update_date_time'], 'd/m/Y, H:i'); ?></td>
      <td>
        <button class="form-btn-icon" <?php Tiwdal::register('opinion_detail', $data, ['is_ajax' => 1]); ?>>
          <?= file_get_contents('../assets/icon/icon-edit.svg'); ?>
        </button>
      </td>
    </tr>
  <?php } ?>
</tbody>