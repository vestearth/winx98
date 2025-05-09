<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'refund_summary'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];

?>
<tbody data-total_count="<?= 2 ?>" class="table-striped-last border-table-1 ">

  <tr>
    <td nowrap class="text-center font-SemiBold">21/06/2022</td>
    <td nowrap class="text-right font-SemiBold ">100,000.00</td>
    <td nowrap class="text-right font-SemiBold">10,000.00</td>
    <td nowrap class="text-right font-SemiBold">7,000.00</td>
    <td nowrap class="text-right font-SemiBold">3,000.00</td>
    <td nowrap class="text-right font-SemiBold">752</td>
    <td nowrap class="text-right font-SemiBold">247</td>
    <td nowrap class="text-center font-SemiBold">500</td>
    <td nowrap class="text-center font-SemiBold">252</td>
  </tr>
  <tr>
    <td nowrap class="text-center font-SemiBold">20/06/2022</td>
    <td nowrap class="text-right font-SemiBold">205,000.00</td>
    <td nowrap class="text-right font-SemiBold">25,000.00</td>
    <td nowrap class="text-right font-SemiBold">15,000.00</td>
    <td nowrap class="text-right font-SemiBold">10,000.00</td>
    <td nowrap class="text-right font-SemiBold">1,212</td>
    <td nowrap class="text-right font-SemiBold">200</td>
    <td nowrap class="text-center font-SemiBold">700</td>
    <td nowrap class="text-center font-SemiBold">512</td>
  </tr>
  <tr>
    <td nowrap class="text-center font-SemiBold">19/06/2022</td>
    <td nowrap class="text-right font-SemiBold">754,000.00</td>
    <td nowrap class="text-right font-SemiBold">75,000.00</td>
    <td nowrap class="text-right font-SemiBold">75,000.00</td>
    <td nowrap class="text-right font-SemiBold">5,000.00</td>
    <td nowrap class="text-right font-SemiBold">1,800</td>
    <td nowrap class="text-right font-SemiBold">352</td>
    <td nowrap class="text-center font-SemiBold ">1,700</td>
    <td nowrap class="text-center font-SemiBold">100</td>
  </tr>

</tbody>