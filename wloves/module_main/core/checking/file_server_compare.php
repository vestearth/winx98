<?php
$menus = [
  [
    'id' => 1,
    'name' => 'COMPARE',
  ],
  [
    'id' => 2,
    'name' => 'LOG HISTORY',
  ],
];
?>
<div class="col-lg-10 col-md-8 p-10px">
  <!-- nav bar compare & log history -->
  <div class="top-nav-menu">
    <?php foreach ($menus as $key => $data) { ?>
      <a class="nav-menu <?= ($menu == $data['id']) ? 'active' : '' ?>" href="checking.php?page=<?= $page ?>&menu=<?= $data['id'] ?>">
        <div><?= $data['name'] ?></div>
      </a>
    <?php } ?>
  </div>

  <?php
  if ($menu == 1) {
    require_once 'server_compare.php';
  } else if ($menu == 2) {
    require_once 'server_log.php';
  }
  ?>
</div>