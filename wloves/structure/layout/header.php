<?php
echo '<div class="main-content">'; // do not remove
$notification = rand(0, 150);

$option = (isset($_PAGE['bread_crumps_option'])) ? $_PAGE['bread_crumps_option'] : [];

$bread_crumps_list = F_Config::getBreadCrumpMenu($_PAGE['permission'][0], $_PAGE['permission'][1], $_PAGE['permission'][2], $option);

$role_list = ['guardian', 'dev', 'tester'];

F_WLoves::getColorClass();
?>

<?php Tiwdal::startModal('logout_popup'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-body">
  <h3 class="text-center font-16px font-SemiBold text-uppercase">Confirm your log out</h3>
  <div class="text-center">Are you sure?</div>
</div>
<div class="modal-footer d-flex justify-content-between">
  <?php
  TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-light min-w-100px', 'data-dismiss' => 'modal'], ['text' => 'Cancel']);
  ?>
  <a href="../../module_main/login/logout.php">
    <?= TiwForm::normal('btn', '', ['name' => 'submit_delete_module', 'type' => 'button', 'class' => 'btn btn-danger'], ['text' => 'YES!!']); ?>
  </a>
</div>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('logout_user_popup'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-body">
  <h3 class="text-center font-16px font-SemiBold text-uppercase">Confirm your log out</h3>
  <div class="text-center">Are you sure?</div>
</div>
<div class="modal-footer d-flex justify-content-between">
  <?php
  TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-light min-w-100px', 'data-dismiss' => 'modal'], ['text' => 'Cancel']);
  ?>
  <a href="../../module_main/login/logout_user.php">
    <?= TiwForm::normal('btn', '', ['name' => 'submit_delete_module', 'type' => 'button', 'class' => 'btn btn-danger'], ['text' => 'YES!!']); ?>
  </a>
</div>
<?php Tiwdal::endModal() ?>