<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'summary_report'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$from_date = '2022-10-1';
$to_date = '2022-10-14';
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
?>
<tbody data-total_count="<?= 2 ?>" class="table-striped-2 border-table">
  <tr>
    <td nowrap class="text-white font-SemiBold text-right bg-blue-1">ยอดรวม</td>
    <td nowrap class="text-right bg-blue-2 font-SemiBold"> 300</td>
    <td nowrap class="text-right bg-blue-2 font-SemiBold">200</td>
    <td nowrap class="text-right bg-blue-2 font-SemiBold">300</td>
    <td nowrap class="text-right bg-blue-2 font-SemiBold">100</td>
    <td nowrap class="text-right bg-blue-2 font-SemiBold">1,000,000.00</td>
    <td nowrap class="text-right bg-blue-2 font-SemiBold">500,000.00</td>
    <td nowrap class="text-right text-success bg-blue-2 font-SemiBold">500,000.00</td>
  </tr>
  <tr>
    <td nowrap class="font-SemiBold">08/07/2022</td>
    <td nowrap class="text-right "> 300</td>
    <td nowrap class="text-right ">200</td>
    <td nowrap class="text-right ">300</td>
    <td nowrap class="text-right ">100</td>
    <td nowrap class="text-right ">1,000,000.00</td>
    <td nowrap class="text-right ">200,000.00</td>
    <td nowrap class="text-right text-success ">200,000.00</td>
  </tr>
  <tr>
    <td nowrap class="font-SemiBold">09/07/2022</td>
    <td nowrap class="text-right "> 300</td>
    <td nowrap class="text-right ">200</td>
    <td nowrap class="text-right ">300</td>
    <td nowrap class="text-right ">100</td>
    <td nowrap class="text-right ">1,000,000.00</td>
    <td nowrap class="text-right ">300,000.00</td>
    <td nowrap class="text-right text-success ">300,000.00</td>
  </tr>
</tbody>