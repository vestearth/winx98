<?php Tiwdal::startModal('modal_turnover', 'modal-xl'); ?>
<div class="modal-header">
  <h5 class="font-16px font-SemiBold">การคืนยอด Turnover / ยอดเสีย</h5>
</div>
<form method="post">
  <div class="modal-body">
    <div class="col-lg-12 d-flex p-0 flex-wrap align-items-center">
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          ประเภทการคืนยอด
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex">
        <div>
          ยอดเสีย (Turnover)
        </div>
      </div>
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          ยอดคืนสูงสุด
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex">
        <div>
          <?php
          TiwForm::normal('text', $turn_over['maximum_turn_over'], ['name' => 'maximum_turn_over', 'class' => 'min-w-270px mb-0']);
          ?>
        </div>
      </div>
    </div>
    <div class="col-lg-12 d-flex p-0 flex-wrap align-items-center mt-15px">
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          ยอดคืนต่ำสุด
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex">
        <div>
          <?php
          TiwForm::normal('text', $turn_over['minimum_turn_over'], ['name' => 'minimum_turn_over', 'class' => 'min-w-270px mb-0']); ?>
        </div>
      </div>
      <div class="col-lg-2 font-14px font-Medium p-0">
        <div class=" py-5px">
          เปิดการคืนยอดเสีย
        </div>
      </div>
      <div class="col-lg-4 font-14px font-Medium p-0 d-flex align-items-center">
        <div>
          <?php
          $checked = ($turn_over['is_active'] == 1) ? 'checked' : '';
          ?>
          <?= TiwForm::normal('checkbox', '1', ['name' => 'is_active', 'checked' => $checked], ['style' => '1', 'is_on_off' => true]); ?>
        </div>
        <div class=" ml-10px text-primary font-16px">
          เปิดใช้งาน
        </div>
      </div>
    </div>
    <hr>
    <div class="col-lg-12 p-0">
      <i class=" font-14px text-dark">ประเภทเกม</i>
    </div>
    <div class="col-lg-12 d-flex p-0 flex-wrap mt-15px">
      <?php foreach ($list_games as $key => $game) {
      ?>
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
                  $checked = ($turn_over[$game['is_open']] == 1) ? 'checked' : '';
                  TiwForm::normal('checkbox', 1, ['name' => $game['is_open'], 'checked' => $checked], ['style' => '1', 'is_on_off' => true]);
                  ?>
                </div>
                <div class=" ml-10px text-primary font-16px">
                  เปิดใช้งาน
                </div>
              </div>
              <div class=" d-flex align-items-center">
                <div class=" mr-20px max-w-160px">
                  คอมมิชชั่น % (turnover)
                </div>
                <div>
                  <?= TiwForm::normal('text', $turn_over[$game['commission']], ['name' => $game['commission'], 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px'], []); ?>
                </div>
              </div>
              <div class=" d-flex align-items-center">
                <div class=" mr-3px max-w-160px">
                  คอมมิชชั่น % (turnover)
                  แสดงหน้าผู้เล่น
                </div>
                <div>
                  <?= TiwForm::normal('text', $turn_over[$game['commission_player']], ['name' =>  $game['commission_player'], 'oninput' => 'limitDecimalPlaces(event, 2)', 'class' => 'max-w-50px'], []); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_update_turnover', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>