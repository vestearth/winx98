<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'play_report'];
require_once '../../.framework/import.php';

$code = $_GET['c'];


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

if (isset($_GET['date'])) {
  $get_date = $_GET['date'];
  $seperate_date = explode(' - ', $get_date);
  $from_date = isset($seperate_date[0]) ? $seperate_date[0] : Util::getSystemDate('-' . 7 . ' days');
  $to_date = isset($seperate_date[1]) ? $seperate_date[1] : Aww::formatDate('', 'Y-m-d');
  $from_date_replace = str_replace('/', '-', $from_date);
  $to_date_replace = str_replace('/', '-', $to_date);
  $from_date_replace_2 = Aww::formatDate($from_date_replace, 'Y-m-d');
  $to_date_replace_2 = Aww::formatDate($to_date_replace, 'Y-m-d');
} else {
  $from_date_replace_2 = Util::getSystemDate('-' . 7 . ' days');
  $to_date_replace_2 = Aww::formatDate('', 'Y-m-d');
  $from_date = Aww::formatDate(Util::getSystemDate('-' . 7 . ' days'), 'd/m/Y');
  $to_date = Aww::formatDate('', 'd/m/Y');
}
$date_input = $from_date_replace_2 . ' to ' . $to_date_replace_2;

$summary = nga_statistic::getSummaryCardAndSlot($code, $from_date_replace_2, $to_date_replace_2);
$select =  nga_statistic::selectSummaryCardAndSlot($code, $from_date_replace_2, $to_date_replace_2);
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

  <div class='bg-whites mb-10px pb-10px border-bottom'>
    <div class="d-flex top-tap justify-content-between  pt-10px px-15px">
      <div class="msg ">
        <div class='topic'>รายงานหมุนวงล้อ&เล่นไพ่</div>
        <div class="font-14px text-sub">
          ข้อมูลรายละเอียดสรุปการหมุนวงล้อ & เล่นไพ่
        </div>
      </div>
      <div class="date-range">
        <form method="get" id="form_event_date_range">
          <?= TiwForm::normal('daterange', $date_input, ['name' => 'date', 'class' => 'event_date_range'], []); ?>
          <input type="hidden" name="c" value="<?= $code; ?>">
        </form>
      </div>
    </div>
  </div>
  <div class="bg-whites">
    <div class="form-row">
      <div class="col-lg-6">
        <div class="container-graph h-300px w-100p max-w-300px py-10px mx-auto">
          <canvas id="Chartdonut" height="250" class="w-100p max-w-250px"></canvas>
        </div>

        <div class="w-100p max-w-300px py-10px mx-auto">
          <div class="w-375px">
            <div class="font-18px font-Bold ">
              กราฟแสดงเครดิตการหมุนวงล้อ & เปิดไพ่
            </div>
            <div class="legend py-15px mx-auto">

              <div class="d-flex py-5px mx-auto">
                <div class="w-5px h20px bg-success "></div>
                <div class="pl-10px">
                  ยอดรวมเครดิตที่ใช้หมุนวงล้อ
                  <span class="text-success font-Bold">
                    <?= $summary['percent_play_slot'] ?>% | <?= number_format($summary['sum_credit_play_slot'], 2) ?>
                  </span>
                  <span class="font-Bold">เครดิต</span>
                </div>
              </div>

              <div class="d-flex py-5px  mx-auto">
                <div class="w-5px h20px bg-danger "></div>
                <div class="pl-10px">
                  ยอดรวมเครดิตที่ใช้เปิดไพ่
                  <span class="text-danger font-Bold">
                    <?= $summary['percent_play_card'] ?>% | <?= number_format($summary['sum_credit_play_card'], 2) ?>
                  </span>
                  <span class="font-Bold">เครดิต</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="container-graph h-300px w-100p max-w-300px py-10px mx-auto">
          <canvas id="ChartdonutNumber" height="250" class="w-100p max-w-250px"></canvas>
        </div>
        <div class="w-100p max-w-300px py-10px mx-auto">
          <div class="font-18px font-Bold ">
            กราฟแสดงยอดรวมการเปิดไพ่
          </div>
          <div class="legend py-15px mx-auto">
            <div class="d-flex py-5px mx-auto">
              <div class="w-5px h20px bg-g-blue "></div>
              <div class="pl-10px">
                ยอดรวมเครดิต
                <span class="text-g-blue font-Bold">
                  <?= $summary['card_receive_credit_percent'] ?>% | <?= number_format($summary['card_receive_credit_amount'], 2) ?>
                </span>
                <span class="font-Bold">เครดิต</span>
              </div>
            </div>
            <div class="d-flex py-5px  mx-auto">
              <div class="w-5px h20px bg-g-blue-1 "></div>
              <div class="pl-10px">
                ยอดรวมแต้ม
                <span class="text-g-blue-1 font-Bold">
                  <?= $summary['card_receive_point_percent'] ?>% | <?= number_format($summary['card_receive_point_amount'], 2) ?>
                </span>
                <span class="font-Bold">แต้ม</span>
              </div>
            </div>
            <div class="d-flex py-5px  mx-auto">
              <div class="w-5px h20px bg-success "></div>
              <div class="pl-10px">
                ยอดรวมรางวัล
                <span class="text-success font-Bold">
                  <?= $summary['card_receive_reward_percent'] ?>% | <?= number_format($summary['card_receive_reward_amount'], 2) ?>
                </span>
                <span class="font-Bold">รางวัล</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="table-responsive ">
      <table class="table table-striped-2">
        <thead>
          <tr>
            <th nowrap>วันที่</th>
            <th nowrap class="max-w-500px"> หมุนวงล้อ (เครดิต) </th>
            <th nowrap class="thin-cell"> หมุนวงล้อ (แต้ม) </th>
            <th nowrap class="thin-cell"> หมุนวงล้อ (รางวัล) </th>
            <th nowrap class="thin-cell"> เปิดไพ่ (เครดิต) </th>
            <th nowrap class="thin-cell"> เปิดไพ่ (แต้ม) </th>
            <th nowrap class="thin-cell"> เปิดไพ่ (รางวัล) </th>
          </tr>
        </thead>
        <tbody class="text-right">
          <tr>
            <td class="text-white bg-blue-1"><?= $select[0]['date'] ?></td>
            <td class="thin-cell bg-blue-2"><?= number_format($select[0]['slot_receive_credit_amount'], 2) ?></td>
            <td class="thin-cell bg-blue-2"><?= number_format($select[0]['slot_receive_point_amount'], 2) ?></td>
            <td class="thin-cell bg-blue-2"><?= number_format($select[0]['slot_receive_reward_amount'], 2) ?></td>
            <td class="thin-cell bg-blue-2"><?= number_format($select[0]['card_receive_credit_amount'], 2) ?></td>
            <td class="thin-cell bg-blue-2"><?= number_format($select[0]['card_receive_point_amount'], 2) ?></td>
            <td class="thin-cell bg-blue-2"><?= number_format($select[0]['card_receive_reward_amount'], 2) ?></td>
          </tr>
          <?php
          unset($select[0]);
          ?>
          <?php foreach ($select as $value) { ?>
            <tr>
              <td class=" text-left"><?= Aww::formatDate($value['date'], 'd/m/Y'); ?></td>
              <td class="thin-cell"><?= number_format($value['slot_receive_credit_amount'], 2) ?></td>
              <td class="thin-cell"><?= number_format($value['slot_receive_point_amount'], 2) ?></td>
              <td class="thin-cell"><?= number_format($value['slot_receive_reward_amount'], 2) ?></td>
              <td class="thin-cell"><?= number_format($value['card_receive_credit_amount'], 2) ?></td>
              <td class="thin-cell"><?= number_format($value['card_receive_point_amount'], 2) ?></td>
              <td class="thin-cell"><?= number_format($value['card_receive_reward_amount'], 2) ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>


  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>


</body>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.js" integrity="sha512-5m2r+g00HDHnhXQDbRLAfZBwPpPCaK+wPLV6lm8VQ+09ilGdHfXV7IVyKPkLOTfi4vTTUVJnz7ELs7cA87/GMA==" crossorigin="anonymous" referrerpolicy="no-referrer">
</script>

<script>
  function findlength(str) {
    return str.length;
  }
  const donut = document.getElementById('Chartdonut').getContext('2d');
  let color = ['#3E88FB', '#FE635B', '#0BAA22', '#D0D6DD'];
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
        let loop = Math.floor((length - 1) / 3);
        console.log(loop);
        for (let i = 0; i < loop; i++) {
          total = total + ',' + totals.slice(-3);
        }
        total = totals.substr(0, length - 3 * loop) + total + '.00';
      } else {
        total = totalRaw;
      }
      ctx.font = 'bolder 25px Sarabun';
      ctx.fillStyle = '#000000';
      ctx.textAlign = 'center';
      ctx.fillText(total, width / 2, height / 2 - 5);
      ctx.restore();

      ctx.font = 'normal 14px Sarabun';
      ctx.fillStyle = '#3A4248';
      ctx.textAlign = 'center';
      ctx.fillText('เครดิต', width / 2, height / 2 + 30);
      ctx.restore();
    }
  }
  var sum_credit_play_slot = <?= $summary['sum_credit_play_slot'] ?>;
  var sum_credit_play_card = <?= $summary['sum_credit_play_card'] ?>;
  const Chartdonut = new Chart(donut, {
    type: 'doughnut',
    plugins: [centerText],
    data: {
      labels: ['หมุนวงล้อ', 'เปิดไพ่'],
      datasets: [{
          //? ค่าน้อย แสดงผลกราฟด้านล่าง
          data: [sum_credit_play_slot, sum_credit_play_card],
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
      maintainAspectRatio: false,
      cutout: '70%',
      plugins: {
        legend: false
      }
    },
  });
</script>
<script>
  const donuts = document.getElementById('ChartdonutNumber').getContext('2d');
  color = ['#5C9CFF', '#235E88', '#0baa22', '#D0D6DD'];
  //! color = 'ยอดฝาก', 'ยอดถอน', 'ส่วนต่าง' , ยอดเมื่อวาน
  const centerTexts = {
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
      let totalRaw = chart.data.datasets[0].data[0] + chart.data.datasets[0].data[1] + chart.data.datasets[0].data[2];
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
      ctx.fillStyle = '#000000 ';
      ctx.textAlign = 'center';
      ctx.fillText(total, width / 2, height / 2 - 5);
      ctx.restore();

      ctx.font = 'normal 14px Sarabun';
      ctx.fillStyle = '#3A4248';
      ctx.textAlign = 'center';
      ctx.fillText('รายการ', width / 2, height / 2 + 30);
      ctx.restore();
    }
  }
  var card_receive_credit_count = <?= $summary['card_receive_credit_amount'] ?>;
  var card_receive_point_count = <?= $summary['card_receive_point_amount'] ?>;
  var card_receive_reward_count = <?= $summary['card_receive_reward_amount'] ?>;

  const ChartdonutNumber = new Chart(donuts, {
    type: 'doughnut',
    plugins: [centerTexts],
    data: {
      labels: ['เครดิต', 'แต้ม', 'รางวัล'],
      datasets: [{
          //? ค่าน้อย แสดงผลกราฟด้านล่าง
          data: [card_receive_credit_count, card_receive_point_count, card_receive_reward_count],
          backgroundColor: [
            color[0], color[1], color[2],
          ],
          borderColor: [
            color[0], color[1], color[2],
          ],
        },

      ]
    },
    options: {
      maintainAspectRatio: false,
      cutout: '70%',

      plugins: {
        legend: false
      }
    },
  });
  $(document).ready(function() {
    $(document).on('change', '.event_date_range', function() {
      var date_range = $('.event_date_range').val();
      var date_range_arr = date_range.split(' - ');
      var date_start = date_range_arr[0];
      var date_end = date_range_arr[1];
      if (date_start != '' && date_end != undefined) {
        $('#form_event_date_range').submit();
      }
    });
  });
</script>


</html>