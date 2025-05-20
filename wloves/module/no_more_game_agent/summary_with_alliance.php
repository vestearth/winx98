<?php
$_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'summary_with_alliance'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$current_user = User::getCurrent();
$id = (isset($_GET['alliance']) && $_GET['alliance']) ? $_GET['alliance'] : '';
$amount = (isset($_GET['amount']) && $_GET['amount']) ? $_GET['amount'] : 1;
$start_date = (isset($_GET['start_date']) && $_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
$end_date = (isset($_GET['end_date']) && $_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');
// $start_month = (isset($_GET['start_date']) && $_GET['start_date']) ? $_GET['start_date'] : date('Y-m-01');
// $end_month = (isset($_GET['end_date']) && $_GET['end_date']) ? $_GET['end_date'] : date('Y-m-t');
// $start_month_where = date('Y-m-01', strtotime($start_month));
// $end_month_where = date('Y-m-t', strtotime($end_month));


if ($current_user['user_type'] == "Alliance") {
  $ally_fixed = nga_management::getAllianceByUserID($code, $current_user['id']);
  $alliance_options = [
    'list' => [
      [
        'value' => $ally_fixed['id'],
        'name' => $ally_fixed['name']
      ],
    ],
  ];
  $id = (isset($_GET['alliance']) && $_GET['alliance']) ? $_GET['alliance'] : $ally_fixed['id'];
} else {
  $where_ally = [
    'is_active' => 1,
  ];
  $alliance_list = nga_management::selectAlliance($code, $where_ally);
  $alliance_options = [
    'list' => [
      [
        'value' => '',
        'name' => 'เลือกการตลาด',
        'disabled' => 'disabled',
      ],
    ],
  ];

  if ($alliance_list) {
    foreach ($alliance_list as $ally) {
      $alliance_options['list'][] = [
        'value' => $ally['id'],
        'name' => $ally['name'],
      ];
    }
  }
}

$status_list = [
  [
    'value' => '1',
    'text' => 'Active'
  ],
  [
    'value' => '0',
    'text' => 'Non Active'
  ],
];

$where = [
  'count_deposit_time' => $amount,
  'first_time_deposit_from_date' => $start_date,
  'first_time_deposit_to_date' => $end_date,
];

if ($id) {
  $where['alliance_id'] = $id;
} else {
  unset($where['alliance_id']);
}

$options = [
  'sum_deposit' => true,
];
$data_list = nga_user::selectUser($code, $where, $options);
$summary = isset($data_list['summary']) ? $data_list['summary'] : [];
$table_list = isset($data_list['list']) ? $data_list['list'] : [];
$slicedArray = array_slice($table_list, 1);
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

  <div class='bg-whites pb-10px mb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px px-15px">
      <div class="msg ">
        <div class='topic'>สรุปแยกตามการตลาด</div>
        <div class="font-14px text-sub">
          ข้อมูลรายละเอียดยอดการตลาด
        </div>
      </div>
    </div>
  </div>
  <?php /* if ($current_user['user_type'] == 'Alliance') { */ ?>

  <div class="bg-whites pt-15px">
    <form method="get">
      <?= TiwForm::normal('hidden', $code, ['name' => 'c']); ?>
      <div class="form-row px-15px ">
        <div class="col-lg-6">
          <div>
            <label class="font-Bold">เลือกการตลาด</label>
            <?php
            TiwForm::normal('select', $id, ['name' => 'alliance'], $alliance_options);
            ?>
          </div>
        </div>
        <div class="col-lg-6">
          <label class="font-Bold">จำนวนครั้งที่ฝาก (มากกว่าหรือเท่ากับ)</label>
          <?= TiwForm::normal('number', $amount, ['name' => 'amount', 'placeholder' => 0, 'min' => 1], []); ?>
        </div>
        <div class="col-lg-4">
          <label class="font-Bold">วันที่เริ่ม</label>
          <?= TiwForm::normal('date', $start_date, ['name' => 'start_date'], []); ?>
        </div>
        <div class="col-lg-4">
          <label class="font-Bold">วันที่สิ้นสุด</label>
          <?= TiwForm::normal('date', $end_date, ['name' => 'end_date'], []); ?>
        </div>
        <div class="col-lg-3 d-flex align-items-center">
          <?= TiwForm::normal('btn', '', ['name' => 'submit_report', 'type' => 'submit', 'class' => 'mt-10px'], ['text' => 'ค้นหา', 'type' => '']); ?>
        </div>
      </div>
    </form>
    <div class="total-list p-15px">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ยอดฝาก</th>
            <th>จำนวนลูกค้า</th>
            <th>ยอดรวม</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($summary as $sum_list) { ?>
            <tr>
              <td>
                <?= ($sum_list['amount'] == '300+') ? 'มากกว่าหรือเท่ากับ 300' : $sum_list['amount']; ?>
              </td>
              <td><?= number_format($sum_list['customer_count'], 0); ?></td>
              <td><?= number_format($sum_list['sum_deposit'], 2); ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>


  <div class="table mb-0 table-striped">
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap>#</th>
            <th nowrap>วันที่สมัคร</th>
            <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
            <th nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อลูกค้า</th>
            <th nowrap data-sort="first_time_deposit" data-filter="<?= Homepagify::dataFilter('first_time_deposit', 'number') ?>">ยอดฝากครั้งแรก</th>
            <th nowrap>วันที่ฝากครั้งแรก</th>
            <th nowrap>จำนวนครั้งที่ฝาก</th>
            <th nowrap>ยอดฝากรวม</th>
            <th nowrap>ยอดถอนรวม</th>
            <th nowrap data-sort="" data-filter="<?= Homepagify::dataFilter('', 'number') ?>">ยอดเงินได้-เสีย</th>
            <th nowrap data-sort="last_online_date_time" data-filter="<?= Homepagify::dataFilter('last_online_date_time', 'select', $status_list) ?>">สถานะผู้เล่น</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right font-Bold font-16px text-primary"><?= number_format($table_list[0]['sum_all_first_time_deposit'], 2) ?></td>
            <td></td>
            <td></td>
            <td class="text-right font-Bold font-16px text-primary"><?= number_format($table_list[0]['sum_all_deposit'], 2) ?></td>
            <td class="text-right font-Bold font-16px text-primary"><?= number_format($table_list[0]['sum_all_withdraw'], 2) ?></td>
            <td class="text-right font-Bold font-16px <?= ($table_list[0]['sum_all_win_lost'] > 0) ? 'text-primary' : 'text-danger' ?>"><?= number_format($table_list[0]['sum_all_win_lost'], 2) ?></td>
            <td></td>
          </tr>
          <?php foreach ($slicedArray as $key =>  $ally_data) {
            $keys = $key + 1;
          ?>
            <tr class="tr-link cursor-pointer" data-link="customer_details.php?c=<?= $code ?>&id=<?= $ally_data['id'] ?>&page=1">
              <td><?= $keys; ?></td>
              <td nowrap>
                <div><?= Aww::formatDate($ally_data['insert_date_time'], 'd/m/Y'); ?></div>
              </td>
              <td nowrap>
                <div><?= hidePhoneNumber($ally_data['username']); ?></div>
              </td>
              <td nowrap class="text-primary"><?= $ally_data['bank_name']; ?></td>
              <td nowrap class="text-right"><?= number_format($ally_data['first_time_deposit'], 2); ?></td>
              <td nowrap>
                <?php if ($ally_data['first_time_deposit_date']) {
                  echo Aww::formatDate($ally_data['first_time_deposit_date'], 'd/m/Y');
                } else {
                  echo '-';
                }
                ?>
              </td>
              <td nowrap class="text-right"><?= number_format($ally_data['count_deposit_time'], 0); ?></td>
              <td nowrap class="text-right text-success"><?= number_format($ally_data['sum_deposit'], 2); ?></td>
              <td nowrap class="text-right text-danger"><?= number_format($ally_data['sum_withdraw'], 2); ?></td>
              <?php
              if ($ally_data['sum_win_lost'] >= 1) {
                $style_td = 'text-success';
              } else if ($ally_data['sum_win_lost'] < 0) {
                $style_td = 'text-danger';
              } else {
                $style_td = '';
              }
              ?>
              <td nowrap class="text-right <?= $style_td; ?>">
                <?= number_format($ally_data['sum_win_lost'], 2); ?>
              </td>
              <td nowrap>
                <div class="d-flex align-items-center">
                  <?php if ($ally_data['last_online_date_time']) { ?>
                    <?= file_get_contents('assets/icon/icon-circle-green.svg') ?>
                    <span class="ml-5px">Active</span>
                  <?php } else { ?>
                    <?= file_get_contents('assets/icon/icon-circle-red.svg') ?>
                    <span class="ml-5px">Non Active</span>
                  <?php } ?>
                </div>
              </td>
            </tr>
          <?php }
          ?>
        </tbody>
      </table>
    </div>
  </div>




  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>


</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>