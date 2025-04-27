<?php
require_once '.framework/import.php';
require_once 'layout/navbanner.php'; // Include the file containing renderBannerBorder
$step = (isset($_GET['step']) && $_GET['step']) ? $_GET['step'] : 1;
$ref_id = isset($_GET['ref']) ? $_GET['ref'] : '';
$ref_marketing = isset($_GET['ref_m']) ? $_GET['ref_m'] : '';
$check_member = nga_user::checkMembercode($code, $ref_id);
$upline_no = isset($check_member['tel_no']) ? $check_member['tel_no'] : '';
// if ($ref_marketing) {
//   $redirect_link = "http://$_SERVER[HTTP_HOST]";
//   $redirect_link = $redirect_link . '/landing.php';
//   $check_marketing = nga_user::checkAllianceActiveByReflink($code, $ref_marketing);
//   $market_response = ($check_marketing['response_status']) ? 'accept' : Aww::redirect($redirect_link);
// }

// $data_username = (isset($_POST['username']) && $_POST['username']) ? $_POST['username'] : '';
// $ref_id_link = (isset($_POST['ref_id']) && $_POST['ref_id']) ? $_POST['ref_id'] : '';
// $ref_market = (isset($_POST['ref_marketing']) && $_POST['ref_marketing']) ? $_POST['ref_marketing'] : '';
// $data_password = (isset($_POST['password']) && $_POST['password']) ? $_POST['password'] : '';
// $data_bank_id = (isset($_POST['bank_id']) && $_POST['bank_id']) ? $_POST['bank_id'] : '';
// $data_bank_account = (isset($_POST['bank_account']) && $_POST['bank_account']) ? $_POST['bank_account'] : '';


if ($_POST) {
  // $check_bank_allow = nga_user::getBankNameByBankNo($code, $_POST['bank_id'], $_POST['bank_account']);
  // Aww::display($check_bank_allow);
  // die();
  if (isset($_POST['submit_register'])) {
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
      'upline_member_code' => $_POST['upline_member_code'],
      'user_type_id' => 2,
    ];

    $result = nga_user::addNewUser($code, $data, false, true);
    Aww::display($result);
    die();
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
  Aww::loadAsset('assets/css/custom.css');
  ?>
</head>

<body>
  <?php include 'layout/nmg_bg.php'; ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-6 text-center">
        <?php renderBannerBorder(); ?>
        <div class="card-login">
          <div class="card-login-body">
            <div class="login-thread d-flex">
              <div>
                <div class="title d-flex">สมัครสมาชิก</div>
                <p class="subtitle">ขั้นตอนง่าย ๆ ในการสมัครสมาชิก</p>
              </div>
            </div>
            <?php
            include 'view/register/signup_form.php';
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