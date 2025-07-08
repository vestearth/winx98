<?php
require_once '.framework/import.php';
require_once 'layout/navbanner.php'; // Include the file containing renderBannerBorder
if ($_POST) {
  if (isset($_POST['submit_login'])) {
    $result = User::login($_POST['username'], $_POST['password']);
    if ($result) {
      // if ($result && $result['response_data']['user_type_id'] == 2) {
      $user_id = $result['response_data']['id'];
      $data = [
        'user_id' => $user_id,
        'detail' => 'เข้าสู่ระบบ',
      ];
      nga_user::addNewUserLog($code, $data);
      $response_redirect = 'index.php';
    } else {
      User::logout();
      $response_redirect = 'index.php';
      $response_status = 'error';
      $response_message = 'Admin cannot login !!';
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
$system_line = nga_management::getGeneralWebsite($code);
if (empty($system_line)) {
  $system_line['line_id'] = '';
  $system_line['line_link'] = 'https://line.me/R/ti/p/@152kglax?oat_content=url&ts=05140244';
}
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
$AlliasRef = !empty($getAlliasRefID) ? $getAlliasRefID : $getAlliasRef;

$banner_download_login = (isset($_COOKIE['banner_download_login']) && $_COOKIE['banner_download_login']) ? $_COOKIE['banner_download_login'] : null;

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
  Aww::loadAsset('assets/css/custom.css');
  ?>
</head>

<body>
  <?php include 'layout/winx98_bg.php'; ?>
  <?php renderBannerBorder($ref_marketing, $ref_m, 'landing'); ?>
  <div class="container">
    <?php
    $lhb_style = 'style-web-close-banner';
    if (!$banner_download_login) {
      $lhb_style = '';
    ?>
      <div class="landing-header-download">
        <div class="pos-rel">
          <div class="app-close pos-ab">
            <button type="button" class="custom-btn-top-close" id="closeModalLogin">
              <?= file_get_contents('assets/icon/cross.svg') ?>
            </button>
          </div>
          <img src="assets/images/landing/app_banner.png?gen=<?= rand(0.1, 1111); ?>" class="event_view_load_app" alt="logo">
        </div>
      </div>
    <?php } ?>
    <div class="row justify-content-center custom-header-layout <?= $lhb_style; ?>">
      <div class="col-lg-5 col-md-6 text-center">
        <div class="card-login">
          <!-- <div class="card-login-nav">
            <a href="login.php" class="active"><?= Ty::get('login') ?></a>
            <a href="signup.php"><?= Ty::get('register') ?></a>
          </div> -->
          <div class="card-login-body mt-100px">
            <div class="login-thread d-flex">
              <div>
                <div class="title d-flex">เข้าสู่ระบบ</div>
                <p class="subtitle">ยินดีต้อนรับเข้าสู่ระบบ</p>
              </div>
            </div>
            <form method="post">
              <div class="form-group">
                <label for="username"><?= Ty::get('Phonenumber') ?></label>
                <div class="input-icon user">
                  <input
                    type="text"
                    inputmode="numeric"
                    pattern="(06|08|09)\d{8}"
                    name="username"
                    id="username"
                    maxlength="10"
                    value=""
                    class="form-input-custom verticle-divide"
                    placeholder="<?= Ty::get('loginwphonenumb') ?>"
                    required
                    oninput="handlePhoneInput(this)">
                </div>
              </div>
              <div class="form-group">
                <label for="password"><?= Ty::get('Password') ?></label>
                <div class="input-icon password">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-input-custom"
                    placeholder="<?= Ty::get('pass_fill', [], ["case" => "ucfirst"]) ?>"
                    required
                    inputmode="numeric"
                    pattern="\d*">
                </div>
              </div>
              <!-- <div class="d-flex mb-20px">
                <span class="text-grey"> <?= "จำรหัสผ่านไม่ได้" ?> <a class="text-white" href="#"> <?= "ลืมรหัสผ่าน" ?></a></span>
              </div> -->
              <div class="form-group">
                <button type="submit" class="btn btn-main" name="submit_login">
                  <?= Ty::get('login') ?>
                </button>
              </div>
              <a href="signup.php<?=
                                  // สร้าง URL สำหรับ signup โดยใช้ค่า ref ที่เก็บใน cookie
                                  !empty($_COOKIE['ref_value']) && !empty($_COOKIE['ref_type'])
                                    ? ($_COOKIE['ref_type'] == 'm' ? '?m=' . urlencode($_COOKIE['ref_value']) : '?ref_m=' . urlencode($_COOKIE['ref_value']))
                                    : '?m=1'
                                  ?>" class="btn btn-register" name="submit_register">
                <?= "สมัครสมาชิก"; ?>
              </a>
              <div class="d-flex justify-content-center my-2">หรือ</div>
              <?php if (!empty($AlliasRef)) { ?>
                <a href="<?= $AlliasRef['line_link'] ?>" class="text-white">
                  <div class="border-gradient w-100">
                    <img src="source/line-login-icon.png" class="line-icon">
                    <span>ติดต่อผ่านไลน์ <?= $AlliasRef['line_name'] ?></span>
                    <p class="mb-0">สามารถติดต่อหรือสอบถามได้ตลอด 24 ชั่วโมง</p>
                  </div>
                </a>
              <?php } else { ?>
                <a href="<?= $getAlliasRef['line_link'] ?>" class="text-white">
                  <div class="qr-code-section mt-15px">
                    <div class="qr-box">
                      <?php if (!empty($getAlliasRef['line_image'])) { ?>
                        <img src="<?= $getAlliasRef['line_image']; ?>" alt="">
                      <?php } ?>
                    </div>
                  </div>
                </a>
              <? } ?>
              <!-- <span> <?= Ty::get('forgotpassword') ?> <span class="text-pink cursor-pointer" <?php Tiwdal::register('modal_forgot_password', []); ?>> <?= Ty::get('clickhere') ?></span></span> -->
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php Tiwdal::startModal('modal_forgot_password', 'modal-md modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <div class="my-10px text-center">
      <a href="<?= $getAlliasRef['line_link']; ?>" class="link-line text-gold" target="_blank">
        <?= Ty::get('contact_forgor_password') ?> :
        <?= $getAlliasRef['line_name']; ?>
      </a>
    </div>
  </div>
  <div class="modal-footer justify-content-center">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main rounded max-w-250px">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  ?>
</body>


</html>

<script>
  function handlePhoneInput(el) {
    el.value = el.value.replace(/\D/g, ''); // Only digits

    // Check if valid format
    const isValidPhone = /^(06|08|09)\d{8}$/.test(el.value);

    if (isValidPhone) {
      document.getElementById('password').focus();
    }
  }
  document.getElementById('password').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, ''); // Remove all non-digits
  });
  $(document).ready(function() {
    $(document).on('click', '.event_view_load_app', function(e) {
      $('#modal_download_app').modal('show');
    });
    $(document).on('click', '.event_show_android', function(e) {
      $('#modal_android_download_app').modal('show');
    });
    $(document).on('click', '.event_show_ios', function(e) {
      $('#modal_ios_download_app').modal('show');
    });

    $(document).on('click', '#closeModalLogin', function(e) {
      $('.landing-header-download').remove('');
      $('.custom-header-layout').css('margin-top', '0px');
      $.cookie("banner_download_login", "close_login", {
        expires: 7
      });
    });
  });
</script>