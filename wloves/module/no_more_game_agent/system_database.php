<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
require_once '../../.framework/import.php';
Structure::loadModules(['datatables', 'boatnav', 'brandnote']);
$code = $_GET['c'];
$page = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 1;
$link = '?c=' . $_GET['c'];
$is_info = (isset($_GET['is_info']) && $_GET['is_info']) ? $_GET['is_info'] : 0;
$comment_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : 0;
$is_add = (isset($_GET['is_add']) && $_GET['is_add']) ? $_GET['is_add'] : 0;
//select option for promotion page 
$select_user_group = nga_management::selectUserGroup($code);
$data_nav = [
  'param_name'  => 'page',
  'type' => 'mutiple',
  'title_list' => [
    [
      'title' => 'ฐานข้อมูล',
      'icon'   => 'module/no_more_game_agent/assets/icon/icon-folder.svg',
      'class' => '',
      'list' => [
        [
          'id'  => 1,
          'name'  => 'ตั้งค่าเกม',
          'icon'   => '',
          'count'  => '',
        ],
        [
          'id'  => 2,
          'name'  => 'จัดการกลุ่มลูกค้า',
          'icon'   => '',
          'count'  => '',
        ],
        // [
        //   'id'  => 3,
        //   'name'  => 'จัดการโปรโมชั่น',
        //   'icon'   => '',
        //   'count'  => '',
        // ],
        // [
        //   'id'  => 18,
        //   'name'  => 'จัดการโปรโมชั่นเพิ่มเติม',
        //   'icon'   => '',
        //   'count'  => '',
        // ],
        // [
        //   'id'  => 4,
        //   'name'  => 'จัดการหน้า Landing Pages',
        //   'icon'   => '',
        //   'count'  => '',
        // ],
        [
          'id'  => 11,
          'name'  => 'จัดการหน้า Banner',
          'icon'   => '',
          'count'  => '',
        ],
        // [
        //   'id'  => 5,
        //   'name'  => 'จัดการของรางวัล',
        //   'icon'   => '',
        //   'count'  => '',
        // ],
        [
          'id'  => 6,
          'name'  => 'ตั้งค่าการตลาด',
          'icon'   => '',
          'count'  => '',
        ],
        // [
        //   'id'  => 8,
        //   'name'  => 'ตั้งค่า BOT',
        //   'icon'   => '',
        //   'count'  => '',
        // ],
        // [
        //   'id'  => 10,
        //   'name'  => 'ตั้งค่าการโอนอัตโนมัติ',
        //   'icon'   => '',
        //   'count'  => '',
        // ],
        // [
        //   'id'  => 9,
        //   'name'  => 'ตั้งค่าการฝากถอนอัตโนมัติ',
        //   'icon'   => '',
        //   'count'  => '',
        // ],
        [
          'id'  => 12,
          'name'  => 'ตั้งค่าความคิดเห็น',
          'icon'   => '',
          'count'  => '',
        ],
        [
          'id'  => 13,
          'name'  => 'ตั้งค่าประกาศวิ่ง',
          'icon'   => '',
          'count'  => '',
        ],
        // [
        //   'id'  => 15,
        //   'name'  => 'ตั้งค่ากิจกรรมยอดฝากสะสม',
        //   'icon'   => '',
        //   'count'  => '',
        // ],
        [
          'id'  => 14,
          'name'  => 'ตั้งค่าสิทธิ์การสร้างลูกค้า',
          'icon'   => '',
          'count'  => '',
        ],
        [
          'id'  => 16,
          'name'  => 'ตั้งค่าสิทธิ์ยกเลิกรายการฝาก',
          'icon'   => '',
          'count'  => '',
        ],
        [
          'id'  => 17,
          'name'  => 'ตั้งค่าสิทธิ์ลิงก์เข้าสู่ระบบอัตโนมัติ',
          'icon'   => '',
          'count'  => '',
        ],

      ]
    ],
    // [
    //   'title' => 'ข้อมูลทั่วไป',
    //   'icon'   => 'module/no_more_game_agent/assets/icon/icon-folder.svg',
    //   'class' => '',
    //   'list' => [
    //     [
    //       'id'  => 7,
    //       'name'  => 'การตั้งค่าทั่วไป',
    //       'icon'   => '',
    //       'count'  => '',
    //     ],
    //   ]
    // ],
  ],
];

if ($_POST) {
  if (isset($_POST['submit_edit_website_data'])) {
    unset($_POST['submit_edit_website_data']);
    $result =  nga_management::updateGeneralWebsite($code, $_POST, $_FILES['img_file']);
  } else if (isset($_POST['submit_add_announce'])) {
    unset($_POST['submit_add_announce']);
    $data = [
      'is_use' => (isset($_POST['is_use'])) ? true : false,
      'announce_text' => $_POST['announce_note_1']
    ];
    $result = nga_management::updateGeneralAnnounce($code, $data);
  } else if (isset($_POST['submit_add_promotion'])) {
    unset($_POST['submit_add_promotion']);
    $user_group_temp = [];
    foreach ($select_user_group as $key => $value) {
      $user_group_temp[$key] = [
        'user_group_id' => $value['id'],
        'is_active' => (in_array($value['id'], $_POST['user_group_promotion'])) ? 1 : 0
      ];
    }
    $cal_type = ['deposit', 'new_user'];
    if (!in_array($_POST['calculate_type'], $cal_type)) {
      unset($_POST['sum_deposit']);
    }
    if ($_POST['calculate_type'] == 'new_user') {
      unset($_POST['sum_deposit_ex']);
    } else if ($_POST['calculate_type'] == 'deposit') {
      $_POST['sum_deposit'] = $_POST['sum_deposit_ex'];
      unset($_POST['sum_deposit_ex']);
    }
    if ($_POST['calculate_type'] != 'new_user') {
      $_POST['user_group_promotion'] = $user_group_temp;
    }
    $_POST['is_show_on_promotion_page'] = isset($_POST['is_show_on_promotion_page']) ? 1 : 0;
    $_POST['is_show_on_main_page'] = isset($_POST['is_show_on_main_page']) ? 1 : 0;
    $_POST['is_show_on_user_from_alliance'] = isset($_POST['is_show_on_user_from_alliance']) ? 1 : 0;
    $_POST['is_per_day_unlimit'] = isset($_POST['is_per_day_unlimit']) ? 1 : 0;
    $_POST['is_per_user_unlimit'] = isset($_POST['is_per_user_unlimit']) ? 1 : 0;
    $_POST['is_max_user_unlimit'] = isset($_POST['is_max_user_unlimit']) ? 1 : 0;

    $_POST['is_cal_with_turn_over'] = isset($_POST['is_cal_with_turn_over']) ? 1 : 0;
    $_POST['is_game_card_can_use'] = isset($_POST['is_game_card_can_use']) ? 1 : 0;
    $_POST['is_game_board_can_use'] = isset($_POST['is_game_board_can_use']) ? 1 : 0;
    $_POST['is_game_slot_can_use'] = isset($_POST['is_game_slot_can_use']) ? 1 : 0;
    $_POST['is_game_arcade_can_use'] = isset($_POST['is_game_arcade_can_use']) ? 1 : 0;
    $_POST['is_game_casinolive_can_use'] = isset($_POST['is_game_casinolive_can_use']) ? 1 : 0;
    $_POST['is_game_fishing_can_use'] = isset($_POST['is_game_fishing_can_use']) ? 1 : 0;
    $_POST['is_game_sport_can_use'] = isset($_POST['is_game_sport_can_use']) ? 1 : 0;

    if (!$_POST['is_cal_with_turn_over']) {
      unset($_POST['turn_over_times']);
    }
    if ($_POST['type'] != 'credit') {
      unset($_POST['is_cal_with_turn_over']);
      unset($_POST['turn_over_times']);
      if ($_POST['calculate_type'] != 'deposit') {
        unset($_POST['sum_deposit']);
      }
      unset($_POST['is_game_card_can_use']);
      unset($_POST['is_game_board_can_use']);
      unset($_POST['is_game_slot_can_use']);
      unset($_POST['is_game_arcade_can_use']);
      unset($_POST['is_game_casinolive_can_use']);
      unset($_POST['is_game_fishing_can_use']);
      unset($_POST['is_game_sport_can_use']);
    }
    // if ($_POST['credit_point_receive']) {
    //   unset($_POST['credit_point_receive_percent']);
    // } else if ($_POST['credit_point_receive_percent']) {
    //   unset($_POST['credit_point_receive']);
    // $_POST['credit_point_receive'] = $_POST['credit_percent_point_receive'];
    // }
    if ($_POST['game']) {
      $_POST['game_product_list'] = $_POST['game'];
    };
    unset($_POST['game']);
    if ($_POST['game_type']) {
      $_POST['game_type_list'] = $_POST['game_type'];
    };
    unset($_POST['game_type']);

    if ($_POST['unlock_turn_over'] == '') {
      unset($_POST['unlock_turn_over']);
    };
    $_POST['turn_over_extra_percent'] = 0;

    $result = nga_management::addNewPromotion($code, $_POST, $_FILES['image']);
  } else if (isset($_POST['submit_edit_promotion'])) {
    unset($_POST['submit_edit_promotion']);
    $user_group_temp = [];
    foreach ($select_user_group as $key => $value) {
      $user_group_temp[$key] = [
        'user_group_id' => $value['id'],
        'is_active' => (in_array($value['id'], $_POST['user_group_promotion'])) ? 1 : 0
      ];
    }
    $_POST['user_group_promotion'] = $user_group_temp;
    $_POST['is_show_on_promotion_page'] = isset($_POST['is_show_on_promotion_page']) ? 1 : 0;
    $_POST['is_show_on_main_page'] = isset($_POST['is_show_on_main_page']) ? 1 : 0;
    $_POST['is_show_on_user_from_alliance'] = isset($_POST['is_show_on_user_from_alliance']) ? 1 : 0;
    $_POST['is_per_day_unlimit'] = isset($_POST['is_per_day_unlimit']) ? 1 : 0;
    $_POST['is_per_user_unlimit'] = isset($_POST['is_per_user_unlimit']) ? 1 : 0;
    $_POST['is_max_user_unlimit'] = isset($_POST['is_max_user_unlimit']) ? 1 : 0;

    $_POST['is_cal_with_turn_over'] = isset($_POST['is_cal_with_turn_over']) ? 1 : 0;
    $_POST['is_game_card_can_use'] = isset($_POST['is_game_card_can_use']) ? 1 : 0;
    $_POST['is_game_board_can_use'] = isset($_POST['is_game_board_can_use']) ? 1 : 0;
    $_POST['is_game_slot_can_use'] = isset($_POST['is_game_slot_can_use']) ? 1 : 0;
    $_POST['is_game_arcade_can_use'] = isset($_POST['is_game_arcade_can_use']) ? 1 : 0;
    $_POST['is_game_casinolive_can_use'] = isset($_POST['is_game_casinolive_can_use']) ? 1 : 0;
    $_POST['is_game_fishing_can_use'] = isset($_POST['is_game_fishing_can_use']) ? 1 : 0;
    $_POST['is_game_sport_can_use'] = isset($_POST['is_game_sport_can_use']) ? 1 : 0;
    if (!$_POST['is_cal_with_turn_over']) {
      unset($_POST['turn_over_times']);
    }
    if ($_POST['game']) {
      $_POST['game_product_list'] = $_POST['game'];
    };
    unset($_POST['game']);
    if ($_POST['game_type']) {
      $_POST['game_type_list'] = $_POST['game_type'];
    };
    unset($_POST['game_type']);
    $_POST['turn_over_extra_percent'] = 0;


    $result =  nga_management::updatePromotion($code, $_POST['id'], $_POST, $_FILES['image']);
  } else if (isset($_POST['submit_delete_promotion'])) {
    $result = nga_management::deletePromotionByID($code, $_POST['id']);
  } else if (isset($_POST['submit_delete_auto_transfer'])) {
    $result = nga_management::deleteBotAutoTransferByID($code, $_POST['id']);
  } else if (isset($_POST['submit_add_auto_transfer'])) {
    $result = nga_management::addNewBotAutoTransfer($code, $_POST);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('../../');
  Aww::loadAsset('assets/css/no_more_gaming.css');
  ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php
  include_once '../../structure/layout/header-default.php';
  ?>
  <div class="form-row mb--20px">
    <div class="col-lg-3 p-0 border-right-simpler">
      <div class="w-card" style="min-height: calc(100vh - 70px);">
        <div class="px-20px py-10px">
          <p class="font-weight-bold mb-0 font-18px">ตั้งค่าฐานข้อมูล</p>
          <p class="mb-0 font-15px">
            ตั้งค่าฐานข้อมูลต่าง ๆ เพื่อนำไปใช้
            ภายในระบบ โปรดตรวจเช็คข้อมูลการ
            ตั้งค่าให้ถูกต้องทุกครั้ง</p>
        </div>
        <?php Boatnav::wolves($data_nav, $link); ?>
      </div>
    </div>
    <div class="col-lg-9 p-0 ">
      <?php
      if ($page == 1) {
        include 'view/setting/game_status.php';
      } else if ($page == 2 && $is_info) {
        include 'view/setting/customer_detail.php';
      } else if ($page == 2 && $is_add) {
        include 'view/setting/add_customer_group.php';
      } else if ($page == 2) {
        include 'view/setting/customer_group_setting.php';
        // } else if ($page == 3) {
        //   include 'view/setting/promotion_setting.php';
        // } else if ($page == 4) {
        //   include 'view/setting/landing_setting.php';
        // } else if ($page == 5) {
        //   include 'view/setting/reward_setting.php';
      } else if ($page == 6) {
        include 'view/setting/alliance_setting.php';
        // } else if ($page == 7) {
        //   include 'view/setting/general_setting.php';
        // } else if ($page == 8 && !$is_info) {
        //   include 'view/setting/bot_setting.php';
        // } else if ($page == 8 && $is_info) {
        //   include 'view/setting/bot_setting_detail.php';
        // } else if ($page == 9) {
        //   include 'view/setting/withdraw_auto_setting.php';
        // } else if ($page == 10) {
        //   include 'view/setting/transfer_auto_setting.php';
      } else if ($page == 11) {
        include 'view/setting/banner_setting.php';
      } else if ($page == 12 && $comment_id) {
        include 'view/setting/comment/comment_setting.php';
      } else if ($page == 12 && !$comment_id) {
        include 'view/setting/comment/category_comment_setting.php';
      } else if ($page == 13) {
        include 'view/setting/tile_writer_setting.php';
      } else if ($page == 14) {
        include 'view/setting/permission_create_user_setting.php';
        // } else if ($page == 15) {
        // include 'view/setting/deposit_event.php';
      } else if ($page == 16) {
        include 'view/setting/permission_cancel_list_setting.php';
      } else if ($page == 17) {
        include 'view/setting/permission_auto_login.php';
        // } else if ($page == 18) {
        //   include 'view/setting/promotion_extra.php';
      }
      ?>
    </div>
  </div>
  <?php
  include_once '../../structure/layout/footer.php';
  Structure::loadFooter('../../');
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

</body>

</html>

<script>
  $(document).ready(function() {
    $(document).on("change", ".event_group_bank input", function(e) {
      var bot_main = $(this).val();
      listBotBank(bot_main);
    });
  });

  function listBotBank(id) {
    var params = {
      code: '<?= $code; ?>',
      id: id,
    };
    $.post('ajax/ajax_select_bot_bank.php', params)
      .done(function(data) {
        $('.event_botBank_target').html(data);
      })
  }
</script>