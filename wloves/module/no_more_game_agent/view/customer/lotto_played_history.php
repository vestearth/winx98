<?php

$status_lotto = [
  [
    'value' => 'payout',
    'text' => 'ออกผลแล้ว'
  ],
  [
    'value' => 'pending',
    'text' => 'รอผล'
  ],
  // [
  //   'value' => 'success',
  //   'text' => 'ได้รางวัล'
  // ],
  [
    'value' => 'cancel',
    'text' => 'ยกเลิก'
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
<div class='bg-white mb-1px pb-10px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">
    <div class="msg col-lg-6">
      <div class='topic ml-10px'>
        ประวัติการเล่นหวย </div>
      <div class="font-14px text-sub ml-10px">
        ข้อมูลรายละเอียดประวัติการเล่นหวย
      </div>
    </div>
  </div>
</div>
<div class="bg-white">
  <div id="lotto_played" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('lotto_played', '?c=' . $code . '&user_id=' . $customer_data['id'], '', '') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="bet_date_time" data-filter="<?= Homepagify::dataFilter('bet_date', 'date') ?>">วันที่เล่นหวย</th>
            <th nowrap>เวลาที่เล่น</th>
            <th nowrap data-sort="lotto_type" data-filter="<?= Homepagify::dataFilter('lotto_type', 'select', $type_lotto_played) ?>">ประเภท</th>
            <th nowrap data-sort="bet_type" data-filter="<?= Homepagify::dataFilter('bet_type', 'select', $type_bet_played) ?>">รางวัล</th>
            <th nowrap data-sort="bet_number" data-filter="<?= Homepagify::dataFilter('bet_number', 'text') ?>">เลขหวย</th>
            <th nowrap data-sort="bet_amount" data-filter="<?= Homepagify::dataFilter('bet_amount', 'text') ?>">ยอดเดิมพัน</th>
            <th class="th-right" nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_lotto) ?>">สถานะ</th>
            <th nowrap class="thin-cell">ได้/เสีย</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>