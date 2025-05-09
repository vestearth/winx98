<?php
$_PAGE['permission'] = ['no_more_game_agent', 'agent', 'agent'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];
$from_date_show = date('d/m/Y', strtotime($from_date));
$to_date_show = date('d/m/Y', strtotime($to_date));
$where = [
  'agent_id' => $_GET['agent_id'],
  'start_date' => $from_date,
  'end_date' => $to_date,
];
$call_api = nga_agent::selectAgentCommission($code, $where);
$total_count = count($call_api);
$total_win_lose = 0;
foreach ($call_api as $total_agent) {
  // if ($total_agent['is_my_direct_downline']) {
  $total_win_lose += $total_agent['lose'];
  // }
}

$total_win_lose_commission = 0;
foreach ($call_api as $total_agent2) {
  // if ($total_agent2['is_my_direct_downline']) {
  $total_win_lose_commission += $total_agent2['commission'];
  // }
}
?>
<tbody data-total_count="<?= $total_count; ?>" class="table-striped-2">
  <?php foreach ($call_api as $total_agent) { ?>
    <tr>
      <td nowrap><?= $total_agent['agent_name']; ?></td>
      <td nowrap class="text-center "><?= number_format($total_agent['turn_over_amount'], 2); ?></td>
      <td nowrap class="text-center "><?= number_format($total_agent['turn_over_valid'], 2); ?></td>
      <td nowrap class="text-center "><?= number_format($total_agent['stake_count'], 2); ?></td>
      <td nowrap class="text-center "><?= number_format($total_agent['gross_commission'], 2); ?></td>
      <td nowrap class="text-center "><?= number_format($total_agent['lose'], 2); ?></td>
      <td nowrap class="text-center "><?= number_format($total_agent['commission'], 2); ?></td>
      <td nowrap class="text-center ">
        <?php if ($total_agent['lose'] > 0) {
          $win_lose_style = 'text-success';
        } else {
          $win_lose_style = 'text-danger';
        } ?>
        <span class="<?= $win_lose_style; ?>">
          <?= number_format($total_agent['lose'], 2); ?>
        </span>
      </td>
      <td nowrap>
        <?php
        $games = json_decode($total_agent['game_type_json']);
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
    <td nowrap class="text-white text-right  "></td>
    <td nowrap class="text-right "> </td>
    <td nowrap class="text-right "></td>
    <td nowrap class="text-righ "></td>
    <td nowrap class="text-right "></td>
    <td nowrap class="text-right "></td>
    <td nowrap colspan="2" class="text-right font-14px">Total</td>
    <td nowrap class="text-right">
      <?php
      if ($total_win_lose > 0) {
        $total_win_lose_style = 'text-success';
        $symbol_total = '+';
      } else {
        $total_win_lose_style = 'text-danger';
        $symbol_total = '';
      }
      ?>
      <span class="<?= $total_win_lose_style; ?>">
        <?= $symbol_total . number_format($total_win_lose, 2); ?>
      </span>
    </td>
  </tr>

  <tr class="row-bg-blue-4">
    <td nowrap colspan="8" class="text-right font-20px font-SemiBold">รอบบิล <?= $from_date_show; ?> - <?= $to_date_show; ?></td>
    <td nowrap class="font-20px font-Bold text-right">
      <?php
      if ($total_win_lose_commission > 0) {
        $total_win_lose_style = 'text-success';
        $symbol = '+';
      } else {
        $total_win_lose_style = 'text-danger';
        $symbol = '';
      }
      ?>
      <span class="<?= $total_win_lose_style; ?>">
        <?= $symbol . number_format($total_win_lose_commission, 2); ?>
      </span>
    </td>
  </tr>
</tbody>