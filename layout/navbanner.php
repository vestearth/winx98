<?php
function renderBannerBorder()
{
?>
  <div class="d-flex banner-border">
    <a href="index.php" style="color: unset; text-decoration: none;">
      <div class="pos-rel">
        <img src="source/icon-mockup.png?v=<?= rand(1, 999) ?>" alt="Logo">
        WinX98
        <div class="pos-abs smoke-img">
          <img src="source/effect_border.png?v=<?= rand(1, 999) ?>" alt="Logo">
        </div>
      </div>
    </a>
  </div>
<?php
}
?>