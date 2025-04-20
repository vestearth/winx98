<?php
// Footer navigation menu function
function renderFooterLanding($menu_landing)
{
?>
  <div class="nav-footer">
    <?php foreach ($menu_landing as $menu_item): ?>
      <a href="<?= $menu_item['url'] ?>" class="underline-unset">
        <div class="item">
          <img src="<?= $menu_item['image'] ?>" alt="หน้าแรก">
          <div><?= $menu_item['title'] ?></div>
        </div>
      </a>
    <?php endforeach; ?>
  </div>

<?php
}
?>