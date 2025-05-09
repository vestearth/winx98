<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'user_id' => $_GET['id'],
  'insert_date' => $_POST['insert_date'],
  'credit_point_receive' => $_POST['credit_point_receive'],
  'status' => $_POST['status'],
  'promotion_name' => $_POST['promotion_name'],
];
if ($_POST['status'] == 'all') {
  unset($where['status']);
}
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];

$data_list = nga_management::selectPromotionUseHistory($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $promotion) {
    if ($promotion['type'] == 'credit') {
      $type = 'เครดิต';
    } else if ($promotion['type'] == 'point') {
      $type = 'แต้ม';
    } else {
      $type = '';
    }
  ?>
    <tr>
      <td nowrap class="thin-cell">
        <div><?= Aww::formatDate($promotion['insert_date_time'], 'd/m/Y H:i'); ?></div>
      </td>
      <td nowrap class="thin-cell text-right ">
        <div class="pl-30px">
          <?= number_format($promotion['credit_point_receive'], 2); ?>
        </div>
      </td>
      <td nowrap class="thin-cell">
        <div class="form-row">
          <div class="col-8 text-center">
            <div class='pr-10px d-flex'>
              <?php if ($promotion['status'] == 'confirm') { ?>
                <div class="px-5px size-12px">
                  <?= file_get_contents("./../assets/icon/icon-dot-green.svg"); ?>
                </div>
                <div>ได้รับ<?= $type ?>แล้ว</div>
              <?php } else { ?>
                <div class="px-5px size-12px">
                  <?= file_get_contents("./../assets/icon/icon-dot-yellow.svg"); ?>
                </div>
                <div>ยังไม่ได้รับ<?= $type ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="col-4">
          </div>
        </div>
      </td>
      <td nowrap>
        <?= $promotion['promotion_name']; ?>
      </td>
      <!-- <td nowrap>
        0 <span class="text-red">(Mock up)</span>
      </td>
      <td nowrap>
        0 <span class="text-red">(Mock up)</span>
      </td>
      <td nowrap>
        0 <span class="text-red">(Mock up)</span>
      </td> -->
    </tr>
  <?php } ?>
</tbody>