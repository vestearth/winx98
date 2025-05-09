<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];
$select_user_group = nga_management::selectUserGroup($code);
if ($_POST['calculate_type'] == 'invite_friend') {
  $calculate_type = 'ชวนเพื่อน';
} else if ($_POST['calculate_type'] == 'deposit') {
  $calculate_type = 'มียอดฝาก';
} else if ($_POST['calculate_type'] == 'excess_lost') {
  $calculate_type = 'มียอดเสีย';
} else if ($_POST['calculate_type'] == 'play_game') {
  $calculate_type = 'เข้าเล่นเกม';
} else if ($_POST['calculate_type'] == 'new_user') {
  $calculate_type = 'สมัครสมาชิกใหม่';
} else {
  $calculate_type = '-';
}

$is_check_user_group_all = true;
$check_user = [];
if (isset($_POST['user_group_promotion'])) {
  foreach ($_POST['user_group_promotion'] as $value) {
    array_push($check_user, $value['is_active']);
  }
}
if (in_array(0, $check_user)) {
  $is_check_user_group_all = false;
}

$is_credit_text = ($_POST['type'] == 'credit') ? 'เครดิต' : 'แต้ม';
$is_credit_text_holder = ($_POST['type'] == 'credit') ? 'บาท' : 'แต้ม';
$game_type_list_data = ['CARD', 'BOARD', 'ARCADE', 'SLOT', 'FISHING', 'CASINOLIVE', 'SPORT', 'LOTTO'];
$game_product = nga_api_seamless::getProductIDList($code);
?>
<form method="post" enctype="multipart/form-data">
  <div class="modal-header">
    <h5 class="modal-title text-uppercase">แก้ไขโปรโมชั่น</h5>
  </div>
  <div class="modal-body">
    <div class="form-row mb-10px">
      <div class="col-3">
        <p class="mb-0 font-14px">ประเภท</p>
      </div>
      <div class="col-9">
        <div>
          <span class="mb-0 font-14px"><?= $_POST['type_modal'] ?></span>
        </div>
        <div class="d-flex align-items-center mt-5px">
          <?= file_get_contents('../assets/icon/double-check.svg') ?>
          <span class="mb-0 ml-5px font-14px text-primary"><?= $_POST['receive_type_modal'] ?></span>
        </div>
      </div>
    </div>
    <?php if ($_POST['calculate_type'] != '') { ?>
      <div class="form-row mb-10px">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px">สูตรการคำนวณ</p>
        </div>
        <div class="col-9">
          <span class="mb-0 ml-5px font-16px"><?= $calculate_type ?></span>
        </div>
      </div>
    <?php } ?>
    <div class="form-row mb-10px">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">ชื่อโปรโมชั่น</p>
      </div>
      <div class="col-9">
        <span class="mb-0 ml-5px font-16px"><?= $_POST['name'] ?></span>
      </div>
    </div>
    <div class="form-row mb-10px">
      <div class="col-3 pt-5px">
        <p class="mb-0 font-14px">เงื่อนไขรายละเอียด</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('textarea', $_POST['description'], ['name' => 'description', 'class' => 'form-control', 'placeholder' => 'กรอก'], []); ?>
      </div>
    </div>
    <?php if ($_POST['calculate_type'] != 'excess_lost') { ?>
      <div class="form-row scope_form_promotion_custom">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px ">รับ<?= $is_credit_text ?></p>
        </div>
        <div class="col-9">
          <div class="pos-rel">
            <?= TiwForm::normal('number',  $_POST['credit_point_receive'], ['name' => 'credit_point_receive', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer"><?= $is_credit_text_holder ?></span>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php if ($calculate_type == 'มียอดฝาก') { ?>
      <div class="form-row">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px ">รับ<span class="scope_type_promotion_text">เครดิต</span></p>
        </div>
        <div class="col-9">
          <div class="pos-rel">
            <?= TiwForm::normal('number', $_POST['credit_point_receive_percent'], ['name' => 'credit_point_receive_percent', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer">%</span>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px">โบนัสสูงสุด</p>
        </div>
        <div class="col-9">
          <?= TiwForm::normal('number', $_POST['max_credit_point_receive'], ['name' => 'max_credit_point_receive', 'class' => 'form-control'], []); ?>
          <span class="text-placeholer">บาท</span>
        </div>
      </div>
      <div class="form-row">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px">จำนวนรับสูงสุดต่อโปรโมชั่น</p>
        </div>
        <div class="col-9">
          <?= TiwForm::normal('number', $_POST['max_receive_server'], ['name' => 'max_receive_server', 'class' => 'form-control'], []); ?>
          <span class="text-placeholer">ครั้ง</span>
        </div>
      </div>
    <?php } ?>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">วัน - เวลาที่เริ่ม</p>
      </div>
      <div class="col-9">
        <span class="font-16px pl-7px"><?= Aww::formatDate($_POST['start_date_time'], 'd/m/Y, H:i'); ?></span>
      </div>
    </div>
    <div class="form-row">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px">วัน - เวลาที่สิ้นสุด</p>
      </div>
      <div class="col-9">
        <?= TiwForm::normal('datetime', $_POST['end_date_time'], ['name' => 'end_date_time', 'class' => 'form-control'], []); ?>
      </div>
    </div>
    <?php if ($_POST['receive_type'] == 'manual') { ?>
      <div class="form-row">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px">ช่องทางติดต่อ</p>
        </div>
        <div class="col-9">
          <?= TiwForm::normal('text', $_POST['contact'], ['name' => 'contact', 'class' => 'form-control'], []); ?>
        </div>
      </div>
    <?php } ?>
    <?php if ($_POST['receive_type'] == 'auto') { ?>
      <div class="">
        <?php if ($_POST['calculate_type'] == 'invite_friend') { ?>
          <div class="scope_form_promotion_sub_type_invite_friend">
            <div class="form-row">
              <div class="col-3 align-self-center">
                <p class="mb-0 font-14px">ชวนเพื่อนครบ</p>
              </div>
              <div class="col-9">
                <div class="pos-rel">
                  <?= TiwForm::normal('number', $_POST['sum_invite_friend'], ['name' => 'sum_invite_friend', 'class' => 'form-control'], []); ?>
                  <span class="text-placeholer">คน</span>
                </div>
              </div>
            </div>
          </div>
        <?php } else if ($_POST['calculate_type'] == 'deposit') { ?>
          <div class="scope_form_promotion_sub_type_deposit">
            <div class="form-row">
              <div class="col-3 align-self-center">
                <p class="mb-0 font-14px">มียอดฝาก</p>
              </div>
              <div class="col-9">
                <div class="pos-rel">
                  <?= TiwForm::normal('number', $_POST['sum_deposit'], ['name' => 'sum_deposit', 'class' => 'form-control'], []); ?>
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
                    <?= TiwForm::normal('number', $_POST['time_per_day'], ['name' => 'time_per_day', 'class' => 'form-control'], []); ?>
                    <span class="text-placeholer mt-5px">ครั้ง / คน</span>
                  </div>
                  <div class="w-100 d-flex align-items-center">
                    <?= TiwForm::normal('checkbox', 1, ['name' => 'is_per_day_unlimit', 'checked' => ($_POST['is_per_day_unlimit'] == '1') ? true : false, 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
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
                    <?= TiwForm::normal('number', $_POST['time_per_user'], ['name' => 'time_per_user', 'class' => 'form-control'], []); ?>
                    <span class="text-placeholer mt-5px">ครั้ง / ช่วงโปรโมชั่น</span>
                  </div>
                  <div class="w-100 d-flex align-items-center">
                    <?= TiwForm::normal('checkbox', 1, ['name' => 'is_per_user_unlimit', 'checked' => ($_POST['is_per_user_unlimit'] == '1' ? true : false), 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } else if ($_POST['calculate_type'] == 'excess_lost') { ?>
          <div class="scope_form_promotion_sub_type_excess_lost">
            <div class="form-row">
              <div class="col-3 align-self-center">
                <p class="mb-0 font-14px">มียอดเสียเกิน</p>
              </div>
              <div class="col-9">
                <div class="pos-rel w-100">
                  <?= TiwForm::normal('number',  $_POST['sum_excess_lost'], ['name' => 'sum_excess_lost', 'class' => 'form-control'], []); ?>
                  <span class="text-placeholer mt-5px"><?= $is_credit_text_holder ?></span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-3 align-self-center">
                <p class="mb-0 font-14px">รับ<?= $is_credit_text ?>คืน</p>
              </div>
              <div class="col-9">
                <div class="pos-rel w-100">
                  <?= TiwForm::normal('number', $_POST['credit_point_back_percent'], ['name' => 'credit_point_back_percent', 'class' => 'form-control'], []); ?>
                  <span class="text-placeholer mt-5px">% ของยอดเสีย</span>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-3 align-self-center">
                <p class="mb-0 font-14px">รับ<?= $is_credit_text ?>คืนไม่เกิน</p>
              </div>
              <div class="col-9">
                <div class="d-flex">
                  <div class="pos-rel w-100">
                    <?= TiwForm::normal('number', $_POST['max_credit_point_back'], ['name' => 'max_credit_point_back', 'class' => 'form-control'], []); ?>
                    <span class="text-placeholer"><?= $is_credit_text_holder ?></span>
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
                    <?= TiwForm::normal('number',  $_POST['time_per_user'], ['name' => 'time_per_user', 'class' => 'form-control'], []); ?>
                    <span class="text-placeholer mt-5px">ครั้ง</span>
                  </div>
                  <div class="w-100 d-flex align-items-center">
                    <?= TiwForm::normal('checkbox', 1, ['name' => 'is_per_user_unlimit', 'checked' => ($_POST['is_per_user_unlimit'] == '1') ? true : false, 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } else if ($_POST['calculate_type'] == 'play_game') { ?>
          <div class="scope_form_promotion_sub_type_play_game">
            <div class="form-row">
              <div class="col-3 align-self-center">
                <p class="mb-0 font-14px">เข้าเล่นเกมครบ</p>
              </div>
              <div class="col-9">
                <div class="pos-rel w-100">
                  <?= TiwForm::normal('number', $_POST['sum_play_game'], ['name' => 'sum_play_game', 'class' => 'form-control'], []); ?>
                  <span class="text-placeholer mt-5px">ครั้ง</span>
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
                    <?= TiwForm::normal('number', $_POST['time_per_day'], ['name' => 'time_per_day', 'class' => 'form-control'], []); ?>
                    <span class="text-placeholer mt-5px">ครั้ง / คน</span>
                  </div>
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
                    <?= TiwForm::normal('number', $_POST['time_per_user'], ['name' => 'time_per_user', 'class' => 'form-control'], []); ?>
                    <span class="text-placeholer mt-5px">ครั้ง / ช่วงโปรโมชั่น</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } else if ($_POST['calculate_type'] == 'new_user') { ?>
          <div class="scope_form_promotion_sub_type_new_user">
            <div class="form-row">
              <div class="col-3 align-self-center">
                <p class="mb-0 font-14px">จำกัดจำนวน</p>
              </div>
              <div class="col-9">
                <div class="d-flex">
                  <div class="pos-rel w-100">
                    <?= TiwForm::normal('number', $_POST['max_user'], ['name' => 'max_user', 'class' => 'form-control'], []); ?>
                    <span class="text-placeholer mt-5px">คน</span>
                  </div>
                  <div class="w-100 d-flex align-items-center">
                    <?= TiwForm::normal('checkbox', 1, ['name' => 'is_max_user_unlimit', 'checked' => ($_POST['is_max_user_unlimit'] == '1') ? true : false, 'class' => 'ml-15px'], ['style' => '3', 'label' => 'ไม่จำกัด']); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    <?php } ?>
    <?php if ($_POST['calculate_type'] != 'new_user') { ?>
      <div class="form-row mt-10px">
        <div class="col-lg-3">
          <div class=" font-14px font-Medium">
            กลุ่มลูกค้า
          </div>
        </div>
        <div class="col-lg-9 d-flex mt--7px">
          <div class="row w-100 pos-rel">
            <div class="user-group-screen d-none"></div>
            <div class="col-4 pl-5px font-14px font-Medium d-flex align-items-center mb-10px">
              <div class=" mt-3px mr-5px">
                <?= TiwForm::normal('checkbox', '', ['name' => 'event_check_all', 'checked' => $is_check_user_group_all, 'class' => 'event_check_all'], ['style' => '3', 'label' => 'ทั้งหมด']); ?>
              </div>
            </div>
            <?php foreach ($_POST['user_group_promotion'] as $value) { ?>
              <div class="col-4 pl-5px font-14px font-Medium d-flex align-items-center mb-10px">
                <div class=" mt-3px mr-5px">
                  <?= TiwForm::normal('checkbox', $value['manage_user_group_id'], ['name' => 'user_group_promotion[]', 'class' => 'scope_user_group_check', 'checked' => ($value['is_active'] == '1') ? true : false], ['style' => '3', 'label' => $value['user_group_name']]); ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php if ($_POST['calculate_type'] == 'new_user'  && $_POST['receive_type'] == 'auto' && $_POST['type'] == 'credit') { ?>
      <div class="form-row scope_row_group_credit">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px ">มียอดฝาก</span></p>
        </div>
        <div class="col-9">
          <div class="pos-rel">
            <?= TiwForm::normal('number', $_POST['sum_deposit'], ['name' => 'sum_deposit', 'class' => 'form-control'], []); ?>
            <span class="text-placeholer ">บาท</span>
          </div>
        </div>
      </div>
    <?php } ?>
    <?php if (($_POST['calculate_type'] == 'excess_lost' || $_POST['calculate_type'] == 'play_game') && $_POST['receive_type'] == 'auto' && $_POST['type'] == 'credit') { ?>
      <div class="form-row scope_row_group_credit_game  pt-10px">
        <div class="col-3">
          <p class="mb-0 font-14px ">ประเภทเกม</span></p>
        </div>
        <div class="col-9">
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_card_can_use', $_POST['is_game_card_can_use'] ? 'checked' : '' => true], ['style' => '3', 'label' => 'เปิดไพ่']); ?>
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_board_can_use', $_POST['is_game_board_can_use'] ? 'checked' : '' => true], ['style' => '3', 'label' => 'บอร์ดเกม']); ?>
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_slot_can_use', $_POST['is_game_slot_can_use'] ? 'checked' : '' => true], ['style' => '3', 'label' => 'สล็อตเสี่ยงโชค']); ?>
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_arcade_can_use', $_POST['is_game_arcade_can_use'] ? 'checked' : '' => true], ['style' => '3', 'label' => 'ตู้เกม Arcade']); ?>
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_casinolive_can_use', $_POST['is_game_casinolive_can_use'] ? 'checked' : '' => true], ['style' => '3', 'label' => 'คาสิโน']); ?>
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_fishing_can_use', $_POST['is_game_fishing_can_use'] ? 'checked' : '' => true], ['style' => '3', 'label' => 'เกมตกปลา']); ?>
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_game_sport_can_use', $_POST['is_game_sport_can_use'] ? 'checked' : '' => true], ['style' => '3', 'label' => 'เกมกีฬา']); ?>
        </div>
      </div>
    <?php } ?>

    <?php if ($_POST['receive_type'] == 'auto' && $_POST['type'] == 'credit') { ?>
      <div class="form-row scope_row_group_credit_turn_over mt-10px">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px ">ติดเทิร์น</span></p>
        </div>
        <div class="col-9">
          <div class="d-flex align-items-center w-100">
            <?= TiwForm::normal('checkbox', 1, ['name' => 'is_cal_with_turn_over', $_POST['is_cal_with_turn_over'] ? 'checked' : '' => true, 'class' => 'event_cal_with_turn_over'], ['style' => '3', 'label' => 'ติดเทิร์น']); ?>
            <div class="pos-rel <?= !$_POST['is_cal_with_turn_over'] ? 'd-none' : '' ?> ">
              <?= TiwForm::normal('number', $_POST['turn_over_times'], ['name' => 'turn_over_times', 'class' => 'form-control scope_turn_over_times'], []); ?>
              <span class="text-placeholer ">%</span>
            </div>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-3 pt-7px">
            <label class="font-14px font-SemiBold">ปลดเทิร์น % (คิดจากยอดโบนัสที่ได้รับ)</label>
          </div>
          <div class="col-md-">
            <?= TiwForm::normal('number', $_POST['unlock_turn_over'], ['name' => 'unlock_turn_over', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          </div>
        </div>
      </div>
      <div class="scope_form_promotion_auto">
        <div class="font-Medium font-14px mb-10px">ประเภทเกม</div>
        <div class="form-group">
          <div class="form-row">
            <?php
            if (empty($_POST['game_type_list'])) {
              $json_decode_game_type = [];
            } else {
              $json_decode_game_type = json_decode($_POST['game_type_list'], true);
            }
            $isChecked = false;
            foreach ($game_type_list_data as $game_type_list) {
              if (!empty($_POST['game_type_list'])) {
                $isChecked = in_array($game_type_list, $json_decode_game_type) ? true : false;
              }
            ?>
              <div class="col-md-4 mb-10px">
                <?= TiwForm::normal('checkbox', $game_type_list, ['name' => 'game_type[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_type_list, 'is_on_off' => true]); ?>
              </div>
            <?php
            } ?>
          </div>
        </div>
      </div>
      <div class="scope_form_promotion_auto">
        <div class="font-Medium font-14px mb-10px">กำหนดค่ายเกมที่ได้รับโปรโมชัน</div>
        <div class="form-group">
          <div class="form-row">
            <?php
            if (empty($_POST['game_product_list'])) {
              $json_decode_product = [];
            } else {
              $json_decode_product = json_decode($_POST['game_product_list'], true);
            }
            foreach ($game_product as $game_setting) {
              $isChecked = in_array($game_setting, $json_decode_product) ? true : false;
            ?>
              <div class="col-md-4 mb-10px">
                <?= TiwForm::normal('checkbox', $game_setting, ['name' => 'game[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_setting, 'is_on_off' => true]); ?>
              </div>
            <?php
            } ?>
          </div>
        </div>
      </div>
    <?php } ?>



    <div class="form-row">
      <div class="col-lg-3">
        <div class=" font-14px">
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
          TiwForm::normal('upload-img', $_POST['promotion_image'], ['name' => 'image'], $options); ?>
        </div>
      </div>
    </div>
    <div class="form-row mt-15px">
      <div class="col-6">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">แสดงในหน้าโปรโมชั่น</p>
          <div class="pr-20px">
            <?= TiwForm::normal('checkbox', '1', ['name' => 'is_show_on_promotion_page', 'checked' => ($_POST['is_show_on_promotion_page'] == '1') ? true : false], ['style' => '1', 'is_on_off' => true]); ?>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">แสดงในหน้าหลัก</p>
          <div class="pr-20px">
            <?= TiwForm::normal('checkbox', '1', ['name' => 'is_show_on_main_page', 'checked' => ($_POST['is_show_on_main_page'] == '1') ? true : false], ['style' => '1', 'is_on_off' => true]); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row mt-15px">
      <div class="col-6">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">แสดงให้ลูกค้า <br> ที่มาจากเซียน</p>
          <div class="pr-20px">
            <?= TiwForm::normal('checkbox', '1', ['name' => 'is_show_on_user_from_alliance', 'checked' => ($_POST['is_show_on_user_from_alliance'] == '1') ? true : false], ['style' => '1', 'is_on_off' => true]); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_promotion', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
  <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
</form>