<?php
require_once '.framework/import.php';

if ($is_login) {
  $user_data = User::getCurrent();
} else {
  Aww::redirect('login.php');
}
function textFormat($text = '', $pattern = '', $ex = '')
{
  $cid = ($text == '') ? '0000000000000' : $text;
  $pattern = ($pattern == '') ? '_-____-_____-__-_' : $pattern;
  $p = explode('-', $pattern);
  $ex = ($ex == '') ? '-' : $ex;
  $first = 0;
  $last = 0;
  for ($i = 0; $i <= count($p) - 1; $i++) {
    $first = $first + $last;
    $last = strlen($p[$i]);
    $returnText[$i] = substr($cid, $first, $last);
  }

  return implode($ex, $returnText);
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
  <?php
  if ($is_login) {
    $user_data = User::getCurrent();
    $alliance_data = nga_management::getAllianceByID($code, $user_data['alliance_id']);
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้าข้อมูลส่วนตัว',
    ];
    nga_user::addNewUserLog($code, $data);
    $customer_data = nga_user::getUserByID($code, $user_data['id']);
    // $system_line =  nga_management::getGeneralWebsite($code);
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>
  <?php include 'layout/winx98_bg.php'; ?>
  <?php require_once 'layout/navbanner.php'; ?>
  <?php require_once 'layout/footer_nav.php'; ?>
  <?php renderFooterNav(); ?>
  <?php renderBannerUser(); ?>
  <div class="container position-relative">

    <div class="row">
      <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item">
              <a href="index.php"><?= Ty::get('home') ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('profile') ?></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-5 col-md-6 m-auto pb-20px">
        <div class="card-content mb-20px  min-h-400px text-center" style="margin-top:15%;">
          <div class="card-content-body">
            <p class=" text-white font-18px"><?= Ty::get('profile') ?></p>
            <div class="form-group max-w-305px m-auto">
              <div class="input-icon user">
                <input type="text" name="username" id="username" class="form-input-custom" value="<?= $customer_data['username']; ?>" readonly>
              </div>
            </div>
            <?php if ($customer_data['birth_date']) { ?>
              <div class="form-group max-w-305px m-auto">
                <div class="input-icon user mt-10px">
                  <input type="text" name="username" id="username" class="form-input-custom" value="Birthday : <?= Aww::formatDate($customer_data['birth_date'], 'd M Y'); ?>" readonly>
                </div>
              </div>
            <?php } ?>
            <div class="card-bank mb-10px">
              <div class="icon-bank">
                <img src="<?= $customer_data['bank_image']; ?>" alt="" class="rounded">
              </div>
              <p class="text-white font-18px mb-5px"><?= $customer_data['bank_name_th']; ?></p>
              <h2 class="font-24px mb-10px font-Bold"><?= textFormat($customer_data['bank_number'], '___-_-_____-_', '-'); ?></h2>
              <p class="text-white font-18px mb-5px"><?= $customer_data['bank_name']; ?></p>
            </div>
            <p class="text-pink-2 font-16px my-10px"><?= Ty::get('editinfor') ?></p>
            <a href="<?= $alliance_data['line_link'] ?>" class="btn btn-main border max-w-305px">
              <img src="assets/icon/line.svg" class="mr-5px" alt="line">
              <?= $alliance_data['line_name'] ?>
            </a>
          </div>
        </div>
        <a href="change_password.php" class="btn btn-outline-light d-block w-100 mb-20px mt-50px">
          <?= Ty::get('changepass') ?>
        </a>
        <?php if (!$user_data['birth_date']) { ?>
          <!-- <a href="change_birthday.php" class="btn btn-outline-light mb-15px d-block w-100 mb-20px">
            <?= Ty::get('changehbd') ?>
          </a> -->
        <?php } ?>
        <button class="btn btn-logout" <?php Tiwdal::register('modal_logout', []); ?>>
          <?= Ty::get('Logout') ?>
        </button>
      </div>
    </div>
  </div>


  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  ?>


</body>

</html>