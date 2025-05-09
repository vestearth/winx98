<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'redemption'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav', 'brandnote']);
$code = $_GET['c'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$count_reward = nga_user::countUserRedemtionHistory($code);

if ($_POST) {
  if (isset($_POST['submit_confirm_reward'])) {
    $result =  nga_user::updateUserRedemptionStatus($code, $_POST['id'], $_POST['status_send']);
  } else if (isset($_POST['submit_confirm_multi_reward'])) {
    $lists = json_decode($_POST['ids']);
    $result = nga_user::updateUserRedemptionStatusByList($code, $lists, 'confirm');
  } else if (isset($_POST['submit_confirm_reject_multi_reward'])) {
    $lists = json_decode($_POST['ids']);
    $result = nga_user::updateUserRedemptionStatusByList($code, $lists, 'rejected');
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};

$status_list = [

  [
    'value' => 'confirm',
    'text' => 'ยืนยันแล้ว'
  ],
  [
    'value' => 'rejected',
    'text' => 'ยกเลิก'
  ],
  // [
  //   'value' => 'wait_confirm',
  //   'text' => 'รอยืนยัน'
  // ],
];

$data_nav = [
  'param_name'  => 'page',
  'class' => 'bg-whites',
  'list' => [
    [
      'id'  => 1,
      'name'  => 'รอยืนยัน (' . $count_reward['wait_confirm'] . ')',
    ],
    [
      'id'  => 2,
      'name'  => 'ประวัติการแลก (' . $count_reward['confirm'] . ')',
    ]
  ]
];
$link = 'redemption_list.php?c=' . $_GET['c'];


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
  <?php include_once '../../structure/layout/header-default.php'; ?>
  <div class="editable-card core-new border-radius-bottom-0 ">
    <div class="editable-card-header rounded-0 d-flex justify-content-between p-0 bg-whites nav-lines">
      <?= Boatnav::dinner($data_nav, $link); ?>
    </div>
  </div>
  <!-- <div class='bg-white mb-15px pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">

      <div class="msg col-lg-6">
        <div class='topic ml-10px'>
          รายการแลกของรางวัล </div>
        <div class="font-14px text-sub ml-10px">
          ข้อมูลรายละเอียดรายการแลกของรางวัล
        </div>
      </div>
    </div>
  </div> -->
  <?php if ($page == 1) { ?>
    <div class="bg-white">
      <div id="redemption_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('redemption_list', '?c=' . $code, '', 'รายการแลกของรางวัล') ?>>
        <div class="table-responsive">
          <table class="table table-sort table-search ">
            <thead>
              <tr>
                <th nowrap class="thin-cell no-sort"> <?= Homepagify::createCheckboxThead('checkboxAll1', 'value', []); ?> </th>
                <th nowrap data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วัน/เวลา</th>
                <th nowrap data-sort="reward_name" data-filter="<?= Homepagify::dataFilter('reward_name', 'text') ?>">ของรางวัล</th>
                <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
                <th nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อลูกค้า</th>
                <th nowrap data-sort="point_before" class="text-right">จำนวนแต้ม(ก่อน)</th>
                <th nowrap data-sort="point_use" class="text-right">แต้มที่ใข้</th>
                <th nowrap data-sort="point_after" class="text-right">จำนวนแต้ม(หลัง)</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <div class="float-nav">
      <div class="side side-left">
        <p class="mb-0 font-16px">เลือกรายการทั้งหมด | <span class="text-primary"><span class="scope_count_list">0</span> รายการ </span> </p>
      </div>
      <div class="side side-right">
        <button class="btn btn-danger event_reject_list" <?= Tiwdal::register('modal_reject', []); ?>>ไม่อนุมัติ</button>
        <button class="btn btn-success event_approve_list" <?= Tiwdal::register('modal_approve', []); ?>>อนุมัติ</button>
      </div>
    </div>
  <?php } else if ($page == 2) { ?>
    <div class="bg-white">
      <div id="redemption_history_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('redemption_history_list', '?c=' . $code, '', 'รายการแลกของรางวัล') ?>>
        <div class="table-responsive">
          <table class="table table-sort table-search ">
            <thead>
              <tr>
                <th nowrap data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วัน/เวลา</th>
                <th nowrap data-sort="reward_name" data-filter="<?= Homepagify::dataFilter('reward_name', 'text') ?>">ของรางวัล</th>
                <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
                <th nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อลูกค้า</th>
                <th nowrap data-sort="point_before" class="text-right">จำนวนแต้ม(ก่อน)</th>
                <th nowrap data-sort="point_use" class="text-right">แต้มที่ใข้</th>
                <th nowrap data-sort="point_after" class="text-right">จำนวนแต้ม(หลัง)</th>
                <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

  <?php Tiwdal::startModal('detail', 'modal-md'); ?>
  <form method="post" class="">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ยืนยันของรางวัล</h5>
      </div>
      <div class="modal-body px-0">

        <div class=" form-row px-15px ">
          <div class=" col-lg-4 my-auto pb-10px text-subs">
            วัน/เวลา
          </div>
          <div class="col-lg-8  pb-10px">
            <span name="{date_data}"></span>
          </div>

          <div class="col-lg-4 my-auto pb-10px text-subs">
            ของรางวัล
          </div>
          <div class="col-lg-8  pb-10px">
            <span name="{reward_name}"></span>
          </div>

          <div class="col-lg-4 my-auto pb-10px text-subs">
            รหัสลูกค้า
          </div>
          <div class="col-lg-8  pb-10px">
            <span name="{username}"></span>
          </div>

          <div class="col-lg-4 my-auto pb-10px text-subs">
            ชื่อลูกค้า
          </div>
          <div class="col-lg-8  pb-10px">
            <span name="{bank_name}" class="text-primary"></span>
          </div>

          <div class="col-lg-4 my-auto pb-10px text-subs">
            จำนวนแต้ม (ก่อน)
          </div>
          <div class="col-lg-8  pb-10px">
            <span name="{point_before}"></span>
          </div>

          <div class="col-lg-4 my-auto pb-10px text-subs">
            จำนวนแต้ม (หลัง)
          </div>
          <div class="col-lg-8  pb-10px">
            <span name="{point_after}"></span>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <input type="hidden" name="{id}">
      <input type="hidden" name="{status_send}">
      <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ยกเลิก</button>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_confirm_reward', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-success',], ['text' => 'ยืนยัน']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('modal_approve', 'modal-xs'); ?>
  <form method="post" class="">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-center">
        <h5 class="modal-title">อนุมัติการแลกของรางวัล</h5>
      </div>
      <div class="modal-body px-0">
        <div class="form-row px-15px">
          <div class="col-12 text-center">
            <p class="font-14px">คุณต้องการอนุมัติการแลกของรางวัล <span class="text-success">" <span class="scope_count_list_confirm">0</span> รายการนี้ "</span> ใช่หรือไม่ ?</p>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <input type="hidden" name="ids" class="scope_lists_input">
      <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ยกเลิก</button>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_confirm_multi_reward', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-success',], ['text' => 'ยืนยัน']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('modal_reject', 'modal-xs'); ?>
  <form method="post" class="">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-center">
        <h5 class="modal-title">ไม่อนุมัติการแลกของรางวัล</h5>
      </div>
      <div class="modal-body px-0">
        <div class="form-row px-15px">
          <div class="col-12 text-center">
            <p class="font-14px">คุณไม่อนุมัติการแลกของรางวัล <span class="text-danger">" <span class="scope_count_list_confirm">0</span> รายการนี้ "</span> ใช่หรือไม่ ?</p>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <input type="hidden" name="ids" class="scope_lists_input">
      <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ยกเลิก</button>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_confirm_reject_multi_reward', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-danger',], ['text' => 'ยืนยัน']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Aww::loadAsset('assets/js/force_logout.js'); ?>
  <script>
    $('#modal_reject , #modal_approve').on('shown.bs.modal', function() {
      var lists = jQuery.parseJSON(valueChecklist('redemption_list'));
      var encode_lists = JSON.stringify(lists);
      var count = lists.length;
      $(this).find('.scope_lists_input').val(encode_lists)
      $(this).find('.scope_count_list_confirm').text(count)
    })

    $(document).on('change , click', 'input[name="checkbox_list"] , .table-checked-all input[type="checkbox"] , .page-size , #redemption_list th input , .select-page , .page-item', function() {
      loopCountCheckLists()
    });

    function loopCountCheckLists() {
      var i = 0;
      $('input[name="checkbox_list"]').each(function() {
        if ($(this).prop("checked") == true) {
          i += 1
        }
      });
      $('.scope_count_list').text(i)
    }
  </script>

</body>

</html>