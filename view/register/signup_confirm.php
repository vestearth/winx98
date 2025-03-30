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
  <div class="form-group">
    <label for="password"><?= "ชื่อบัญชี"; ?></label>
    <div class="input-icon password">
      <input type="text" name="affiliate" id="affiliate" value="" class="form-input-custom" placeholder="<?= "ชื่อบัญชี"; ?>" required>
      <input type="hidden" name="ref" value="<?= $upline_no; ?>">
      <input type="hidden" name="ref_id" value="<?= $ref_id_link; ?>">
      <input type="hidden" name="ref_marketing" value="<?= $ref_market; ?>">
      <input type="hidden" name="username" value="<?= $data_username ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="bank"><?= Ty::get('bank', [], ["case" => "ucfirst"]) ?></label>
    <div class="input-icon bank">
    <input type="text" name="bank" id="bank" value="" class="form-input-custom" placeholder="<?= Ty::get('bank_select') ?>" required>
      <?php /*
      <select name="bank_id" class="event_select_bank empty" required>
        <option value="" selected><?= Ty::get('bank_select') ?></option>
        <?php foreach ($options_bank['list'] as $bank) { ?>
          <option value="<?= $bank['value'] ?>"><?= $bank['name'] ?></option>
        <?php } ?>
      </select>
       */ ?>
    </div>
  </div>
  <div class="form-group">
    <label for="account"><?= Ty::get('acc_numb', [], ["case" => "ucfirst"]) ?></label>
    <div class="input-icon account">
      <input type="number" name="bank_account" id="account" class="form-input-custom" placeholder="<?= Ty::get('accnumb_fill') ?>" required>
    </div>
  </div>
  <div class="group-btn">
    <button type="submit" class="btn btn-sub w-100">
      <?= Ty::get('login'); ?>
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