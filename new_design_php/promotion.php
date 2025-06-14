<?php
require_once '.framework/import.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  ?>
</head>

<body>
  <?php
  // if ($is_login) {
  //   $user_data = User::getCurrent();
  //   $where = [
  //     'user_id' => $user_data['id'],
  //     'is_read' => "'0'"
  //   ];
  //   $notification = User_Notification::selectNotification($code, $where);
  //   $options = [
  //     'sort'        => ['insert_date_time' => 'DESC']
  //   ];
  //   $promotion_list = nga_management::selectUserPromotion($code, $user_data['id'], $options);
  //   $system_line =  nga_management::getGeneralWebsite($code);

  //   $ref_id = [];
  //   if ($notification) {
  //     foreach ($notification as $key => $value) {
  //       $ref_id[] = $value['ref_id'];
  //       $data = [
  //         'is_read' => 1
  //       ];
  //       User_Notification::updateNotification($code, $value['id'], $data);
  //     }
  //   }
  // } else {
  //   Aww::redirectOG('landing.php');
  // }

  if ($is_login) {
    $system_line =  nga_management::getGeneralWebsite($code);
    $user_data = User::getCurrent();
    $alliance_data = nga_management::getAllianceByID($code, $user_data['alliance_id']);
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้าโปรโมชั่น',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $where = [
      'user_id' => $user_data['id'],
      'is_read' => "'0'"
    ];
    $options = [
      'sort'        => ['insert_date_time' => 'DESC']
    ];
    $notification = User_Notification::selectNotification($code, $where);
    $promotion_list = nga_management::selectUserPromotion($code, $user_data['id'], $options);
    $sum_bet = 0;
    $hbd_promo = nga_management::getPromotionBirthday($code, $user_data['id']);
    if (date('m') == date('m', strtotime($user_data['birth_date']))) {
      $sum_bet_data = nga_user::getUserSumBet($code, $user_data['id'], date('Y-m'));
      if ($sum_bet_data) {
        $sum_bet = $sum_bet_data['sum_bet'];
      }
    }
    $receive = 0;
    foreach ($hbd_promo['user_group_receive'] as $key => $value) {
      if ($value['manage_user_group_id'] == $user_data['user_group_id']) {
        $receive = $value['receive_amount'];
        break;
      }
    }

    $special_promo = nga_management::getPromotionSpecialDay($code, $user_data['id']);
    $receive_special = 0;
    foreach ($special_promo['user_group_receive'] as $key => $value) {
      if ($value['manage_user_group_id'] == $user_data['user_group_id']) {
        $receive_special = $value['receive_amount'];
        break;
      }
    }

    $lucky_promo = nga_management::getPromotionMonthly($code, $user_data['id']);
    $receive_lucky = 0;
    $deposit_require = 0;
    foreach ($lucky_promo['user_group_receive'] as $key => $value) {
      if ($value['manage_user_group_id'] == $user_data['user_group_id']) {
        $receive_lucky = $value['receive_amount'];
        $deposit_require = $value['deposit_require'];
        break;
      }
    }

    $ref_id = [];
    if ($notification) {
      foreach ($notification as $key => $value) {
        $ref_id[] = $value['ref_id'];
        $data = [
          'is_read' => 1
        ];
        User_Notification::updateNotification($code, $value['id'], $data);
      }
    }
    $promo_rank_first_depo = nga_management::selectPromotionDepositForUser($code, $user_data['id']);
    $user_options = [
      'sort'        => isset($_POST['data_sort']) && $_POST['data_sort'] ? $_POST['data_sort'] : ['sort_order_id' => 'ASC']
    ];
    $user_group = nga_management::selectUserGroup($code, [], $user_options);
    $count_user_group = count($user_group);
  } else {
    Aww::redirectOG('login.php');
  }
  ?>
  <?php include 'layout/menu.php'; ?>
  <?php include 'layout/winx98_bg.php'; ?>
  <div class="container position-relative">

    <div class="row">
      <div class="col-12 mb-20px">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item active" aria-current="page"><?= 'สิทธิพิเศษตาม Rank' ?></li>
          </ol>
        </nav>
        <div class="table-custom">
          <div class="table-responsive">
            <table class="table-theme w-100">
              <thead>
                <tr>
                  <th></th>
                  <?php foreach ($user_group as $user_rank) { ?>
                    <th class="py-10px">
                      <div>
                        <div class="img-rank">
                          <div class="user-group-img">
                            <img src="<?= $user_rank['user_group_image'] ?>">
                          </div>
                        </div>
                        <p class="mb-0 text-center px-10px text-nowrap"><?= $user_rank['name'] ?></p>
                      </div>
                    </th>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="p-15px" thin-cell>โปรโมชันวันเกิด</td>
                  <?php foreach (range(1, $count_user_group) as $key => $count_user) {
                    $keys = $key + 1;
                    if ($keys > 3) {
                      $icon = 'assets/icon/icon-rank-checked.svg';
                    } else {
                      $icon = 'assets/icon/icon-rank-cancel.svg';
                    }
                  ?>
                    <td class="text-center align-middle">
                      <img src="<?= $icon; ?>">
                      <?php if ($keys == 4) { ?>
                        <p class="mb-0 font-14px">
                          300 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 5) { ?>
                        <p class="mb-0 font-14px">
                          500 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 6) { ?>
                        <p class="mb-0 font-14px">
                          700 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 7) { ?>
                        <p class="mb-0 font-14px">
                          1000 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 8) { ?>
                        <p class="mb-0 font-14px">
                          2000 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 9) { ?>
                        <p class="mb-0 font-14px">
                          3000 <?= Ty::get('credit') ?>
                        </p>
                      <?php } ?>
                    </td>
                  <?php } ?>
                </tr>
                <tr>
                  <td class="p-15px" thin-cell>โปรโมชันวันพิเศษ</td>
                  <?php foreach (range(1, $count_user_group) as $key => $count_user) {
                    $keys = $key + 1;
                    if ($keys > 2) {
                      $icon = 'assets/icon/icon-rank-checked.svg';
                    } else {
                      $icon = 'assets/icon/icon-rank-cancel.svg';
                    }
                  ?>
                    <td class="text-center align-middle">
                      <img src="<?= $icon; ?>">
                      <?php if ($keys == 3) { ?>
                        <p class="mb-0 font-14px">
                          50 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 4) { ?>
                        <p class="mb-0 font-14px">
                          100 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 5) { ?>
                        <p class="mb-0 font-14px">
                          200 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 6) { ?>
                        <p class="mb-0 font-14px">
                          300 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 7) { ?>
                        <p class="mb-0 font-14px">
                          400 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 8) { ?>
                        <p class="mb-0 font-14px">
                          600 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 9) { ?>
                        <p class="mb-0 font-14px">
                          800 <?= Ty::get('credit') ?>
                        </p>
                      <?php } ?>
                    </td>
                  <?php } ?>
                </tr>
                <tr>
                  <td class="p-15px align-top" thin-cell>โปรโมชันรับโชครายเดือน</td>
                  <?php foreach (range(1, $count_user_group) as $key => $count_user) {
                    $keys = $key + 1;
                    if ($keys > 2) {
                      $icon = 'assets/icon/icon-rank-checked.svg';
                    } else {
                      $icon = 'assets/icon/icon-rank-cancel.svg';
                    }
                  ?>
                    <td class="text-center align-top">
                      <img src="<?= $icon; ?>" class="pt-15px">
                      <?php if ($keys == 3) { ?>
                        <p class="mb-0 font-14px">
                          Silver มียอด
                        </p>
                        <p class="mb-0 font-14px">
                          ฝากสะสมเดือน
                        </p>
                        <p class="mb-0 font-14px">
                          ก่อนหน้า
                        </p>
                        <p class="mb-0 font-14px">
                          1000 <?= Ty::get('credit') ?> :
                        </p>
                        <p class="mb-0 font-14px">
                          50 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 4) { ?>
                        <p class="mb-0 font-14px">
                          Gold มียอด
                        </p>
                        <p class="mb-0 font-14px">
                          ฝากสะสมเดือน
                        </p>
                        <p class="mb-0 font-14px">
                          ก่อนหน้า
                        </p>
                        <p class="mb-0 font-14px">
                          2000 <?= Ty::get('credit') ?> :
                        </p>
                        <p class="mb-0 font-14px">
                          100 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 5) { ?>
                        <p class="mb-0 font-14px">
                          Diamond มียอด
                        </p>
                        <p class="mb-0 font-14px">
                          ฝากสะสมเดือน
                        </p>
                        <p class="mb-0 font-14px">
                          ก่อนหน้า
                        </p>
                        <p class="mb-0 font-14px">
                          5000 <?= Ty::get('credit') ?> :
                        </p>
                        <p class="mb-0 font-14px">
                          200 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 6) { ?>
                        <p class="mb-0 font-14px">
                          Conqueror มียอด
                        </p>
                        <p class="mb-0 font-14px">
                          ฝากสะสมเดือน
                        </p>
                        <p class="mb-0 font-14px">
                          ก่อนหน้า
                        </p>
                        <p class="mb-0 font-14px">
                          10000 <?= Ty::get('credit') ?> :
                        </p>
                        <p class="mb-0 font-14px">
                          300 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 7) { ?>
                        <p class="mb-0 font-14px">
                          VIP มียอด
                        </p>
                        <p class="mb-0 font-14px">
                          ฝากสะสมเดือน
                        </p>
                        <p class="mb-0 font-14px">
                          ก่อนหน้า
                        </p>
                        <p class="mb-0 font-14px">
                          10000 <?= Ty::get('credit') ?> :
                        </p>
                        <p class="mb-0 font-14px">
                          400 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 8) { ?>
                        <p class="mb-0 font-14px">
                          Conqueror มียอด
                        </p>
                        <p class="mb-0 font-14px">
                          ฝากสะสมเดือน
                        </p>
                        <p class="mb-0 font-14px">
                          ก่อนหน้า
                        </p>
                        <p class="mb-0 font-14px">
                          30000 <?= Ty::get('credit') ?> :
                        </p>
                        <p class="mb-0 font-14px">
                          600 <?= Ty::get('credit') ?>
                        </p>
                      <?php } else if ($keys == 9) { ?>
                        <p class="mb-0 font-14px">
                          Conqueror มียอด
                        </p>
                        <p class="mb-0 font-14px">
                          ฝากสะสมเดือน
                        </p>
                        <p class="mb-0 font-14px">
                          ก่อนหน้า
                        </p>
                        <p class="mb-0 font-14px">
                          30000 <?= Ty::get('credit') ?> :
                        </p>
                        <p class="mb-0 font-14px">
                          800 <?= Ty::get('credit') ?>
                        </p>
                      <?php } ?>
                    </td>
                  <?php } ?>
                </tr>
                <tr>
                  <td class="p-15px" thin-cell>โปรโมชันฝากแรกของวัน</td>
                  <td class="text-center">
                    <img src="<?= 'assets/icon/icon-rank-cancel.svg'; ?>" class="pt-15px">
                  </td>
                  <td class="text-center py-15px font-14px" colspan='2'>
                    <p class="mb-0">Bronze-Silver</p>
                    <p class="mb-0">20% โบนัสรายวัน ฝากแรก</p>
                    <p class="mb-0">ของวันโบนัสสูงสุด 1,000</p>
                    <p class="mb-0">เทิร์นโอเวอร์ 10 เท่า</p>
                  </td>
                  <td class="text-center py-15px font-14px" colspan='2'>
                    <p class="mb-0">Gold-Diamond</p>
                    <p class="mb-0">30% โบนัสรายวัน ฝากแรก</p>
                    <p class="mb-0">ของวันโบนัสสูงสุด 3,000</p>
                    <p class="mb-0">เทิร์นโอเวอร์ 15 เท่า</p>
                  </td>
                  <td class="text-center py-15px font-14px">
                    <p class="mb-0">Con</p>
                    <p class="mb-0">40% โบนัสรายวัน ฝากแรก</p>
                    <p class="mb-0">ของวันโบนัสสูงสุด 6,000</p>
                    <p class="mb-0">เทิร์นโอเวอร์ 18 เท่า</p>
                  </td>
                  <td class="text-center py-15px font-14px" colspan='3'>
                    <p class="mb-0">VIP-VVVIP</p>
                    <p class="mb-0">50% โบนัสรายวัน ฝากแรกของวันโบนัสสูงสุด</p>
                    <p class="mb-0">โบนัสสูงสุด 10,000 เทิร์นโอเวอร์</p>
                    <p class="mb-0">20 เท่า</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-custom mb-10px">
            <li class="breadcrumb-item">
              <a href="index.php"><?= Ty::get('home') ?></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('promotions') ?></li>
          </ol>
        </nav>
      </div>
    </div>
    <div class="row">
      <?php if ($promotion_list) { ?>
        <?php foreach ($promotion_list as $key => $list) { ?>
          <div class="col-lg-10  mb-20px m-auto">
            <div class="title-promotion"><?= $list['name'] ?></div>
            <div class="card-promotion">
              <div class="card-promotion-img">
                <img src="<?= $list['promotion_image'] ?>" alt="promotion">
                <div class="card-promotion-point">
                  <?= Ty::get('yougotbonus') ?> <span class="text-pink"><?= number_format($list['amount_wait_confirm'], 2)  ?> <?= $list['type'] == 'credit' ? Ty::get('baht') : Ty::get('point') ?></span>
                </div>
                <?php if (in_array($list['id'], $ref_id)) {  ?>
                  <div class="ribbon-new">
                    <img src="assets/images/ribbon-new.png" alt="">
                  </div>
                <?php } ?>
              </div>
              <?php $btn_allow = $list['amount_wait_confirm'] > 0 ? '' : 'disabled'; ?>
              <div class="card-promotion-content">
                <div class="card-promotion-content-title">
                  <span> <?= Ty::get('yourbonus') ?> <?= number_format($list['amount_wait_confirm'], 2)  ?></span>
                  <button class="btn btn-main w-150px rounded event_confirm" promotion_name="<?= $list['name'] ?>" promotion_id="<?= $list['id'] ?>" <?= $btn_allow; ?> user_id="<?= $user_data['id']; ?>" unit_type="<?= $list['type']; ?>" amount="<?= $list['amount_wait_confirm']; ?>"><?= Ty::get('receive') ?><?= $list['type'] == 'credit' ? Ty::get('credit') : Ty::get('point') ?></button>
                </div>
                <div class="sub-text event_add_class text-center text-pink-2 mt-15px" data-toggle="collapse" data-target="#table_<?= $list['id'] ?>" type="button" aria-expanded="false" aria-controls="table<?= $list['id'] ?>">รายละเอียด</div>
                <div class="table-responsive collapse event_collapse" id="table_<?= $list['id'] ?>">
                  <table class="table table-custom">
                    <thead>
                      <tr>
                        <th scope="col" colspan="2" class="text-white"><?= Ty::get('terms_conds') ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'deposit') { ?>
                        <tr>
                          <td><?= Ty::get('deposit_bal', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end"><?= $list['sum_deposit']; ?> <?= Ty::get('baht') ?></td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('notmore', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end">
                            <?= ($list['is_per_day_unlimit']) ?  Ty::get('unlimited_amount', [], ["case" => "ucfirst"]) : $list['time_per_day']; ?> <?= Ty::get('times_person') ?>
                          </td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('time_per', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end">
                            <?= ($list['is_per_user_unlimit']) ?  Ty::get('unlimited_amount', [], ["case" => "ucfirst"]) : $list['time_per_user']; ?> <?= Ty::get('times_pro') ?>
                          </td>
                        </tr>
                      <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'new_user') { ?>
                        <tr>
                          <td><?= Ty::get('begin_datetime', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end"> <?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('end_datetime', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('amount_limit', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end">
                            <?= ($list['is_max_user_unlimit']) ? Ty::get('unlimited_amount') : $list['max_user']; ?> <?= Ty::get('person') ?>
                          </td>
                        </tr>
                      <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'invite_friend') { ?>
                        <tr>
                          <td><?= Ty::get('begin_datetime', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end"><?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('end_datetime', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('complete_invite'), [], ["case" => "ucfirst"] ?></td>
                          <td class="text-pink text-end"><?= $list['sum_invite_friend']; ?> <?= Ty::get('person') ?></td>
                        </tr>
                      <?php } else if ($list['receive_type'] == 'manual') { ?>
                        <tr>
                          <td><?= Ty::get('begin_datetime', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end"><?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('end_datetime', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('contact', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end"><?= $list['contact']; ?></td>
                        </tr>
                      <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'excess_lost') { ?>
                        <tr>
                          <td><?= Ty::get('loss_than', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end">
                            <?= $list['sum_excess_lost']; ?> <?= $list['type'] == 'credit' ? Ty::get('baht') : Ty::get('point') ?>
                          </td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('receive', [], ["case" => "ucfirst"]) ?><?= $list['type'] == 'credit' ? Ty::get('credit') : Ty::get('point') ?><?= Ty::get('return') ?></td>
                          <td class="text-pink text-end">
                            <?= $list['credit_point_back_percent']; ?>% <?= Ty::get('loss_money') ?>
                          </td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('receive', [], ["case" => "ucfirst"]) ?><?= $list['type'] == 'credit' ? Ty::get('credit') : Ty::get('point') ?><?= Ty::get('re_not_more') ?></td>
                          <td class="text-pink text-end" nowarp>
                            <?= $list['max_credit_point_back'] ?> <?= $list['type'] == 'credit' ? Ty::get('baht') : Ty::get('point') ?>
                          </td>
                        </tr>
                      <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'play_game') { ?>
                        <tr>
                          <td><?= Ty::get('complete_games', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end" nowarp><?= $list['sum_play_game']; ?> <?= Ty::get('times') ?></td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('notmore', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end" nowarp><?= $list['time_per_day']; ?> <?= Ty::get('times_person') ?></td>
                        </tr>
                        <tr>
                          <td><?= Ty::get('time_player', [], ["case" => "ucfirst"]) ?></td>
                          <td class="text-pink text-end" nowarp><?= $list['time_per_user'] ?> <?= Ty::get('times_pro') ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                    <tfoot>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <ul>
                            <li class="text-table">
                              <span class="text-pink-2 font-17px"> <?= Ty::get('note', [], ["case" => "ucfirst"]) ?> :</span>
                              <br>
                              <div class="mt--20px" style="white-space: pre-line;">
                                <?= $list['description']; ?>
                              </div>
                            </li>
                          </ul>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="mb-20px m-auto">
            <?php if ($list['is_last_receive'] && $list['is_received'] && $user_data['turn_over_promotion'] != 0) { ?>
              <div class="bg-accept-promo text-center mb-15px">
                กำลังใช้งานโปรโมชั่นนี้ ไม่สามารถใช้โปรอื่นได้
              </div>
            <?php } ?>
          </div>
        <?php  } ?>
      <?php } ?>

      <?php
      if ($user_data['birth_date'] && ($hbd_promo['is_active'] == 1)) {
      ?>
        <div class="col-lg-10  mb-20px m-auto">
          <form method="post">
            <div class="title-promotion"><?= ucfirst($hbd_promo['name']) ?></div>
            <div class="card-promotion">
              <div class="card-promotion-img">
                <div class="img-1by1 holder">
                  <img src="<?= $hbd_promo['img_path'] ?>" alt="promotion">
                </div>
                <div class="card-promotion-point">
                  <?= Ty::get('yougotbonus') ?> <span class="text-brown font-Bold"><?= number_format($receive, 2)  ?> <?= Ty::get('baht'); ?></span>
                </div>
                <div class="ribbon-new">
                  New
                </div>
              </div>
              <div class="card-promotion-content">
                <?php $btn_allow = date('m') == (date('m', strtotime($user_data['birth_date'])) && !$hbd_promo['is_receive']) ? '' : 'disabled'; ?>
                <div class="card-promotion-title-group">
                  <div class="hr-effect">
                    <img src="assets/images/wink-line.png" alt="">
                  </div>
                  <span class="font-18px text-white"><?= Ty::get('yougotbonus') ?></span>
                  <div class="card-promotion-content-title mb-15px">
                    <span class="text-bg"><?= number_format($receive, 2)  ?></span>
                    <button class="btn btn-main w-150px event_birthday_promotion" <?= $btn_allow; ?> promotion_id="<?= $hbd_promo['id'] ?>" user_id="<?= $user_data['id']; ?>" amount="<?= $receive; ?>">
                      <?= Ty::get('receive') ?><?= Ty::get('credit'); ?>
                    </button>
                  </div>
                </div>
                <div class="sub-text event_add_class text-center text-pink-2 my-15px" data-toggle="collapse" data-target="#table_hbd_<?= $list['id'] ?>" type="button" aria-expanded="false" aria-controls="table<?= $list['id'] ?>">รายละเอียด</div>
                <div class="table-responsive collapse event_collapse" id="table_hbd_<?= $list['id'] ?>">
                  <table class="table table-custom">
                    <thead>
                      <tr>
                        <th scope="col" colspan="2"><?= Ty::get('terms_conds') ?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?= Ty::get('minimun_turnover', [], ['case' => 'ucfirst']) ?></td>
                        <td class="text-pink text-end" nowarp>
                          <div class="d-flex align-items-center justify-content-end">
                            <?= number_format($hbd_promo['turn_over_for_receive'], 2) ?>
                            <div class="box-text-amount pl-5px">
                              <?= Ty::get('baht', [], ['case' => 'ucfirst']) ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><?= Ty::get('total_turn_monthly', [], ['case' => 'ucfirst']) ?></td>
                        <td class="text-pink text-end" nowarp>
                          <div class="d-flex align-items-center justify-content-end">
                            <?= number_format($sum_bet, 2) ?>
                            <div class="box-text-amount pl-5px">
                              <?= Ty::get('baht', [], ['case' => 'ucfirst']) ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-pink-2 font-17px"> <?= Ty::get('game_allow', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="d-flex align-items-center">
                              <?php
                              if (empty($hbd_promo['game_type_list'])) {
                                $json_decode_game_type = [];
                              } else {
                                $json_decode_game_type = json_decode($hbd_promo['game_type_list'], true);
                                foreach ($json_decode_game_type as $key => $value) {
                                  echo $value;
                                  if ($key == array_key_last($json_decode_game_type)) {
                                    echo '';
                                  } else {
                                    echo ', ';
                                  }
                                }
                              }
                              ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-pink-2 font-17px"> <?= Ty::get('firm_allow', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="">
                              <?php
                              if (empty($hbd_promo['game_product_list'])) {
                                $json_decode_firm_type = [];
                              } else {
                                $json_decode_firm_type = json_decode($hbd_promo['game_product_list'], true);
                                foreach ($json_decode_firm_type as $key => $value) {
                                  $keys = $key + 1;
                                  echo '<span class="mb-0">' . $value . '</span>';
                              ?>
                              <?php
                                  if ($key == array_key_last($json_decode_firm_type)) {
                                    echo '';
                                  } else {
                                    echo ', ';
                                  }
                                  if ($keys % 8 == 0) {
                                    echo '<br>';
                                  }
                                }
                              }
                              ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-pink-2 font-17px"> <?= Ty::get('note', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="mt--20px" style="white-space: pre-line; color: #fff">
                              <?= $hbd_promo['description']; ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>
      <?php
      }
      ?>
      <?php
      if ($special_promo['is_active'] == 1) {
      ?>
        <div class="col-lg-10  mb-20px m-auto">
          <form method="post">
            <div class="title-promotion"><?= 'Special day promotion' ?></div>
            <div class="card-promotion">
              <div class="card-promotion-img">
                <div class="img-1by1 holder">
                  <img src="<?= $special_promo['img_path'] ?>" alt="promotion">
                </div>
                <div class="card-promotion-point">
                  <?= Ty::get('yougotbonus') ?> <span class="text-brown font-Bold"><?= number_format($receive_special, 2)  ?> <?= Ty::get('baht'); ?></span>
                </div>
                <div class="ribbon-new">
                  New
                </div>
              </div>
              <div class="card-promotion-content">
                <?php
                $btn_allow = (in_array(date('d'), [21, 22, 23, 24, 25]) && !$special_promo['is_receive']) ? '' : 'disabled';
                ?>
                <div class="card-promotion-title-group">
                  <div class="hr-effect">
                    <img src="assets/images/wink-line.png" alt="">
                  </div>
                  <span class="font-18px text-white"><?= Ty::get('yougotbonus') ?></span>
                  <div class="card-promotion-content-title mb-15px">
                    <span class="text-bg"><?= number_format($receive_special, 2)  ?></span>
                    <button class="btn btn-main w-150px event_special_promotion" <?= $btn_allow; ?> promotion_id="<?= $special_promo['id'] ?>" user_id="<?= $user_data['id']; ?>" amount="<?= $receive_special; ?>" promo_type="<?= 'special'; ?>">
                      <?= Ty::get('receive') ?><?= Ty::get('credit'); ?>
                    </button>
                  </div>
                </div>
                <div class="sub-text event_add_class text-center text-pink-2 my-15px" data-toggle="collapse" data-target="#table_special_<?= $list['id'] ?>" type="button" aria-expanded="false" aria-controls="table<?= $list['id'] ?>">รายละเอียด</div>
                <div class="table-responsive collapse event_collapse" id="table_special_<?= $list['id'] ?>">
                  <table class="table table-custom">
                    <thead>
                      <tr>
                        <th scope="col" colspan="2"><?= Ty::get('terms_conds') ?></th>
                      </tr>
                    </thead>
                    <tfoot>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-pink-2 font-17px"> <?= Ty::get('game_allow', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="d-flex align-items-center">
                              <?php
                              if (empty($special_promo['game_type_list'])) {
                                $json_decode_game_type = [];
                              } else {
                                $json_decode_game_type = json_decode($special_promo['game_type_list'], true);
                                foreach ($json_decode_game_type as $key => $value) {
                                  echo $value;
                                  if ($key == array_key_last($json_decode_game_type)) {
                                    echo '';
                                  } else {
                                    echo ', ';
                                  }
                                }
                              }
                              ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-pink-2 font-17px"> <?= Ty::get('firm_allow', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="">
                              <?php
                              if (empty($special_promo['game_product_list'])) {
                                $json_decode_firm_type = [];
                              } else {
                                $json_decode_firm_type = json_decode($special_promo['game_product_list'], true);
                                foreach ($json_decode_firm_type as $key => $value) {
                                  $keys = $key + 1;
                                  echo '<span class="mb-0">' . $value . '</span>';
                              ?>
                              <?php
                                  if ($key == array_key_last($json_decode_firm_type)) {
                                    echo '';
                                  } else {
                                    echo ', ';
                                  }
                                  if ($keys % 8 == 0) {
                                    echo '<br>';
                                  }
                                }
                              }
                              ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-pink-2 font-17px"> <?= Ty::get('note', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="mt--20px" style="white-space: pre-line;">
                              <?= $special_promo['description']; ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>
      <?php } ?>
      <?php
      if ($lucky_promo['is_active'] == 1) {
      ?>
        <div class="col-lg-10  mb-20px m-auto">
          <div class="title-promotion"><?= 'Lucky monthly promotion' ?></div>
          <form method="post">
            <div class="card-promotion">
              <div class="card-promotion-img">
                <div class="img-1by1 holder">
                  <img src="<?= $lucky_promo['img_path'] ?>" alt="promotion">
                </div>
                <div class="card-promotion-point">
                  <?= Ty::get('yougotbonus') ?> <span class="text-brown font-Bold"><?= number_format($receive_special, 2)  ?> <?= Ty::get('baht'); ?></span>
                </div>
                <div class="ribbon-new">
                  New
                </div>
              </div>
              <div class="card-promotion-content">
                <?php
                $btn_allow = (in_array(date('d'), [1, 2, 3, 4, 5]) && !$lucky_promo['is_receive']) ? '' : 'disabled';
                ?>
                <div class="card-promotion-title-group">
                  <div class="hr-effect">
                    <img src="assets/images/wink-line.png" alt="">
                  </div>
                  <span class="font-18px text-white"><?= Ty::get('yougotbonus') ?></span>
                  <div class="card-promotion-content-title mb-15px">
                    <span class="text-bg"><?= number_format($receive_special, 2)  ?></span>
                    <button class="btn btn-main w-150px event_special_promotion" <?= $btn_allow; ?> promotion_id="<?= $lucky_promo['id'] ?>" user_id="<?= $user_data['id']; ?>" amount="<?= $receive_special; ?>" promo_type="<?= 'lucky'; ?>">
                      <?= Ty::get('receive') ?><?= Ty::get('credit'); ?>
                    </button>
                  </div>
                </div>
                <div class="sub-text event_add_class text-center text-pink-2 my-15px" data-toggle="collapse" data-target="#table_lucky_<?= $list['id'] ?>" type="button" aria-expanded="false" aria-controls="table<?= $list['id'] ?>">รายละเอียด</div>
                <div class="table-responsive collapse event_collapse" id="table_lucky_<?= $list['id'] ?>">
                  <table class="table table-custom">
                    <thead>
                      <tr>
                        <th scope="col" colspan="2"><?= Ty::get('terms_conds') ?></th>
                      </tr>
                    </thead>
                    <tr>

                      <td><?= Ty::get('total_deposit_amount', [], ['case' => 'ucfirst']) ?></td>
                      <td class="text-pink text-end" nowarp>
                        <div class="d-flex align-items-center justify-content-end">
                          <?= number_format($deposit_require, 2) ?>
                          <div class="box-text-amount pl-5px">
                            <?= Ty::get('baht', [], ['case' => 'ucfirst'])
                            ?>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td><?= Ty::get('current_deposit', [], ['case' => 'ucfirst']) ?></td>
                      <td class="text-pink text-end" nowarp>
                        <div class="d-flex align-items-center justify-content-end">
                          <?= number_format($lucky_promo['current_deposit'], 2) ?>
                          <div class="box-text-amount pl-5px">
                            <?= Ty::get('baht', [], ['case' => 'ucfirst']) ?>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tfoot>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-pink-2 font-17px"> <?= Ty::get('game_allow', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="d-flex align-items-center">
                              <?php
                              if (empty($lucky_promo['game_type_list'])) {
                                $json_decode_game_type = [];
                              } else {
                                $json_decode_game_type = json_decode($lucky_promo['game_type_list'], true);
                                foreach ($json_decode_game_type as $key => $value) {
                                  echo $value;
                                  if ($key == array_key_last($json_decode_game_type)) {
                                    echo '';
                                  } else {
                                    echo ', ';
                                  }
                                }
                              }
                              ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-pink-2 font-17px"> <?= Ty::get('firm_allow', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="">
                              <?php
                              if (empty($lucky_promo['game_product_list'])) {
                                $json_decode_firm_type = [];
                              } else {
                                $json_decode_firm_type = json_decode($lucky_promo['game_product_list'], true);
                                foreach ($json_decode_firm_type as $key => $value) {
                                  $keys = $key + 1;
                                  echo '<span class="mb-0">' . $value . '</span>';
                              ?>
                              <?php
                                  if ($key == array_key_last($json_decode_firm_type)) {
                                    echo '';
                                  } else {
                                    echo ', ';
                                  }
                                  if ($keys % 8 == 0) {
                                    echo '<br>';
                                  }
                                }
                              }
                              ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-pink-2 font-17px"> <?= Ty::get('note', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="mt--20px" style="white-space: pre-line;">
                              <?= $lucky_promo['description']; ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </form>
        </div>
      <?php } ?>
      <?php if ($promo_rank_first_depo) { ?>
        <?php foreach ($promo_rank_first_depo as $key => $list) {
          if ($list['type'] == 'bronze_silver') {
            $name_rank = 'Bronze-Silver';
          } else if ($list['type'] == 'gold_diamond') {
            $name_rank = 'Gold-Diamond';
          } else if ($list['type'] == 'con') {
            $name_rank = "Conqueror's";
          } else if ($list['type'] == 'vip_vvip') {
            $name_rank = 'VIP-VVIP';
          }
        ?>
          <div class="col-lg-10  mb-20px m-auto">
            <div class="title-promotion"><?= 'โปรโมชั่นฝากแรกของวัน ' . $name_rank; ?></div>
            <div class="card-promotion">
              <div class="card-promotion-img">
                <div class="img-1by1 holder">
                  <img src="<?= $list['promotion_image'] ?>" alt="promotion">
                </div>
                <div class="card-promotion-point">
                  <?= Ty::get('yougotbonus') ?> <span class="text-brown font-Bold"><?= number_format($list['outstanding'], 2)  ?> <?= Ty::get('credit'); ?></span>
                </div>
                <div class="ribbon-new">
                  New
                </div>
              </div>
              <?php $btn_allow = $list['outstanding'] > 0 ? '' : 'disabled'; ?>
              <div class="card-promotion-content">
                <div class="card-promotion-content-title">
                  <span> <?= Ty::get('yourbonus') ?> <?= number_format($list['outstanding'], 2)  ?></span>
                  <button class="btn btn-main w-150px rounded event_confirm_deposit" promotion_id="<?= $list['id_for_receive'] ?>" <?= $btn_allow; ?> user_id="<?= $user_data['id']; ?>" unit_type="<?= $list['type']; ?>" amount="<?= $list['outstanding']; ?>"><?= Ty::get('receive') ?><?= Ty::get('credit'); ?></button>
                </div>
                <div class="sub-text event_add_class text-center text-pink-2 mt-15px" data-toggle="collapse" data-target="#table_pro_<?= $list['id'] ?>" type="button" aria-expanded="false" aria-controls="table<?= $list['id'] ?>">รายละเอียด</div>
                <div class="collapse event_collapse" id="table_pro_<?= $list['id'] ?>">
                  <div class="p-8px">
                    วิธีการขอรับโบนัส
                    <p class="mb-0">1. โปรโมชั่นนี้สำหรับสมาชิก <?= 'NMG ระดับ' . $name_rank; ?></p>
                    <p class="mb-0">2. สมาชิกที่มียอดขั้นต่ำ <?= number_format($list['min_deposit'])  ?> บาท</p>
                    <p class="mb-0">3. ในหน้าฝากเงิน เลือกโปรโมชั่นนี้จากแถบด้านล่าง</p>
                    <p class="mb-0">4. หลักจากฝากเงิน ต้องทำการกดรับโบนัสจะถูกโอนไปยังกระเป๋าหลัก</p>
                    <p class="mb-0">5. สมาชิกสามารถขอรับโปรโมชั่นรายวันได้ 1ครั้ง/วัน</p>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-custom-two">
                      <thead>
                        <tr>
                          <th scope="col"><?= 'แพลตฟอร์ม' ?></th>
                          <th scope="col" class="text-nowrap"><?= 'โบนัสสูงสุด' ?></th>
                          <th scope="col" class="text-nowrap"><?= 'เทิร์นโอเวอร์' ?></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="" width="50%">
                            <div class="">
                              <?php
                              if (empty($list['game_product_list'])) {
                                $json_decode_firm_type = [];
                              } else {
                                $json_decode_firm_type = json_decode($list['game_product_list'], true);
                                foreach ($json_decode_firm_type as $key => $value) {
                                  $keys = $key + 1;
                                  echo '<span class="mb-0">' . $value . '</span>';
                              ?>
                              <?php
                                  if ($key == array_key_last($json_decode_firm_type)) {
                                    echo '';
                                  } else {
                                    echo ', ';
                                  }
                                  if ($keys % 4 == 0) {
                                    echo '<br>';
                                  }
                                }
                              }
                              ?>
                            </div>
                          </td>
                          <td class="" width="25%"><?= number_format($list['max_credit']); ?></td>
                          <td class="" width="25%">
                            <?= number_format($list['turn_over_for_withdraw'] / 100); ?> เท่า
                          </td>
                        </tr>
                      </tbody>
                      <!-- <tfoot>
                      <tr style="width: 100%;">
                        <td colspan="3">
                          <div class="text-table">
                            <span class="text-gold font-17px"> <?= Ty::get('note', [], ['case' => 'ucfirst']) ?> :</span>
                            <br>
                            <div class="mt--20px" style="white-space: pre-line;">
                              <?= $list['description']; ?>
                            </div>
                          </div>
                        </td>
                      </tr>
                    </tfoot> -->
                    </table>
                  </div>
                  <div class="mt--30px" style="white-space: pre-line;">
                    <?= $list['description']; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php  } ?>
      <?php } ?>
      <?php
      if (!$promotion_list && !$user_data['birth_date']) {
      ?>
        <div class="col-lg-10  mb-20px m-auto">
          <p class="text-center my-20px font-23px"><?= Ty::get('nopro_avai') ?></p>
        </div>
      <?php
      }
      ?>
    </div>
  </div>



  <div class="backdrop-claim" style="display: none;">
    <div class="claim-container">
      <p class="text-gold font-22px"><?= Ty::get('receive') ?><span class="scope_type"></span><?= Ty::get('received') ?>!</p>
      <div class="lottie-box">
        <lottie-player src="assets/images/lottie/success.json" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
      <div class="detail">
        <p class="font-18px">
          <?= Ty::get('bonus_transfer') ?> <span class="scope_amount_receive"></span><br>
          <?= Ty::get('to_credit') ?>
        </p>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  ?>
  <script>
    $(document).on('click', '.event_confirm', function() {
      var user_id = $(this).attr('user_id');
      var promotion_id = $(this).attr('promotion_id');
      var promotion_name = $(this).attr('promotion_name');
      var type = $(this).attr('unit_type');
      var amount = $(this).attr('amount');
      if (type == 'credit') {
        var type_msg = '<?= Ty::get('credit') ?>';
        var currency = '<?= Ty::get('baht') ?>';
      } else {
        var type_msg = '<?= Ty::get('point') ?>';
        var currency = '<?= Ty::get('point') ?>';
      }

      var params = {
        user_id: user_id,
        promotion_id: promotion_id,
        promotion_name: promotion_name
      };

      $.post('ajax/ajax_promotion_redemption.php', params)
        .done(function(data) {
          var result = JSON.parse(data);
          if (result.response_status) {
            $('.backdrop-claim').find('.scope_type').text(type_msg)
            $('.backdrop-claim').find('.scope_amount_receive').text(Aww.formatMoney(amount) + ' ' + currency);

            setTimeout(() => {
              $('.backdrop-claim').fadeIn('fast', function() {
                setTimeout(() => {
                  location.reload();
                }, 2000);
              });
            }, 1000);
          } else {
            Aww.notification('error', result.response_message)
          }
        })
    })

    $(document).on('click', '.event_birthday_promotion', function() {
      var user_id = $(this).attr('user_id');
      var promotion_id = $(this).attr('promotion_id');
      var amount = $(this).attr('amount');

      var type_msg = '<?= Ty::get('credit', [], ['case' => 'ucfirst']) ?>';
      var currency = '<?= Ty::get('baht', [], ['case' => 'ucfirst']) ?>';

      var params = {
        user_id: user_id,
        promotion_id: promotion_id,
      };

      $.post('ajax/ajax_promotion_hbd_redemption.php', params)
        .done(function(data) {
          var result = JSON.parse(data);
          // console.log(result);
          if (result.response_status) {
            $('.backdrop-claim').find('.scope_type').text(type_msg)
            $('.backdrop-claim').find('.scope_amount_receive').text(Aww.formatMoney(amount) + ' ' + currency);

            setTimeout(() => {
              $('.backdrop-claim').fadeIn('fast', function() {
                setTimeout(() => {
                  location.reload();
                }, 2000);
              });
            }, 1000);
          } else {
            Aww.notification('error', result.response_message)
          }
        })
    })

    $(document).on('click', '.event_special_promotion', function() {
      var user_id = $(this).attr('user_id');
      var promotion_id = $(this).attr('promotion_id');
      var amount = $(this).attr('amount');
      var type = $(this).attr('promo_type');
      var type_msg = '<?= Ty::get('credit', [], ['case' => 'ucfirst']) ?>';
      var currency = '<?= Ty::get('baht', [], ['case' => 'ucfirst']) ?>';

      var params = {
        user_id: user_id,
        promotion_id: promotion_id,
        type: type
      };

      $.post('ajax/ajax_promotion_special_redemption.php', params)
        .done(function(data) {
          var result = JSON.parse(data);
          // console.log(result);
          if (result.response_status) {
            $('.backdrop-claim').find('.scope_type').text(type_msg)
            $('.backdrop-claim').find('.scope_amount_receive').text(Aww.formatMoney(amount) + ' ' + currency);

            setTimeout(() => {
              $('.backdrop-claim').fadeIn('fast', function() {
                setTimeout(() => {
                  location.reload();
                }, 2000);
              });
            }, 1000);
          } else {
            Aww.notification('error', result.response_message)
          }
        })
    });

    $(document).on('click', '.event_confirm_deposit', function() {
      var user_id = $(this).attr('user_id');
      var promotion_id = $(this).attr('promotion_id');
      var type = $(this).attr('unit_type');
      var amount = $(this).attr('amount');
      var type_msg = '<?= Ty::get('credit', [], ['case' => 'ucfirst']) ?>';
      var currency = '<?= Ty::get('baht', [], ['case' => 'ucfirst']) ?>';

      var params = {
        user_id: user_id,
        promotion_id: promotion_id,
      };

      $.post('ajax/ajax_promotion_deposit.php', params)
        .done(function(data) {
          var result = JSON.parse(data);
          if (result.response_status) {
            $('.backdrop-claim').find('.scope_type').text(type_msg)
            $('.backdrop-claim').find('.scope_amount_receive').text(Aww.formatMoney(amount) + ' ' + currency);

            setTimeout(() => {
              $('.backdrop-claim').fadeIn('fast', function() {
                setTimeout(() => {
                  location.reload();
                }, 2000);
              });
            }, 1000);
          } else {
            Aww.notification('error', result.response_message)
          }
        })
    });

    checkScreenSize();

    $(window).resize(function() {
      checkScreenSize();
    });

    function checkScreenSize() {
      var screenWidthThreshold = 768;

      // Check the screen width
      if ($(window).width() < screenWidthThreshold) {
        // On small screens, enable collapse
        $('.event_add_class').show();
        $('.event_collapse').addClass('hide');
      } else {
        // On larger screens, disable collapse
        $('.event_add_class').hide();
        $('.event_collapse').addClass('show');
      }
    };
  </script>
</body>

</html>