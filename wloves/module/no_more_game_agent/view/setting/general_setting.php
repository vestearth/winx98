<?php
if ($_POST) {
  if (isset($_POST['submit_card_data'])) {
    unset($_POST['submit_card_data']);
    $is_active = isset($_POST['is_activate']) ? $_POST['is_activate'] : '0';
    $reward_list = [
      [
        'id'              => 1,
        'recive_amount'   => $_POST['recive_amount_1'],
        'recive_type'     => $_POST['recive_type_1'],
        'receive_percent' => $_POST['receive_percent_1'],
        'remark'          => $_POST['remark_1'],
      ],
      [
        'id'              => 2,
        'recive_amount'   => $_POST['recive_amount_2'],
        'recive_type'     => $_POST['recive_type_2'],
        'receive_percent' => $_POST['receive_percent_2'],
        'remark'          => $_POST['remark_2'],
      ],
      [
        'id'              => 3,
        'recive_amount'   => $_POST['recive_amount_3'],
        'recive_type'     => $_POST['recive_type_3'],
        'receive_percent' => $_POST['receive_percent_3'],
        'remark'          => $_POST['remark_3'],
      ],
      [
        'id'              => 4,
        'recive_amount'   => $_POST['recive_amount_4'],
        'recive_type'     => $_POST['recive_type_4'],
        'receive_percent' => $_POST['receive_percent_4'],
        'remark'          => $_POST['remark_4'],
      ],
      [
        'id'              => 5,
        'recive_amount'   => $_POST['recive_amount_5'],
        'recive_type'     => $_POST['recive_type_5'],
        'receive_percent' => $_POST['receive_percent_5'],
        'remark'          => $_POST['remark_5'],
      ],
      [
        'id'              => 6,
        'recive_amount'   => $_POST['recive_amount_6'],
        'recive_type'     => $_POST['recive_type_6'],
        'receive_percent' => $_POST['receive_percent_6'],
        'remark'          => $_POST['remark_6'],
      ],
    ];

    $data = [
      'is_activate' => $is_active,
      'limit_use_per_day' => $_POST['limit_use_per_day'],
      'minimum_deposit' => $_POST['minimum_deposit'],
      'limit_claim_per_day' => $_POST['limit_claim_per_day'],
      'detail' => $_POST['detail'],
      'reward_list' => $reward_list,
    ];
    $result = nga_management::updateCardSetting($_GET['c'], $data);
  } else if (isset($_POST['submit_slot_setting'])) {
    $is_active = isset($_POST['is_activate']) ? $_POST['is_activate'] : '0';
    $reward_list = [
      [
        'id'              => 1,
        'recive_amount'   => $_POST['recive_amount_1'],
        'recive_type'     => $_POST['recive_type_1'],
        'receive_percent' => $_POST['receive_percent_1'],
        'amount_per_day'  => $_POST['amount_per_day_1'],
      ],
      [
        'id'              => 2,
        'recive_amount'   => $_POST['recive_amount_2'],
        'recive_type'     => $_POST['recive_type_2'],
        'receive_percent' => $_POST['receive_percent_2'],
        'amount_per_day'  => $_POST['amount_per_day_2'],
      ],
      [
        'id'              => 3,
        'recive_amount'   => $_POST['recive_amount_3'],
        'recive_type'     => $_POST['recive_type_3'],
        'receive_percent' => $_POST['receive_percent_3'],
        'amount_per_day'  => $_POST['amount_per_day_3'],
      ],
      [
        'id'              => 4,
        'recive_amount'   => $_POST['recive_amount_4'],
        'recive_type'     => $_POST['recive_type_4'],
        'receive_percent' => $_POST['receive_percent_4'],
        'amount_per_day'  => $_POST['amount_per_day_4'],
      ],
      [
        'id'              => 5,
        'recive_amount'   => $_POST['recive_amount_5'],
        'recive_type'     => $_POST['recive_type_5'],
        'receive_percent' => $_POST['receive_percent_5'],
        'amount_per_day'  => $_POST['amount_per_day_5'],
      ],
      [
        'id'              => 6,
        'recive_amount'   => $_POST['recive_amount_6'],
        'recive_type'     => $_POST['recive_type_6'],
        'receive_percent' => $_POST['receive_percent_6'],
        'amount_per_day'  => $_POST['amount_per_day_6'],
      ],
      [
        'id'              => 7,
        'recive_amount'   => $_POST['recive_amount_7'],
        'recive_type'     => $_POST['recive_type_7'],
        'receive_percent' => $_POST['receive_percent_7'],
        'amount_per_day'  => $_POST['amount_per_day_7'],
      ],
      [
        'id'              => 8,
        'recive_amount'   => $_POST['recive_amount_8'],
        'recive_type'     => $_POST['recive_type_8'],
        'receive_percent' => $_POST['receive_percent_8'],
        'amount_per_day'  => $_POST['amount_per_day_8'],
      ],
      [
        'id'              => 9,
        'recive_amount'   => $_POST['recive_amount_9'],
        'recive_type'     => $_POST['recive_type_9'],
        'receive_percent' => $_POST['receive_percent_9'],
        'amount_per_day'  => $_POST['amount_per_day_9'],
      ],
      [
        'id'              => 10,
        'recive_amount'   => $_POST['recive_amount_10'],
        'recive_type'     => $_POST['recive_type_10'],
        'receive_percent' => $_POST['receive_percent_10'],
        'amount_per_day'  => $_POST['amount_per_day_10'],
      ],
    ];
    $data = [
      'is_activate' => $is_active,
      'limit_use_per_day' => $_POST['limit_use_per_day'],
      'minimum_deposit' => $_POST['minimum_deposit'],
      'limit_claim_per_day' => $_POST['limit_claim_per_day'],
      'detail' => $_POST['detail'],
      'reward_list' => $reward_list,
    ];
    $result = nga_management::updateSlotSetting($_GET['c'], $data);
  } else if (isset($_POST['submit_update_commission'])) {
    unset($_POST['submit_update_commission']);
    $_POST['is_show_commission'] = isset($_POST['is_show_commission']) ? $_POST['is_show_commission'] : '0';
    $_POST['is_active'] = isset($_POST['is_active']) ? $_POST['is_active'] : '0';
    $_POST['is_open_card_game'] = isset($_POST['is_open_card_game']) ? $_POST['is_open_card_game'] : '0';
    $_POST['is_open_board_game'] = isset($_POST['is_open_board_game']) ? $_POST['is_open_board_game'] : '0';
    $_POST['is_open_slot_game'] = isset($_POST['is_open_slot_game']) ? $_POST['is_open_slot_game'] : '0';
    $_POST['is_open_arcade_game'] = isset($_POST['is_open_arcade_game']) ? $_POST['is_open_arcade_game'] : '0';
    $_POST['is_open_fishing_game'] = isset($_POST['is_open_fishing_game']) ? $_POST['is_open_fishing_game'] : '0';
    $_POST['is_open_casinolive_game'] = isset($_POST['is_open_casinolive_game']) ? $_POST['is_open_casinolive_game'] : '0';

    $_POST['is_active_new'] = isset($_POST['is_active_new']) ? $_POST['is_active_new'] : '0';
    // $_POST['is_open_card_game_new'] = isset($_POST['is_open_card_game_new']) ? $_POST['is_open_card_game_new'] : '0';
    // $_POST['is_open_board_game_new'] = isset($_POST['is_open_board_game_new']) ? $_POST['is_open_board_game_new'] : '0';
    // $_POST['is_open_slot_game_new'] = isset($_POST['is_open_slot_game_new']) ? $_POST['is_open_slot_game_new'] : '0';
    // $_POST['is_open_arcade_game_new'] = isset($_POST['is_open_arcade_game_new']) ? $_POST['is_open_arcade_game_new'] : '0';
    // $_POST['is_open_fishing_game_new'] = isset($_POST['is_open_fishing_game_new']) ? $_POST['is_open_fishing_game_new'] : '0';
    // $_POST['is_open_casinolive_game_new'] = isset($_POST['is_open_casinolive_game_new']) ? $_POST['is_open_casinolive_game_new'] : '0';

    $result = nga_management::updateGameUserCommissionSetting($code, $_POST);
  } else if (isset($_POST['submit_update_turnover'])) {
    unset($_POST['submit_update_turnover']);
    $_POST['is_active'] = isset($_POST['is_active']) ? $_POST['is_active'] : '0';
    $_POST['is_open_card_game'] = isset($_POST['is_open_card_game']) ? $_POST['is_open_card_game'] : '0';
    $_POST['is_open_board_game'] = isset($_POST['is_open_board_game']) ? $_POST['is_open_board_game'] : '0';
    $_POST['is_open_slot_game'] = isset($_POST['is_open_slot_game']) ? $_POST['is_open_slot_game'] : '0';
    $_POST['is_open_arcade_game'] = isset($_POST['is_open_arcade_game']) ? $_POST['is_open_arcade_game'] : '0';
    $_POST['is_open_fishing_game'] = isset($_POST['is_open_fishing_game']) ? $_POST['is_open_fishing_game'] : '0';
    $_POST['is_open_casinolive_game'] = isset($_POST['is_open_casinolive_game']) ? $_POST['is_open_casinolive_game'] : '0';
    $_POST['is_open_sport_game'] = isset($_POST['is_open_sport_game']) ? $_POST['is_open_sport_game'] : '0';
    $_POST['is_open_sportbook'] = isset($_POST['is_open_sportbook']) ? $_POST['is_open_sportbook'] : '0';
    $result = nga_management::updateGameTurnOverSetting($code, $_POST);
  } else if (isset($_POST['submit_withdraw_turnover_data'])) {
    unset($_POST['submit_withdraw_turnover_data']);
    $result = nga_management::updatePercentTurnOverSetting($code, $_POST['percent']);
  } else if (isset($_POST['submit_invoice_discount_data'])) {
    unset($_POST['submit_invoice_discount_data']);
    $data = [
      'discount_percent' => $_POST['discount_percent'],
    ];
    $result = nga_agent::updateMyInvoiceDiscount($code, $data);
  } else if (isset($_POST['submit_share_link'])) {
    unset($_POST['submit_share_link']);
    $data = [
      'title' => $_POST['title'],
      'description' => $_POST['description'],
    ];
    $img_file = isset($_FILES['img_file']) ? $_FILES['img_file'] : null;
    $result = nga_management::updateShareSetting($code, $data, $img_file);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

$check_update_general = nga_management::getManagementLastUpdate($code);
$get_generalwebsite = nga_management::getGeneralWebsite($code);
$get_announce = nga_management::getGeneralAnnounce($code);
$get_card = nga_management::getCardSetting($code);
$get_share = nga_management::getShareSetting($code);
// การสร้างรายได้ชั้น 1
$get_commission = nga_management::getGameUserCommissionSetting($code);
$turn_over = nga_management::getGameTurnOverSetting($code);
$turn_over_withdraw = nga_management::getPercentTurnOverSetting($code);
$invoice_discount = nga_agent::getMyInvoiceDiscount($code);
$reward_list = isset($get_card['reward_list']) ? $get_card['reward_list'] : [];
$get_slot = nga_management::getSlotSetting($code);
$slot_reward_list = isset($get_slot['reward_list']) ? $get_slot['reward_list'] : [];
$options_condition = [
  'list' => [
    [
      'value' => 'point',
      'name' => 'แต้ม',
    ],
    [
      'value' => 'credit',
      'name' => 'เครดิต',
    ],
    [
      'value' => 'reward',
      'name' => 'รางวัล',
    ],
  ],
];

$list_games = [
  [
    'name' => 'เปิดไพ่',
    'is_open' => 'is_open_card_game',
    'commission' => 'card_commission',
    'commission_player' => 'card_commission_player',
    'commission_lv2' => 'card_commission_lv2',
    // 'commission_player_lv2' => 'card_commission_player_lv2',

    'is_open_new'            => 'is_open_card_game_new',
    'commission_new'              => 'card_commission_new',
    'commission_player_new'       => 'card_commission_new_player',
    'commission_lv2_new'          => 'card_commission_new_lv2',
    'commission_lv3_new'          => 'card_commission_new_lv3',
  ],
  [
    'name' => 'บอร์ดเกม',
    'is_open' => 'is_open_board_game',
    'commission' => 'board_commission',
    'commission_player' => 'board_commission_player',
    'commission_lv2' => 'board_commission_lv2',
    // 'commission_player_lv2' => 'board_commission_player_lv2',

    'is_open_new'            => 'is_open_board_game_new',
    'commission_new'              => 'board_commission_new',
    'commission_player_new'       => 'board_commission_new_player',
    'commission_lv2_new'          => 'board_commission_new_lv2',
    'commission_lv3_new'          => 'board_commission_new_lv3',
  ],
  [
    'name' => 'สล็อตเสี่ยงโชค',
    'is_open' => 'is_open_slot_game',
    'commission' => 'slot_commission',
    'commission_player' => 'slot_commission_player',
    'commission_lv2' => 'slot_commission_lv2',
    // 'commission_player_lv2' => 'slot_commission_player_lv2',

    'is_open_new'            => 'is_open_slot_game_new',
    'commission_new'              => 'slot_commission_new',
    'commission_player_new'       => 'slot_commission_new_player',
    'commission_lv2_new'          => 'slot_commission_new_lv2',
    'commission_lv3_new'          => 'slot_commission_new_lv3',
  ],
  [
    'name' => 'ตู้เกม Arcade',
    'is_open' => 'is_open_arcade_game',
    'commission' => 'arcade_commission',
    'commission_player' => 'arcade_commission_player',
    'commission_lv2' => 'arcade_commission_lv2',
    // 'commission_player_lv2' => 'arcade_commission_player_lv2',

    'is_open_new'            => 'is_open_arcade_game_new',
    'commission_new'              => 'arcade_commission_new',
    'commission_player_new'       => 'arcade_commission_new_player',
    'commission_lv2_new'          => 'arcade_commission_new_lv2',
    'commission_lv3_new'          => 'arcade_commission_new_lv3',
  ],
  [
    'name' => 'คาสิโน',
    'is_open' => 'is_open_casinolive_game',
    'commission' => 'casinolive_commission',
    'commission_player' => 'casinolive_commission_player',
    'commission_lv2' => 'casinolive_commission_lv2',
    // 'commission_player_lv2' => 'casinolive_commission_player_lv2',

    'is_open_new'            => 'is_open_casinolive_game_new',
    'commission_new'              => 'casinolive_commission_new',
    'commission_player_new'       => 'casinolive_commission_new_player',
    'commission_lv2_new'          => 'casinolive_commission_new_lv2',
    'commission_lv3_new'          => 'casinolive_commission_new_lv3',
  ],
  [
    'name' => 'เกมตกปลา',
    'is_open' => 'is_open_fishing_game',
    'commission' => 'fishing_commission',
    'commission_player' => 'fishing_commission_player',
    'commission_lv2' => 'fishing_commission_lv2',
    // 'commission_player_lv2' => 'fishing_commission_player_lv2',

    'is_open_new'            => 'is_open_fishing_game_new',
    'commission_new'              => 'fishing_commission_new',
    'commission_player_new'       => 'fishing_commission_new_player',
    'commission_lv2_new'          => 'fishing_commission_new_lv2',
    'commission_lv3_new'          => 'fishing_commission_new_lv3',
  ],
  // [
  //   'name' => 'หวย',
  //   'is_open' => 'is_open_lotto',
  //   'commission' => 'lotto_commission',
  //   'commission_player' => 'lotto_commission_player',
  //   'commission_lv2' => 'lotto_commission_lv2',
  //   // 'commission_player_lv2' => 'lotto_commission_player_lv2',

  //   'is_open_new'            => 'is_open_lotto_new',
  //   'commission_new'              => 'lotto_commission_new',
  //   'commission_player_new'       => 'lotto_commission_new_player',
  //   'commission_lv2_new'          => 'lotto_commission_new_lv2',
  //   'commission_lv3_new'          => 'lotto_commission_new_lv3',
  // ],
  // [
  //   'name' => 'กีฬา',
  //   'is_open' => 'is_open_sportbook',
  //   'commission' => 'sportbook_commission',
  //   'commission_player' => 'sportbook_commission_player',
  //   'commission_lv2' => 'sportbook_commission_lv2',
  //   // 'commission_player_lv2' => 'sportbook_commission_player_lv2',

  //   'is_open_new'            => 'is_open_sportbook_new',
  //   'commission_new'              => 'sportbook_commission_new',
  //   'commission_player_new'       => 'sportbook_commission_new_player',
  //   'commission_lv2_new'          => 'sportbook_commission_new_lv2',
  //   'commission_lv3_new'          => 'sportbook_commission_new_lv3',
  // ]
];

?>
<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">การตั้งค่าทั่วไป
    </div>
    <div class="font-15px text-secondary">จัดการการตั้งค่าทั่วไปของระบบ</div>
  </div>
</div>
<div class=" bg-white">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        ลิงก์ไลน์
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($check_update_general['general_website'], 'd/m/Y, H:i') . ' โดย ' . $check_update_general['general_website_by'] ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'edit_website_data', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <!-- ปิดไว้ก่อน
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        สมัครสมาชิก
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          อัพเดทล่าสุด: 20/06/2022, 17:00 โดย Admin <span class="text-danger">(under develop)</span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'edit_register_data', 'is_data' => true, 'modal_data' => []]);

          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        Function
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          อัพเดทล่าสุด: 20/06/2022, 17:00 โดย Admin <span class="text-danger">(under develop)</span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'func_data', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        ฝาก-ถอน
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          อัพเดทล่าสุด: 20/06/2022, 17:00 โดย Admin <span class="text-danger">(under develop)</span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'depose_data', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div> -->
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        สล็อตเสี่ยงโชค
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($check_update_general['slot'], 'd/m/Y, H:i') . ' โดย ' . $check_update_general['slot_by'] ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'spin_data', 'is_data' => true, 'modal_data' => []]);

          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        เปิดไพ่
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($check_update_general['card'], 'd/m/Y, H:i') . ' โดย ' . $check_update_general['card_by'] ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'card_data', 'is_data' => true, 'modal_data' => []]);

          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        การสร้างรายได้
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          อัพเดทล่าสุด:
          <?= Aww::formatDate($check_update_general['game_user_commission'], 'd/m/Y, H:i') . ' โดย ' . $check_update_general['game_user_commission_by'] ?>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'modal_monetization', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <?php /* 
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        การคืนยอด Turnover / ยอดเสีย
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          อัพเดทล่าสุด:
          <?= Aww::formatDate($check_update_general['game_turn_over'], 'd/m/Y, H:i') . ' โดย ' . $check_update_general['game_turn_over_by'] ?>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'modal_turnover', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  */ ?>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        Turnover ที่ต้องทำสำหรับถอน
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          อัพเดทล่าสุด: <?= Aww::formatDate($turn_over_withdraw['last_update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $turn_over_withdraw['last_update_username'] ?>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'modal_withdraw_turnover', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        ตั้งค่าสำหรับการ Share ลิงก์เว็ปไซต์
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          อัพเดทล่าสุด: <?= Aww::formatDate($get_share['update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $get_share['last_update_username'] ?>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'modal_share_link', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <?php /* 
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        การตั้งค่า % ยอดรายได้
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          อัพเดทล่าสุด: <?= Aww::formatDate($invoice_discount['update_date_time'], 'd/m/Y, H:i') . ' โดย ' . $invoice_discount['id'] ?>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'modal_invoice_discount', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  <div class="col-lg-12 d-flex min-h-40px align-items-center p-0">
    <div class="col-lg-6">
      <div class=" font-16px font-SemiBold">
        ประกาศจากทางเว็บไซต์
      </div>
    </div>
    <div class="col-lg-6">
      <div class=" font-14px font-Regular d-flex justify-content-end text-muted align-items-center">
        <div>
          <span>
            อัพเดทล่าสุด:
            <?= Aww::formatDate($check_update_general['general_announce'], 'd/m/Y, H:i') . ' โดย ' . $check_update_general['general_announce_by'] ?>
          </span>
        </div>
        <div class=" ml-15px">
          <?php
          TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'mr-5px'], ['text' => '', 'type' => 'edit',  'modal_id' => 'modal_announce', 'is_data' => true, 'modal_data' => []]);
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class=" m-0">
  */ ?>
</div>
<?php Tiwdal::startModal('edit_website_data', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">ลิงก์ไลน์</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <!-- <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ชื่อเว็บ</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', $get_generalwebsite['website_name'], ['name' => 'website_name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    -->
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">line ไอดี</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', $get_generalwebsite['line_id'], ['name' => 'line_id', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ลิงก์ไลน์</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', $get_generalwebsite['line_link'], ['name' => 'line_link', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <!-- <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">เว็บสูตร</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', $get_generalwebsite['web_formula'], ['name' => 'web_formula', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">โลโก้เว็บ</label>
        </div>
        <div class="col-md-9 text-primary pt-7px">
          <?php
          $options = [
            'width' => '200px',
            'height' => '100%',
            'bg-img' => 'assets/image/bg_upload.png',
          ];
          TiwForm::normal('upload-img', $get_generalwebsite['img_path'], ['name' => 'img_file',], $options);
          ?>
        </div>
      </div>
    </div> -->
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_edit_website_data">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('edit_register_data', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">สมัครสมาชิก</h5>
</div>
<form method="post">
  <div class="modal-body">

    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">เปิดใช้การผ่าน OTP</label>
        </div>
        <div class="col-md-9 pt-7px">
          <?php TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">OTP</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '0110', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>


    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_edit_register_data">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('func_data', 'modal-lg'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">FUNCTION</h5>
</div>
<form method="post">
  <div class="modal-body">

    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">เปิดใช้แจ้งยอด
            ฝาก/ถอน ผ่าน line</label>
        </div>
        <div class="col-md-9 pt-7px">
          <?php TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">เปิดใช้ล้างแคช</label>
        </div>
        <div class="col-md-9 pt-7px">
          <?php TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">การสร้างยูสเซอร์</label>
        </div>
        <div class="col-md-9 pt-7px">
          <?php TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">สถานะเว็บไซต์</label>
        </div>
        <div class="col-md-9 pt-7px">
          <?php TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">เปิดแสดง IP</label>
        </div>
        <div class="col-md-9 pt-7px">
          <?php TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ทางเข้าระบบออโต้ใหม่</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', 'https://singhaplay.com/monitor/login?key=Npgt9NkE', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ข้อความเมื่อเว็บไซต์ปิด</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('text', '', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => '']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">รูปแบบ template</label>
        </div>
        <div class="col-md-9 pt-7px d-flex align-items-center">
          <?php TiwForm::normal('checkbox', 1, ['name' => '', 'checked' => true, 'class' => 'check-val'], ['style' => '1', 'is_on_off' => true]); ?>
          <div id="status" class=" font-16px text-primary font-Medium ml-5px">
            เปิด
          </div>
        </div>
        <div class="col-md-3 pt-7px">
        </div>
        <div class="col-md-9 pt-7px d-flex align-items-center">
          <div id="img-1" class="">
            <img src="./assets/image/image_1.png" alt="">
          </div>
          <div id="img-2" class="hide--">
            <img src="./assets/image/image_2.png" alt="">
          </div>
        </div>
      </div>
    </div>
    <script>
      $(function() {
        $(document).on('change', '.check-val input', function(e) {
          if ($(this).prop('checked') == true) {
            $('#status').html('เปิด');
            $('#status').addClass('text-primary');
            $('#status').removeClass('text-secondary');
            $('#img-2').addClass('hide--');
            $('#img-1').removeClass('hide--');
          } else {
            $('#status').html('ปิด');
            $('#status').addClass('text-secondary');
            $('#status').removeClass('text-primary');
            $('#img-2').removeClass('hide--');
            $('#img-1').addClass('hide--');
          }
        });
      });
    </script>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_func_data">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('depose_data', 'modal-lg'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">รายละเอียดลูกค้า</h5>
</div>
<form method="post">
  <div class="modal-body">

    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">กลุ่มลูกค้า</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?php
          $options = ['list' => [
            [
              'value' => '1',
              'name' => 'New User',

            ],
            [
              'value' => '2',
              'name' => 'VIP',

            ],
          ],];
          TiwForm::normal('select', '1', ['name' => ''], $options);
          ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ธนาคาร<br>
            สำหรับฝากครั้งเเรก</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?php
          $options = ['list' => [
            [
              'value' => '1',
              'name' => 'พัชรพล ณ เรืองผล, 4161199063',
              'img' => './assets/image/scb.png',
            ],
            [
              'value' => '2',
              'name' => 'พัชรพล ณ เรืองผล, 4161199063',
              'img' => './assets/image/scb.png',
            ],
          ],];
          TiwForm::normal('select-img', '1', ['name' => ''], $options);
          ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ธนาคารสำหรับ<br>
            การถอนอัตโนมัติ</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?php
          $options = ['list' => [
            [
              'value' => '1',
              'name' => 'พัชรพล ณ เรืองผล, 4161199063',
              'img' => './assets/image/scb.png',
            ],
            [
              'value' => '2',
              'name' => 'พัชรพล ณ เรืองผล, 4161199063',
              'img' => './assets/image/scb.png',
            ],
          ],];
          TiwForm::normal('select-img', '1', ['name' => ''], $options);
          ?>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ยอดฝากเกินจากนี้จะ<br>
            ไม่ใช้ระบบฝากอัตโนมัติ</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?= TiwForm::normal('number', '20,000.00', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          <span class="text-mute font-italic">
            0 คือ ปิดระบบฝากอัตโนมัติ
          </span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ยอดถอนเกินจากนี้จะ<br>
            ไม่ใช้ระบบถอนอัตโนมัติ</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?= TiwForm::normal('number', '20,000.00', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          <span class="text-mute font-italic">
            0 คือ ปิดระบบฝากอัตโนมัติ
          </span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ถอนเงินขั้นต่ำ</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?= TiwForm::normal('number', '0.00', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>

        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ถอนเงินได้สูงสุด</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?= TiwForm::normal('number', '500000.00', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>

        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">จำนวนการถอน / วัน</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?= TiwForm::normal('number', '5', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>

        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ยอด turnover<br>
            ของยอดฝาก (%)</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?= TiwForm::normal('number', '100', ['name' => 'name', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">สลับบัญชีถอนอัตโนมัติ
            (บัญชีถอนเงินไม่พอ)</label>
        </div>
        <div class="col-md-8 pt-7px ml-50px">
          <?php TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ธนาคารเปิด</label>
        </div>
        <div class="col-md-8 pt-7px ml-50px">
          <?php TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">ข้อความเมื่อธนาคารปิด</label>
        </div>
        <div class="col-md-8 ml-50px">
          <?= TiwForm::normal(
            'textarea',
            '🚨แจ้งสมาชิกทุกท่าน🚨ธนาคารไทยพาณิชย์ ขัดข้องทำให้ไม่สามารถทำรายการถอนได้ในขณะนี้ขออภัยในความไม่สะดวก',
            ['name' => 'name', 'required' => true, 'class' => 'mb-20px h-100px', 'placeholder' => 'กรอก']
          ); ?>

        </div>
      </div>
    </div>


    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_depose_data">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('spin_data', 'modal-xl'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">สล็อตเสี่ยงโชค</h5>
</div>
<form method="post">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold font-italic">สล็อตเสี่ยงโชค</label>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">เปิด-ปิดการใช้งาน </label>
        </div>
        <div class="col-md-9 pt-7px">
          <?php
          if ($get_slot['is_activate']) {
            $checked = true;
          } else {
            $checked = false;
          }
          ?>
          <?php TiwForm::normal('checkbox', '1', ['name' => 'is_activate', 'checked' => $checked], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">จำนวนลุ้นรางวัลสล็อตเสี่ยงโชค / วัน</label>
        </div>
        <div class="col-md-5 d-flex align-items-center">
          <?= TiwForm::normal('number', $get_slot['limit_use_per_day'], ['name' => 'limit_use_per_day', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          <span class="text-nowrap">ครั้ง</span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-8">
          <div class="form-row">
            <div class="col-md-4 pt-7px">
              <label class="font-14px font-SemiBold">จำนวนยอดฝากขั้นต่ำ</label>
            </div>
            <div class="col-md-7 d-flex align-items-center">
              <?= TiwForm::normal('number', $get_slot['minimum_deposit'], ['name' => 'minimum_deposit', 'required' => true, 'class' => 'mb-0 ml-25px', 'placeholder' => 'กรอก']); ?>
              <span class="text-nowrap">บาท</span>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="form-row">
            <div class="col-md-6 pt-7px">
              <label class="font-14px font-SemiBold">จำนวนสิทธิที่ได้รับ</label>
            </div>
            <div class="col-md-6 d-flex align-items-center">
              <?= TiwForm::normal('number', $get_slot['limit_claim_per_day'], ['name' => 'limit_claim_per_day', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
              <span class="text-nowrap ml-5px">สิทธิ/วัน/คน</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-14px font-SemiBold">เงื่อนไขรายละเอียด</label>
        </div>
        <div class="col-md-9">
          <?= TiwForm::normal('textarea', $get_slot['detail'], ['name' => 'detail', 'required' => true, 'class' => 'mb-0 min-h-50px', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <?php foreach ($slot_reward_list as $key => $slot_reward) {
      $i = $key + 1;
    ?>
      <div class="form-group scope_row_condition">
        <div class="form-row">
          <div class="col-md-3">
            <label class="font-14px font-SemiBold pt-7px">เงื่อนไข <?= $slot_reward['id'] ?></label>
          </div>
          <div class="col-md-1">
            <?php $is_readonly = ($slot_reward['recive_type'] == 'reward') ? 'readonly' : '';
            ?>
            <?= TiwForm::normal('number', ($slot_reward['recive_type'] == 'reward') ? 1 : $slot_reward['recive_amount'], ['name' => 'recive_amount_' . $i, 'required' => true, 'class' => 'mb-0 scope_recive_amount', $is_readonly => true]) ?>
          </div>
          <div class="col-md-2">
            <?php
            $options = ['list' => [
              [
                'value' => 'credit',
                'name' => 'เครดิต',

              ],
              [
                'value' => 'point',
                'name' => 'แต้ม',
              ],
              [
                'value' => 'reward',
                'name' => 'รางวัล',

              ],
            ],];
            TiwForm::normal('select', $slot_reward['recive_type'], ['name' => 'recive_type_' . $i, 'class' => 'event_recive_type'], $options);
            ?>
          </div>
          <div class="col-md-1 pt-7px">
            โอกาสออก
          </div>
          <div class="col-md-1">
            <?= TiwForm::normal('number', $slot_reward['receive_percent'], ['name' => 'receive_percent_' . $i, 'required' => true, 'class' => 'mb-0 event_slot_percent',]); ?>
          </div>
          <div class="col-md-1 pt-7px">
            % <span class="ml-5px">จำนวน</span>
          </div>
          <div class="col-md-1">
            <?= TiwForm::normal('number', $slot_reward['amount_per_day'], ['name' => 'amount_per_day_' . $i, 'required' => true, 'class' => 'mb-0',]); ?>
          </div>
          <div class="col-md-1 pt-7px">
            ครั้ง / วัน
          </div>

        </div>
      </div>
    <? } ?>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-6 pt-7px">
          <label class="font-14px font-SemiBold"></label>
        </div>
        <div class="col-md-6  text-primary font-Medium">
          โอกาสออก <span class="event_result_slot">100</span> %
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px event_check_percent_slot" name="submit_slot_setting">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('card_data', 'modal-xl'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">เปิดไพ่</h5>
</div>
<form method="post">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-5 pt-7px">
          <label class="font-14px font-SemiBold font-italic">เปิดไพ่</label>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-4 pt-7px">
          <label class="font-14px font-SemiBold">เปิด-ปิดการใช้งาน </label>
        </div>
        <div class="col-md-7 pt-7px">
          <?php
          if ($get_card['is_activate']) {
            $checked = true;
          } else {
            $checked = false;
          }
          ?>
          <?php TiwForm::normal('checkbox', '1', ['name' => 'is_activate', 'checked' => $checked], ['style' => '1', 'label' => '<span class="text-primary">เปิดใช้งาน</span>', 'is_on_off' => true]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-4 pt-7px">
          <label class="font-14px font-SemiBold">จำนวนลุ้นรางวัลเปิดไพ่ / วัน</label>
        </div>
        <div class="col-md-7 d-flex align-items-center">
          <?= TiwForm::normal('number', $get_card['limit_use_per_day'], ['name' => 'limit_use_per_day', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          <span class="ml-5px">ครั้ง</span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-8">
          <div class="form-row">
            <div class="col-md-6 pt-7px">
              <label class="font-14px font-SemiBold">จำนวนยอดฝากลุ้นไพ่</label>
            </div>
            <div class="col-md-6 d-flex align-items-center">
              <?= TiwForm::normal('number', $get_card['minimum_deposit'], ['name' => 'minimum_deposit', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
              <span class="ml-5px">บาท</span>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="form-row">
            <div class="col-md-5 pt-7px">
              <label class="font-14px font-SemiBold">จำนวนสิทธิที่ได้รับ</label>
            </div>
            <div class="col-md-7 d-flex align-items-center">
              <?= TiwForm::normal('number', $get_card['limit_claim_per_day'], ['name' => 'limit_claim_per_day', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
              <span class="ml-5px text-nowrap">สิทธิ/วัน/คน</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-4 pt-7px">
          <label class="font-14px font-SemiBold">เงื่อนไขรายละเอียด</label>
        </div>
        <div class="col-md-7 ">
          <?= TiwForm::normal('textarea', $get_card['detail'], ['name' => 'detail', 'required' => true, 'class' => 'mb-0 min-h-50px', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <div class="col-12">
          <div class="form-row">
            <?php
            foreach ($reward_list as $key => $reward_data) {
              $keys = $key + 1;
            ?>
              <div class="col-6 mb-15px">
                <div class="form-row">
                  <div class="col-md-2">
                    <label class="font-14px font-SemiBold pt-7px">เงื่อนไข <?= $reward_data['id'] ?></label>
                  </div>
                  <div class="col-md-2">
                    <?= TiwForm::normal('number', $reward_data['recive_amount'], ['name' => 'recive_amount_' . $keys, 'required' => true, 'class' => 'mb-0',]); ?>
                  </div>

                  <div nowrap class="col-md-3">
                    <?php
                    TiwForm::normal('select', $reward_data['recive_type'], ['name' => 'recive_type_' . $keys, 'class' => 'mb-0'], $options_condition);
                    ?>
                  </div>
                  <div class="col-md-4 d-flex align-items-center">
                    <span class="ml-5px text-nowrap">โอกาสออก</span>
                    <?= TiwForm::normal('number', $reward_data['receive_percent'], ['name' => 'receive_percent_' . $keys, 'required' => true, 'class' => 'mb-0 event_card_percent',]); ?>
                  </div>
                  <div class="col pt-7px">
                    %
                  </div>
                  <div class="col-2"></div>
                  <div class="col-10">
                    <?= TiwForm::normal('textarea', $reward_data['remark'], ['name' => 'remark_' . $keys, 'class' => 'mb-0', 'placeholder' => 'ระบุหมายเหตุ (ถ้ามี)']); ?>
                  </div>
                </div>
              </div>
            <? } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="form-group">
      <div class="form-row mt-20px">
        <div class="col-md-12 text-primary font-Medium d-flex justify-content-center">
          โอกาสออก <span class="ml-30px event_result_card">100 </span>%
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px event_check_percent_card" name="submit_card_data">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>


<?php Tiwdal::startModal('modal_announce', 'modal-md'); ?>
<div class="modal-header">
  <h5 class="modal-title text-uppercase font-16px font-SemiBold">ประกาศ</h5>
</div>
<form method="post">
  <div class="modal-body">
    <div class="col-lg-12 d-flex p-0 align-items-center flex-wrap">
      <div class="col-lg-3 font-14px font-Medium p-0">
        <div>
          เปิดใช้งาน
        </div>
      </div>
      <div class="col-lg-9 font-16px font-Medium d-flex align-items-center p-0">
        <div>
          <?php $is_use_announce = $get_announce['is_use'] == 1 ? true : false; ?>
          <?= TiwForm::normal('checkbox', 1, ['name' => 'is_use', 'class' => 'event_is_use_announce', 'checked' => $is_use_announce], ['style' => '1', 'is_on_off' => true]); ?>
        </div>
        <div class=" ml-10px">
          <span class="scope_is_use_announce <?= ($is_use_announce) ? 'text-primary' : 'text-danger' ?>"><?= ($is_use_announce) ? 'เปิดใช้งาน' : 'ปิดใช้งาน' ?></span>
        </div>
      </div>
    </div>
    <div class="col-lg-12 font-14px font-Medium p-0 mt-15px flex-wrap">
      <div>
        เนื้อหา
      </div>
    </div>
    <?php Brandnote::startNote('announce_note', 'announce_note_1', $get_announce['announce_text'], '200', ''); ?>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_add_announce', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('modal_partner', 'modal-md'); ?>
<div class="modal-header">
  <h5 class="modal-title text-uppercase font-16px font-SemiBold">การตลาด</h5>
</div>
<form method="post">
  <div class="modal-body">
    <div class="col-lg-12 d-flex p-0 flex-wrap">
      <div class="col-lg-3 font-14px font-Medium p-0">
        เปิดการรายงาน<br>
        ผลการตลาด
      </div>
      <div class="col-lg-9 font-14px font-Medium p-0 d-flex align-items-center">
        <div>
          <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '1', 'is_on_off' => true]); ?>
        </div>
        <div class=" ml-10px font-16px font-Medium text-primary">
          เปิดใช้งาน
        </div>
      </div>
    </div>
    <div class="col-lg-12 d-flex p-0 mt-15px flex-wrap">
      <div class="col-lg-3 font-14px font-Medium p-0">
        ประเภทการคำนวณ<br>
        รีพอร์ท
      </div>
      <div class="col-lg-9 font-14px font-Medium p-0 d-flex">
        <div>
          <?php
          $options = [
            'list' => [
              [
                'value' => 'เอเยนต์',
                'name' => 'เอเยนต์',
              ],
            ],
          ];
          TiwForm::normal('select', 'เอเยนต์', ['name' => '', 'class' => 'min-w-400px'], $options); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_party', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('modal_withdraw_turnover', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">Turnover ที่ต้องทำสำหรับถอน</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-5 pt-7px">
          <label class="font-14px font-SemiBold">Turnover ที่ต้องทำสำหรับถอน </label>
        </div>
        <div class="col-md-6">
          <?= TiwForm::normal('text', $turn_over_withdraw['percent'], ['name' => 'percent', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
        <div class="col-1">
          <div class="font-14px font-SemiBold pt-7px">
            %
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_withdraw_turnover_data">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('modal_share_link', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">ตั้งค่าสำหรับการแชร์ลิงก์เว็ปไซต์</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-15px">
          <label class="font-14px font-SemiBold">หัวเรื่อง</label>
        </div>
        <div class="col-md-9 pt-7px">
          <?= TiwForm::normal('text', $get_share['title'], ['name' => 'title', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
        <div class="col-md-3 pt-15px">
          <label class="font-14px font-SemiBold">รายละเอียด</label>
        </div>
        <div class="col-md-9 pt-7px">
          <?= TiwForm::normal('text', $get_share['description'], ['name' => 'description', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
        <div class="col-md-3 pt-15px">
          <label class="font-14px font-SemiBold">รูปภาพ</label>
          <p class="font-14px text-secondary">ขนาดรูปที่แนะนำ <br>900 × 500 px</p>
        </div>
        <div class="col-md-9 pt-15px">
          <?php
          $options = [
            // 'width' => '469px',
            'width' => '100%',
            // 'height' => '100%',
            'height' => '262px',
            'bg-img' => $get_share['img_path'],
            'title' => '', //title จะไปแสดงด้านล่างของรูป
            'is_btn' => 0, //ไม่เอาปุ่มทั้งหมด
            'is_view' => 1, //ไม่เอาปุ่ม view
            'is_delete' => 1, //ไม่เอาปุ่ม ลบ
            // 'preview_name' => '{name}', //ใช้กรณีที่ใช้ Auto form ใส่ชื่อให้ตรงกับ data ที่หลังบ้านส่งมา
          ];
          TiwForm::normal('upload-img', $get_share['img_path'], ['name' => 'img_file', 'title' => 'รูปจะถูกใช้ตอนแชร์ลิงค์'], $options);
          ?>
          <p class="mb-0 mt-15px">กรณีที่แชร์แล้วรูปและข้อความไม่ขึ้น ให้ไปที่ <a href="https://developers.facebook.com/tools/debug/" target="_blank">Sharing Debugger</a> แล้วเอาลิงค์เว็ปไซต์ NMG ของคุณ จากนั้นวางช่อง URL และกด Debug จากนั้นกด Scrape Again อีกครั้ง</p>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_share_link">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('modal_invoice_discount', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">ตั้งค่า % ยอดรายได้</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-5 pt-7px">
          <label class="font-14px font-SemiBold">ยอดรายได้</label>
        </div>
        <div class="col-md-6">
          <?= TiwForm::normal('text', $invoice_discount['discount_percent'], ['name' => 'discount_percent', 'required' => true, 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
        <div class="col-1">
          <div class="font-14px font-SemiBold pt-7px">
            %
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_invoice_discount_data">บันทึก</button>
    </div>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php
// การคืนยอด Turnover / ยอดเสีย
include 'general_setting/modal_turnover.php';
?>

<?php
// การสร้างรายได้ 
include 'general_setting/modal_monetization.php';
?>

<script>
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
</script>