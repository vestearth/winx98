<?php
require_once '.framework/import.php';

require_once 'layout/navbanner.php'; // Include the file containing renderBannerBorder
$step = (isset($_GET['step']) && $_GET['step']) ? $_GET['step'] : 1;
// $ref_id = isset($_GET['ref']) ? $_GET['ref'] : '';


// Priority: URL parameter > cookie > default
$ref_from_url = '';
$ref_type = '';

// 1. เช็ค URL parameter ก่อน
if (!empty($_GET['m'])) {
  $ref_from_url = $_GET['m'];
  $ref_type = 'm';
} elseif (!empty($_GET['ref_m'])) {
  $ref_from_url = $_GET['ref_m'];
  $ref_type = 'ref_m';
}

// 2. ถ้ามี URL parameter ให้เซฟใน cookie
if (!empty($ref_from_url)) {
  setcookie('ref_value', $ref_from_url, time() + (86400 * 30), "/");
  setcookie('ref_type', $ref_type, time() + (86400 * 30), "/");
  $ref_m = ($ref_type == 'm') ? $ref_from_url : '';
  $ref_marketing = $ref_from_url;
} else {
  // 3. ถ้าไม่มีใน URL ให้เช็ค cookie
  if (!empty($_COOKIE['ref_value']) && !empty($_COOKIE['ref_type'])) {
    $ref_from_cookie = $_COOKIE['ref_value'];
    $cookie_type = $_COOKIE['ref_type'];
    $ref_m = ($cookie_type == 'm') ? $ref_from_cookie : '';
    $ref_marketing = $ref_from_cookie;
  } else {
    // 4. ถ้าไม่มีใน cookie ให้ใช้ m=1 เป็น default
    $ref_m = '1';
    $ref_marketing = '1';
    setcookie('ref_value', '1', time() + (86400 * 30), "/");
    setcookie('ref_type', 'm', time() + (86400 * 30), "/");
  }
}

// ตรวจสอบว่า $ref_m มีในระบบหรือไม่
$getAlliasRefID = nga_management::getAllianceByID($code, $ref_m);
if (!empty($ref_m) && isset($getAlliasRefID['ref_link'])) {
  // ถ้า m มีค่าและหาเจอในระบบ ให้ใช้ m เป็น ref_marketing
  $ref_marketing = $ref_m;
} else {
  // ถ้า m ไม่มีในระบบ ให้ใช้ ref_marketing จาก cookie หรือ default
  if (empty($ref_marketing)) {
    $ref_marketing = 'z0e380297';
  }
}

$getAlliasRef = nga_management::getAllianceByRefLink($code, $ref_marketing);


$data_username = (isset($_POST['username']) && $_POST['username']) ? $_POST['username'] : '';
$ref_id_link = (isset($_POST['ref_id']) && $_POST['ref_id']) ? $_POST['ref_id'] : '';
$ref_market = (isset($_POST['ref_marketing']) && $_POST['ref_marketing']) ? $_POST['ref_marketing'] : '';
$data_password = (isset($_POST['password']) && $_POST['password']) ? $_POST['password'] : '';
$data_bank_id = (isset($_POST['bank_id']) && $_POST['bank_id']) ? $_POST['bank_id'] : '';
$data_bank_account = (isset($_POST['bank_account']) && $_POST['bank_account']) ? $_POST['bank_account'] : '';


if ($_POST) {
  if (isset($_POST['submit_register'])) {
    // Use $getAlliasRefID if $ref_m is set, otherwise $getAlliasRef
    if (!empty($ref_m) && isset($getAlliasRefID['ref_link'])) {
      $ref_checked = $getAlliasRefID['ref_link'];
    } elseif (isset($getAlliasRef['ref_link'])) {
      $ref_checked = $getAlliasRef['ref_link'];
    } else {
      $ref_checked = '';
    }

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
    $bank_name = trim($_POST['bank_name']) . ' ' . trim($_POST['bank_name2']);
    $bank_name = preg_replace('/\s+/', ' ', $bank_name);

    $data = [
      'username' => htmlspecialchars(trim($_POST['username'])),
      'password' => $password,
      'bank_abb' => htmlspecialchars(trim($_POST['bank_id'])),
      'bank_number' => htmlspecialchars(trim($_POST['bank_account'])),
      'bank_name' => htmlspecialchars($bank_name),
      'line_id' => htmlspecialchars(trim($_POST['line_id'])),
      'user_type_id' => 2,
    ];

    if ($ref_checked) {
      $data['ref_link'] = $ref_checked;
      $result = nga_user::addNewUserFromAlliance($code, $data);
    } else {
      $result = nga_user::addNewUser($code, $data, false, true);
    }
    if ($result['response_status'] || $result['response_message'] == 'มีบัญชีนี้ในระบบแล้ว') {
      $force_login = User::login($_POST['username'], $password);
      $response_message = $force_login['response_message'];
      $response_redirect = 'index.php';
    } else {
      $response_message = $result['response_message'];
    }
    $response_redirect = 'login.php' . (
      // สร้าง URL สำหรับ redirect โดยใช้ค่า ref ที่เก็บใน cookie
      !empty($_COOKIE['ref_value']) && !empty($_COOKIE['ref_type'])
      ? ($_COOKIE['ref_type'] == 'm' ? '?m=' . urlencode($_COOKIE['ref_value']) : '?ref_m=' . urlencode($_COOKIE['ref_value']))
      : '?m=1'
    );
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
  <?php include 'layout/winx98_bg.php'; ?>
  <?php renderBannerBorder($ref_marketing, $ref_m, 'landing'); ?>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-6 text-center">
        <div class="card-login">
          <div class="card-login-body mt-85px">
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