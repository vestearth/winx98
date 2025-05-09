<?php
$link = '?c=' . $_GET['c'] . '&page=' .  $_GET['page'] . '&is_info=1';
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$get_current_user =  User::getCurrent();
$arr_admin_for_bot_sleep = ['admin', 'bowadmin', 'tamadmin', 'earthadmin', 'artadmin'];

if ($_POST) {
  if (isset($_POST['submit_edit_bot_setting'])) {
    $is_open = isset($_POST['is_open']) ? $_POST['is_open'] : 0;
    $is_deposit = isset($_POST['is_deposit']) ? $_POST['is_deposit'] : 0;
    $is_withdraw = isset($_POST['is_withdraw']) ? $_POST['is_withdraw'] : 0;
    $data = [
      'bot_name' => $_POST['bot_name'],
      'is_open' => $is_open,
      'is_deposit' => $is_deposit,
      'is_withdraw' => $is_withdraw,
      // 'sleep_time' => isset($_POST['sleep_time']) ? $_POST['sleep_time'] :  []
      // 'vpn' => 'vpn',
    ];
    if (in_array($get_current_user['username'], $arr_admin_for_bot_sleep)) {
      $data['sleep_time'] = isset($_POST['sleep_time']) ? $_POST['sleep_time'] :  [];
    }

    $result = nga_management_bot::updateBotGroup($code, $id, $data);
    $response_redirect = 'system_database.php?c=' . $code . '&page=8&is_info=1&id=' . $_GET['id'];
  } else if (isset($_POST['submit_edit_bank_bot'])) {
    $kbank_data = (isset($_POST['kbank_data']) && $_POST['kbank_data'] != '') ? $_POST['kbank_data'] : '';
    $scb_version = (isset($_POST['scb_version']) && $_POST['scb_version'] != '') ? $_POST['scb_version'] : '';
    $device_id = (isset($_POST['device_id']) && $_POST['device_id'] != '') ? $_POST['device_id'] : '';
    $data = [
      'bank_account_no' => $_POST['bank_account_no'],
      'bank_account_name' => $_POST['bank_account_name'],
      'user_name' => $_POST['user_name'],
      'password' => $_POST['password'],
      'otp_tel_no' => $_POST['otp_tel_no'],
      'sum_money_swap_bank' => $_POST['sum_money_swap_bank'],
      'transaction_count_swap_bank' => $_POST['transaction_count_swap_bank'],
      'device_id' => $device_id,
      'pin' => $_POST['pin'],
      'scb_version' => $scb_version,
      'kbank_data' => $kbank_data,
    ];
    $result = nga_management_bot::updateBotGroupList($code, $_POST['id'], $data, $_FILES['qr_code']);
  } else if (isset($_POST['submit_add_bank_bot'])) {
    $kbank_data = (isset($_POST['kbank_data']) && $_POST['kbank_data'] != '') ? $_POST['kbank_data'] : '';
    $scb_version = (isset($_POST['scb_version']) && $_POST['scb_version'] != '') ? $_POST['scb_version'] : '';
    $device_id = (isset($_POST['device_id']) && $_POST['device_id'] != '') ? $_POST['device_id'] : '';
    $data = [
      'bank_account_no' => $_POST['bank_account_no'],
      'bank_account_name' => $_POST['bank_account_name'],
      'user_name' => $_POST['user_name'],
      'password' => $_POST['password'],
      'otp_tel_no' => $_POST['otp_tel_no'],
      'sum_money_swap_bank' => $_POST['sum_money_swap_bank'],
      'transaction_count_swap_bank' => $_POST['transaction_count_swap_bank'],
      'device_id' => $device_id,
      'pin' => $_POST['pin'],
      'scb_version' => $scb_version,
      'kbank_data' => $kbank_data,
    ];
    $result = nga_management_bot::addNewBotGroupList($code, $_GET['id'], $data, $_FILES['qr_code']);
  } else if (isset($_POST['submit_delete_bank_bot'])) {
    $result = nga_management_bot::deleteBotGroupListByID($code, $_POST['id']);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};

?>
<div class="form-row m-0">
  <div class="col-12 p-0 mb--10px">
    <div class="editable-card core-new border-radius-0 mb-10px">
      <div class="editable-card-header-back pl-15px py-10px font-13px d-flex border-radius-0">
        <a class="text-secondary" href="system_database.php?c=<?= $_GET['c'] ?>&page=8">ตั้งค่า BOT</a>
        <span class="px-5px">></span>
        <span class="text-primary">รายละเอียด BOT</span>
      </div>
    </div>
  </div>
  <div class="col-12 p-0 mb--10px ">
    <?php
    include 'bot_detail_info.php';
    ?>
  </div>
</div>


<?php Tiwdal::startModal('delete_bot_bank', ''); ?>
<form method="post">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-body mt-30px">
    <h3 class="text-center font-16px font-SemiBold text-uppercase">ลบบัญชีธนาคารที่ใช้ BOT</h3>
    <p class="mb-5px text-center">
      คุณต้องการ <span class="text-danger text-uppercase"> “ลบบัญชีธนาคารที่ใช้ BOT”</span> นี้ใช่หรือไม่
    </p>
  </div>
  <div class="modal-footer d-flex justify-content-between">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-danger w-100px" name="submit_delete_bank_bot">Delete</button>
  </div>
</form>
<?php Tiwdal::endModal() ?>