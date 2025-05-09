<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'failed_deposit_summary_report'];
require_once '../../.framework/import.php';
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
$code = $_GET['c'];

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

  <div class="bg-w mb-10px">
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
            <div class="font-18px font-Bold text-header ">รายงานสรุปการฝากเงินไม่สำเร็จ</div>
            <div class="font-14px text-sub ">
              สรุปผลการชวนเพื่อนของลูกค้า, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="form-row summary_event">
      <div class="col-lg-6">
        <div class="form-row pl-15px">
          <div class="col-lg-6 ">
            <div class="border-round">
              <div class="topic font-Bold">
                ยอดฝากเงินไม่สำเร็จประจำวัน
              </div>
              <div class="pb-5px">
                <span class="font-Bold font-30px text-danger">21,261.00 </span> บาท
              </div>
              <div>เพิ่มขึ้น <span class="font-Bold text-danger">3% <?= file_get_contents('./assets/icon/icon-redarrow-up.svg') ?></span>จากเมื่อวาน</div>
            </div>
          </div>
          <div class="col-lg-6 pl-10px">
            <div class="border-round">
              <div class="topic font-Bold">
                การฝากเงินประจำวัน
              </div>
              <div class="form-row">
                <div class="col-lg-5">
                  <div class="pb-5px font-Bold font-30px text-primary">
                    1,780
                  </div>
                  <div>รายการฝาก</div>
                </div>
                <div class="col-lg-1 h-50px ">
                  <div class="border-left h-40px my-5px"></div>
                </div>
                <div class="col-lg-6">
                  <div class="pb-5px font-Bold font-30px text-danger">
                    45
                  </div>
                  <div>ไม่สำเร็จ</div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-12 pt-10px"></div>
          <div class="col-lg-6">
            <div class="border-round">
              <div class="topic font-Bold">
                ยอดฝากไม่สำเร็จสะสม 7 วันย้อนหลัง
              </div>
              <div class="pb-5px">
                <span class="font-Bold font-30px text-danger">151,261.00 </span> บาท
              </div>
              <div>วันที่ 13/06/2022 - 20/06/2022</div>
            </div>
          </div>
          <div class="col-lg-6 pl-10px">
            <div class="border-round">
              <div class="topic font-Bold">
                ช่วงเวลาที่เกิดปัญหามากที่สุด
              </div>
              <div class="pb-5px">
                <span class="font-Bold font-30px text-header">18:00 - 19:00 </span> บาท
              </div>
              <div>รายการที่ไม่สำเร็จ <span class="font-Bold text-danger">7</span> รายการ </div>
            </div>
          </div>

        </div>
      </div>
      <div class="col-lg-6 pl-20px">
        <div class="graph-donut form-row">
          <div class="col-xl-4">
            <div class="container-graph h-300px w-100p max-w-300px py-10px mx-auto">
              <canvas id="Chartdonut" height="250" class="w-100p max-w-250px"></canvas>
            </div>
          </div>
          <div class="col-xl-8">
            <div class="pl-30px pt-50px">
              <div class="font-18px font-Bold ">
                กราฟแสดงการฝากเงินประจำวัน
              </div>
              <div class="legend py-15px">
                <div class="d-flex py-5px">
                  <div class="w-5px h20px bg-success "></div>
                  <div class="pl-10px">
                    รายการฝากสำเร็จ <span class="text-success font-Bold"> 85.50%</span>
                  </div>
                </div>

                <div class="d-flex py-5px">
                  <div class="w-5px h20px bg-danger "></div>
                  <div class="pl-10px">
                    รายการฝากไม่สำเร็จ <span class="text-danger font-Bold"> 14.50%</span>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-w px-15px py-15px ">
    <div class="d-flex align-items-center pb-10px">
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
                <div class="font-14px text-mute">วันที่เริ่มต้น</div>
              </div>
              <div class="mx-10px mt-5px">-</div>
              <div>
                <?= TiwForm::normal('date', '', ['name' => '', 'class' => 'w-200px']) ?>
                <div class="font-14px text-mute">วันที่สิ้นสุด</div>
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
  <div id="failed_deposit_summary_report" class="container-pagination bg-w  no-border-radius" <?= Homepagify::createHomepagify('failed_deposit_summary_report', '?c=' . $code, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-striped-2">
        <thead>
          <tr>
            <th class="thin-cell" nowrap>วันที่</th>
            <th class="thin-cell text-right" nowrap>จำนวนครั้งการทำรายการฝาก</th>
            <th class="thin-cell text-right" nowrap>จำนวนครั้งการทำรายการไม่สำเร็จ</th>
            <th class="thin-cell text-right" nowrap>คิดเป็น</th>
            <th class="thin-cell text-right" nowrap>ยอดรวมการทำรายการไม่สำเร็จ (บาท)</th>
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
        let loop = (length - 1) / 3;
        for (let i = 0; i < loop; i++) {
          total = total + ',' + totals.slice(-3)
        }
        total = totals.substr(0, length - 3 * loop) + total;
      } else {
        total = totalRaw;
      }
      ctx.font = 'bolder 36px Sarabun';
      ctx.fillStyle = color[0];
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
  const Chartdonut = new Chart(donut, {
    type: 'doughnut',
    plugins: [centerText],
    data: {
      labels: ['ยอดฝาก', 'ยอดถอน'],
      datasets: [{
          //? ค่าน้อย แสดงผลกราฟด้านล่าง
          data: [1522, 258],
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

</html>