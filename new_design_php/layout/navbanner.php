<?php
function renderBannerBorder($user_data = null)
{
?>
  <div class="d-flex justify-content-between banner-border">
    <a href="index.php" style="color: unset; text-decoration: none;">
      <div class="pos-rel">
        <img src="assets/img/winx98.svg" alt="Logo">
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

<?php
function renderBannerLanding()
{
?>
  <div class="menu-container">
    <a href="index.php" style="color: unset; text-decoration: none;">
      <div class="pos-rel">
        <img src="assets/img/winx98.svg" alt="Logo">
      </div>
    </a>
    <div class="d-flex align-items-center">
      <button class="btn menu-icon-user mr-10px" onclick="window.location.href='register.php'">
        <div class="font-gold">
          สมัคร
        </div>
      </button>
      <button class="btn menu-icon-user" onclick="window.location.href='login.php'">
        <div class="">
          เข้าสู่ระบบ
        </div>
      </button>
    </div>
  </div>
<?php
}
?>

<?php
function renderBannerUser($user_data = null)
{
?>
  <div class="menu-container">
    <a href="index.php" style="color: unset; text-decoration: none;">
      <div class="pos-rel">
        <img src="assets/img/winx98.svg" alt="Logo">
      </div>
    </a>
    <div class="d-flex align-items-center">
      <button class="btn menu-icon-user mr-10px" onclick="window.location.href='signup.php'">
        <div class="font-gold">
          สมัคร
        </div>
      </button>
      <button class="btn menu-icon-user" onclick="window.location.href='login.php'">
        <div class="">
          เข้าสู่ระบบ
        </div>
      </button>
    </div>
  </div>
<?php
}
?>