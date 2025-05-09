<?php
// Structure::loadMetaForAjax('../../../');

if ($_POST) {
  if (isset($_POST['submit_edit_birthday_promo'])) {
    unset($_POST['submit_edit_birthday_promo']);
    $game_type_list = json_decode(base64_decode($_POST['game_type']));
    $game_product_list = json_decode(base64_decode($_POST['game']));

    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : '0';
    $data = [
      'name' => 'birthday promotion',
      'description' => $_POST['description'],
      'turn_over_for_receive' => $_POST['turn_over_for_receive'],
      'turn_over_for_withdraw' => $_POST['turn_over_for_withdraw'],
      // 'game_product_list' => $_POST['game'],
      // 'game_type_list' => $_POST['game_type'],
      // ชั่วคราวใช้เพื่อเก็บค่า game_type และ game_product ไว้ก่อน
      'game_product_list' => $game_product_list,
      'game_type_list' => $game_type_list,
      'unlock_turn_over' => $_POST['unlock_turn_over'],
      'is_active' => $is_active,
    ];
    $img_file = isset($_FILES['img_file']) ? $_FILES['img_file'] : null;
    // foreach ($_POST as $key => $value) {
    //   if (is_numeric($key)) {
    //     $result_usergroup = nga_management::updatePromotionBirthdayUserGroup($_GET['c'], $key, ['receive_amount' => $value]);
    //   }
    // }
    $result = nga_management::updatePromotionBirthday($_GET['c'], 1, $data, $img_file);
  } else if (isset($_POST['submit_edit_special_promo'])) {
    unset($_POST['submit_edit_special_promo']);
    $game_type_list = json_decode(base64_decode($_POST['game_type']));
    $game_product_list = json_decode(base64_decode($_POST['game']));

    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : '0';
    $data = [
      'description' => $_POST['description'],
      'turn_over_for_withdraw' => $_POST['turn_over_for_withdraw'],
      // 'game_product_list' => $_POST['game'],
      // 'game_type_list' => $_POST['game_type'],

      // ชั่วคราวใช้เพื่อเก็บค่า game_type และ game_product ไว้ก่อน
      'game_product_list' => $game_product_list,
      'game_type_list' => $game_type_list,
      'unlock_turn_over' => $_POST['unlock_turn_over'],
      'is_active' => $is_active,
    ];
    $img_file = isset($_FILES['img_file']) ? $_FILES['img_file'] : null;
    foreach ($_POST as $key => $value) {
      if (is_numeric($key)) {
        $result_usergroup = nga_management::updatePromotionSpecialDayUserGroup($_GET['c'], $key, ['receive_amount' => $value]);
      }
    }
    $result = nga_management::updatePromotionSpecialDay($_GET['c'], 1, $data, $img_file);
  } else if (isset($_POST['submit_edit_lucky_promo'])) {
    unset($_POST['submit_edit_lucky_promo']);
    $game_type_list = json_decode(base64_decode($_POST['game_type']));
    $game_product_list = json_decode(base64_decode($_POST['game']));
    $is_active = isset($_POST['is_active']) ? $_POST['is_active'] : '0';

    $data = [
      'description' => $_POST['description'],
      'turn_over_for_withdraw' => $_POST['turn_over_for_withdraw'],
      // 'game_product_list' => $_POST['game'],
      // 'game_type_list' => $_POST['game_type'],

      // ชั่วคราวใช้เพื่อเก็บค่า game_type และ game_product ไว้ก่อน
      'game_product_list' => $game_product_list,
      'game_type_list' => $game_type_list,
      'unlock_turn_over' => $_POST['unlock_turn_over'],
      'is_active' => $is_active,
    ];
    $img_file = isset($_FILES['img_file']) ? $_FILES['img_file'] : null;
    foreach ($_POST as $key => $value) {
      if (is_numeric($key) && isset($_POST['deposit_require_' . $key])) {
        $deposit_require_key = 'deposit_require_' . $key;
        $deposit_require_value = $_POST[$deposit_require_key];
        $result_usergroup = nga_management::updatePromotionMonthlyUserGroup($_GET['c'], $key, ['receive_amount' => $value, 'deposit_require' => $deposit_require_value]);
      }
    }
    $result = nga_management::updatePromotionMonthly($_GET['c'], 1, $data, $img_file);
  } else if (isset($_POST['submit_edit_rank_promotion'])) {
    unset($_POST['submit_edit_rank_promotion']);
    // $user_group_temp = [];
    // foreach ($select_user_group as $key => $value) {
    //   $user_group_temp[$key] = [
    //     'user_group_id' => $value['id'],
    //     'is_active' => (in_array($value['id'], $_POST['user_group_promotion'])) ? 1 : 0
    //   ];
    // }
    // $_POST['user_group_promotion'] = $user_group_temp;
    // $_POST['is_show_on_promotion_page'] = isset($_POST['is_show_on_promotion_page']) ? 1 : 0;
    // $_POST['is_show_on_main_page'] = isset($_POST['is_show_on_main_page']) ? 1 : 0;
    // $_POST['is_game_card_can_use'] = isset($_POST['is_game_card_can_use']) ? 1 : 0;
    // $_POST['is_game_board_can_use'] = isset($_POST['is_game_board_can_use']) ? 1 : 0;
    // $_POST['is_game_slot_can_use'] = isset($_POST['is_game_slot_can_use']) ? 1 : 0;
    // $_POST['is_game_arcade_can_use'] = isset($_POST['is_game_arcade_can_use']) ? 1 : 0;
    // $_POST['is_game_casinolive_can_use'] = isset($_POST['is_game_casinolive_can_use']) ? 1 : 0;
    // $_POST['is_game_fishing_can_use'] = isset($_POST['is_game_fishing_can_use']) ? 1 : 0;
    // $_POST['is_game_sport_can_use'] = isset($_POST['is_game_sport_can_use']) ? 1 : 0;
    $_POST['is_active'] = isset($_POST['is_active']) ? 1 : 0;
    // if ($_POST['game']) {
    //   $_POST['game_product_list'] = $_POST['game'];
    // };
    // unset($_POST['game']);
    // if ($_POST['game_type']) {
    //   $_POST['game_type_list'] = $_POST['game_type'];
    // };
    // unset($_POST['game_type']);
    $data = [
      'is_show_on_promotion_page' => 1,
      'is_show_on_main_page'       => 1,
      'is_active'       => $_POST['is_active'],
    ];
    $id = $_POST['id'];
    unset($_POST['id']);
    $result =  nga_management::updatePromotionDeposit($code, $id, $data, $_FILES['image']);
  }
  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}


$hbd_promo = nga_management::getPromotionBirthday($code);
$special_promo = nga_management::getPromotionSpecialDay($code);
$monthly_promo = nga_management::getPromotionMonthly($code);
$game_product = nga_api_seamless::getProductIDList($code);
$game_type_list_data = ['CARD', 'BOARD', 'ARCADE', 'SLOT', 'FISHING', 'CASINOLIVE', 'SPORT', 'LOTTO'];
?>
<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">การตั้งค่าโปรโมชันเพิ่มเติม
    </div>
    <div class="font-15px text-secondary">จัดการการตั้งค่าโปรโมชันเพิ่มเติม</div>
  </div>
</div>
<div class=" bg-white">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        โปรโมชั่นวันเกิด (รับได้เฉพาะเดือนเกิดเท่านั้น)
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($hbd_promo['update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $hbd_promo['last_update_username']
            ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'edit_birthday_promo', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        โปรโมชั่นวันพิเศษ (รับได้เฉพาะวันที่ 21-25 ของแต่ละเดือนเท่านั้น)
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($special_promo['update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $special_promo['last_update_username']
            ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'edit_special_promo', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        โปรโมชั่นรับโชครายเดือน (รับได้เฉพาะวันที่ 1-5 ของแต่ละเดือนเท่านั้น)
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($monthly_promo['update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $monthly_promo['last_update_username']
            ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'edit_lucky_promo', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        โปรโมชั่นฝากแรกของวัน (แรงค์ Bronze-Silver)
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <?php
          $promotion_rank_bronze = nga_management::getPromotionDepositByType($code, 'bronze_silver');
          ?>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($promotion_rank_bronze['update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $promotion_rank_bronze['last_update_username']
            ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'edit_promotion_first_depo', 'modal_data' => $promotion_rank_bronze, 'modal_prefix' => '', 'is_ajax' => true]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        โปรโมชั่นฝากแรกของวัน (แรงค์ Gold Diamond)
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <?php
          $promotion_rank_gold = nga_management::getPromotionDepositByType($code, 'gold_diamond');
          ?>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($promotion_rank_gold['update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $promotion_rank_gold['last_update_username']
            ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'edit_promotion_first_depo', 'modal_data' => $promotion_rank_gold, 'modal_prefix' => '', 'is_ajax' => true]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        โปรโมชั่นฝากแรกของวัน (แรงค์ Con)
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <?php
          $promotion_rank_con = nga_management::getPromotionDepositByType($code, 'con');
          ?>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($promotion_rank_con['update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $promotion_rank_con['last_update_username']
            ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'edit_promotion_first_depo', 'modal_data' => $promotion_rank_con, 'modal_prefix' => '', 'is_ajax' => true]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        โปรโมชั่นฝากแรกของวัน (แรงค์ VIP-VVIP)
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <?php
          $promotion_rank_vip = nga_management::getPromotionDepositByType($code, 'vip_vvip');
          ?>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($promotion_rank_vip['update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $promotion_rank_vip['last_update_username']
            ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'edit_promotion_first_depo', 'modal_data' => $promotion_rank_vip, 'modal_prefix' => '', 'is_ajax' => true]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
</div>

<?php Tiwdal::startModal('edit_birthday_promo', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">โปรโมชันวันเกิด</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-3 pt-7px">
          <p class="mb-0 font-14px">เงื่อนไขรายละเอียด</p>
        </div>
        <div class="col-9">
          <?= TiwForm::normal('textarea', $hbd_promo['description'], ['name' => 'description', 'class' => 'form-control', 'placeholder' => 'กรอก', 'readonly' => 1], []); ?>
        </div>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">กำหนดยอดรับแต่ละ Rank</div>
    <div class="form-group">
      <div class="form-row">
        <?php foreach ($hbd_promo['user_group_receive'] as $user_rank) { ?>
          <div class="col-md-3 pt-7px">
            <label class="font-14px font-SemiBold"><?= $user_rank['user_group_name'] ?></label>
          </div>
          <div class="col-md-9 readonly-temp">
            <?= TiwForm::normal('number', $user_rank['receive_amount'], ['name' => $user_rank['id'], 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">กำหนดเงื่อนไขยอดเทิร์น</div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ยอดเดิมพันหมุนเวียนขั้นต่ำในเดือนเกิด</label>
        </div>
        <div class="col-md-9 readonly-temp">
          <?= TiwForm::normal('number', $hbd_promo['turn_over_for_receive'], ['name' => 'turn_over_for_receive', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ติดเทิร์น (คิดจากยอดโบนัสที่ได้รับ)</label>
        </div>
        <div class="col-md-9 readonly-temp">
          <?= TiwForm::normal('number', $hbd_promo['turn_over_for_withdraw'], ['name' => 'turn_over_for_withdraw', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-3 pt-7px">
            <label class="font-14px font-SemiBold">ปลดเทิร์น % (คิดจากยอดโบนัสที่ได้รับ)</label>
          </div>
          <div class="col-md-9 readonly-temp">
            <?= TiwForm::normal('number', $monthly_promo['unlock_turn_over'], ['name' => 'unlock_turn_over', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">ประเภทเกม</div>
    <div class="form-group">
      <div class="form-row">
        <?php
        if (empty($hbd_promo['game_type_list'])) {
          $json_decode_game_type = [];
        } else {
          $json_decode_game_type = json_decode($hbd_promo['game_type_list'], true);
        }
        $isChecked = false;
        foreach ($game_type_list_data as $game_type_list) {
          if (!empty($hbd_promo['game_type_list'])) {
            $isChecked = in_array($game_type_list, $json_decode_game_type) ? true : false;
          }
        ?>
          <div class="col-md-4 mb-10px disabled-temp">
            <?= TiwForm::normal('checkbox', $game_type_list, ['name' => 'game_type_mock[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_type_list, 'is_on_off' => true]); ?>
          </div>
        <?php
        } ?>
        <?php
        $game_type_list_test = base64_encode($hbd_promo['game_type_list'])
        ?>
        <?= TiwForm::normal('hidden', $game_type_list_test, ['name' => 'game_type']); ?>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">กำหนดค่ายเกมที่ได้รับโปรโมชัน</div>
    <div class="form-group">
      <div class="form-row">
        <?php
        if (empty($hbd_promo['game_product_list'])) {
          $json_decode_product = [];
        } else {
          $json_decode_product = json_decode($hbd_promo['game_product_list'], true);
        }

        foreach ($game_product as $game_setting) {
          $isChecked = in_array($game_setting, $json_decode_product) ? true : false;
        ?>
          <div class="col-md-4 mb-10px disabled-temp">
            <?= TiwForm::normal('checkbox', $game_setting, ['name' => 'game_mock[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_setting, 'is_on_off' => true]); ?>
          </div>
        <?php
        } ?>
        <?php
        $game_product_list_test = base64_encode($hbd_promo['game_product_list'])
        ?>
        <?= TiwForm::normal('hidden', $game_product_list_test, ['name' => 'game'], ['style' => '1', 'label' => $game_setting, 'is_on_off' => true]); ?>
      </div>
    </div>
    <div class="form-group ">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">รูปโปรโมชัน</label>
          <div class="font-12px text-secondary">(สัดส่วน 1080x1080 px)</div>
        </div>
        <div class="col-md-9 text-primary pt-7px">
          <?php
          $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
          ];
          TiwForm::normal('upload-img', $hbd_promo['img_path'], ['name' => 'img_file',], $options);
          ?>
        </div>
      </div>
    </div>
    <div class="form-row my-15px">
      <div class="col-3">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">เปิดใช้โปรโมชัน</p>
        </div>
      </div>
      <div class="col-9">
        <div class="pr-20px">
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_active', 'checked' => ($hbd_promo['is_active'] == '1') ? true : false], ['style' => '1', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_edit_birthday_promo">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>


<?php Tiwdal::startModal('edit_special_promo', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">โปรโมชั่นวันพิเศษ</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-3 pt-7px">
          <p class="mb-0 font-14px">เงื่อนไขรายละเอียด</p>
        </div>
        <div class="col-9">
          <?= TiwForm::normal('textarea', $special_promo['description'], ['name' => 'description', 'class' => 'form-control', 'placeholder' => 'กรอก', 'readonly' => 1], []); ?>
        </div>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">กำหนดยอดรับแต่ละ Rank</div>
    <div class="form-group">
      <div class="form-row">
        <?php foreach ($special_promo['user_group_receive'] as $user_rank) { ?>
          <div class="col-md-3 pt-7px">
            <label class="font-14px font-SemiBold"><?= $user_rank['user_group_name'] ?></label>
          </div>
          <div class="col-md-9 readonly-temp">
            <?= TiwForm::normal('number', $user_rank['receive_amount'], ['name' => $user_rank['id'], 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">กำหนดเงื่อนไขยอดเทิร์น</div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ติดเทิร์น (คิดจากยอดโบนัสที่ได้รับ)</label>
        </div>
        <div class="col-md-9 readonly-temp">
          <?= TiwForm::normal('number', $special_promo['turn_over_for_withdraw'], ['name' => 'turn_over_for_withdraw', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ปลดเทิร์น % (คิดจากยอดโบนัสที่ได้รับ)</label>
        </div>
        <div class="col-md-9 readonly-temp">
          <?= TiwForm::normal('number', $monthly_promo['unlock_turn_over'], ['name' => 'unlock_turn_over', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">ประเภทเกม</div>
    <div class="form-group">
      <div class="form-row">
        <?php
        if (empty($special_promo['game_type_list'])) {
          $json_decode_game_type = [];
        } else {
          $json_decode_game_type = json_decode($special_promo['game_type_list'], true);
        }
        $isChecked = false;
        foreach ($game_type_list_data as $game_type_list) {
          if (!empty($special_promo['game_type_list'])) {
            $isChecked = in_array($game_type_list, $json_decode_game_type) ? true : false;
          }
        ?>
          <div class="col-md-4 mb-10px disabled-temp">
            <?= TiwForm::normal('checkbox', $game_type_list, ['name' => 'game_type[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_type_list, 'is_on_off' => true]); ?>
          </div>
        <?php
        } ?>
        <?php
        $game_type_list_test = base64_encode($special_promo['game_type_list'])
        ?>
        <?= TiwForm::normal('hidden', $game_type_list_test, ['name' => 'game_type']); ?>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">กำหนดค่ายเกมที่ได้รับโปรโมชัน</div>
    <div class="form-group">
      <div class="form-row">
        <?php
        if (!empty($special_promo['game_product_list'])) {
          $json_decode_product = json_decode($special_promo['game_product_list'], true);
        } else {
          $json_decode_product = [];
        }
        foreach ($game_product as $game_setting) {
          $isChecked = in_array($game_setting, $json_decode_product) ? true : false;
        ?>
          <div class="col-md-4 mb-10px disabled-temp">
            <?= TiwForm::normal('checkbox', $game_setting, ['name' => 'game[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_setting, 'is_on_off' => true]); ?>
          </div>
        <?php
        } ?>
        <?php
        $game_product_list_test = base64_encode($special_promo['game_product_list'])
        ?>
        <?= TiwForm::normal('hidden', $game_product_list_test, ['name' => 'game']); ?>
      </div>
    </div>
    <div class="form-group ">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">รูปโปรโมชัน</label>
          <div class="font-12px text-secondary">(สัดส่วน 1080x1080 px)</div>
        </div>
        <div class="col-md-9 text-primary pt-7px">
          <?php
          $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
          ];
          TiwForm::normal('upload-img', $special_promo['img_path'], ['name' => 'img_file',], $options);
          ?>
        </div>
      </div>
    </div>
    <div class="form-row my-15px">
      <div class="col-3">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">เปิดใช้โปรโมชัน</p>
        </div>
      </div>
      <div class="col-9">
        <div class="pr-20px">
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_active', 'checked' => ($special_promo['is_active'] == '1') ? true : false], ['style' => '1', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_edit_special_promo">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('edit_lucky_promo', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">โปรโมชันรับโชครายเดือน</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">

    <div class="form-group">
      <div class="form-row">
        <div class="col-3 pt-7px">
          <p class="mb-0 font-14px">เงื่อนไขรายละเอียด</p>
        </div>
        <div class="col-9">
          <?= TiwForm::normal('textarea', $monthly_promo['description'], ['name' => 'description', 'class' => 'form-control', 'placeholder' => 'กรอก', 'readonly' => '1'], []); ?>
        </div>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">กำหนดยอดรับแต่ละ Rank</div>
    <div class="form-group">
      <div class="form-row">
        <?php foreach ($monthly_promo['user_group_receive'] as $user_rank) { ?>
          <div class="col-md-3 pt-7px">
            <label class="font-14px font-SemiBold"><?= $user_rank['user_group_name'] ?></label>
          </div>
          <div class="col-md-3 readonly-temp">
            <?= TiwForm::normal('number', $user_rank['receive_amount'], ['name' => $user_rank['id'], 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          </div>
          <div class="col-md-3 pt-7px">
            <label class="font-14px font-SemiBold">ยอดฝากสะสมขั้นต่ำ</label>
          </div>
          <div class="col-md-3 readonly-temp">
            <?= TiwForm::normal('number', $user_rank['deposit_require'], ['name' => 'deposit_require_' . $user_rank['id'], 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">กำหนดเงื่อนไขยอดเทิร์น</div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ติดเทิร์น (คิดจากยอดโบนัสที่ได้รับ)</label>
        </div>
        <div class="col-md-9 readonly-temp">
          <?= TiwForm::normal('number', $monthly_promo['turn_over_for_withdraw'], ['name' => 'turn_over_for_withdraw', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ปลดเทิร์น % (คิดจากยอดโบนัสที่ได้รับ)</label>
        </div>
        <div class="col-md-9 readonly-temp">
          <?= TiwForm::normal('number', $monthly_promo['unlock_turn_over'], ['name' => 'unlock_turn_over', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">ประเภทเกม</div>
    <div class="form-group">
      <div class="form-row">
        <?php
        if (empty($monthly_promo['game_type_list'])) {
          $json_decode_game_type = [];
        } else {
          $json_decode_game_type = json_decode($monthly_promo['game_type_list'], true);
        }
        $isChecked = false;
        foreach ($game_type_list_data as $game_type_list) {
          if (!empty($monthly_promo['game_type_list'])) {
            $isChecked = in_array($game_type_list, $json_decode_game_type) ? true : false;
          }
        ?>
          <div class="col-md-4 mb-10px disabled-temp">
            <?= TiwForm::normal('checkbox', $game_type_list, ['name' => 'game_type[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_type_list, 'is_on_off' => true]); ?>
          </div>
        <?php
        } ?>
        <?php
        $game_type_list_test = base64_encode($monthly_promo['game_type_list'])
        ?>
        <?= TiwForm::normal('hidden', $game_type_list_test, ['name' => 'game_type']); ?>
      </div>
    </div>
    <div class="font-Medium font-16px mb-10px">กำหนดค่ายเกมที่ได้รับโปรโมชัน</div>
    <div class="form-group">
      <div class="form-row">
        <?php
        if (empty($monthly_promo['game_product_list'])) {
          $json_decode_product = [];
        } else {
          $json_decode_product = json_decode($monthly_promo['game_product_list'], true);
        }
        foreach ($game_product as $game_setting) {
          $isChecked = in_array($game_setting, $json_decode_product) ? true : false;
        ?>
          <div class="col-md-4 mb-10px disabled-temp">
            <?= TiwForm::normal('checkbox', $game_setting, ['name' => 'game[]', 'checked' => ($isChecked) ? true : false], ['style' => '1', 'label' => $game_setting, 'is_on_off' => true]); ?>
          </div>
        <?php
        } ?>
        <?php
        $game_product_list_test = base64_encode($monthly_promo['game_product_list'])
        ?>
        <?= TiwForm::normal('hidden', $game_product_list_test, ['name' => 'game']); ?>
      </div>
    </div>

    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">รูปโปรโมรชัน</label>
          <div class="font-12px text-secondary">(สัดส่วน 1080x1080 px)</div>
        </div>
        <div class="col-md-9 text-primary pt-7px">
          <?php
          $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
          ];
          TiwForm::normal('upload-img', $monthly_promo['img_path'], ['name' => 'img_file',], $options);
          ?>
        </div>
      </div>
    </div>
    <div class="form-row my-15px">
      <div class="col-3">
        <div class="d-flex justify-content-between">
          <p class="mb-0 font-14px">เปิดใช้โปรโมชัน</p>
        </div>
      </div>
      <div class="col-9">
        <div class="pr-20px">
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_active', 'checked' => ($monthly_promo['is_active'] == '1') ? true : false], ['style' => '1', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_edit_lucky_promo">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::ajaxModal('edit_promotion_first_depo', 'modal-md'); ?>


<script>
  $('.disabled-temp input').attr('disabled', true);
  $('.readonly-temp input').attr('readonly', true);
  $(".event_card_percent").on("keyup", function() {
    var sum = 0;
    $(".event_card_percent").each(function() {
      if ($(this).val() != "")
        sum += parseFloat($(this).val());
      sum_format = sum.toFixed(2);
    });

    $(".event_result_card").html(sum_format);
    if (sum_format != 100) {
      $('.event_check_percent_card').attr('disabled', true);
    } else {
      $('.event_check_percent_card').attr('disabled', false);
    }
  });

  $(".event_slot_percent").on("keyup", function() {
    var sum = 0;
    $(".event_slot_percent").each(function() {
      if ($(this).val() != "")
        sum += parseFloat($(this).val());
      sum_format = sum.toFixed(2);
    });

    $(".event_result_slot").html(sum_format);
    if (sum_format != 100) {
      $('.event_check_percent_slot').attr('disabled', true);
    } else {
      $('.event_check_percent_slot').attr('disabled', false);
    }
  });
  $(document).on('click', '.event_is_use_announce input[name="is_use"]', function() {
    if ($(this).prop("checked") == true) {
      $('.scope_is_use_announce').text('เปิดใช้งาน')
      $('.scope_is_use_announce').removeClass('text-danger');
      $('.scope_is_use_announce').addClass('text-primary');
    } else if ($(this).prop("checked") == false) {
      $('.scope_is_use_announce').text('ปิดใช้งาน')
      $('.scope_is_use_announce').removeClass('text-primary');
      $('.scope_is_use_announce').addClass('text-danger');
    }
  });

  $(document).on('change', '.event_recive_type', function() {
    var type = $(this).val();
    var scope = $(this).parents('.scope_row_condition');
    if (type == 'reward') {
      scope.find('.scope_recive_amount').val(1);
      scope.find('.scope_recive_amount').attr('readonly', true);
    } else {
      scope.find('.scope_recive_amount').attr('readonly', false);
    }
  });

  $(document).on('change', 'input[name="event_check_all"]', function() {
    if ($(this).prop("checked") == true) {
      $('.scope_user_group_check').find('input').prop('checked', true);
    } else if ($(this).prop("checked") == false) {
      $('.scope_user_group_check').find('input').prop('checked', false);
    }
  });
</script>