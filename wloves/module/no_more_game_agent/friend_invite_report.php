<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'friend_invite_report'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$summary_downline = nga_statistic::getSummaryUserDownline($code);
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
  <div class="bg-white">
    <div class='pb-15px'>
      <div class="pt-10px px-15px">
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
            <div class="font-18px font-Bold  ">รายงานสรุปผลการชวนเพื่อน</div>
            <div class="font-14px text-sub ">
              สรุปผลการชวนเพื่อนของลูกค้า, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="content">
      <div class="form-row">
        <div class="col-lg-7 py-15px px-15px">
          <div class="border-round ">
            <div class="font-Bold">ลูกค้าที่ชวนเพื่อนได้มากที่สุด</div>
            <div class="form-row ">
              <div class="col-lg-6">
                <div class="font-24px  font-Bold py-10px">
                  <?= $summary_downline['bank_name']; ?>
                </div>
                <div class="pb-10px text-sub">รหัสลูกค้า: <span class="font-SemiBold"> <?= $summary_downline['username'] ?></span></div>
              </div>
              <div class="col-lg-6">
                <div class="form-row ">
                  <div class="col-lg-6 ">
                    <div class="border-left  pl-15px">
                      <span class="font-30px text-primary font-SemiBold"><?= number_format($summary_downline['count_downline'], 0); ?> </span> ราย
                    </div>
                    <div class="pl-15px">ลูกค้าที่สมัคร</div>
                  </div>
                  <div class="col-lg-6">
                    <div>
                      <span class="font-30px text-success font-SemiBold"><?= number_format($summary_downline['count_downline_deposit_firsttime'], 0); ?> </span> ราย
                    </div>
                    <div>ฝากครั้งแรก</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="friend_invite_report" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('friend_invite_report', '?c=' . $code, '', 'รายการลูกค้าที่มีการชวนเพื่อน') ?>>
      <div class="table-responsive">
        <table class="table table-striped-2 table-sort table-search">
          <thead>
            <tr>
              <th data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
              <th nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อ - สกุล</th>
              <th nowrap data-sort="downline_count" data-filter="<?= Homepagify::dataFilter('downline_count', 'number') ?>">จำนวนลูกค้าที่สมัคร</th>
              <th nowrap nowrap>จำนวนลูกค้าที่ฝากครั้งแรก</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>

  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>


</body>
<?php Aww::loadAsset('assets/js/force_logout.js'); ?>

<script>
  function showContent() {
    var content = document.getElementById("content");
    var table = document.getElementById("friend_invite_report");
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