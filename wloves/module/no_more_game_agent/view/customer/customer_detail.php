<?php
$select_bot_bank = nga_management_bot::selectBotGroupList($code);

$bank_name_options = [
  'is_search' => true,
  'list' => [],
];

if ($select_bot_bank) {
  foreach ($select_bot_bank as $value) {
    $bank_name_options['list'][] = [
      'value' => $value['id'],
      'name' => $value['bank_account_name'] . ', ' . $value['bank_account_no'],
      'img' => $value['bank_image'],
    ];
  }
}
$arr_remark = ['เติมเครดิตผิดยูสเซอร์', 'เติมเครดิตซ้ำ', 'เติมเครดิตโดยที่ไม่ได้แนบสลิป', 'เติมเครดิตแนบสลิปผิดยูสเซอร์', 'ลูกค้ามีสองยูสเซอร์ ทำให้เครดิตเข้าผิดยูสเซอร์', 'เลขบัญชี 4 ตัวท้ายตรงกับบัญชีฝากหน้าเว็บ', 'เลขบัญชีลูกค้า 4 ตัวท้ายเหมือนกัน ทำให้เครดิตเข้าผิดยูสเซอร์'];
?>

<div class="editable-card core-new border-radius-0 font-14px">
  <form method="post" enctype="multipart/form-data">
    <div class="editable-card core-new border-radius-0-0-10-10 font-14px">
      <div class="d-flex justify-content-between align-items-center flex-wrap px-15px">
        <div class=" py-10px">
          <div class="font-16px font-SemiBold  text-uppercase">รายละเอียดลูกค้า</div>
          <div>จัดการข้อมูลรายละเอียดลูกค้า</div>
        </div>
        <div class="d-flex align-items-center ">
          <?php if ($is_edit) { ?>
            <a href="guide_list.php?c=<?= $_GET['c'] ?>&id=<?= $id ?>">
              <?= TiwForm::normal('btn', '', ['type' => 'button',  'class' => 'btn-light m-5px min-w-80px'], ['text' => 'CANCEL', 'type' => '']); ?>
            </a>
            <?= TiwForm::normal('btn', '', ['name' => 'submit_save_guide_detail', 'type' => 'submit', 'class' => 'btn-primary m-5px'], ['text' => 'SAVE']); ?>
          <?php } else { ?>
            <button type="button" class="m-5px btn btn-outline-info w-120px" <?= Tiwdal::register('edit_customer_detail'); ?>>
              แก้ไขข้อมูล
            </button>
            <button type="button" class="m-5px btn btn-success w-120px" <?= Tiwdal::register('deposit_credit_customer'); ?>>
              เพิ่มเครดิตลูกค้า
            </button>
            <button type="button" class="m-5px btn btn-danger w-120px" <?= Tiwdal::register('withdraw_credit_customer'); ?>>
              ลดเครดิตลูกค้า
            </button>
            <button type="button" class="m-5px btn btn-primary w-120px" <?= Tiwdal::register('increase_turn_over'); ?>>
              เพิ่มยอดเทิร์น
            </button>
            <button type="button" class="m-5px btn btn-warning w-120px" <?= Tiwdal::register('decrease_turn_over'); ?>>
              ลดยอดเทิร์น
            </button>
            <button type="button" class="m-5px btn btn-info w-170px" <?= Tiwdal::register('increase_turn_over_promotion'); ?>>
              เพิ่มยอดเทิร์นโปรโมชัน
            </button>
            <button type="button" class="m-5px btn btn-secondary w-170px" <?= Tiwdal::register('decrease_turn_over_promotion'); ?>>
              ลดยอดเทิร์นโปรโมชัน
            </button>

          <?php } ?>
        </div>
      </div>
      <hr class="my-0">
      <div class="px-15px py-10px">
        <div class="row 10px">
          <div class="col-lg-4">
            <div class="mb-10px">
              <div class="card-header-primary  font-SemiBold font-18px">
                ข้อมูลเบื้องต้น
              </div>
              <div class="card-white px-15px py-10px font-Medium">
                <div class="d-flex align-items-center justify-content-between mb-10px">
                  <div class="d-flex align-items-center">
                    <div class="bank-img">
                      <img src="<?= $customer_data['bank_image']; ?>" class="br-50px">
                    </div>
                    <div class="ml-15px">
                      <div class="font-18px  text-primary"><?= $customer_data['bank_name']; ?></div>
                      <div class="font-16px"><?= $customer_data['bank_number']; ?></div>
                    </div>
                  </div>
                  <div class="hovertext cursor-pointer" data-hover="<?= ($customer_data['is_ban']) ? 'ปลดบล็อค user' : 'ล็อก user'; ?>" <?= Tiwdal::register(($customer_data['is_ban']) ? 'unblock_user_modal' : 'block_user_modal'); ?>>
                    <?php
                    if ($customer_data['is_ban']) { ?>
                      <?= file_get_contents('assets/icon/icon-unlock-danger.svg') ?>
                    <?php } else { ?>
                      <?= file_get_contents('assets/icon/icon-lock-danger.svg') ?>
                    <?php } ?>
                  </div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">เบอร์โทรศัพท์</div>
                  <div class="col-sm-6 font-16px"><?= hidePhoneNumber($customer_data['username']); ?></div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">วันเกิด</div>
                  <div class="col-sm-6 font-16px">
                    <?php
                    if ($customer_data['birth_date']) {
                      echo Aww::formatDate($customer_data['birth_date'], 'd/m/Y');
                    } else {
                      echo '-';
                    }
                    ?>
                  </div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">Line ID</div>
                  <div class="col-sm-6 font-16px"><?= ($customer_data['line_id']) ? $customer_data['line_id'] : '-' ?></div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">รหัสเเนะนำเพื่อน</div>
                  <div class="col-sm-6 font-16px"><?= $customer_data['member_code']; ?></div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">กลุ่มลูกค้า</div>
                  <div class="col-sm-6 font-16px"><?= $customer_data['user_group_name']; ?></div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">การตลาด</div>
                  <div class="col-sm-6 font-16px"><?= $customer_data['alliance_name']; ?></div>
                </div>
                <?php /* 
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">โอนเงิน</div>
                  <div class="col-sm-6 font-16px text-success">สำเร็จ <span class="text-danger">(mockup)</span></div>
                </div>
                  */ ?>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">ตรวจสอบยอดเล่น (turnover)</div>
                  <div class="col-sm-6 font-16px">
                    <?php if ($customer_data['is_check_sum_play']) { ?>
                      <span class="text-success">
                        เปิด
                      </span>
                    <?php } else { ?>
                      <span class="text-danger">
                        ปิด
                      </span>
                    <?php } ?>
                    <?php /* if ($customer_data['turn_over_check'] == 'not_found') { ?>
                      <span class="text-danger">
                        ไม่มีการเล่น
                      </span>
                    <?php } else if ($customer_data['turn_over_check'] == 'confirm') { ?>
                      <span class="text-success">
                        สำเร็จ
                      </span>
                    <?php } else if ($customer_data['turn_over_check'] == 'wait_confirm') { ?>
                      <span class="text-warning">
                        รอกดรับ
                      </span>
                    <?php } */ ?>
                  </div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">ถอนเงิน (Auto)</div>
                  <?php if ($customer_data['is_auto_withdraw']) { ?>
                    <div class="col-sm-6 font-16px text-success">เปิด</div>
                  <?php } else { ?>
                    <div class="col-sm-6 font-16px text-danger">ปิด</div>
                  <?php } ?>
                  <?php /* 
                  <?php if ($customer_data['withdraw_status'] == 'not_complete') { ?>
                    <div class="col-sm-6 font-16px text-danger">ไม่สำเร็จ</div>
                  <?php } else if ($customer_data['withdraw_status'] == 'completed') { ?>
                    <div class="col-sm-6 font-16px text-success">สำเร็จ</div>
                  <?php } else if ($customer_data['withdraw_status'] == 'never_withdraw') { ?>
                    <div class="col-sm-6 font-16px">-</div>
                  <?php } ?>
                  */ ?>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">Turnover ล่าสุด</div>
                  <div class="col-sm-6 font-16px"><?= number_format($customer_data['last_turn_over'], 2); ?></div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">Turnover ที่ต้องทำสำหรับถอน
                    <span class="d-inline-block font-18px ml-5px" tabindex="0" data-toggle="tooltip" title="กรณียูสเล่นเกมประเภทยิงปลา ยอดเทิร์นจะไม่ลด Admin ต้องทำการลดยอดเทิร์นด้วยมือ">
                      <span class="badge badge-danger">!</span>
                    </span>
                  </div>
                  <div class="col-sm-6 font-16px"><?= number_format($customer_data['turn_over_for_withdraw'], 2); ?></div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">Turnover โปรโมชัน</div>
                  <div class="col-sm-6 font-16px"><?= number_format($customer_data['turn_over_promotion'], 2); ?></div>
                </div>
              </div>
            </div>
            <div class="">
              <div class="card-header-primary font-SemiBold font-18px">
                รหัส User Agent
              </div>
              <div class="card-white px-15px py-10px font-Medium">
                <div class="row mb-10px">
                  <div class="col-sm-6 font-14px">รหัสสมาชิก (User Agent)</div>
                  <div class="col-sm-4 font-16px">
                    <?= $customer_data['user_code']; ?>
                    <span class="event_copy text-primary font-14px">(คัดลอกสำเร็จ)</span>
                  </div>
                  <div class="col-sm-2">
                    <input type="hidden" name="data_copy" val="<?= $customer_data['user_code']; ?>">
                    <div class="d-flex align-items-center justify-content-end">
                      <div class="copy-user-code cursor-pointer" data-clipboard-text="<?= $customer_data['user_code']; ?>" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อคัดลอก">
                        <i class="far fa-copy font-18px"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-8">
            <div class="mb-10px">
              <div class="card-header-primary font-SemiBold font-18px">
                รหัส User Web
              </div>
              <div class="card-white px-15px py-10px font-Medium">
                <div class="row mb-10px">
                  <div class="col-sm-4 font-14px">รหัสสมาชิก (Web)</div>
                  <div class="col-sm-8 font-16px">
                    <div class="d-flex">
                      <?= hidePhoneNumber($customer_data['username']); ?>
                      <div class="ml-10px">
                        <?php
                        TiwForm::normal('btn', '', ['name' => 'edit_web_user', 'type' => 'button'], ['text' => '', 'type' => 'edit', 'modal_id' => 'edit_web_user', 'modal_data' => [], 'prefix' => '../../']);
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-4 font-14px">รหัสผ่าน</div>
                  <div class="col-sm-8 font-16px">
                    <div class="d-flex">
                      ••••••••
                      <div class="ml-10px">
                        <?php
                        TiwForm::normal('btn', '', ['name' => 'edit_password', 'type' => 'button'], ['text' => '', 'type' => 'edit', 'modal_id' => 'edit_password', 'modal_data' => [], 'prefix' => '../../']);
                        ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row mb-10px">
                  <div class="col-sm-4 font-14px">ลิงก์เข้าสู่ระบบอัตโนมัติ</div>
                  <?php
                  $url = "http://$_SERVER[HTTP_HOST]";
                  $url = $url . '/secret_login.php';
                  $target = $url . '?token=' . base64_encode($customer_data['username']);
                  ?>
                  <div class="col-sm-8 font-16px">
                    <?php
                    if ($current_user_data['is_permission_god_link']) {
                    ?>

                      <button type="button" class="ml-0 btn btn-primary w-120px">
                        <a href="<?= $target; ?>" class="text-white">
                          เข้าสู่ระบบลูกค้า
                        </a>
                      </button>
                    <?php
                    } else {
                      echo "<span> - </span>";
                    }
                    ?>


                  </div>
                </div>
              </div>
              <div class="">
                <div class="card-header-primary font-SemiBold font-18px">
                  สรุป ฝาก/ถอน
                </div>
                <div class="card-white px-15px py-10px font-Medium">
                  <div class="row mb-10px">
                    <div class="col-sm-4 font-14px">
                      <div class="text-center">
                        <div class="font-30px font-SemiBold"><?= number_format($customer_data['sum_transaction_deposit'], 2); ?></div>
                        <div class="font-14px">รวมยอดฝาก (เงินสด)</div>
                      </div>
                    </div>
                    <div class="col-sm-4 font-16px">
                      <div class="text-center">
                        <div class="font-30px font-SemiBold"><?= number_format($customer_data['sum_transaction_withdraw'], 2); ?></div>
                        <div class="font-14px">รวมยอดถอน</div>
                      </div>
                    </div>
                    <div class="col-sm-4 font-16px">
                      <div class="text-center">
                        <div class="font-30px font-SemiBold text-success"><?= number_format($customer_data['sum_commission_received'], 2); ?></div>
                        <div class="font-14px">รวมยอดโบนัส</div>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-10px">
                    <div class="col-sm-4 font-14px">
                      <div class="text-center">
                        <div class="font-30px scope_profit_wd font-SemiBold scope_style_profit"><?= number_format(0, 2) ?></div>
                        <div class="font-14px d-flex justify-content-center">
                          ลูกค้ากำไร
                          <div class="event_generate_profit cursor-pointer ml-10px" data-toggle="tooltip" data-placement="top" title="คลิกเพื่อดูกำไร">
                            <img src="assets/icon/search-hover.svg" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4 font-16px">
                      <div class="text-center">
                        <div class="font-30px font-SemiBold"><?= number_format($customer_data['sum_withdraw'], 2) ?></div>
                        <div class="font-14px">รวมยอดถอนกระเป๋าเงิน</div>
                      </div>
                    </div>
                    <div class="col-sm-4 font-16px">
                      <div class="text-center">
                        <div class="font-30px font-SemiBold"><?= number_format($customer_data['money_balance'], 2) ?></div>
                        <div class="font-14px">ยอดเงินปัจจุบัน </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="">
                <div class="card-header-primary font-SemiBold font-18px">
                  <div class="d-flex justify-content-between align-items-center">
                    บัญชีอื่น (ตอนฝาก)
                    <button type="button" class="m-5px btn btn-outline-primary w-180px" <?= Tiwdal::register('add_alias'); ?>>
                      เพิ่มบัญชีอื่น (ใช้ตอนฝาก)
                    </button>
                  </div>
                </div>
                <?php
                $bank_number_alias = ($customer_data['bank_number_alias'] != null) ? $customer_data['bank_number_alias'] : [];
                if ($bank_number_alias) {
                ?>
                  <div class="card-white px-15px py-10px font-Medium">
                    <div class="row mb-10px">
                      <?php
                      $bank_alias_data = json_decode($bank_number_alias, true);

                      if ($bank_alias_data == null) {
                        $customArray[$key][$customKey] = '-';
                      } else {
                        $customArray = array();

                        foreach ($bank_alias_data as $key => $value) {
                          if ($value) {
                            $customKey = 'alias_bank_account';
                          }
                          // $intValue = intval($value);
                          $intValue = strval($value);
                          $customArray[$key][$customKey] = $intValue;
                        }
                      }
                      ?>
                      <div class="col-sm-4 font-14px">
                        <span class="mb-15px">เลขที่บัญชี (4 ตัวท้าย)</span>
                      </div>
                      <div class="col-sm-7 font-14px">
                        <?php
                        foreach ($customArray as $key => $other_acc) {
                          $keys = $key + 1;

                        ?>
                          <div class="mb-5px"> <?= $other_acc['alias_bank_account']; ?></div>
                        <?php
                        }
                        ?>
                      </div>
                      <div class="col-sm-1 d-flex justify-content-end">
                        <button type="button" class="form-btn-icon" <?php Tiwdal::register('four_letter_bank', $customer_data, ['is_ajax' => 1]); ?>>
                          <?= file_get_contents('assets/icon/icon-edit.svg'); ?>
                        </button>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
  </form>
</div>
<?php Tiwdal::startModal('edit_customer_detail', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">รายละเอียดลูกค้า</h5>
    </div>
    <div class="modal-body">
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">User (agent)</label>
        </div>
        <div class="col-md-8">
          <div class="font-16px font-Medium"><?= $customer_data['user_code']; ?></div>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">User (Login)</label>
        </div>
        <div class="col-md-8">
          <div class="font-16px font-Medium"><?= $customer_data['username']; ?></div>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">รหัสผ่าน User</label>
        </div>
        <div class="col-md-8">
          <div class="font-16px font-Medium">••••••••</div>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">ชื่อ</label>
        </div>
        <div class="col-md-8">
          <?= TiwForm::normal('text', $customer_data['name'], ['name' => 'name', 'placeholder' => 'กรอก']) ?>
          <?= TiwForm::normal('hidden', $customer_data['name'], ['name' => 'old_name', 'placeholder' => 'กรอก']) ?>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">นามสกุล</label>
        </div>
        <div class="col-md-8">
          <?= TiwForm::normal('text', $customer_data['surname'], ['name' => 'surname', 'placeholder' => 'กรอก']) ?>
          <?= TiwForm::normal('hidden', $customer_data['surname'], ['name' => 'old_surname', 'placeholder' => 'กรอก']) ?>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">วันเกิด</label>
        </div>
        <div class="col-md-8">
          <?= TiwForm::normal('date', $customer_data['birth_date'], ['name' => 'birth_date', 'placeholder' => 'กรอก']) ?>
          <?= TiwForm::normal('hidden', $customer_data['birth_date'], ['name' => 'old_birth_date', 'placeholder' => 'กรอก']) ?>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">Line ID</label>
        </div>
        <div class="col-md-8">
          <?= TiwForm::normal('text', $customer_data['line_id'], ['name' => 'line_id', 'placeholder' => 'กรอก']) ?>
          <?= TiwForm::normal('hidden', $customer_data['line_id'], ['name' => 'old_line_id', 'placeholder' => 'กรอก']) ?>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">ธนาคาร</label>
        </div>
        <div class="col-md-8">
          <?php
          $bank = Bank::select();
          $bank_list = [
            'list' => [
              [
                'value' => '',
                'name' => 'เลือกธนาคาร',
                'img' => '',
                'disabled' => true
              ]
            ]
          ];
          foreach ($bank as $bank_data) {
            $bank_list['list'][] = [
              'value' => $bank_data['abb'],
              'name' => $bank_data['name_th'],
              'img' => $bank_data['image'],
            ];
          }
          ?>
          <?= TiwForm::normal('select-img', $customer_data['bank_abb'], ['name' => 'bank_abb', 'placeholder' => 'กรุณาเลือก'], $bank_list) ?>
          <?= TiwForm::normal('hidden', $customer_data['bank_abb'], ['name' => 'old_bank_abb', 'placeholder' => 'กรอก']) ?>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">ชื่อบัญชีธนาคาร</label>
        </div>
        <div class="col-md-8">
          <?= TiwForm::normal('text', $customer_data['bank_name'], ['name' => 'bank_name', 'placeholder' => 'กรอก']) ?>
          <?= TiwForm::normal('hidden', $customer_data['bank_name'], ['name' => 'old_bank_name', 'placeholder' => 'กรอก']) ?>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">เลขที่บัญชีธนาคาร</label>
        </div>
        <div class="col-md-8">
          <?= TiwForm::normal('number', $customer_data['bank_number'], ['name' => 'bank_number', 'placeholder' => '0000-0000-000']) ?>
          <?= TiwForm::normal('hidden', $customer_data['bank_number'], ['name' => 'old_bank_number', 'placeholder' => '0000-0000-000']) ?>
        </div>
      </div>
      <?php /* 
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">Turnover ที่ต้องทำสำหรับถอน <br> (last = 0; target = 100)</label>
        </div>
        <div class="col-md-8">
          <?= TiwForm::normal('number', $customer_data['lost_amount_for_turn_over'], ['name' => 'lost_amount_for_turn_over', 'placeholder' => '0']) ?>
        </div>
      </div>
      */ ?>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">รหัสเเนะนำเพื่อน</label>
        </div>
        <div class="col-md-8">
          <div class="mb-10px form-row">
            <div class="col-md-12">
              <?= TiwForm::normal('text', $customer_data['member_code'], ['name' => 'member_code', 'placeholder' => 'กรอก']) ?>
              <?= TiwForm::normal('hidden', $customer_data['member_code'], ['name' => 'old_member_code', 'placeholder' => 'กรอก']) ?>
            </div>
          </div>
        </div>
      </div>
      <div class="form-row mb-10px">
        <div class="col-md-4">
          <label class="font-Medium font-14px mt-7px">กลุ่มลูกค้า</label>
        </div>
        <div class="col-md-8">
          <div class="mb-10px">
            <?php
            $type_customer = [];
            $selectUserGroup = nga_management::selectUserGroup($code, []);
            foreach ($selectUserGroup as $data) {
              $type_customer['list'][] = [
                'value' => $data['id'],
                'name' => $data['name'],
              ];
            }
            ?>
            <?= TiwForm::normal('select', $customer_data['user_group_id'], ['name' => 'user_group_id', 'placeholder' => 'กรอก'], $type_customer) ?>
            <?= TiwForm::normal('hidden', $customer_data['user_group_id'], ['name' => 'old_user_group_id', 'placeholder' => 'กรอก']) ?>
          </div>
          <?php
          $is_check_sum_play = ($customer_data['is_check_sum_play']) ? true : false;
          $is_auto_withdraw = ($customer_data['is_auto_withdraw']) ? true : false;
          ?>
          <div class="mb-10px">
            <?= TiwForm::normal('checkbox', 1, ['checked' => $is_check_sum_play, 'name' => 'is_check_sum_play'], ['style' => '3', 'label' => 'ตรวจสอบยอดเล่น (เทิร์น)']) ?>
            <?= TiwForm::normal('hidden', $is_check_sum_play, ['name' => 'old_is_check_sum_play', 'placeholder' => 'กรอก']) ?>
          </div>
          <div>
            <?= TiwForm::normal('checkbox', 1, ['checked' => $is_auto_withdraw, 'name' => 'is_auto_withdraw'], ['style' => '3', 'label' => 'ถอนเงิน (Auto)']) ?>
            <?= TiwForm::normal('hidden', $is_auto_withdraw, ['name' => 'old_is_auto_withdraw', 'placeholder' => 'กรอก']) ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ยกเลิก</button>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_customer_detail', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('deposit_credit_customer', 'modal-md'); ?>
<form method="post" enctype="multipart/form-data">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">เพิ่มเครดิตลูกค้า</h5>
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
          ยูสเซอร์ (Agent)
        </div>
        <div class="col-lg-8  my-auto pb-10px">
          <div><?= $customer_data['username']; ?></div>
        </div>
        <div class="col-lg-4 mt-7px pb-10px">
          เหตุผล
        </div>
        <div class="col-lg-8  my-auto pb-10px">
          <?php TiwForm::normal('textarea', '', ['name' => 'remark', 'class' => 'min-h-70px', 'placeholder' => 'กรอก']); ?>
        </div>
        <div class="col-lg-4 mt-7px pb-10px">
          จากธนาคาร
        </div>
        <div class="col-lg-8  my-auto pb-10px">
          <?php TiwForm::normal('select-img', '', ['name' => 'web_bank_bot_list_id'], $bank_name_options); ?>
        </div>
        <div class="col-lg-4  my-auto pb-10px">
          รูปภาพ
        </div>
        <div class="col-lg-8  my-auto pb-10px">
          <?php
          $options_image = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
          ];
          TiwForm::normal('upload-img', '', ['name' => 'img'], $options_image); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_deposit_customer', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('withdraw_credit_customer', 'modal-md'); ?>
<form method="post" class="">
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
          ยูสเซอร์ (agent)
        </div>
        <div class="col-lg-8  my-auto pb-10px">
          <div><?= $customer_data['username']; ?></div>
        </div>
        <div class="col-lg-4 mt-7px pb-10px">
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
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_withdraw_customer', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('increase_turn_over', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">เพิ่มยอดเทิร์น</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-3 my-auto pb-10px">
          จำนวนยอดเทิร์น
        </div>
        <div class="col-lg-9  pb-10px">
          <div class="form-row">
            <div class="col-6">
              <?php TiwForm::normal('number', '', ['name' => 'increase_amount', 'class' => '', 'placeholder' => '0']); ?>
            </div>
            <div class="col-3 my-auto">
              ยอดเทิร์น
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_increase_turn_over', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('increase_turn_over_promotion', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">เพิ่มยอดเทิร์นโปรโมชัน</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-3 my-auto pb-10px">
          จำนวนยอดเทิร์น
        </div>
        <div class="col-lg-9  pb-10px">
          <div class="form-row">
            <div class="col-6">
              <?php TiwForm::normal('number', '', ['name' => 'increase_amount', 'class' => '', 'placeholder' => '0']); ?>
            </div>
            <div class="col-3 my-auto">
              ยอดเทิร์น
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_increase_turn_over_promo', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>


<?php Tiwdal::startModal('decrease_turn_over', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">ลดยอดเทิร์น</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-3 my-auto pb-10px">
          จำนวนยอดเทิร์น
        </div>
        <div class="col-lg-9  pb-10px">
          <div class="form-row">
            <div class="col-6">
              <?php TiwForm::normal('number', '', ['name' => 'reduce_amount', 'class' => '', 'placeholder' => '0']); ?>
            </div>
            <div class="col-3 my-auto">
              ยอดเทิร์น
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_decrease_turn_over', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('decrease_turn_over_promotion', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">ลดยอดเทิร์นโปรโมชัน</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-3 my-auto pb-10px">
          จำนวนยอดเทิร์น
        </div>
        <div class="col-lg-9  pb-10px">
          <div class="form-row">
            <div class="col-6">
              <?php TiwForm::normal('number', '', ['name' => 'reduce_amount', 'class' => '', 'placeholder' => '0']); ?>
            </div>
            <div class="col-3 my-auto">
              ยอดเทิร์น
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_decrease_turn_over_promo', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('block_user_modal', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<form method="post" class="">
  <div class="modal-content">
    <div class="modal-body">
      <div class="font-16px text-uppercase font-SemiBold text-center mb-10px">บล็อคผู้ใช้งาน</div>
      <div class="text-secondary text-center">ท่านแน่ใจหรือไม่ว่าต้องการบล็อค<span class="text-danger text-uppercase">“ผู้ใช้งานนี้”</span><br>การบล็อคของคุณจะไม่ส่งผลต่อประวัติการใช้งานที่ผ่านไปแล้ว<br>และไม่สามารถเข้าสู่ระบบได้</div>
    </div>
    <div class="modal-footer">
      <div class="d-flex justify-content-end m--5px w-100">
        <button class="btn btn-close-modal min-w-80px m-5px" data-dismiss="modal">ยกเลิก</button>
        <?= TiwForm::normal('btn', '', ['name' => 'submit_block_user', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn-danger'], ['text' => 'ยืนยัน']); ?>
      </div>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>


<?php Tiwdal::startModal('unblock_user_modal', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<form method="post" class="">
  <div class="modal-content">
    <div class="modal-body">
      <div class="font-16px text-uppercase font-SemiBold text-center mb-10px">ปลดบล็อคผู้ใช้งาน</div>
      <div class="text-secondary text-center">ท่านแน่ใจหรือไม่ว่าต้องการปลดบล็อค <span class="text-primary text-uppercase">“ผู้ใช้งานนี้”</span><br>การปลดบล็อคของคุณจะไม่ส่งผลต่อประวัติการใช้งานที่ผ่านไปแล้ว<br>แต่ผู้ใช้งานจะกลับมาเข้าสู่ระบบได้อย่างเดิม</div>
    </div>
    <div class="modal-footer">
      <div class="d-flex justify-content-end m--5px w-100">
        <button class="btn btn-close-modal min-w-80px m-5px" data-dismiss="modal">ยกเลิก</button>
        <?= TiwForm::normal('btn', '', ['name' => 'submit_unblock_user', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn-primary'], ['text' => 'ยืนยัน']); ?>
      </div>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('edit_web_user', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">เปลี่ยนรหัสสมาชิก (Web)</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-3 my-auto pb-10px">
          รหัสสมาชิก (Web) ใหม่
        </div>
        <div class="col-lg-9  pb-10px">
          <div class="form-row">
            <div class="col-6">
              <?php TiwForm::normal('number', '', ['name' => 'renew_username', 'class' => '', 'placeholder' => '']); ?>
              <?php TiwForm::normal('hidden', $customer_data['username'], ['name' => 'old_renew_username', 'class' => '', 'placeholder' => '']); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_username', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('edit_password', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">เปลี่ยนรหัสผ่านลูกค้า</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-3 my-auto pb-10px">
          รหัสผ่านใหม่
        </div>
        <div class="col-lg-9  pb-10px">
          <div class="form-row">
            <div class="col-6">
              <?php TiwForm::normal('password', '', ['name' => 'renew_password', 'class' => '', 'placeholder' => '']); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_password', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('add_alias', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">เพิ่มบัญชีอื่น</h5>
    </div>
    <div class="modal-body">
      <div class="form-row">
        <div class="col-lg-4 my-auto pb-10px">
          เลขที่บัญชีธนาคาร (4 ตัวท้าย)
        </div>
        <div class="col-lg-8 pb-10px">
          <div class="form-row">
            <div class="col">
              <?php TiwForm::normal('text', '', ['name' => 'alias_bank_account', 'class' => '', 'placeholder' => '']); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $customer_data['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_add_alias', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::ajaxModal('four_letter_bank', 'modal-md'); ?>


<script>
  $(document).ready(function() {
    $('.event_copy').hide();
    $('.copy-user-code').click(function() {
      var copyText = $('.copy-user-code').attr('data-clipboard-text');
      var tempElement = $('<textarea>').val(copyText).appendTo($('body')).select();
      document.execCommand('copy');
      tempElement.remove();

      // Show the success message
      var successMessage = $('.event_copy');
      if (successMessage) {
        successMessage.show();
      }

      // Hide the success message after 2 seconds
      setTimeout(function() {
        if (successMessage) {
          successMessage.hide();
        }
      }, 2000);
    });

    $(document).on('click', '.event_generate_profit', function() {
      var $scopeAccount = $('.scope_profit_wd');
      var $scopeStyle = $('.scope_style_profit');
      $scopeAccount.text('รอสักครู่...');
      var params = {
        code: '<?= $code ?>',
        id: '<?= $id ?>',
      };
      $.post('ajax/ajax_check_profit.php', params)
        .done(function(data) {
          var result = JSON.parse(data);
          if (result.sum_profit) {
            if (result.sum_profit > 0) {
              $scopeStyle.addClass('text-success');
            } else if (result.sum_profit < 0) {
              $scopeStyle.addClass('text-danger');
            }
            $scopeAccount.text(parseFloat(result.sum_profit).toFixed(2));
          } else {
            $scopeAccount.text('ไม่พบข้อมูล');
          }
        })

    })
  });
</script>