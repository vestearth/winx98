<?php
// $_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'summary_with_alliance'];
$_WLOVES['no_check_permission'] = 1;
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$alliance_id = (isset($_GET['id']) && $_GET['id']) ? $_GET['id'] : null;
$insert_date = (isset($_GET['date_data']) && $_GET['date_data']) ? $_GET['date_data'] : null;

function randomName($length = 10)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

$where = [
  // 'alliance_id' => $alliance_id,
  // 'insert_date' => $insert_date,
  // 'username' => $_POST['username'],
  // 'bank_name' => $_POST['bank_name'],
  // 'first_time_deposit' => $_POST['first_time_deposit'],
  // 'first_time_deposit_date' => $_POST['first_time_deposit_date'],
  // 'count_deposit_time' => $_POST['count_deposit_time'],
  // 'sum_deposit' => $_POST['sum_deposit'],
  // 'last_online_date_time' => $_POST['last_online_date_time'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['insert_date_time' => 'DESC']
];

// รอเชื่อมจริงกลับมาใช้ตรงนี้ 
// $data_list = nga_user::selectUser($code, $where, $options);
// $list = isset($data_list['list']) ? $data_list['list'] : [];
// $total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;

// mockup data
$marketing_list = [
  'test' => [
    [
      'data' => 35,
    ],
    [
      'data' => 62,
    ],
  ],
  'mar' => [
    [
      'data' => 34,
    ],
    [
      'data' => 89,
    ],
  ],
  randomName(rand(1, 10)) => [
    [
      'data' => rand(1, 100),
    ],
    [
      'data' => rand(1, 100),
    ],
  ],
  randomName(rand(1, 10)) => [
    [
      'data' => rand(1, 100),
    ],
    [
      'data' => rand(1, 100),
    ],
  ],
  randomName(rand(1, 10)) => [
    [
      'data' => rand(1, 100),
    ],
    [
      'data' => rand(1, 100),
    ],
  ],
  randomName(rand(1, 10)) => [
    [
      'data' => rand(1, 100),
    ],
    [
      'data' => rand(1, 100),
    ],
  ],
  randomName(rand(1, 10)) => [
    [
      'data' => rand(1, 100),
    ],
    [
      'data' => rand(1, 100),
    ],
  ],
];
$list = [
  [
    'date' => '2021-01-01',
    'invite' => rand(0, 100),
    'wrong_condition' => rand(0, 100),
    'total' => rand(100, 200),
  ],
  [
    'date' => '2021-01-02',
    'invite' => rand(0, 100),
    'wrong_condition' => rand(0, 100),
    'total' => rand(100, 200),
  ],
];

$total_count = 2;
$count_marketing = count($marketing_list);
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php foreach ($list as $key => $market_data) { ?>
    <tr class="">
      <td nowrap>
        <div>
          <?= Aww::formatDate($market_data['date'], 'd/m/Y'); ?>
        </div>
      </td>
      <?php
      foreach ($marketing_list as $insert_list) { ?>
        <td nowrap>
          <div><?= $insert_list[$key]['data']; ?></div>
        </td>
      <?php } ?>
      <td nowrap><?= number_format($market_data['invite'], 0); ?> </td>
      <td nowrap><?= number_format($market_data['wrong_condition'], 0); ?> </td>
      <td nowrap><?= number_format($market_data['total'], 0); ?> </td>
    </tr>
  <?php } ?>
  <tr>
    <td class="font-SemiBold">รวมทั้งหมด</td>
    <?php foreach ($marketing_list as $total) { ?>
      <td class="font-SemiBold text-primary"><?= rand(0, 100); ?></td>
    <?php } ?>
    <td class="font-SemiBold text-primary"><?= rand(0, 100); ?></td>
    <td class="font-SemiBold text-primary"><?= rand(0, 100); ?></td>
    <td class="font-SemiBold text-primary"><?= rand(0, 100); ?></td>
  </tr>
</tbody>