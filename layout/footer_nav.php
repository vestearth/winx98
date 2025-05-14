<?php
// Footer navigation menu function
function renderFooterNav()
{
?>
  <div class="nav-footer">
    <?php
    $navItems = [
      [
        'href' => 'index.php',
        'icon' => 'source/icon-home.svg',
        'alt'  => 'หน้าแรก',
        'label' => 'หน้าแรก'
      ],
      [
        'href' => 'games.php',
        'icon' => 'source/icon-gaming.svg',
        'alt'  => 'เล่นเกม',
        'label' => 'เล่นเกม'
      ],
      [
        'href' => 'wallet.php',
        'icon' => 'source/icon-wallet.svg',
        'alt'  => 'กระเป๋า',
        'label' => 'กระเป๋า'
      ],
      [
        'href' => '#',
        'icon' => 'source/icon-other.svg',
        'alt'  => 'อื่น ๆ',
        'label' => 'อื่น ๆ',
        'extra' => 'openBtn" onclick="openNav()'
      ]
    ];

    $currentPage = basename($_SERVER['PHP_SELF']);

    foreach ($navItems as $item) {
      $isActive = ($item['href'] !== '#' && $currentPage === $item['href']) ? ' active' : '';
      $extraClass = isset($item['extra']) ? ' ' . $item['extra'] : '';
      echo '<a href="' . $item['href'] . '" style="text-decoration: none;">';
      echo '<div class="item' . $isActive . $extraClass . '">';
      echo '<img src="' . $item['icon'] . '" alt="' . $item['alt'] . '">';
      echo '<div>' . $item['label'] . '</div>';
      echo '</div>';
      echo '</a>';
    }
    ?>
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
      ["กระเป๋าเงิน", "source/icon-wallet-menu.svg", "wallet.php"],
      ["ฝากเงิน", "source/icon-deposit-menu.svg", "deposit.php"],
      ["ถอนเงิน", "source/icon-withdraw-menu.svg", "withdraw.php"],
      // ["โปรโมชั่น", "source/icon-promotion-menu.svg", "promotion.php"],
      ["คืนยอดเสีย", "source/icon-refund-menu.svg", "refund.php"],
      // ["สร้างรายได้", "source/icon-earning-menu.svg", "earning.php"],
      ["ข้อมูลส่วนตัว", "source/icon-profile-menu.svg", "user.php"],
      ["ติดต่อเรา", "source/icon-contact-menu.svg", "https://line.me/R/ti/p/@152kglax?oat_content=url&ts=05140244"],
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