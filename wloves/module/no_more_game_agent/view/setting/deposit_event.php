<?php
// รอเปลี่ยน API 
if ($_POST) {
  if (isset($_POST['submit_add_data'])) {
    $data = [
      'event_type' => $_POST['event_type'],
      'deposit_amount' => $_POST['deposit_amount'],
      'credit_receive' => $_POST['credit_receive'],
      'cal_turn_over_percent' => $_POST['cal_turn_over_percent'],
      'detail' => $_POST['detail'],
    ];

    $event_type = isset($_POST['event_type']) ? $_POST['event_type'] : '';
    if ($event_type == 'short_term') {
      $data['from_date_time'] = $_POST['start_date_event'];
      $data['to_date_time'] = $_POST['end_date_event'];
    } else {
      $month_open_event = isset($_POST['month_open_event']) ? $_POST['month_open_event'] : '';
      $data['from_date_time'] = Aww::formatDate($month_open_event, 'Y-m-d');
    }
    $result = nga_management::addNewEventDeposit($code, $data);
  } else if (isset($_POST['submit_edit_data'])) {
    $status = (isset($_POST['status']) && $_POST['status']) ? $_POST['status'] : 'pending';
    // $data = [
    //   'deposit_amount' => $_POST['deposit_amount'],
    //   'credit_receive' => $_POST['credit_receive'],
    //   'cal_turn_over_percent' => $_POST['cal_turn_over_percent'],
    //   'detail' => $_POST['detail'],
    // ];
    $result = nga_management::updateEventDepositStatus($code, $_POST['id'], $status);
  } else if (isset($_POST['submit_delete_activity'])) {
    $result = nga_management::deleteEventDeposiByID($code, $_POST['id']);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};

$table_event_options = [
  [
    'value' => 'short_term',
    'text' => 'Short term 7 วัน',
  ],
  [
    'value' => 'long_term',
    'text' => 'Long term 30 วัน',
  ],
];

$table_status_options = [
  [
    'value' => 'active',
    'text' => 'เปิดใช้งานอยู่',
  ],
  [
    'value' => 'pending',
    'text' => 'ตั้งเวลาเปิดล่วงหน้า',
  ],
  [
    'value' => 'expire',
    'text' => 'หมดเขตแล้ว',
  ],
];
?>

<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">ตั้งค่ากิจกรรมยอดฝากสะสม
    </div>
    <div class="font-15px text-secondary">จัดการข้อมูลกิจกรรมยอดฝากสะสม</div>
  </div>
  <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'h-40px'], ['type' => 'button', 'text' => '+ เพิ่มช่วงกิจกรรม', 'modal_id' => 'add_data', 'modal_data' => []]); ?>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">
  <div id="deposit_event" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('deposit_event', '?c=' . $_GET['c'], '', 'กิจกรรมยอดฝากสะสม',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th nowrap class="thin-cell">ช่วงเวลากิจกรรม</th>
            <th nowrap data-sort="event_type" data-filter="<?= Homepagify::dataFilter('event_type', 'select', $table_event_options) ?>">ประเภท</th>
            <th data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $table_status_options) ?>">สถานะ</th>
            <th class="thin-cell"></th>
          </tr>
        </thead>

      </table>
    </div>
  </div>
</div>
<?php Tiwdal::startModal('delete_deposit_activity', 'modal-md'); ?>
<form method="post">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-body mt-30px">
    <h3 class="text-center font-16px font-SemiBold text-uppercase">ลบกิจกรรมยอดฝากสะสม</h3>
    <p class="mb-5px text-center">
      คุณต้องการ <span class="text-danger text-uppercase"> “ลบกิจกรรมยอดฝากสะสม”</span> นี้ใช่หรือไม่
    </p>
  </div>
  <div class="modal-footer d-flex justify-content-between">
    <?php TiwForm::normal('hidden', '', ['name' => '{id}'], []); ?>
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-danger w-100px" name="submit_delete_activity">Delete</button>
  </div>
</form>
<?php Tiwdal::endModal(); ?>


<?php Tiwdal::startModal('add_data', 'modal-xl'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">เพิ่มช่วงกิจกรรมยอดฝากสะสม</h5>
</div>
<form method="post" enctype="multipart/form-data">
  <div class="modal-body">
    <div class="mb-15px font-14px font-Medium"><i>กิจกรรมยอดฝากสะสม</i></div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">
            สถานะ
          </label>
        </div>
        <div class="col-md-4">
          <div class="d-flex"></div>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">รูปแบบกิจกรรม</label>
        </div>
        <div class="col-md-4">
          <?php
          $style_event_options = [
            'list' => [
              [
                'value' => 'short_term',
                'name' => 'Short term 7 วัน',
              ],
              [
                'value' => 'long_term',
                'name' => 'Long term 30 วัน',
              ],
            ],
          ];
          TiwForm::normal('select', '', ['name' => 'event_type', 'class' => 'event_changed_type'], $style_event_options);
          ?>
        </div>
      </div>
    </div>
    <div class="form-group event_period_7">
      <div class="form-row">
        <div class="col-md-3">
          <label class="font-15px font-SemiBold">
            วัน - เวลาที่เริ่ม
          </label>
        </div>
        <div class="col-md-4">
          <div class="d-flex">
            <?php
            TiwForm::normal('datetime', '', ['name' => 'start_date_event', 'class' => 'event_lock_month'], []);
            ?>
          </div>
        </div>
        <div class="col-md-5 d-flex align-items-center">
          <span class="text-danger">ไม่สามารถเลือกวันที่ซ้ำกับวันที่มีกิจกรรมอยู่แล้ว</span>
        </div>
      </div>
    </div>
    <div class="form-group event_period_7">
      <div class="form-row">
        <div class="col-md-3">
          <label class="font-15px font-SemiBold">
            วัน - เวลาที่สิ้นสุด
          </label>
        </div>
        <div class="col-md-4">
          <div class="d-flex">
            <?php
            TiwForm::normal('datetime', '', ['name' => 'end_date_event', 'class' => 'event_set_lock_month'], []);
            ?>
          </div>
        </div>
        <div class="col-md-5 d-flex align-items-center">
          <span class="text-danger">ช่วงเวลาที่เลือกจะต้องมากกว่า 7 วัน</span>
        </div>
      </div>
    </div>
    <div class="form-group event_period_30">
      <div class="form-row">
        <div class="col-md-3">
          <label class="font-15px font-SemiBold">
            เดือนที่เปิดกิจกรรม
          </label>
        </div>
        <div class="col-md-4">
          <div class="d-flex">
            <?php
            TiwForm::normal('month', '', ['name' => 'month_open_event', 'class' => 'event_type_month'], []);
            ?>
          </div>
        </div>
        <div class="col-md-5 d-flex align-items-center">
          <span class="text-danger">ไม่สามารถเลือกเดือนที่มีกิจกรรมอยู่แล้ว</span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">จำนวนยอดฝากต่อวัน (บาท)</label>
        </div>
        <div class="col-md-4">
          <?= TiwForm::normal('number', '', ['name' => 'deposit_amount', 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ฝากครบ <span class="scope_day">7</span> วัน แจกเครดิต (บาท)</label>
        </div>
        <div class="col-md-4">
          <?= TiwForm::normal('number', '', ['name' => 'credit_receive', 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
        </div>
        <div class="col-2 pt-7px">
          <label class="font-15px font-SemiBold">ติดเทิร์น</label>
        </div>
        <div class="col-2 d-flex">
          <?= TiwForm::normal('number', '', ['name' => 'cal_turn_over_percent', 'class' => 'mb-0', 'placeholder' => 'กรอก']); ?>
          <span class="ml-3px pt-7px">%</span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">เงื่อนไขรายละเอียด</label>
        </div>
        <div class="col-md-8">
          <?= TiwForm::normal('textarea', '', ['name' => 'detail', 'class' => 'mb-0 min-h-100px', 'placeholder' => 'กรอก']); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
    <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_add_data">บันทึก</button>
  </div>
</form>
<?php Tiwdal::endModal(); ?>

<?php Tiwdal::ajaxModal('deposit_edit_data', 'modal-xl', []); ?>


<script>
  $(document).ready(function() {
    $('.event_period_30').hide();

    $(document).on('change', '.event_changed_type', function() {
      var value = $(this).val();
      if (value == 'short_term') {
        $('.scope_day').text('7');
        $('.event_period_7').show();
        $('.event_period_30').hide();
      } else if (value == 'long_term') {
        $('.scope_day').text('30');
        $('.event_period_7').hide();
        $('.event_period_30').show();
      }
    });
    $(document).on('change', '.event_lock_month', function() {
      var month_start = $(this).val();
      // cal for date last on this month 
      var month_start_split = month_start.split('T');
      var month_start_date = new Date(month_start_split[0]);
      var month_start_date_last = new Date(month_start_date.getFullYear(), month_start_date.getMonth() + 1, 0);
      var month_start_date_last_format = month_start_date_last.getFullYear() + '-' + (month_start_date_last.getMonth() + 1) + '-' + month_start_date_last.getDate();
      var month_end = (month_start_date_last_format + 'T23:59');
      // end cal for date last on this month
      $('.event_set_lock_month').attr('min', month_start);
      $('.event_set_lock_month').attr('max', month_end);
    });

  });
</script>