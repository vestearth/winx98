<?php

$_PAGE['permission'] = ['no_more_game_agent', 'agent', 'agent'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$agent_lv1 = nga_agent::getSummaryAgent($code);
$downline_list = isset($agent_lv1['downline_list']) ? $agent_lv1['downline_list'] : [];

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


$status_list = [
  [
    'value' => 'All',
    'text' => 'All'
  ],
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
  <div class="bg-whites pt-10px mb-1px">
    <div class="form-row px-15px ">
      <div class="col-lg-3 ">
        <div class="mb-10px">
          <div class="card-header-primary py-10px  font-SemiBold font-14px">
            พันธมิตร LV.1
          </div>
          <div class="card-white px-15px py-10px font-Medium h-210px">
            <div class="text-center">
              <div class="font-60px text-black"> <?= number_format($agent_lv1['downline_count']); ?></div>
              <div class="text-sub">ราย</div>
            </div>
            <div class="border-top-1 mt-10px pt-5px">
              <?php foreach ($downline_list as $downline) {
                if ($downline['total_income'] > 0) {
                  $class_colour = 'text-success';
                } else {
                  $class_colour = 'text-danger';
                } ?>
                <?= Phase_2($downline['agent_name'], 6, number_format($downline['total_income'], 2) . ' บาท', '', $class_colour . ' text-right') ?>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <div class="mb-10px">
          <div class="card-header-primary py-10px  font-SemiBold font-14px">
            รวมรายได้จากพันธมิตร
          </div>
          <div class="card-white px-15px py-10px font-Medium  h-210px">
            <div class="text-center">
              <?php
              if ($agent_lv1['today_income'] > 0) {
                $class_colour = 'text-success';
              } else {
                $class_colour = 'text-danger';
              } ?>
              <div class="font-60px <?= $class_colour; ?>">
                <?= ($agent_lv1['today_income'] > 0) ? '+' : ''; ?>
                <?= number_format($agent_lv1['today_income'], 2); ?>
              </div>
              <div class="text-sub">บาท</div>
            </div>
            <div class="border-top-1 mt-10px pt-5px text-center">
              <div class="text-vertical-center my-20px">
                <?php
                if ($agent_lv1['income_compare_yesterday_percent'] > 0) {
                  $percent_class_colour = 'text-success';
                  $text_update = 'เพิ่มขึ้น';
                } else {
                  $percent_class_colour = 'text-danger';
                  $text_update = 'ลดลง';
                } ?>
                <?= $text_update; ?> <span class="<?= $percent_class_colour; ?>"><?= number_format($agent_lv1['income_compare_yesterday_percent'], 0); ?>%</span> จากเมื่อวานนี้</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class='bg-white pb-10px border-bottom'>
    <div class="d-flex top-tap justify-content-between  pt-10px">
      <div class="msg col-lg-6">
        <div class='topic'>
          พันธมิตร </div>
        <div class="font-14px text-sub ">
          รายการสรุปข้อมูลและจัดการพันธมิตรของระบบ
        </div>
      </div>
    </div>
  </div>

  <div id="agent" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('agent', '?c=' . $code, '', 'พันธมิตร ') ?>>
    <div class="table-responsive">
      <table class="table table-striped-2">
        <thead>
          <tr>
            <th class="col-2" nowrap>พันธมิตร</th>
            <th class="text-right" nowrap>จำนวนยูสเซอร์</th>
            <th class="text-right" nowrap>ฝากครั้งเเรก</th>
            <th class="text-right" nowrap>ยอดแพ้</th>
            <th class="text-right" nowrap>พันธมิตร</th>
            <th class="text-right" nowrap>แบ่งเปอร์เซ็นต์ (%)</th>
            <th class="text-right" nowrap>รายได้สุทธิ</th>
            <th nowrap>หมายเหตุ</th>
            <th nowrap></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>


  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php
  Structure::loadFooter('../../');
  Aww::loadAsset('assets/js/force_logout.js');
  ?>


</body>


</html>