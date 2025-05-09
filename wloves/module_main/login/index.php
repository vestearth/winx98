<?php
$_WLOVES['no_check_permission'] = 1;
$_PAGE['permission']            = ['index', '', ''];
require_once '../../.framework/import.php';

if ($_POST) {
  if (isset($_POST['submit_login'])) {
    $response = User::login($_POST['username'], $_POST['password'], ['remember_me' => true]);
    if (isset($response['response_status']) && $response['response_status'] == true) {
      User_Firebase::register($response['response_data']['id'], $_POST['firebase_registration_id'], ['type' => 'web']);
      // WLoves::setTheme('dark');
      if (F_User::isDev()) {
        Aww::redirect('../../module_main/landing/?action=welcome');
      }
      Aww::redirect('../../module_main/landing/?action=welcome');
    } else {
      if (isset($response['response_detail'])) {
        Aww::notification(($response['response_detail']['message']) ? $response['response_detail']['message'] : 'Empty response', 'error');
        Aww::redirect('');
      } else if (isset($response['response_message'])) {
        // Aww::notification(($response['response_message']) ? $response['response_message'] : 'Empty response', 'error');
        Aww::session('error_login', 'error');
        Aww::session('user_login', $_POST['username']);
        Aww::session('pass_login', $_POST['password']);
        Aww::redirect('');
      }
    }
  }
}

WLoves::initSystem();

$logo_image = File::getPath('logo_image');
$background = File::getPath('signin_image');
if (strpos($background, '/placeholder/')  === false) {
  $background = $background;
} else {
  $background = '';
}
$program = F_WLoves::$initial_data['program'];
if (!isset($program)) {
  die();
}

$link = 'index.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php Structure::loadMeta('../../'); ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php include_once '../../structure/layout/blank_header.php'; ?>
  <div class="w-loves-login-container" <?= ($background) ? 'style="background-image:url(' . $background . ')"' : '' ?>>
    <div class="login-container-wrap">
      <?php if (F_User::isDev()) { ?>
        <a href="../../index.php" class="btn-back">
          <?= file_get_contents('../../structure/image/icon/arrow/left-arrow.svg') ?>
          <span>Back</span>
        </a>
      <?php } ?>
      <div class="logo-login-box">
        <div class="logo-element-group">
          <?php if (strpos($logo_image, '/placeholder/')  === false) { ?>
            <img src="<?= $logo_image  ?>" class="logo-items">
          <?php  } else { ?>
            <img src="<?= '../../' . F_OG_IMAGE_URL ?>" class="logo-items">
          <?php } ?>
        </div>
      </div>
      <form id="login" method="post" class="login-box">
        <div class="greeting-text-group text-center">
          <h6 class='font-14px font-SemiBold  mb-6px' style="color:<?= $program['color_highlight'] ?>">Welcome back to</h6>
          <h2 class='font-20px font-SemiBold text-info text-uppercase'><?= $program['program_name'] ? $program['program_name'] : 'program name' ?> </h2>
        </div>
        <?php
        $class = '';
        if (Aww::session('error_login') == 'error') {
          $class = 'is_error';
        }
        ?>
        <div class="form-group mb-15px ">
          <div class="d-flex flex-column-reverse">
            <input type="text" name="username" class="form-control <?= $class ?>" value="<?php echo (Aww::session('user_login')) ? Aww::session('user_login') : ''; ?>" required autofocus>
            <label class="control-label">Username</label>
          </div>
          <div class="empty-val-icon"></div>
          <span class="empty-val-text">Please enter an Username</span>
        </div>
        <div class="form-group mb-10px">
          <div class="d-flex flex-column-reverse">
            <input type="password" name="password" class="form-control <?= $class ?>" value="<?php echo (Aww::session('pass_login')) ? Aww::session('pass_login') : ''; ?>" required>
            <label class=" control-label">Password</label>
          </div>
          <div class="toggle-password"></div>
          <div class="empty-val-icon"></div>
          <span class="empty-val-text">Please enter an Password</span>
        </div>
        <div class="form-group mb-5px">
          <?= TiwForm::normal('checkbox', '', ['name' => 'show_password'], ['style' => '3', 'label' => 'Show password']); ?>
        </div>
        <div class="text-error-internet text-danger" style="display: none;">
          The username or password is not correct. <br>
          You entered is incorrect.
        </div>
        <?php if (Aww::session('error_login') == 'error') { ?>
          <div class="text-error">
            The username or password is not correct. <br>
            You entered is incorrect.
          </div>
        <?php
          Aww::removeSession('error_login');
          Aww::removeSession('user_login');
          Aww::removeSession('pass_login');
        }
        ?>
        <input type="hidden" name="firebase_registration_id">
        <input type="hidden" name="submit_login">
      </form>
      <div class="text-right mt-25px d-flex justify-content-between">
        <button type="button" class="btn-login">
          <span>Login</span>
          <div class="mask"></div>
        </button>
      </div>
      <!-- <div class="mt-20px text-center  font-14px text-secondary">
        If you connected account with social media
      </div>
      <div class="d-flex align-items-center mt-20px justify-content-center">
        <a href="" class="mr-10px"><img src="../../structure/image/google.png"></a>
        <a href=""><img src="../../structure/image/facebook.png"></a>
      </div> -->
      <div class="mt-20px text-center  font-14px text-secondary">
        if you found any problem please contact to <br>
        <u class="font-SemiBold"><?= ($program['support_email']) ? $program['support_email'] : 'w.lovesx@wolvescrop.com' ?></u>
      </div>
    </div>

    <?php Tiwdal::startModal('ready_login', 'modal-md modal-m500px', ['data-backdrop' => '']); ?>
    <form method="post">
      <div class="modal-body border-top-radius-10px">
        <div class="form-row">
          <div class="col-12 form-group text-center">
            <h5 class="font-18px font-Bold text-info mb-30px mt-20px">INSTALLATION COMPLETE</h5>
            <p class="text-secondary font-Medium font-16px max-w-440px mx-auto mb-35px">Your program installation is complete. You will be start program at Log in page, Enter Guardian Username & Password
              in first Log in and start to manage your program.</p>
          </div>
          <div class="col-12">
            <img src="../../structure/image/img-ready-login.png" alt="" class="img-fluid">
          </div>
        </div>
      </div>
    </form>
    <?php Tiwdal::endModal() ?>

    <?php include_once '../../structure/layout/footer.php'; ?>
    <?php Structure::loadFooter('../../'); ?>

    <script src="https://www.gstatic.com/firebasejs/8.2.10/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.2.10/firebase-messaging.js"></script>
    <script>
      var firebaseConfig = {
        apiKey: "AIzaSyDmA4xJ5tM61dl5eCigzulO-CuUwTt7Px8",
        authDomain: "wolvesmain2020.firebaseapp.com",
        databaseURL: "https://wolvesmain2020.firebaseio.com",
        projectId: "wolvesmain2020",
        storageBucket: "wolvesmain2020.appspot.com",
        messagingSenderId: "525494405059",
        appId: "1:525494405059:web:c995d2fe0d9afb2a871f76",
        measurementId: "G-07CXLBQLNN"
      };
      firebase.initializeApp(firebaseConfig);
      const messaging = firebase.messaging();
      messaging.getToken({
        vapidKey: 'BDVQCUsPbdbuooM0Lk_yDBcvpkI1HGouaztMlQV6ei7el2O3iPz4LfY1l6FMGP-apAvZHBNIZ7xWpoLsnrdrVMI'
      }).then((currentToken) => {
        if (currentToken) {
          $('input[name="firebase_registration_id"]').val(currentToken);
        } else {
          console.log('No registration token available. Request permission to generate one.');
        }
      }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
      });
    </script>

    <script>
      $(document).ready(function() {
        if ($('input[name=password]').val()) {
          $('.toggle-password').addClass('show');
        }
        $('.btn-login').on('click', function() {

          var username = $('#login').find('input[name=username]');
          var password = $('#login').find('input[name=password]');
          username.blur();
          password.blur();

          if (!username.val()) {
            username.addClass('empty-val');
            username.parents('.form-group').find('.empty-val-icon').addClass('show');
            username.parents('.form-group').find('.empty-val-text').text('Please enter an Username');
            username.parents('.form-group').find('.empty-val-text').show();
            // username.focus();
          } else {
            // password.focus();
          }
          if (!password.val()) {
            password.addClass('empty-val');
            password.parents('.form-group').find('.empty-val-icon').addClass('show');
            password.parents('.form-group').find('.empty-val-text').text('Please enter an Password');
            password.parents('.form-group').find('.empty-val-text').show();
          }
          if (username.val() && password.val()) {
            $('#login').submit();
          }
        });


        $('.toggle-password').click(function(e) {
          e.preventDefault();
          $(this).toggleClass('show');
          $(this).parent().find('input[name=password]').val('');
          $(this).parent().find('input[name=password]').addClass('empty-val');
          $(this).parents('.form-group').find('.empty-val-icon').addClass('show');
          $(this).parents('.form-group').find('.empty-val-text').text('This field is required!');
          $(this).parents('.form-group').find('.empty-val-text').toggle();
          $(this).parent().find('input[name=password]').focus();

        });
        $('input[name=show_password]').on('change', function() {
          if ($(this).is(':checked')) {
            $('input[name=password]').attr('type', 'text');
            $('input[name=password]').focus();
          } else {
            $('input[name=password]').attr('type', 'password');
          }
        });
        $('input[name=username]').on('keyup', function() {
          if ($(this).hasClass('empty-val')) {
            $(this).removeClass('empty-val');
            $(this).parents('.form-group').find('.empty-val-icon').removeClass('show');
            $(this).parents('.form-group').find('.empty-val-text').toggle();
          }
          var format = /[!@#$%^&*()+\-=\[\]{};':"\\|,.<>\/?]+/;
          if (format.test($(this).val())) {
            $(this).addClass('empty-val');
            $(this).parents('.form-group').find('.empty-val-text').text('Please Enter a Valid Username');
            $(this).parents('.form-group').find('.empty-val-text').toggle();
          } else {}
        });
        $('input[name=password]').on('keyup', function() {
          if ($(this).hasClass('empty-val')) {
            $(this).removeClass('empty-val');
            $(this).parents('.form-group').find('.empty-val-icon').removeClass('show');
            $(this).parents('.form-group').find('.empty-val-text').toggle();
          }

          if ($(this).val()) {
            if (!$('.toggle-password').hasClass('show')) {
              $('.toggle-password').addClass('show');
            }
          }
        });

        $(document).on("keydown", function(e) {
          if (e.keyCode === 13) {
            e.preventDefault();
            $('button.btn-login').trigger('click');
          }
        });

        $('.render-modal').click(function(e) {
          $('#ready_login').modal('hide')
        });

        <?php if (isset($_GET['success'])) { ?>
          $('#ready_login').modal('show');
          history.replaceState(null, null, 'index.php');
          setTimeout(() => {
            $('#ready_login').modal('hide');
          }, 6000);
        <?php } ?>
      });
    </script>
</body>

</html>