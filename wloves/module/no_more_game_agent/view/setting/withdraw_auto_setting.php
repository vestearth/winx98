<?php
$link = '?c=' . $_GET['c'] . '&page=' .  $_GET['page'] . '&is_info=1';
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$required_symbol = ($is_edit) ? '<span class="text-danger">*</span>' : '';

$get_auto_wd = nga_management::getAutoDepositWithdraw($code);
if ($_POST) {
  if (isset($_POST['submit_edit_auto_wd'])) {
    $is_withdraw = ((isset($_POST['is_withdraw_active'])) && $_POST['is_withdraw_active'] == 'not') ? '0' : 1;
    $data = [
      'deposit_not_use_amount'  => $_POST['deposit_not_use_amount'],
      'withdraw_not_use_amount' => $_POST['withdraw_not_use_amount'],
      'withdraw_minimum'        => $_POST['withdraw_minimum'],
      'withdraw_maximum'        => $_POST['withdraw_maximum'],
      'withdraw_limit_per_day'  => $_POST['withdraw_limit_per_day'],
      'deposit_condition'       => $_POST['deposit_condition'],
      'is_withdraw_active'      => $is_withdraw,
      'withdraw_condition'      => $_POST['withdraw_condition'],
    ];

    $result = nga_management::updateAutoDepositWithdraw($code, $data);
    $response_redirect = 'system_database.php?c=' . $code . '&page=' .  $_GET['page'] . '&is_info=1&id=' . $_GET['id'];
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
  <div class="col-12 p-0 mb--10px ">
    <div class="col-12 p-0">
      <!-- style="min-height: calc(100vh - 120px);" -->
      <div class="editable-card border-radius-0 mb-10px">
        <form method="post" enctype='multipart/form-data' id="product_form">
          <div class="d-flex justify-content-between align-items-center px-15px py-10px flex-wrap">
            <div class="">
              <p class="font-weight-bold mb-0">ตั้งค่าการฝากถอนอัตโนมัติ</p>
              <p class="mb-0">จัดการเงื่อนไขการฝากถอนเงินอัตโนมัติของลูกค้าในระบบ</p>
            </div>
            <div class="d-flex align-items-center">
              <?php if ($is_edit) { ?>
                <a href="system_database.php?c=<?= $_GET['c'] ?>&page=<?= $_GET['page']; ?>&is_info=1">
                  <button type="button" class="btn btn-close-modal mr-5px w-80px " style="color:black!important">ยกเลิก</button>
                </a>
                <?php TiwForm::normal('btn', '', ['name' => 'submit_update_data', 'class' => 'min-h-35px w-120px'], ['type' => 'submit', 'text' => 'บันทึก']); ?>
              <?php } else { ?>
                <a href="system_database.php?c=<?= $_GET['c'] ?>&page=<?= $_GET['page']; ?>&is_info=1&is_edit=1">
                  <button type="button" class="btn btn-outline-info w-120px mr-10px">แก้ไขข้อมูล</button>
                </a>
              <?php } ?>
            </div>
          </div>

          <hr class="my-0">
          <div class="px-20px py-10px">


            <div class="title_italic font-16px font-Bold mb-10px"><i>การฝากอัตโนมัติ</i></div>

            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">ยอดฝากเกินนี้จะไม่ใช้ระบบ
                    ฝากอัตโนมัติ <?= $required_symbol; ?>
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                  <?php if ($is_edit) {
                    TiwForm::normal('text', $get_auto_wd['deposit_not_use_amount'], ['name' => 'deposit_not_use_amount', 'placeholder' => 'กรอก', 'required' => 'true']);
                  ?>
                  <?php } else { ?>
                    <label class="font-15px pt-7px">
                      <?= number_format($get_auto_wd['deposit_not_use_amount'], 2); ?>
                    </label>
                  <?php } ?>
                </div>
                <?php if ($is_edit) { ?>
                  <div class="col-lg-3 d-flex align-items-center text-secondary">
                    <i class="font-15px">0 คือ ปิดระบบฝากอัตโนมัติ</i>
                  </div>
                <?php } ?>
              </div>
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">ข้อตกลงและเงื่อนไขการฝาก
                    <?= $required_symbol; ?>
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                  <?php if ($is_edit) {
                    TiwForm::normal('textarea', $get_auto_wd['deposit_condition'], ['name' => 'deposit_condition', 'placeholder' => 'กรอก', 'required' => 'true', 'class' => 'min-h-100px']);
                  ?>
                  <?php } else { ?>
                    <label class="font-15px d-flex mt--15px">
                      <span style="white-space: pre-line">
                        <?= $get_auto_wd['deposit_condition']; ?>
                      </span>
                    </label>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="title_italic font-16px font-Bold mb-10px"><i>การถอนอัตโนมัติ</i></div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">
                    ปิดการถอนเงิน
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                  <?php if ($is_edit) {
                    TiwForm::normal('checkbox', 'not', ['name' => 'is_withdraw_active', ($get_auto_wd['is_withdraw_active']) ? '' : 'checked' => true], ['style' => '1']);
                  ?>
                  <?php } else {
                  ?>
                    <?php if ($get_auto_wd['is_withdraw_active']) { ?>
                      <label class="font-15px pt-7px text-danger">
                        ปิด
                      </label>
                    <?php } else { ?>
                      <label class="font-15px pt-7px text-primary">
                        เปิด
                      </label>
                    <?php }  ?>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-lg-3">
                <label class="font-15px font-SemiBold text-secondary pt-7px">
                  หมายเหตุ
                </label>
              </div>
              <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                <?php if ($is_edit) {
                  TiwForm::normal('textarea', $get_auto_wd['withdraw_condition'], ['name' => 'withdraw_condition', 'placeholder' => 'กรอก', 'class' => 'min-h-100px']);
                ?>
                <?php } else { ?>
                  <label class="font-15px d-flex mt--15px text-secondary">
                    <span style="white-space: pre-line">
                      <?= $get_auto_wd['withdraw_condition']; ?>
                    </span>
                  </label>
                <?php } ?>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">ยอดถอนเกินนี้จะไม่ใช้ระบบ
                    ถอนอัตโนมัติ <?= $required_symbol; ?>
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                  <?php if ($is_edit) {
                    TiwForm::normal('text', $get_auto_wd['withdraw_not_use_amount'], ['name' => 'withdraw_not_use_amount', 'placeholder' => 'กรอก', 'required' => 'true']);
                  ?>
                  <?php } else { ?>
                    <label class="font-15px pt-7px">
                      <?= number_format($get_auto_wd['withdraw_not_use_amount'], 2); ?>
                    </label>
                  <?php } ?>
                </div>
                <?php if ($is_edit) { ?>
                  <div class="col-lg-3 d-flex align-items-center text-secondary">
                    <i class="font-15px">0 คือ ปิดระบบฝากอัตโนมัติ</i>
                  </div>
                <?php } ?>
              </div>
            </div>

            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">ถอนเงินขั้นต่ำ <?= $required_symbol; ?></label>
                </div>
                <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                  <?php if ($is_edit) {
                    TiwForm::normal('text', $get_auto_wd['withdraw_minimum'], ['name' => 'withdraw_minimum', 'placeholder' => 'กรอก', 'required' => 'true']);
                  ?>
                  <?php } else { ?>
                    <label class="font-15px pt-7px">
                      <?= number_format($get_auto_wd['withdraw_minimum'], 2); ?>
                    </label>
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">ถอนเงินได้สูงสุด <?= $required_symbol; ?></label>
                </div>
                <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                  <?php if ($is_edit) {
                    TiwForm::normal('text', $get_auto_wd['withdraw_maximum'], ['name' => 'withdraw_maximum', 'placeholder' => 'กรอก', 'required' => 'true']);
                  ?>
                  <?php } else { ?>
                    <label class="font-15px pt-7px">
                      <?= number_format($get_auto_wd['withdraw_maximum'], 2); ?>
                    </label>
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">จำนวนการถอนไม่เกิน(ครั้ง / วัน) <?= $required_symbol; ?></label>
                </div>
                <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                  <?php if ($is_edit) {
                    TiwForm::normal('text', $get_auto_wd['withdraw_limit_per_day'], ['name' => 'withdraw_limit_per_day', 'placeholder' => 'กรอก', 'required' => 'true']);
                  ?>
                  <?php } else { ?>
                    <label class="font-15px pt-7px">
                      <?= number_format($get_auto_wd['withdraw_limit_per_day'], 0); ?>
                    </label>
                  <?php } ?>
                </div>
              </div>
            </div>

          </div>
          <input type="hidden" name="submit_edit_auto_wd">
        </form>
      </div>
    </div>
  </div>
</div>