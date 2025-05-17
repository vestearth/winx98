<?php

$_PAGE['permission'] = ['no_more_game_agent', 'alliance', 'loss_win_alliance'];
require_once '../../.framework/import.php';

$code = $_GET['c'];
$user = User::getCurrent();
$get_alliance_user = nga_management::getAllianceByUserID($code, $user['id']);
$a_id = (isset($get_alliance_user['id']) && $get_alliance_user['id']) ? $get_alliance_user['id'] : null;
$alliance_data = nga_management::getAllianceByID($code, $a_id);
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

  <?php if ($user['user_type'] == 'Alliance') { ?>
    <div class='bg-whites pb-10px mb-10px'>
      <div class="d-flex top-tap justify-content-between  pt-10px px-15px">
        <div class="msg ">
          <div class='topic'>ยอดพันธมิตร (เดือนปัจจุบันเท่านั้น)</div>
          <div class="font-14px text-sub">
            ข้อมูลรายละเอียดยอดพันธมิตร
          </div>
        </div>
      </div>
    </div>
    <div class="bg-whites pt-15px">
      <div class="form-row px-15px ">
        <div class="col-lg-3 ">
          <div class="mb-10px">
            <div class="card-header-primary py-10px  font-SemiBold font-14px">
              รายละเอียดพันธมิตร
            </div>
            <div class="card-white px-15px py-10px font-Medium">
              <div class=" font-14px">
                ลิงก์แนะนำเพื่อน
              </div>
              <div class="d-flex align-items-center">
                <a class="mr-5px scope_link_hilight" href="<?= $alliance_data['link']; ?>"> <u><?= $alliance_data['link']; ?></u> </a>
                <span class="cursor-pointer  btn-clipboard event-copy-noti copy-icon-w-20px" data-clipboard-text="<?= $alliance_data['link']; ?>"> <?= file_get_contents('assets/icon/icon-copy-green-2.svg') ?></span>
                <input type="hidden" class="scope_link_copy" value="<?= $alliance_data['link'] ?>">
              </div>
            </div>
            <div class="pb-5px"></div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="mb-10px">
            <div class="card-header-success py-10px font-SemiBold font-14px">
              จำนวนสมาชิกทั้งหมด
            </div>
            <div class="card-white px-15px pt-10px pb-20px font-Medium">
              <div class=" font-14px">
                <?php
                if ($alliance_data['alliance_type'] == 'monthly') {
                  $user_count  = $alliance_data['user_count_monthly'];
                } else {
                  $user_count  = $alliance_data['user_count'];
                }
                ?>
                <span class="font-20px font-Bold text-success"><?= number_format($user_count); ?> </span> คน
              </div>
              <div class="pb-25px"></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="mb-10px">
            <div class="card-header-purple  font-SemiBold font-14px">
              จำนวนฝากทั้งหมด
            </div>
            <div class="card-white px-15px py-10px font-Medium">
              <div class=" font-14px">
                <span class="font-20px font-Bold text-success"><?= number_format($alliance_data['sum_user_deposit']); ?> </span> คน
                <div class="pt-5px">
                  คิดเป็น <span class="text-success font-20px font-Bold"><?= number_format($alliance_data['sum_user_deposit_percent']); ?></span> % จากสมาชิกทั้งหมด
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
        </div>
      </div>
    </div>
    <div id="loss_win_alliance" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('loss_win_alliance', '?c=' . $code . '&id=' . $a_id, '', 'รายการ') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search ">
          <thead class="col-6-white">
            <tr>
              <th nowrap data-sort="deposit_first_time_date" data-filter="<?= Homepagify::dataFilter('deposit_first_time_date', 'date') ?>">วันที่ฝากครั้งแรก</th>
              <th nowrap data-sort="user_register_count" data-filter="<?= Homepagify::dataFilter('user_register_count', 'number') ?>">จำนวนคนสมัคร</th>
              <th nowrap data-sort="user_count_by_first_time_date" data-filter="<?= Homepagify::dataFilter('user_count_by_first_time_date', 'number') ?>">ฝากครั้งแรก (คน)</th>
              <th nowrap data-sort="count_deposit_first_time_percent" data-filter="<?= Homepagify::dataFilter('count_deposit_first_time_percent', 'number') ?>">เปอร์เซ็นต์การฝาก</th>
              <th nowrap data-sort="count_user_active" data-filter="<?= Homepagify::dataFilter('count_user_active', 'number') ?>">จำนวนสมาชิก Active</th>
              <th nowrap data-sort="count_user_active_percent" data-filter="<?= Homepagify::dataFilter('count_user_active_percent', 'number') ?>">เปอร์เซ็นต์ Active</th>
              <th nowrap></th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  <?php } else { ?>
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="alert alert-danger text-center font-20px font-Bold" role="alert">
            <span>คุณไม่ใช่ Alliance ไม่สามารถเข้าหน้านี้ได้</span>
          </div>
        </div>
      </div>
    </div>
  <?php } ?>
  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

  <script>
    $(document).on('click', '.event-copy-noti', function() {
      Aww.notification('success', 'copy success');
    })
  </script>

</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>