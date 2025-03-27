<?php Aww::loadAsset('assets/js/preloader.js'); ?>

<div class="toast-noti fixed-bottom position-bottom p-0"></div>
<?php
echo '<button class="btn-to-top" title="Go to top">
  <i class="fa fa-angle-double-up"></i>
</button>';
?>

<?php Tiwdal::startModal('modal_download_app', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
<button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
  <?= file_get_contents('assets/icon/cross.svg') ?>
</button>
<div class="modal-body">
  <h5 class="text-center">Select Device</h5>
</div>
<div class="modal-footer">
  <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main event_show_android mx-5px">
    <?= 'Android' ?>
  </button>
  <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main event_show_ios mx-5px">
    <?= 'IOS' ?>
  </button>
</div>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('modal_android_download_app', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
<button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
  <?= file_get_contents('assets/icon/cross.svg') ?>
</button>
<div class="modal-body">
  <img src="assets/images/landing/android_download.png?v=4" class="img-responsive">
</div>
<div class="modal-footer">
  <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
    <?= Ty::get('okay') ?>
  </button>
</div>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('modal_ios_download_app', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
<button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
  <?= file_get_contents('assets/icon/cross.svg') ?>
</button>
<div class="modal-body">
  <img src="assets/images/landing/ios_download.png?v=4" class="img-responsive">
</div>
<div class="modal-footer">
  <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
    <?= Ty::get('okay') ?>
  </button>
</div>
<?php Tiwdal::endModal() ?>

<script>
  $(document).ready(function() {
    $(document).on('click', '.event_view_load_app', function(e) {
      $('#modal_download_app').modal('show');
    });
    $(document).on('click', '.event_show_android', function(e) {
      $('#modal_android_download_app').modal('show');
    });
    $(document).on('click', '.event_show_ios', function(e) {
      $('#modal_ios_download_app').modal('show');
    });

    $(document).on('click', '#closeModalWeb', function(e) {
      $('.landing-header-download').remove('');
      $('.custom-header-layout').css('margin-top', '0px');
      $.cookie("banner_download_web", "web_close", {
        expires: 7
      });
    });
  });

  function menuToggle(e) {
    var menu = document.getElementById('menu');
    e.classList.toggle("active");
    menu.classList.toggle('open');
  }

  function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text().trim()).select();
    document.execCommand("copy");
    $temp.remove();
  }
</script>