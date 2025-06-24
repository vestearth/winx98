<?php
function renderBannerBorder($ref_marketing = null, $m = null, $redirect_link = 'index')
{
  $query_param = '';
  if (!empty($m)) {
    $query_param = '?m=' . urlencode($m);
  } elseif (!empty($ref_marketing)) {
    $query_param = '?ref_m=' . urlencode($ref_marketing);
  }
?>
  <div class="menu-container">
    <a href="<?= $redirect_link; ?>.php<?= $query_param ?>" style="color: unset; text-decoration: none;">
      <div class="pos-rel">
        <img src="assets/img/winx98v2.svg" alt="Logo">
      </div>
    </a>
  </div>
<?php
}
?>

<?php
function renderBannerLanding($ref_marketing = null, $m = null, $redirect_link = 'index')
{
  $query_param = '';
  if (!empty($m)) {
    $query_param = '?m=' . urlencode($m);
  } elseif (!empty($ref_marketing)) {
    $query_param = '?ref_m=' . urlencode($ref_marketing);
  }
?>
  <div class="menu-container">
    <a href="<?= $redirect_link; ?>.php<?= $query_param ?>" style="color: unset; text-decoration: none;">
      <div class="pos-rel">
        <img src="assets/img/winx98v2.svg" alt="Logo">
      </div>
    </a>
    <div class="d-flex align-items-center">
      <button class="btn menu-icon-user mr-10px" onclick="window.location.href='signup.php<?= isset($ref_marketing) ? '?ref_m=' . urlencode($ref_marketing) : '' ?>'">
        <div class="font-gold">
          สมัคร
        </div>
      </button>
      <button class="btn menu-icon-user" onclick="window.location.href='login.php<?= isset($ref_marketing) ? '?ref_m=' . urlencode($ref_marketing) : '' ?>'">
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
function renderBannerUser()
{
  $user_current = User::getCurrent();
?>
  <div class="menu-container">
    <a href="index.php" style="color: unset; text-decoration: none;">
      <div class="pos-rel">
        <img src="assets/img/winx98v2.svg" alt="Logo">
      </div>
    </a>
    <div class="header-bar">
      <div class="icon-container">
        <!-- Notification Bell with Badge -->
        <!-- <div class="icon-wrapper">
          <button class="icon-btn notification-btn" id="notificationBtn">
            <svg class="icon bell-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span class="notification-badge" id="notificationBadge">3</span>
          </button>
        </div> -->

        <!-- User Profile Icon -->
        <div class="icon-wrapper">
          <button class="icon-btn notification-btn" id="notificationBtn">
            <span class="text-gold text-nowrap">
              ฿ <?= $user_current['money_balance'] >= 1000000 ? number_format($user_current['money_balance'] / 1000000, 1) . 'M' : ($user_current['money_balance'] >= 100000 ? number_format($user_current['money_balance'] / 1000, 1) . 'K' : number_format($user_current['money_balance'], 2)); ?>
            </span>
          </button>
        </div>

        <div class="icon-wrapper">
          <button class="icon-btn profile-btn" id="profileBtn" onclick="window.location.href='user.php'">
            <svg class="icon profile-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </button>
        </div>
        <div class="icon-wrapper">
          <button class="icon-btn logout-btn" onclick="window.location.href='logout.php'">
            <svg class="icon logout-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
              <polyline points="16,17 21,12 16,7"></polyline>
              <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="dropdown-menu notification-dropdown" id="notificationDropdown">
    <div class="dropdown-header">
      <h3>Notifications</h3>
      <button class="clear-all-btn">Clear All</button>
    </div>
    <div class="notification-list">
      <div class="notification-item unread">
        <div class="notification-content">
          <span class="notification-text">New message received</span>
          <span class="notification-time">2 minutes ago</span>
        </div>
      </div>
      <div class="notification-item unread">
        <div class="notification-content">
          <span class="notification-text">Your order has been shipped</span>
          <span class="notification-time">1 hour ago</span>
        </div>
      </div>
      <div class="notification-item unread">
        <div class="notification-content">
          <span class="notification-text">Weekly report is ready</span>
          <span class="notification-time">3 hours ago</span>
        </div>
      </div>
    </div>
  </div>

  <div class="dropdown-menu profile-dropdown" id="profileDropdown">
    <div class="profile-info">
      <div class="profile-avatar">
        <span>VE</span>
      </div>
      <div class="profile-details">
        <span class="profile-name">vestearth</span>
        <span class="profile-email">user@example.com</span>
      </div>
    </div>
    <hr class="dropdown-divider">
    <div class="dropdown-links">
      <a href="#" class="dropdown-link">Profile Settings</a>
      <a href="#" class="dropdown-link">Account</a>
      <a href="#" class="dropdown-link">Preferences</a>
      <hr class="dropdown-divider">
      <a href="#" class="dropdown-link logout">Sign Out</a>
    </div>
  </div>
<?php
}
?>

<?php
function navDepositWithdraw($type = '')
{
  $depositActive = $type === 'deposit' ? 'active' : '';
  $withdrawActive = $type === 'withdraw' ? 'active' : '';
?>
  <div class="col-12 mb-20px">
    <nav class="nav-container">
      <button class="nav-button left <?= $depositActive; ?>" id="downloadBtn" onclick="window.location.href='deposit.php'">
        <div class="d-flex align-items-center justify-content-center">
          <div class="mr-10px">
            <?= file_get_contents('assets/img/icon/icon-deposit.svg'); ?>
          </div>
          <span>ฝากเงิน</span>
        </div>
      </button>
      <button class="nav-button right <?= $withdrawActive; ?>" id="loginBtn" onclick="window.location.href='withdraw.php'">
        <div class="d-flex align-items-center justify-content-center">
          <div class="mr-10px">
            <?= file_get_contents('assets/img/icon/icon-withdraw.svg'); ?>
          </div>
          <span>ถอนเงิน</span>
        </div>
      </button>
    </nav>
  </div>
<?php
}
?>