<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];
$is_active = '123';
if ($_POST['is_active'] == 'เปิดการใช้งาน') {
  $is_active = '1';
} else if ($_POST['is_active'] == 'ปิดการใช้งาน') {
  $is_active = '0';
}

$where = [
  'name' => $_POST['name'],
  'alliance_type' => $_POST['alliance_type'],
  'is_active' => $is_active,
];
if ($_POST['alliance_type']) {
  unset($where['alliance_type']);
}
if ($is_active == 123) {
  unset($where['is_active']);
}

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_management::selectAlliance($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) {
    if ($data['alliance_type'] == 'monthly') {
      $alliance_type = 'แบบรายเดือน';
    } else if ($data['alliance_type'] == 'yearly') {
      $alliance_type = 'แบบรายปี';
    } else if ($data['alliance_type'] == 'lifetime') {
      $alliance_type = 'แบบสะสมระยะยาว';
    }
    $data['alliance_type'] = $alliance_type;
  ?>
    <tr>
      <td class="font-15px font-Medium" nowrap><?= $data['name']; ?></td>
      <td class="font-15px font-Medium" nowrap><?= $data['username']; ?></td>
      <?php /*
      <td class="font-15px font-Medium" nowrap><?= $data['line_name']; ?></td>
      <td class="font-15px font-Regular text-primary" nowrap>
        if ($data['line_link']) {
          echo '<img src="assets/icon/clip-link.svg">';
          echo $data['line_link'];
        }
      </td>
        */ ?>
      <td class="font-15px font-Regular text-primary" nowrap> <img src="assets/icon/clip-link.svg">
        <?= $data['link']; ?>
      </td>
      <td>
        <div class="d-flex align-items-center">
          <div class="font-15px font-Medium" nowrap><?= $alliance_type; ?></div>
        </div>
      </td>
      <td class="font-15px font-Medium text-success">
        <?php
        $is_active_txt = ($data['is_active']) ? 'เปิดใช้งาน' : 'ปิดการใช้งาน';
        ?>
        <span class="<?= ($data['is_active']) ? 'text-success' : 'text-danger'; ?>"><?= $is_active_txt; ?></span>
      </td>
      <td nowrap class="thin-cell py-5px">
        <div class="d-flex align-items-center">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit', 'prefix' => $prefix, 'modal_id' => 'edit_data', 'modal_data' => $data]);
          if ($data['username'] != 'alliance1') {
            TiwForm::normal('btn', '', ['type' => 'button', 'class' => ''], ['text' => '', 'type' => 'delete', 'prefix' => $prefix, 'modal_id' => 'delete_data', 'modal_data' => $data]);
          }
          ?>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>