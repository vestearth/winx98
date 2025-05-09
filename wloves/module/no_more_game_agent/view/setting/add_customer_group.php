<?php
$bot_list = [];
$bot_list_api = nga_management_bot::selectBotGroupList($code, []);
foreach ($bot_list_api as $bot_data) {
  $bot_list['list'][] = [
    'value' => $bot_data['id'],
    'name' => $bot_data['bank_account_name'] . ' / ' . $bot_data['bank_account_no'],
    'img' => $bot_data['bank_image']
  ];
}

$bot_bank_list = [];
$botBank_api = nga_management_bot::selectBotGroup($code, []);
foreach ($botBank_api as $bank_bot_data) {
  $bot_bank_list['list'][] = [
    'value' => $bank_bot_data['id'],
    'name' => $bank_bot_data['bot_name'],
    'img' => $bank_bot_data['bank_image']
  ];
}
$withdraw_bot_bank_list = [];
foreach ($botBank_api as $bank_bot_data) {
  if ($bank_bot_data['is_withdraw'] == 1) {
    $withdraw_bot_bank_list['list'][] = [
      'value' => $bank_bot_data['id'],
      'name' => $bank_bot_data['bot_name'],
      'img' => $bank_bot_data['bank_image']
    ];
  }
}

if ($_POST) {
  if (isset($_POST['submit_create_user_group'])) {
    unset($_POST['submit_create_user_group']);

    // $deposit_bank_temp = [];
    // foreach ($_POST['deposit_bot_group_list_id'] as $key => $value) {
    //   $keys = $key + 1;
    //   $deposit_bank_temp[$key] = [
    //     'deposit_bot_group_list_id' => $value,
    //     'is_show_all_deposit_account' => (isset($_POST['is_show_all_deposit_account_' . $keys])) ? true : false,
    //   ];
    // }
    $data = [
      // 'name' => $_POST['name'],
      'withdraw_bot_group_id' => $_POST['withdraw_bot_group_id'],
      'deposit_bot_group_id' => $_POST['deposit_bot_group_id'],
      // 'withdraw_bot_group_list_id' => $_POST['withdraw_bot_group_list_id'],
      // 'is_show_all_withdraw_account' => (isset($_POST['is_show_all_withdraw_account'])) ? true : false,
      // 'deposit_time' => $_POST['deposit_time'],
      // 'sum_deposit' => $_POST['sum_deposit'],
      // 'is_auto_group_shift' => (isset($_POST['is_auto_group_shift'])) ? true : false,
      // 'color' => $_POST['color'],
      // 'minimum_for_cal_turn_over' => $_POST['minimum_for_cal_turn_over'],
      // 'maximum_turn_over' => $_POST['maximum_turn_over'],
      // 'minimum_turn_over' => $_POST['minimum_turn_over'],
      // 'is_active' => isset($_POST['is_active']) ? $_POST['is_active'] : '0',
      // 'turn_over_percent' => $_POST['turn_over_percent'],
      // 'turn_over_percent_customer' => $_POST['turn_over_percent_customer'],
    ];
    $result =  nga_management::addNewUserGroup($code, $data, $_FILES['img_file']);
    $response_data = (isset($result['response_data']) && $result['response_data']) ? $result['response_data'] : [];
    $response_redirect = 'system_database.php?c=' . $code . '&id=' . $response_data['insert_id'] . '&page=2&is_info=1';
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

// Mock รอลบ 
$turn_over = nga_management::getGameTurnOverSetting($code);
$list_games = [
  [
    'name' => 'เปิดไพ่',
    'is_open' => 'is_open_card_game',
    'commission' => 'card_commission',
    'commission_player' => 'card_commission_player',
  ],
  [
    'name' => 'บอร์ดเกม',
    'is_open' => 'is_open_board_game',
    'commission' => 'board_commission',
    'commission_player' => 'board_commission_player',
  ],
  [
    'name' => 'สล็อตเสี่ยงโชค',
    'is_open' => 'is_open_slot_game',
    'commission' => 'slot_commission',
    'commission_player' => 'slot_commission_player',
  ],
  [
    'name' => 'ตู้เกม Arcade',
    'is_open' => 'is_open_arcade_game',
    'commission' => 'arcade_commission',
    'commission_player' => 'arcade_commission_player',
  ],
  [
    'name' => 'คาสิโน',
    'is_open' => 'is_open_casinolive_game',
    'commission' => 'casinolive_commission',
    'commission_player' => 'casinolive_commission_player',
  ],
  [
    'name' => 'เกมตกปลา',
    'is_open' => 'is_open_fishing_game',
    'commission' => 'fishing_commission',
    'commission_player' => 'fishing_commission_player',
  ],
  [
    'name' => 'เกมกีฬา',
    'is_open' => 'is_open_sport_game',
    'commission' => 'sport_commission',
    'commission_player' => 'sport_commission_player',
  ]
];

// End Mock รอลบ 

?>
<div class="col-12 p-0 mb--10px">
  <div class="editable-card core-new border-radius-0 mb-10px">
    <div class="editable-card-header-back pl-15px py-10px font-13px d-flex border-radius-0">
      <a class="text-secondary" href="system_database.php?c=<?= $_GET['c'] ?>&page=2">จัดการกลุ่มลูกค้า </a>
      <span class="px-5px">></span>
      <span class="text-primary">รายละเอียดกลุ่มลูกค้า</span>
    </div>
  </div>
</div>
<div class="col-12 p-0">
  <div class="editable-card border-radius-0" style="min-height: calc(100vh - 120px);">
    <form method="post" enctype='multipart/form-data' id="product_form">
      <div class="d-flex justify-content-between align-items-center px-15px py-10px flex-wrap">
        <div class="">
          <p class="font-weight-bold mb-0">รายละเอียดกลุ่มลูกค้า</p>
          <p class="mb-0">จัดการรายละเอียดกลุ่มลูกค้าและตั้งค่าเงื่อนไขต่าง ๆ</p>
        </div>
        <div class="d-flex align-items-center">
          <a href="system_database.php?c=<?= $_GET['c'] ?>&page=2">
            <button type="button" class="btn btn-close-modal min-h-45px mr-5px w-80px">ยกเลิก</button>
          </a>
          <?php TiwForm::normal('btn', '', ['name' => 'submit_create_user_group', 'class' => 'w-120px'], ['type' => 'submit', 'text' => 'บันทึก']); ?>
        </div>
      </div>
      <hr class="my-0">
      <div class="px-20px py-10px">
        <div class="title_italic font-16px font-Bold mb-10px"><i>รายละเอียด</i></div>
        <div class="form-row">
          <div class="col-md-9">
            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">ชื่อกลุ่มลูกค้า
                    <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium">
                  <?= TiwForm::normal('text', '', ['name' => 'name', 'placeholder' => 'กรอก', 'required' => true]);
                  ?>
                </div>
              </div>
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">เลือกกลุ่ม Bot
                    <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium">
                  <?= TiwForm::normal('select-img', '', ['name' => 'deposit_bot_group_id', 'required' => true, 'class' => 'event_group_bank'], $bot_bank_list); ?>
                </div>
              </div>
            </div>
            <?php /* 
            <div class="form-group event_botBank_target">
              <div class="form-row align-items-center">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">ธนาคารสำหรับการฝากอัตโนมัติ
                    <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium">
                  <?php
                  TiwForm::normal('select-img', '', ['name' => 'deposit_bot_group_list_id', 'required' => true], $bot_list);
                  ?>
                </div>
                <div class="col-lg-4 d-flex align-items-center">
                  <div class="mr-10px ml-10px">
                    <?= TiwForm::normal('checkbox', '', ['name' => 'is_show_all_deposit_account'], ['style' => '3']); ?>
                  </div>
                  <div class=" font-16px font-Medium">
                    แสดงเลขบัญชีทั้งหมด
                  </div>
                </div>
              </div>
            </div>
            */ ?>
            <div class="form-group">
              <div class="form-row align-items-center">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">กลุ่ม Bot สำหรับการถอนอัตโนมัติ
                    <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium">
                  <?php
                  TiwForm::normal('select-img', '', ['name' => 'withdraw_bot_group_id', 'required' => true], $withdraw_bot_bank_list);
                  ?>
                </div>
                <?php /* 
                <div class="col-lg-4 d-flex align-items-center">
                  <div class="mr-10px ml-10px">
                    <?= TiwForm::normal('checkbox', '', ['name' => 'is_show_all_withdraw_account'], ['style' => '3']); ?>
                  </div>
                  <div class=" font-16px font-Medium">
                    แสดงเลขบัญชีทั้งหมด
                  </div>
                </div>
                */ ?>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-4 text-right">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">รูป/ไอคอน </label>
                </div>
                <div class="col-lg font-16px font-Medium ">
                  <div class="d-flex align-items-center custom_color justify-content-center">
                    <?php $options = [
                      'width' => '150px',
                      'height' => '100%',
                      'bg-img' => 'assets/image/bg_upload.png',
                    ];
                    TiwForm::normal('upload-img', '', ['name' => 'img_file'], $options); ?>
                  </div>
                  <div class="font-italic font-15px mt-10px text-center">
                    ไฟล์ .png หรือ .jpg สัดส่วน 1:1 <br> หรือ 128x128 px
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php /* 
        <div class="title_italic font-16px font-Bold mb-10px"><i>กำหนดเงื่อนไขการเลื่อนระดับ</i></div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">จำนวนครั้งที่ฝาก
                <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-lg-2 font-16px font-Medium">
              <?= TiwForm::normal('number', '', ['name' => 'deposit_time', 'placeholder' => '0', 'required' => true]); ?>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">ยอดฝากทั้งหมด
                <span class="text-danger">*</span>
              </label>
            </div>
            <div class="col-lg-2 font-16px font-Medium">
              <?= TiwForm::normal('number', '', ['name' => 'sum_deposit', 'placeholder' => '0', 'required' => true]); ?>
            </div>
          </div>
        </div>
        <div class="title_italic font-15px mb-10px font-italic">ในกรณีที่ผู้เล่นมีจำนวนครั้งที่ฝาก และยอดฝาก ตรงตามเงื่อนไขที่กำหนด ผู้เล่นสามารถเลื่อนระดับอัตโนมัติได้</div>
        <div class="form-group">
          <div class="form-row align-items-center">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">เลื่อนระดับอัตโนมัติ
              </label>
            </div>
            <div class="col-lg-5 font-16px font-Medium">
              <?= TiwForm::normal('checkbox', '', ['name' => 'is_auto_group_shift'], ['style' => '1', 'label' => 'เปิดใช้งาน', 'is_on_off' => true]); ?>
            </div>
          </div>
        </div>
        <div class="title_italic font-16px font-Bold mb-10px"><i>รายละเอียดอื่น ๆ</i></div>

        <div class="form-group mb-40px mt-20px">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">กำหนดสี</label>
            </div>
            <div class="col-lg-5 font-16px font-Medium text-primary d-flex">
              <?= TiwForm::normal('color', '#FFFFFF', ['name' => 'color', 'class' => 'color_form ', 'style' => ''], []); ?>
              <div class="ml-15px pt-5px">
                #00000
              </div>
            </div>
          </div>
          <div class="form-row form-group mt-10px">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">ประเภทการคืนยอด</label>
            </div>
            <div class="col-lg-5 font-16px font-Medium d-flex">
              <div class="pt-5px">
                ยอดเสีย
              </div>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">ยอดเล่นขั้นต่ำ</label>
            </div>
            <div class="col-lg-3 font-16px font-Medium text-primary d-flex">
              <?php
              TiwForm::normal('number', '', ['name' => 'minimum_for_cal_turn_over', 'class' => 'min-w-270px mb-0']);
              ?>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">ยอดคืนสูงสุด</label>
            </div>
            <div class="col-lg-3 font-16px font-Medium text-primary d-flex">
              <?php
              TiwForm::normal('number', '', ['name' => 'maximum_turn_over', 'class' => 'min-w-270px mb-0']);
              ?>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">ยอดคืนต่ำสุด</label>
            </div>
            <div class="col-lg-3 font-16px font-Medium text-primary d-flex pt-7px">
              <?php
              TiwForm::normal('number', '', ['name' => 'minimum_turn_over', 'class' => 'mb-0']);
              ?>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">เปิดการคืนยอดเสีย</label>
            </div>
            <div class="col-lg-3 font-14px font-Medium p-0 d-flex align-items-center">
              <div>
                <?= TiwForm::normal('checkbox', '1', ['name' => 'is_active'], ['style' => '1', 'is_on_off' => true]); ?>
              </div>
              <div class=" ml-10px text-primary font-16px">
                เปิดใช้งาน
              </div>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">คอมมิชชั่น %</label>
            </div>
            <div class="col-lg-3">
              <?= TiwForm::normal('text', '0.00', ['name' => 'turn_over_percent', 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'min-h-25px h-25px']); ?>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3 align-self-end">
              <label class="font-15px font-Medium text-secondary">
                คอมมิชชั่น %
                แสดงหน้าผู้เล่น
              </label>
            </div>
            <div class="col-lg-3">
              <?= TiwForm::normal('text', '0.00', ['name' =>  'turn_over_percent_customer', 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'min-h-25px h-25px']); ?>
            </div>
          </div>
        </div>
        */ ?>
      </div>
    </form>
  </div>
</div>