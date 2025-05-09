<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'promotion_summary_report'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
if (isset($_GET['date'])) {
  $year_month = $_GET['date'];
  $year_data = Aww::formatDate($year_month, 'Y');
  $month_data = Aww::formatDate($year_month, 'm');

  // อันนี้เท่กว่า 
  // $year_data = substr($year_month, 0, 4);
  // $month_data = substr($year_month, 5, 2);

} else {
  $year_month = date('Y-m');
  $year_data = date('Y');
  $month_data = date('m');
}

if (isset($_GET['submit_clear_summary'])) {
  $from_date = Util::getSystemDate('-' . 7 . ' days');
  $to_date = Aww::formatDate('', 'Y-m-d');
} else {
  $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : Util::getSystemDate('-' . 7 . ' days');
  $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : Aww::formatDate('', 'Y-m-d');
}

$formula_type = isset($_GET['formula_type_id']) ? $_GET['formula_type_id'] : '';
if (isset($_GET['promotion_id'])) {
  if (in_array($formula_type, ['birthday', 'special_day', 'monthly_day', 'dftd_bronze_silver', 'dftd_gold_diamond', 'dftd_con', 'dftd_vip_vvip'])) {
    if ($formula_type == 'birthday') {
      $calculate_type = -1;
    } else if ($formula_type == 'special_day') {
      $calculate_type = -2;
    } else if ($formula_type == 'monthly_day') {
      $calculate_type = -3;
    } else if ($formula_type == 'dftd_bronze_silver') {
      $calculate_type = -4;
    } else if ($formula_type == 'dftd_gold_diamond') {
      $calculate_type = -5;
    } else if ($formula_type == 'dftd_con') {
      $calculate_type = -6;
    } else if ($formula_type == 'dftd_vip_vvip') {
      $calculate_type = -7;
    }
  } else {
    $calculate_type = isset($_GET['promotion_id']) ? $_GET['promotion_id'] : '';
  }
} else {
  $where = [
    'calculate_type' => 'invite_friend'
  ];
  $result = nga_management::selectPromotion($code, $where);
  if (in_array($formula_type, ['birthday', 'special_day', 'monthly_day', 'dftd_bronze_silver', 'dftd_gold_diamond', 'dftd_con', 'dftd_vip_vvip'])) {
    if ($formula_type == 'birthday') {
      $calculate_type = -1;
    } else if ($formula_type == 'special_day') {
      $calculate_type = -2;
    } else if ($formula_type == 'monthly_day') {
      $calculate_type = -3;
    } else if ($formula_type == 'dftd_bronze_silver') {
      $calculate_type = -4;
    } else if ($formula_type == 'dftd_gold_diamond') {
      $calculate_type = -5;
    } else if ($formula_type == 'dftd_con') {
      $calculate_type = -6;
    } else if ($formula_type == 'dftd_vip_vvip') {
      $calculate_type = -7;
    }
  } else if ($result) {
    $calculate_type = $result[0]['id'];
  } else {
    $calculate_type = '';
  }
}
$get_promotion = nga_management::getPromotionByID($code, $calculate_type);


$formula_type_options = [
  'list' => [
    [
      'value' => 'invite_friend',
      'name' => 'ชวนเพื่อน',
    ],
    [
      'value' => 'deposit',
      'name' => 'มียอดฝาก',
    ],
    [
      'value' => 'excess_lost',
      'name' => 'มียอดเสีย',
    ],
    [
      'value' => 'play_game',
      'name' => 'เข้าเล่นเกม',
    ],
    [
      'value' => 'new_user',
      'name' => 'สมัครสมาชิกใหม่',
    ],
    [
      'value' => 'birthday',
      'name' => 'โปรโมชั่นวันเกิด',
    ],
    [
      'value' => 'special_day',
      'name' => 'โปรโมชั่นวันพิเศษ',
    ],
    [
      'value' => 'monthly_day',
      'name' => 'โปรโมชั่นรับโชครายเดือน',
    ],
    [
      'value' => 'dftd_bronze_silver',
      'name' => 'โปรโมชั่นฝากแรกของวัน (แรงค์ Bronze-Silver)',
    ],
    [
      'value' => 'dftd_gold_diamond',
      'name' => 'โปรโมชั่นฝากแรกของวัน (แรงค์ Gold Diamond)',
    ],
    [
      'value' => 'dftd_con',
      'name' => 'โปรโมชั่นฝากแรกของวัน (แรงค์ Con)',
    ],
    [
      'value' => 'dftd_vip_vvip',
      'name' => 'โปรโมชั่นฝากแรกของวัน (แรงค์ VIP-VVIP)',
    ],
  ],
];
$promotion_summary = nga_statistic::getSummaryPromotion($code, $year_month);
$promotion = isset($promotion_summary['promotion']) ? $promotion_summary['promotion'] : [];
$popular_promotion = isset($promotion_summary['popular_promotion']) ? $promotion_summary['popular_promotion'] : [];

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
        <div class="d-flex align-items-center  justify-content-between">
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
              <?php
              $month = Aww::formatMonthNameTH($month_data);
              $year = $year_data + 543;
              $full_date = $month . ', ' . $year;
              ?>
              <div class="font-18px font-Bold text-header ">รายงานสรุปผลแยกตามโปรโมชั่น (อัตโนมัติ) | <span class="text-primary"><?= $full_date ?></span> </div>
              <div class="font-14px text-sub ">
                สรุปผลแยกตามโปรโมชั่นของคุณ, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
              </div>
            </div>
          </div>
          <div class="date-range  max-w-200px w-100">
            <form method="get" id="form_event_month_select" class="">
              <?= TiwForm::normal('month', $year_month, ['name' => 'date', 'class' => 'event_month_select'], []); ?>
              <input type="hidden" name="c" value="<?= $code; ?>">
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row px-15px summary_event">
      <div class="col-lg-4">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            โปรโมชั่นที่มี
          </div>
          <div class=" font-Medium">
            <div class="font-15px">
              <span class="font-30px font-Bold text-primary"><?= number_format($promotion['count_all']); ?> </span>โปรโมชั่น
            </div>
            <div class="font-15px">
              ใช้ได้ <span class="text-success"><?= number_format($promotion['can_use']); ?></span> | หมดแล้ว <span class="text-danger"><?= number_format($promotion['can_not_use']); ?></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            โปรโมชั่นที่มีคนร่วมมากที่สุด
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-7  my-auto">
                  <div class=" font-24px font-Bold text-header text-ellipsis-430px"><?= $popular_promotion['promotion_name']; ?></div>
                </div>
                <div class="col-5 border-left">
                  <div class="font-30px font-Bold "><span class="text-success"><?= number_format($popular_promotion['user_count']); ?></span> <span class="font-15px font-Medium">ราย</span> </div>
                </div>
                <div class="col-12">
                  <div class="font-15px"><span class="font-Medium">สูตรการคำนวณ </span>
                    <?php
                    $name = '';
                    foreach ($formula_type_options['list'] as $check_type) {
                      if ($check_type['value'] == $popular_promotion['calculate_type']) {
                        $name = $check_type['name'];
                      }
                    ?>
                    <?php } ?>
                    <span class="font-Bold text-primary">
                      <?= $name; ?>
                      <span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php /* 
      <div class="col-lg-5">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            โปรโมชั่นทำกำไรสะสมต่ำสุด
          </div>
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-7  my-auto">
                  <div class=" font-24px font-Bold text-header text-ellipsis-230px">ฝาก 20,000 ขึ้นไป รับ</div>
                </div>
                <div class="col-5 border-left">
                  <div class="font-30px font-Bold "><span class="text-danger">32</span> <span class="font-15px font-Medium">ราย</span> </div>
                </div>
                <div class="col-12">
                  <div class="font-15px"><span class="font-Medium">สูตรการคำนวณ </span> <span class="font-Bold text-primary">มียอดฝาก<span></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      */ ?>
      <div class="col-lg-3 col-md-6">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            แจกเครดิตไปแล้วทั้งหมด
          </div>
          <div class="font-Medium">
            <div class="font-15px">
              <span class="font-30px font-Bold text-primary"><?= number_format($promotion_summary['credit_received'], 2); ?> </span> บาท
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="mb-10px border-round">
          <div class=" font-Bold font-16px text-header">
            แจกแต้มไปแล้วทั้งหมด
          </div>
          <div class="font-Medium">
            <div class="font-15px">
              <span class="font-30px font-Bold text-primary"><?= number_format($promotion_summary['point_received'], 2); ?> </span> แต้ม
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <form method="GET">
    <div class="bg-w px-15px py-10px pb-15px">
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
          <div class="font-16px font-Bold text-header font-italic mb-10px">ตัวกรองผลข้อมูล</div>
        </div>
      </div>
      <div class="row filter_event mt-10px">
        <div class="col-lg-7">
          <div class="row mb-10px">
            <div class="col-sm-3">
              <div class="mt-7px">เลือกสูตรการคำนวณ</div>
            </div>
            <div class="col-sm-9">
              <?= TiwForm::normal('select', $formula_type, ['name' => 'formula_type_id', 'class' => 'event_select_formula'], $formula_type_options) ?>
            </div>
          </div>
          <div class="row mb-10px event_hide_extra">
            <div class="col-sm-3">
              <div class="mt-7px">เลือกโปรโมชั่น</div>
            </div>
            <div class="col-sm-9 ">
              <div class="scope_promotion_list">
                <?php
                $options = [
                  'list' => [
                    [
                      'value' => '',
                      'name' => ''
                    ]
                  ]
                ]
                ?>
                <?= TiwForm::normal('select', '', ['name' => 'promotion_id', 'class' => ''], $options)
                ?>
              </div>
            </div>
          </div>
          <div class="row mb-10px">
            <div class="col-sm-3">
              <div class="mt-7px">แสดงผลตามวันที่</div>
            </div>
            <div class="col-sm-9">
              <div class="d-flex">
                <div class="w-100">
                  <?= TiwForm::normal('date', $from_date, ['name' => 'from_date', 'class' => '']) ?>
                  <div class="font-14px text-mute font-italic">วันที่เริ่มต้น</div>
                </div>
                <div class="mx-10px mt-5px">-</div>
                <div class="w-100">
                  <?= TiwForm::normal('date', $to_date, ['name' => 'to_date', 'class' => '']) ?>
                  <div class="font-14px text-mute font-italic">วันที่สิ้นสุด</div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-10px">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
              <div class="d-flex mt-10px">
                <button type="submit" name="submit_search_summary" class="btn btn-warning mr-5px w-100px">ค้นหา</button>
                <button type="submit" name="submit_clear_summary" class="btn btn-close-modal w-70px scope_btn_clear_search">ล้าง</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="c" value="<?= $code ?>">
    <div class="scope_promotion_type"></div>
  </form>
  <div id="promotion_summary_report" class="container-pagination bg-w  no-border-radius filter_event" <?= Homepagify::createHomepagify('promotion_summary_report', '?c=' . $code . '&from_date=' . $from_date . '&to_date=' . $to_date . '&cal_type=' . $calculate_type . '&formula_type=' . $formula_type, '', 'รายการลูกค้าภายใต้เงื่อนไข') ?>>
    <div class="table-responsive">
      <table class="table table-sort  table-striped-2">
        <thead>
          <tr>
            <th class="thin-cell" nowrap data-sort="user_register_date_time">วันที่สมัครสมาชิก</th>
            <th class="thin-cell" nowrap data-sort="user_register_date_time">วันที่รับโปรโมชัน</th>
            <th class="thin-cell" nowrap data-sort="username">รหัสลูกค้า</th>
            <th class="thin-cell" nowrap data-sort="user_bank_name">ชื่อ - สกุล</th>
            <?php if ($formula_type == 'deposit') { ?>
              <th class="thin-cell text-right" nowrap data-sort="deposit_amount">ยอดฝาก</th>
            <?php } else if ($formula_type == 'excess_lost') { ?>
              <th class="thin-cell text-right" nowrap data-sort="current_excess_lost">ยอดเสีย</th>
            <?php } else if ($formula_type == 'play_game') { ?>
              <th class="thin-cell text-right" nowrap data-sort="current_excess_lost">เข้าเล่นเกม (เกม)</th>
            <?php } else if ($formula_type == 'birthday') { ?>
              <th class="thin-cell" nowrap data-sort="current_excess_lost">วันเกิด</th>
            <?php } ?>

            <?php
            if ($get_promotion) {
              if ($get_promotion['type'] == 'point') {
                $text_unit = 'แต้ม';
              } else if ($get_promotion['type'] == 'credit') {
                $text_unit = 'เครดิต';
              } else {
                $text_unit = 'เครดิต';
              }
            } else {
              $text_unit = 'เครดิต/แต้ม';
            }
            ?>
            <th class="thin-cell text-right" nowrap data-sort="credit_point_receive"><?= $text_unit; ?>ที่ได้รับ</th>
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
    //Filter Select เดือน รายการด้านบน 
    $(document).on('change', '.event_month_select', function() {
      $('#form_event_month_select').submit();
    });

    // Filter table ด้านล่าง
    var formula_type = '<?= $formula_type ?>';
    var cal_type = '<?= $calculate_type ?>';
    // jquery in_array 

    if (formula_type == 'birthday' || formula_type == 'special_day' || formula_type == 'monthly_day' || formula_type == 'dftd_bronze_silver' || formula_type == 'dftd_gold_diamond' || formula_type == 'dftd_con' || formula_type == 'dftd_vip_vvip') {
      $('.event_hide_extra').hide();
      $('.scope_promotion_list select').attr('disabled', true);
    } else {
      $('.event_hide_extra').show();
      $('.scope_promotion_list select').attr('disabled', false);
      listPromotions(formula_type, cal_type);
    }
    // listPromotions(formula_type, cal_type);
    $(document).on('change', '.event_select_formula', function() {
      var formula_type = $(this).val();
      if (formula_type == 'birthday' || formula_type == 'special_day' || formula_type == 'monthly_day' || formula_type == 'dftd_bronze_silver' || formula_type == 'dftd_gold_diamond' || formula_type == 'dftd_con' || formula_type == 'dftd_vip_vvip') {
        $('.event_hide_extra').hide();
        $('.scope_promotion_list select').attr('disabled', true);

      } else {
        $('.event_hide_extra').show();
        $('.scope_promotion_list select').attr('disabled', false);
        listPromotions(formula_type, cal_type);
      }
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
    });

    $(document).on('click', '.icon_down_filter', function() {
      $('.filter_event').show();
      $('.icon_down_filter').hide();
      $('.icon_up_filter').show();
    });
  });


  function listPromotions(id, promotion) {
    var params = {
      code: '<?= $code; ?>',
      id: id,
      promotion: promotion,
    };
    $.post('ajax/ajax_select_promotion.php', params)
      .done(function(data) {
        $('.scope_promotion_list').html(data);
      })
  }
</script>



</html>