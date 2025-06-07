<?php
// Footer navigation menu function
function renderFooterNav($linelink = null)
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
        'href' => 'comment.php',
        'icon' => 'assets/img/icon/nav-comment.svg',
        'alt'  => 'ความเห็น',
        'label' => 'ความเห็น'
      ],
      [
        'href' => $linelink ? $linelink : 'https://line.me/R/ti/p/@152kglax?oat_content=url&ts=05140244',
        'icon' => 'assets/img/icon/nav-line.svg',
        'alt'  => 'ติดต่อ',
        'label' => 'ติดต่อ'
      ],
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

<?php
}
?>