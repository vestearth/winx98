<?php
$_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'loss_win_alliance'];
require_once '../../.framework/import.php';
$code = $_GET['c'];
$id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : null;
$date_data = isset($_GET['date_data']) ? $_GET['date_data'] : [];
$where = [
  'alliance_id' => $id,
  'first_time_deposit_date' => $date_data,
];

if ($_POST) {
  if (isset($_POST['export_excel'])) {
    $options = [
      'export' => 'excel',
      'selected_fields' => [
        'username',
        'first_time_deposit_date',
        'bank_name',
        'first_time_deposit',
        'insert_date_time',
        // 'count_deposit_time',
        // 'sum_deposit',
        // 'sum_win_lost'
      ],
    ];
    $result = nga_user::selectUser($code, $where, $options);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';
    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
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

$detail_ally = nga_management::getAllianceDetailByDate($code, $id, $date_data);
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
        <div class='topic'>พันธมิตร</div>
        <div class="font-14px text-sub">
          ข้อมูลรายละเอียดพันธมิตร
        </div>
      </div>
    </div>
  </div>
  <div class="bg-whites pt-15px">
    <div class="form-row px-15px ">
      <div class="col-lg-3 ">
        <div class="mb-10px">
          <div class="card-header-success py-10ox font-SemiBold font-14px">
            ชื่อพันธมิตร <span class=" text-default font-14px  ml-10px"><?= $detail_ally['name']; ?></span>
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              หัวหน้าพันธมิตร <span class="ml-10px text-primary"><?= $detail_ally['leader_name']; ?></span>
            </div>
            <div class="pb-35px"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-primary py-10px font-SemiBold font-14px">
            จำนวนสมาชิกทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-primary"><?= number_format($detail_ally['user_register_count']); ?> </span> คน
              <div class="pt-5px">
                ฝากเงินแล้ว <span class="text-success"><?= number_format($detail_ally['user_count_by_first_time_date']); ?> </span>คน คิดเป็น <span class="text-success"> <?= number_format($detail_ally['count_deposit_first_time_percent']); ?>%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-success  font-SemiBold font-14px">
            ยอดฝากของสมาชิกทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-success"><?= number_format($detail_ally['sum_user_deposit']); ?> </span> บาท
              <div class="pt-5px">
                จากสมาชิกทั้งหมด <span class="text-primary"><?= number_format($detail_ally['user_count_by_first_time_date']); ?> </span> คน
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
      </div>
    </div>
  </div>
  <div id="loss_win_alliance_detail" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('loss_win_alliance_detail', '?c=' . $code . '&id=' . $id . '&date_data=' . $date_data, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
            <th nowrap>วันที่สมัคร</th>
            <th nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อลูกค้า</th>
            <th nowrap data-sort="first_time_deposit" data-filter="<?= Homepagify::dataFilter('first_time_deposit', 'number') ?>">ยอดฝากครั้งแรก</th>
            <th nowrap>วันที่ฝากครั้งแรก</th>
            <th nowrap data-sort="count_deposit_time" data-filter="<?= Homepagify::dataFilter('count_deposit_time', 'number') ?>">จำนวนครั้งที่ฝาก</th>
            <th nowrap data-sort="sum_deposit" data-filter="<?= Homepagify::dataFilter('sum_deposit', 'number') ?>">ยอดฝากทั้งหมด</th>
            <th nowrap data-sort="" data-filter="<?= Homepagify::dataFilter('', 'number') ?>">ยอดเงินได้-เสีย</th>
            <th nowrap data-sort="is_have_last_online" data-filter="<?= Homepagify::dataFilter('is_have_last_online', 'select', $status_list) ?>">สถานะผู้เล่น</th>
          </tr>
        </thead>
      </table>
    </div>
    <div class="menu-export">
      <div class="btn-group dot3">
        <button type="button" class="btn btn-dropdown-3dot  p-0" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?= file_get_contents('assets/icon/more.svg'); ?>
        </button>
        <form method="POST">
          <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm">
            <button class="btn dropdown-item justify-content-start event-export-excel text-info" type="submit" name="export_excel">
              <?= file_get_contents('assets/icon/icon-export.svg') ?>
              <span class="ml-10px">Export Excel</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>