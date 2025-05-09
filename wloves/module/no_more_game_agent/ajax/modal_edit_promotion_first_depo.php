<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];

$calculate_type = 'มียอดฝาก';
$_POST['calculate_type'] = 'deposit';
$_POST['receive_type'] = 'auto';
$_POST['type'] == 'credit';
$name_rank = '';
if ($_POST['type'] == 'bronze_silver') {
  $name_rank = 'Bronze-Silver';
} else if ($_POST['type'] == 'gold_diamond') {
  $name_rank = 'Gold-Diamond';
} else if ($_POST['type'] == 'con') {
  $name_rank = "Conqueror's";
} else if ($_POST['type'] == 'vip_vvip') {
  $name_rank = 'VIP-VVIP';
}
$_POST['name'] = 'โปรโมชั่นฝากแรกของวัน ' . $name_rank;
$is_check_user_group_all = true;
$check_user = [];
if (isset($_POST['user_group'])) {
  foreach ($_POST['user_group'] as $value) {
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
          <span class="mb-0 font-14px">เครดิต</span>
        </div>
        <div class="d-flex align-items-center mt-5px">
          <?= file_get_contents('../assets/icon/double-check.svg') ?>
          <span class="mb-0 ml-5px font-14px text-primary"><?= 'อัตโนมัติ' ?></span>
        </div>
      </div>
    </div>
    <?php if ($_POST['calculate_type'] != '') { ?>
      <div class="form-row mb-10px">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px">สูตรการคำนวณ</p>
        </div>
        <div class="col-9">
          <span class="mb-0 ml-5px font-16px"><?= 'ฝากแรกของวัน' ?></span>
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
        <?= TiwForm::normal('textarea', $_POST['description'], ['name' => 'description', 'class' => 'form-control', 'placeholder' => 'กรอก', 'readonly' => 'true'], []); ?>
      </div>
    </div>
    <?php if ($calculate_type == 'มียอดฝาก') { ?>
      <div class="form-row">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px ">รับ<span class="scope_type_promotion_text">เครดิต</span></p>
        </div>
        <div class="col-9">
          <div class="pos-rel">
            <?= TiwForm::normal('number', $_POST['credit_receive'], ['name' => 'credit_receive', 'class' => 'form-control', 'readonly' => 'true'], []); ?>
            <span class="text-placeholer">%</span>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-3 align-self-center">
          <p class="mb-0 font-14px">โบนัสสูงสุด</p>
        </div>
        <div class="col-9">
          <?= TiwForm::normal('number', $_POST['max_credit'], ['name' => 'max_credit', 'class' => 'form-control', 'readonly' => 'true'], []); ?>
          <span class="text-placeholer">บาท</span>
        </div>
      </div>
    <?php } ?>
    <?php if ($_POST['receive_type'] == 'auto') { ?>
      <div class="">
        <?php if ($_POST['calculate_type'] == 'deposit') { ?>
          <div class="scope_form_promotion_sub_type_deposit">
            <div class="form-row">
              <div class="col-3 align-self-center">
                <p class="mb-0 font-14px">มียอดฝาก</p>
              </div>
              <div class="col-9">
                <div class="pos-rel">
                  <?= TiwForm::normal('number', $_POST['min_deposit'], ['name' => 'min_deposit', 'class' => 'form-control', 'readonly' => 'true'], []); ?>
                  <span class="text-placeholer">บาท</span>
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
                <?= TiwForm::normal('checkbox', '', ['name' => 'event_check_all', 'checked' => $is_check_user_group_all, 'class' => 'event_check_all', 'disabled' => 'true'], ['style' => '3', 'label' => 'ทั้งหมด']); ?>
              </div>
            </div>
            <?php foreach ($_POST['user_group'] as $value) { ?>
              <div class="col-4 pl-5px font-14px font-Medium d-flex align-items-center mb-10px">
                <div class=" mt-3px mr-5px">
                  <?= TiwForm::normal('checkbox', $value['manage_user_group_id'], ['name' => 'user_group_promotion[]', 'class' => 'scope_user_group_check', 'checked' => ($value['is_active'] == '1') ? true : false, 'disabled' => 'true'], ['style' => '3', 'label' => $value['user_group_name']]); ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    <?php } ?>

    <div class="form-row scope_row_group_credit_turn_over mt-10px">
      <div class="col-3 align-self-center">
        <p class="mb-0 font-14px ">ติดเทิร์น</span></p>
      </div>
      <div class="col-4">
        <div class="d-flex align-items-center w-100">
          <?= TiwForm::normal('number', $_POST['turn_over_for_withdraw'], ['name' => 'turn_over_for_withdraw', 'class' => 'form-control scope_turn_over_times', 'readonly' => 'true'], []); ?>
          <span class="text-placeholer ">%</span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ปลดเทิร์น % (คิดจากยอดโบนัสที่ได้รับ)</label>
        </div>
        <div class="col-md-4">
          <?= TiwForm::normal('number', $_POST['unlock_turn_over'], ['name' => 'unlock_turn_over', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก', 'readonly' => 'true']); ?>
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
              <?= TiwForm::normal('checkbox', $game_type_list, ['name' => 'game_type[]', 'checked' => ($isChecked) ? true : false, 'disabled' => 'true'], ['style' => '1', 'label' => $game_type_list, 'is_on_off' => true]); ?>
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
              <?= TiwForm::normal('checkbox', $game_setting, ['name' => 'game[]', 'checked' => ($isChecked) ? true : false, 'disabled' => 'true'], ['style' => '1', 'label' => $game_setting, 'is_on_off' => true]); ?>
            </div>
          <?php
          } ?>
        </div>
      </div>
    </div>

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
          <p class="mb-0 font-14px">เปิด/ปิดโปรโมชั่น</p>
          <div class="pr-20px">
            <?= TiwForm::normal('checkbox', '1', ['name' => 'is_active', 'checked' => ($_POST['is_active'] == '1') ? true : false], ['style' => '1', 'is_on_off' => true]); ?>
          </div>
        </div>
      </div>
      <?php /* 
      <div class="col-6">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">แสดงในหน้าหลัก</p>
          <div class="pr-20px">
            <?= TiwForm::normal('checkbox', '1', ['name' => 'is_show_on_main_page', 'checked' => ($_POST['is_show_on_main_page'] == '1') ? true : false], ['style' => '1', 'is_on_off' => true]); ?>
          </div>
        </div>
      </div>
      */ ?>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_rank_promotion', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
  <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
</form>