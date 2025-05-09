<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'deposit_event_report'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$selected_duration = isset($_GET['selected_activity']) ? $_GET['selected_activity'] : '';

if (isset($_GET['submit_clear_summary'])) {
  $date_data = Aww::formatDate('', 'Y-m-d');
} else {
  $date_data = isset($_GET['date_data']) ? $_GET['date_data'] : Aww::formatDate('', 'Y-m-d');
}

$deposit_data = nga_statistic::selectSummaryDepositByBot($code, $date_data);
$withdraw_data =  nga_statistic::selectSummaryWithdrawByBot($code, $date_data);

$selected_activity_options = [
  'list' => [],
];

$event_activity_list = nga_management::selectEventDeposit($code, []);
$type_period = '';
foreach ($event_activity_list as $data) {
  if ($data['event_type'] == 'short_term') {
    $event_name = 'Short Term 7 วัน';
    $start_date = Aww::formatDate($data['from_date_time'], 'd/m/Y');
    $end_date = Aww::formatDate($data['to_date_time'], 'd/m/Y');
    $type_period = '7 วัน';
  } else {
    $event_name = 'Long Term 30 วัน';
    $start_date = Aww::formatDate($data['from_date_time'], 'd/m/Y');
    $end_date = Aww::formatDate($data['to_date_time'], 'd/m/Y');
    $type_period = '30 วัน';
  }
  $selected_activity_options['list'][] = [
    'value' => $data['id'],
    'name' => $event_name . ' | ' . $start_date . ' - ' . $end_date,
    'type' => $type_period,
  ];
}
foreach ($selected_activity_options['list'] as $key => $data) {
  if ($selected_duration) {
    if ($data['value'] == $selected_duration) {
      $duration_show = $data['name'];
      $period_name = $data['type'];
    }
  } else {
    if ($key == 0) {
      $selected_duration = $data['value'];
      $duration_show = $data['name'];
      $period_name = $data['type'];
    }
  }
}
$data_deposit_event =  nga_statistic::getSummaryEventDeposit($code, $selected_duration);
$event_detail = isset($data_deposit_event['event_detail']) ? $data_deposit_event['event_detail'] : [];
$count_user = isset($data_deposit_event['count_user']) ? $data_deposit_event['count_user'] : [];


$status_list = [
  [
    'value' => 'completed',
    'text' => 'ได้โบนัสแล้ว'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'กำลังฝากต่อเนื่อง'
  ],
  [
    'value' => 'cancel',
    'text' => 'ตัดสิทธิ์แล้ว'
  ],
];
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
      <div class="d-flex justify-content-between pt-10px px-15px">
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
            <div class="font-18px font-Bold text-header ">
              รายงานยอดฝากสะสม |
              <span class="event_show_text text-primary"><?= $duration_show; ?></span>
            </div>
            <div class="font-14px text-sub ">
              เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
            </div>
          </div>
        </div>
        <div class="max-w-400px w-100">
          <form method="get" id="form_event_month_select" class="">
            <?= TiwForm::normal('select', $selected_duration, ['name' => 'selected_activity', 'class' => 'event_select_text'], $selected_activity_options); ?>
            <input type="hidden" name="c" value="<?= $code; ?>">
          </form>
        </div>
      </div>
    </div>
    <div class="form-row px-15px summary_event">
      <!-- ลิสต์จำนวนยอดฝาก + กิจกรรม  -->
      <div class="col-lg-4">
        <div class="mb-10px border-round">
          <div class="form-row">
            <div class="col-6 font-Bold font-16px text-header ">
              จำนวนยอดฝากต่อวัน
            </div>
            <div class="col-6 font-Bold font-16px text-header pl-15px">
              ฝากครบ <?= $period_name; ?> แจกเครดิต
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6  my-auto">
                  <div class="font-30px font-Bold text-header text-primary"><?= number_format($event_detail['deposit_amount'], 2); ?> </div>
                </div>
                <div class="col-6 border-left">
                  <div> <span class="font-30px font-Bold text-primary"><?= number_format($event_detail['credit_receive'], 2) ?></span> <span class="font-15px font-Medium"></span> </div>
                </div>
                <div class="col-6">
                  <div>บาท</div>
                </div>
                <div class="col-6">
                  <div>บาท</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ลิสต์จำนวนผู้เล่นต่างๆ -->
      <div class="col-lg-6">
        <div class="mb-10px border-round">
          <div class="form-row">
            <div class="col-4 font-Bold font-16px text-header ">
              จำนวนผู้เล่นที่ได้โบนัสแล้ว
            </div>
            <div class="col-4 font-Bold font-16px text-header pl-15px">
              ผู้เล่นที่กำลังฝากต่อเนื่อง
            </div>
            <div class="col-4 font-Bold font-16px text-header pl-15px">
              ผู้เล่นที่ตัดสิทธิ์แล้ว
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-4  my-auto">
                  <div class="font-30px font-Bold text-header text-success"><?= number_format($count_user['จำนวนผู้เล่นที่ได้โบนัสแล้ว'], 0); ?></div>
                </div>
                <div class="col-4 border-left">
                  <div>
                    <span class="font-30px font-Bold text-primary"><?= number_format($count_user['ผู้เล่นที่กำลังฝากต่อเนื่อง'], 0); ?>
                    </span>
                  </div>
                </div>
                <div class="col-4 border-left">
                  <div>
                    <span class="font-30px font-Bold text-danger"><?= number_format($count_user['ผู้เล่นที่ตัดสิทธิ์แล้ว'], 0); ?>
                    </span>
                  </div>
                </div>
                <div class="col-4">
                  <div>คน</div>
                </div>
                <div class="col-4">
                  <div>คน</div>
                </div>
                <div class="col-4">
                  <div>คน</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            ยอดโบนัสที่แจกไปแล้วทั้งหมด
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6 border-left">
                  <div>
                    <span class="font-30px font-Bold"><?= number_format($data_deposit_event['total_bonus'], 2) ?></span> <span class="ml-15px font-15px font-Medium">บาท</span>
                  </div>
                  <div>จากจำนวนทั้งหมด <span class="text-primary font-Bold"><?= number_format($count_user['จำนวนผู้เล่นที่ได้โบนัสแล้ว'], 0); ?></span> คน</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            ยอดฝากสะสมทั้งกิจกรรม
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-6 border-left">
                  <div>
                    <span class="font-30px font-Bold text-primary"><?= number_format($data_deposit_event['sum_deposit'], 2) ?></span> <span class="ml-15px font-15px font-Medium">บาท</span>
                  </div>
                  <?php
                  $total_user_bonus = $count_user['จำนวนผู้เล่นที่ได้โบนัสแล้ว'] + $count_user['ผู้เล่นที่กำลังฝากต่อเนื่อง'] + $count_user['ผู้เล่นที่ตัดสิทธิ์แล้ว'];
                  ?>
                  <div>จากจำนวนทั้งหมด <span class="text-primary font-Bold"><?= number_format($total_user_bonus, 0); ?></span> คน</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="deposit_event_list" class="container-pagination bg-w  no-border-radius filter_event" <?= Homepagify::createHomepagify('deposit_event_list', '?c=' . $code . '&event_id=' . $selected_duration, '', 'รายการลูกค้าภายใต้เงื่อนไข') ?>>
    <div class="table-responsive">
      <table class="table table-sort  table-striped-2">
        <thead>
          <tr>
            <th class="" nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
            <th class="" nowrap data-sort="user_bank_name" data-filter="<?= Homepagify::dataFilter('user_bank_name', 'text') ?>">ชื่อ - สกุล</th>
            <th class="text-right" width="20%" nowrap>ฝากต่อเนื่อง (วัน)</th>
            <th class="" width="20%" nowrap>สถานะ</th>
            <th class="thin-cell text-right" nowrap>ยอดฝากสะสม</th>
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
    $(document).on('change', '.event_select_text', function() {
      var val = $(this).val();
      var text = $(this).find('option:selected').text();
      $('.event_show_text').html(text);
      // submit form_event_month_select
      $('#form_event_month_select').submit();
    });

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