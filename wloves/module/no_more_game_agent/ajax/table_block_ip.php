<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'data_revision_history'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];
$id = isset($_GET['id']) ? $_GET['id'] : 1;
?>

<tbody data-total_count="5">
  <?php
  for ($i = 0; $i < 5; $i++) { ?>
    <tr class="" data-link="">
      <td class="font-16px font-Medium" nowrap>01/03/2565, 09:40</td>
      <td class="font-16px font-Medium" nowrap>154.150.4.176</td>
      <td class="font-16px font-Medium" align="left">-</td>
      <td class="font-16px font-Medium" align="left" nowrap>Bond</td>
      <td align="left" class="font-16px font-Medium" nowrap>
        <?php TiwForm::normal('btn', '', ['type' => 'button', 'class' => ''], ['text' => '', 'type' => 'delete', 'prefix' => $prefix, 'modal_id' => 'unblock_ip', 'modal_data' => []]); ?>
      </td>
    </tr>
  <?php
  }
  ?>

</tbody>