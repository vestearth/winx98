<?php
// Footer navigation menu function
function renderFooterNav()
{
?>
  <div class="nav-footer">
    <a href="index.php" style="text-decoration: none;">
      <div class="item active">
        <img src="source/icon-home.svg" alt="หน้าแรก">
        <div>หน้าแรก</div>
      </div>
    </a>
    <a href="games.php" style="text-decoration: none;">
      <div class="item">
        <img src="source/icon-gaming.svg" alt="เล่นเกม">
        <div>เล่นเกม</div>
      </div>
    </a>
    <a href="#" style="text-decoration: none;">
      <div class="item">
        <img src="source/icon-wallet.svg" alt="กระเป๋า">
        <div>กระเป๋า</div>
      </div>
    </a>
    <a href="#" style="text-decoration: none;">
      <div class="item openBtn" onclick="openNav()">
        <img src="source/icon-other.svg" alt="อื่น ๆ">
        <div>อื่น ๆ</div>
      </div>
    </a>
  </div>

  <div id="rightNav">
    <div class="pos-rel d-flex align-items-center closeBtn" onclick="closeNav()">
      <img src="source/icon-mockup.png?v=<?= rand(1, 999) ?>" alt="Logo" class="mr-5px">
      WinX98
    </div>
    <?php
    $links = [
      ["หน้าแรก", "source/icon-home-menu.svg", "index.php"],
      ["เล่นเกม", "source/icon-gaming-menu.svg", "games.php"],
      ["กระเป๋าเงิน", "source/icon-wallet-menu.svg", "#"],
      ["ฝากเงิน", "source/icon-deposit-menu.svg", "deposit.php"],
      ["ถอนเงิน", "source/icon-withdraw-menu.svg", "withdraw.php"],
      ["โปรโมชั่น", "source/icon-promotion-menu.svg", "promotion.php"],
      ["คืนยอดเสีย", "source/icon-refund-menu.svg", "refund.php"],
      ["สร้างรายได้", "source/icon-earning-menu.svg", "earning.php"],
      ["ข้อมูลส่วนตัว", "source/icon-profile-menu.svg", "user.php"],
      ["ติดต่อเรา", "source/icon-contact-menu.svg", "#"],
      ["แสดงความคิดเห็น", "source/icon-comment-menu.svg", "comment.php"]
    ];
    $footerLinks = [
      ['ภาษาไทย', "source/icon-thai-lang.svg", "#"],
      ['ออกจากระบบ', "source/icon-logout-menu.svg", "logout.php"]
    ];

    echo '<div class="right-side">';
    foreach ($links as $link) {
      $icon = file_get_contents($link[1]);
      echo "<a href=\"{$link[2]}\" class=\"nav-link\">";
      echo "<div class=\"icon-wrapper\">{$icon}</div>";
      echo "<span class=\"nav-text\">{$link[0]}</span>";
      echo "</a>";
    }
    echo '</div>';
    echo '<div class="right-side-last">';
    foreach ($footerLinks as $footerLink) {
      $icon = file_get_contents($footerLink[1]);
      echo "<a href=\"{$footerLink[2]}\" class=\"nav-link\">";
      echo "<div class=\"icon-wrapper\">{$icon}</div>";
      echo "<span class=\"nav-text\">{$footerLink[0]}</span>";
      echo "</a>";
    }

    echo '</div>';

    ?>
  </div>
<?php
}
?>