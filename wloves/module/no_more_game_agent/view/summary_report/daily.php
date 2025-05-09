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
      </div>
      <input type="hidden" name="c" value="<?= $code ?>">
      <input type="hidden" name="page" value="<?= $page ?>">
    </form>
  </div>
  <div class="table-responsive">
    <table class="table table-striped-2">
      <thead>
        <tr>
          <th class="thin-cell" nowrap>วันที่</th>
          <th class="thin-cell text-right" nowrap>จำนวนลูกค้าที่สมัคร</th>
          <th class="thin-cell text-right" nowrap>จำนวนลูกค้าที่ฝาก</th>
          <th class="thin-cell text-right" nowrap>จำนวนรายการฝาก</th>
          <th class="thin-cell text-right" nowrap>จำนวนรายการถอน</th>
          <th class="thin-cell text-right" nowrap>ยอดรวมฝาก</th>
          <th class="thin-cell text-right" nowrap>ยอดรวมถอน</th>
          <th class="thin-cell text-right" nowrap>ส่วนต่าง</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($select_summary_credit_transaction as $value) {
          if ($value['date'] == 'ยอดรวม') {
        ?>
            <tr>
              <td nowrap class="text-white font-SemiBold text-right bg-blue-1">ยอดรวม</td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['user_count']) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['user_count_deposit']) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['deposit_count']) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['withdraw_count']) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['deposit_sum'], 2) ?></td>
              <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['withdraw_sum'], 2) ?></td>
              <td nowrap class="text-right <?= ($value['dep_wit_difference'] <= 0) ? 'text-danger' : 'text-success' ?> bg-blue-2 font-SemiBold"><?= number_format($value['dep_wit_difference'], 2) ?></td>
            </tr>
          <?php } else { ?>
            <tr>
              <td nowrap class="font-SemiBold"><?= Aww::formatDate($value['date'], 'd/m/Y'); ?></td>
              <td nowrap class="text-right"><?= number_format($value['user_count']) ?></td>
              <td nowrap class="text-right"><?= number_format($value['user_count_deposit']) ?></td>
              <td nowrap class="text-right"><?= number_format($value['deposit_count']) ?></td>
              <td nowrap class="text-right"><?= number_format($value['withdraw_count']) ?></td>
              <td nowrap class="text-right"><?= number_format($value['deposit_sum'], 2) ?></td>
              <td nowrap class="text-right"><?= number_format($value['withdraw_sum'], 2) ?></td>
              <td nowrap class="text-right <?= ($value['dep_wit_difference'] <= 0) ? 'text-danger' : 'text-success' ?>"><?= number_format($value['dep_wit_difference'], 2) ?></td>
            </tr>
        <?php
          }
        }
        ?>
      </tbody>
    </table>
  </div>