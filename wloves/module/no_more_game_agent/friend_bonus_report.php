<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'friend_bonus_report'];
require_once '../../.framework/import.php';
$code = $_GET['c'];

if (isset($_GET['date'])) {
  $get_date = $_GET['date'];
  $seperate_date = explode(' - ', $get_date);
  $from_date = isset($seperate_date[0]) ? $seperate_date[0] : Util::getSystemDate('-' . 7 . ' days');
  $to_date = isset($seperate_date[1]) ? $seperate_date[1] : Aww::formatDate('', 'Y-m-d');
  $from_date_replace = str_replace('/', '-', $from_date);
  $to_date_replace = str_replace('/', '-', $to_date);
  $from_date_2 = Aww::formatDate($from_date_replace, 'Y-m-d');
  $to_date_2 = Aww::formatDate($to_date_replace, 'Y-m-d');
} else {
  $from_date_2 = Util::getSystemDate('-' . 7 . ' days');
  $to_date_2 = Aww::formatDate('', 'Y-m-d');
  $from_date = Aww::formatDate(Util::getSystemDate('-' . 7 . ' days'), 'd/m/Y');
  $to_date = Aww::formatDate('', 'd/m/Y');
}
$date_input = $from_date_2 . ' to ' . $to_date_2;

$sum_downline_com = nga_statistic::getSummaryUserDownlineCommission($code, $from_date_2, $to_date_2);
$user_top_commission = isset($sum_downline_com['user_top_commission']) ? $sum_downline_com['user_top_commission'] : [];

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

  <div class="bg-w">
    <div class='pb-15px'>
      <div class="pt-10px px-15px d-flex justify-content-between">
        <div class="d-flex align-items-center">
          <div class="cursor-pointer" onclick="showContent();">
            <div class="icon_up_summary">
              <?= file_get_contents('./assets/icon/icon-up-blue.svg') ?>
            </div>
            <div class="icon_down_summary" style="display:none;">
              <?= file_get_contents('./assets/icon/icon-down-hide.svg') ?>
            </div>
          </div>
          <div class="ml-10px">
            <div class="font-18px font-Bold  ">รายงานโบนัสจากการชวนเพื่อน</div>
            <div class="font-14px text-sub ">
              สรุปยอดโบนัสจากการชวนเพื่อน, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
            </div>
          </div>
        </div>
        <div class="">
          <form method="get" id="form_event_date_range">
            <?= TiwForm::normal('daterange', $date_input, ['name' => 'date', 'class' => 'input-control border-0 event_date_range w-250px'], []); ?>
            <input type="hidden" name="c" value="<?= $code; ?>">
          </form>
        </div>
      </div>
    </div>
    <div id="content">
      <div class="form-row">
        <div class="col-lg-6 px-15px">
          <div class="form-row">
            <div class="col-lg-6 pr-5px">
              <div class="border-round">
                <div class="topic font-Bold">
                  จำนวนทั้งหมด
                </div>
                <div class="text-center">
                  <div class="pb-5px">
                    <span class="font-Bold font-30px text-black"><?= number_format($sum_downline_com['count_user'], 0); ?> </span>
                  </div>
                  คน
                </div>
              </div>
            </div>

            <div class="col-lg-6 pl-5px">
              <div class="border-round">
                <div class="topic font-Bold">
                  ยอดรับรวม
                </div>
                <div class="text-left">
                  <div class="pb-5px">
                    <span class="font-Bold font-30px text-primary"><?= number_format($sum_downline_com['sum_commission'], 2); ?> </span>บาท
                  </div>
                  จากจำนวนทั้งหมด <span class="text-primary font-SemiBold"> <?= number_format($sum_downline_com['count_user'], 0); ?></span> คน
                </div>
              </div>
            </div>
            <div class="pb-10px col-lg-12"></div>
            <div class="col-lg-6 pr-5px">
              <div class="border-round">
                <div class="topic font-Bold">
                  รับไปแล้วทั้งหมด
                </div>
                <div class="text-left ">
                  <div class="pb-5px">
                    <span class="font-Bold font-30px text-success"><?= number_format($sum_downline_com['sum_commission_received'], 2); ?> </span>
                  </div>
                  จากยอดทั้งหมด <span class=" font-SemiBold text-primary"><?= number_format($sum_downline_com['sum_commission'], 2); ?> </span>บาท
                </div>
              </div>
            </div>

            <div class="col-lg-6 pl-5px">
              <div class="border-round">
                <div class="topic font-Bold">
                  ยอดคงค้าง
                </div>
                <div class="text-left">
                  <div class="pb-5px">
                    <span class="font-Bold font-30px text-warning"><?= number_format($sum_downline_com['sum_commission_outstanding'], 2); ?> </span>บาท
                  </div>
                  จากยอดทั้งหมด <span class="font-SemiBold text-primary"><?= number_format($sum_downline_com['sum_commission'], 2); ?> </span>บาท
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 px-15px">
          <div class="border-round px-0">
            <div class="font-Bold px-15px">
              สายแนะนำที่มียอดรับสะสมสูงสุด
            </div>
            <table class="table p-100 table-in-card-1  mt-10px border-none  ">
              <thead>
                <tr class="bg-greys">
                  <th>ชื่อหัวสาย</th>
                  <th class="text-right">ยอดรวม</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($user_top_commission as $key => $user_commission) {
                  $key_id = $key + 1;
                  if ($key_id == 1) {
                ?>
                    <tr>
                      <td class="font-SemiBold"><?= $user_commission['upline_bank_name']; ?></td>
                      <td class="text-right text-success font-SemiBold"><?= number_format($user_commission['money_upline_receive'], 2); ?></td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td class="font-SemiBold"><?= $user_commission['upline_bank_name']; ?></td>
                      <td class="text-right font-SemiBold"><?= number_format($user_commission['money_upline_receive'], 2); ?></td>
                    </tr>
                <?php }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div id="friend_bonus_report" class="container-pagination bg-w  no-border-radius pt-15px" <?= Homepagify::createHomepagify('friend_bonus_report', '?c=' . $code . '&from_date=' . $from_date_2 . '&to_date=' . $to_date_2, '', 'รายการ') ?>>
      <div class="table-responsive">
        <table class="table table-striped-2 table-sort table-search">
          <thead>
            <tr>
              <th nowrap></th>
              <th nowrap class="thin-cell"> ยอดรับรวม </th>
              <th nowrap class="thin-cell"> รับไปแล้วทั้งหมด </th>
              <th nowrap class="thin-cell"> ยอดรอรับทั้งหมด </th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>

  </div>


  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>
<?php Aww::loadAsset('assets/js/force_logout.js'); ?>

<script>
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

  function showContent() {
    var content = document.getElementById("content");
    var table = document.getElementById("friend_bonus_report");
    var icon_show = document.getElementsByClassName("icon_up_summary");
    var icon_hide = document.getElementsByClassName("icon_down_summary");
    if (content.style.display === "none") {
      content.style.display = "block";
      table.style.display = "block";
      icon_show[0].style.display = "block";
      icon_hide[0].style.display = "none";
    } else {
      content.style.display = "none";
      table.style.display = "none";
      icon_show[0].style.display = "none";
      icon_hide[0].style.display = "block";
    }
  }
</script>

</html>