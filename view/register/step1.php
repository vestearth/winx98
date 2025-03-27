<form action="signup.php?step=2" method="post">
  <div class="form-group">
    <label for="username"><?= Ty::get('Phonenumber') ?></label>
    <div class="input-icon user">
      <input type="hidden" name="ref_id" value="<?= $ref_id; ?>">
      <input type="hidden" name="ref_marketing" value="<?= $ref_marketing; ?>">
      <input type="hidden" name="ref" value="<?= $upline_no; ?>">
      <input type="number" name="username" id="username" value="<?= $data_username ?>" class="form-input-custom" placeholder="<?= Ty::get('loginwphonenumb') ?>" required>
      <!-- otp  -->
      <input type="hidden" name="otp[]" maxlength="1" placeholder="_" required class="event_input_otp" autofocus value="1">
      <input type="hidden" name="otp[]" maxlength="1" placeholder="_" required class="event_input_otp" value="2">
      <input type="hidden" name="otp[]" maxlength="1" placeholder="_" required class="event_input_otp" value="3">
      <input type="hidden" name="otp[]" maxlength="1" placeholder="_" required class="event_input_otp" value="4">
      <input type="hidden" name="otp[]" maxlength="1" placeholder="_" required class="event_input_otp" value="5">
      <input type="hidden" name="otp[]" maxlength="1" placeholder="_" required class="event_input_otp" value="6">
    </div>
  </div>
  <div class="group-btn">
    <a href="login.php" class="btn btn-cancel">
      <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
    </a>
    <button type="submit" class="btn btn-sub arrow">
      <?= Ty::get('next') ?>
    </button>
  </div>
</form>

<script>
  $(document).ready(function() {
    $('#username').on('input', function() {
      var input = $(this).val();
      if (input.length === 1 && input !== '0') {
        $(this).val('0');
      }
      var submitBtn = $('.btn-sub');
      if (input.length > 0 && input[0] !== '0') {
        submitBtn.prop('disabled', true);
      } else {
        submitBtn.prop('disabled', false);
      }
    });
  });
</script>