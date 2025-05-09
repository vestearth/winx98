<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav', 'brandnote']);

$id = isset($_GET['id']) ? $_GET['id'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$code = $_GET['c'];
$is_edit = isset($_GET['is_edit']) ? 1 : 0;
$current_user = User::getCurrentUserID();
$current_user_data = User::getCurrent();

$data_nav = [
  'param_name' => 'page',
  'class' => 'bg-whites',
  'list' => [
    [
      'id' => 1,
      'name' => 'รายละเอียด',
    ],
    [
      'id' => 2,
      'name' => 'รายการกระเป๋า Credit',
    ],
    [
      'id' => 3,
      'name' => 'รายการฝาก-ถอน (Wallet)',
    ],
    [
      'id' => 4,
      'name' => 'วงล้อ / เปิดไพ่ / สะสมแต้ม',
    ],
    [
      'id' => 5,
      'name' => 'โปรโมชั่น',
    ],
    [
      'id' => 6,
      'name' => 'ชวนเพื่อน',
    ],

    [
      'id' => 7,
      'name' => 'รายการคืนยอด',
    ],
    [
      'id' => 9,
      'name' => 'ประวัติการเล่นเกม',
    ],
    [
      'id' => 10,
      'name' => 'ประวัติการเล่นหวย',
    ],
    [
      'id' => 11,
      'name' => 'ประวัติการเดิมพันกีฬา',
    ],
    [
      'id' => 8,
      'name' => 'ประวัติแก้ไข',
    ],
  ],
];
$link = 'customer_details.php?c=' . $_GET['c'] . '&id=' . $id;

if ($_POST) {
  if (isset($_POST['submit_edit_customer_detail'])) {
    unset($_POST['submit_edit_customer_detail']);
    $is_auto_withdraw = isset($_POST['is_auto_withdraw']) ? $_POST['is_auto_withdraw'] : 0;
    $is_check_sum_play = isset($_POST['is_check_sum_play']) ? $_POST['is_check_sum_play'] : 0;

    $data = [
      'name' => $_POST['name'],
      'surname' => $_POST['surname'],
      'birth_date' => $_POST['birth_date'],
      'line_id' => $_POST['line_id'],
      'bank_abb' => $_POST['bank_abb'],
      'bank_number' => $_POST['bank_number'],
      'bank_name' => $_POST['bank_name'],
      'member_code' => $_POST['member_code'],
      'is_check_sum_play' => $is_check_sum_play,
      'is_auto_withdraw' => $is_auto_withdraw,
      'lost_amount_for_turn_over' => $_POST['lost_amount_for_turn_over'],
      'user_group_id' => $_POST['user_group_id'],
    ];
    $result = nga_user::updateUser($code, $id, $data);
    $name_edit = '';
    $surname_edit = '';
    $birthday_edit = '';
    $line_edit = '';
    $bank_edit = '';
    $bank_name_edit = '';
    $bank_number_edit = '';
    $member_code_edit = '';
    $user_group_id_edit = '';
    $is_check_sum_play_edit = '';
    $is_auto_withdraw_edit = '';

    if ($result['response_status'] == 'succcess') {
      if ($_POST['name'] != $_POST['old_name']) {
        $name_edit = '<br>แก้ไขชื่อ ' . $_POST['old_name'] . ' เป็น ' . $_POST['name'];
      }
      if ($_POST['surname'] != $_POST['old_surname']) {
        $surname_edit = '<br>แก้ไขนามสกุล ' . $_POST['old_surname'] . ' เป็น ' . $_POST['surname'];
      }
      if ($_POST['birth_date'] != $_POST['old_birth_date']) {
        $birthday_edit = '<br>แก้ไขวันเกิด ' . $_POST['old_birth_date'] . ' เป็น ' . $_POST['birth_date'];
      }
      if ($_POST['line_id'] != $_POST['old_line_id']) {
        $line_edit = '<br>แก้ไข Line ID ' . $_POST['old_line_id'] . ' เป็น ' . $_POST['line_id'];
      }
      if ($_POST['bank_abb'] != $_POST['old_bank_abb']) {
        $bank_edit = '<br>แก้ไขธนาคาร ' . $_POST['old_bank_abb'] . ' เป็น ' . $_POST['bank_abb'];
      }
      if ($_POST['bank_name'] != $_POST['old_bank_name']) {
        $bank_name_edit = '<br>แก้ไขชื่อบัญชีธนาคาร ' . $_POST['old_bank_name'] . ' เป็น ' . $_POST['bank_name'];
      }
      if ($_POST['bank_number'] != $_POST['old_bank_number']) {
        $bank_number_edit = '<br>แก้ไขเลขที่บัญชีธนาคาร ' . $_POST['old_bank_number'] . ' เป็น ' . $_POST['bank_number'];
      }
      if ($_POST['member_code'] != $_POST['old_member_code']) {
        $member_code_edit = '<br>แก้ไขรหัสเเนะนำเพื่อน ' . $_POST['old_member_code'] . ' เป็น ' . $_POST['member_code'];
      }
      if ($_POST['user_group_id'] != $_POST['old_user_group_id']) {
        $user_group_id_edit = '<br>แก้ไขกลุ่มลูกค้า ' . $_POST['old_user_group_id'] . ' เป็น ' . $_POST['user_group_id'];
      }
      if ($_POST['is_check_sum_play'] != $_POST['old_is_check_sum_play']) {
        $is_check_sum_play_edit = '<br>แก้ไขตรวจสอบยอดเล่น (เทิร์น) ' . $_POST['old_is_check_sum_play'] . ' เป็น ' . $is_check_sum_play;
      }
      if ($_POST['is_auto_withdraw'] != $_POST['old_is_auto_withdraw']) {
        $is_auto_withdraw_edit = '<br>แก้ไขถอนเงิน (Auto) ' . $_POST['old_is_auto_withdraw'] . ' เป็น ' . $is_auto_withdraw;
      }

      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'แก้ไขข้อมูลลูกค้า' . $name_edit . $surname_edit . $birthday_edit . $line_edit . $bank_edit . $bank_name_edit . $bank_number_edit . $member_code_edit . $user_group_id_edit . $is_check_sum_play_edit . $is_auto_withdraw_edit,
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);

      $admin_user_name = Amst::get('sys_user', 'username', ['id' => $id]);
      $admin_user_ids = Amst::selectNoKey('sys_user', 'id', ['user_type_id' => 1]);
      foreach ($admin_user_ids as $noti_user_id) {
        $noti_all_user[] = [
          'user_id' => DB::setStringVal($noti_user_id),
          'topic' => DB::setStringVal('มีการแก้ไขข้อมูลลูกค้า'),
          'description' => DB::setStringVal($current_user_data['username'] ? $current_user_data['username'] : ''),
          'type' => DB::setStringVal('แก้ไขข้อมูลลูกค้า' . $name_edit . $surname_edit . $birthday_edit . $line_edit . $bank_edit . $bank_name_edit . $bank_number_edit . $member_code_edit . $user_group_id_edit . $is_check_sum_play_edit . $is_auto_withdraw_edit),
          'ref_id' => DB::setStringVal($id),
        ];
      }
      if ($noti_all_user) {
        Amst::insertBulk('sys_user_notification', $noti_all_user, ['page_size' => 40]); // 30-40 is GOOD
      }
    }
  } else if (isset($_POST['submit_deposit_customer'])) {
    $data = [
      'user_id' => $_POST['user_id'],
      'transaction_type' => 'deposit',
      'credit_amount' => $_POST['credit_amount'],
      'transaction_by_user_id' => $current_user,
      'remark' => $_POST['remark'],
      'web_bank_bot_list_id' => $_POST['web_bank_bot_list_id'],
      'status' => 'completed',
      'transaction_by' => 'admin',
      'is_credit' => '1',
    ];
    $result = nga_user::addUserCreditTransaction($code, $data, $_FILES['img']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'add_deposit',
        'detail' => 'เพิ่มเครดิตลูกค้า ' . $_POST['credit_amount'] . ' เครดิต สาเหตุ :' . $_POST['remark'],
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_withdraw_customer'])) {
    $data = [
      'user_id' => $_POST['user_id'],
      'transaction_type' => 'withdraw',
      'credit_amount' => $_POST['credit_amount'],
      'transaction_by_user_id' => $current_user,
      'remark' => $_POST['remark'],
      'status' => 'completed',
      'transaction_by' => 'admin',
      'is_credit' => '1',
    ];
    $result = nga_user::addUserCreditTransaction($code, $data);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'add_withdraw',
        'detail' => 'ลดเครดิตลูกค้า ' . $_POST['credit_amount'] . ' เครดิต สาเหตุ :' . $_POST['remark'],
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_add_point_game'])) {
    $result = nga_user::addPoint($code, $_POST['user_id'], $_POST['point_amount']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'เพิ่มโบนัสให้ลูกค้า ' . $_POST['point_amount'] . ' แต้ม',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_block_user'])) {
    $result = nga_user::ban($code, $id);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'แบนลูกค้า',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_unblock_user'])) {
    $result = nga_user::unban($code, $id);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'ปลดแบนลูกค้า',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_decrease_turn_over'])) {
    $result = nga_user::reduceTurnoverForWithdraw($code, $_POST['user_id'], $_POST['reduce_amount']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'ลดยอดเทิร์นโอเวอร์ลูกค้า ' . $_POST['reduce_amount'] . ' บาท',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_increase_turn_over'])) {
    $result = nga_user::increaseTurnoverForWithdraw($code, $_POST['user_id'], $_POST['increase_amount']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'เพิ่มยอดเทิร์นโอเวอร์ลูกค้า ' . $_POST['increase_amount'] . ' บาท',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_decrease_turn_over_promo'])) {
    $result = nga_user::reduceTurnoverPromotion($code, $_POST['user_id'], $_POST['reduce_amount']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'ลดโปรโมชันยอดเทิร์นโอเวอร์ลูกค้า ' . $_POST['reduce_amount'] . ' บาท',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_increase_turn_over_promo'])) {
    $result = nga_user::increaseTurnoverPromotion($code, $_POST['user_id'], $_POST['increase_amount']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'เพิ่มโปรโมชันยอดเทิร์นโอเวอร์ลูกค้า ' . $_POST['increase_amount'] . ' บาท',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_complete_cancel_transfer'])) {
    $result = nga_user::cancelWithdraw($code, $_POST['id'], $_POST['remark_cancel']);
  } else if (isset($_POST['submit_edit_password'])) {
    $data = [
      'password' => $_POST['renew_password'],
    ];
    $result = nga_user::updateUserPassword($code, $_POST['user_id'], $data);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'แก้ไขรหัสผ่านลูกค้า',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_edit_username'])) {
    $result = nga_user::updateUserName($code, $_POST['user_id'], $_POST['renew_username']);
    if ($result['response_status'] == 'succcess') {
      $renew_username_edit = '';
      if ($_POST['renew_username'] != $_POST['old_renew_username']) {
        $renew_username_edit = 'แก้ไขรหัสสมาชิก (Web)  ' . $_POST['old_renew_username'] . ' เป็น ' . $_POST['renew_username'];
      }
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'แก้ไขชื่อยูสเซอร์ลูกค้า' . $renew_username_edit,
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_add_alias'])) {
    $result = nga_user::addNewUserBankAlias($code, $_POST['user_id'], $_POST['alias_bank_account']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'เพิ่มบัญชีอื่น (ตอนฝาก)',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  } else if (isset($_POST['submit_edit_alias'])) {
    if (in_array(0, $_POST['alias_bank_account'])) {
      $key = array_search(0, $_POST['alias_bank_account']);
      unset($_POST['alias_bank_account'][$key]);
    }
    $result = nga_user::updateUserBankAlias($code, $_POST['user_id'], $_POST['alias_bank_account']);
    if ($result['response_status'] == 'succcess') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'แก้ไขบัญชีอื่น (ตอนฝาก)',
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
  }
  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

$customer_data = nga_user::getUserByID($code, $id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
Structure::loadMeta('../../');
Aww::loadAsset('assets/css/no_more_gaming.css');
?>
</head>

<body class="<?=Structure::getThemeClass();?>">
  <?php include_once '../../structure/layout/header-default.php';
?>
  <div class="editable-card core-new border-radius-0 font-14px">
    <?php if (isset($_GET['is_from_user_group'])) {?>
      <div class="card-header-primary border-radius-0  pl-15px py-10px font-13px d-flex">
        <a class="text-info" href="system_database.php?c=<?=$_GET['c']?>&page=2&sub_page=2&is_info=1&page=2&id=<?=$_GET['user_group_id']?>">
          <div>จัดการกลุ่มลูกค้า</div>
        </a>
        <div class="mx-1">></div>
        <div class="text-primary">ข้อมูลลูกค้า</div>
      </div>
    <?php } else {?>
      <div class="card-header-primary border-radius-0  pl-15px py-10px font-13px d-flex">
        <a class="text-info" href="customer_list.php?c=<?=$_GET['c']?>">
          <div>ลูกค้า</div>
        </a>
        <div class="mx-1">></div>
        <div class="text-primary">ข้อมูลลูกค้า</div>
      </div>
    <?php }?>
    <div class="editable-card core-new border-radius-bottom-0 ">
      <div class="editable-card-header rounded-0 d-flex justify-content-between p-0 bg-whites nav-lines">
        <?=Boatnav::dinner($data_nav, $link);?>
      </div>
    </div>
  </div>
  <?php
if ($page == 1) {
  include 'view/customer/customer_detail.php';
} else if ($page == 2) {
  include 'view/customer/credit_list.php';
} else if ($page == 3) {
  include 'view/customer/wallet_list.php';
} else if ($page == 4) {
  include 'view/customer/lucky_wheel.php';
} else if ($page == 5) {
  include 'view/customer/promotion.php';
} else if ($page == 6) {
  include 'view/customer/invite_friends.php';
} else if ($page == 7) {
  include 'view/customer/return_list.php';
} else if ($page == 8) {
  include 'view/customer/edit_history.php';
} else if ($page == 9) {
  include 'view/customer/game_played_history.php';
} else if ($page == 10) {
  include 'view/customer/lotto_played_history.php';
} else if ($page == 11) {
  include 'view/customer/sport_played_history.php';
}
?>


  <?php Tiwdal::startModal('delete_clear_job', 'modal-md');?>

  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>

  <div class="modal-body">
    <h3 class="text-center font-16px font-SemiBold text-uppercase">Delete Clear Job</h3>
    <p class="mb-0 text-center mb-10px">
      Are you sure to delete <span class="text-danger text-uppercase"> “Clear Job” </span>form Clear job.<br>
      Your delete is not effect with recent history.
    </p>
  </div>
  <form method="post">
    <div class="modal-footer d-flex justify-content-between  bg-color">
      <?php
TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-light min-w-100px', 'data-dismiss' => 'modal'], ['text' => 'Cancel']);
TiwForm::normal('btn', '', ['name' => 'submit_delete_clear_job', 'type' => 'submit', 'class' => 'btn btn-danger'], ['text' => 'Delete']);
?>
    </div>
  </form>
  <?php Tiwdal::endModal()?>

  <?php include_once '../../structure/layout/footer.php';?>
  <?php Structure::loadFooter('../../');?>

</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js');?>