<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'credit_discount'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$customer_id = $_GET['user_id'];
$friend_id = $_GET['friend_id'];
$where = [
  'upline_user_id' => $customer_id,
  'username' => $_POST['username']
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$data_list = nga_user::selectUserDownline($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
// Aww::display($list);
?>
<tbody data-total_count="<?= $total_count ?>">
  <?php foreach ($list as $key => $invite_list) {
    $table_active = ($invite_list['id'] == $friend_id) ? 'active' : '';
    if ($invite_list['upline3_user_id'] && $invite_list['upline3_user_id'] == $customer_id) {
      $mlm = '(สายชั้นที่ 3)';
    } else if ($invite_list['upline2_user_id'] && $invite_list['upline2_user_id'] == $customer_id) {
      $mlm = '(สายชั้นที่ 2)';
    } else {
      $mlm = '(สายชั้นที่ 1)';
    }
  ?>
    <tr class="tr-link cursor-pointer <?= $table_active; ?>" data-link="?c=<?= $code ?>&id=<?= $customer_id ?>&page=6&friend_id=<?= $invite_list['id'] ?>&upline_id=<?= $customer_id ?>">
      <td nowrap class=" vertical-center my-auto">
        <div class="text-vertical-center pt-8px">
          <?= $invite_list['username'] . ', ' . $invite_list['bank_name'] . ', ' . $mlm; ?>
        </div>
      </td>
      <td nowrap class="text-right vertical-center my-auto">
        <div class="text-vertical-center pt-8px">
          <?= number_format($invite_list['sum_upline_receive'], 2); ?>
        </div>
      </td>
      <td nowrap class="vertical-center text-center">
        <?php if ($invite_list['receive_status'] == 'waiting') { ?>
          <div class="text-vertical-center pt-8px text-orange">
            รอรับ
          </div>
        <?php } else if ($invite_list['receive_status'] == 'completed') { ?>
          <div class="text-vertical-center pt-8px text-success">
            สำเร็จ
          </div>
        <?php } ?>
      </td>
      <td nowrap class="thin-cell vertical-center ">
        <?= file_get_contents('./../assets/icon/icon-arrow-right.svg') ?>
      </td>
    </tr>
  <?php } ?>
  <?php /* 
  เก็บไว้ก่อน จะกลับมาลบอีกทีต้องดักเงื่อนไข ยอดรับรวม กับ รับเงิน เสร็จ
  <tr class="tr-link cursor-pointer" data-link="">
    <td nowrap class=" vertical-center my-auto">
      <div class="text-vertical-center pt-8px">
        89Bvia9379, ฐากูร ณ หนองคาย
      </div>
    </td>
    <td nowrap class="text-right vertical-center my-auto">
      <div class="text-vertical-center pt-8px">
        22,067.00
      </div>
    </td>
    <td nowrap class="vertical-center">
      <div class="text-vertical-center pt-8px text-success">
        สำเร็จ
      </div>
    </td>
    <td nowrap class="thin-cell vertical-center ">
      <?= file_get_contents('./../assets/icon/icon-arrow-right.svg') ?>
    </td>
  </tr>
  */ ?>


</tbody>