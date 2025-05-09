<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'football_history'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$current_user = User::getCurrentUserID();

if ($_POST) {
  if (isset($_POST['submit_detail_sbo'])) {
    unset($_POST['submit_detail_sbo']);
    $result =  nga_api_seamless_sbobet::getQueryReplay($code, $_POST['id_sbo']);
    if ($result['message'] == 'Success') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $_POST['user_id'],
        'action' => 'edit_user',
        'detail' => 'ดูข้อมูล SBOBET ของลูกค้า (หน้าประวัติการเดิมพันกีฬา)'
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
    echo '<script>window.open("' . $result['data']['url'] . '", "_blank");</script>';
  } else {
    if (isset($result)) {
      $response_message = isset($response_message) ? $response_message : $result['response_message'];
      $response_status = $result['response_status'] ? 'success' : 'error';
      $response_redirect = isset($response_redirect) ? $response_redirect : '';

      Aww::notification($response_message, $response_status);
      Aww::redirect($response_redirect);
    }
  }
}


$result_table_options = [
  [
    'value' => 'win',
    'text' => 'ชนะ'
  ],
  [
    'value' => 'half_win ',
    'text' => 'ชนะครึ่งเดียว'
  ],
  [
    'value' => 'draw',
    'text' => 'เสมอ'
  ],
  [
    'value' => 'half_lose',
    'text' => 'แพ้ครึ่งเดียว'
  ],
  [
    'value' => 'lose',
    'text' => 'แพ้'
  ],
];

$status_table_options = [
  [
    'value' => 'waiting',
    'text' => 'รอดำเนินการ'
  ],
  [
    'value' => 'running ',
    'text' => 'กำลังดำเนินการ'
  ],
  [
    'value' => 'rejected',
    'text' => 'บิลถูกปฏิเสธ'
  ],
  [
    'value' => 'cancelled',
    'text' => 'ยกเลิก'
  ],
  [
    'value' => 'done',
    'text' => 'รายการเสร็จสิ้น'
  ],
];

$key_type = [
  'thailotto' => 'หวยไทย',
  'laolotto' => 'หวยลาว',
  'hanoylotto' => 'หวยฮานอย',
  'hanoylottovip' => 'หวยฮานอย(วีไอพี)',
  'baaclotto' => 'หวย ธกส.',
  'gsblotto' => 'ออมสิน',
  'pingponglotto' => 'หวยปิงปอง',
  'laoslotto_set' => 'หวยลาว(แบบชุด)',
  'yeekeelotto' => 'หวยยี่กี',
  'malaylotto' => 'หวยมาเลย์',
  'hanoylotto_set' => 'หวยฮานอย(แบบชุด)',
  'hanoylottovip_set' => 'หวยฮานอยวีไอพี(แบบชุด)',
  'hanoylottospecial_set' => 'หวยฮานอยพิเศษ(แบบชุด)',
  'malaylotto_set' => 'หวยมาเลย์(แบบชุด)',
  'hanoylottospecial' => 'หวยฮานอย(พิเศษ)',
  'stockkorea' => 'หวยหุ้นเกาหลี',
  'stockchina' => 'หวยหุ้นจีน',
  'stockdowjones' => 'หวยหุ้นดาวโจนส์',
  'stocktaiwan' => 'หวยหุ้นไต้หวัน',
  'stockengland' => 'หวยหุ้นอังกฤษ',
  'stockindia' => 'หวยหุ้นอินเดีย',
  'stockhangseng' => 'หวยหุ้นฮั่งเส็ง',
  'stockegypt' => 'หวยหุ้นอียิปต์',
  'stocknikkei' => 'หวยหุ้นนิเคอิ',
  'stocksingapore' => 'หวยหุ้นสิงค์โปร',
  'stockthai' => '	หวยหุ้นไทย',
  'stockgerman' => 'หวยหุ้นเยอรมัน',
  'stockrussia' => 'หวยหุ้นรัสเซีย',
  'stock' => 'รวบหวยหุ้น(ใช้ประเภทนี้ในการตั้งค่าเท่านั้น)',
];
$key_bet_type = [
  'top6' => '6 ตัวบน',
  'top5' => '5 ตัวบน',
  'top4' => '4 ตัวบน',
  'top3' => '3 ตัวบน',
  'top2' => '2 ตัวบน',
  'top1' => '1 ตัวบน',
  'bottom1' => '1 ตัวล่าง',
  'bottom2' => '2 ตัวล่าง',
  'bottom3' => '3 ตัวล่าง',
  'row4' => '4 ตัวโต๊ด',
  'row3' => '3 ตัวโต๊ด',
  'row2' => '2 ตัวโต๊ด',
  'back2' => '2 ตัวหลัง',
  'front2' => '2 ตัวหน้า',
  'lottoset' => 'หวยชุด',
];

$type_lotto_played = [];
foreach ($key_type as $key => $value) {
  $type_lotto_played[] = [
    'value' => $key,
    'text' => $value
  ];
}
$type_bet_played = [];
foreach ($key_bet_type as $key => $value) {
  $type_bet_played[] = [
    'value' => $key,
    'text' => $value
  ];
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

  <div class=' bg-card mb-10px pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">

      <div class="msg col-lg-6">
        <div class='topic ml-10px'>
          ประวัติการเดิมพันกีฬา </div>
        <div class="font-14px text-sub ml-10px">
          ข้อมูลรายละเอียดประวัติการเดิมพันกีฬา
        </div>
      </div>
    </div>

  </div>
  <div class="bg-white">
    <div id="sport_played_all_user" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('sport_played_all_user', '?c=' . $code, '', '') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วันที่เล่นเกม</th>
              <th nowrap>เวลาที่เล่นเกม</th>
              <th nowrap>Username</th>
              <th nowrap>เกม</th>
              <th nowrap>เลขบิล</th>
              <th nowrap>ยอดเล่น</th>
              <th nowrap class="thin-cell">ได้/เสีย</th>
              <th nowrap class="thin-cell">สถานะ</th>
              <th nowrap class="thin-cell"></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

  </div>
</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>