<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'credit_discount'];
require_once '../../.framework/import.php';
$current_user = User::getCurrentUserID();

$code = $_GET['c'];
if ($_POST) {

  if (isset($_POST['submit_withdraw_customer'])) {
    $data = [
      'user_id' => $_POST['user_id'],
      'transaction_type' => 'withdraw',
      'credit_amount' => $_POST['credit_amount'],
      'transaction_by_user_id' => $current_user,
      'remark' => $_POST['remark'],
      'status' => 'completed',
      'transaction_by' => 'admin'
    ];
    $result = nga_user::addUserCreditTransaction($code, $data);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'add_withdraw',
        'detail' => 'ลดเครดิตลูกค้า ' . $_POST['credit_amount'] . ' เครดิต สาเหตุ :' . $_POST['remark'],
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

$status_list = [
  [
    'value' => 'success',
    'text' => 'สำเร็จแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ดำเนินการ'
  ],
];

$arr_remark = ['เติมเครดิตผิดยูสเซอร์', 'เติมเครดิตซ้ำ', 'เติมเครดิตโดยที่ไม่ได้แนบสลิป', 'เติมเครดิตแนบสลิปผิดยูสเซอร์', 'ลูกค้ามีสองยูสเซอร์ ทำให้เครดิตเข้าผิดยูสเซอร์', 'เลขบัญชี 4 ตัวท้ายตรงกับบัญชีฝากหน้าเว็บ', 'เลขบัญชีลูกค้า 4 ตัวท้ายเหมือนกัน ทำให้เครดิตเข้าผิดยูสเซอร์',];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('../../');
  Aww::loadAsset('assets/css/no_more_gaming.css');
  ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php
  include_once '../../structure/layout/header-default.php';
  $options = [
    'selected_fields' => ['id', 'username'],
  ];
  $select_user = nga_user::selectUser($code, [], $options);
  foreach ($select_user as $key => $data) {
    $select_user[$key]['username'] = hidePhoneNumber($data['username']);
  }
  $key_select_list_user = [
    'value' => 'id',
    'name' => 'username',
  ];
  $options_select_user = TiwForm::generateSelectData($select_user, $key_select_list_user, ['is_search' => true]);
  ?>

  <div class='bg-white mb-15px pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">
      <div class="msg col-lg-6">
        <div class='topic ml-10px'>
          รายการลดเครดิต </div>
        <div class="font-14px text-sub ml-10px">
          รายการประวัติการลดเครดิต
        </div>
      </div>
      <div class="button-panel col-lg-6 d-flex justify-content-end">
        <button class="btn-blue mx-5px px-10px" <?= Tiwdal::register('add_modal') ?>>+ เพิ่มรายการลดเครดิต</button>
      </div>
    </div>
  </div>

  <div class="bg-whites table-mx-0">
    <div id="credit_discount_list" class="container-pagination bg-whites  no-border-radius" <?= Homepagify::createHomepagify('credit_discount_list', '?c=' . $code, '', 'รายการลดเครดิต') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
              <th nowrap data-sort="credit_amount" data-filter="<?= Homepagify::dataFilter('credit_amount', 'number') ?>" class="text-right">ยอดเงิน</th>
              <th nowrap data-sort="customer_username" data-filter="<?= Homepagify::dataFilter('customer_username', 'text') ?>">รหัสลูกค้า</th>
              <th nowrap data-sort="credit_before" data-filter="<?= Homepagify::dataFilter('credit_before', 'number') ?>" class="thin-cell">เครดิต (ก่อน)</th>
              <th nowrap data-sort="credit_after" data-filter="<?= Homepagify::dataFilter('credit_after', 'number') ?>" class="thin-cell">เครดิต (หลัง)</th>
              <th nowrap>สถานะ</th>
              <th nowrap data-sort="remark" data-filter="<?= Homepagify::dataFilter('remark', 'text') ?>">เหตุผล</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

  <?php Tiwdal::startModal('add_modal', 'modal-md'); ?>
  <form method="post">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ลดเครดิตลูกค้า</h5>
      </div>
      <div class="modal-body">
        <div class="form-row">
          <div class="col-lg-4 my-auto pb-10px">
            เครดิต
          </div>
          <div class="col-lg-8  pb-10px">
            <div class="form-row">
              <div class="col-5">
                <?php TiwForm::normal('number', '', ['name' => 'credit_amount', 'class' => '', 'placeholder' => '0']); ?>
              </div>
              <div class="col-2 my-auto">
                เครดิต
              </div>
            </div>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            ยูสเซอร์(agent)
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <div class="form-row">
              <div class="col-5">
                <?php TiwForm::normal('select', '', ['name' => 'user_id'], $options_select_user); ?>
              </div>
            </div>
          </div>
          <div class="col-lg-4  my-auto pb-10px">
            เหตุผล
          </div>
          <div class="col-lg-8  my-auto pb-10px">
            <fieldset>
              <input list="remark_withdraw_credit_customer" type="text" name="remark" class="form-select form-datalist" autocomplete="off">
              <datalist id="remark_withdraw_credit_customer">
                <?php foreach ($arr_remark as $value) { ?>
                  <option value="<?= $value ?>">
                  <?php } ?>
              </datalist>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_withdraw_customer', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>