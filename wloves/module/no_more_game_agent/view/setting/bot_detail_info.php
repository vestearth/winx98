<?php
if ($_POST) {
  if (isset($_POST['submit_swap_bot_list'])) {
    $code_swap = 'func_uwklw_manage_bot_group_list';
    $current_id = $_POST['id'];
    $move_to_id = $_POST['move_to_id'];
    $result = Amst::swap($code_swap, $current_id, $move_to_id);
    if ($result) {
      $response_message = 'เปลี่ยนลำดับกลุ่ม BOT สำเร็จ';
      $response_status = 'success';
    } else {
      $response_message = 'เปลี่ยนลำดับกลุ่ม BOT ไม่สำเร็จ';
      $response_status = 'error';
    }
  }
  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    // $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}
$bot_data = nga_management_bot::getBotGroupByID($code, $id);
$get_current_user =  User::getCurrent();
$arr_admin_for_bot_sleep = ['admin', 'bowadmin', 'tamadmin', 'earthadmin', 'artadmin'];

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL            => 'https://scbappv.wolve.dev/get_scb_current_version',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING       => '',
  CURLOPT_MAXREDIRS      => 10,
  CURLOPT_TIMEOUT        => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST  => 'GET',
  CURLOPT_POSTFIELDS     => '{}',
  CURLOPT_HTTPHEADER     => array(),
));


$current_version = curl_exec($curl);
curl_close($curl);

if ($current_version) {
  if ($current_version == 'App version will update') {
    $current_version = 'ไม่สามารถตรวจสอบเวอร์ชันได้';
  } else if ($current_version == 'Fail to get current app version') {
    $current_version = 'ไม่สามารถตรวจสอบเวอร์ชันได้';
  }
}

$arr_sleep_time = [];

for ($i = 0; $i < 24; $i++) {
  $arr_sleep_time[] = [
    'value' => $i,
    'text' => (($i < 10) ? '0' : '') . $i . ':00'
  ];
}

$bot_sleep_time = ($bot_data['sleep_time']) ? json_decode($bot_data['sleep_time'], true) : [];

?>
<div class="col-12 p-0">
  <!-- style="min-height: calc(100vh - 120px);" -->
  <div class="editable-card border-radius-0 mb-10px">
    <form method="post" enctype='multipart/form-data' id="product_form">
      <div class="d-flex justify-content-between align-items-center px-15px py-10px flex-wrap">
        <div class="">
          <p class="font-weight-bold mb-0">รายละเอียด BOT - <span class="text-primary">BOT_SCB</span></p>
          <p class="mb-0">จัดการรายละเอียดกลุ่ม BOT และตั้งค่าเงื่อนไขต่าง ๆ</p>
        </div>
        <div class="d-flex align-items-center">
          <?php if ($is_edit) { ?>
            <a href="system_database.php?c=<?= $_GET['c'] ?>&page=<?= $_GET['page']; ?>&is_info=1&id=<?= $id; ?>">
              <button type="button" class="btn btn-close-modal mr-5px w-80px min-h-45px" style="color:black!important">ยกเลิก</button>
            </a>
            <?php TiwForm::normal('btn', '', ['name' => 'submit_update_data', 'class' => 'w-120px'], ['type' => 'submit', 'text' => 'บันทึก']); ?>
          <?php } else { ?>
            <a href="system_database.php?c=<?= $_GET['c'] ?>&page=<?= $_GET['page']; ?>&is_info=1&is_edit=1&id=<?= $id; ?>">
              <button type="button" class="btn btn-outline-info w-120px mr-10px">แก้ไขข้อมูล</button>
            </a>
          <?php } ?>
        </div>
      </div>

      <hr class="my-0">
      <div class="px-20px py-10px">


        <div class="title_italic font-16px font-Bold mb-10px">รายละเอียด</div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">สถานะ
              </label>
            </div>
            <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
              <?php if ($is_edit) {
                if ($bot_data['is_open']) {
                  $open_check = true;
                } else {
                  $open_check = false;
                }
              ?>
                <?= TiwForm::normal('checkbox', '1', ['name' => 'is_open', 'checked' => $open_check], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน<span>', 'is_on_off' => true]); ?>
              <?php } else { ?>
                <?php if ($bot_data['is_open']) { ?>
                  <label class="font-15px font-SemiBold text-success pt-7px">
                    เปิดใช้งาน
                  </label>
                <?php } else { ?>
                  <label class="font-15px font-SemiBold text-danger pt-7px">
                    ปิดใช้งาน
                  </label>
                <?php } ?>
              <?php } ?>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">ชื่อ BOT
                <?php if ($is_edit) { ?>
                  <span class="text-danger">*</span>
                <?php } ?>
              </label>
            </div>
            <div class="col-lg-5 font-16px font-Medium">
              <?php if ($is_edit) { ?>
                <?= TiwForm::normal('text', $bot_data['bot_name'], ['name' => 'bot_name', 'placeholder' => 'กรอก', 'required' => 'true']); ?>
              <?php } else { ?>
                <label class="font-15px font-SemiBold text-secondary pt-7px">
                  <?= $bot_data['bot_name']; ?>
                </label>
              <?php } ?>
            </div>
          </div>
        </div>

        <!-- ธนาคาร  -->
        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">ธนาคาร
                <?php if ($is_edit) { ?>
                  <span class="text-danger">*</span>
                <?php } ?>
              </label>
            </div>
            <div class="col-lg-5 font-16px font-Medium">
              <label class="font-15px font-SemiBold text-secondary pt-7px d-flex align-items-center">
                <div class="bank-img small-size">
                  <img src="<?= $bot_data['bank_image'] ?>" class=''>
                </div>
                <div class="mt-3px ml-5px">
                  <?= $bot_data['bank_name_th']; ?>
                </div>
              </label>
            </div>

          </div>
        </div>

        <!-- การใช้งาน  -->
        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">
                การใช้งาน
              </label>
            </div>
            <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
              <div class="d-flex">
                <?php if ($is_edit) {
                  $is_deposit = ($bot_data['is_deposit']) ? true : false;
                  $is_withdraw = ($bot_data['is_withdraw']) ? true : false;
                ?>
                  <?= TiwForm::normal('checkbox', 1, ['checked' => $is_deposit, 'name' => 'is_deposit',], ['style' => '3', 'label' => 'ฝาก']); ?>
                  <?= TiwForm::normal('checkbox', 1, ['checked' => $is_withdraw, 'name' => 'is_withdraw', 'class' => 'ml-25px'], ['style' => '3', 'label' => 'ถอน']); ?>
              </div>
            <?php } else { ?>
              <label class="font-15px font-SemiBold text-secondary pt-7px">
                <div class="d-flex align-items-center">
                  <?= file_get_contents('assets/icon/check-circle.svg'); ?>
                  <div class="ml-5px">
                    <?php if ($bot_data['is_deposit'] && $bot_data['is_withdraw']) {
                      echo 'ฝาก/ถอน';
                    } else if ($bot_data['is_deposit']) {
                      echo 'ฝาก';
                    } else if ($bot_data['is_withdraw']) {
                      echo 'ถอน';
                    }
                    ?>
                  </div>
                </div>
              </label>
            <?php } ?>
            </div>

          </div>
        </div>

        <!-- VPN  -->
        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">VPN
                <?php if ($is_edit) { ?>
                  <span class="text-danger">* (Wait API call vpn list)</span>
                <?php } ?>
              </label>
            </div>
            <div class="col-lg-5 font-16px font-Medium">
              <?php if ($is_edit) { ?>
                <?php
                $options = ['list' => [
                  [
                    'value' => '1',
                    'name' => 'Hong Kong',
                  ],
                  [
                    'value' => '2',
                    'name' => 'Canada',
                  ],
                ],];
                TiwForm::normal('select', '1', ['name' => ''], $options);

                ?>
              <?php } else { ?>
                <label class="font-15px font-SemiBold text-secondary pt-7px text-capitalize">
                  <?= $bot_data['vpn']; ?>
                </label>
              <?php } ?>
            </div>
          </div>
        </div>

        <!-- sleep bot  -->
        <?php if (in_array($get_current_user['username'], $arr_admin_for_bot_sleep)) { ?>
          <div class="form-group">
            <div class="form-row">
              <div class="col-lg-3">
                <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">
                  เวลาปิดใช้งาน
                </label>
              </div>
              <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                <?php if ($is_edit) { ?>
                  <div class="d-flex flex-wrap">
                    <?php
                    foreach ($arr_sleep_time as $value) {
                      echo '<div class="mr-10px mb-10px">';
                      echo TiwForm::normal('checkbox', $value['value'], ['checked' => (in_array($value['value'], $bot_sleep_time)) ? 'true' : '', 'name' => 'sleep_time[]'], ['style' => '3', 'label' => $value['text']]);
                      echo '</div>';
                    }
                    ?>
                  </div>
                <?php } else { ?>
                  <?php if ($bot_sleep_time) { ?>
                    <?php
                    $comma_check = (count($bot_sleep_time) > 1) ? ',' : '';
                    $count_lenge = count($bot_sleep_time);
                    ?>
                    <div class="d-flex flex-wrap">
                      <div class="mr-5px">
                        <?= file_get_contents('assets/icon/check-circle.svg'); ?>
                      </div>
                      <?php
                      foreach ($arr_sleep_time as $value) {
                        foreach ($bot_sleep_time as $key => $api_val) {
                          if ($value['value'] == $api_val) {
                            echo '<p class="mr-10px"> ' . $value['text'] . ((($count_lenge - 1) == $key) ? '' : $comma_check) . '</p>';
                          }
                        }
                      }
                      ?>
                    </div>
                  <?php } else { ?>
                    <p>-</p>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>
      <input type="hidden" name="submit_edit_bot_setting">
    </form>
  </div>
  <div class="editable-card border-radius-0 mb-50px">
    <div class="d-flex align-items-center justify-content-between my-5px mx-15px">
      <div class="my-5px">
        <div class="font-18px text-info font-SemiBold">บัญชีธนาคารที่ใช้ BOT
        </div>
        <div class="font-15px text-secondary">จัดการบัญชีธนาคารในกลุ่ม BOT </div>
      </div>
      <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'h-40px'], ['type' => 'button', 'text' => '+ เพิ่มบัญชีธนาคาร', 'modal_id' => 'add_bot_bank', 'modal_data' => []]); ?>

    </div>
    <div id="bot_setting_detail" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('bot_setting_detail', '?c=' . $_GET['c'] . '&id=' . $id, '', 'บัญชีธนาคาร',) ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search">
          <thead>
            <tr>
              <th class="thin-cell"></th>
              <th nowrap data-sort="bank_account_no" data-filter="<?= Homepagify::dataFilter('bank_account_no', 'text') ?>">เลขที่บัญชี</th>
              <th nowrap data-sort="bank_account_name" data-filter="<?= Homepagify::dataFilter('bank_account_name', 'text', []) ?>">ชื่อบัญชี</th>
              <th nowrap data-sort="user_name" data-filter="<?= Homepagify::dataFilter('user_name', 'text', []) ?>">Username</th>
              <th nowrap>เงื่อนไขการสลับบัญชี</th>
              <th nowrap>จำนวนรายการฝาก</th>
              <th nowrap class="thin-cell">เปิดใช้งานสลับบอท</th>
              <th nowrap class="thin-cell"></th>
            </tr>
          </thead>

        </table>
      </div>
    </div>
  </div>
</div>

<?php Tiwdal::startModal('add_bot_bank', 'modal-md',); ?>
<form method="post" enctype="multipart/form-data">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-header">
    <h5 class="modal-title">เพิ่มบัญชีธนาคาร</h5>
  </div>
  <div class="modal-body">
    <div class="form-row">
      <div class="col-md-5 d-flex align-items-center">
        <label>ธนาคาร</label>
      </div>
      <div class="col-md-7 d-flex align-items-center">
        <div class="d-flex">
          <div class="bank-img small-size">
            <img src="<?= $bot_data['bank_image'] ?>" name='bank_image'>
          </div>
          <div name="bank_name_th" class="ml-5px"><?= $bot_data['bank_name_th'] ?></div>
        </div>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>เลขที่บัญชี<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('number', '', ['name' => 'bank_account_no', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>ชื่อบัญชี<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('text', '', ['name' => 'bank_account_name', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>Line Username<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('text', '', ['name' => 'user_name', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>Line Password<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('text', '', ['name' => 'password', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>เบอร์โทรศัพท์สำหรับรับ OTP<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('number', '', ['name' => 'otp_tel_no', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>สลับบัญชีเมื่อมียอดฝากเกิน<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('number', '', ['name' => 'sum_money_swap_bank', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>สลับบัญชีเมื่อมีรายการฝากเกิน<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('number', '', ['name' => 'transaction_count_swap_bank', 'required' => 'true'], []); ?>
      </div>
      <?php if ($bot_data['bank_abb'] == 'SCB') { ?>
        <div class="col-md-5 d-flex align-items-center">
          <label>Device ID<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('text', '', ['name' => 'device_id', 'required' => 'true'], []); ?>
        </div>
        <div class="col-md-5 d-flex align-items-center mt-10px">
          <label>คู่มือ Device ID<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7 mt-10px">
          <a href="https://docs.google.com/document/d/12wMk1QCSjOHcTbF3vRYvFdwNSSWai-pG/edit" target="_blank">ลิงก์คู่มือ</a>
        </div>
        <div class="col-md-5 d-flex align-items-center">
          <label>PIN<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('number', '', ['name' => 'pin', 'required' => 'true'], []); ?>
        </div>
        <div class="col-md-5 d-flex align-items-center mt-10px">
          <label>SCB Version<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('text', $current_version, ['name' => 'scb_version', 'required' => 'true', 'readonly' => 'true'], []); ?>
        </div>
      <?php } else if ($bot_data['bank_abb'] == 'KBANK') { ?>
        <div class="col-md-5 d-flex align-items-center">
          <label>KBANK Data<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('textarea', '', ['name' => 'kbank_data', 'required' => 'true'], []); ?>
        </div>
        <div class="col-md-5 d-flex align-items-center">
          <label>PIN<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('number', '', ['name' => 'pin', 'required' => 'true'], []); ?>
        </div>
      <?php } ?>
      <div class="col-md-5 d-flex align-items-center">
        <label>QR Code<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?php
        $options = [
          'width' => '200px',
          'height' => '100%',
          'bg-img' => 'assets/image/bg_upload.png',
          'is_btn' => 0,
        ];
        TiwForm::normal('upload-img', 'assets/image/bg_upload.png', ['name' => 'qr_code', 'title' => 'แนบไฟล์รูปภาพ'], $options);
        ?>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ยกเลิก</button>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_add_bank_bot', 'type' => 'submit'], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('edit_bot_bank', 'modal-md',); ?>
<form method="post" enctype="multipart/form-data">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-header">
    <h5 class="modal-title">แก้ไขบัญชีธนาคาร</h5>
  </div>
  <div class="modal-body">
    <div class="form-row">
      <div class="col-md-5 d-flex align-items-center">
        <label>ธนาคาร</label>
      </div>
      <div class="col-md-7 d-flex align-items-center">
        <div class="d-flex">
          <div class="bank-img small-size">
            <img src="./assets/image/scb.png" name='{bank_image}'>
          </div>
          <span name="{bank_name_th}" class="ml-5px">ธนาคารไทยพาณิชย์</span>
        </div>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>เลขที่บัญชี<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('text', '', ['name' => '{bank_account_no}', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>ชื่อบัญชี<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('text', '', ['name' => '{bank_account_name}', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>Username<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('text', '', ['name' => '{user_name}', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>Password<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('text', '', ['name' => '{password}', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>เบอร์โทรศัพท์สำหรับรับ OTP<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('number', '', ['name' => '{otp_tel_no}', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>สลับบัญชีเมื่อมียอดฝากเกิน<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('number', '', ['name' => '{sum_money_swap_bank}', 'required' => 'true'], []); ?>
      </div>
      <div class="col-md-5 d-flex align-items-center">
        <label>สลับบัญชีเมื่อมีรายการฝากเกิน<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?= TiwForm::normal('number', '', ['name' => '{transaction_count_swap_bank}', 'required' => 'true'], []); ?>
      </div>
      <?php if ($bot_data['bank_abb'] == 'SCB') { ?>
        <div class="col-md-5 d-flex align-items-center">
          <label>Device ID<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('text', '', ['name' => '{device_id}', 'required' => 'true'], []); ?>
        </div>
        <div class="col-md-5 d-flex align-items-center mt-10px">
          <label>คู่มือ Device ID<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7 mt-10px">
          <a href="https://docs.google.com/document/d/12wMk1QCSjOHcTbF3vRYvFdwNSSWai-pG/edit" target="_blank">ลิงก์คู่มือ</a>
        </div>
        <div class="col-md-5 d-flex align-items-center">
          <label>PIN<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('number', '', ['name' => '{pin}', 'required' => 'true'], []); ?>
        </div>
        <div class="col-md-5 d-flex align-items-center">
          <label>SCB Version<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('text', $current_version, ['name' => 'scb_version', 'required' => 'true', 'readonly' => true], []); ?>
        </div>
      <?php } else if ($bot_data['bank_abb'] == 'KBANK') { ?>
        <div class="col-md-5 d-flex align-items-center">
          <label>KBANK Data<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('textarea', '', ['name' => '{kbank_data}', 'required' => 'true'], []); ?>
        </div>
        <div class="col-md-5 d-flex align-items-center">
          <label>PIN<span class="text-danger">*</span></label>
        </div>
        <div class="col-md-7">
          <?= TiwForm::normal('number', '', ['name' => '{pin}', 'required' => 'true'], []); ?>
        </div>
      <?php } ?>
      <div class="col-md-5 d-flex align-items-center">
        <label>QR Code<span class="text-danger">*</span></label>
      </div>
      <div class="col-md-7">
        <?php
        $options = [
          'width' => '200px',
          'height' => '100%',
          'bg-img' => 'assets/image/bg_upload.png',
          'is_btn' => 0,
          'preview_name' => '{qr_code}',
        ];
        TiwForm::normal('upload-img', 'assets/image/bg_upload.png', ['name' => 'qr_code', 'title' => 'แนบไฟล์รูปภาพ'], $options);
        ?>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <input type="hidden" name="{id}">
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ยกเลิก</button>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_bank_bot', 'type' => 'submit'], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>