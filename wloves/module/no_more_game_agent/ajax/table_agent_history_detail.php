<?php
$_PAGE['permission'] = ['no_more_game_agent', 'agent', 'agent'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'bill_id' => $_GET['id'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nga_agent::selectCommissionBilList($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2">
  <?php
  $start_bill_date = '';
  $end_bill_date = '';
  foreach ($list as $key => $bill_list) {
    $keys = $key + 1;
    if ($keys == 1) {
      $start_bill_date = $bill_list[0]['insert_date_time'];
    } else if ($keys == count($list)) {
      $end_bill_date = $bill_list[1]['insert_date_time'];
    }
  ?>
    <tr>
      <td nowrap><?= $bill_list['agent_name']; ?></td>
      <td nowrap class="text-right"><?= number_format($bill_list['turn_over_amount'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($bill_list['turn_over_valid'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($bill_list['stake_count'], 2); ?></td>
      <td nowrap class="text-right"><?= number_format($bill_list['gross_commission'], 2); ?></td>
      <td nowrap class="text-right">
        <?php if ($bill_list['lose'] > 0) {
          echo '<span class="text-success">' . number_format($bill_list['lose'], 2) . '</span>';
        } else if ($bill_list['lose'] < 0) {
          echo '<span class="text-danger">' . number_format($bill_list['lose'], 2) . '</span>';
        } else {
          echo '<span class="text-grey">' . number_format($bill_list['lose'], 2) . '</span>';
        } ?>
      </td>
      <td nowrap class="text-right">
        <?php if ($bill_list['commission'] > 0) {
          echo '<span class="text-success">' . number_format($bill_list['commission'], 2) . '</span>';
        } else if ($bill_list['commission'] < 0) {
          echo '<span class="text-danger">' . number_format($bill_list['commission'], 2) . '</span>';
        } else {
          echo '<span class="text-grey">' . number_format($bill_list['commission'], 2) . '</span>';
        } ?>
      </td>
      <td nowrap class="text-right">
        <?php if ($bill_list['lose'] > 0) {
          echo '<span class="text-success">' . number_format($bill_list['lose'], 2) . '</span>';
        } else if ($bill_list['lose'] < 0) {
          echo '<span class="text-danger">' . number_format($bill_list['lose'], 2) . '</span>';
        } else {
          echo '<span class="text-grey">' . number_format($bill_list['lose'], 2) . '</span>';
        } ?>
      </td>
      <td nowrap>
        <?php
        $games = json_decode($bill_list['game_type_json']);
        $count_game = count($games);
        ?>
        <?php foreach ($games as $key => $game_list) {
          $keys =  $key + 1;
          if ($game_list == 'CARD') {
            $game_name = 'เปิดไพ่';
          } else if ($game_list == 'SLOT') {
            $game_name = 'สล็อตเสี่ยงโชค';
          } else if ($game_list == 'FISHING') {
            $game_name = 'เกมตกปลา';
          } else if ($game_list == 'ARCADE') {
            $game_name = 'ตู้เกม Arcade';
          } else if ($game_list == 'BOARD') {
            $game_name = 'บอร์ดเกม';
          } else if ($game_list == 'CASINOLIVE') {
            $game_name = 'คาสิโน';
          } else {
            $game_name = 'ไม่ระบุ';
          }
        ?>
          <span class=""><?= $game_name; ?> <?= ($keys == $count_game) ? '' : ' / '; ?></span>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
  <tr class="row-bg-blue-3">
    <td nowrap colspan="9">
      <div class="d-flex justify-content-end">
        <div class="text-right font-14px pr-160px">Total</div>
        <?php
        $total_win_lose = 0;
        foreach ($list as $bill_list) {
          $total_win_lose += $bill_list['lose'];
        }
        if ($total_win_lose > 0) {
          $total_style = 'text-success';
        } else if ($total_win_lose < 0) {
          $total_style = 'text-danger';
        } else {
          $total_style = 'text-grey';
        }
        ?>
        <div nowrap class="<?= $total_style; ?> text-right font-15px w-120px">
          <?= number_format($total_win_lose, 2); ?>
        </div>
      </div>
    </td>
  </tr>
</tbody>
<tr class="row-bg-blue-4">
  <td nowrap colspan="9">
    <div class="d-flex justify-content-end">
      <div class=" font-20px font-SemiBold pr-160px">รอบบิล <?= Aww::formatDate($start_bill_date, 'd/m/Y'); ?> - <?= Aww::formatDate($end_bill_date, 'd/m/Y'); ?> </div>
      <?php
      $total_win_lose_commission = 0;
      foreach ($list as $bill_list) {
        $total_win_lose_commission += $bill_list['commission'];
      }
      if ($total_win_lose_commission > 0) {
        $total_com_style = 'text-success';
        $symbol = '+';
      } else if ($total_win_lose_commission < 0) {
        $total_com_style = 'text-danger';
        $symbol = '';
      } else {
        $total_com_style = 'text-grey';
        $symbol = '';
      }
      ?>
      <div class="<?= $total_com_style; ?> font-20px font-Bold text-right w-120px">
        <?= $symbol . ' ' . number_format($total_win_lose_commission, 2); ?>
      </div>
    </div>
  </td>
</tr>
</tbody>