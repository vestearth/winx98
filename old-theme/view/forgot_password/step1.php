<form action="?step=otp" method="post">
  <div class="form-group">
    <label for="username"><?= Ty::get('Phonenumber') ?></label>
    <div class="input-icon user">
      <input type="text" name="username" id="username" class="form-input-custom" placeholder="<?= Ty::get('loginwphonenumb') ?>" required>
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