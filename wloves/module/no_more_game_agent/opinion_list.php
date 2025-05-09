<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'opinion'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav', 'brandnote']);
$code = $_GET['c'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$count = nga_management::countCommentStatus($code);

if ($_POST) {
  if (isset($_POST['submit_opinion'])) {
    $ids[] = $_POST['id'];
    $status = $_POST['status'];
    $remark = $_POST['remark'];
    if ($status == 'pending') {
      $result = nga_user::setCommentPending($code, $ids, $remark);
    } else if ($status == 'completed') {
      $result = nga_user::setCommentComplete($code, $ids, $remark);
    }
  } else if (isset($_POST['submit_done'])) {
    $remark = $_POST['remark'];
    $lists = json_decode($_POST['ids']);
    $result = nga_user::setCommentComplete($code, $lists, $remark);
  } else if (isset($_POST['submit_wait_confirm'])) {
    $remark = $_POST['remark'];
    $lists = json_decode($_POST['ids']);
    $result = nga_user::setCommentPending($code, $lists, $remark);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};
$type_list = [];
$commentgroup =  nga_management::selectCommentGroup($code);
foreach ($commentgroup  as $key => $data) {
  $type_list[] =
    [
      'value' => $data['id'],
      'text' =>  $data['group_name'],
    ];
}

$status_list = [
  [
    'value' => 5,
    'text' => 'ดีมาก'
  ],
  [
    'value' => 4,
    'text' => 'ดี'
  ],
  [
    'value' => 3,
    'text' => 'พอใช้'
  ],
  [
    'value' => 2,
    'text' => 'แย่'
  ],
  [
    'value' => 1,
    'text' => 'แย่มาก'
  ],
];
$process_list = [
  [
    'value' => 'waiting',
    'text' => 'ยังไม่ดำเนินการ'
  ],
  [
    'value' => 'pending',
    'text' => 'กำลังดำเนินการ'
  ],
];
$data_nav = [
  'param_name'  => 'page',
  'class' => 'bg-whites',
  'list' => [
    [
      'id'  => 1,
      'name'  => 'รอดำเนินการ (' . $count['not_complete'] . ')',
    ],
    [
      'id'  => 2,
      'name'  => 'เสร็จสิ้น (' . $count['completed'] . ')',
    ]
  ]
];
$link = '?c=' . $_GET['c'];


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
  <?php if ($page == 1) { ?>
    <div class="bg-white">
      <div id="opinion_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('opinion_list', '?c=' . $code, '', 'ความคิดเห็นของลูกค้าที่รอดำเนินการ') ?>>
        <div class="table-responsive">
          <table class="table table-sort table-search ">
            <thead>
              <tr>
                <th nowrap class="thin-cell no-sort"> <?= Homepagify::createCheckboxThead('checkboxAll1', 'value', []); ?></th>
                <th nowrap data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วัน/เวลาที่แจ้ง</th>
                <th nowrap data-sort="group_name" data-filter="<?= Homepagify::dataFilter('comment_group_id', 'select', $type_list) ?>">หมวดหมู่</th>
                <th nowrap data-sort="title_name" data-filter="<?= Homepagify::dataFilter('title_name', 'text') ?>">หัวข้อ</th>
                <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
                <th nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อลูกค้า</th>
                <th nowrap data-sort="rating" data-filter="<?= Homepagify::dataFilter('rating', 'select', $status_list) ?>">ความพึงพอใจ</th>
                <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $process_list) ?>">การดำเนินการ</th>
                <th nowrap data-sort="admin_username" data-filter="<?= Homepagify::dataFilter('admin_username', 'text') ?>">โดย</th>
                <th nowrap data-sort="update_date_time" data-filter="<?= Homepagify::dataFilter('update_date', 'date') ?>">วัน/เวลาที่ดำเนินการล่าสุด</th>
                <th nowrap></th>
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
        <button class="btn btn-warning event_reject_list text-white" data-is_check_table='opinion_list' <?= Tiwdal::register('modal_wait_confirm', []); ?>>กำลังดำเนินการ</button>
        <button class="btn btn-success event_approve_list" data-is_check_table='opinion_list' <?= Tiwdal::register('modal_done', []); ?>>เสร็จสิ้น</button>
      </div>
    </div>
  <?php } else if ($page == 2) { ?>
    <div class="bg-white">
      <div id="opinion_history_list" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('opinion_history_list', '?c=' . $code, '', 'ความคิดเห็นของลูกค้าเสร็จสิ้นแล้ว') ?>>
        <div class="table-responsive">
          <table class="table table-sort table-search ">
            <thead>
              <tr>
                <th nowrap data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วัน/เวลาที่แจ้ง</th>
                <th nowrap data-sort="group_name" data-filter="<?= Homepagify::dataFilter('comment_group_id', 'select', $type_list) ?>">หมวดหมู่</th>
                <th nowrap data-sort="title_name" data-filter="<?= Homepagify::dataFilter('title_name', 'text') ?>">หัวข้อ</th>
                <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
                <th nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อลูกค้า</th>
                <th nowrap data-sort="rating" data-filter="<?= Homepagify::dataFilter('rating', 'select', $status_list) ?>">ความพึงพอใจ</th>
                <th nowrap data-sort="status">การดำเนินการ</th>
                <th nowrap data-sort="admin_username" data-filter="<?= Homepagify::dataFilter('admin_username', 'text') ?>">โดย</th>
                <th nowrap data-sort="update_date_time" data-filter="<?= Homepagify::dataFilter('update_date', 'date') ?>">วัน/เวลาที่ดำเนินการล่าสุด</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  <?php } ?>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

  <?php Tiwdal::ajaxModal('opinion_detail', 'modal-xl'); ?>

  <?php Tiwdal::startModal('modal_done', 'modal-xs'); ?>
  <form method="post" class="">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-center">
        <h5 class="modal-title">เสร็จสิ้น</h5>
      </div>
      <div class="modal-body px-0">
        <div class="form-row px-15px">
          <div class="col-12 text-center">
            <p class="font-14px">
              คุณต้องการเปลี่ยนสถานะความคิดเห็นที่เลือกทั้งหมดเป็น <br>
              <span class="text-success">" เสร็จสิ้น "</span> ใช่หรือไม่ ?
            </p>
          </div>
        </div>
        <div class="form-row px-15px">
          <div class="col-4">หมายเหตุ (ถ้ามี)</div>
          <div class="col-8">
            <?php TiwForm::normal('textarea', '', ['name' => 'remark', 'class' => "border rounded mb-0 min-h-70px"]); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <input type="hidden" name="ids" class="scope_lists_input">
      <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ยกเลิก</button>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_done', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-success'], ['text' => 'ยืนยัน']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('modal_wait_confirm', 'modal-xs'); ?>
  <form method="post" class="">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-center">
        <h5 class="modal-title">กำลังดำเนินการ</h5>
      </div>
      <div class="modal-body px-0">
        <div class="form-row px-15px">
          <div class="col-12 text-center">
            <p class="font-14px">
              คุณต้องการเปลี่ยนสถานะความคิดเห็นที่เลือกทั้งหมดเป็น <br>
              <span class="text-warning">" กำลังดำเนินการ "</span> ใช่หรือไม่ ?
            </p>
          </div>
        </div>
        <div class="form-row px-15px">
          <div class="col-4">หมายเหตุ (ถ้ามี)</div>
          <div class="col-8">
            <?php TiwForm::normal('textarea', '', ['name' => 'remark', 'class' => "border rounded mb-0 min-h-70px"]); ?>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <input type="hidden" name="ids" class="scope_lists_input">
      <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ยกเลิก</button>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_wait_confirm', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-warning'], ['text' => 'ยืนยัน']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Aww::loadAsset('assets/js/force_logout.js'); ?>
  <script>
    $('#modal_wait_confirm , #modal_done').on('shown.bs.modal', function() {
      var lists = jQuery.parseJSON(valueChecklist('opinion_list'));
      var encode_lists = JSON.stringify(lists);
      $(this).find('.scope_lists_input').val(encode_lists)
    });


    $(document).on('change , click', 'input[name="checkbox_list"] , .table-checked-all input[type="checkbox"] , .page-size , #redemption_list th input , .select-page , .page-item', function() {
      loopCountCheckLists()
    });

    function loopCountCheckLists() {
      var i = 0;
      var status = [];
      $('input[name="checkbox_list"]').each(function() {
        if ($(this).prop("checked") == true) {
          i += 1;
          status.push($(this).data('status'));
        }
      });
      console.log(status);
      if (jQuery.inArray("waiting", status) !== -1) {
        $('.event_approve_list').attr('disabled', 'disabled');
      }
      $('.scope_count_list').text(i)
    }
  </script>

</body>

</html>