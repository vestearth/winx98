<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'customer_summary_report'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$summary = nga_statistic::getSummaryCustomer($code);
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
            <div class="font-18px font-Bold ">รายงานสรุปผลแยกตามลูกค้า</div>
            <div class="font-14px text-sub ">
              สรุปผลแยกตามลูกค้าของคุณ, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row px-15px summary_event">
      <div class="col-lg-6">
        <div class="row  ">
          <div class="col-sm-6">
            <div class="border-round mb-10px">
              <div class=" font-Bold font-16px ">
                ลูกค้าทั้งหมด
              </div>
              <div class="row ">
                <div class="col-12">
                  <div class="row">
                    <div class="col-6  my-auto">
                      <div class=" "><span class="text-primary font-30px font-Bold"><?= number_format($summary['count_user_not_ban'], 0); ?></span> <span class="font-15px font-Medium">ราย</span> </div>
                    </div>
                    <div class="col-6 border-left">
                      <div class=" "><span class="text-danger font-30px font-Bold"><?= number_format($summary['count_user_is_ban'], 0); ?></span> <span class="font-15px font-Medium">ราย</span> </div>
                    </div>
                    <div class="col-6 ">
                      <div class="font-15px">ปกติ</div>
                    </div>
                    <div class="col-6">
                      <div>ระงับบัญชี</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="mb-10px border-round">
              <div class=" font-Bold font-16px ">
                ลูกค้าใหม่วันนี้
              </div>
              <div class=" font-Medium">
                <div class="font-15px">
                  <span class="font-30px font-Bold text-primary"><?= number_format($summary['count_new_user'], 0); ?> </span> ราย ฝากเงินทั้งหมด <span class="text-primary"><?= number_format($summary['count_new_user_deposit'], 0); ?></span> คน
                </div>
                <div class="font-15px">
                  <?php if ($summary['percent_compare_yesterday'] > 0) {
                    $text_status = 'text-success';
                    $status_text = 'เพิ่มขึ้น';
                    $icon = 'assets/icon/icon-percent-green.svg';
                  } else if ($summary['percent_compare_yesterday'] < 0) {
                    $text_status = 'text-danger';
                    $status_text = 'ลดลง';
                    $icon = 'assets/icon/icon-percent-red.svg';
                  } else {
                    $text_status = 'text-primary';
                    $status_text = '';
                  } ?>
                  <?= $status_text; ?> <span class="<?= $text_status; ?>"><?= number_format($summary['percent_compare_yesterday'], 2); ?>%
                    <?php if ($summary['percent_compare_yesterday'] != 0) { ?>
                      <?= file_get_contents($icon) ?></span>
                <?php } ?>
                จากเมื่อวาน
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row ">
          <div class="col-sm-12">
            <div class="mb-10px border-round">
              <div class=" font-Bold font-16px ">
                ยอดฝากคงค้างสะสมในระบบ
              </div>
              <div class=" font-Medium">
                <div class="font-15px">
                  <span class="font-30px font-Bold text-primary"><?= number_format($summary['sum_deposit'], 2); ?> </span> บาท
                </div>
                <div class="font-15px">
                  จากผู้เล่น <span class="text-primary"><?= number_format($summary['count_user_deposit'], 0); ?> </span> ราย
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row ">
          <div class="col-sm-12">
            <div class="border-round">
              <div class=" font-Bold font-16px ">
                ลูกค้าที่มีกำไรสะสมมากที่สุด
              </div>
              <div class="row">
                <div class="col-12">
                  <div class="row">
                    <div class="col-6  my-auto">
                      <div class=" font-24px font-Bold"><?= $summary['maximum_profit_bank_name']; ?></div>
                    </div>
                    <div class="col-6 border-left">
                      <div class="font-30px font-Bold "><span class="text-success"><?= number_format($summary['maximum_profit_amount'], 0); ?></span> <span class="font-15px font-Medium">บาท</span> </div>
                    </div>
                    <div class="col-6 ">
                      <div class="font-15px">รหัสลูกค้า: <?= $summary['maximum_profit_username']; ?></div>
                    </div>
                    <div class="col-6">
                      <div>ส่วนต่างระหว่างยอดฝาก / ถอน</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="border-round p-0">
          <div class="p-10px font-16px font-Bold">ตารางสรุปยอดฝากครั้งแรกของลูกค้า</div>
          <div class="table-responsive">
            <table class="table p-0 m-0 ">
              <thead>
                <tr class="bg-head-table-grey ">
                  <td>ยอดฝาก</td>
                  <td class="text-right">จำนวนลูกค้า</td>
                  <td class="text-right">ยอดรวม</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td nowrap class="font-SemiBold">0 - 49 บาท</td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_0_49']['user_count']); ?></td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_0_49']['sum_deposit'], 2); ?></td>
                </tr>
                <tr>
                  <td nowrap class="font-SemiBold">50 - 99 บาท</td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_50_99']['user_count']); ?></td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_50_99']['sum_deposit'], 2); ?></td>
                </tr>
                <tr>
                  <td nowrap class="font-SemiBold">100 - 199 บาท</td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_100_199']['user_count']); ?></td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_100_199']['sum_deposit'], 2); ?></td>
                </tr>
                <tr>
                  <td nowrap class="font-SemiBold">200 - 299 บาท</td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_200_299']['user_count']); ?></td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_200_299']['sum_deposit'], 2); ?></td>
                </tr>
                <tr>
                  <td nowrap class="font-SemiBold">มากกว่าหรือเท่ากับ 300 บาท</td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_300_up']['user_count']); ?></td>
                  <td nowrap class="text-right font-SemiBold"><?= number_format($summary['deposit_first_time_300_up']['sum_deposit'], 2); ?></td>
                </tr>
                <tr>
                  <td nowrap colspan="2" class="text-right align-middle">
                    <div class="font-16px font-Bold"> ยอดฝากครั้งแรกรวม</div>
                  </td>
                  <td nowrap class="align-middle text-right">
                    <div> <span class="text-primary font-20px font-Bold mr-10px "><?= number_format($summary['sum_deposit_first_time'], 2); ?></span> บาท</div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="customer_summary_report" class="container-pagination bg-w  no-border-radius" <?= Homepagify::createHomepagify('customer_summary_report', '?c=' . $code, '', 'รายการลูกค้า') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search  table-striped-2">
        <thead>
          <tr>
            <th class="" nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
            <th class="" nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อ - สกุล</th>
            <th class="thin-cell text-right" nowrap data-sort="first_time_deposit_date" data-filter="<?= Homepagify::dataFilter('first_time_deposit_date', 'date') ?>">วันที่ฝากครั้งแรก</th>
            <th class="thin-cell text-right" nowrap data-sort="first_time_deposit" data-filter="<?= Homepagify::dataFilter('first_time_deposit', 'number') ?>">ยอดฝากครั้งแรก</th>
            <th class="thin-cell text-right" nowrap data-sort="count_deposit_time" data-filter="<?= Homepagify::dataFilter('count_deposit_time', 'number') ?>">จำนวนรายการฝาก</th>
            <th class="thin-cell text-right" nowrap data-sort="sum_deposit" data-filter="<?= Homepagify::dataFilter('sum_deposit', 'number') ?>">ยอดฝากรวม</th>
            <th class="thin-cell text-right" nowrap data-sort="sum_withdraw" data-filter="<?= Homepagify::dataFilter('sum_withdraw', 'number') ?>">ยอดถอนรวม</th>
            <th class="thin-cell text-right" nowrap>กำไรลูกค้า</th>
            <th class="thin-cell text-right" nowrap data-sort="money_balance" data-filter="<?= Homepagify::dataFilter('money_balance', 'number') ?>">ยอดคงค้างในระบบ</th>
          </tr>
        </thead>
      </table>
    </div>
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
      $('.icon_down_filter').hide();
      $('.icon_up_filter').show();
      $('.date_filter').hide();
    });
  });
</script>



</html>