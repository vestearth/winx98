<?php Tiwdal::startModal('modal_monetization', 'modal-xl'); ?>
<form method="post">
  <div class="modal-header">
    <h5 class="font-16px font-SemiBold">การสร้างรายได้</h5>
  </div>
  <div class="modal-body">
    <div class="col-lg-12 d-flex p-0 flex-wrap align-items-center">
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          ประเภทการคืนยอด
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex">
        <div>
          ยอดเล่น
        </div>
      </div>
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          ยอดเงินที่คืนสูงสุดต่อยูส
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex">
        <div>
          <?php
          TiwForm::normal('number', $get_commission['maximum_refund_per_user'], ['name' => 'maximum_refund_per_user', 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'min-w-270px mb-0']); ?>
        </div>
      </div>
    </div>
    <div class="col-lg-12 d-flex p-0 flex-wrap align-items-center mt-15px">
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          ยอดเงินที่คืนสูงสุด / วัน
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex align-items-center">
        <div>
          <?php
          TiwForm::normal('number', $get_commission['maximum_refund_per_day'], ['name' => 'maximum_refund_per_day', 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'min-w-270px mb-0']); ?>
        </div>
      </div>
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          เปิดสร้างรายได้
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex">
        <div>
          <?php
          $checked = ($get_commission['is_active'] == 1) ? 'checked' : '';
          TiwForm::normal('checkbox', 1, ['name' => 'is_active', 'checked' => $checked, 'class' => 'event_switch_old'], ['style' => '1', 'is_on_off' => true]);
          ?>
        </div>
        <div class=" ml-10px text-primary font-16px">
          เปิดใช้งาน
        </div>
      </div>
    </div>
    <?php /*
    <div class="col-lg-12 d-flex p-0 flex-wrap align-items-center mt-15px">
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class="py-5px">
          คำอธิบาย <br>(แสดงในหน้าเว็บไซต์)
        </div>
      </div>
      <div class="col-lg-10 font-14px font-Medium p-0 d-flex mt-10px">
        <?php
        TiwForm::normal('textarea', $get_commission['description'], ['name' => 'description', 'class' => 'min-w-270px min-h-100px w-100 w-50 mb-0'], $options); ?>
      </div>
    </div>
    */ ?>
    <hr>
    <div class="col-lg-12 p-0">
      <i class=" font-14px text-dark">ประเภทเกม</i>
    </div>
    <div class="col-lg-12 d-flex p-0 flex-wrap mt-15px">
      <?php foreach ($list_games as $key => $game) { ?>
        <div class="col-lg-6 d-flex p-0 flex-wrap mt-20px">
          <div class="col-lg-4 p-0">
            <div class=" font-14px font-Medium">
              <?= $game['name'] ?>
            </div>
          </div>
          <div class="col-lg-8 p-0">
            <div class=" font-14px font-Medium d-flex flex-column">
              <div class="d-flex flex-row">
                <div>
                  <?php
                  $checked = ($get_commission[$game['is_open']] == 1) ? 'checked' : '';
                  TiwForm::normal('checkbox', 1, ['name' => $game['is_open'], 'checked' => $checked], ['style' => '1', 'is_on_off' => true]);
                  ?>
                </div>
                <div class=" ml-10px text-primary font-16px">
                  เปิดใช้งาน
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class=" mr-20px max-w-160px">
                  สายชั้นที่ 1 คอมมิชชั่น %
                </div>
                <div class="mr-25px">
                  <?= TiwForm::normal('text', $get_commission[$game['commission']], ['name' => $game['commission'], 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px'], []); ?>
                </div>
              </div>
              <div class="d-flex align-items-center justify-content-between">
                <div class=" mr-20px max-w-160px">
                  สายชั้นที่ 2 คอมมิชชั่น %
                </div>
                <div class="mr-25px">
                  <?= TiwForm::normal('text', $get_commission[$game['commission_lv2']], ['name' => $game['commission_lv2'], 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px'], []); ?>
                </div>
              </div>
              <div class=" d-flex align-items-center justify-content-between">
                <div class=" mr-3px max-w-160px">
                  คอมมิชชั่น %
                  แสดงหน้าผู้เล่น
                </div>
                <div class="mr-25px">
                  <?= TiwForm::normal('text', $get_commission[$game['commission_player']], ['name' =>  $game['commission_player'], 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px'], []); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <hr>
  <div class="modal-body">
    <div class="col-lg-12 d-flex p-0 flex-wrap align-items-center">
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          ประเภทการคืนยอด
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex">
        <div>
          ชนะ/แพ้
        </div>
      </div>
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          ยอดเงินที่คืนสูงสุดต่อยูส
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex">
        <div>
          <?php
          TiwForm::normal('number', $get_commission['maximum_refund_per_user_new'], ['name' => 'maximum_refund_per_user_new', 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'min-w-270px mb-0']); ?>
        </div>
      </div>
    </div>
    <div class="col-lg-12 d-flex p-0 flex-wrap align-items-center mt-15px">

      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          เปิดสร้างรายได้
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex">
        <div>
          <?php
          $checked = ($get_commission['is_active_new'] == 1) ? 'checked' : '';
          TiwForm::normal('checkbox', 1, ['name' => 'is_active_new', 'checked' => $checked, 'class' => 'event_switch_active'], ['style' => '1', 'is_on_off' => true]);
          ?>
        </div>
        <div class=" ml-10px text-primary font-16px">
          เปิดใช้งาน
        </div>
      </div>
    </div>
    <hr>
    <div class="col-lg-12 p-0">
      <i class=" font-14px text-dark">คอมมิชชั่นทุกประเภทเกม</i>
    </div>
    <div class="col-lg-12 d-flex p-0 flex-wrap mt-15px">
      <div class="col-lg-6 d-flex p-0 flex-wrap">
        <div class="col-lg-8 p-0">
          <div class=" font-14px font-Medium d-flex flex-column">
            <div class="d-flex align-items-center justify-content-between">
              <div class=" mr-20px max-w-160px">
                สายชั้นที่ 1 คอมมิชชั่น %
              </div>
              <div class="mr-25px">
                <?= TiwForm::normal('text', $get_commission['commission_new'], ['name' => 'commission_new', 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px'], []); ?>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <div class=" mr-20px max-w-160px">
                สายชั้นที่ 2 คอมมิชชั่น %
              </div>
              <div class="mr-25px">
                <?= TiwForm::normal('text', $get_commission['commission_new_lv2'], ['name' => 'commission_new_lv2', 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px'], []); ?>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
              <div class=" mr-20px max-w-160px">
                สายชั้นที่ 3 คอมมิชชั่น %
              </div>
              <div class="mr-25px">
                <?= TiwForm::normal('text', $get_commission['commission_new_lv3'], ['name' => 'commission_new_lv3', 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px'], []); ?>
              </div>
            </div>
            <div class=" d-flex align-items-center justify-content-between">
              <div class="mr-3px">
                คอมมิชชั่น %
                แสดงหน้าผู้เล่น
              </div>
              <div class="mr-25px">
                <?= TiwForm::normal('text', $get_commission['commission_new_player'], ['name' =>  'commission_new_player', 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px'], []); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_update_commission', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>


<script>
  $(document).ready(function() {
    $(document).on('click', '.event_switch_old input', function() {
      if ($(this).is(':checked')) {
        $('input[name="is_active"]').prop('checked', true);
        $('input[name="is_active_2"]').prop('checked', false);
      } else {
        $('input[name="is_active_2"]').prop('checked', true);
        $('input[name="is_active"]').prop('checked', false);
      }
    });
    $(document).on('click', '.event_switch_active input', function() {
      // $('.event_switch_active').click(function() {
      if ($(this).is(':checked')) {
        $('input[name="is_active_2"]').prop('checked', true);
        $('input[name="is_active"]').prop('checked', false);
      } else {
        $('input[name="is_active"]').prop('checked', true);
        $('input[name="is_active_2"]').prop('checked', false);
      }
    });
  });
</script>