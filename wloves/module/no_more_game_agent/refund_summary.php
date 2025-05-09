<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'refund_summary'];
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

  <div class='bg-whites pb-10px '>
    <div class="pt-10px px-15px d-flex justify-content-between">
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
          <div class="font-18px font-Bold  ">รายการสรุปการคืนยอด</div>
          <div class="font-14px text-sub ">
            สรุปยอดโบนัสภายในระบบ, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-whites px-15px mb-10px pb-10px">
    <div class="form-row py-10px ">
      <div class="col-lg-3 pr-10px">
        <div class="border-round">
          <div class="font-Bold">
            ยอดเงินสะสมจากการเล่น/วัน
          </div>
          <div>
            <span class="font-30px font-Bold text-primary">8,507,600.00 </span>บาท
          </div>
          <div>
            จำนวนผู้เล่น <span class="text-warning font-SemiBold">10,000</span> บาท
          </div>
        </div>
      </div>

      <div class="col-lg-3 pr-10px">
        <div class="border-round">
          <div class="font-Bold">
            ผู้เล่นที่มียอดเสียตามเงื่อนไข
          </div>
          <div>
            <span class="font-30px font-Bold text-success">5,514 </span>ราย
          </div>
          <div>
            เพิ่มขึ้น <span class="text-success svg-success font-SemiBold">7 % <?= file_get_contents('./assets/icon/icon-redarrow-up.svg') ?></span> จากเมื่อวาน
          </div>
        </div>
      </div>

      <div class="col-lg-3 pr-10px">
        <div class="border-round">
          <div class="font-Bold">
            รวมเงินคืนยอดเสีย
          </div>
          <div>
            <span class="font-30px font-Bold text-success">56,518.00 </span>บาท
          </div>
          <div>
            เพิ่มขึ้น <span class="text-success svg-success font-SemiBold">3 % <?= file_get_contents('./assets/icon/icon-redarrow-up.svg') ?></span> จากเมื่อวาน
          </div>
        </div>
      </div>

      <div class="col-lg-3 ">
        <div class="border-round">
          <div class="font-Bold">
            ยอดเงินคืนแล้ว
          </div>
          <div>
            <span class="font-30px font-Bold text-success">40,500.00 </span>บาท
          </div>
          <div>
            ยอดคงค้าง <span class="text-danger font-SemiBold">16,018.00</span> บาท
          </div>
        </div>
      </div>
    </div>
    <div class="border-round py-10px">
      <div class="font-Bold">
        กราฟแสดงยอดการคืนยอดเสียรายวัน 7 วันย้อนหลัง
      </div>
      <div class="h-375px">
        <canvas id="myChart" width="400" height="400" class=""></canvas>
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
        <div class="font-16px font-Bold  ">ตัวกรองผลข้อมูล</div>
      </div>
    </div>
    <div class="date_filter capsule_sky font-14px font-Medium ml-45px w-207px" style="display: none;">19/06/2022 - 20/06/2022 <span class="cursor-pointer ml-10px"><?= file_get_contents('assets/icon/icon-close-red.svg') ?></span></div>
    <div class="row filter_event">
      <div class="col-sm-2">
        <div class="mt-7px">แสดงผลตามวันที่</div>
      </div>
      <div class="col-sm-10">
        <div class="row">
          <div class="col-12">
            <div class="d-flex">
              <div>
                <?= TiwForm::normal('date', '', ['name' => '', 'class' => 'w-200px']) ?>
                <div class="font-14px text-mute font-italic">วันที่เริ่มต้น</div>
              </div>
              <div class="mx-10px mt-5px">-</div>
              <div>
                <?= TiwForm::normal('date', '', ['name' => '', 'class' => 'w-200px']) ?>
                <div class="font-14px text-mute font-italic">วันที่สิ้นสุด</div>
              </div>
            </div>
          </div>
          <div class="col-12 mt-10px">
            <div class="d-flex">
              <button class="btn btn-warning mr-5px w-100px">ค้นหา</button>
              <button class="btn btn-close-modal w-70px">ล้าง</button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <div id="refund_summary" class="container-pagination bg-w  no-border-radius" <?= Homepagify::createHomepagify('refund_summary', '?c=' . $code, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-striped-2">
        <thead class="border-table-1">
          <tr>
            <th class="thin-cell text-center" nowrap>วันที่</th>
            <th class="thin-cell text-right" nowrap>ยอดเงินสะสม</th>
            <th class="thin-cell text-right" nowrap>ยอดคืนเงินเสีย</th>
            <th class="thin-cell text-right" nowrap>ยอดเงินคืนแล้ว</th>
            <th class="thin-cell text-right" nowrap>ยอดเงินยังไม่คืน</th>
            <th class="thin-cell text-right" nowrap>กดรับคืนยอดเสีย</th>
            <th class="thin-cell text-right" nowrap>ไม่กดรับคืนยอดเสีย</th>
            <th class="thin-cell text-center" nowrap>เครดิต</th>
            <th class="thin-cell text-center" nowrap>บัญชี</th>
          </tr>
        </thead>
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
  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['', 'จ. 14/06', 'อ.  15/06', 'พ. 16/06', 'พฤ. 17/06', 'ศ. 18/06', 'ส. 19/06', 'อา. 20/06'],
      datasets: [{
        label: '',
        data: [390000, 280000, 470000, 350000, 420000, 350000, 250000, 400000],
        backgroundColor: [
          '#FE635B',
        ],
        borderColor: [
          '#FE635B',
        ],
        borderWidth: 2,
        pointRadius: [0, 4, 4, 4, 4, 4, 4, 4],
        hoverPointRadius: [0, 4, 4, 4, 4, 4, 4, 4]
      }]
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          align: 'start',
          labels: {
            boxWidth: 0,
            boxHeight: 0
          }

        },
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            borderDash: [5, 15],
          },
          ticks: {
            stepSize: 100000
          },
          title: {
            display: true,
            text: 'ยอดรวม',
            align: 'center',
          },

          suggestedMax: 510000
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

</html>