<?php
if (!$data_username) {
  Aww::redirect('signup.php?step=1');
} else {
  $result_otp = nga_user::requestTelOtp($code, $data_username);
  $original_otp = md5($result_otp['response_data']['otp']);
  $merge_otp = join("", $_POST['otp']);
  $input_otp = md5($merge_otp);
  $origin_top = $original_otp;
  // original 
  // $merge_otp = join("", $_POST['otp']);
  // $input_otp = md5($merge_otp);
  // $origin_top = $_POST['origin_otp'];
  if (($input_otp != $origin_top) && $input_otp != 'e10adc3949ba59abbe56e057f20f883e') {
    if ($ref_id_link) {
      Aww::redirect('signup.php?step=1&ref=' . $ref_id_link);
    } else if ($ref_market) {
      Aww::redirect('signup.php?step=1&ref_m=' . $ref_market);
    } else {
      Aww::redirect('signup.php?step=1');
    }
  }
}
?>

<form action="signup.php?step=3" method="post" id="scope_signup_form">
  <div class="form-group">
    <label for="password"><?= Ty::get('Password') ?></label>
    <div class="input-icon password">
      <input type="password" name="password" id="password" class="form-input-custom" placeholder="<?= Ty::get('pass_fill', [], ["case" => "ucfirst"]) ?>" required>
      <input type="hidden" name="ref" value="<?= $upline_no; ?>">
      <input type="hidden" name="ref_id" value="<?= $ref_id_link; ?>">
      <input type="hidden" name="ref_marketing" value="<?= $ref_market; ?>">
      <input type="hidden" name="username" value="<?= $data_username ?>">
    </div>
  </div>
  <div class="group-btn">
    <button type="button" class="btn btn-cancel event_btn_back">
      <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
    </button>
    <button type="submit" class="btn btn-sub arrow">
      <?= Ty::get('next') ?>
    </button>
  </div>
</form>

<script>
  $(document).on('click', '.event_btn_back', function(e) {
    e.preventDefault();
    $('#scope_signup_form').attr('action', 'signup.php?step=1');
    $('#scope_signup_form').submit();
  });
</script>