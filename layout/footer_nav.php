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
    <a href="wallet.php" style="text-decoration: none;">
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
      Mock Casino.
    </div>
    <?php
    $links = [
      ["หน้าแรก", "source/icon-home.svg"],
      ["เล่นเกม", "source/icon-gaming.svg"],
      ["กระเป๋าเงิน", "source/icon-wallet.svg"],
      ["ฝากเงิน", "source/icon-wallet.svg"],
      ["ถอนเงิน", "source/icon-wallet.svg"],
      ["โปรโมชั่น", "source/icon-wallet.svg"],
      ["คืนยอดเสีย", "source/icon-wallet.svg"],
      ["สร้างรายได้", "source/icon-wallet.svg"],
      ["ข้อมูลส่วนตัว", "source/icon-wallet.svg"],
      ["ติดต่อเรา", "source/icon-wallet.svg"],
      ["แสดงความคิดเห็น", "source/icon-wallet.svg"]
    ];
    $footerLinks = [
      ['ภาษาไทย', "assets/icon/lang.svg"],
      ['ออกจากระบบ', "assets/images/icon/logout.svg"]
    ];

    echo '<div class="right-side">';
    foreach ($links as $link) {
      echo "<a href=\"#\" class=\"nav-link\"><img src=\"{$link[1]}\" alt=\"{$link[0]}\" class=\"menu-list\"> <span class=\"nav-text\">{$link[0]}</span></a>";
    }
    echo '</div>';
    echo '<div class="right-side-last">';
    foreach ($footerLinks as $footerLink) {
      echo "<a href=\"#\" class=\"nav-link\"><img src=\"{$footerLink[1]}\" alt=\"{$footerLink[0]}\" class=\"menu-list\"> <span class=\"nav-text\">{$footerLink[0]}</span></a>";
    }

    echo '</div>';

    ?>
  </div>
<?php
}
?>