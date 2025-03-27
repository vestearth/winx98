<?php
  function renderBannerBorder() {
    ?>
    <div class="d-flex banner-border">
      <div class="pos-rel">
        <img src="source/icon-mockup.png?v=<?= rand(1, 999) ?>" alt="Logo">
        Mock Casino.
        <div class="pos-abs smoke-img">
          <img src="source/effect_border.png?v=<?= rand(1, 999) ?>" alt="Logo">
        </div>
      </div>
    </div>
    <?php
  }
?>