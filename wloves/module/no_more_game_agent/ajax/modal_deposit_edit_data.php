<?php
$prefix = '../../../';
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'auto_withdraw'];
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];
$edit_data = $_POST;
?>

<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">แก้ไขช่วงกิจกรรมยอดฝากสะสม</h5>
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
          <div class="d-flex">
            <?php
            if ($edit_data['status'] != 'expire') {
              if ($edit_data['status'] == 'active') {
                $checked = 'checked';
              } else {
                $checked = '';
              }
              TiwForm::normal('checkbox', 'active', ['name' => 'status', 'class' => 'green', 'checked' => $checked], ['style' => '1', 'is_on_off' => true, 'label' => 'เปิดใช้งาน']);
            } else {
            ?>
              <div class="text-secondary pt-7px">หมดเขตแล้ว</div>
            <?php
            }
            ?>
          </div>
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
                'value' => 'short_term ',
                'name' => 'Short term 7 วัน',
              ],
              [
                'value' => 'long_term',
                'name' => 'Long term 30 วัน',
              ],
            ],
          ];
          // TiwForm::normal('select', $edit_data['event_type'], ['name' => 'event_type', 'disabled' => 'true'], $style_event_options);
          if ($edit_data['event_type'] == 'short_term') {
            echo $event_type = 'Short term 7 วัน';
          } else {
            echo $event_type = 'Long term 30 วัน';
          }
          ?>
        </div>
      </div>
    </div>
    <?php if ($edit_data['event_type'] == 'short_term') { ?>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-3">
            <label class="font-15px font-SemiBold">
              วัน - เวลาที่เริ่ม
            </label>
          </div>
          <div class="col-md-4">
            <div class="d-flex">
              <?php
              // TiwForm::normal('datetime', $edit_data['from_date_time'], ['name' => 'start_date_event', 'disabled' => 'true'], []);
              echo Aww::formatDate($edit_data['from_date_time'], 'd/m/Y H:i');
              ?>
            </div>
          </div>
          <div class="col-md-5 d-flex align-items-center">
            <span class="text-danger">ไม่สามารถเลือกวันที่ซ้ำกับวันที่มีกิจกรรมอยู่แล้ว</span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-3">
            <label class="font-15px font-SemiBold">
              วัน - เวลาที่สิ้นสุด
            </label>
          </div>
          <div class="col-md-4">
            <div class="d-flex">
              <?php
              // TiwForm::normal('datetime', $edit_data['to_date_time'], ['name' => 'end_date_event', 'disabled' => 'true'], []);
              echo Aww::formatDate($edit_data['to_date_time'], 'd/m/Y H:i');
              ?>
            </div>
          </div>
          <div class="col-md-5 d-flex align-items-center">
            <span class="text-danger">ช่วงเวลาที่เลือกจะต้องมากกว่า 7 วัน</span>
          </div>
        </div>
      </div>
    <?php } else { ?>
      <div class="form-group">
        <div class="form-row">
          <div class="col-md-3">
            <label class="font-15px font-SemiBold">
              เดือนที่เปิดกิจกรรม
            </label>
          </div>
          <div class="col-md-4">
            <div class="d-flex">
              <?php
              // $year_data = Aww::formatDate($edit_data['from_date_time'], 'Y-m');
              // TiwForm::normal('month', $year_data, ['name' => 'month_open_event', 'class' => 'event_type_month', 'readonly' => 'true'], []);
              $year_data = Aww::formatDate($edit_data['from_date_time'], 'Y');
              $month_data = Aww::formatDate($edit_data['from_date_time'], 'm');
              $month = Aww::formatMonthNameTH($month_data);
              $year = $year_data + 543;
              echo $full_date = $month . ', ' . $year;
              ?>
            </div>
          </div>
          <div class="col-md-5 d-flex align-items-center">
            <span class="text-danger">ไม่สามารถเลือกเดือนที่มีกิจกรรมอยู่แล้ว</span>
          </div>
        </div>
      </div>
    <?php } ?>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ช่วงเวลากิจกรรม</label>
        </div>
        <div class="col-md-4 pt-7px">
          <span class="text-primary event_total_date">
            <?= Aww::formatDate($edit_data['from_date_time'], 'd/m/Y, H:i'); ?> - <?= Aww::formatDate($edit_data['to_date_time'], 'd/m/Y, H:i'); ?>
          </span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">จำนวนยอดฝากต่อวัน (บาท)</label>
        </div>
        <div class="col-md-4">
          <?= TiwForm::normal('number', $edit_data['deposit_amount'], ['name' => 'deposit_amount', 'class' => 'mb-0', 'placeholder' => 'กรอก'], ['is_edit' => false]); ?>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-md-3 pt-7px">
          <label class="font-15px font-SemiBold">ฝากครบ <span><?= $data = ($edit_data['event_type'] == 'short_term') ? '7' : '30'; ?></span> วัน แจกเครดิต (บาท)</label>
        </div>
        <div class="col-md-4">
          <?= TiwForm::normal('number', $edit_data['credit_receive'], ['name' => 'credit_receive', 'class' => 'mb-0', 'placeholder' => 'กรอก'], ['is_edit' => false]); ?>
        </div>
        <div class="col-2 pt-7px">
          <label class="font-15px font-SemiBold">ติดเทิร์น</label>
        </div>
        <div class="col-2 d-flex">
          <?= TiwForm::normal('number', $edit_data['cal_turn_over_percent'], ['name' => 'cal_turn_over_percent', 'class' => 'mb-0', 'placeholder' => 'กรอก'], ['is_edit' => false]); ?>
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
          <?= TiwForm::normal('textarea', $edit_data['detail'], ['name' => 'detail', 'class' => 'mb-0 min-h-100px', 'placeholder' => 'กรอก'], ['is_edit' => false]); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
    <button type="button" class="btn btn-close-modal w-100px h-40px" data-dismiss="modal">ยกเลิก</button>
    <?php
    if ($edit_data['status'] != 'expire') {
    ?>
      <button type="submit" class="btn btn-primary w-120px h-40px" name="submit_edit_data">บันทึก</button>
    <?php } ?>
  </div>
</form>