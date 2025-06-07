<?php
// redirect from wrong bank 
if (isset($_GET['u_name'])) {
  $decode_user = base64_decode($_GET['u_name']);
  $decode_pass = base64_decode($_GET['u_pass']);
  $data_username = $data_username ? $data_username : $decode_user;
  $data_password = $data_password ? $data_password : $decode_pass;
  $ref_id_link = (isset($_GET['ref'])) ? $_GET['ref'] : '';
  $ref_market = (isset($_GET['ref_m'])) ? $_GET['ref_m'] : '';
}

if ($data_username && $data_password) {
  //register
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
} else {
  if ($ref_id_link) {
    Aww::redirect('signup.php?step=1&ref=' . $ref_id_link);
  } else if ($ref_market) {
    Aww::redirect('signup.php?step=1&ref_m=' . $ref_market);
  } else {
    Aww::redirect('signup.php?step=1');
  }
}
?>

<form action="signup.php?step=4" method="post">
  <input type="hidden" name="username" value="<?= $data_username ?>">
  <input type="hidden" name="password" value="<?= $data_password ?>">
  <input type="hidden" name="ref" value="<?= $upline_no; ?>">
  <input type="hidden" name="ref_id" value="<?= $ref_id_link; ?>">
  <input type="hidden" name="ref_marketing" value="<?= $ref_market; ?>">
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
  <div class="group-btn">
    <a href="login.php" class="btn btn-cancel">
      <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
    </a>
    <button type="submit" class="btn btn-sub arrow">
      <?= Ty::get('next') ?>
    </button>
  </div>
</form>