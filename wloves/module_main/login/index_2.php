<?php
$_WLOVES['no_check_permission'] = 1;
$_PAGE['permission']            = ['index', '', ''];
require_once '../../.framework/import.php';

// echo '<pre>';
// print_r($_REQUEST);
// echo '</pre>';
// die();
if (isset($_GET)) {
  if (isset($_GET['ticket'])) {
    $response = hku_sso::loginSso('mhgst', $_GET['ticket']);
    if (isset($response['response_status']) && $response['response_status'] == true) {
      Aww::redirect('../../module_main/landing/?action=welcome');
    } else {
      if (isset($response['response_message'])) {
        Aww::notification(($response['response_message']) ? $response['response_message'] : 'Error', 'error');
        Aww::redirect('../../module_main/login/index.php?error=1');
      }
    }
  }
}

if (User::getCurrentUserID()) {
  Aww::redirect('../../module_main/landing/?action=welcome');
}
// $url =  Smb_Aad::getAuthorizationLink('yedfj');


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
$link = 'index_2.php';

$url = 'https://cas.ust.hk/cas/login?service=http%3A%2F%2Fsimpler2.smerp.hk%2Fsimpler%2Fmodule_main%2Flogin%2Findex.php';
// $url = 'https://cas.ust.hk/cas/login?service=http%3A%2F%2F128.199.207.248%3A8312%2Fwloves%2Fmodule_main%2Flogin%2Findex.php';
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
      <div class="logo-login-box">
        <div class="logo-element-group">
          <?php if (strpos($logo_image, '/placeholder/')  === false) { ?>
            <img src="<?= $logo_image  ?>" class="logo-items h-auto">
          <?php  } else { ?>
            <img src="<?= '../../' . F_OG_IMAGE_URL ?>" class="logo-items">
          <?php } ?>
        </div>
      </div>
      <div class="greeting-text-group text-center">
        <h6 class="font-26px">Welcome back!</h6>
      </div>
      <div class="login-box">
        <div class="text-right mt-25px d-flex justify-content-between align-items-center">
          <a href="<?= $url ?>" class="btn-login pt-10px">
            <span>Login SSO</span>
            <div class="mask"></div>
          </a>
        </div>
      </div>
      <div class="mt-20px text-center  font-14px text-secondary">
        <br>
        <a href="<?= $link ?>" class="mt-5px" style="color:<?= $program['color_highlight'] ?>">Go to System Login</a>
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