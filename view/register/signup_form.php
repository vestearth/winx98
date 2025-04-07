<?php 
$bank_config = Bank::select();
$options_bank = [
  'list' => [],
];
foreach ($bank_config as $key => $data) {
  $options_bank['list'][] = [
    'value' => $data['abb'],
    'name' => $data['name_th'],
    'img' => $data['image'],
  ];
}

?>
<form method="post">
  <div class="form-group">
    <label for="username"><?= Ty::get('Phonenumber') ?></label>
    <div class="input-icon user">
      <input type="hidden" name="ref_id" value="<?= $ref_id; ?>">
      <input type="hidden" name="ref_marketing" value="<?= $ref_marketing; ?>">
      <input type="hidden" name="ref" value="<?= $upline_no; ?>">
      <input type="number" name="username" id="username" value="<?= $data_username ?>" class="form-input-custom" placeholder="<?= Ty::get('loginwphonenumb') ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="password"><?= Ty::get('Password') ?></label>
    <div class="input-icon password">
      <input type="password" name="password" id="password" class="form-input-custom" placeholder="<?= Ty::get('pass_fill', [], ["case" => "ucfirst"]) ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="bank"><?= Ty::get('bank', [], ["case" => "ucfirst"]) ?></label>
    <div class="input-icon bank">
      <select name="bank_id" class="event_select_bank empty" required>
        <option value="" selected><?= Ty::get('bank_select') ?></option>
        <?php foreach ($options_bank['list'] as $bank) { ?>
          <option value="<?= $bank['value'] ?>"><?= $bank['name'] ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="account"><?= Ty::get('acc_numb', [], ["case" => "ucfirst"]) ?></label>
    <div class="input-icon account">
      <input type="number" name="bank_account" id="account" class="form-input-custom" placeholder="<?= Ty::get('accnumb_fill') ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="upline_member_code"><?= "ผู้แนะนำ"; ?></label>
    <div class="input-icon aff">
      <input type="text" name="upline_member_code" id="affiliate" value="" class="form-input-custom" placeholder="<?= "กรอกรหัสผู้แนะนำหากมี" ?>">
    </div>
  </div>
  <div class="group-btn">
    <button type="submit" name="submit_register" class="btn btn-sub w-100">
      <?= "ยืนยันบัญชี"; ?>
    </button>
  </div>
  <div class="group-btn mt-10px">
    <a href="login.php" class="btn btn-cancel w-100">
        <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
    </a>
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