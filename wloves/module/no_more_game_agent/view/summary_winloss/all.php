<div class="bg-w px-15px py-10px ">
  <div class="d-flex align-items-center">
    <div class="cursor-pointer">
      <div class="icon_up_filter">
        <?= file_get_contents('./assets/icon/icon-up-blue.svg') ?>
      </div>
      <div class="icon_down_filter" style="display:none;">
        <?= file_get_contents('./assets/icon/icon-down-hide.svg') ?>
      </div>
    </div>
    <div class="ml-10px">
      <div class="font-16px font-Bold text-header ">ตัวกรองผลข้อมูล</div>
    </div>
  </div>
  <div class="date_filter capsule_sky font-14px font-Medium ml-45px w-207px" style="display: none;"><?= Aww::formatDate($from_date, 'd/m/Y') . ' - ' . Aww::formatDate($to_date, 'd/m/Y'); ?>
    <span class="cursor-pointer ml-10px evnet_clear_search"><?= file_get_contents('assets/icon/icon-close-red.svg') ?></span>
  </div>
  <form method="get" action="?c=<?= $code ?>">
    <div class="row filter_event">
      <div class="col-sm-2">
        <div class="mt-7px">แสดงผลตามวันที่</div>
      </div>
      <div class="col-sm-10">
        <div class="row">
          <div class="col-12">
            <div class="d-flex">
              <div>
                <?= TiwForm::normal('date', $from_date, ['name' => 'from_date', 'class' => 'w-200px']) ?>
                <div class="font-14px text-mute"><i>วันที่เริ่มต้น</i></div>
              </div>
              <div class="mx-10px mt-5px">-</div>
              <div>
                <?= TiwForm::normal('date', $to_date, ['name' => 'to_date', 'class' => 'w-200px']) ?>
                <div class="font-14px text-mute"><i>วันที่สิ้นสุด</i></div>
              </div>
            </div>
          </div>
          <div class="col-12 mt-10px">
            <div class="d-flex">
              <button type="submit" name="submit_search_summary" class="btn btn-warning mr-5px w-100px">ค้นหา</button>
              <button type="submit" name="submit_clear_summary" class="btn btn-close-modal w-70px scope_btn_clear_search">ล้าง</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-2 mt-10px">
        <div class="font-SemiBold">วิธีการคำนวณ</div>
      </div>
      <div class="col-10 mt-10px">
        <p class="mb-0">ส่วนต่าง = รวมยอดฝาก - รวมยอดถอน</p>
        <p class="mb-0">กำไรของระบบ = ยอดแพ้ชนะ - คืนยอดเสีย - เปิดไพ่ - สล็อตเสี่ยงโชค - โปรโมชั่น - ชวนเพื่อน</p>
      </div>
    </div>
    <input type="hidden" name="c" value="<?= $code ?>">
    <input type="hidden" name="page" value="<?= $page ?>">
  </form>
</div>
<div class="bg-w">
  <div class="table-responsive">
    <table class="table table-striped-2">
      <thead>
        <tr>
          <th class="thin-cell" nowrap>วันที่</th>
          <th class="thin-cell text-right" nowrap>รวมยอดฝาก</th>
          <th class="thin-cell text-right" nowrap>รวมยอดถอน</th>
          <th class="thin-cell text-right" nowrap>ส่วนต่าง</th>
          <th class="thin-cell text-right" nowrap>คืนยอดเสีย (กดรับแล้ว)</th>
          <th class="thin-cell text-right" nowrap>เปิดไพ่</th>
          <th class="thin-cell text-right" nowrap>สล็อตเสี่ยงโชค</th>
          <th class="thin-cell text-right" nowrap>โปรโมชั่น (กดรับแล้ว) </th>
          <th class="thin-cell text-right" nowrap>ชวนเพื่อน (กดรับแล้ว) </th>
          <th class="thin-cell text-right" nowrap>ยอดแพ้-ชนะ (ถ้าเป็นบวกระบบได้)</th>
          <th class="thin-cell text-right" nowrap>กำไรของระบบ</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($select_summary_credit_transaction as $value) {
          if ($value['date'] == 'ยอดรวม') {
            $sum_web_received = isset($value['sum_web_received']) ? $value['sum_web_received'] : 0;
            $money_can_transfer = isset($value['money_can_transfer']) ? $value['money_can_transfer'] : 0;

            if ($value['sum_user_diff_deposit_withdraw'] < 0) {
              $sum_user_diff_colour = 'text-danger';
            } else if ($value['sum_user_diff_deposit_withdraw'] == 0) {
              $sum_user_diff_colour = 'text-info';
            } else {
              $sum_user_diff_colour = 'text-success';
            }

            if ($sum_web_received < 0) {
              $sum_web_colour = 'text-danger';
            } else if ($sum_web_received == 0) {
              $sum_web_colour = 'text-info';
            } else {
              $sum_web_colour = 'text-success';
            }

            if ($value['sum_user_bet_payout'] < 0) {
              $sum_user_colour = 'text-danger';
            } else if ($value['sum_user_bet_payout'] == 0) {
              $sum_user_colour = 'text-info';
            } else {
              $sum_user_colour = 'text-success';
            }

            if ($money_can_transfer < 0) {
              $money_transfer_colour = 'text-danger';
            } else if ($money_can_transfer == 0) {
              $money_transfer_colour = 'text-info';
            } else {
              $money_transfer_colour = 'text-success';
            }
        ?>
            <tr>
              <td nowrap class="text-white font-SemiBold text-right bg-blue-1">ยอดรวม</td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['sum_user_deposit'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['sum_user_withdraw'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold <?= $sum_user_diff_colour; ?> "><?= number_format($value['sum_user_diff_deposit_withdraw'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['sum_user_turn_over_receive'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['sum_user_receive_from_play_card'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['sum_user_receive_from_play_slot'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['sum_user_receive_promotion'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['sum_user_receive_from_invite_friend'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold <?= $sum_user_colour; ?> bg-blue-2 font-SemiBold"><?= number_format($value['sum_user_bet_payout'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold <?= $sum_web_colour; ?>"><?= number_format($sum_web_received, 2) ?></td>
            </tr>
          <?php } else {
            $sum_web_received = isset($value['sum_web_received']) ? $value['sum_web_received'] : 0;
            $money_can_transfer = isset($value['money_can_transfer']) ? $value['money_can_transfer'] : 0;

            if ($value['sum_user_diff_deposit_withdraw'] < 0) {
              $sum_user_diff_colour = 'text-danger';
            } else if ($value['sum_user_diff_deposit_withdraw'] == 0) {
              $sum_user_diff_colour = 'text-info';
            } else {
              $sum_user_diff_colour = 'text-success';
            }

            if ($sum_web_received < 0) {
              $sum_web_colour = 'text-danger';
            } else if ($sum_web_received == 0) {
              $sum_web_colour = 'text-info';
            } else {
              $sum_web_colour = 'text-success';
            }

            if ($value['sum_user_bet_payout'] < 0) {
              $sum_user_colour = 'text-danger';
            } else if ($value['sum_user_bet_payout'] == 0) {
              $sum_user_colour = 'text-info';
            } else {
              $sum_user_colour = 'text-success';
            }

            // money_transfer colour 
            if ($money_can_transfer < 0) {
              $money_transfer_colour = 'text-danger';
            } else if ($money_can_transfer == 0) {
              $money_transfer_colour = 'text-info';
            } else {
              $money_transfer_colour = 'text-success';
            }
          ?>
            <tr>
              <td nowrap class="font-SemiBold"><?= Aww::formatDate($value['date'], 'd/m/Y'); ?></td>
              <td nowrap class="text-right"><?= number_format($value['sum_user_deposit'], 2) ?></td>
              <td nowrap class="text-right"><?= number_format($value['sum_user_withdraw'], 2) ?></td>
              <td nowrap class="text-right <?= $sum_user_diff_colour; ?> "><?= number_format($value['sum_user_diff_deposit_withdraw'], 2) ?></td>
              <td nowrap class="text-right"><?= number_format($value['sum_user_turn_over_receive'], 2) ?></td>
              <td nowrap class="text-right"><?= number_format($value['sum_user_receive_from_play_card'], 2) ?></td>
              <td nowrap class="text-right"><?= number_format($value['sum_user_receive_from_play_slot'], 2) ?></td>
              <td nowrap class="text-right"><?= number_format($value['sum_user_receive_promotion'], 2) ?></td>
              <td nowrap class="text-right"><?= number_format($value['sum_user_receive_from_invite_friend'], 2) ?></td>
              <td nowrap class="text-right <?= $sum_user_colour; ?>"><?= number_format($value['sum_user_bet_payout'], 2) ?></td>
              <td nowrap class="text-right <?= $sum_web_colour; ?> "><?= number_format($sum_web_received, 2) ?></td>
            </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>
</div>