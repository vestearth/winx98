<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'failed_deposit_summary_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];

?>
<tbody data-total_count="<?= 2 ?>" class="table-striped-2 border-table">
  <tr>
    <td nowrap class="text-white font-SemiBold text-right bg-blue-1">ยอดรวม</td>
    <td nowrap class="text-right bg-blue-2 "> 3,000</td>
    <td nowrap class="text-right bg-blue-2">65</td>
    <td nowrap class="text-right bg-blue-2">5 %</td>
    <td nowrap class="text-right bg-blue-2 text-danger">31,261.00</td>
  </tr>
  <tr>
    <td nowrap>20/06/2022</td>
    <td nowrap class="text-right ">1,780</td>
    <td nowrap class="text-right ">45</td>
    <td nowrap class="text-right ">14.5 %</td>
    <td nowrap class="text-right text-danger">21,261.00</td>
  </tr>
  <tr>
    <td nowrap>19/06/2022</td>
    <td nowrap class="text-right ">1,220 </td>
    <td nowrap class="text-right ">20</td>
    <td nowrap class="text-right ">1 %</td>
    <td nowrap class="text-right text-danger">21,261.00</td>
  </tr>

</tbody>