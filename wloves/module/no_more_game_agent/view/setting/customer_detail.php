<?php
$id = isset($_GET['id']) ? $_GET['id'] : null;
$sub_page = (isset($_GET['sub_page']) && $_GET['sub_page']) ? $_GET['sub_page'] : 1;
$link = '?c=' . $_GET['c'] . '&page=' .  $_GET['page'] . '&is_info=1&id=' . $id;
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : 0;
$data_nav       = [
  'param_name'  => 'sub_page',
  'class' => 'nav-ststus',
  'list'  => []
];
$data_nav['list'] = [
  [
    'id'     => 1,
    'name'   => 'ข้อมูลกลุ่มลูกค้า',
  ],
  [
    'id'     => 2,
    'name'   => 'รายชื่อลูกค้าในกลุ่ม',
  ],

];

if ($_POST) {
  if (isset($_POST['submit_edit_user_group'])) {
    unset($_POST['submit_edit_user_group']);
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
      // 'withdraw_bot_group_list_id' => $_POST['withdraw_bot_group_list_id'],

      'withdraw_bot_group_id' => $_POST['withdraw_bot_group_id'],
      'deposit_bot_group_id' => $_POST['deposit_bot_group_id'],

      // 'deposit_time' => $_POST['deposit_time'],
      // 'is_show_all_withdraw_account' => (isset($_POST['is_show_all_withdraw_account'])) ? true : false,
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
    $result =  nga_management::updateUserGroup($code, $id, $data, $_FILES['img_file']);
    $response_redirect = 'system_database.php?c=' . $_GET['c'] . '&page=2&is_info=1&id=' . $id;
  } else if (isset($_POST['submit_delete_user_group'])) {
    $result = nga_management::deleteUserGroupByID($code, $_POST['id']);
    $response_redirect = 'system_database.php?c=' . $code . '&page=2';
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

<div class="form-row m-0">
  <div class="col-12 p-0 mb--10px">
    <div class="editable-card core-new border-radius-0 mb-10px">
      <div class="editable-card-header-back pl-15px py-10px font-13px d-flex border-radius-0">
        <a class="text-secondary" href="system_database.php?c=<?= $_GET['c'] ?>&page=2">จัดการกลุ่มลูกค้า </a>
        <span class="px-5px">></span>
        <span class="text-primary">รายละเอียดกลุ่มลูกค้า</span>
      </div>
    </div>
  </div>
  <div class="col-12 p-0 mb--10px ">
    <div class="top-nav border-radius-0 align-items-center">
      <?php Boatnav::dinner($data_nav, $link); ?>

      <button type="button" class="btn btn-dropdown-3dot p-0 bg-card-navbar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?= file_get_contents('assets/icon/more.svg'); ?>
      </button>
      <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm border-radius-10px py-0">
        <button type="button" class="btn dropdown-item align-items-center more-hover-active" <?= Tiwdal::register('delete_user_group', []); ?>>
          <?= file_get_contents('assets/icon/icon-delete.svg') ?>
          <span class="ml-10px text-danger">ลบข้อมูล</span>
        </button>
      </div>
    </div>
    <?php
    if ($sub_page == 1) {
      include 'customer_detail_info.php';
    } else if ($sub_page == 2) {
      include 'customer_detail_list.php';
    }
    ?>
  </div>
</div>

<?php Tiwdal::startModal('delete_user_group', 'modal-md'); ?>
<form method="post">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-body mt-30px">
    <h3 class="text-center font-16px font-SemiBold text-uppercase">ลบกลุ่มลูกค้า</h3>
    <p class="mb-5px text-center">
      คุณต้องการ <span class="text-danger text-uppercase"> “ลบกลุ่มลูกค้า”</span> นี้ใช่หรือไม่
    </p>
  </div>
  <div class="modal-footer d-flex justify-content-between">
    <?php TiwForm::normal('hidden', $id, ['name' => 'id'], []); ?>
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">ยกเลิก</button>
    <button type="submit" class="btn btn-danger w-100px" name="submit_delete_user_group">ยืนยัน</button>
  </div>
</form>
<?php Tiwdal::endModal(); ?>

<script>
  // $(document).ready(function() {
  //   $(document).on("change", ".event_group_bank input", function(e) {
  //     var bot_main = $(this).val();
  //     $('.event_botBank_clear').empty();
  //     listBotBank(bot_main);
  //   });
  // });

  // function listBotBank(id) {
  //   var params = {
  //     code: '<?= $code; ?>',
  //     id: id,
  //   };
  //   $.post('ajax/ajax_select_bot_bank.php', params)
  //     .done(function(data) {
  //       $('.event_botBank_target').html(data);
  //     })
  // }
</script>