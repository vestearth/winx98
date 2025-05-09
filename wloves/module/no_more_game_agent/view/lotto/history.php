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
        <th class="thin-cell text-right" nowrap>ประเภทหวย </th>
        <th class="thin-cell text-right" nowrap>ยอดแทง</th>
        <th class="thin-cell text-right" nowrap>ยอดได้</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $key_type = [
        'thailotto' => 'หวยไทย',
        'laolotto' => 'หวยลาว',
        'hanoylotto' => 'หวยฮานอย',
        'hanoylottovip' => 'หวยฮานอย(วีไอพี)',
        'baaclotto' => 'หวย ธกส.',
        'gsblotto' => 'ออมสิน',
        'pingponglotto' => 'หวยปิงปอง',
        'laoslotto_set' => 'หวยลาว(แบบชุด)',
        'yeekeelotto' => 'หวยยี่กี',
        'malaylotto' => 'หวยมาเลย์',
        'hanoylotto_set' => 'หวยฮานอย(แบบชุด)',
        'hanoylottovip_set' => 'หวยฮานอยวีไอพี(แบบชุด)',
        'hanoylottospecial_set' => 'หวยฮานอยพิเศษ(แบบชุด)',
        'malaylotto_set' => 'หวยมาเลย์(แบบชุด)',
        'hanoylottospecial' => 'หวยฮานอย(พิเศษ)',
        'stockkorea' => 'หวยหุ้นเกาหลี',
        'stockchina' => 'หวยหุ้นจีน',
        'stockdowjones' => 'หวยหุ้นดาวโจนส์',
        'stocktaiwan' => 'หวยหุ้นไต้หวัน',
        'stockengland' => 'หวยหุ้นอังกฤษ',
        'stockindia' => 'หวยหุ้นอินเดีย',
        'stockhangseng' => 'หวยหุ้นฮั่งเส็ง',
        'stockegypt' => 'หวยหุ้นอียิปต์',
        'stocknikkei' => 'หวยหุ้นนิเคอิ',
        'stocksingapore' => 'หวยหุ้นสิงค์โปร',
        'stockthai' => '	หวยหุ้นไทย',
        'stockgerman' => 'หวยหุ้นเยอรมัน',
        'stockrussia' => 'หวยหุ้นรัสเซีย',
        'stock' => 'รวบหวยหุ้น(ใช้ประเภทนี้ในการตั้งค่าเท่านั้น)',
      ];
      // Aww::display($select_summary_lotto);
      foreach ($select_summary_lotto as $value) {
        if ($value['bet_date'] == 'ยอดรวม') {
          $payout_amount = $value['payout_amount'];

      ?>
          <tr>
            <td nowrap class="text-white font-SemiBold text-right bg-blue-1 text-center">ยอดรวม</td>
            <td nowrap class="text-right bg-blue-2 font-SemiBold"></td>
            <td nowrap class="text-right bg-blue-2 font-SemiBold"><?= number_format($value['bet_amount'], 2) ?></td>
            <td nowrap class="text-right <?= ($payout_amount <= 0) ? 'text-danger' : 'text-success' ?>  bg-blue-2 font-SemiBold"><?= number_format($payout_amount, 2) ?></td>
          </tr>
        <?php } else {
          $payout_amount = $value['payout_amount'];
          $lotto_type = $key_type[$value['lotto_type']];
        ?>
          <tr>
            <td nowrap class="font-SemiBold"><?= Aww::formatDate($value['bet_date'], 'd/m/Y'); ?></td>
            <td nowrap class="text-right"><?= $lotto_type; ?></td>
            <td nowrap class="text-right font-SemiBold"><?= number_format($value['bet_amount'], 2) ?></td>
            <td nowrap class="text-right <?= ($payout_amount <= 0) ? 'text-danger' : 'text-success' ?>  font-SemiBold"><?= number_format($payout_amount, 2) ?></td>
          </tr>
      <?php
        }
      }
      ?>
    </tbody>
  </table>
</div>