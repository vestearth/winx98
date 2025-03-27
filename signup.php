<?php
require_once '.framework/import.php';
$step = (isset($_GET['step']) && $_GET['step']) ? $_GET['step'] : 1;
$ref_id = isset($_GET['ref']) ? $_GET['ref'] : '';
$ref_marketing = isset($_GET['ref_m']) ? $_GET['ref_m'] : '';
$check_member = nga_user::checkMembercode($code, $ref_id);
$upline_no = isset($check_member['tel_no']) ? $check_member['tel_no'] : '';
if ($ref_marketing) {
  $redirect_link = "http://$_SERVER[HTTP_HOST]";
  $redirect_link = $redirect_link . '/landing.php';
  $check_marketing = nga_user::checkAllianceActiveByReflink($code, $ref_marketing);
  $market_response = ($check_marketing['response_status']) ? 'accept' : Aww::redirect($redirect_link);
}

$data_username = (isset($_POST['username']) && $_POST['username']) ? $_POST['username'] : '';
$ref_id_link = (isset($_POST['ref_id']) && $_POST['ref_id']) ? $_POST['ref_id'] : '';
$ref_market = (isset($_POST['ref_marketing']) && $_POST['ref_marketing']) ? $_POST['ref_marketing'] : '';
$data_password = (isset($_POST['password']) && $_POST['password']) ? $_POST['password'] : '';
$data_bank_id = (isset($_POST['bank_id']) && $_POST['bank_id']) ? $_POST['bank_id'] : '';
$data_bank_account = (isset($_POST['bank_account']) && $_POST['bank_account']) ? $_POST['bank_account'] : '';

if ($step == 2) {

  if (!is_numeric($data_username)) {
    Aww::notification('Invalid phone number format', 'error');
    Aww::redirect('signup.php');
  }

  if (strlen($data_username) != 10) {
    Aww::notification('Invalid phone number format', 'error');
    Aww::redirect('signup.php');
  }

  if (substr(strval($data_username), 0, 2) === '00') {
    Aww::notification('Invalid phone number format', 'error');
    Aww::redirect('signup.php');
  }
}

if ($_POST) {
  if (isset($_POST['submit_register'])) {
    $ref_checked = isset($_POST['ref_marketing']) ? $_POST['ref_marketing'] : '';
    $password = $_POST['password'];

    if (!is_numeric($_POST['username'])) {
      Aww::notification('Invalid phone number format', 'error');
      Aww::redirect('signup.php');
    }

    if (strlen($_POST['username']) != 10) {
      Aww::notification('Invalid phone number format', 'error');
      Aww::redirect('signup.php');
    }

    if (substr(strval($_POST['username']), 0, 2) === '00') {
      Aww::notification('Invalid phone number format', 'error');
      Aww::redirect('signup.php');
    }

    $data = [
      'username' => $_POST['username'],
      'password' => $password,
      'bank_abb' => $_POST['bank_id'],
      'bank_number' => $_POST['bank_account'],
      'bank_name' => $_POST['bank_name'],
      'upline_member_code' => $_POST['ref_id'],
    ];
    if ($ref_checked) {
      $data['ref_link'] = $ref_checked;
      $result = nga_user::addNewUserFromAlliance($code, $data);
    } else {
      $data['upline_member_code'] = $_POST['ref_id'];
      $result = nga_user::addNewUser($code, $data, false, true);
    }
    if ($result['response_status'] || $result['response_message'] == 'มีบัญชีนี้ในระบบแล้ว') {
      $force_login = User::login($_POST['username'], $password);
      $response_message = $force_login['response_message'];
      $response_redirect = 'index.php';
    } else {
      $response_message = $result['response_message'];
    }
    // $response_redirect = 'login.php';
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
        <div class="card-login">
          <div class="card-login-nav">
            <a href="login.php"><?= Ty::get('login') ?></a>
            <a href="signup.php" class="active"><?= Ty::get('register') ?></a>
          </div>
          <div class="card-login-body">
            <div class="step-register">
              <div class="item active">
                <div class="item-icon">
                  <?= file_get_contents('assets/icon/user.svg') ?>
                </div>
                <div class="item-text">
                  <?= Ty::get('Sign up') ?>
                </div>
                <div class="line"></div>
              </div>
              <div class="item <?= $step > 1 ? 'active' : '' ?>">
                <div class="item-icon">
                  <?= file_get_contents('assets/icon/lock.svg') ?>
                </div>
                <div class="item-text">
                  <?= Ty::get('set_pass') ?>
                </div>
                <div class="line"></div>
              </div>
              <div class="item <?= $step > 2 ? 'active' : '' ?>">
                <div class="item-icon">
                  <?= file_get_contents('assets/icon/bank.svg') ?>
                </div>
                <div class="item-text">
                  <?= Ty::get('bank_acc') ?>
                </div>
                <div class="line"></div>
              </div>
              <div class="item">
                <div class="item-icon">
                  <?= file_get_contents('assets/icon/check.svg') ?>
                </div>
                <div class="item-text">
                  <?= Ty::get('succeed', [], ["case" => "ucfirst"]) ?>
                </div>
              </div>
            </div>
            <?php
            if ($step == 1) {
              include 'view/register/step1.php';
            } else if ($step == 'otp') {
              include 'view/register/step_otp.php';
            } else if ($step == 2) {
              include 'view/register/step2.php';
            } else if ($step == 3) {
              include 'view/register/step3.php';
            } else if ($step == 4) {
              include 'view/register/step4.php';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  ?>
</body>

</html>