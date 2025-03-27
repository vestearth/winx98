<?php
require_once '.framework/import.php';


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
  ?>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
  <?php
  if ($is_login) {
    $user_data = User::getCurrent();
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้าฝากเงิน',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $bank_data = nga_management_bot::getBankForTransfer($code, $user_data['id']);
    $get_auto_wd = nga_management::getAutoDepositWithdraw($code);
    $system_line =  nga_management::getGeneralWebsite($code);

    $check_bank_allow = nga_user::getBankNameByBankNo($code, $user_data['bank_abb'], $user_data['bank_number']);
    $user_group = nga_management::getUserGroupByID($code, $user_data['user_group_id']);
    $is_kbank = isset($user_group['deposit_bank_abb']) ? $user_group['deposit_bank_abb'] : false;

    $where = [
      'user_id' => $user_data['id'],
      'is_read' => "'0'"
    ];
    $options = [
      'sort'        => ['insert_date_time' => 'DESC']
    ];
    $notification = User_Notification::selectNotification($code, $where);
    $promotion_list = nga_management::selectUserPromotion($code, $user_data['id'], $options);
    $promo_rank_first_depo = nga_management::selectPromotionDepositForUser($code, $user_data['id']);

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
            <li class="breadcrumb-item active" aria-current="page"><?= Ty::get('deposit') ?></li>
          </ol>
        </nav>
      </div>
      <div class="col-md-6">
        <div class="card-content mb-10px mt-35px">
          <div class="card-content-header">
            <?= Ty::get('banktransfer') ?>
          </div>
          <div class="card-content-body text-center">
            <p class="text-pink-2 mb-20px font-SemiBold font-16px"><?= Ty::get('plsuseregistered') ?></p>
            <div class="t1 font-16px">*<?= Ty::get('aftertransaction') ?> </div>
            <a href="<?= $system_line['line_link'] ?>" class="text-pink mb-20px font-16px"><?= $system_line['line_id'] ?></a>
            <div class="card-bank">
              <div class="icon-bank">
                <img src="<?= $bank_data['image'] ?>" alt="" class="rounded">
              </div>
              <p class="text-white mb-5px"><?= $bank_data['name_th'] ?></p>
              <h2 class="font-24px mb-10px font-Bold number_copy"><?= textFormat($bank_data['bank_account_no'], '___-_-_____-_', '-'); ?></h2>
              <p class="text-white mb-5px"><?= Ty::get('accountname') ?>: <?= $bank_data['bank_account_name']; ?></p>
              <button class="btn btn-copy-code border event_btn_copy">
                <img src="assets/icon/copy.svg" alt="copy">
                <?= Ty::get('copyaccuntnmb') ?>
              </button>
            </div>
          </div>
        </div>

        <div class="card-earning-2 mt-15px text-center">
          <h3>“โปรโมชั่นฝากเงินทั้งหมด”</h3>
          <p class="mb-0">*รายการโปรโมชันที่สามารถรับได้ เมื่อทำการฝากเงินตามเงื่อนไข</p>
        </div>
        <div>
          <div class="mb-10px font-16px text-gold" data-toggle="collapse" data-target="#all_promotion " type="button" aria-expanded="false" aria-controls="all_promotion">เปิด/ปิดแสดงรายการโปรโมชัน</div>
        </div>
        <div class="collapse show" id="all_promotion">
          <?php if ($promotion_list) { ?>
            <?php foreach ($promotion_list as $key => $list) {
              if ($list['calculate_type'] == 'deposit' && $list['is_last_receive']) {
            ?>
                <div class="row pb-15px g-0">
                  <div class="col-xl-3 col-4">
                    <div class="card-promotion-img">
                      <div class="img-1by1 holder">
                        <img src="<?= $list['promotion_image'] ?>" alt="promotion">
                      </div>
                      <?php if (in_array($list['id'], $ref_id)) {  ?>
                        <div class="ribbon-new">
                          New
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-xl-9 col-8">
                    <div class="card-promotion-deposit">
                      <?php $btn_allow = $list['amount_wait_confirm'] > 0 ? '' : 'disabled'; ?>
                      <div class="card-promotion-content">
                        <div class="card-promotion-title-group">
                          <div class="">
                            <div class="title-promotion"><?= $list['name'] ?></div>
                          </div>
                          <div class="card-promotion-content-title">
                            <span>
                              <?= Ty::get('โบนัสที่จะได้รับ') ?>
                              <span class="text-gold font-22px"><?= number_format($list['amount_wait_confirm'], 2); ?></span>
                            </span>
                          </div>
                          <div class="mt-15px d-flex justify-content-between align-items-center">
                            <button class="btn btn-main short w-150px rounded event_confirm" promotion_name="<?= $list['name'] ?>" promotion_id="<?= $list['id'] ?>" <?= $btn_allow; ?> user_id="<?= $user_data['id']; ?>" unit_type="<?= $list['type']; ?>" amount="<?= $list['amount_wait_confirm']; ?>"><?= Ty::get('receive') ?><?= $list['type'] == 'credit' ? Ty::get('credit') : Ty::get('point') ?></button>
                            <div class="sub-text event_add_class" data-toggle="collapse" data-target="#table<?= $list['id'] ?>" type="button" aria-expanded="false" aria-controls="table<?= $list['id'] ?>">ดูเพิ่มเติม</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mt-10px collapse" id="table<?= $list['id'] ?>">
                      <div class="table-responsive">
                        <table class="table table-custom">
                          <thead>
                            <tr>
                              <th scope="col" colspan="2"><?= Ty::get('terms_conds') ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'deposit') { ?>
                              <tr>
                                <td><?= Ty::get('deposit_bal') ?></td>
                                <td class="text-gold text-end"><?= $list['sum_deposit']; ?> <?= Ty::get('baht') ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('notmore') ?></td>
                                <td class="text-gold text-end"><?= $list['time_per_day']; ?> <?= Ty::get('times_person') ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('time_per') ?></td>
                                <td class="text-gold text-end">
                                  <?= ($list['is_per_user_unlimit']) ?  'ไม่จำกัดจำนวน' : $list['time_per_user']; ?> <?= Ty::get('times_pro') ?>
                                </td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'new_user') { ?>
                              <tr>
                                <td><?= Ty::get('begin_datetime') ?></td>
                                <td class="text-gold text-end"> <?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('end_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('amount_limit') ?></td>
                                <td class="text-gold text-end">
                                  <?= ($list['is_max_user_unlimit']) ? 'ไม่จำกัดจำนวน' : $list['max_user']; ?> คน
                                </td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'invite_friend') { ?>
                              <tr>
                                <td><?= Ty::get('begin_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('end_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('complete_invite') ?></td>
                                <td class="text-gold text-end"><?= $list['sum_invite_friend']; ?> คน</td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'manual') { ?>
                              <tr>
                                <td><?= Ty::get('begin_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('end_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('contact') ?></td>
                                <td class="text-gold text-end"><?= $list['contact']; ?></td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'excess_lost') { ?>
                              <tr>
                                <td><?= Ty::get('loss_than', [], ['case' => 'ucfirst']) ?></td>
                                <td class="text-gold text-end">
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['sum_excess_lost']; ?>
                                    <div class="box-text-amount">
                                      <?= $list['type'] == 'credit' ? Ty::get('baht', [], ['case' => 'ucfirst']) : Ty::get('point', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('receive', [], ['case' => 'ucfirst']) ?><?= $list['type'] == 'credit' ? Ty::get('credit') : Ty::get('point', [], ['case' => 'ucfirst', [], ['case' => 'ucfirst']]) ?><?= Ty::get('return') ?></td>
                                <td class="text-gold text-end">
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['credit_point_back_percent']; ?>%
                                    <div class="box-text-amount">
                                      <?= Ty::get('loss_money', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('receive') ?><?= $list['type'] == 'credit' ? Ty::get('credit') : Ty::get('point') ?><?= Ty::get('re_not_more') ?></td>
                                <td class="text-gold text-end" nowarp>
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['max_credit_point_back'] ?>
                                    <div class="box-text-amount">
                                      <?= $list['type'] == 'credit' ? Ty::get('baht') : Ty::get('point') ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'play_game') { ?>
                              <tr>
                                <td><?= Ty::get('complete_games', [], ['case' => 'ucfirst']) ?></td>
                                <td class="text-gold text-end" nowarp>
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['sum_play_game'] ?>
                                    <div class="box-text-amount">
                                      <?= Ty::get('times', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('notmore', [], ['case' => 'ucfirst']) ?></td>
                                <td class="text-gold text-end" nowarp>
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['time_per_day'] ?>
                                    <div class="box-text-amount">
                                      <?= Ty::get('times_person', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('time_player', [], ['case' => 'ucfirst']) ?></td>
                                <td class="text-gold text-end" nowarp>
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['time_per_user'] ?>
                                    <div class="box-text-amount">
                                      <?= Ty::get('times_pro', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                          <tfoot>
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
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                  <?php if ($list['is_last_receive'] && $list['is_received']) { ?>
                    <div class="col-12 px-0">
                      <div class="bg-accept-promo text-center">
                        กำลังใช้งานโปรโมชั่นนี้ ไม่สามารถใช้โปรอื่นได้
                      </div>
                    </div>
                  <?php } ?>
                </div>
            <?php
                break;
              }
            } ?>
            <?php foreach ($promotion_list as $key => $list) {
              if ($list['calculate_type'] == 'deposit' && !$list['is_last_receive']) {
            ?>
                <div class=" row pb-15px">
                  <div class="col-xl-3 col-4 px-0">
                    <div class="card-promotion-img">
                      <div class="img-1by1 holder">
                        <img src="<?= $list['promotion_image'] ?>" alt="promotion">
                      </div>
                      <?php if (in_array($list['id'], $ref_id)) {  ?>
                        <div class="ribbon-new">
                          New
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-xl-9 col-8 px-0">
                    <div class="card-promotion-deposit">
                      <?php $btn_allow = $list['amount_wait_confirm'] > 0 ? '' : 'disabled'; ?>
                      <div class="card-promotion-content">
                        <div class="card-promotion-title-group">
                          <div class="">
                            <div class="title-promotion"><?= $list['name'] ?></div>
                          </div>
                          <div class="card-promotion-content-title">
                            <span>
                              <?= Ty::get('โบนัสที่จะได้รับ') ?>
                              <span class="text-gold font-22px"><?= number_format($list['amount_wait_confirm'], 2); ?></span>
                            </span>
                          </div>
                          <div class="mt-15px d-flex justify-content-between align-items-center">
                            <button class="btn btn-main short w-150px rounded event_confirm" promotion_id="<?= $list['id'] ?>" <?= $btn_allow; ?> user_id="<?= $user_data['id']; ?>" unit_type="<?= $list['type']; ?>" amount="<?= $list['amount_wait_confirm']; ?>"><?= Ty::get('receive') ?><?= $list['type'] == 'credit' ? Ty::get('credit') : Ty::get('point') ?></button>
                            <div class="sub-text event_add_class" data-toggle="collapse" data-target="#table<?= $list['id'] ?>" type="button" aria-expanded="false" aria-controls="table<?= $list['id'] ?>">ดูเพิ่มเติม</div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="mt-10px collapse" id="table<?= $list['id'] ?>">
                      <div class="table-responsive">
                        <table class="table table-custom">
                          <thead>
                            <tr>
                              <th scope="col" colspan="2"><?= Ty::get('terms_conds') ?></th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'deposit') { ?>
                              <tr>
                                <td><?= Ty::get('deposit_bal') ?></td>
                                <td class="text-gold text-end"><?= $list['sum_deposit']; ?> <?= Ty::get('baht') ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('notmore') ?></td>
                                <td class="text-gold text-end"><?= $list['time_per_day']; ?> <?= Ty::get('times_person') ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('time_per') ?></td>
                                <td class="text-gold text-end">
                                  <?= ($list['is_per_user_unlimit']) ?  'ไม่จำกัดจำนวน' : $list['time_per_user']; ?> <?= Ty::get('times_pro') ?>
                                </td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'new_user') { ?>
                              <tr>
                                <td><?= Ty::get('begin_datetime') ?></td>
                                <td class="text-gold text-end"> <?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('end_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('amount_limit') ?></td>
                                <td class="text-gold text-end">
                                  <?= ($list['is_max_user_unlimit']) ? 'ไม่จำกัดจำนวน' : $list['max_user']; ?> คน
                                </td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'invite_friend') { ?>
                              <tr>
                                <td><?= Ty::get('begin_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('end_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('complete_invite') ?></td>
                                <td class="text-gold text-end"><?= $list['sum_invite_friend']; ?> คน</td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'manual') { ?>
                              <tr>
                                <td><?= Ty::get('begin_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('end_datetime') ?></td>
                                <td class="text-gold text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('contact') ?></td>
                                <td class="text-gold text-end"><?= $list['contact']; ?></td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'excess_lost') { ?>
                              <tr>
                                <td><?= Ty::get('loss_than', [], ['case' => 'ucfirst']) ?></td>
                                <td class="text-gold text-end">
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['sum_excess_lost']; ?>
                                    <div class="box-text-amount">
                                      <?= $list['type'] == 'credit' ? Ty::get('baht', [], ['case' => 'ucfirst']) : Ty::get('point', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('receive', [], ['case' => 'ucfirst']) ?><?= $list['type'] == 'credit' ? Ty::get('credit') : Ty::get('point', [], ['case' => 'ucfirst', [], ['case' => 'ucfirst']]) ?><?= Ty::get('return') ?></td>
                                <td class="text-gold text-end">
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['credit_point_back_percent']; ?>%
                                    <div class="box-text-amount">
                                      <?= Ty::get('loss_money', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('receive') ?><?= $list['type'] == 'credit' ? Ty::get('credit') : Ty::get('point') ?><?= Ty::get('re_not_more') ?></td>
                                <td class="text-gold text-end" nowarp>
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['max_credit_point_back'] ?>
                                    <div class="box-text-amount">
                                      <?= $list['type'] == 'credit' ? Ty::get('baht') : Ty::get('point') ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'play_game') { ?>
                              <tr>
                                <td><?= Ty::get('complete_games', [], ['case' => 'ucfirst']) ?></td>
                                <td class="text-gold text-end" nowarp>
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['sum_play_game'] ?>
                                    <div class="box-text-amount">
                                      <?= Ty::get('times', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('notmore', [], ['case' => 'ucfirst']) ?></td>
                                <td class="text-gold text-end" nowarp>
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['time_per_day'] ?>
                                    <div class="box-text-amount">
                                      <?= Ty::get('times_person', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td><?= Ty::get('time_player', [], ['case' => 'ucfirst']) ?></td>
                                <td class="text-gold text-end" nowarp>
                                  <div class="d-flex align-items-center justify-content-end">
                                    <?= $list['time_per_user'] ?>
                                    <div class="box-text-amount">
                                      <?= Ty::get('times_pro', [], ['case' => 'ucfirst']) ?>
                                    </div>
                                  </div>
                                </td>
                              </tr>
                            <?php } ?>
                          </tbody>
                          <tfoot>
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
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            <?php  }
            } ?>

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
                <div class="row pb-15px">
                  <div class="col-xl-3 col-4 px-0">
                    <div class="card-promotion-img">
                      <div class="img-1by1 holder">
                        <img src="<?= $list['promotion_image'] ?>" alt="promotion">
                      </div>
                      <?php if (in_array($list['id'], $ref_id)) {  ?>
                        <div class="ribbon-new">
                          New
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="col-xl-9 col-8 px-0">
                    <div class="card-promotion-deposit">
                      <?php $btn_allow = $list['outstanding'] > 0 ? '' : 'disabled'; ?>
                      <div class="card-promotion-content">
                        <div class="card-promotion-title-group">
                          <div class="hide-mobile">
                            <div class="title-promotion"><?= 'โปรโมชั่นฝากแรกของวัน ' . $name_rank; ?></div>
                          </div>
                          <div class="card-promotion-content-title">
                            <span> <?= Ty::get('yourbonus') ?> <span class="text-gold"><?= number_format($list['outstanding'], 2)  ?></span></span>
                          </div>
                        </div>

                        <div class="mt-15px d-flex justify-content-between align-items-center">
                          <button class="btn btn-main short w-150px rounded event_confirm_deposit" promotion_id="<?= $list['id_for_receive'] ?>" <?= $btn_allow; ?> user_id="<?= $user_data['id']; ?>" unit_type="<?= $list['type']; ?>" amount="<?= $list['outstanding']; ?>"><?= Ty::get('receive') ?><?= Ty::get('credit'); ?></button>
                          <div class="sub-text sub-text event_add_class text-right" data-toggle="collapse" data-target="#table_pro_<?= $list['id'] ?>" type="button" aria-expanded="false" aria-controls="table<?= $list['id'] ?>">ดูเพิ่มเติม</div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="collapse event_collapse mt-10px" id="table_pro_<?= $list['id'] ?>">
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
                                      if ($keys % 5 == 0) {
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
                        </table>
                      </div>
                      <div class="mt--20px" style="white-space: pre-line;">
                        <?= $list['description']; ?>
                      </div>
                    </div>
                  </div>

                </div>

              <?php  } ?>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
      <div class="col-md-6">
        <div class="title-table">
          <?= Ty::get('deposithistory') ?>
        </div>
        <div id="deposit_list" class="container-pagination table-custom" <?= Homepagify::createHomepagify('deposit_list', '', '', 'รายการถอน', ''); ?>>
          <div class="table-responsive">
            <table class="table table-sort table-theme">
              <thead>
                <tr>
                  <th nowrap class="text-white" data-sort=""><?= Ty::get('dateandtime') ?></th>
                  <th nowrap class="text-white thin-cell text-end" data-sort=""><?= Ty::get('amount') ?></th>
                  <th nowrap class="text-white text-end no-sort" data-sort=""><?= Ty::get('status') ?></th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php Tiwdal::startModal('modal_detail', 'modal-sm modal-no-more modal-dialog-centered'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <div class="title">
      <?= Ty::get('trans_time', [], ["case" => "ucfirst"]) ?>
    </div>
    <p class="detail">
      <span name="{date_trans}"></span>
    </p>
    <div class="title">
      <?= Ty::get('transfer_acc', [], ["case" => "ucfirst"]) ?>
    </div>
    <p class="detail">
      <span name="{transfer_data}"></span>
    </p>
    <div class="title">
      <?= Ty::get('dep_balance') ?>
    </div>
    <p class="detail">
      <span name="{credit_amount}"></span>
      <?= Ty::get('baht') ?>
    </p>
    <div class="title">
      <?= Ty::get('status') ?>
    </div>
    <p class="detail text-success">
      <span name="{status_complete}"></span>
    </p>
    <p class="detail text-warning">
      <span name="{status_waiting}"></span>
    </p>
    <div class="title">
      <?= Ty::get('reason') ?>
    </div>
    <p class="detail">
      <span name="{remark}"></span>
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn-main rounded ">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <div class="menu-fix-right">
    <a href="<?= $system_line['line_link'] ?>" target="_blank">
      <div class="menu-line">
        <div class="box-close event_close_fix_menu">
          <?= file_get_contents('assets/icon/close.svg') ?>
        </div>
      </div>
    </a>
  </div>

  <?php Tiwdal::startModal('modal_kbank_condition', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <p class="detail font-16px text-center" style="white-space: pre-line">
      ขณะนี้ไม่สามารถดึงรายการฝากได้ เนื่องจากเว็บธนาคารใช้งานไม่ได้ ขออภัยในความไม่สะดวก
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('modal_maintenance', 'modal-sm modal-no-more mx-auto modal-dialog-centered mt-0'); ?>
  <button type="button" class="btn-top-close" data-bs-dismiss="modal" aria-label="Close">
    <?= file_get_contents('assets/icon/cross.svg') ?>
  </button>
  <div class="modal-body">
    <h5 class="text-center">ขออภัยในความไม่สะดวก</h5>
    <p class="detail font-16px text-center" style="white-space: pre-line">
      ธนาคารไทยพานิชณ์ (SCB) จะทำการปิดปรับปรุงการใช้บริการเพื่อพัฒนาระบบระหว่าง
      วันศุกร์ที่ 9 มิถุนายน 2556 เวลา 20:00 น.
      ถึงเวลา
      วันเสาร์ 10 มิถุนายน 2556 เวลา 03:00 น.
    </p>
    <p class="text-danger text-center" style="white-space: pre-line">
      ลูกค้าจะไม่สามารถทำรายการฝาก - ถอนเงิน
      ผ่าน SCB ได้ตามช่วงเวลาที่ระบุ ทั้งนี้
      <u>ลูกค้าสามารถติดต่อแอดมิน</u>
      เพื่อทำรายการได้ตามปกติ
    </p>
  </div>
  <div class="modal-footer">
    <button data-bs-dismiss="modal" aria-label="Close" class="btn btn-main">
      <?= Ty::get('okay') ?>
    </button>
  </div>
  <?php Tiwdal::endModal() ?>

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

  <script>
    $(document).ready(function() {
      var currentTime = new Date(); // Get the current time

      var currentHour = currentTime.getHours(); // Get the current hour
      // Check if the current time is within the specified range
      if ((currentHour >= 16 && currentHour <= 23) || (currentHour >= 0 && currentHour <= 6)) {
        // Disable the button
        // $('#modal_maintenance').modal('show');
      }

      var bank_run = '<?= $check_bank_allow['account_name']; ?>';
      var is_kbank = '<?= $is_kbank; ?>';
      if (!bank_run && is_kbank == 'KBANK') {
        $('#modal_kbank_condition').modal('show');
      }

      $(document).on('click', '.event_close_fix_menu', function(e) {
        e.preventDefault();
        $(this).parents('a').fadeOut(300, function() {
          $(this).remove();
        });
      });

      $(document).on("click", ".event_btn_copy", function(e) {
        copyToClipboard($(".number_copy"));
        Aww.notification("success", "Copied");
      });

      $(document).on('click', '.event_confirm', function() {
        var user_id = $(this).attr('user_id');
        var promotion_id = $(this).attr('promotion_id');
        var promotion_name = $(this).attr('promotion_name');
        var type = $(this).attr('unit_type');
        var amount = $(this).attr('amount');
        if (type == 'credit') {
          var type_msg = '<?= Ty::get('credit', [], ['case' => 'ucfirst']) ?>';
          var currency = '<?= Ty::get('baht', [], ['case' => 'ucfirst']) ?>';
        } else {
          var type_msg = '<?= Ty::get('point', [], ['case' => 'ucfirst']) ?>';
          var currency = '<?= Ty::get('point', [], ['case' => 'ucfirst']) ?>';
        }

        var params = {
          user_id: user_id,
          promotion_id: promotion_id,
          promotion_name: promotion_name,
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
    });
  </script>
</body>

</html>