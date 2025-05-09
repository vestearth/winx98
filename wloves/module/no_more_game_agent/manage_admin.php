<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'manage_admin'];
require_once '../../.framework/import.php';

$code = $_GET['c'];

$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 1;
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
  <div class="col-lg-12 px-0">
    <div class="d-flex">
      <div class="col-lg-4 px-0 bg-white">
        <div class="d-flex align-items-center justify-content-between my-5px mx-15px">
          <div class="mb-5px">
            <div class="font-18px text-info font-SemiBold">แอดมิน
            </div>
            <div class="font-15px text-secondary">สร้างและจัดการแอดมิน</div>
          </div>
          <?php if ($is_edit == 1) { ?>
            <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'pl-20px pr-20px mr-15px opacity-5'], ['type' => 'button', 'text' => '+ เพิ่มแอดมิน', 'modal_id' => 'add_admin', 'modal_data' => []]); ?>
          <?php } else { ?>
            <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'pl-20px pr-20px mr-15px'], ['type' => 'button', 'text' => '+ เพิ่มแอดมิน', 'modal_id' => 'add_admin', 'modal_data' => []]); ?>
          <?php } ?>
        </div>
        <div class="editable-card core-new border-radius-0 mb-50px">
          <div id="manage_admin" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('manage_admin', '?c=' . $_GET['c'] . '&id=' . $id, '', 'แอดมิน',) ?>>
            <div class="table-responsive">
              <table class="table table-sort table-search">
                <thead>
                  <tr>
                    <th class="thin-cell" nowrap data-sort="toptic" data-filter="<?= Homepagify::dataFilter('', 'text') ?>">ชื่อ</th>
                    <th nowrap data-sort="detail" data-filter="<?= Homepagify::dataFilter('', 'text') ?>">Username</th>
                    <th class=" text-right" nowrap data-sort="score_use" data-filter="<?= Homepagify::dataFilter('', 'text') ?>">Permission</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>

      </div>
      <div class="col-lg-8 px-0 bg-white border-left h-90-vh">
        <div class="bg-white" style="z-index: 3; width:100%">
          <div class="d-flex align-items-center justify-content-between my-5px mx-15px">
            <div class=" mb-5px">
              <div class="font-18px text-info font-SemiBold">ข้อมูลแอดมิน |<span class=" text-primary"> jane@gmail.com</span>
              </div>
              <div class="font-15px text-secondary">จัดการข้อมูลแอดมิน และความสามารถในการเข้าถึง</div>
            </div>
            <?php if ($is_edit == 1) { ?>
              <div class=" d-flex align-items-center">
                <a href="manage_admin.php?c=<?= $_GET['c'] ?>">
                  <button type="button" class="btn btn-close-modal text-dark mr-5px w-80px">ยกเลิก</button>
                </a>
                <button type="submit" name="submit_edit_admin" class="form-btn">บันทึก</button>
              </div>
            <?php } else { ?>
              <div class=" d-flex align-items-center">
                <a href="manage_admin.php?c=<?= $_GET['c'] ?>&is_edit=1">
                  <button type="button" class="btn btn-outline-info w-120px mr-10px">แก้ไขข้อมูล</button>
                </a>
                <button type="button" class="btn btn-dropdown-3dot p-0 bg-card-navbar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?= file_get_contents('assets/icon/more.svg'); ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm border-radius-10px py-0">
                  <button type="button" class="btn dropdown-item align-items-center more-hover-active" <?= Tiwdal::register('delete_admin', []); ?>>
                    <?= file_get_contents('assets/icon/icon-delete.svg') ?>
                    <span class="ml-10px text-danger">ลบแอดมิน</span>
                  </button>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
        <div class="border-header"></div>
        <div class="editable-card core-new border-radius-0 mb-50px bg-white overflow-auto h-80-vh">
          <div class="d-flex align-items-center justify-content-between my-5px mx-15px">
            <div class="mb-5px">
              <div class="font-15px text-info font-SemiBold mb-5px"><i>ข้อมูลเบื้องต้น</i>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-12">
              <div class="form-row">
                <div class="col-lg-3 font-15px font-SemiBold text-secondary mb-5px">
                  ชื่อ
                </div>
                <div class="col-lg-9 font-16px font-Medium">
                  <?php if ($is_edit == 1) { ?>
                    <?= TiwForm::normal('text', 'james', ['name' => '', 'placeholder' => 'กรอก', 'class' => 'mb-0 max-w-200px'], []); ?>
                  <?php } else { ?>
                    james
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-12">
              <div class="form-row">
                <div class="col-lg-3 font-15px font-SemiBold text-secondary mb-5px">
                  Username
                </div>
                <div class="col-lg-9 font-16px font-Medium">
                  james@ust.hk <span class=" text-primary">(Active)</span>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-12">
              <div class="form-row">
                <div class="col-lg-3 font-15px font-SemiBold text-secondary mb-5px">
                  รหัสผ่าน
                </div>
                <div class="col-lg-9">
                  <div>
                    ••••••••• <?php if ($is_edit == 1) { ?>
                      <span class=" text-primary ml-5px font-16px font-Medium opacity-5"><u>เปลี่ยนรหัสผ่าน</u></span>
                    <?php } else { ?>
                      <span class=" text-primary ml-5px font-16px font-Medium cursor-pointer" <?= Tiwdal::register('change_password', []); ?>><u>เปลี่ยนรหัสผ่าน</u></span>
                    <?php } ?>
                    <div class=" text-muted">
                      เปลี่ยนรหัสผ่านล่าสุด : 31/12/2025, 00:00 โดย James
                    </div>
                  </div>
                </div>
                <?php if ($is_edit == 1) { ?>
                  <div class="col-lg-12 font-16px font-Medium">
                    <div class="d-flex justify-content-end">
                      <div class=" mr-15px">
                        <u>
                          <a class="text-danger" href="#">ล้างทั้งหมด</a>
                        </u>
                      </div>
                      <div class="">
                        <u>
                          <a class=" text-primary" href="#">เลือกทั้งหมด</a>
                        </u>
                      </div>
                    </div>
                  </div>
                <?php } else { ?>

                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0">
            <div class=" bg-info min-h-40px d-flex align-items-center">
              <div class="px-15px text-white font-Bold">
                <i>ดูแลระบบ</i>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-hover min-h-35px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                เมนู
              </div>
            </div>
            <div class=" col-lg-2 bg-hover min-h-35px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                Permission
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                ลูกค้า
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายการฝาก - ถอน
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายการลดเครดิต
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                Statements
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายการแลกของรางวัล
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0">
            <div class=" bg-info min-h-40px d-flex align-items-center">
              <div class="px-15px text-white font-Bold">
                <i>กระเป๋าเงิน</i>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-hover min-h-35px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                เมนู
              </div>
            </div>
            <div class=" col-lg-2 bg-hover min-h-35px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                Permission
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายการเพิ่มเครดิต (ฝากมือ)
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายการเพิ่มเครดิต (กิจกรรม)
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายการเพิ่มเครดิต (โปรโมชั่น)
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รวมรายการเพิ่มเครดิต
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายการโบนัสชวนเพื่อน
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายการคืนยอดเสีย
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                สรุปรายการคืนยอด
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0">
            <div class=" bg-info min-h-40px d-flex align-items-center">
              <div class="px-15px text-white  font-Bold">
                <i>เอเยนต์</i>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-hover min-h-35px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                เมนู
              </div>
            </div>
            <div class=" col-lg-2 bg-hover min-h-35px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                Permission
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                เอเยนต์
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0">
            <div class=" bg-info min-h-40px d-flex align-items-center">
              <div class="px-15px text-white  font-Bold">
                <i>การตลาด</i>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-hover min-h-35px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                เมนู
              </div>
            </div>
            <div class=" col-lg-2 bg-hover min-h-35px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                Permission
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                ยอดการตลาด
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                ยอดการตลาด
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0">
            <div class=" bg-info min-h-40px d-flex align-items-center">
              <div class="px-15px text-white  font-Bold">
                <i>การจัดการ</i>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-hover min-h-35px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                เมนู
              </div>
            </div>
            <div class=" col-lg-2 bg-hover min-h-35px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                Permission
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                การโยกเงิน
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                ประวัติการเล่นเกม
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                ตั้งค่าฐานข้อมูลระบบ
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0">
            <div class=" bg-info min-h-40px d-flex align-items-center">
              <div class="px-15px text-white  font-Bold">
                <i>ข้อมูลสรุปและสถิติ</i>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-hover min-h-35px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                เมนู
              </div>
            </div>
            <div class=" col-lg-2 bg-hover min-h-35px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                Permission
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                ภาพรวม
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายงานสรุปยอดฝาก / ถอน
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายงานสรุปยอดฝาก / ถอนแยกรายบัญชี
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายงานสรุปการฝากเงินไม่สำเร็จ
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายงานสรุปยอดโยกเงิน
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายงานสรุปผลแยกตามโปรโมชั่น
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายงานสรุปผลแยกตามลูกค้า
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายงานการชวนเพื่อน
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายงานโบนัสจากการชวนเพื่อน
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายงานหมุนวงล้อ & เล่นไพ่
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                รายการสรุปการคืนยอด
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0">
            <div class=" bg-info min-h-40px d-flex align-items-center">
              <div class="px-15px text-white  font-Bold">
                <i>ผู้ใช้งานระบบ</i>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-hover min-h-35px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                เมนู
              </div>
            </div>
            <div class=" col-lg-2 bg-hover min-h-35px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-secondary font-15px font-Medium">
                Permission
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                จัดการแอดมิน
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                ประวัติการแก้ไขข้อมูลลูกค้า
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
          <div class="col-lg-12 px-0 d-flex">
            <div class=" col-lg-10 bg-white min-h-40px d-flex align-items-center px-0 j-border">
              <div class="px-15px text-secondary font-16px font-Medium">
                Block IP
              </div>
            </div>
            <div class=" col-lg-2 bg-white min-h-40px d-flex align-items-center px-0 justify-content-center j-border">
              <div class="px-15px text-primary font-15px font-Medium">
                <?php if ($is_edit == 1) { ?>
                  <?= TiwForm::normal('checkbox', '', ['name' => '', 'checked' => true], ['style' => '3']); ?>
                <?php } else { ?>
                  Yes
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php Tiwdal::startModal('change_password', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form action="" method="post" id="change_password">
    <div class="modal-body border-radius-10-10-0-0px">
      <div class=" font-16px font-SemiBold mt-5px d-flex justify-content-between align-items-center">
        <div>
          เปลี่ยนรหัสผ่าน
        </div>
        <div class=" font-15px font-Regular">
          เปลี่ยนรหัสผ่านล่าสุด : 31/12/2025, 00:00 โดย James
        </div>
      </div>
      <hr class=" mx--15px">
      <div class="form-group">
        <div class="form-row align-items-center">
          <div class="col-lg-3 py-5px font-14px font-Medium">
            รหัสผ่านใหม่<span class=" text-danger">*</span>
          </div>
          <div class="col-lg-9">
            <?= TiwForm::normal('password', '•••••••••', ['name' => '', 'placeholder' => 'กรอก', 'class' => 'mb-0'], []); ?>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row align-items-center">
          <div class="col-lg-3 py-5px font-14px font-Medium">
            ยืนยันรหัสผ่านใหม่<span class=" text-danger">*</span>
          </div>
          <div class="col-lg-9">
            <?= TiwForm::normal('password', '•••••••••', ['name' => '', 'placeholder' => 'กรอก', 'class' => 'mb-0'], []); ?>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div class="modal-footer d-flex justify-content-end">
    <button type="button" class="btn btn-close-modal w-100px" data-dismiss="modal">ยกเลิก</button>
    <button type="submit" name="submit_change_password" form="change_password" class="btn btn-primary w-120px">ยืนยัน</button>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('add_admin', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form action="" method="post" id="add_admin">
    <div class="modal-body border-radius-10-10-0-0px">
      <div class=" font-16px font-SemiBold mt-5px">
        <div>
          เพิ่มแอดมิน
        </div>
      </div>
      <hr class=" mx--15px">
      <div class="form-group">
        <div class="form-row align-items-center">
          <div class="col-lg-3 py-5px font-14px font-Medium">
            ชื่อ
          </div>
          <div class="col-lg-9">
            <?= TiwForm::normal('text', '', ['name' => '', 'placeholder' => 'กรอก', 'class' => 'mb-0'], []); ?>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="form-row align-items-center">
          <div class="col-lg-3 py-5px font-14px font-Medium">
            Email
          </div>
          <div class="col-lg-9">
            <?= TiwForm::normal('text', '', ['name' => '', 'placeholder' => 'กรอก', 'class' => 'mb-0'], []); ?>
          </div>
        </div>
      </div>
      <hr class=" mx--15px">
      <div class="form-group">
        <div class="form-row align-items-center">
          <div class="col-lg-3 py-5px font-14px font-Medium">
            รหัสผ่านเพื่อระบุตัวตน
          </div>
          <div class="col-lg-9">
            <?= TiwForm::normal('number', '•••••••••', ['name' => '', 'placeholder' => '', 'class' => 'mb-0'], []); ?>
          </div>
        </div>
      </div>
    </div>
  </form>
  <div class="modal-footer d-flex justify-content-end">
    <button type="button" class="btn btn-close-modal w-100px" data-dismiss="modal">ยกเลิก</button>
    <button type="submit" name="submit_add_admin" form="add_admin" class="btn btn-primary w-120px">สร้าง</button>
  </div>
  <?php Tiwdal::endModal() ?>

  <?php Tiwdal::startModal('delete_admin', 'modal-md'); ?>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <form action="" method="post" id="delete_admin">
    <div class="modal-body border-radius-10-10-0-0px">
      <div class="form-row align-items-center">
        <div class="col-12 form-group text-center">
          <p class="text-info mb-5px mt-20px font-SemiBold font-16px text-uppercase">ลบแอดมิน</p>
          <p class="text-info mb-0 font-14px">คุณต้องการ <span class="text-danger">“ลบแอดมิน”</span> ใช่หรือไม่</p>
        </div>
      </div>
    </div>
  </form>
  <div class="modal-footer d-flex justify-content-end">
    <button type="button" class="btn btn-close-modal w-100px" data-dismiss="modal">ยกเลิก</button>
    <button type="submit" name="submit_delete_admin" form="delete_admin" class="btn btn-danger w-120px">ยืนยัน</button>
  </div>
  <?php Tiwdal::endModal() ?>


  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>

</html>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>