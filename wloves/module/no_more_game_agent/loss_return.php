<?php

$_PAGE['permission'] = ['no_more_game_agent', 'wallet', 'loss_return'];
require_once '../../.framework/import.php';

$code = $_GET['c'];




function phase_2($msg1, $num_range, $msg2, $class1 = '', $class2 = '', $class = '')
{
  $num = (12 - $num_range);
  echo  '<div class="form-row  font-14px ' . $class . '">
  <div class="col-lg-' . $num_range . ' font-Medium text-grey ' . $class1 . '">
  ' . $msg1 . '
  </div>
  <div class="col-lg-' . $num . ' ' . $class2 . ' ">
  ' . $msg2 . '
  </div>
  </div>';
}


$status_list = [
  [
    'value' => 'confirm',
    'text' => 'ได้รับแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ยอดเงินไม่ได้กดรับ'
  ],
  [
    'value' => 'wait_confirm',
    'text' => 'รอรับ'
  ],
];

$get_statistics = nga_user::getSumUserTurnOverStatistics($code);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('../../');
  Aww::loadAsset('assets/css/no_more_gaming.css');
  ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php include_once '../../structure/layout/header-default.php'; ?>

  <div class='bg-whites pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">
      <div class="msg col-lg-6">
        <div class="d-flex">
          <div class="pr-10px">
            <div class="cursor-pointer" onclick="showContent();">
              <div class="icon_up_summary">
                <?= file_get_contents('./assets/icon/icon-up-blue.svg') ?>
              </div>
              <div class="icon_down_summary" style="display:none;">
                <?= file_get_contents('./assets/icon/icon-down-hide.svg') ?>
              </div>
            </div>
          </div>
          <div>
            <div class='topic'>
              การคืนยอดเสีย </div>
            <div class="font-14px text-sub ">
              แยกตามการคืนยอดเสียตามเงื่อนไข, เลือกข้อมูลที่คุณต้องการค้นหาเป็นพิเศษ
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-whites scope-show" id="content">
    <div class="form-row px-15px ">
      <div class="col-lg-3 ">
        <div class="mb-10px">
          <div class="card-header-primary py-10px  font-SemiBold font-14px">
            ลูกค้าที่เข้าเล่นทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <?= Phase_2('ปกติ', 6, ' <span class="font-20px font-Bold text-success">' . number_format($get_statistics['count_player_play_game'], 0) . '</span> ราย', '', 'font-14px text-right') ?>
            <?php
            /*
            Phase_2('ครบตามเงื่อนไข', 6, ' <span class="font-20px font-Bold text-primary"> 550</span> ราย', '', 'font-14px text-right');
            Phase_2('ไม่เข้าเงื่อนไข', 6, ' <span class="font-20px font-Bold text-danger"> 450</span> ราย', '', 'font-14px text-right');
            */
            ?>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-success py-10px font-SemiBold font-14px">
            ยอดการคืนยอดเสีย
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-success"><?= number_format($get_statistics['sum_turn_over'], 2) ?> </span>บาท
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-purple  font-SemiBold font-14px">
            ยอดเงินกดรับแล้ว
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-purple"><?= number_format($get_statistics['sum_turn_over_received'], 2) ?> </span>บาท
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-orange  font-SemiBold font-14px">
            ยอดเงินคงค้าง
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-orange"><?= number_format($get_statistics['sum_turn_over_outstanding'], 2) ?> </span>บาท
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="table">

    <div id="loss_return" class="container-pagination bg-white  no-border-radius scope-show" <?= Homepagify::createHomepagify('loss_return', '?c=' . $code, '', 'รายการ') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead>
            <tr>
              <th nowrap data-sort="turn_over_date" data-filter="<?= Homepagify::dataFilter('turn_over_date', 'date') ?>">วัน</th>
              <th nowrap data-sort="user_username" data-filter="<?= Homepagify::dataFilter('user_username', 'text') ?>">รหัสลูกค้า</th>
              <th nowrap data-sort="user_bank_name" data-filter="<?= Homepagify::dataFilter('user_bank_name', 'text') ?>">ชื่อลูกค้า </th>
              <th nowrap class="thin-cell" data-sort="sum_loss_amount" data-filter="<?= Homepagify::dataFilter('sum_loss_amount', 'number') ?>">ยอดเสีย</th>
              <th nowrap data-sort="sum_turn_over" data-filter="<?= Homepagify::dataFilter('sum_turn_over', 'number') ?>">จำนวนเงินคืนทั้งหมด</th>
              <th nowrap class="thin-cell" data-sort="sum_turn_over_received" data-filter="<?= Homepagify::dataFilter('sum_turn_over_received', 'number') ?>">จำนวนเบิก</th>
              <th nowrap class="thin-cell" data-sort="sum_turn_over_outstanding" data-filter="<?= Homepagify::dataFilter('sum_turn_over_outstanding', 'number') ?>">จำนวนค้าง</th>
              <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>

            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>


  <?php Tiwdal::startModal('detail_modal', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form method="post" class="">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-16px font-SemiBold">ข้อมูลการถอน</h5>
      </div>
      <div class="modal-body pt-0 px-5px">
        <div class="form-row border-bottom px-15px  ">
          <div class="col-lg-6 border-right">
            <div class="font-14px font-italic py-10px">
              รายละเอียดลูกค้า
            </div>
            <div class="form-row pb-10px">
              <div class="col-3">
                <img src="./assets/image/scb-large.png">
              </div>
              <div class="col-9">
                <div class="text-primary font-18px">
                  เกศรินทร์ เหล็กคำ
                </div>
                <div>
                  000-0-0000-0
                </div>
              </div>
            </div>
            <?= Phase_2('รหัสสมาชิก', 6, '89bvia9367') ?>
            <?= Phase_2('เบอร์โทร', 6, '0844644816') ?>
            <?= Phase_2('กลุ่มลูกค้า', 6, 'Bronze') ?>

          </div>
          <div class="col-lg-6">
            <div class="font-14px font-italic py-10px">
              รายละเอียดการถอน
            </div>
            <?= Phase_2('วัน/เวลา', 5, '14/06/2022, 07:49') ?>
            <?= Phase_2('ยอดเงิน', 5, '57.00') ?>
            <?= Phase_2('สถานะ', 5, 'สำเร็จแล้ว', '', 'text-success font-14px') ?>
            <?= Phase_2('เหตุผล', 5, 'ถอนเงินผ่านธนาคารไทยพาณิชย์ เลขบัญชี 411-1-01708-3') ?>

          </div>
        </div>
        <div class="form-row px-15px">
          <div class="col-lg-8 ">
            <div class="font-14px font-italic py-10px">
              รายละเอียดการถอน
            </div>
            <?= Phase_2('วันที่โอน', 6, '14/06/2022, 07:49') ?>
            <?= Phase_2('ยอดเงิน', 6, '57.00') ?>
            <?= Phase_2('เลขบัญชี', 6, '<div>บัญชีเว็บ: 829-2-65515-6</div>
                                    <div> บัญชีลูกค้า: 411-1-01708-3</div>') ?>
            <?= Phase_2('สถานะ', 6, 'โอนเงินเเล้ว') ?>
            <?= Phase_2('Otp', 6, '377123 (Ref. AX4RTY)') ?>
            <?= Phase_2('ก่อนโอน', 6, '200.00') ?>
            <?= Phase_2('หลังโอน', 6, '143.00') ?>
            <?= Phase_2('หมายเหตุ', 6, 'สำเร็จ') ?>
            <?= Phase_2('โอนโดย', 6, '<img src="./assets/image/bot-auto.png">') ?>
          </div>
        </div>

      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_add_guide', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-danger',], ['text' => 'ยกเลิกการถอน']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
  <?php Aww::loadAsset('assets/js/force_logout.js'); ?>

  <script>
    function showContent() {
      var content = document.getElementById("content");
      var table = document.getElementById("table");
      var icon_show = document.getElementsByClassName("icon_up_summary");
      var icon_hide = document.getElementsByClassName("icon_down_summary");
      if (content.style.display === "none") {
        content.style.display = "block";
        table.style.display = "block";
        icon_show[0].style.display = "block";
        icon_hide[0].style.display = "none";
      } else {
        content.style.display = "none";
        table.style.display = "none";
        icon_show[0].style.display = "none";
        icon_hide[0].style.display = "block";
      }
    }
  </script>

</body>

</html>