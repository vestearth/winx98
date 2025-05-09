<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'cash_flow_summary_report'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
if (isset($_GET['submit_clear_summary'])) {
  $from_date = Util::getSystemDate('-' . 7 . ' days');
  $to_date = Aww::formatDate('', 'Y-m-d');
} else {
  $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : Util::getSystemDate('-' . 7 . ' days');
  $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : Aww::formatDate('', 'Y-m-d');
}

$bot_summary = nga_statistic::getSummaryBotTransferMoney($code);
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
            <div class="font-18px font-Bold text-header">รายงานสรุปยอดโยกเงิน</div>
            <div class="font-14px text-sub ">
              สรุปสรุปยอดโยกเงินภายในระบบ, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row px-15px summary_event">
      <div class="col-lg-3">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            ยอดโยกเงินประจำวัน
          </div>
          <div class=" font-Medium">
            <div class="font-15px">
              <span class="font-30px font-Bold text-primary"><?= number_format($bot_summary['today_transfer_money'], 2); ?> </span>บาท
            </div>
            <div class="font-15px">
              <?php
              if ($bot_summary['yesterday_transfer_money'] > $bot_summary['today_transfer_money']) {
                $text_decrease_increase = 'ลดลง';
                $text_style = 'text-danger';
                $icon_percent = file_get_contents('./assets/icon/icon-percent-red.svg');
              } else if ($bot_summary['yesterday_transfer_money'] < $bot_summary['today_transfer_money']) {
                $text_decrease_increase = 'เพิ่มขึ้น';
                $text_style = 'text-success';
                $icon_percent = file_get_contents('assets/icon/icon-percent-green.svg');
              } else {
                $text_decrease_increase = 'ไม่มีการเปลี่ยนแปลง';
                $text_style = 'text-primary';
                $icon_percent = '';
              }
              ?>
              <?= $text_decrease_increase; ?> <span class="<?= $text_style; ?>"><?= number_format($bot_summary['percent_compare_yesterday'], 2); ?>% <?= $icon_percent; ?></span> จากเมื่อวาน
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            ยอดโยกเงินสะสมรวม
          </div>
          <div class=" font-Medium">
            <div class="font-15px">
              <span class="font-30px font-Bold text-primary"><?= number_format($bot_summary['sum_transfer_money'], 2); ?> </span>บาท
            </div>
            <div class="font-15px">

              ตั้งแต่วันที่: <span class="font-Bold text-header"><?= ($bot_summary['transfer_first_date']) ?  Aww::formatDate($bot_summary['transfer_first_date'], 'd/m/Y') : '' ?> </span>
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
                  <div class=" font-24px font-Bold text-header"><?= $bot_summary['maximum_withdraw_bank_name']; ?></div>
                </div>
                <div class="col-6 border-left">
                  <div> <span class="font-30px font-Bold text-primary"><?= ($bot_summary['maximum_withdraw_sum_amount']) ? number_format($bot_summary['maximum_withdraw_sum_amount'], 2) : '0' ?></span> <span class="font-15px font-Medium">บาท</span> </div>
                </div>
                <div class="col-6">
                  <div class="font-15px"><span class="font-Medium">ธนาคาร:</span> <span class="font-Bold text-header"><?= $bot_summary['maximum_withdraw_bank_name_th']; ?><span></div>
                </div>
                <div class="col-6">
                  <div>
                    จากการทำรายการ
                    <span class="text-primary font-Bold">
                      <?= ($bot_summary['maximum_withdraw_count']) ? number_format($bot_summary['maximum_withdraw_count'], 0) : 0 ?>
                    </span>
                    รายการ
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px ">
            บัญชีที่โยกเงินเข้าสะสมมากที่สุด
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6  my-auto">
                  <div class=" font-24px font-Bold"><?= $bot_summary['maximum_deposit_bank_no']; ?></div>
                </div>
                <div class="col-6 border-left">
                  <div>
                    <span class="font-30px font-Bold text-primary">
                      <?= ($bot_summary['maximum_deposit_sum_amount']) ? number_format($bot_summary['maximum_deposit_sum_amount'], 2) : 0 ?></span>
                    <span class="font-15px font-Medium">บาท</span>
                  </div>
                </div>
                <div class="col-6 ">
                  <div class="font-15px"><span class="font-Medium">ธนาคาร:</span> <span class="font-Bold"><?= $bot_summary['maximum_deposit_bank_name_th']; ?><span></div>
                </div>
                <div class="col-6">
                  <div>
                    จากการทำรายการ
                    <span class="text-primary font-Bold">
                      <?= ($bot_summary['maximum_deposit_count']) ? number_format($bot_summary['maximum_deposit_count'], 0) : 0 ?>
                    </span>
                    รายการ
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-w px-15px py-10px pb-15px ">
    <div class="d-flex align-items-center mb-10px">
      <div class="cursor-pointer">
        <div class="icon_up_filter">
          <?= file_get_contents('./assets/icon/icon-up-blue.svg') ?>
        </div>
        <div class="icon_down_filter" style="display:none;">
          <?= file_get_contents('./assets/icon/icon-down-hide.svg') ?>
        </div>
      </div>
      <div class="ml-10px">
        <div class="font-16px font-Bold font-italic text-header">ตัวกรองผลข้อมูล</div>
      </div>
    </div>
    <div class="date_filter capsule_sky font-14px font-Medium ml-45px w-207px" style="display: none;">19/06/2022 - 20/06/2022 <span class="cursor-pointer ml-10px"><?= file_get_contents('assets/icon/icon-close-red.svg') ?></span></div>
    <form method="get" action="?c=<?= $code ?>">
      <div class="row filter_event ">
        <div class="col-sm-2">
          <div class="mt-7px">แสดงผลตามวันที่</div>
        </div>
        <div class="col-sm-10">
          <div class="row">
            <div class="col-12">
              <div class="d-flex">
                <div>
                  <?= TiwForm::normal('date', $from_date, ['name' => 'from_date', 'class' => 'w-200px']) ?>
                  <div class="font-14px text-mute font-italic">วันที่เริ่มต้น</div>
                </div>
                <div class="mx-10px mt-5px">-</div>
                <div>
                  <?= TiwForm::normal('date', $to_date, ['name' => 'to_date', 'class' => 'w-200px']) ?>
                  <div class="font-14px text-mute font-italic">วันที่สิ้นสุด</div>
                </div>
              </div>
            </div>
            <div class="col-12 mt-10px">
              <div class="d-flex">
                <button type="submit" name="submit_search_summary" class="btn btn-warning mr-5px w-100px">ค้นหา</button>
                <button type="submit" name="submit_clear_summary" class="btn btn-close-modal w-70px scope_btn_clear_search">ล้าง</button>
                <input type="hidden" name="c" value="<?= $code ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div id="cash_flow_summary_report" class="container-pagination bg-w  no-border-radius" <?= Homepagify::createHomepagify('cash_flow_summary_report', '?c=' . $code . '&from_date=' . $from_date . '&to_date=' . $to_date, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-striped-2">
        <thead>
          <tr>
            <th class="thin-cell" nowrap>วันที่/เวลา</th>
            <th class="thin-cell " nowrap>จากธนาคาร</th>
            <th class="thin-cell " nowrap>ไปยังธนาคาร</th>
            <th class="thin-cell text-right" nowrap>ยอดโยกเงิน</th>
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