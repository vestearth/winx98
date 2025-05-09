<?php
$promotion_type_options = [
  'list' => [
    [
      'value' => 'point',
      'name' => 'แต้ม',
    ],
    [
      'value' => 'credit',
      'name' => 'เครดิต',
    ],
  ],
];

$formula_type_options = [
  'list' => [
    [
      'value' => 'invite_friend',
      'name' => 'ชวนเพื่อน',
    ],
    [
      'value' => 'deposit',
      'name' => 'มียอดฝาก',
    ],
    [
      'value' => 'excess_lost',
      'name' => 'มียอดเสีย',
    ],
    [
      'value' => 'play_game',
      'name' => 'เข้าเล่นเกม',
    ],
    [
      'value' => 'new_user',
      'name' => 'สมัครสมาชิกใหม่',
    ],
  ],
];
$game_type_list_data = ['CARD', 'BOARD', 'ARCADE', 'SLOT', 'FISHING', 'CASINOLIVE', 'SPORT', 'LOTTO'];
$game_product = nga_api_seamless::getProductIDList($code);
?>
<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">โปรโมชั่น
    </div>
    <div class="font-15px text-secondary">สร้างและจัดการโปรโมชั่น</div>
  </div>
  <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'pl-20px pr-20px mr-15px'], ['type' => 'button', 'text' => '+ เพิ่มโปรโมชั่น', 'modal_id' => 'add_promotion', 'modal_data' => []]); ?>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="promotion_setting" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('promotion_setting', '?c=' . $_GET['c'], '', 'โปรโมชั่น ',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th class="thin-cell"></th>
            <th nowrap data-sort="name" data-filter="<?= Homepagify::dataFilter('name', 'text') ?>">ชื่อโปรโมชั่น</th>
            <th nowrap data-sort="start_date_time" data-filter="<?= Homepagify::dataFilter('start_date', 'date') ?>">วันที่เริ่ม</th>
            <th nowrap data-sort="end_date_time" data-filter="<?= Homepagify::dataFilter('end_date', 'date') ?>">วันที่สิ้นสุด</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<?php Tiwdal::startModal('add_promotion', 'modal-md'); ?>
<form method="post" enctype="multipart/form-data">
  <div class="modal-header">
    <h5 class="modal-title text-uppercase">เพิ่มโปรโมชั่น</h5>
  </div>
  <div class="modal-body">
    <div class="form-row mb-10px">
      <div class="col-3">
        <p class="mb-0 font-14px">ประเภท</p>
      </div>
      <div class="col-9">
        <div>
          <?= TiwForm::normal('select', '', ['name' => 'type', 'class' => 'form-control event_promotion_type'], $promotion_type_options); ?>
        </div>
        <div class="d-flex">
          <?= TiwForm::normal('radio', 'manual', ['name' => 'receive_type', 'checked' => 'true', 'id' => 'sub_type_promotion', 'class' => 'event_promotion_sub_type', 'data-type' => 'custom'], ['style' => '2', 'label' => 'กำหนดเอง']); ?>
          <?= TiwForm::normal('radio', 'auto', ['name' => 'receive_type', 'id' => 'sub_type_promotion', 'class' => 'ml-20px event_promotion_sub_type', 'data-type' => 'auto'], ['style' => '2', 'label' => 'อัตโนมัติ']); ?>
        </div>
      </div>
    </div>
    <div class="form-row scope_form_promotion_auto d-none">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">สูตรการคำนวณ</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('select', '', ['name' => 'calculate_type', 'class' => 'form-control event_formula_type'], $formula_type_options); ?>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">ชื่อโปรโมชั่น</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('text', '', ['name' => 'name', 'class' => 'form-control', 'placeholder' => 'กรอก'], []); ?>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">เงื่อนไขรายละเอียด</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('textarea', '', ['name' => 'description', 'class' => 'form-control', 'placeholder' => 'กรอก'], []); ?>
      </div>
    </div>
    <div class="form-row scope_credit_point_receive">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px ">รับ<span class="scope_type_promotion_text">แต้ม</span></p>
      </div>
      <div class="col-9">
        <div class="pos-rel">
          <?= TiwForm::normal('number', '', ['name' => 'credit_point_receive', 'class' => 'form-control'], []); ?>
          <span class="text-placeholer scope_type_promotion_placeholder_text">แต้ม</span>
        </div>
      </div>
    </div>
    <div class="form-row scope_form_promotion_deposit d-none">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px ">รับ<span class="scope_type_promotion_text">เครดิต</span></p>
      </div>
      <div class="col-9">
        <div class="pos-rel">
          <?= TiwForm::normal('number', '', ['name' => 'credit_point_receive_percent', 'class' => 'form-control'], []); ?>
          <span class="text-placeholer">%</span>
        </div>
      </div>
    </div>
    <div class="form-row scope_form_promotion_deposit d-none">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">โบนัสสูงสุด</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('number', '', ['name' => 'max_credit_point_receive', 'class' => 'form-control'], []); ?>
        <span class="text-placeholer">บาท</span>
      </div>
    </div>
    <div class="form-row scope_form_promotion_deposit d-none">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">จำนวนรับสูงสุดต่อโปรโมชั่น</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('number', '', ['name' => 'max_receive_server', 'class' => 'form-control'], []); ?>
        <span class="text-placeholer">ครั้ง</span>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">วัน - เวลาที่เริ่ม</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('datetime', '', ['name' => 'start_date_time', 'class' => 'form-control'], []); ?>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">วัน - เวลาที่สิ้นสุด</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('datetime', '', ['name' => 'end_date_time', 'class' => 'form-control'], []); ?>
      </div>
    </div>
    <div class="form-row scope_form_promotion_custom">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">ช่องทางติดต่อ</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('text', '', ['name' => 'contact', 'class' => 'form-control'], []); ?>
      </div>
    </div>
    <div class="scope_form_promotion_all scope_form_promotion_auto d-none">
      <div class="scope_form_promotion_sub_type_invite_friend">
        <div class="form-row">
          <div class="col-3 align-self-center">
            <p class="mb-0 font-14px">ชวนเพื่อนครบ</p>
          </div>
          <div class="col-9">
            <div class="pos-rel">
              <?= TiwForm::normal('text', '', ['name' => 'sum_invite_friend', 'class' => 'form-control'], []); ?>
              <span class="text-placeholer">คน</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row scope_row_group_user">
      <div class="col-lg-3">
        <div class=" font-14px font-Medium mb-10px py-5px">
          กลุ่มลูกค้า
        </div>
      </div>
      <div class="col-lg-9 d-flex mt--7px">
        <div class="row w-100 pos-rel">
          <div class="user-group-screen d-none"></div>
          <div class="col-4  font-14px font-Medium d-flex align-items-center">
            <div class=" mt-3px mr-5px">
              <?= TiwForm::normal('checkbox', '', ['name' => 'event_check_all', 'checked' => false, 'class' => 'event_check_all'], ['style' => '3', 'label' => 'ทั้งหมด']); ?>
            </div>
          </div>
          <?php foreach ($select_user_group as $value) { ?>
            <div class="col-4  font-14px font-Medium d-flex align-items-center">
              <div class=" mt-3px mr-5px">
                <?= TiwForm::normal('checkbox', $value['id'], ['name' => 'user_group_promotion[]', 'checked' => false, 'class' => 'scope_user_group_check'], ['style' => '3', 'label' => $value['name']]); ?>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="form-row scope_row_group_credit d-none">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px ">มียอดฝาก</span></p>
      </div>
      <div class="col-9">
        <div class="pos-rel">
          <?= TiwForm::normal('number', '', ['name' => 'sum_deposit', 'class' => 'form-control'], []); ?>
          <span class="text-placeholer ">บาท</span>
        </div>
      </div>
    </div>

    <div class="form-row scope_row_group_credit_game d-none pt-10px">
      <div class="col-3">
        <p class="mb-0 font-14px ">ประเภทเกม</span></p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_card_can_use', 'checked' => false,], ['style' => '3', 'label' => 'เปิดไพ่']); ?>
        <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_board_can_use', 'checked' => false,], ['style' => '3', 'label' => 'บอร์ดเกม']); ?>
        <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_slot_can_use', 'checked' => false,], ['style' => '3', 'label' => 'สล็อตเสี่ยงโชค']); ?>
        <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_arcade_can_use', 'checked' => false,], ['style' => '3', 'label' => 'ตู้เกม Arcade']); ?>
        <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_casinolive_can_use', 'checked' => false,], ['style' => '3', 'label' => 'คาสิโน']); ?>
        <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_fishing_can_use', 'checked' => false,], ['style' => '3', 'label' => 'เกมตกปลา']); ?>
        <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_sport_can_use', 'checked' => false,], ['style' => '3', 'label' => 'เกมกีฬา']); ?>
      </div>
    </div>
    <div class="form-row scope_row_group_credit_turn_over d-none mt-10px">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px ">ติดเทิร์น</span></p>
      </div>
      <div class="col-9">
        <div class="d-flex align-items-center w-100">
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_cal_with_turn_over', 'checked' => false, 'class' => 'event_cal_with_turn_over'], ['style' => '3', 'label' => 'ติดเทิร์น']); ?>
          <div class="pos-rel d-none">
            <?= TiwForm::normal('number', '', ['name' => 'turn_over_times', 'class' => 'form-control scope_turn_over_times'], []); ?>
            <span class="text-placeholer ">%</span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row scope_row_group_credit_turn_over d-none mt-10px">
      <div class="col-md-3 pt-7px">
        <label class="font-14px">ปลดเทิร์น % (คิดจากยอดโบนัสที่ได้รับ)</label>
      </div>
      <div class="col-md-5">
        <? // TiwForm::normal('number', '', ['name' => 'unlock_turn_over', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); 
        ?>
        <?= TiwForm::normal('number', '', ['name' => 'unlock_turn_over', 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
      </div>
    </div>
    <div class="scope_row_group_credit_turn_over d-none">
      <div class="font-Medium font-14px mb-10px">ประเภทเกม</div>
      <div class="form-group">
        <div class="form-row">
          <?php
          $isChecked = false;
          foreach ($game_type_list_data as $game_type_list) {
          ?>
            <div class="col-md-4 mb-10px">
              <?= TiwForm::normal('checkbox', $game_type_list, ['name' => 'game_type[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_type_list, 'is_on_off' => true]); ?>
            </div>
          <?php
          } ?>
        </div>
      </div>
    </div>
    <div class="scope_row_group_credit_turn_over d-none">
      <div class="font-Medium font-14px mb-10px">กำหนดค่ายเกมที่ได้รับโปรโมชัน</div>
      <div class="form-group">
        <div class="form-row">
          <?php
          $isChecked = false;
          foreach ($game_product as $game_setting) {
          ?>
            <div class="col-md-4 mb-10px">
              <?= TiwForm::normal('checkbox', $game_setting, ['name' => 'game[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_setting, 'is_on_off' => true]); ?>
            </div>
          <?php
          } ?>
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="col-lg-3">
        <div class=" font-14px mb-10px py-5px mt-20px">
          รูปภาพ <br> <span class="font-12px">(สัดส่วน 1080x1080 px)</span>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="ml-5px font-16px font-Medium d-flex align-items-center mt-10px-custom custom_color">
          <?php $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
            'is_btn' => 0,
          ];
          TiwForm::normal('upload-img', '', ['name' => 'image'], $options); ?>
        </div>
      </div>
    </div>
    <div class="form-row mt-15px">
      <div class="col-6">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">แสดงในหน้าโปรโมชั่น</p>
          <div class="pr-20px">
            <?= TiwForm::normal('checkbox', '1', ['name' => 'is_show_on_promotion_page'], ['style' => '1', 'is_on_off' => true]); ?>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">แสดงในหน้าหลัก</p>
          <div class="pr-20px">
            <?= TiwForm::normal('checkbox', '1', ['name' => 'is_show_on_main_page'], ['style' => '1', 'is_on_off' => true]); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row mt-15px">
      <div class="col-6">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">แสดงให้ลูกค้า <br> ที่มาจากเซียน</p>
          <div class="pr-20px">
            <?= TiwForm::normal('checkbox', '1', ['name' => 'is_show_on_user_from_alliance'], ['style' => '1', 'is_on_off' => true]); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_add_promotion', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::ajaxModal('edit_promotion', 'modal-md'); ?>

<div class="clone_form_promotion_all d-none">
  <div class="scope_form_promotion_sub_type_invite_friend">
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">ชวนเพื่อนครบ</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('number', '', ['name' => 'sum_invite_friend', 'class' => 'form-control'], []); ?>
      </div>
    </div>
  </div>
  <div class="scope_form_promotion_sub_type_deposit">
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">มียอดฝาก</p>
      </div>
      <div class="col-9">
        <div class="pos-rel">
          <?= TiwForm::normal('number', '', ['name' => 'sum_deposit_ex', 'class' => 'form-control'], []); ?>
          <span class="text-placeholer">บาท</span>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">จำนวนครั้งต่อวันไม่เกิน</p>
      </div>
      <div class="col-9">
        <div class="d-flex">
          <div class="pos-rel w-100">
            <?= TiwForm::normal('number', '', ['name' => 'time_per_day', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer mt-5px">ครั้ง / คน</span>
          </div>
          <div class="w-100 d-flex align-items-center">
            <?= TiwForm::normal('checkbox', 1, ['name' => 'is_per_day_unlimit', 'checked' => 'false', 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">จำนวนครั้งต่อคน</p>
      </div>
      <div class="col-9">
        <div class="d-flex">
          <div class="pos-rel w-100">
            <?= TiwForm::normal('number', '', ['name' => 'time_per_user', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer mt-5px">ครั้ง / ช่วงโปรโมชั่น</span>
          </div>
          <div class="w-100 d-flex align-items-center">
            <?= TiwForm::normal('checkbox', 1, ['name' => 'is_per_user_unlimit', 'checked' => 'false', 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="scope_form_promotion_sub_type_excess_lost">
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">มียอดเสียเกิน</p>
      </div>
      <div class="col-9">
        <div class="pos-rel w-100">
          <?= TiwForm::normal('number', '', ['name' => 'sum_excess_lost', 'class' => 'form-control'], []); ?>
          <span class="text-placeholer mt-5px">บาท</span>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">รับ<span class="scope_type_promotion_text">แต้ม</span>คืน</p>
      </div>
      <div class="col-9">
        <div class="pos-rel w-100">
          <?= TiwForm::normal('number', '', ['name' => 'credit_point_back_percent', 'class' => 'form-control'], []); ?>
          <span class="text-placeholer mt-5px">% ของยอดเสีย</span>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">รับ<span class="scope_type_promotion_text">แต้ม</span>คืนไม่เกิน</p>
      </div>
      <div class="col-9">
        <div class="d-flex">
          <div class="pos-rel w-100">
            <?= TiwForm::normal('number', '', ['name' => 'max_credit_point_back', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer scope_type_promotion_placeholder_text">แต้ม</span>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">จำนวนครั้งต่อลูกค้า</p>
      </div>
      <div class="col-9">
        <div class="d-flex">
          <div class="pos-rel w-100">
            <?= TiwForm::normal('number', '', ['name' => 'time_per_user', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer mt-5px">ครั้ง</span>
          </div>
          <div class="w-100 d-flex align-items-center">
            <?= TiwForm::normal('checkbox', '', ['name' => 'is_per_user_unlimit', 'checked' => 'false', 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="scope_form_promotion_sub_type_play_game">
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">เข้าเล่นเกมครบ</p>
      </div>
      <div class="col-9">
        <div class="pos-rel w-100">
          <?= TiwForm::normal('number', '', ['name' => 'sum_play_game', 'class' => 'form-control'], []); ?>
          <span class="text-placeholer mt-5px">เกม</span>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">จำนวนครั้งต่อวันไม่เกิน</p>
      </div>
      <div class="col-9">
        <div class="d-flex">
          <div class="pos-rel w-100">
            <?= TiwForm::normal('number', '', ['name' => 'time_per_day', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer mt-5px">ครั้ง / คน</span>
          </div>
          <?php /* 
          <div class="w-100 d-flex align-items-center">
            <?= TiwForm::normal('checkbox', '', ['name' => 'is_per_day_unlimit', 'checked' => 'false', 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
          </div>
          */ ?>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">จำนวนครั้งต่อลูกค้าไม่เกิน</p>
      </div>
      <div class="col-9">
        <div class="d-flex">
          <div class="pos-rel w-100">
            <?= TiwForm::normal('number', '', ['name' => 'time_per_user', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer mt-5px">ครั้ง / ช่วงโปรโมชั่น</span>
          </div>
          <?php /* 
          <div class="w-100 d-flex align-items-center">
            <?= TiwForm::normal('checkbox', '', ['name' => 'is_per_user_unlimit', 'checked' => 'false', 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
          </div>
          */ ?>
        </div>
      </div>
    </div>
  </div>
  <div class="scope_form_promotion_sub_type_new_user">
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">จำกัดจำนวน</p>
      </div>
      <div class="col-9">
        <div class="d-flex">
          <div class="pos-rel w-100">
            <?= TiwForm::normal('number', '', ['name' => 'max_user', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer mt-5px">คน</span>
          </div>
          <div class="w-100 d-flex align-items-center">
            <?= TiwForm::normal('checkbox', 1, ['name' => 'is_max_user_unlimit', 'checked' => 'false', 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php Tiwdal::startModal('delete_data', 'modal-xs'); ?>
<form action="" method="post" id="form_delete_data">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-body border-radius-10-10-0-0px">
    <div class="form-row align-items-center">
      <div class="col-12 form-group text-center">
        <p class="text-info mb-5px mt-20px font-SemiBold font-16px text-uppercase">ลบโปรโมชั่น</p>
        <p class="text-info mb-0 font-14px my-20px">คุณต้องการ <span class="text-danger"> ลบโปรโมชั่น </span> ใช่หรือไม่</p>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_delete_promotion', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-danger',], ['text' => 'ยืนยัน']); ?>
  </div>
  <input type="hidden" name="{id}">
</form>
<?php Tiwdal::endModal() ?>

<script>
  $(document).on('click', '.event_promotion_sub_type', function() {
    var type = $(this).find('input[name="receive_type"]').attr('data-type');
    var promotion_type = $('.event_promotion_type').val();
    if (type == 'custom') {
      $('.scope_form_promotion_custom').removeClass('d-none');
      $('.scope_form_promotion_auto').addClass('d-none');
      $('.scope_row_group_credit_turn_over').addClass('d-none');
    } else if (type == 'auto') {
      $('.scope_form_promotion_custom').addClass('d-none');
      $('.scope_form_promotion_auto').removeClass('d-none');
      if (promotion_type == 'credit') {
        $('.scope_row_group_credit_turn_over').removeClass('d-none');
      } else {
        $('.scope_row_group_credit_turn_over').addClass('d-none');
      }
    }
  });

  $(document).on('change', '.event_formula_type', function() {
    var type = $(this).val();
    var promotion_type = $('.event_promotion_type').val();

    if (type == 'excess_lost') {
      $('.scope_credit_point_receive').addClass('d-none');
    } else {
      $('.scope_credit_point_receive').removeClass('d-none');
    }

    if (type == 'new_user') {
      $('.scope_row_group_user').addClass('d-none');
      if (promotion_type == 'credit') {
        $('.scope_row_group_credit').removeClass('d-none');
      }
    } else {
      $('.scope_row_group_user').removeClass('d-none');
      $('.scope_row_group_credit').addClass('d-none');
    }
    if (promotion_type == 'credit') {
      $('.scope_row_group_credit_turn_over').removeClass('d-none');
    } else {
      $('.scope_row_group_credit_turn_over').addClass('d-none');
    }
    if (type == 'excess_lost' && promotion_type == 'credit' || type == 'play_game' && promotion_type == 'credit') {
      $('.scope_row_group_credit_game').removeClass('d-none');
    } else {
      $('.scope_row_group_credit_game').addClass('d-none');
    }

    if (type == 'deposit') {
      $('.scope_form_promotion_deposit').removeClass('d-none');
    } else {
      $('.scope_form_promotion_deposit').addClass('d-none');
    }


    var clone = $('.clone_form_promotion_all').find('.scope_form_promotion_sub_type_' + type).html();
    $('.scope_form_promotion_all').html(clone);
  });

  $(document).on('change', '.event_promotion_type', function() {
    var receive_type = $('input[name="receive_type"]:checked').attr('data-type');
    var event_formula_type = $('.event_formula_type').val();
    var type = $(this).val();
    if (type == 'point') {
      $('.scope_type_promotion_text').text('แต้ม');
      $('.scope_type_promotion_placeholder_text').text('แต้ม');
      $('.scope_row_group_credit_turn_over').addClass('d-none');
      $('.scope_row_group_credit_game').addClass('d-none');
    } else if (type == 'credit') {
      $('.scope_type_promotion_text').text('เครดิต');
      $('.scope_type_promotion_placeholder_text').text('บาท');
      if (event_formula_type == 'excess_lost' || event_formula_type == 'play_game') {
        $('.scope_row_group_credit_game').removeClass('d-none');
      } else {
        $('.scope_row_group_credit_game').addClass('d-none');
      }
      if (receive_type == 'auto') {
        $('.scope_row_group_credit_turn_over').removeClass('d-none');
      }
    }
  });

  $(document).on('change', 'input[name="event_check_all"]', function() {
    if ($(this).prop("checked") == true) {
      $('.scope_user_group_check').find('input').prop('checked', true);
    } else if ($(this).prop("checked") == false) {
      $('.scope_user_group_check').find('input').prop('checked', false);
    }
  });

  $(document).on('change', 'input[name="user_group_promotion[]"]', function() {
    $('.user-group-screen').removeClass('d-none');
    var scope = $(this).parents('.modal');
    var count = scope.find('input[name="user_group_promotion[]"]').length;
    var i = 0;
    $('input[name="user_group_promotion[]"]').each(function(index) {
      if ($(this).prop("checked") == true) {
        i += 1;
      }
    });
    if (i == count) {
      $('input[name="event_check_all"]').prop('checked', true);
    } else {
      $('input[name="event_check_all"]').prop('checked', false);
    }
    setTimeout(() => {
      $('.user-group-screen').addClass('d-none');
    }, 500);
  });

  $(document).on('change', 'input[name="is_cal_with_turn_over"]', function() {
    if ($(this).prop("checked") == true) {
      $('.scope_turn_over_times').closest('.pos-rel').removeClass('d-none');
    } else if ($(this).prop("checked") == false) {
      $('.scope_turn_over_times').closest('.pos-rel').addClass('d-none');
    }
  });
</script>