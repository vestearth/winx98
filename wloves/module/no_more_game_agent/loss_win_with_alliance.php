<?php

$_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'loss_win_with_alliance'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$total_summary = nga_management::getSumAllianceDetail($code);
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

  <div class='bg-whites mb-10px pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px px-15px">
      <div class="msg ">
        <div class='topic'>ยอดรวมพันธมิตร</div>
        <div class="font-14px text-sub">
          ข้อมูลรายละเอียดยอดรวมพันธมิตร
        </div>
      </div>
    </div>
  </div>
  <div class="bg-whites pt-15px">
    <div class="form-row px-15px ">
      <div class="col-lg-3 ">
        <div class="mb-10px">
          <div class="card-header-primary py-10px  font-SemiBold font-14px">
            จำนวนพันธมิตรทั้งหมด
          </div>
          <div class="card-white px-15px pt-10px pb-20px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-primary"><?= number_format($total_summary['alliance_count']); ?> </span>พันธมิตร
            </div>
            <div class="pb-20px"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-success py-10px font-SemiBold font-14px">
            ยอดชวนเพื่อนทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-success"><?= number_format($total_summary['sum_user_count']); ?> </span> คน
              <div class="pt-5px">
                จากพันธมิตรทั้งหมด <span class="text-primary"><?= number_format($total_summary['alliance_count']); ?></span> พันธมิตร
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-purple  font-SemiBold font-14px">
            ยอดฝากครั้งแรกรวมทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-purple"><?= number_format($total_summary['sum_deposit_first_time'], 2); ?> </span> บาท
              <div class="pt-5px">
                จากชวนเพื่อนทั้งหมด <span class="text-primary"><?= number_format($total_summary['sum_user_count']); ?></span> คน
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="mb-10px">
          <div class="card-header-danger  font-SemiBold font-14px">
            รวมยอดเสียของพันธมิตรทั้งหมด
          </div>
          <div class="card-white px-15px py-10px font-Medium">
            <div class=" font-14px">
              <span class="font-20px font-Bold text-danger"><?= number_format($total_summary['sum_lost'], 2); ?> </span>บาท
            </div>
            <div class="pt-5px">
              จากพันธมิตรทั้งหมด <span class="text-primary"><?= number_format($total_summary['alliance_count']); ?></span> พันธมิตร
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="loss_win_with_alliance" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('loss_win_with_alliance', '?c=' . $code, '', 'รายการ') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <?php /* 
            <th nowrap data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วันที่สมัคร</th>
            */ ?>
            <th nowrap data-sort="name" data-filter="<?= Homepagify::dataFilter('name', 'text') ?>">ชื่อพันธมิตร</th>
            <th nowrap data-sort="user_count" data-filter="<?= Homepagify::dataFilter('user_count', 'number') ?>">จำนวนชวนเพื่อน</th>
            <th nowrap>การฝากครั้งแรก</th>
            <th nowrap data-sort="count_deposit_first_time_percent">เปอร์เซ็นต์การฝาก</th>
            <th nowrap>ยอดฝากครั้งแรก</th>
            <th nowrap></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>