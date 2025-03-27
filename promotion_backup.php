<?php
require_once '.framework/import.php';
$page = 'promotion';
if ($is_login) {
  $user_data = User::getCurrent();
} else {
  Aww::redirect('login.php');
}
$promotion_list = nga_management::selectUserPromotion($code, $user_data['id']);
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
  <?php include 'layout/menu.php'; ?>
  <div class="container position-relative">
    <div class="font-18px font-Medium text-center">โปรโมชั่น</div>
    <div class="row">
      <?php foreach ($promotion_list as $key => $list) { ?>
        <div class="col-lg-10  mb-20px m-auto">
          <div class="title-promotion"><?= $list['name'] ?></div>
          <div class="card-promotion">
            <div class="card-promotion-img">
              <img src="<?= $list['promotion_image'] ?>" alt="promotion">
              <div class="card-promotion-point">
                ท่านได้รับโบนัส <span class="text-pink"><?= number_format($list['amount_wait_confirm'], 2)  ?> <?= $list['type'] == 'credit' ? 'บาท' : 'แต้ม' ?></span>
              </div>
            </div>
            <?php $btn_allow = $list['amount_wait_confirm'] > 0 ? '' : 'disabled'; ?>
            <div class="card-promotion-content">
              <div class="card-promotion-content-title">
                <span> โบนัสสะสม <span class="text-pink"><?= number_format($list['amount_wait_confirm'], 2)  ?></span></span>
                <button class="btn btn-main w-150px rounded event_confirm" promotion_id="<?= $list['id'] ?>" <?= $btn_allow; ?> user_id="<?= $user_data['id']; ?>" unit_type="<?= $list['type']; ?>" amount="<?= $list['amount_wait_confirm']; ?>">รับ<?= $list['type'] == 'credit' ? 'เครดิต' : 'แต้ม' ?></button>
              </div>
              <div class="table-responsive">
                <table class="table table-custom">
                  <thead>
                    <tr>
                      <th scope="col" colspan="2">ข้อกำหนดและเงื่อนไข</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'deposit') { ?>
                      <tr>
                        <td>มียอดฝาก</td>
                        <td class="text-aqua text-end"><?= $list['sum_deposit']; ?> บาท</td>
                      </tr>
                      <tr>
                        <td>จำนวนครั้งต่อวันไม่เกิน</td>
                        <td class="text-aqua text-end"><?= $list['time_per_day']; ?> ครั้ง / คน</td>
                      </tr>
                      <tr>
                        <td>จำนวนครั้งต่อคน</td>
                        <td class="text-aqua text-end">
                          <?= ($list['is_per_user_unlimit']) ?  'ไม่จำกัดจำนวน' : $list['time_per_user']; ?> ครั้ง / ช่วงโปรโมชั่น
                        </td>
                      </tr>
                    <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'new_user') { ?>
                      <tr>
                        <td>วัน/เวลาที่เริ่ม</td>
                        <td class="text-aqua text-end"> <?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                      </tr>
                      <tr>
                        <td>วัน/เวลาที่สิ้นสุด</td>
                        <td class="text-aqua text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                      </tr>
                      <tr>
                        <td>จำกัดจำนวน</td>
                        <td class="text-aqua text-end">
                          <?= ($list['is_max_user_unlimit']) ? 'ไม่จำกัดจำนวน' : $list['max_user']; ?> คน
                        </td>
                      </tr>
                    <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'invite_friend') { ?>
                      <tr>
                        <td>วัน/เวลาที่เริ่ม</td>
                        <td class="text-aqua text-end"><?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                      </tr>
                      <tr>
                        <td>วัน/เวลาที่สิ้นสุด</td>
                        <td class="text-aqua text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                      </tr>
                      <tr>
                        <td>ชวนเพื่อนครบ</td>
                        <td class="text-aqua text-end"><?= $list['sum_invite_friend']; ?> คน</td>
                      </tr>
                    <?php } else if ($list['receive_type'] == 'manual') { ?>
                      <tr>
                        <td>วัน/เวลาที่เริ่ม</td>
                        <td class="text-aqua text-end"><?= Aww::formatDate($list['start_date_time'], 'd/m/Y, H:i'); ?></td>
                      </tr>
                      <tr>
                        <td>วัน/เวลาที่สิ้นสุด</td>
                        <td class="text-aqua text-end"><?= Aww::formatDate($list['end_date_time'], 'd/m/Y, H:i'); ?></td>
                      </tr>
                      <tr>
                        <td>ช่องทางการติดต่อ</td>
                        <td class="text-aqua text-end"><?= $list['contact']; ?></td>
                      </tr>
                    <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'excess_lost') { ?>
                      <tr>
                        <td>มียอดเสียเกิน</td>
                        <td class="text-aqua text-end">
                          <?= $list['sum_excess_lost']; ?> <?= $list['type'] == 'credit' ? 'บาท' : 'แต้ม' ?>
                        </td>
                      </tr>
                      <tr>
                        <td>รับ<?= $list['type'] == 'credit' ? 'เครดิต' : 'แต้ม' ?>คืน</td>
                        <td class="text-aqua text-end">
                          <?= $list['credit_point_back_percent']; ?>% ของยอดเสีย
                        </td>
                      </tr>
                      <tr>
                        <td>รับ<?= $list['type'] == 'credit' ? 'เครดิต' : 'แต้ม' ?>คืนไม่เกิน</td>
                        <td class="text-aqua text-end" nowarp>
                          <?= $list['max_credit_point_back'] ?> <?= $list['type'] == 'credit' ? 'บาท' : 'แต้ม' ?>
                        </td>
                      </tr>
                    <?php } else if ($list['receive_type'] == 'auto' && $list['calculate_type'] == 'play_game') { ?>
                      <tr>
                        <td>เข้าเล่นเกมครบ</td>
                        <td class="text-aqua text-end" nowarp><?= $list['sum_play_game']; ?> ครั้ง</td>
                      </tr>
                      <tr>
                        <td>จำนวนครั้งต่อวันไม่เกิน</td>
                        <td class="text-aqua text-end" nowarp><?= $list['time_per_day']; ?> ครั้ง / คน</td>
                      </tr>
                      <tr>
                        <td>จำนวนครั้งต่อลูกค้าไม่เกิน</td>
                        <td class="text-aqua text-end" nowarp><?= $list['time_per_user'] ?> ครั้ง / ช่วงโปรโมชั่น</td>
                      </tr>
                    <?php } ?>
                  </tbody>
                  <tfoot>
                    <tr style="width: 100%;">
                      <td colspan="3">
                        <ul>
                          <li class="text-table">
                            <span class="text-gold font-17px"> หมายเหตุ :</span>
                            <br>
                            <?= $list['description']; ?>
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
      <?php  } ?>
    </div>
  </div>



  <div class="backdrop-claim" style="display: none;">
    <div class="claim-container">
      <p class="text-gold font-22px">รับ<span class="scope_type"></span>แล้ว!</p>
      <div class="lottie-box">
        <lottie-player src="assets/images/icon/success.json" background="transparent" speed="1" loop autoplay></lottie-player>
      </div>
      <div class="detail">
        <p class="font-18px">
          ระบบได้โอนโบนัส จำนวน <span class="scope_amount_receive"></span><br>
          ไปยังเครดิตของท่านเรียบร้อยแล้ว
        </p>
      </div>
    </div>
  </div>

  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  ?>
  <script>
    $(document).on('click', '.event_confirm', function() {
      var user_id = $(this).attr('user_id');
      var promotion_id = $(this).attr('promotion_id');
      var type = $(this).attr('unit_type');
      var amount = $(this).attr('amount');
      if (type == 'credit') {
        var type_msg = 'เครดิต';
        var currency = 'บาท';
      } else {
        var type_msg = 'แต้ม';
        var currency = 'แต้ม';
      }

      var params = {
        user_id: user_id,
        promotion_id: promotion_id,
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
  </script>
</body>

</html>