<?php

$_PAGE['permission'] = ['no_more_game_agent', 'wallet', 'summarize_returns'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$get_data = '';
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


$total_turnover = nga_statistic::getSummaryTurnOverHistory($code, $from_date_replace_2, $to_date_replace_2);

$chart_labels = [''];
$chart_sum_turnover = [''];
$chart_sum_receive = [''];

foreach ($total_turnover['graph_data'] as $key => $value) {
  array_push($chart_labels, Aww::formatDate($key, 'd/m/Y', true));
  array_push($chart_sum_turnover, $value['sum_turn_over']);
  array_push($chart_sum_receive, $value['sum_receive']);
}
$chart_labels = json_encode($chart_labels);
$chart_sum_turnover = json_encode($chart_sum_turnover);
$chart_sum_receive = json_encode($chart_sum_receive);

function phase_2($msg1, $num_range, $msg2, $class1 = '', $class2 = '', $class = '')
{
  $num = (12 - $num_range);
  echo  '<div class="form-row py-5px font-14px ' . $class . '">
  <div class="col-lg-' . $num_range . ' font-Medium text-grey ' . $class1 . '">
  ' . $msg1 . '
  </div>
  <div class="col-lg-' . $num . ' ' . $class2 . ' ">
  ' . $msg2 . '
  </div>
  </div>';
}


$status_list = [

  [
    'value' => 'success',
    'text' => 'ได้รับแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ยกเลิก'
  ],
  [
    'value' => 'waiting',
    'text' => 'รอรับ'
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

  <div class='bg-white pb-10px border-bottom'>
    <div class="d-flex top-tap justify-content-between  pt-10px">
      <div class="msg col-lg-6">
        <div class='topic'>
          สรุปรายการคืนยอด </div>
        <div class="font-14px text-sub ">
          ข้อมูลรายละเอียดสรุปรายการคืนยอด
        </div>
      </div>
      <div class="date-range px-15px">
        <form method="get" id="form_event_date_range">
          <?= TiwForm::normal('daterange', $date_input, ['name' => 'date', 'class' => 'event_date_range'], []); ?>
          <input type="hidden" name="c" value="<?= $code; ?>">
        </form>
      </div>
    </div>
  </div>


  <div class="mt-10px">
    <div class="form-row px-15px ">

      <div class="col-lg-3 ">
        <div class="mb-10px">
          <div class="card-header-primary py-10px  font-SemiBold font-14px">
            รวมยอดเครดิตที่คืนให้ลูกค้า
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-primary"><?= number_format($total_turnover['sum_turn_over'], 2); ?> </span>บาท
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-orange  font-SemiBold font-14px">
            รวมยอดที่ลูกค้ากดรับเครดิต
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-orange"><?= number_format($total_turnover['sum_receive'], 2); ?> </span>บาท
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-success py-10px font-SemiBold font-14px">
            รวมยอดคงเหลือ
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-success"><?= number_format($total_turnover['sum_outstanding'], 2); ?> </span>บาท
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

  <div class='border-radius-15px bg-whites mx-15px mb-10px pb-20px'>
    <div class="font-Bold font-16px pt-15px px-15px">กราฟแสดงยอดเครดิตที่คืนให้ลูกค้า / ยอดที่ลูกค้ากดรับเครดิต | <span class="text-primary">วันที่ <?= $from_date; ?> - <?= $to_date; ?></span> </div>
    <div class="h-375px">
      <canvas id="myChart" width="400" height="400" class="px-10px "></canvas>
    </div>
  </div>

  <div id="summarize_returns" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('summarize_returns', '?c=' . $code . '&from_date=' . $from_date_replace_2 . '&to_date=' . $to_date_replace_2, '', 'รายการคืนยอด') ?>>
    <div class="table-responsive">
      <table class="table table-striped-2">
        <thead>
          <tr>
            <th>วันที่</th>
            <th class="thin-cell" nowrap>ยอดเครดิตที่คืนให้ลูกค้า</th>
            <th class="thin-cell" nowrap>ยอดที่ลูกค้ากดรับเครดิต</th>
            <th class="thin-cell" nowrap>รวมยอดคงเหลือ</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>


  <?php Tiwdal::startModal('detail_modal', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-16px font-SemiBold">ข้อมูลการถอน</h5>
      </div>
      <div class="modal-body pt-0 px-5px">
        <div class="form-row border-bottom px-15px  ">
          <div class="col-lg-6 border-right">
            <div class="font-14px font-italic py-10px">
              รายละเอียดลูกค้า
            </div>
            <div class="form-row pb-10px">
              <div class="col-3">
                <img src="./assets/image/scb-large.png">
              </div>
              <div class="col-9">
                <div class="text-primary font-18px">
                  เกศรินทร์ เหล็กคำ
                </div>
                <div>
                  000-0-0000-0
                </div>
              </div>
            </div>
            <?= Phase_2('รหัสสมาชิก', 6, '89bvia9367') ?>
            <?= Phase_2('เบอร์โทร', 6, '0844644816') ?>
            <?= Phase_2('กลุ่มลูกค้า', 6, 'Bronze') ?>

          </div>
          <div class="col-lg-6">
            <div class="font-14px font-italic py-10px">
              รายละเอียดการถอน
            </div>
            <?= Phase_2('วัน/เวลา', 5, '14/06/2022, 07:49') ?>
            <?= Phase_2('ยอดเงิน', 5, '57.00') ?>
            <?= Phase_2('สถานะ', 5, 'สำเร็จแล้ว', '', 'text-success font-14px') ?>
            <?= Phase_2('เหตุผล', 5, 'ถอนเงินผ่านธนาคารไทยพาณิชย์ เลขบัญชี 411-1-01708-3') ?>

          </div>
        </div>
        <div class="form-row px-15px">
          <div class="col-lg-8 ">
            <div class="font-14px font-italic py-10px">
              รายละเอียดการถอน
            </div>
            <?= Phase_2('วันที่โอน', 6, '14/06/2022, 07:49') ?>
            <?= Phase_2('ยอดเงิน', 6, '57.00') ?>
            <?= Phase_2('เลขบัญชี', 6, '<div>บัญชีเว็บ: 829-2-65515-6</div>
                                    <div> บัญชีลูกค้า: 411-1-01708-3</div>') ?>
            <?= Phase_2('สถานะ', 6, 'โอนเงินเเล้ว') ?>
            <?= Phase_2('Otp', 6, '377123 (Ref. AX4RTY)') ?>
            <?= Phase_2('ก่อนโอน', 6, '200.00') ?>
            <?= Phase_2('หลังโอน', 6, '143.00') ?>
            <?= Phase_2('หมายเหตุ', 6, 'สำเร็จ') ?>
            <?= Phase_2('โอนโดย', 6, '<img src="./assets/image/bot-auto.png">') ?>
          </div>
        </div>

      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_add_guide', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-danger',], ['text' => 'ยกเลิกการถอน']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

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
  var chart_sum_turnover = jQuery.parseJSON('<?= $chart_sum_turnover ?>');
  var chart_sum_receive = jQuery.parseJSON('<?= $chart_sum_receive ?>');

  const myChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{
          label: 'รวมยอดเครดิตที่คืนให้ลูกค้า',
          data: chart_sum_turnover,
          backgroundColor: [
            'rgba(49, 140, 247, 1)',
          ],
          borderColor: [
            'rgba(49, 140, 247, 1)',
          ],
          borderWidth: 2,
          pointRadius: [0, 4, 4, 4, 4, 4, 4],
          hoverPointRadius: [0, 4, 4, 4, 4, 4, 4]
        },
        {
          label: 'ยอดที่ลูกค้ากดรับเครดิต',
          data: chart_sum_receive,
          backgroundColor: [
            '#FFA829',
          ],
          borderColor: [
            '#FFA829',
          ],
          borderWidth: 2,
          pointRadius: [0, 4, 4, 4, 4, 4, 4],
          hoverPointRadius: [0, 4, 4, 4, 4, 4, 4]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      plugins: {
        legend: {
          align: 'start',
          labels: {
            boxWidth: 20,
            boxHeight: 1
          }

        },
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            borderDash: [5, 15],
          },
          title: {
            display: true,
            text: 'ยอดรวม',
            align: 'center',
          },
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