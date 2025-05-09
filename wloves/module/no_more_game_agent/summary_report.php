<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'summary_report'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav']);

$code = $_GET['c'];
$get_data = nga_statistic::getSummaryCreditTransaction($code);
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$chart_labels = [''];
$chart_sum_withdraw = [''];
$chart_sum_deposit = [''];

foreach ($get_data['graph_data'] as $key => $value) {
  array_push($chart_labels, Aww::formatDate($key, 'd/m/Y', true));
  array_push($chart_sum_withdraw, $value['sum_withdraw']);
  array_push($chart_sum_deposit, $value['sum_deposit']);
}
$chart_labels = json_encode($chart_labels);
$chart_sum_withdraw = json_encode($chart_sum_withdraw);
$chart_sum_deposit = json_encode($chart_sum_deposit);

if (isset($_GET['submit_clear_summary'])) {
  $from_date = Util::getSystemDate('-' . 7 . ' days');
  $to_date = Aww::formatDate('', 'Y-m-d');
} else {
  $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : Util::getSystemDate('-' . 7 . ' days');
  $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : Aww::formatDate('', 'Y-m-d');
}

if ($page == 2) {
  $select_summary_credit_transaction =  nga_statistic::selectSummaryCreditTransaction($code, $from_date, $to_date);
} else {
  $select_summary_credit_transaction =  nga_statistic::selectSummaryCreditTransactionall($code, $from_date, $to_date);
}
$data_nav = [
  'param_name'  => 'page',
  'class' => 'bg-whites',
  'list' => [
    [
      'id'  => 1,
      'name'  => 'รายการทั้งหมด',
    ],
    [
      'id'  => 2,
      'name'  => 'รายการเฉพาะลูกค้าใหม่',
    ],
  ]
];
$link = 'summary_report.php?c=' . $_GET['c'];

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
            <div class="font-18px font-Bold  text-header">รายงานสรุปยอดฝาก / ถอน</div>
            <div class="font-14px text-sub ">
              สรุปยอดฝากถอนภายในระบบ, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row px-15px summary_event">
      <div class="col-lg-3 ">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px ">
            ยอดฝากรวมประจำวัน
          </div>
          <?php
          if ($get_data['today_deposit_compare_yesterday'] <= 0) {
            $is_flip = 'flip-arrow';
            $to_day_deposit_compare_yesterday_title = 'ลดลง';
            $to_day_deposit_compare_yesterday_class = 'text-danger';
            $to_day_deposit_compare_yesterday_icon = 'icon-percent-red';
          } else {
            $is_flip = '';
            $to_day_deposit_compare_yesterday_title = 'เพิ่มขึ้น';
            $to_day_deposit_compare_yesterday_class = 'text-success';
            $to_day_deposit_compare_yesterday_icon = 'icon-percent-green';
          }
          ?>
          <div class=" font-Medium">
            <div class="font-15px">
              <span class="font-30px font-Bold text-success"><?= number_format($get_data['today_deposit'], 2) ?></span>บาท
            </div>
            <div class="font-15px <?= $is_flip ?>">
              <?= $to_day_deposit_compare_yesterday_title ?> <span class="<?= $to_day_deposit_compare_yesterday_class ?>"><?= number_format($get_data['today_deposit_compare_yesterday']) ?>% <?= file_get_contents('assets/icon/' . $to_day_deposit_compare_yesterday_icon . '.svg') ?></span> จากเมื่อวาน
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 ">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            ยอดถอนรวมประจำวัน
          </div>
          <?php
          if ($get_data['today_withdraw_compare_yesterday'] <= 0) {
            $is_flip = 'flip-arrow';
            $today_withdraw_compare_yesterday_title = 'ลดลง';
            $today_withdraw_compare_yesterday_class = 'text-danger';
            $today_withdraw_compare_yesterday_icon = 'icon-percent-red';
          } else {
            $is_flip = '';
            $today_withdraw_compare_yesterday_title = 'เพิ่มขึ้น';
            $today_withdraw_compare_yesterday_class = 'text-success';
            $today_withdraw_compare_yesterday_icon = 'icon-percent-green';
          }
          ?>
          <div class=" font-Medium">
            <div class="font-15px">
              <span class="font-30px font-Bold text-danger"><?= number_format($get_data['today_withdraw'], 2) ?></span>บาท
            </div>
            <div class="font-15px <?= $is_flip ?>">
              <?= $today_withdraw_compare_yesterday_title ?> <span class="<?= $today_withdraw_compare_yesterday_class ?>"><?= number_format($get_data['today_withdraw_compare_yesterday']) ?>% <?= file_get_contents('assets/icon/' . $today_withdraw_compare_yesterday_icon . '.svg') ?></span> จากเมื่อวาน
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 ">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            ส่วนต่างประจำวัน
          </div>
          <?php
          if ($get_data['today_dep_wit_difference_compare_yesterday'] <= 0) {
            $is_flip = 'flip-arrow';
            $today_dep_wit_difference_compare_yesterday_title = 'ลดลง';
            $today_dep_wit_difference_compare_yesterday_class = 'text-danger';
            $today_dep_wit_difference_compare_yesterday_icon = 'icon-percent-red';
          } else {
            $is_flip = '';
            $today_dep_wit_difference_compare_yesterday_title = 'เพิ่มขึ้น';
            $today_dep_wit_difference_compare_yesterday_class = 'text-success';
            $today_dep_wit_difference_compare_yesterday_icon = 'icon-percent-green';
          }
          ?>
          <div class=" font-Medium">
            <div class="font-15px">
              <span class="font-30px font-Bold text-primary"><?= number_format($get_data['today_dep_wit_difference'], 2) ?></span>บาท
            </div>
            <div class="font-15px <?= $is_flip ?>">
              <?= $today_dep_wit_difference_compare_yesterday_title ?> <span class="<?= $today_dep_wit_difference_compare_yesterday_class ?>"><?= number_format($get_data['today_dep_wit_difference_compare_yesterday']) ?>% <?= file_get_contents('assets/icon/' . $today_dep_wit_difference_compare_yesterday_icon . '.svg') ?></span> จากเมื่อวาน
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 ">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            การทำรายการประจำวัน
          </div>
          <div class="row">
            <div class="col-6">
              <div class="row">
                <div class="col-12 border-right">
                  <div class="text-primary font-30px font-Bold text-primary"><?= number_format($get_data['count_today_deposit']) ?></div>
                </div>
                <div class="col-12">
                  <div>รายการฝาก</div>
                </div>
              </div>
            </div>
            <div class="col-6">
              <div class="row">
                <div class="col-12">
                  <div class="font-30px font-Bold "><?= number_format($get_data['count_today_withdraw']) ?></div>
                </div>
                <div class="col-12">
                  <div>รายการถอน</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class='border-radius-15px border-round mx-15px mb-10px pb-20px summary_event'>
      <div class="font-Bold font-16px pt-15px px-15px text-header">กราฟแสดงยอดฝาก / ถอน 7 วันย้อนหลัง</div>
      <div class="h-375px">
        <canvas id="myChart" width="400" height="400" class=""></canvas>
      </div>
    </div>
  </div>

  <div class="editable-card core-new border-radius-bottom-0 ">
    <div class="editable-card-header rounded-0 d-flex justify-content-between p-0 bg-whites nav-lines ">
      <?= Boatnav::dinner($data_nav, $link); ?>
    </div>
  </div>

  <?php
  if ($page == 2) {
    include 'view/summary_report/daily.php';
  } else {
    include 'view/summary_report/all.php';
  }
  ?>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

</body>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.js" integrity="sha512-5m2r+g00HDHnhXQDbRLAfZBwPpPCaK+wPLV6lm8VQ+09ilGdHfXV7IVyKPkLOTfi4vTTUVJnz7ELs7cA87/GMA==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script>
  const ctx = document.getElementById('myChart').getContext('2d');
  const legendMargin = {
    id: 'legendMargin',
    beforeInit(chart, legend, options) {
      const fitValue = chart.legend.fit;
      chart.legend.fit = function fit() {
        fitValue.bind(chart.legend)();
        return this.height += 20;
      }
    }
  }

  var labels = jQuery.parseJSON('<?= $chart_labels ?>');
  var chart_sum_withdraw = jQuery.parseJSON('<?= $chart_sum_withdraw ?>');
  var chart_sum_deposit = jQuery.parseJSON('<?= $chart_sum_deposit ?>');

  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
          label: 'ยอดฝากรวม',
          data: chart_sum_deposit,
          backgroundColor: [
            '#0BAA22',
          ],
          borderColor: [
            '#0BAA22',
          ],
          borderWidth: 2,
          pointRadius: [0, 4, 4, 4, 4, 4, 4, 4],
          hoverPointRadius: [0, 4, 4, 4, 4, 4, 4, 4]
        },
        {
          label: 'ยอดถอนรวม',
          data: chart_sum_withdraw,
          backgroundColor: [
            '#FE635B',
          ],
          borderColor: [
            '#FE635B',
          ],
          borderWidth: 2,
          pointRadius: [0, 4, 4, 4, 4, 4, 4, 4],
          hoverPointRadius: [0, 4, 4, 4, 4, 4, 4, 4]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          align: 'start',
          labels: {
            boxWidth: 15,
            boxHeight: 1
          }

        },
      },
      scales: {
        y: {
          color: '#000000',
          beginAtZero: true,
          grid: {
            borderDash: [3, 3],
            color: (context) => {
              if (context.tick.value == 0) {
                return '#FFFFFF'
              } else {
                return 'rgba(0,0,0,0.1)'
              }
            }
          },
          // ticks: {
          //   stepSize: 100000
          // },
          title: {
            display: true,
            text: 'ยอดรวม',
            align: 'center',
            padding: {
              bottom: 50
            },
          },

          // suggestedMax: 510000
        },
        x: {
          grid: {
            lineWidth: 0,
          },
          title: {
            display: true,
            text: 'วันที่',
            align: 'center',
          },
        },
      }
    },
    plugins: [legendMargin],
  });
</script>

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

  $(document).on('click', '.evnet_clear_search', function() {
    $('.scope_btn_clear_search').click();
  });
</script>



</html>