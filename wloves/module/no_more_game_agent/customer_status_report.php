<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'customer_status_report'];
require_once '../../.framework/import.php';
$current_user = User::getCurrentUserID();

$code = $_GET['c'];
if ($_POST) {

  if (isset($_POST['submit_activate_user'])) {
    $result = nga_user::setUserStatusActivate($code, $_POST['id']);
  } else if (isset($_POST['submit_deactivate_user'])) {
    $result = nga_user::setUserStatusDeActivate($code, $_POST['id']);
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
    'value' => '0',
    'text' => 'ใช้งาน'
  ],
  [
    'value' => '1',
    'text' => 'ไม่ใช้งาน'
  ],
];

$total_stat = nga_user::selectUserStatusStatistics($code);
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
          รายงานสถานะลูกค้า </div>
        <div class="font-14px text-sub ml-10px">
          แจ้งสถานะปัจจุบันของลูกค้าภายในระบบ
        </div>
      </div>
    </div>
    <hr>
    <div class="form-row px-10px">
      <div class="col-lg-3">
        <div class="card-customer-bg green">
          จำนวนลูกค้าทั้งหมด
          <p class="mb-0"><span class="amount"><?= number_format($total_stat['user_all_count'], 0); ?></span> ราย</p>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card-customer-bg blue">
          จำนวนลูกค้าที่ใช้งาน
          <p class="mb-0"><span class="amount"><?= number_format($total_stat['user_activate_count'], 0); ?></span> ราย</p>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card-customer-bg red">
          จำนวนลูกค้าที่ไม่ได้ใช้งาน (ไม่เข้าสู่ระบบเกิน 60 วัน)
          <p class="mb-0"><span class="amount"><?= number_format($total_stat['user_deactivate_count'], 0); ?></span> ราย</p>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="card-customer-bg yellow">
          จำนวนลูกค้าที่ใช้งาน แต่มีบัญชีซ้ำ
          <p class="mb-0"><span class="amount"><?= number_format($total_stat['user_activate_duplicate_count'], 0); ?></span> ราย</p>
        </div>
      </div>
    </div>
  </div>



  <div class="bg-whites table-mx-0">
    <div id="customer_status_report" class="container-pagination bg-whites  no-border-radius" <?= Homepagify::createHomepagify('customer_status_report', '?c=' . $code, '', 'ลูกค้า') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="last_active" data-filter="<?= Homepagify::dataFilter('last_active', 'date') ?>">วันที่,เวลาใช้งานล่าสุด</th>
              <th nowrap data-sort="day_diff" data-filter="<?= Homepagify::dataFilter('day_diff', 'number') ?>" class="">ไม่ได้เข้าสู่ระบบ (วัน)</th>
              <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">ยูสเซอร์ (Agent)</th>
              <th nowrap data-sort="bank_number" data-filter="<?= Homepagify::dataFilter('bank_number', 'number') ?>" class="">ธนาคาร</th>
              <th nowrap data-sort="is_deactivate" data-filter="<?= Homepagify::dataFilter('is_deactivate', 'select', $status_list) ?>">สถานะ</th>
              <th nowrap class="thin-cell"></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

  <?php Tiwdal::startModal('activate_user_modal', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="">
    <div class="modal-content">
      <div class="modal-body">
        <div class="font-16px text-uppercase font-SemiBold text-center mb-10px">เปลี่ยนสถานะเปิดใช้งานยูสเซอร์</div>
        <div class="text-secondary text-center">ท่านแน่ใจหรือไม่ว่าต้องการ <span class="text-primary text-uppercase">“เปิดใช้งานยูสเซอร์”</span><br>การเปิดของคุณจะไม่ส่งผลต่อประวัติการใช้งานที่ผ่านไปแล้ว<br>และยังสามารถเข้าสู่ระบบได้ปกติ แต่จะมีผลกับการฝากเงิน กรณีเลขบัญชี 4 ตัวท้ายซ้ำ</div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="{id}">
        <div class="d-flex justify-content-end m--5px w-100">
          <button class="btn btn-close-modal min-w-80px m-5px" data-dismiss="modal">ยกเลิก</button>
          <?= TiwForm::normal('btn', '', ['name' => 'submit_activate_user', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn-primary'], ['text' => 'ยืนยัน']); ?>
        </div>
      </div>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('deactivate_user_modal', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="">
    <div class="modal-content">
      <div class="modal-body">
        <div class="font-16px text-uppercase font-SemiBold text-center mb-10px">เปลี่ยนสถานะเปิดไม่ได้ใช้งานยูสเซอร์</div>
        <div class="text-secondary text-center">ท่านแน่ใจหรือไม่ว่าต้องการ<span class="text-danger text-uppercase">“ปิดใช้งานยูสเซอร์”</span><br>การเปิดของคุณจะไม่ส่งผลต่อประวัติการใช้งานที่ผ่านไปแล้ว<br>และยังสามารถเข้าสู่ระบบได้ปกติ แต่จะมีผลกับการฝากเงิน กรณีเลขบัญชี 4 ตัวท้ายซ้ำ
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" name="{id}">
        <div class="d-flex justify-content-end m--5px w-100">
          <button class="btn btn-close-modal min-w-80px m-5px" data-dismiss="modal">ยกเลิก</button>
          <?= TiwForm::normal('btn', '', ['name' => 'submit_deactivate_user', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn-danger'], ['text' => 'ยืนยัน']); ?>
        </div>
      </div>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>
</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>