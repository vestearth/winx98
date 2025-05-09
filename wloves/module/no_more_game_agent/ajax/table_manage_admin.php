<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'manage_admin'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];
$id = isset($_GET['id']) ? $_GET['id'] : 1;
?>

<tbody data-total_count="5">
  <tr class="tr-link cursor-pointer <?= ($id == 1) ? 'active' : '' ?>" data-link="manage_admin.php?c=<?= $_GET['c'] ?>&id=1">
    <td class="font-16px font-Medium" nowrap>Jane</td>
    <td class="font-16px font-Medium" nowrap>Jane@gmail.com</td>
    <td class="font-16px font-Medium" nowrap align="right"><span class="text-primary">20</span>/ 32</td>
  </tr>
  <tr class="tr-link cursor-pointer <?= ($id == 2) ? 'active' : '' ?>" data-link="manage_admin.php?c=<?= $_GET['c'] ?>&id=2">
    <td class="font-16px font-Medium" nowrap>Jane</td>
    <td class="font-16px font-Medium" nowrap>Jane@gmail.com</td>
    <td class="font-16px font-Medium" nowrap align="right"><span class="text-primary">20</span>/ 32</td>
  </tr>
  <tr class="tr-link cursor-pointer <?= ($id == 3) ? 'active' : '' ?>" data-link="manage_admin.php?c=<?= $_GET['c'] ?>&id=3">
    <td class="font-16px font-Medium" nowrap>Jane</td>
    <td class="font-16px font-Medium" nowrap>Jane@gmail.com</td>
    <td class="font-16px font-Medium" nowrap align="right"><span class="text-primary">20</span>/ 32</td>
  </tr>
  <tr class="tr-link cursor-pointer <?= ($id == 4) ? 'active' : '' ?>" data-link="manage_admin.php?c=<?= $_GET['c'] ?>&id=4">
    <td class="font-16px font-Medium" nowrap>Jane</td>
    <td class="font-16px font-Medium" nowrap>Jane@gmail.com</td>
    <td class="font-16px font-Medium" nowrap align="right"><span class="text-primary">20</span>/ 32</td>
  </tr>
  <tr class="tr-link cursor-pointer <?= ($id == 5) ? 'active' : '' ?>" data-link="manage_admin.php?c=<?= $_GET['c'] ?>&id=5">
    <td class="font-16px font-Medium" nowrap>Jane</td>
    <td class="font-16px font-Medium" nowrap>Jane@gmail.com</td>
    <td class="font-16px font-Medium" nowrap align="right"><span class="text-primary">20</span>/ 32</td>
  </tr>
</tbody>