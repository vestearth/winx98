<?php
$module_code = $user_information['id']; //from user_type.php

if ($_POST) {
  if (isset($_POST['submit_update_hide_permission'])) {
    unset($_POST['submit_update_hide_permission']);

    if (isset($_POST['permission_all']) && isset($_POST['checked'])) {
      foreach ($_POST['permission_all'] as $permission => $value) {
        if (isset($_POST['checked'][$permission])) {
          unset($_POST['permission_all'][$permission]);
        }
      }
    }
    $permission_no_checked = array_keys($_POST['permission_all']);
    $permission_checked = isset($_POST['checked']) ? array_keys($_POST['checked']) : [];

    if ($permission_no_checked) {
      $result = User_type::triggerHiddenPermission($id, $permission_no_checked, 0);
    }
    if ($permission_checked) {
      $result = User_type::triggerHiddenPermission($id, $permission_checked, 1);
    }

    if ($result['response_status']) {
      $response_redirect = 'program_setting.php?setting=user_type&id=' . $id . '&nav_type=1';
    }
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

$is_edit = (isset($_GET['is_edit']) && $_GET['is_edit']) ? true : false;

$hide_checked = User_type::getHiddenPermissionList($id);
?>
<div class="row">
  <div class="col-lg-12 px-0">
    <form action="" method="post">
      <div class="d-flex align-items-center justify-content-between flex-wrap px-15px pt-10px">
        <div>
          <h3 class="font-SemiBold font-16px mb-0">Hide permission</h3>
          <p class="font-Regular font-14px mb-10px">Hide page and function. it will be effect with module user used this user type in main.</p>
        </div>
        <div class="d-flex align-items-center mb-10px">
          <?php
          if ($is_edit) {
            echo '<a href="program_setting.php?setting=user_type&id=' . $id . '&nav_type=1" class="btn btn-light h-35px mr-5px">CANCEL</a>';
            TiwForm::normal('btn', 'submit', ['name' => 'submit_update_hide_permission'], ['text' => Itlanguage::translate('SAVE')]);
          } else {
            echo '<a href="program_setting.php?setting=user_type&id=' . $id . '&nav_type=1&is_edit=1">' . TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-outline-info border'], ['text' => 'EDIT DATA', 'type' => '', 'is_return' => true]) . '</a>';
          }
          ?>
        </div>
      </div>
      <hr class="my-0">
      <div class="px-15px pt-15px pb-0">
        <div class="px-15px">
          <?= F_Permission::templateConfigHidePermission(['is_edit' => $is_edit, 'permission' => $hide_checked]); ?>
        </div>
      </div>
    </form>
  </div>
</div>