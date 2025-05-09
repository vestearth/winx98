<?php

$_PAGE['permission'] = ['no_more_game_agent', 'wallet', 'bonus_invite'];
require_once '../../.framework/import.php';

$code = $_GET['c'];

$status_list = [

  [
    'value' => 'success',
    'text' => 'สำเร็จแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ดำเนินการ'
  ],
];

function phase_2($msg1, $num_range, $msg2, $class1 = '', $class2 = '', $class = '')
{
  $num = (12 - $num_range);
  echo  '<div class="form-row py-5px font-14px ' . $class . '">
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
    'value' => 'completed',
    'text' => 'ได้รับแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ยกเลิก'
  ],
  [
    'value' => 'waiting',
    'text' => 'รอรับ'
  ],
];

$summary_data = nga_statistic::getSummaryUserCommission($code);

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

  <div class='bg-whites pb-10px mb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">

      <div class="msg col-lg-6">
        <div class='topic'>
          รายการโบนัสชวนเพื่อน </div>
        <div class="font-14px text-sub ">
          ข้อมูลรายละเอียดรายการโบนัสชวนเพื่อน
        </div>
      </div>
    </div>
  </div>

  <div class="bg-whites">
    <div class="form-row px-15px ">
      <div class="col-lg-3 ">
        <div class="my-10px">
          <div class="card-header-primary py-10px  font-SemiBold font-14px">
            จำนวนผู้รับทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-primary"><?= number_format($summary_data['count_user_receive'], 0); ?></span>
              คน
            </div>
            <div class="pb-20px">
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="my-10px">
          <div class="card-header-success py-10px font-SemiBold font-14px">
            ยอดรับทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-success"><?= number_format($summary_data['sum_commission'], 2); ?> </span>บาท
              <div class="pt-5px">
                จากผู้รับทั้งหมด <span class="text-primary"><?= number_format($summary_data['count_user_receive'], 0); ?></span> คน
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="my-10px">
          <div class="card-header-purple  font-SemiBold font-14px">
            ยอดที่รับไปแล้ว
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-purple"><?= number_format($summary_data['sum_commission_received'], 2); ?> </span>บาท
              <div class="pt-5px">
                จากผู้รับทั้งหมด <span class="text-primary"><?= number_format($summary_data['count_user_receive'], 0); ?></span> คน
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="col-lg-3">
        <div class="my-10px">
          <div class="card-header-orange  font-SemiBold font-14px">
            ยอดที่รอรับ
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-orange"><?= number_format($summary_data['sum_commission_outstanding'], 2); ?> </span>บาท
            </div>
            <div class="pt-5px">
              จากผู้รับทั้งหมด <span class="text-primary"><?= number_format($summary_data['count_user_receive'], 0); ?></span> คน
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div id="bonus_invite" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('bonus_invite', '?c=' . $code, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="member_code" data-filter="<?= Homepagify::dataFilter('member_code', 'text') ?>">รหัสแนะนำ</th>
            <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">รหัสลูกค้า</th>
            <th nowrap data-sort="bank_name" data-filter="<?= Homepagify::dataFilter('bank_name', 'text') ?>">ชื่อลูกค้า </th>
            <th nowrap data-sort="sum_money_diff" data-filter="<?= Homepagify::dataFilter('sum_money_diff', 'number') ?>">ยอดเงินที่ได้</th>
            <th nowrap data-sort="sum_money_upline" data-filter="<?= Homepagify::dataFilter('sum_money_upline', 'number') ?>">ยอดเงินที่คืน</th>
            <th nowrap data-sort="money_upline_received" data-filter="<?= Homepagify::dataFilter('money_upline_received', 'number') ?>">ยอดเงินกดรับแล้ว</th>
            <th nowrap data-sort="money_upline_outstanding" data-filter="<?= Homepagify::dataFilter('money_upline_outstanding', 'number') ?>">ยอดเงินคงค้าง</th>
            <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>

          </tr>
        </thead>
      </table>
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


</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>