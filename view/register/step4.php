<?php
$check_bank_allow = '';
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
  $check_bank_allow = nga_user::getBankNameByBankNo($code, $_POST['bank_id'], $_POST['bank_account']);
  $encode_user = base64_encode($data_username);
  $encode_pass = base64_encode($data_password);

  if (!$check_bank_allow['is_found']) {
    Aww::notification(Ty::get('acc_notfound'), 'error');
    if ($ref_id_link) {
      Aww::redirect('signup.php?step=3&ref=' . $ref_id_link . '&u_name=' . $encode_user . '&u_pass=' . $encode_pass);
    } else if ($ref_market) {
      Aww::redirect('signup.php?step=3&ref_m=' . $ref_market . '&u_name=' . $encode_user . '&u_pass=' . $encode_pass);
    } else {
      Aww::redirect('signup.php?step=3&u_name=' . $encode_user . '&u_pass=' . $encode_pass);
    }
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


<form action="" method="post">
  <div class="form-group">
    <label for="username"><?= Ty::get('Phonenumber') ?></label>
    <div class="input-icon user">
      <input type="text" name="username" id="username" value="<?= $data_username ?>" class="form-input-custom" placeholder="<?= Ty::get('loginwphonenumb') ?>" required readonly>
    </div>
  </div>
  <div class="form-group">
    <label for="password"><?= Ty::get('Password') ?></label>
    <div class="input-icon password">
      <input type="text" name="password" id="password" value="<?= $data_password ?>" class="form-input-custom" placeholder="<?= Ty::get('pass_fill', [], ["case" => "ucfirst"]) ?>" required readonly>
    </div>
  </div>
  <div class="form-group">
    <label for="bank"><?= Ty::get('bank', [], ["case" => "ucfirst"]) ?></label>
    <div class="input-icon bank">
      <?php
      $bank_name = '';
      foreach ($options_bank['list'] as $bank) {
        if ($data_bank_id == $bank['value']) {
          $bank_name = $bank['name'];
        }
      }
      ?>
      <input type="text" name="bank" id="bank" value="<?= $bank_name ?>" class="form-input-custom" readonly>
      <input type="hidden" name="bank_id" value="<?= $data_bank_id; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="account"><?= Ty::get('acc_numb', [], ["case" => "ucfirst"]) ?></label>
    <div class="input-icon account">
      <input type="number" name="bank_account" id="bank_account" value="<?= $data_bank_account ?>" class="form-input-custom" placeholder="<?= Ty::get('accnumb_fill') ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="account"><?= Ty::get('accountname') ?></label>
    <div class="input-icon user">
      <input type="text" name="bank_name" value="<?= $check_bank_allow['account_name']; ?>" id="name" class="form-input-custom" placeholder="<?= Ty::get('accountname') ?>" required>
    </div>
  </div>
  <input type="hidden" name="upline_member_code" value="<?= $upline_no; ?>">
  <input type="hidden" name="ref_id" value="<?= $ref_id_link; ?>">
  <input type="hidden" name="ref_marketing" value="<?= $ref_market; ?>">
  <div class="group-btn justify-content-center">
    <a href="login.php" class="btn btn-cancel d-none">
      <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
    </a>
    <button type="submit" class="btn btn-sub arrow" name="submit_register">
      <?= Ty::get('succeed') ?>
    </button>
  </div>
</form>

<?php Tiwdal::startModal('modal_kbank_condition', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
<button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
  <?= file_get_contents('assets/icon/cross.svg') ?>
</button>
<div class="modal-body">
  <p class="detail font-16px text-center" style="white-space: pre-line">
    ไม่สามารถสมัครสมาชิกได้ในขณะนี้ กรุณาลองใหม่อีกครั้งในภายหลัง เนื่องจากเว็บธนาคารไม่สามารถใช้งานได้ ขออภัยในความไม่สะดวก
  </p>
</div>
<div class="modal-footer">
  <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
    <?= Ty::get('okay') ?>
  </button>
</div>
<?php Tiwdal::endModal() ?>

<script>
  $(document).ready(function() {
    var bank_run = '<?= $check_bank_allow['is_found']; ?>';

    if (!bank_run) {
      $('#modal_kbank_condition').modal('show');
    }
  });
</script>