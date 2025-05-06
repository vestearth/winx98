<?php
require_once '.framework/import.php';
$type_id = isset($_GET['type']) ? $_GET['type'] : '';
$sub_id = isset($_GET['sub']) ? $_GET['sub'] : '';
$sub_comment = '';
$comment_detail = '';
$user_data = User::getCurrent();
$data = [
  'user_id' => $user_data['id'],
  'detail' => 'เข้าหน้าความคิดเห็น',
];
nga_user::addNewUserLog($code, $data);

if ($_POST) {
  if (isset($_POST['submit_comment'])) {
    $data = [
      'user_id' => $user_data['id'],
      'comment_title_id' => $sub_id,
      'rating' => isset($_POST['rating']) ? $_POST['rating'] : 0,
      'detail' =>  isset($_POST['detail']) ? $_POST['detail'] : '',
    ];

    $file = isset($_FILES['file']) ? $_FILES['file'] : '';
    $result = nga_user::addNewComment($code, $data, $file);
    if ($result['response_status']) {
      $data = [
        'user_id' => $user_data['id'],
        'detail' => 'แสดงความคิดเห็น ' . $sub_id,
      ];
      $user_log = nga_user::addNewUserLog($code, $data);
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


$rating_list = [
  [
    'name' => Ty::get('perfect'),
    'value' => 5,
    'img' => 'assets/icon/rating/excellent.png',
  ],
  [
    'name' => Ty::get('excellent'),
    'value' => 4,
    'img' => 'assets/icon/rating/good.png',
  ],
  [
    'name' => Ty::get('fair'),
    'value' => 3,
    'img' => 'assets/icon/rating/well.png',
  ],
  [
    'name' => Ty::get('bad'),
    'value' => 2,
    'img' => 'assets/icon/rating/worst.png',
  ],
  [
    'name' => Ty::get('terrible'),
    'value' => 1,
    'img' => 'assets/icon/rating/terrible.png',
  ],
];


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
    $comment = nga_management::selectCommentGroup($code);
    if ($type_id) {
      $where = [
        'comment_group_id' => $type_id,
      ];
      $sub_comment =  nga_management::selectCommentTitle($code, $where);
    }
    if ($sub_id) {
      $comment_detail =   nga_management::getCommentTitleByID($code, $sub_id);
    }
    // Aww::display($comment);
    Aww::display($sub_comment);
    // die();
    $type_name = '';
    if ($type_id) {
      foreach ($comment as $key => $value) {
        if ($value['id'] == $type_id) {
          $type_name = $value['group_name'];
        }
      }
    }


    // เช็คว่าtype นั้นมี sub ไหม ถ้ามีให้ link ไป sub เลย
    if ($sub_comment && !$sub_id) {
      Aww::redirect('?type=' . $type_id . '&sub=' . $sub_comment[0]['id']);
    }
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>
  <?php include 'layout/menu.php'; ?>
  <?php include 'layout/nmg_bg.php'; ?>
  <div class="container position-relative">

    <div class="row">
      <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item">
              <a href="index.php"><?= Ty::get('home') ?></a>
            </li>
            <li class="breadcrumb-item <?= (!$type_id) ? 'active' : '' ?> " aria-current="page">
              <a href="comment.php"><?= Ty::get('comment') ?></a>
            </li>
            <?php if ($type_name) { ?>
              <li class="breadcrumb-item active" aria-current="page"><?= $type_name ?></li>
            <?php } ?>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4 col-md-6 <?= $sub_id ? 'mobile-page' : ''  ?>">
        <h1 class="comment-title">
          <?= Ty::get('selectcategory') ?>
        </h1>
        <?php if (!$sub_comment) { ?>
          <?php foreach ($comment as $key => $list) { ?>
            <a href="?type=<?= $list['id'] ?>" class="comment-link  <?= $list['id'] == $type_id ? 'active' : '' ?>">
              <span> <?= $list['group_name'] ?> </span>
              <?= file_get_contents('assets/icon/double-arrow-right.svg') ?>
            </a>
          <?php } ?>
        <?php } else { ?>
          <?php foreach ($sub_comment as $key => $list_sub) { ?>
            <a href="?type=<?= $type_id ?>&sub=<?= $list_sub['id'] ?>" class="comment-link <?= $list_sub['id'] == $sub_id ? 'active' : '' ?>">
              <span> <?= $list_sub['title_name'] ?> </span>
              <?= file_get_contents('assets/icon/double-arrow-right.svg') ?>
            </a>
          <?php } ?>
        <?php } ?>
      </div>
      <div class="col-lg-8 col-md-6 <?= !$sub_id ? 'mobile-page' : ''  ?>">
        <?php if ($comment_detail) {  ?>
          <div class="card-comment mb-15px">
            <h3 class="font-16px mb-5px text-gold"><?= $comment_detail['title_name'] ?></h3>
            <div class="detail">
              <?= $comment_detail['description'] ?>
            </div>
          </div>
        <?php } ?>

        <div class="card-comment">
          <form method="post" enctype="multipart/form-data">
            <?php // if ($comment_detail['is_have_rating']) { 
            ?>
            <h4 class="font-16px font-Medium text-gold"><?= Ty::get('ratesatisfaction') ?></h4>
            <div class="d-flex">
              <?php foreach ($rating_list as $key => $value) { ?>
                <div class="rating-radio">
                  <input type="radio" name="rating" id="rating-<?= $value['value'] ?>" value="<?= $value['value'] ?>">
                  <label for="rating-<?= $value['value'] ?>">
                    <img src="<?= $value['img'] ?>" alt="">
                    <span><?= $value['name'] ?></span>
                  </label>
                </div>
              <?php } ?>
            </div>
            <?php // } 
            ?>
            <?php // if ($comment_detail['is_have_detail']) { 
            ?>
            <p class="font-16px mb-10px text-gold font-Medium">
              <?= Ty::get('detail', [], ["case" => "ucfirst"]) ?>
            </p>
            <textarea name="detail" rows="5" placeholder="<?= Ty::get('explainmoredetail') ?>"></textarea>
            <?php // } 
            ?>
            <?php // if ($comment_detail['is_have_file']) { 
            ?>
            <div class="d-flex align-items-center mobile-colume mobile-aligh-start">
              <p class="font-16px mb-0 mr-10px font-Medium">
                <?= Ty::get('attachedfile') ?>
              </p>
              <div class="max-w-300px file-custom">
                <?php TiwForm::normal('file', '', ['name' => 'file', 'accept' => "image/png, image/jpeg"], ['prefix' => '']); ?>
              </div>
            </div>
            <?php // } 
            ?>
            <div class="group-btn mt-15px">
              <a href="comment.php?type=<?= $type_id ?>" class="btn btn-cancel">
                <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
              </a>
              <button type="submit" class="btn btn-sub" type="submit" name="submit_comment">
                <?= 'ยืนยันความคิดเห็น'; ?>
              </button>
            </div>
          </form>
        </div>
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