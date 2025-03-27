<?php
require_once '../.framework/import.php';
Structure::loadMetaForAjax('../');
$code = Aww::API_CODE['nmg'];
$user_data = User::getCurrent();

$where = [
  'user_id' => nga_user::getDownlineUserIDs($code, $user_data['id']),
  'is_wallet' => 1,
  'status' => 'completed'
];

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : ['transaction_date_time' => 'DESC']
];

$user_earning = nga_user::selectuserCreditTransaction($code, $where, $options);
$data_list = isset($user_earning['list']) ? $user_earning['list'] : [];
$total_count = isset($user_earning['total_count']) ? $user_earning['total_count'] : 0;
if (nga_user::getDownlineUserIDs($code, $user_data['id'])) {
?>
  <tbody data-total_count="<?= $total_count; ?>">
    <?php
    foreach ($data_list as $list) {
    ?>
      <tr>
        <td nowrap class="text-white">
          <?= $list['customer_username']; ?>
        </td>
        <td nowrap class="text-white">
          <?= $list['customer_bank_name']; ?>
        </td>
        <td nowrap class="text-white">
          <?= Aww::formatDate($list['transaction_date_time'], 'd/m/Y, H:i'); ?>
        </td>
        <td nowrap class="text-white">
          <?php
          if ($list['transaction_type'] == 'deposit') {
            echo number_format($list['credit_amount'], 2);
          } else {
            echo '';
          }
          ?>
        </td>
        <td nowrap class="text-white">
          <?php
          if ($list['transaction_type'] == 'withdraw') {
            echo number_format($list['credit_amount'], 2);
          } else {
            echo '';
          }
          ?>
        </td>

      </tr>
    <?php } ?>
  </tbody>
<?php } ?>