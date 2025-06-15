<?php
require_once '.framework/import.php';
$step = (isset($_GET['step']) && $_GET['step']) ? $_GET['step'] : 1;

$data_username = (isset($_POST['username']) && $_POST['username']) ? $_POST['username'] : '';
$data_password = (isset($_POST['password']) && $_POST['password']) ? $_POST['password'] : '';
$system_line =  nga_management::getGeneralWebsite($code);

if ($_POST) {
  if (isset($_POST['submit_change_password'])) {
    if ($_POST['password'] == $_POST['confirm_password']) {
      $password = $_POST['password'];
      $data = [
        'password' => $password,
      ];
      $result = User::updateUser($_POST['hidden_id'], $data);
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
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-6 text-center">
        <div class="logo">
          <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo">
        </div>
        <div class="card-login min-h-100px">
          <div class="card-login-nav">
            <a href="#" class="active w-100"><?= Ty::get('pass_setting') ?></a>
          </div>
          <div class="card-login-body">
            <?php
            if ($step == 1) {
              include 'view/forgot_password/step1.php';
            } else if ($step == 'otp') {
              include 'view/forgot_password/step_otp.php';
            } else if ($step == 2) {
              include 'view/forgot_password/step2.php';
            }
            ?>
          </div>
        </div>
        <p class="text-white text-center my-10px">
          <?= Ty::get('contact_ad') ?>
          <a href="<?= $system_line['line_link'] ?>" target="_blank" class="text-pink-2">
            <?= $system_line['line_id'] ?>
          </a>
        </p>
      </div>
    </div>
  </div>

  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  ?>
</body>

</html>