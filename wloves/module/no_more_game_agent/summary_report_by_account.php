<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'summary_report_by_account'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
if (isset($_GET['submit_clear_summary'])) {
  $date_data = Aww::formatDate('', 'Y-m-d');
} else {
  $date_data = isset($_GET['date_data']) ? $_GET['date_data'] : Aww::formatDate('', 'Y-m-d');
}
$data_account_report =  nga_statistic::getSummaryTransactionByBot($code);

$deposit_data = nga_statistic::selectSummaryDepositByBot($code, $date_data);
$withdraw_data =  nga_statistic::selectSummaryWithdrawByBot($code, $date_data);
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
  <div class="bg-w pb-15px mb-10px">
    <div class='pb-15px'>
      <div class="pt-10px px-15px">
        <div class="d-flex align-items-center">
          <div class="cursor-pointer">
            <div class="icon_up_summary">
              <?= file_get_contents('./assets/icon/icon-up-blue.svg') ?>
            </div>
            <div class="icon_down_summary" style="display:none;">
              <?= file_get_contents('./assets/icon/icon-down-hide.svg') ?>
            </div>
          </div>
          <div class="ml-10px">
            <div class="font-18px font-Bold text-header ">รายงานสรุปยอดฝาก / ถอน แยกตามบัญชี</div>
            <div class="font-14px text-sub ">
              สรุปยอดฝาก / ถอน แยกตามบัญชีภายในระบบ, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row px-15px summary_event">
      <div class="col-lg-6">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header ">
            บัญชีที่มียอดฝากสูงสุดประจำวัน
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6  my-auto">
                  <div class=" font-24px font-Bold text-header"><?= $data_account_report['today_maximum_deposit']['bank_account_name'] ?></div>
                </div>
                <div class="col-6 border-left">
                  <div> <span class="font-30px font-Bold text-primary"><?= number_format($data_account_report['today_maximum_deposit']['sum_amount'], 2) ?></span> <span class="font-15px font-Medium">บาท</span> </div>
                </div>
                <div class="col-6">
                  <div class="font-15px"><span class="font-Medium">ธนาคาร:</span> <span class="font-Bold text-header"><?= $data_account_report['today_maximum_deposit']['bank_name_th'] ?><span></div>
                </div>
                <div class="col-6">
                  <div>จากการทำรายการ <span class="text-primary font-Bold"><?= number_format($data_account_report['today_maximum_deposit']['count_list']) ?></span> รายการ</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            บัญชีที่มียอดถอนสูงสุดประจำวัน
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6  my-auto">
                  <div class=" font-24px font-Bold text-header"><?= $data_account_report['today_maximum_withdraw']['bank_account_name'] ?></div>
                </div>
                <div class="col-6 border-left">
                  <div> <span class="font-30px font-Bold text-danger"><?= number_format($data_account_report['today_maximum_withdraw']['sum_amount'], 2) ?></span> <span class="font-15px font-Medium">บาท</span> </div>
                </div>
                <div class="col-6">
                  <div class="font-15px"><span class="font-Medium">ธนาคาร:</span> <span class="font-Bold text-header"><?= $data_account_report['today_maximum_withdraw']['bank_name_th'] ?><span></div>
                </div>
                <div class="col-6">
                  <div>จากการทำรายการ <span class="text-primary font-Bold"><?= number_format($data_account_report['today_maximum_withdraw']['count_list']) ?></span> รายการ</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header ">
            บัญชีที่มียอดฝากสะสมสูงสุด
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6  my-auto">
                  <div class=" font-24px font-Bold text-header"><?= $data_account_report['sum_maximum_deposit']['bank_account_name'] ?></div>
                </div>
                <div class="col-6 border-left">
                  <div><span class="font-30px font-Bold text-primary"><?= number_format($data_account_report['sum_maximum_deposit']['sum_amount'], 2) ?></span> <span class="font-15px font-Medium">บาท</span> </div>
                </div>
                <div class="col-6">
                  <div class="font-15px"><span class="font-Medium">ธนาคาร:</span> <span class="font-Bold text-header"><?= $data_account_report['sum_maximum_deposit']['bank_name_th'] ?><span></div>
                </div>
                <div class="col-6">
                  <div>จากการทำรายการ <span class="text-primary font-Bold"><?= number_format($data_account_report['sum_maximum_deposit']['count_list']) ?></span> รายการ</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            บัญชีที่โยกเงินออกสะสมมากที่สุด
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6  my-auto">
                  <div class=" font-24px font-Bold text-header"><?= $data_account_report['sum_maximum_withdraw']['bank_account_name'] ?></div>
                </div>
                <div class="col-6 border-left">
                  <div> <span class="font-30px font-Bold text-danger"><?= number_format($data_account_report['sum_maximum_withdraw']['sum_amount'], 2) ?></span> <span class="font-15px font-Medium ">บาท</span> </div>
                </div>
                <div class="col-6 ">
                  <div class="font-15px"><span class="font-Medium">ธนาคาร:</span> <span class="font-Bold text-header"><?= $data_account_report['sum_maximum_withdraw']['bank_name_th'] ?><span></div>
                </div>
                <div class="col-6">
                  <div>จากการทำรายการ <span class="text-primary font-Bold"><?= number_format($data_account_report['sum_maximum_withdraw']['count_list']) ?></span> รายการ</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
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
        <div class="font-16px font-Bold text-header">ตัวกรองผลข้อมูล</div>
      </div>
    </div>
    <div class="date_filter capsule_sky font-14px font-Medium ml-45px w-100px" style="display: none;">
      <?= Aww::formatDate($date_data, 'd/m/Y'); ?>
      <?php /* 
      <span class="cursor-pointer ml-10px"><?= file_get_contents('assets/icon/icon-close-red.svg') ?></span>
      */ ?>
    </div>
    <form method="GET">
      <div class="row filter_event">
        <div class="col-sm-2">
          <div class="mt-7px">แสดงผลตามวันที่</div>
        </div>
        <div class="col-sm-10">
          <div class="row">
            <div class="col-12">
              <div class="d-flex">
                <div>
                  <?= TiwForm::normal('date', $date_data, ['name' => 'date_data', 'class' => 'w-200px']) ?>
                </div>
              </div>
            </div>
            <div class="col-12 mt-10px">
              <div class="d-flex">
                <button type="submit" name="submit_search_summary" class="btn btn-warning mr-5px w-100px">ค้นหา</button>
                <button type="submit" name="submit_clear_summary" class="btn btn-close-modal w-70px">ล้าง</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="c" value="<?= $code ?>">
    </form>
  </div>
  <div class="table-responsive filter_event">
    <table class="table table-none-custom border-table">
      <?php
      $count_deposit = 0;
      if ($deposit_data) {
        $count_deposit = count($deposit_data) - 1;
      } ?>
      <thead>
        <tr>
          <td colspan="9">บัญชีฝาก <?= number_format($count_deposit); ?> บัญชี</td>
        </tr>
        <tr>
          <th class="thin-cell" nowrap>บัญชีฝาก</th>
          <th class="thin-cell text-right" nowrap>รอบ 06:00 น.</th>
          <th class="thin-cell text-right" nowrap>รอบ 12:00 น.</th>
          <th class="thin-cell text-right" nowrap>ยอดรวม 06:00 น - 12:00 น.</th>
          <th class="thin-cell text-right" nowrap>รอบ 18:00 น.</th>
          <th class="thin-cell text-right" nowrap>รอบ 24:00 น.</th>
          <th class="thin-cell text-right" nowrap>ยอดรวม 18:00 น - 24:00 น.</th>
          <th class="thin-cell text-right" nowrap>ยอดฝากรวม</th>
          <th class="thin-cell text-right" nowrap>จำนวนครั้งการฝากรวม</th>
        </tr>
      </thead>
      <tbody class="">
        <?php
        foreach ($deposit_data as $deposit_list) {
          if ($deposit_list['bank_account_name'] == 'ยอดฝากรวม') {
        ?>
            <tr>
              <td nowrap class="text-white text-right bg-blue-1 "><?= $deposit_list['bank_account_name']; ?></td>
              <td nowrap class="text-right bg-blue-2"><?= number_format($deposit_list['6:00'], 2); ?></td>
              <td nowrap class="text-right bg-blue-2"><?= number_format($deposit_list['12:00'], 2); ?></td>
              <td nowrap class="text-right bg-blue-2"><?= number_format($deposit_list['sum_6:00_12:00'], 2); ?></td>
              <td nowrap class="text-right bg-blue-2"><?= number_format($deposit_list['18:00'], 2); ?></td>
              <td nowrap class="text-right bg-blue-2"><?= number_format($deposit_list['23:59'], 2); ?></td>
              <td nowrap class="text-right bg-blue-2"><?= number_format($deposit_list['sum_18:00_23:59'], 2); ?></td>
              <td nowrap class="text-right bg-blue-2"><?= number_format($deposit_list['sum'], 2); ?></td>
              <td nowrap class="text-right bg-blue-2"><?= number_format($deposit_list['count'], 0); ?></td>
            </tr>
          <?php } else { ?>
            <tr>
              <td nowrap class="">
                <img src="<?= $deposit_list['bank_image']  ?>" alt="" class=" w-30px h-30px rounded-circle ">
                <span class="ml-5px"><?= $deposit_list['bank_account_name']; ?></span>
              </td>
              <td nowrap class="text-right"><?= number_format($deposit_list['6:00'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($deposit_list['12:00'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($deposit_list['sum_6:00_12:00'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($deposit_list['18:00'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($deposit_list['23:59'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($deposit_list['sum_18:00_23:59'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($deposit_list['sum'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($deposit_list['count'], 0); ?></td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>
  </div>
  <div class="table-responsive filter_event">
    <table class="table table-none-custom border-table">
      <?php
      $count_withdraw = 0;
      if ($deposit_data) {
        $count_withdraw = count($withdraw_data) - 1;
      } ?>
      <thead>
        <tr>
          <td colspan="5">บัญชีถอน <?= number_format($count_withdraw); ?> บัญชี</td>
        </tr>
        <tr>
          <th class="thin-cell" nowrap>บัญชีถอน</th>
          <th class="thin-cell text-right" nowrap>รอบ 12:00 น.</th>
          <th class="thin-cell text-right" nowrap>รอบ 24:00 น.</th>
          <th class="thin-cell text-right" nowrap>รวมยอดถอน</th>
          <th class="thin-cell text-right" nowrap>จำนวนครั้งการถอนรวม</th>
        </tr>
      </thead>
      <tbody class="">
        <?php foreach ($withdraw_data as $withdraw_list) {
          if ($withdraw_list['bank_account_name'] == 'ยอดถอนรวม') {
        ?>
            <tr>
              <td nowrap class="text-white text-right bg-danger"><?= $withdraw_list['bank_account_name']; ?></td>
              <td nowrap class="text-right bg-danger-2"><?= number_format($withdraw_list['12:00'], 2); ?></td>
              <td nowrap class="text-right bg-danger-2"><?= number_format($withdraw_list['23:59'], 2); ?></td>
              <td nowrap class="text-right bg-danger-2"><?= number_format($withdraw_list['sum'], 2); ?></td>
              <td nowrap class="text-right bg-danger-2"><?= number_format($withdraw_list['count'], 0); ?></td>
            </tr>
          <?php } else { ?>
            <tr>
              <td nowrap class="">
                <img src="<?= $withdraw_list['bank_image']  ?>" alt="" class=" w-30px h-30px rounded-circle ">
                <span class="ml-5px"><?= $withdraw_list['bank_account_name']; ?></span>
              </td>
              <td nowrap class="text-right"><?= number_format($withdraw_list['12:00'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($withdraw_list['23:59'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($withdraw_list['sum'], 2); ?></td>
              <td nowrap class="text-right"><?= number_format($withdraw_list['count'], 0); ?></td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>


</body>
<?php Aww::loadAsset('assets/js/force_logout.js'); ?>
<script>
  $(document).ready(function() {
    $(document).on('click', '.icon_up_summary', function() {
      $('.summary_event').hide();
      $('.icon_up_summary').hide();
      $('.icon_down_summary').show();
    });

    $(document).on('click', '.icon_down_summary', function() {
      $('.summary_event').show();
      $('.icon_down_summary').hide();
      $('.icon_up_summary').show();
    });

    $(document).on('click', '.icon_up_filter', function() {
      $('.filter_event').hide();
      $('.icon_up_filter').hide();
      $('.icon_down_filter').show();
      $('.date_filter').show();
    });

    $(document).on('click', '.icon_down_filter', function() {
      $('.filter_event').show();
      $('.icon_up_filter').show();
      $('.icon_down_filter').hide();
      $('.date_filter').hide();
    });
  });
</script>



</html>