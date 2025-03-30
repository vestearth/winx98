<?php
// Footer navigation menu function
function renderFooterNav() {
  ?>

  <div class="nav-footer">
        <div class="item active">
            <img src="source/icon-home.svg" alt="หน้าแรก">
            <div>หน้าแรก</div>
        </div>
        <div class="item">
            <img src="source/icon-gaming.svg" alt="เล่นเกม">
            <div>เล่นเกม</div>
        </div>
        <div class="item">
            <img src="source/icon-wallet.svg" alt="กระเป๋า">
            <div>กระเป๋า</div>
        </div>
        <div class="item" onclick="sideMenuToggle(this)">
            <img src="source/icon-other.svg" alt="อื่น ๆ">
            <div>อื่น ๆ</div>
        </div>
    </div>
  <?php
}
?>

<script>
  function sideMenuToggle(e) {
    var menu = document.getElementById('side-menu');
    e.classList.toggle("active");
    menu.classList.toggle('open');
  }
</script>


