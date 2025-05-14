<?php
function renderBannerBorder($user_data = null)
{
?>

  <div class="d-flex justify-content-between banner-border">
    <a href="index.php" style="color: unset; text-decoration: none;">
      <div class="pos-rel">
        <img src="source/icon-mockup.png?v=<?= rand(1, 999) ?>" alt="Logo">
        WinX98
        <div class="pos-abs smoke-img">
          <img src="source/effect_border.png?v=<?= rand(1, 999) ?>" alt="Logo">
        </div>
      </div>
    </a>
    <?php if ($user_data) {
    ?>
      <div class="box-cash-nav">
        <img src="source/wallet-profile.svg" alt="">
        <div class="text-white font-15px d-flex ml-10px">฿ <?= number_format($user_data, 2) ?></div>
      </div>
    <?php } ?>
  </div>
<?php
}
?>