<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'overview'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$summary_overview =  nga_statistic::getSummaryDaily($code);
$compare_yesterday = isset($summary_overview['compare_yesterday']) ? $summary_overview['compare_yesterday'] : [];
$daily_movement = isset($summary_overview['daily_movement']) ? $summary_overview['daily_movement'] : [];
$graph_deposit_today = isset($summary_overview['graph_deposit_today']) ? $summary_overview['graph_deposit_today'] : [];

if ($summary_overview) {
  // กราฟเส้น ยอดฝาก/ถอน 
  $chart_sum_today = [$compare_yesterday['today_deposit_amount'], $compare_yesterday['today_withdraw_complete_amount'], $compare_yesterday['diff_today_amount']];
  $chart_sum_yesterday = [$compare_yesterday['yesterday_deposit_amount'], $compare_yesterday['yesterday_withdraw_complete_amount'], $compare_yesterday['diff_yesterday_amount']];

  // ความเคลื่อนไหวประจำวัน
  $chart_daily_movement_today = [$daily_movement['today_bonus_amount'], $daily_movement['today_transfer_money_amount'], $daily_movement['today_profit_amount'], $daily_movement['today_turn_over_amount']];
  $chart_daily_movement_yesterday = [$daily_movement['yesterday_bonus_amount'], $daily_movement['yesterday_transfer_money_amount'], $daily_movement['yesterday_profit_amount'], $daily_movement['yesterday_turn_over_amount']];

  // กราฟแสดงการฝากเงินประจำวัน 
  $chart_deposit_today = [$graph_deposit_today['today_deposit_complete_count'], $graph_deposit_today['today_deposit_not_complete_count']];
}


$chart_sum_today = json_encode($chart_sum_today);
$chart_sum_yesterday = json_encode($chart_sum_yesterday);
$chart_daily_movement_today = json_encode($chart_daily_movement_today);
$chart_daily_movement_yesterday = json_encode($chart_daily_movement_yesterday);
$chart_deposit_today = json_encode($chart_deposit_today);

function phase_2($msg1, $num_range, $msg2, $class1 = 'font-Medium text-grey', $class2 = '', $class = '')
{
  $num = (12 - $num_range);
  echo  '<div class="form-row py-5px font-14px ' . $class . '">
  <div class="col-lg-' . $num_range . ' ' . $class1 . '">
  ' . $msg1 . '
  </div>
  <div class="col-lg-' . $num . ' ' . $class2 . ' ">
  ' . $msg2 . '
  </div>
  </div>';
}




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

  <div class="bg-whites px-15px py-15px">
    <div class="d-flex justify-content-between pb-10px">
      <div class="font-20px font-Bold">
        ภาพรวมรายวัน | <span class="font-16px font-SemiBold text-header"> ข้อมูลประจำวัน: <span class="text-primary"><?= Aww::formatDate('', 'd/m/Y'); ?></span> </span>
      </div>
      <div>
        อัพเดทข้อมูลล่าสุด <?= Aww::formatDate('', 'd/m/Y, H:i'); ?>
      </div>
    </div>
    <div class="form-row align-items-stretch ">
      <div class="col-lg-6 mb-5px">
        <div class="border-round text-sub-1">
          <div class="font-SemiBold text-header">
            ยอด ฝาก / ถอนประจำวัน
          </div>
          เปรียบเทียบข้อมูลกับเมื่อวาน
          <div class="graph-bar">
            <div name='legend' class="d-flex flex-wrap py-10px w-60">
              <div class="d-flex pr-10px">
                <div class="w-30px h-10px bg-gray my-auto mr-5px"></div>
                <div class="my-auto text-header"> ยอดเมื่อวาน</div>
              </div>
              <div class="d-flex pr-10px">
                <div class="w-30px h-10px bg-primary my-auto mr-5px"></div>
                <div class="my-auto text-header"> ยอดฝาก</div>
              </div>
              <div class="d-flex pr-10px">
                <div class="w-30px h-10px bg-danger my-auto mr-5px"></div>
                <div class="my-auto text-header"> ยอดถอน</div>
              </div>
              <div class="d-flex pr-10px">
                <div class="w-30px h-10px bg-success my-auto mr-5px"></div>
                <div class="my-auto text-header"> ส่วนต่าง</div>
              </div>
            </div>
            <div class="container-graph h-250px pl-50px mx-auto py-10px">
              <canvas id="myChart" width="200" height="250" class="px-10px "></canvas>
            </div>
          </div>

          <div class="graph-donut form-row">
            <div class="col-xl-4">
              <div class="container-graph h-300px w-100p max-w-300px py-10px mx-auto">
                <canvas id="Chartdonut" height="250" class="w-100p max-w-300px"></canvas>
              </div>
            </div>
            <div class="col-xl-8">
              <div class="pl-30px pt-50px  mx-auto">
                <div class="border-bottom">
                  <div class="font-18px font-Bold ">
                    กราฟแสดงการฝากเงินประจำวัน
                  </div>
                  <div class="legend py-15px">
                    <div class="d-flex py-5px">
                      <div class="w-5px h20px bg-success "></div>
                      <div class="pl-10px">
                        รายการฝากสำเร็จ <span class="text-success font-Bold"> <?= number_format($graph_deposit_today['today_deposit_complete_percent'], 2); ?>%</span>
                      </div>
                    </div>
                    <div class="d-flex py-5px">
                      <div class="w-5px h20px bg-danger "></div>
                      <div class="pl-10px">
                        รายการ ฝากเงินไม่เข้า <span class="text-danger font-Bold"> <?= number_format($graph_deposit_today['today_deposit_not_complete_percent'], 2); ?>%</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="pt-20px">
                  <div> <span class="font-28px text-danger font-Bold"><?= number_format($graph_deposit_today['today_deposit_not_complete_amount'], 2); ?> </span> บาท</div>
                  <div>
                    <?php if ($graph_deposit_today['diff_deposit_not_complete_status'] == 'down') { ?>
                      ยอดที่ฝากเงินไม่เข้า: ลดจากเมื่อวาน
                    <?php } else if ($graph_deposit_today['diff_deposit_not_complete_status'] == 'up') { ?>
                      ยอดที่ฝากเงินไม่เข้า: เพิ่มขึ้นจากเมื่อวาน
                    <?php } else { ?>
                      ยอดที่ฝากเงินไม่เข้า: เท่าเมื่อวาน
                    <?php } ?>

                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-6">

        <div class="border-round h-400px">
          <div class="font-SemiBold">
            ความเคลื่อนไหวประจำวัน
          </div>
          เปรียบเทียบข้อมูลกับเมื่อวาน

          <div class="graph-bar-horzontal">
            <div name='legend' class="d-flex flex-wrap py-10px w-60">
              <div class="d-flex pr-10px">
                <div class="w-30px h-10px bg-gray my-auto mr-5px"></div>
                <div class="my-auto"> ยอดเมื่อวาน</div>
              </div>
              <div class="d-flex pr-10px">
                <div class="w-30px h-10px bg-primary my-auto mr-5px"></div>
                <div class="my-auto"> ยอดรวมวันนี้</div>
              </div>
            </div>
            <div class="container-graph h-250px pl-50px mx-auto py-10px">
              <canvas id="chartHorizontal" width="200" height="250" class="px-10px "></canvas>
            </div>
          </div>
        </div>

        <div class="form-row mt-equal text-sub-1">
          <div class="col-lg-6  mb-5px">
            <div class="border-round h-equal">
              <div class="text-center my-10px">
                <div class="font-18px font-Bold text-header">
                  ลูกค้าใหม่วันนี้
                </div>
                <div class="font-46px font-Bold text-primary">
                  <?= number_format($summary_overview['new_customer']['today_count'], 0); ?>
                </div>
                <div>
                  ราย
                </div>
                <div>
                  <?php if ($summary_overview['new_customer']['today_count'] > $summary_overview['new_customer']['yesterday_count']) {
                    $text_show = 'เพิ่มขึ้น';
                    $text_color = 'text-success';
                    $icon_status = 'svg-success';
                  } else if ($summary_overview['new_customer']['today_count'] < $summary_overview['new_customer']['yesterday_count']) {
                    $text_show = 'ลดลง';
                    $text_color = 'text-danger';
                    $icon_status = 'svg-danger';
                  } else {
                    $text_show = '';
                    $text_color = 'text-sub-1';
                    $icon_status = 'svg-sub-1';
                  } ?>
                  <?= $text_show; ?> <span class="<?= $text_color; ?> font-Bold <?= $icon_status; ?>"><?= number_format($summary_overview['new_customer']['compare_yesterday'], 0); ?>% <?= file_get_contents('./assets/icon/icon-redarrow-up.svg') ?></span>จากเมื่อวาน
                </div>
                <div>
                  ฝากเงินทั้งหมด <span><?= number_format($summary_overview['new_customer']['deposit_count'], 0); ?></span> คน
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6  mb-5px">
            <div class="border-round h-equal ">
              <div class="text-center my-15px">
                <div class="font-18px font-Bold text-header">
                  โปรโมชั่นที่อยู่ในช่วงเวลา
                </div>
                <div class="font-46px font-Bold text-primary">
                  <?= number_format($summary_overview['promotion_in_time_count'], 0); ?>
                </div>
                <div>
                  โปรโมชั่น
                </div>
                <div class="pt-10px">
                  กำลังเปิดใช้งานในขณะนี้
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.js" integrity="sha512-5m2r+g00HDHnhXQDbRLAfZBwPpPCaK+wPLV6lm8VQ+09ilGdHfXV7IVyKPkLOTfi4vTTUVJnz7ELs7cA87/GMA==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
<script>
  var chart_sum_today = jQuery.parseJSON('<?= $chart_sum_today ?>');
  var chart_sum_yester = jQuery.parseJSON('<?= $chart_sum_yesterday ?>');

  const line = document.getElementById('myChart').getContext('2d');
  let color = ['#3E88FB', '#FE635B', '#0BAA22', '#D0D6DD'];
  //! color = 'ยอดฝาก', 'ยอดถอน', 'ส่วนต่าง' , ยอดเมื่อวาน
  const myChart = new Chart(line, {
    type: 'bar',
    data: {
      labels: ['ยอดฝาก', 'ยอดถอน', 'ส่วนต่าง'],
      datasets: [{
          //? ค่าน้อย แสดงผลกราฟด้านล่าง
          data: chart_sum_yester,
          backgroundColor: [
            color[3], color[3], color[3]
          ],
          borderColor: [
            color[3], color[3], color[3]
          ],
          barThickness: 40,
        },
        {
          //? ค่าต่าง (ค่ามาก ลบ ค่าน้อย) แสดงผลกราฟด้านบน
          data: chart_sum_today,
          backgroundColor: [
            color[0], color[1], color[2]
          ],
          borderColor: [
            color[0], color[1], color[2]
          ],
          barThickness: 40,
        },
      ]
    },
    options: {
      // indexAxis: 'y',
      maintainAspectRatio: false,
      plugins: {
        legend: false
      },
      scales: {
        y: {

          stacked: true,
          ticks: {
            // stepSize: 100000,
            // padding: 20,
            // crossAlign: 'start'
          },
          grid: {
            borderDash: [5, 10],
            color: "#9CA2A8",
            color: (context) => {
              if (context.tick.value == 0) {
                return '#FFFFFF'
              } else {
                return 'rgba(0,0,0,0.1)'
              }
            },
          },
          // suggestedMax: 300000
        },
        x: {
          stacked: true,
          grid: {
            lineWidth: 0,
            color: "#9CA2A8"
          },

        },
      }
    },

  });
</script>

<script>
  function findlength(str) {
    return str.length;
  }
  const donut = document.getElementById('Chartdonut').getContext('2d');
  color = ['#3E88FB', '#FE635B', '#0BAA22', '#D0D6DD'];
  //! color = 'ยอดฝาก', 'ยอดถอน', 'ส่วนต่าง' , ยอดเมื่อวาน
  const centerText = {
    id: 'centerText',
    afterDatasetsDraw(chart, args, options) {
      const {
        ctx,
        chartArea: {
          left,
          right,
          top,
          bottom,
          width,
          height
        }
      } = chart;
      ctx.save();
      let totalRaw = chart.data.datasets[0].data[0] + chart.data.datasets[0].data[1];
      let total = '';
      if (totalRaw >= 1000) {
        totals = totalRaw.toString();
        length = findlength(totals);
        let loop = (length - 1) / 3;
        for (let i = 0; i < loop; i++) {
          total = total + ',' + totals.slice(-3)
        }
        total = totals.substr(0, length - 3 * loop) + total;
      } else {
        total = totalRaw;
      }
      ctx.font = 'bolder 36px Sarabun';
      ctx.fillStyle = '#3E88FB';
      ctx.textAlign = 'center';
      ctx.fillText(total, width / 2, height / 2 - 5);
      ctx.restore();

      ctx.font = 'normal 14px Sarabun';
      ctx.fillStyle = '#3A4248';
      ctx.textAlign = 'center';
      ctx.fillText('รายการฝาก', width / 2, height / 2 + 30);
      ctx.restore();
    }
  }
  var chart_deposit_today = jQuery.parseJSON('<?= $chart_deposit_today ?>');
  const Chartdonut = new Chart(donut, {
    type: 'doughnut',
    plugins: [centerText],
    data: {
      labels: ['รายการฝากสำเร็จ', 'รายการฝากเงินไม่เข้า'],
      datasets: [{
          //? ค่าน้อย แสดงผลกราฟด้านล่าง
          data: chart_deposit_today,
          backgroundColor: [
            color[2], color[1]
          ],
          borderColor: [
            color[2], color[1]
          ],
        },

      ]
    },
    options: {
      maintainAspectRatio: true,
      responsive: true,
      cutout: '70%',
      plugins: {
        legend: false
      }
    },
  });
</script>

<script>
  var chart_daily_movement_today = jQuery.parseJSON('<?= $chart_daily_movement_today ?>');
  var chart_daily_movement_yesterday = jQuery.parseJSON('<?= $chart_daily_movement_yesterday ?>');
  const lineH = document.getElementById('chartHorizontal').getContext('2d');
  color = ['#3E88FB', '#FE635B', '#0BAA22', '#D0D6DD'];
  //! color = 'ยอดฝาก', 'ยอดถอน', 'ส่วนต่าง' , ยอดเมื่อวาน
  const lineHorizon = new Chart(lineH, {
    type: 'bar',
    data: {
      labels: ['ยอดโบนัส', 'ยอดโยกเงิน', 'ยอดรวมกำไร', 'ยอดคืนยอดเสีย'],
      datasets: [{
          //? ค่าน้อย แสดงผลกราฟด้านซ้าย
          data: chart_daily_movement_yesterday,
          backgroundColor: [
            color[3], color[3], color[3], color[3]
          ],
          barThickness: 30,
        },
        {
          //? ค่าต่าง (ค่ามาก ลบ ค่าน้อย) แสดงผลกราฟด้านขวา
          data: chart_daily_movement_today,
          backgroundColor: [
            color[0], color[0], color[0], color[0]
          ],
          barThickness: 30,
        },
      ]
    },
    options: {
      indexAxis: 'y',
      maintainAspectRatio: false,
      plugins: {
        legend: false
      },
      scales: {
        y: {
          stacked: true,

          grid: {
            lineWidth: 0,
          },

        },
        x: {
          stacked: true,
          ticks: {
            // stepSize: 30000,
            // padding: 20,
            // crossAlign: 'start'
          },
          grid: {
            borderDash: [5, 5],
            color: (context) => {
              console.log(context)
              if (context.tick.value == 0) {
                return '#FFFFFF'
              } else {
                return 'rgba(0,0,0,0.1)'
              }
            },
          },
          beginAtZero: true,
          grace: 5,
        },
      }
    },

  });
</script>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>