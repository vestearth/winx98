<?php

$_PAGE['permission'] = ['no_more_game_agent', 'wallet', 'add_credit_list'];
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


$type_list = [
  [
    'value' => 'เปิดไพ่',
    'text' => 'เปิดไพ่'
  ],
  [
    'value' => 'หมุนวงล้อ',
    'text' => 'หมุนวงล้อ'
  ],
  [
    'value' => 'ฝากมือ',
    'text' => 'ฝากมือ'
  ],
];

$status_list = [
  [
    'value' => 'success',
    'text' => 'ได้รับแล้ว'
  ],
];


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
    <div class="d-flex top-tap justify-content-between pt-10px">
      <div class="msg col-lg-6">
        <div class='topic'>
          รวมรายการเพิ่มเครดิต </div>
        <div class="font-14px text-sub ">
          ข้อมูลรายละเอียดรวมรายการเพิ่มเครดิต
        </div>
      </div>
    </div>
  </div>
  <div id="add_credit_list" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('add_credit_list', '?c=' . $code, '', 'รวมรายการเพิ่มเครดิต') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วัน/เวลา</th>
            <th nowrap>ประเภท</th>
            <th nowrap data-sort="customer_username" data-filter="<?= Homepagify::dataFilter('customer_username', 'text') ?>">รหัสลูกค้า</th>
            <th nowrap class="thin-cell" data-sort="credit_amount" data-filter="<?= Homepagify::dataFilter('credit_amount', 'number') ?>">ยอดเงิน</th>
            <th nowrap data-sort="credit_before" class="thin-cell">เครดิต (ก่อน)</th>
            <th nowrap data-sort="credit_after" class="thin-cell">เครดิต (หลัง)</th>
            <th nowrap class="thin-cell">ธนาคาร</th>
            <th nowrap>สถานะ</th>
            <th nowrap data-sort="remark" data-filter="<?= Homepagify::dataFilter('remark', 'text') ?>">หมายเหตุ</th>
            <th></th>
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
        <h5 class="modal-title font-16px font-SemiBold">รายการฝาก</h5>
      </div>
      <div class="modal-body pt-0 px-15px">
        <div class="font-SemiBold font-14px pt-10px pb-5px">รายละเอียด</div>
        <?= Phase_2('วัน/เวลา(สร้าง)', 4, '<span name="{transaction_date_time}"></span>', 'font-14px font-Medium', 'font-16px') ?>
        <?= Phase_2('ยอดเงิน', 4, '<span name="{credit_amount}"></span>', 'font-14px font-Medium', 'font-16px') ?>
        <?= Phase_2('รหัสลูกค้า', 4, '<span name="{customer_username}"></span>', 'font-14px font-Medium', 'font-16px') ?>
        <?= Phase_2('โอนโดย', 4, '<span class="text-primary" name="{admin_username}"></span>', 'font-14px font-Medium', 'font-16px') ?>
        <?= Phase_2('สถานะ', 4, '<div class="bg-green square-round">ได้รับเงินแล้ว</div>', 'font-14px font-Medium', 'font-14px ') ?>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-cancels min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'กลับ']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('detail_preview_img', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title font-16px font-SemiBold">รูปภาพ</h5>
    </div>
    <div class="modal-body pt-0 px-15px">
      <div class="row">
        <div class="col-12 d-flex justify-content-center">
          <div class="w-100 d-flex justify-content-center">
            <img src="" name="{admin_confirm_image}" class="w-500px border-bottom-radius-10px object-fit-contain">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-cancels min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'กลับ']); ?>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php 
  Structure::loadFooter('../../'); 
  Aww::loadAsset('assets/js/force_logout.js');
  ?>


</body>

</html>