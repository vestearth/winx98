<?php
Aww::console($select_summary_provider);
?>

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
        <th class="thin-cell text-right" nowrap>ค่ายเกม</th>
        <th class="thin-cell text-right" nowrap>จำนวนเกม</th>
        <th class="thin-cell text-right" nowrap>จำนวนผู้เล่นทั้งหมด</th>
        <th class="thin-cell text-right" nowrap>Win (บาท)</th>
        <th class="thin-cell text-right" nowrap>Loss (บาท)</th>
        <th class="thin-cell text-right" nowrap>ส่วนต่าง W/L</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($select_summary_provider as $value) {
        if ($value['transaction_date'] == 'ยอดรวม') {
          $total_difference = $value['sum_lose'] - $value['sum_win'];

      ?>
          <tr>
            <td nowrap class="text-white font-SemiBold text-right bg-blue-1 text-center">ยอดรวม</td>
            <td nowrap class="text-right bg-blue-2 font-SemiBold"></td>
            <td nowrap class="text-right bg-blue-2 font-SemiBold"></td>
            <td nowrap class="text-right bg-blue-2 font-SemiBold"></td>
            <td nowrap class="text-right bg-blue-2 font-SemiBold text-success"><?= number_format($value['sum_win'], 2) ?></td>
            <td nowrap class="text-right bg-blue-2 font-SemiBold text-danger"><?= number_format($value['sum_lose'], 2) ?></td>
            <td nowrap class="text-right <?= ($total_difference <= 0) ? 'text-danger' : 'text-success' ?>  bg-blue-2 font-SemiBold"><?= number_format($total_difference, 2) ?></td>
          </tr>
        <?php } else {
          $difference = $value['sum_lose'] - $value['sum_win'];

        ?>
          <tr>
            <td nowrap class="font-SemiBold"><?= Aww::formatDate($value['transaction_date'], 'd/m/Y'); ?></td>
            <td nowrap class="text-right"><?= $value['product_id']; ?></td>
            <td nowrap class="text-right font-SemiBold"><?= number_format($value['count_game']) ?></td>
            <td nowrap class="text-right font-SemiBold"><?= number_format($value['count_user']) ?></td>
            <td nowrap class="text-right font-SemiBold text-success"><?= number_format($value['sum_win'], 2) ?></td>
            <td nowrap class="text-right font-SemiBold text-danger"><?= number_format($value['sum_lose'], 2) ?></td>
            <td nowrap class="text-right <?= ($difference <= 0) ? 'text-danger' : 'text-success' ?>  font-SemiBold"><?= number_format($difference, 2) ?></td>
          </tr>
      <?php
        }
      }
      ?>
    </tbody>
  </table>
</div>