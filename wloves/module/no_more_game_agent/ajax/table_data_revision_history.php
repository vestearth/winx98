<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'data_revision_history'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];
$id = isset($_GET['id']) ? $_GET['id'] : 1;
?>

<tbody data-total_count="10">
  <?php
  for ($i = 0; $i < 10; $i++) { ?>
    <tr class="tr-link cursor-pointer" data-link="">
      <td class="font-16px font-Medium" nowrap>14/06/2022 10:52</td>
      <td class="font-16px font-Regular text-primary" nowrap>กนกวรรณ บุญโนนแต้</td>
      <td class="font-16px font-Regular" align="left" nowrap align="right">89Bvia9427</td>
      <td class="font-16px font-Regular" align="left" nowrap align="right">ธนาคาร ( ธนาคารไทยพาณิชย์, ธนาคารกสิกร )</td>
      <td></td>
      <td align="left" class="font-16px font-Regular" nowrap align="right">โดย Bud</td>
    </tr>
  <?php
  }
  ?>

</tbody>