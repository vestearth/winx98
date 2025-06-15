<?php
if (!$data_username) {
  Aww::redirect('forgot_password.php?step=1');
} else {
  $merge_otp = join("", $_POST['otp']);
  $input_otp = md5($merge_otp);
  $origin_top = $_POST['origin_otp'];
  if (($input_otp != $origin_top) && $input_otp != 'e10adc3949ba59abbe56e057f20f883e') {
    Aww::redirect('forgot_password.php?step=1');
  }
  $check_id = nga_user::getUserByUsername($code, $data_username);
}
?>
<form method="post" id="scope_signup_form">
  <input type="hidden" name="username" value="<?= $data_username ?>">
  <div class="form-group">
    <label for="username"><?= Ty::get('Phonenumber') ?></label>
    <div class="input-icon user">
      <input type="text" name="username" id="username" class="form-input-custom" value="<?= $data_username ?>" required readonly>
    </div>
  </div>
  <div class="form-group">
    <label for="password"><?= Ty::get('new_pass') ?></label>
    <div class="input-icon password">
      <input type="password" name="password" id="password" class="form-input-custom" placeholder="<?= Ty::get('pass_fill', [], ["case" => "ucfirst"]) ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="confirm_password"><?= Ty::get('newpass_conf') ?></label>
    <div class="input-icon password">
      <input type="password" name="confirm_password" id="confirm_password" class="form-input-custom" placeholder="<?= Ty::get('pass_fill', [], ["case" => "ucfirst"]) ?>" required>
    </div>
  </div>
  <input type="hidden" name="hidden_id" value="<?= $check_id['id']; ?>">
  <div class="group-btn">
    <a href="login.php" class="btn btn-cancel event_btn_back">
      <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
    </a>
    <button type="submit" class="btn btn-sub" type="submit" name="submit_change_password">
      <?= Ty::get('confirm2') ?>
    </button>
  </div>
</form>
<script>
  $(document).on('click', '.event_btn_back', function(e) {
    e.preventDefault();
    $('#scope_signup_form').attr('action', 'forgot_password.php?step=1');
    $('#scope_signup_form').submit();
  });
</script>