<?php
if ($_POST) {
  if (isset($_POST['submit_format_code'])) {
    $data = [
      'user_code_format_text1' => $_POST['user_code_format_text1'],
      'user_code_format_text2' => $_POST['user_code_format_text2'],
      'user_code_format_digit3' => $_POST['user_code_format_digit3'],
    ];
    $result = User_type::updateUserType($id, $data);
  } else if (isset($_POST['submit_user_type_detail'])) {
    $data = [
      'name' => $_POST['name'],
      'description' => $_POST['description'],
    ];
    $result = User_type::updateUserType($id, $data);

    if ($result['response_status']) {
      $response_redirect = 'program_setting.php?setting=user_type&id=' . $id . '&nav_type=3';
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

//$user_information => from user_type.php
?>
<form action="" method="post">
  <div class="row">
    <div class="col-lg-12 px-0">
      <div class="d-flex align-items-center justify-content-between flex-wrap px-15px mt-10px">
        <div>
          <h3 class="font-16px mb-0 d-flex align-items-center text-uppercase text-info">User Type Details</h3>
          <p class="font-14px mb-10px">Manage user type details.</p>
        </div>
        <div class="mb-10px">
          <?php
          if ($is_edit) {
            echo '<div class="d-flex">';
            echo '<a href="program_setting.php?setting=user_type&id=' . $id . '&nav_type=3" class="btn btn-light h-35px mr-5px">CANCEL</a>';
            TiwForm::normal('btn', 'submit', ['name' => 'submit_user_type_detail'], ['text' => Itlanguage::translate('SAVE')], ['id' => 'form_module_detail']);
            echo '</div>';
          } else {
            echo '<a href="program_setting.php?setting=user_type&id=' . $id . '&nav_type=3&is_edit=1">' . TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-outline-info border'], ['text' => 'EDIT DATA', 'type' => '', 'is_return' => true]) . '</a>';
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  <hr class="mx--15px mt-0 mb-5px">
  <div class="form-row">
    <div class="col-md-5 col-lg-4 font-14px text-secondary d-flex align-items-center">User Type Name</div>
    <div class="col-md-7 col-lg-8">
      <?= TiwForm::normal('text', ($is_edit ? $user_information['name'] : '<span class="font-18px text-primary font-SemiBold">' . $user_information['name'] . '</span>'), ['name' => 'name'], ['is_edit' => $is_edit]) ?>
    </div>
    <div class="col-md-5 col-lg-4 font-14px text-secondary d-flex align-items-center">Description</div>
    <div class="col-md-7 col-lg-8">
      <?= TiwForm::normal('textarea', $user_information['description'], ['name' => 'description'], ['is_edit' => $is_edit]) ?>
    </div>
  </div>
</form>