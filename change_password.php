<?php
require_once '.framework/import.php';
if ($is_login) {
  $user_data = User::getCurrent();
  $data = [
    'user_id' => $user_data['id'],
    'detail' => 'เข้าหน้าเปลี่ยนรหัสผ่าน',
  ];
  nga_user::addNewUserLog($code, $data);
} else {
  Aww::redirect('landing.php');
}

if ($_POST) {
  if (isset($_POST['submit_change_password'])) {
    if ($_POST['password'] == $_POST['confirm_password']) {
      $password = $_POST['password'];
      $data = [
        'password' => $password,
      ];
      $result = User::updateUser($_POST['hidden_id'], $data);
      if ($result['response_status']) {
        $data = [
          'user_id' => $_POST['hidden_id'],
          'detail' => 'เปลี่ยนรหัสผ่าน',
        ];
        $user_log = nga_user::addNewUserLog($code, $data);
      }
      $force_logout = User::logout();
      $response_message = Ty::get('pass_change');
      $response_redirect = 'login.php';
    } else {
      $response_message = Ty::get('pass_match');
      $response_status = 'error';
      Aww::notification($response_message, $response_status);
    }
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  ?>
</head>

<body>
  <?php include 'layout/nmg_bg.php'; ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-6 text-center">
        <div class="logo">
          <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo">
        </div>
        <div class="card-login min-h-100px">
          <div class="card-login-nav">
            <a href="#" class="active w-100"><?= Ty::get('set_pass1', [], ["case" => "ucfirst"]) ?></a>
          </div>
          <div class="card-login-body">
            <form action="" method="post">
              <div class="form-group">
                <label for="password"><?= Ty::get('Phonenumber') ?></label>
                <div class="input-icon password">
                  <input type="text" name="password" id="password" class="form-input-custom" value="<?= $user_data['username']; ?>" required readonly>
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
                  <input type="hidden" name="hidden_id" value="<?= $user_data['id']; ?>">
                </div>
              </div>
              <div class="group-btn">
                <a href="user.php" class="btn btn-cancel">
                  <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
                </a>
                <button type="submit" class="btn btn-sub" name="submit_change_password">
                  <?= Ty::get('confirm2') ?>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php Structure::loadFooter(); ?>
</body>

</html>