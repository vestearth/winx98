<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'history_admin_report'];
require_once '../../.framework/import.php';

$code = $_GET['c'];

if (isset($_GET['submit_clear_summary'])) {
  $from_date = Util::getSystemDate('-' . 7 . ' days');
  $to_date = Aww::formatDate('', 'Y-m-d');
  $get_admin = '';
  $get_work_list = [];
  $work_list_api = 'none';
} else {
  $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : Util::getSystemDate('-' . 7 . ' days');
  $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : Aww::formatDate('', 'Y-m-d');
  $get_admin = isset($_GET['admin_id']) ? $_GET['admin_id'] : '';
  $get_work_list = isset($_GET['work_list']) ? $_GET['work_list'] : [];
  $work_list_api = base64_encode(json_encode($get_work_list));
}

$bot_summary = nga_statistic::getSummaryBotTransferMoney($code);

$options_user = [
  'selected_fields' => ['id', 'username'],
];
$call_admin_list = User::selectUser('dvjdb', [], $options_user);
$admin_list['list'] = [
  // 'value' => '',
  // 'name' => 'เลือก'
];

foreach ($call_admin_list as $admin_data_list) {
  $admin_list['list'][] = [
    'value' => $admin_data_list['id'],
    'name' => $admin_data_list['username'],
  ];
}

$status_action_options = [
  [
    'value' => 'login',
    'text' => 'เข้าใช้งานระบบ',
  ],
  [
    'value' => 'add_deposit',
    'text' => 'ทำรายการฝากมือ',
  ],
  [
    'value' => 'add_withdraw',
    'text' => 'ทำรายการถอนมือ',
  ],
  [
    'value' => 'edit_user',
    'text' => 'แก้ไขข้อมูลลูกค้า',
  ],
  [
    'value' => 'edit_self',
    'text' => 'แก้ไขข้อมูลตนเอง',
  ],
  [
    'value' => 'add_user',
    'text' => 'สมัครให้ลูกค้า',
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

  <div class="bg-w mb-10px">
    <div class="d-flex align-items-center">
      <div class="px-15px py-10px">
        <div class="font-16px font-Bold text-header">การเข้าใช้งานระบบของแอดมิน</div>
      </div>
    </div>
    <div id="summary_login_admin" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('summary_login_admin', '?c=' . $code, '', '') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">Admin</th>
              <th nowrap data-sort="full_name" data-filter="<?= Homepagify::dataFilter('full_name', 'text') ?>">ชื่อ</th>
              <th nowrap data-sort="transaction_date">เข้าใช้ระบบล่าสุด</th>
              <th nowrap>IP</th>
              <th nowrap>จำนวนครั้งฝากการฝากมือ</th>
              <th nowrap>จำนวนครั้งถอนมือ</th>
              <th nowrap>จำนวนครั้งการแก้ไขข้อมูลลูกค้า</th>
              <th nowrap>จำนวนครั้งการแก้ไขข้อมูลตนเอง</th>
              <th nowrap>จำนวนครั้งการสมัครให้ลูกค้า</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <div class="bg-w pb-15px">
    <div class="px-15px py-10px">
      <div class="d-flex align-items-center">
        <div class="ml-10px">
          <div class="font-18px font-Bold text-header">รายงานประวัติการใช้งานของแอดมิน</div>
          <div class="font-14px text-sub ">
            บันทึกการเข้าใช้งานระบบของแอดมิน รวมถึงรายละเอียดการใช้งาน
          </div>
        </div>
      </div>
    </div>
    <hr class="my-0">
    <div class="d-flex align-items-center px-15px py-10px">
      <div class="cursor-pointer">
        <div class="icon_up_filter">
          <?= file_get_contents('./assets/icon/icon-up-blue.svg') ?>
        </div>
        <div class="icon_down_filter" style="display:none;">
          <?= file_get_contents('./assets/icon/icon-down-hide.svg') ?>
        </div>
      </div>
      <div class="ml-10px">
        <div class="font-16px font-Bold font-italic text-header">ตัวกรองผลข้อมูล</div>
      </div>
    </div>
    <div class="date_filter capsule_sky font-14px font-Medium ml-45px w-207px" style="display: none;"><?= Aww::formatDate($from_date, 'd/m/Y'); ?> - <?= Aww::formatDate($to_date, 'd/m/Y'); ?> <span class="cursor-pointer ml-10px"><?= file_get_contents('assets/icon/icon-close-red.svg') ?></span></div>
    <form method="get" action="?c=<?= $code ?>">
      <div class="row mb-10px px-15px py-10px filter_event ">
        <div class="col-xl-6 col-lg-5">
          <div class="row">
            <div class="col-sm-3">
              <div class="mt-7px">ข้อมูลตั้งแต่วันที่</div>
            </div>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-12">
                  <div class="d-flex">
                    <div>
                      <?= TiwForm::normal('date', $from_date, ['name' => 'from_date', 'class' => 'w-200px']) ?>
                    </div>
                    <div class="mx-10px mt-5px">-</div>
                    <div>
                      <?= TiwForm::normal('date', $to_date, ['name' => 'to_date', 'class' => 'w-200px']) ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="mt-7px">แอดมิน</div>
            </div>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-12">
                  <div class="d-flex">
                    <div class="min-w-200px">
                      <?= TiwForm::normal('select', $get_admin, ['name' => 'admin_id', 'placeholder' => 'กรอก'], $admin_list) ?>
                    </div>
                  </div>
                </div>
                <div class="col-12 mt-10px">
                  <div class="d-flex">
                    <button type="submit" name="submit_search_summary" class="btn btn-warning mr-5px w-100px">ค้นหา</button>
                    <button type="submit" name="submit_clear_summary" class="btn btn-close-modal w-70px scope_btn_clear_search">ล้าง</button>
                    <input type="hidden" name="c" value="<?= $code ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-lg-7">
          <div class="row">
            <div class="col-sm-3">
              <div class="mt-7px">หัวข้อการทำงาน</div>
            </div>
            <div class="col-sm-9">
              <div class="row">
                <div class="col-md-3">
                  <div class="mt-7px">
                    <?php
                    $isCheckedAll = false;
                    if (count($get_work_list) == count($status_action_options)) {
                      $isCheckedAll = true;
                    }
                    ?>
                    <?= TiwForm::normal('checkbox', 'All', ['name' => '', 'class' => 'event_work_check_all', 'checked' => ($isCheckedAll) ? true : false], ['style' => '3', 'label' => 'ทั้งหมด']); ?>
                  </div>
                </div>
                <?php
                $isChecked = false;
                foreach ($status_action_options as $work_list) {
                  $isChecked = in_array($work_list['value'], $get_work_list) ? true : false;
                ?>
                  <div class="col-md-3">
                    <div class="mt-7px text-nowrap">
                      <?= TiwForm::normal('checkbox', $work_list['value'], ['name' => 'work_list[]', 'class' => 'work_list', 'checked' => ($isChecked) ? true : false], ['style' => '3', 'label' => $work_list['text']]); ?>
                    </div>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
  <div class="bg-white mt-10px">
    <div class="px-15px py-10px">
      <div class="font-16px font-Bold text-header">รายงานประวัติการทำรายการของแอดมิน</div>
    </div>
    <div id="summary_work_admin" class="container-pagination bg-w  no-border-radius" <?= Homepagify::createHomepagify('summary_work_admin', '?c=' . $code . '&from_date=' . $from_date . '&to_date=' . $to_date . '&admin_id=' . $get_admin . '&work_list_data=' . $work_list_api, '', 'รายการ') ?>>
      <div class="table-responsive">
        <table class="table table-striped-2">
          <thead>
            <tr>
              <th class="thin-cell" nowrap>วันที่,เวลาทำรายการ</th>
              <th class="thin-cell" nowrap>ยูสแอดมิน</th>
              <th class="thin-cell" data-sort="action" nowrap>หัวข้อการใช้งาน</th>
              <th class="thin-cell" data-sort="ip" data-filter="<?= Homepagify::dataFilter('ip', 'text') ?>" nowrap>IP</th>
              <th class="thin-cell" data-sort="user_username" data-filter="<?= Homepagify::dataFilter('user_username', 'text') ?>" nowrap>ยูสลูกค้า</th>
              <th class="thin-cell" nowrap>รายละเอียด</th>
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
  $(document).ready(function() {
    $(document).on('change', '.event_work_check_all input', function() {
      if ($(this).is(':checked')) {
        $('.work_list input').prop('checked', true);
      } else {
        $('.work_list input').prop('checked', false);
      }
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



</html>