<?php
require_once '.framework/import.php';
if ($_POST) {
  if (isset($_POST['submit_login'])) {
    $result = User::login($_POST['username'], $_POST['password']);
    if ($result) {
      $response_redirect = 'index.php';
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
$uncount_page = 'login';
$system_line =  nga_management::getGeneralWebsite($code);


if ($is_login) {
  Aww::redirect('index.php');
}
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
  <div class="container maintain-page">
    <div class="row justify-content-center maintain-margin">
      <div class="col-lg-5 col-md-6 text-center">
        <div class="logo">
          <img src="assets/images/logo.png?v=2" alt="Logo">
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <div class="text-center mt-20px">
        <span class="title-maintain">
          กำลัง<span class="colour">ปรับปรุงระบบ</span>
        </span>
        <p class="sub-maintain">
          ขออภัยในความไม่สะดวก เราจำเป็นต้องใช้เวลาซักครู่ เพื่อปรับปรุงระบบให้ดียิ่งขึ้น โปรดกลับมาอีกครั้งในภายหลัง
        </p>
      </div>
    </div>
    <div class="img-maintain">
      <img src="assets/images/maintain/mt-icon.png?v=2" alt="Logo">
    </div>
  </div>

  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  ?>
</body>

</html>