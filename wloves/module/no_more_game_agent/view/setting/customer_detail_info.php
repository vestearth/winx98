<?php
$get_data = nga_management::getUserGroupByID($code, $id);
$deposit_bot_list = (isset($get_data['deposit_bot_list']) && $get_data['deposit_bot_list']) ? $get_data['deposit_bot_list'] : [];
$bot_list = [];
$bot_bank_list = [];
$withdraw_bot_bank_list = [];
$where_bot = [
  'is_withdraw' => 1
];
$bot_list_api = nga_management_bot::selectBotGroupList($code, $where_bot);
foreach ($bot_list_api as $bot_data) {
  $bot_list['list'][] = [
    'value' => $bot_data['id'],
    'name' => $bot_data['bank_account_name'] . ' / ' . $bot_data['bank_account_no'],
    'img' => $bot_data['bank_image']
  ];
}

// foreach ($deposit_bot_list as $bot_data) {
//   $bot_list['list'][] = [
//     'value' => $bot_data['deposit_bot_group_list_id'],
//     'name' => $bot_data['bank_account_name'] . ' / ' . $bot_data['bank_account_no'],
//     'img' => $bot_data['bank_image']
//   ];
// }

$botBank_api = nga_management_bot::selectBotGroup($code, []);
foreach ($botBank_api as $bank_bot_data) {
  $bot_bank_list['list'][] = [
    'value' => $bank_bot_data['id'],
    'name' => $bank_bot_data['bot_name'],
    'img' => $bank_bot_data['bank_image']
  ];
}

foreach ($botBank_api as $bank_bot_data) {
  if ($bank_bot_data['is_withdraw'] == 1) {
    $withdraw_bot_bank_list['list'][] = [
      'value' => $bank_bot_data['id'],
      'name' => $bank_bot_data['bot_name'],
      'img' => $bank_bot_data['bank_image']
    ];
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
?>
<div class="col-12 p-0">
  <div class="editable-card border-radius-0 mb-50px" style="min-height: calc(100vh - 120px);">
    <form method="post" enctype='multipart/form-data' id="product_form">
      <div class="d-flex justify-content-between align-items-center px-15px py-10px flex-wrap">
        <div class="">
          <p class="font-weight-bold mb-0">รายละเอียดกลุ่มลูกค้า - <span class="text-primary"><?= $get_data['name']; ?></span></p>
          <p class="mb-0">จัดการรายละเอียดกลุ่มลูกค้าและตั้งค่าเงื่อนไขต่าง ๆ</p>
        </div>
        <div class="d-flex align-items-center">
          <?php if ($is_edit) { ?>
            <a href="system_database.php?c=<?= $_GET['c'] ?>&page=2&is_info=1&id=<?= $id; ?>">
              <button type="button" class="btn btn-close-modal min-h-45px mr-5px w-80px " style="color:black!important">ยกเลิก</button>
            </a>
            <?php TiwForm::normal('btn', '', ['name' => 'submit_edit_user_group', 'class' => 'w-120px'], ['type' => 'submit', 'text' => 'บันทึก']); ?>
          <?php } else { ?>
            <a href="system_database.php?c=<?= $_GET['c'] ?>&page=2&is_info=1&is_edit=1&id=<?= $id; ?>">
              <button type="button" class="btn btn-outline-info w-120px mr-10px">แก้ไขข้อมูล</button>
            </a>
          <?php } ?>
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
                  <label class="font-15px font-SemiBold text-secondary pt-7px">ชื่อกลุ่มลูกค้า</label>
                </div>
                <div class="col-lg-5 font-16px font-Medium">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">
                    <?= $get_data['name']; ?>
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">เลือกกลุ่ม Bot
                    <?php if ($is_edit) { ?>
                      <span class="text-danger">*</span>
                    <?php } ?>
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium">
                  <?php if ($is_edit) { ?>
                    <?= TiwForm::normal('select-img', $get_data['deposit_bot_group_id'], ['name' => 'deposit_bot_group_id', 'required' => true, 'class' => ''], $bot_bank_list); ?>
                  <?php } else { ?>
                    <div class="font-15px font-SemiBold text-secondary pt-7px">
                      <?= $get_data['deposit_bot_name']; ?>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <!-- <div class="event_botBank_clear"> -->
            <?php /* foreach ($deposit_bot_list as $key => $deposit_list) {
              $keys = $key + 1;
            ?>
              <div class="form-group event_botBank_clear">
                <div class="form-row">
                  <div class="col-lg-3">
                    <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">ธนาคารสำหรับการฝากอัตโนมัติ
                      <?php if ($is_edit) { ?>
                        <span class="text-danger">*</span>
                      <?php } ?>
                    </label>
                  </div>
                  <div class="col-lg-5 font-16px font-Medium">
                    <?php if ($is_edit) { ?>
                      <?php
                      TiwForm::normal('select-img', $deposit_list['deposit_bot_group_list_id'], ['name' => 'deposit_bot_group_list_id[]', 'required' => true], $bot_list);
                      ?>
                    <?php } else {
                      if ($deposit_list['is_show_all_deposit_account']) {
                        $deposit_acc_no = $deposit_list['bank_account_no'];
                      } else {
                        $deposit_acc_no = substr($deposit_list['bank_account_no'], 0, 7) . '***';
                      }
                    ?>
                      <label class="font-15px font-SemiBold text-secondary pt-7px d-flex align-items-center">
                        <div class="bank-img small-size mr-5px">
                          <img src="<?= $deposit_list['bank_image'] ?>" class=''>
                        </div>
                        <?= $deposit_list['bank_account_name'] . ',' . $deposit_acc_no ?>
                      </label>
                      <?php if ($deposit_list['is_show_all_deposit_account']) { ?>
                        <div class="text-primary">
                          <img src="./assets/icon/double-check.svg" class=''>
                          แสดงเลขบัญชีทั้งหมด
                        </div>
                      <?php } else { ?>
                        <div class="text-warning">
                          แสดงเลขบัญชีบางส่วน
                        </div>
                      <?php } ?>
                    <?php } ?>
                  </div>

                  <?php if ($is_edit) {
                    $deposit_checked = ($deposit_list['is_show_all_deposit_account']) ? true : false;
                  ?>
                    <div class="col-lg-3 font-16px font-Medium ml-15px">
                      <div class="pt-7px">
                        <?= TiwForm::normal('checkbox', 1, ['checked' => $deposit_checked, 'name' => 'is_show_all_deposit_account_' . $keys,], ['style' => '3', 'label' => 'แสดงเลขบัญชีทั้งหมด']); ?>
                      </div>
                    </div>
                  <?php } ?>

                </div>
              </div>
            <?php } */ ?>
            <!-- </div> -->
            <div class="form-group event_botBank_target">

            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px  max-w-180px">กลุ่ม Bot สำหรับการถอนอัตโนมัติ
                    <?php if ($is_edit) { ?>
                      <span class="text-danger">*</span>
                    <?php } ?>
                  </label>
                </div>
                <div class="col-lg-5 font-16px font-Medium">
                  <?php if ($is_edit) { ?>
                    <?php
                    TiwForm::normal('select-img', $get_data['withdraw_bot_group_id'], ['name' => 'withdraw_bot_group_id', 'required' => true], $withdraw_bot_bank_list);
                    // TiwForm::normal('select-img', $get_data['withdraw_bot_group_list_id'], ['name' => 'withdraw_bot_group_list_id', 'required' => true], $bot_list);
                    ?>
                  <?php } else {
                    // if ($get_data['is_show_all_withdraw_account']) {
                    //   $withdraw_acc_no = $get_data['withdraw_bank_account_no'];
                    // } else {
                    //   $withdraw_acc_no = substr($get_data['withdraw_bank_account_no'], 0, 7) . '***';
                    // }
                  ?>
                    <label class="font-15px font-SemiBold text-secondary pt-7px d-flex align-items-center">
                      <div class="d-flex">
                        <?php /* 
                        <div class="bank-img small-size mr-5px">
                          <img src="<?= $get_data['withdraw_bank_image'] ?>" class='mr-5px'>
                        </div>
                        */ ?>
                        <?= $get_data['withdraw_bot_name']; ?>
                      </div>
                    </label>
                  <?php } ?>
                </div>

              </div>
            </div>
          </div>
          <div class="col-md">
            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-4 text-right">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">รูป / ไอคอน </label>
                </div>
                <div class="col-lg font-16px font-Medium <?= (!$is_edit) ? 'd-flex justify-content-center' : ''; ?>">
                  <?php if ($is_edit) { ?>
                    <div class="d-flex align-items-center justify-content-center custom_color text-muted">
                      <div class="col-lg-12 font-16px font-Medium ">
                        <div class="d-flex align-items-center custom_color">
                          <?php $options = [
                            'width' => '200px',
                            'height' => '100%',
                            'bg-img' => 'assets/image/bg_upload.png',
                          ];
                          TiwForm::normal('upload-img', $get_data['user_group_image'], ['name' => 'img_file'], $options); ?>
                        </div>
                      </div>
                    </div>
                    <div class="font-italic text-muted font-15px mt-5px">
                      ไฟล์ .png หรือ .jpg สัดส่วน 1:1 หรือ 128x128 px
                    </div>
                  <?php } else { ?>
                    <label class="font-15px font-SemiBold pt-7px text-muted">
                      <?php if ($get_data['user_group_image']) { ?>
                        <div class="user-group-img-lg">
                          <img src="<?= $get_data['user_group_image']; ?>" class="img-responsive">
                        </div>
                      <?php } else { ?>
                        ไม่มีข้อมูล
                      <?php } ?>
                    </label>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="title_italic font-16px font-Bold mb-10px"><i>กำหนดเงื่อนไขการเลื่อนระดับ</i></div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">จำนวนครั้งที่ฝาก</label>
            </div>
            <div class="col-lg-2 font-16px font-Medium">
              <label class="font-15px font-SemiBold text-secondary pt-7px">
                <?= number_format($get_data['deposit_time'], 0); ?>
              </label>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">ยอดฝากทั้งหมด</label>
            </div>
            <div class="col-lg-2 font-16px font-Medium">
              <label class="font-15px font-SemiBold text-secondary pt-7px">
                <?= number_format($get_data['sum_deposit'], 2); ?>
              </label>
            </div>
          </div>
        </div>

        <div class="title_italic font-15px mb-10px font-italic">ในกรณีที่ผู้เล่นมีจำนวนครั้งที่ฝาก และยอดฝาก ตรงตามเงื่อนไขที่กำหนด ผู้เล่นสามารถเลื่อนระดับอัตโนมัติได้</div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">เลื่อนระดับอัตโนมัติ
              </label>
            </div>
            <div class="col-lg-5 font-16px font-Medium">
              <?php if ($get_data['is_auto_group_shift']) {
              ?>
                <label class="font-15px font-SemiBold text-secondary pt-7px">
                  <div class="text-primary">
                    <img src="assets/icon/double-check.svg" class=''>
                    เปิดใช้งาน
                  </div>
                </label>
              <?php } else { ?>
                <label class="font-15px font-SemiBold text-secondary pt-7px">
                  <div class="text-primary">ปิดใช้งาน</div>
                </label>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">รักษาอันดับ Raking</label>
            </div>
            <div class="col-lg-5 font-16px font-Medium">
              <?php if ($get_data['is_check_deposit_per_month']) {
              ?>
                <label class="font-15px font-SemiBold text-secondary pt-7px">
                  <div class="text-primary">
                    <img src="assets/icon/double-check.svg" class=''>
                    เปิดใช้งาน
                  </div>
                </label>
              <?php } else { ?>
                <label class="font-15px font-SemiBold text-secondary pt-7px">
                  <div class="text-primary">ปิดใช้งาน</div>
                </label>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">ยอดฝากสะสมต่อเดือน</label>
            </div>
            <div class="col-lg-2 font-16px font-Medium">
              <label class="font-15px font-SemiBold text-secondary pt-7px">
                <?= number_format($get_data['deposit_per_month'], 2); ?>
              </label>
            </div>
          </div>
        </div>

        <div class="title_italic font-16px font-Bold mb-10px"><i>รายละเอียดอื่น ๆ</i></div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">กำหนดสี</label>
            </div>
            <div class="col-lg-5 font-16px font-Medium text-primary d-flex">
              <label class="font-15px font-SemiBold pt-7px text-primary">
                <?= $get_data['color']; ?>
              </label>
            </div>
          </div>
          <div class="form-row form-group mt-10px">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">ประเภทการคืนยอด</label>
            </div>
            <div class="col-lg-5 font-16px font-Medium d-flex">
              <div class="pt-5px text-secondary">
                ยอดเสีย
              </div>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">ยอดเล่นขั้นต่ำ</label>
            </div>
            <div class="col-lg-3 font-16px font-Medium text-secondary d-flex">
              <label class="font-15px font-SemiBold text-secondary pt-7px">
                <?= number_format($get_data['minimum_for_cal_turn_over'], 2); ?>
              </label>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">ยอดคืนสูงสุด</label>
            </div>
            <div class="col-lg-3 font-16px font-Medium text-secondary d-flex">
              <label class="font-15px font-SemiBold text-secondary pt-7px">
                <?= number_format($get_data['maximum_turn_over'], 2); ?>
              </label>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">ยอดคืนต่ำสุด</label>
            </div>
            <div class="col-lg-3 font-16px font-Medium text-secondary d-flex <?= ($is_edit) ? 'pt-7px' : ''; ?>">
              <label class="font-15px font-SemiBold text-secondary pt-7px">
                <?= number_format($get_data['minimum_turn_over'], 2); ?>
              </label>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">เปิดการคืนยอดเสีย</label>
            </div>
            <div class="col-lg-3 font-14px font-Medium p-0 d-flex align-items-center">
              <?php if ($get_data['is_active'] == 1) { ?>
                <div class="<?= ($is_edit) ? 'ml-10px' : ''; ?> text-primary font-16px">
                  เปิดใช้งาน
                </div>
              <?php } else { ?>
                <div class="<?= ($is_edit) ? 'ml-10px' : ''; ?> text-secondary  font-16px">
                  ปิดใช้งาน
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="form-row form-group">
            <div class="col-lg-3">
              <label class="font-15px font-Medium text-secondary pt-7px">คอมมิชชั่น %</label>
            </div>
            <div class="col-lg-3">
              <label class="font-15px font-SemiBold text-secondary pt-7px">
                <?= number_format($get_data['turn_over_percent'], 2); ?>
              </label>
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
              <label class="font-15px font-SemiBold text-secondary pt-7px">
                <?= number_format($get_data['turn_over_percent_customer'], 2); ?>
              </label>
            </div>
          </div>
          <?php /*
          <div class="col-lg">
            <div class="form-row pt-10px">
              <div class="col-lg-12 d-flex p-0 flex-wrap">
                <?php foreach ($list_games as $key => $game) {
                ?>
                  <div class="col-lg-6 d-flex p-0 flex-wrap mb-15px">
                    <div class="col-lg-4 p-0">
                      <div class=" font-14px font-Medium mt-5px">
                        <?= $game['name'] ?>
                      </div>
                    </div>
                    <div class="col-lg-8 p-0">
                      <div class=" font-14px font-Medium d-flex flex-column">
                        <div class="d-flex flex-row">
                          <div class="<?= $hidden_slide; ?>">
                            <?php
                            $checked = ($get_data[$game['is_open']] == 1) ? 'checked' : '';
                            TiwForm::normal('checkbox', 1, ['name' => $game['is_open'], 'checked' => $checked], ['style' => '1', 'is_on_off' => true]);
                            ?>
                          </div>
                          <?php if (($get_data[$game['is_open']] == 1)) { ?>
                            <div class="<?= ($is_edit) ? 'ml-10px' : 'mt-5px'; ?> text-primary font-16px">
                              เปิดใช้งาน
                            </div>
                          <?php } else { ?>
                            <div class="<?= ($is_edit) ? 'ml-10px' : 'mt-5px'; ?> text-secondary  font-16px">
                              ปิดใช้งาน
                            </div>
                          <?php } ?>
                        </div>

                        <div class="row">
                          <div class="col-8 align-self-end pb-5px">
                            คอมมิชชั่น %
                          </div>
                          <div class="col-4">
                            <?= TiwForm::normal('text', $get_data[$game['commission']], ['name' => $game['commission'], 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px min-h-25px h-25px'], ['is_edit' => $is_edit]); ?>
                          </div>

                          <div class="col-8 align-self-end pb-5px">
                            คอมมิชชั่น %
                            แสดงหน้าผู้เล่น
                          </div>
                          <div class="col-4">
                            <?= TiwForm::normal('text', $get_data[$game['commission_player']], ['name' =>  $game['commission_player'], 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px min-h-25px h-25px'], ['is_edit' => $is_edit]); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
           */ ?>
        </div>
      </div>
    </form>
  </div>
</div>