<?php
require_once '.framework/import.php';
if ($is_login) {
  $user_data = User::getCurrent();
  $data = [
    'user_id' => $user_data['id'],
    'detail' => 'เข้าหน้าเปลี่ยนวันเกิด',
  ];
  nga_user::addNewUserLog($code, $data);
} else {
  Aww::redirect('login.php');
}
$uncount_page = 'change_pass';

if ($_POST) {
  if (isset($_POST['submit_change_birthday'])) {
    $birth_date = $_POST['birth_date'];
    $data = [
      'birth_date' => $birth_date,
    ];
    $result = User::updateUser($_POST['hidden_id'], $data);
    if ($result['response_status']) {
      $data = [
        'user_id' => $_POST['hidden_id'],
        'detail' => 'แก้ไขวันเกิด ' . $birth_date,
      ];
      $user_log = nga_user::addNewUserLog($code, $data);
    }
    // $force_logout = User::logout();
    // $response_message = Ty::get('birthday_change');
    // $response_redirect = 'login.php';
    // } else {
    //   $response_message = Ty::get('birthday_match');
    //   $response_status = 'error';
    //   Aww::notification($response_message, $response_status);
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
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-6 text-center">
        <div class="logo">
          <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo">
        </div>
        <div class="card-login min-h-100px">
          <div class="card-login-nav">
            <a href="#" class="active w-100"><?= Ty::get('set_birthday', [], ['case' => 'ucfirst']) ?></a>
          </div>
          <div class="card-login-body">
            <form action="" method="post">
              <div class="form-group">
                <label for="password"><?= Ty::get('birthday') ?></label>
                <div class="input-icon password">
                  <input type="date" name="birth_date" class="form-input-custom" value="<?= $user_data['birth_date']; ?>" required>
                  <input type="hidden" name="hidden_id" value="<?= $user_data['id']; ?>">
                </div>
              </div>
              <div class="group-btn">
                <a href="user.php" class="btn btn-cancel">
                  <?= Ty::get('back', [], ['case' => 'ucfirst']) ?>
                </a>
                <button type="submit" class="btn btn-main" type="submit" name="submit_change_birthday">
                  <?= Ty::get('confirm2', [], ['case' => 'ucfirst']) ?>
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