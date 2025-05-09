<?php

$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'summary_account'];
require_once '../../.framework/import.php';

$code = $_GET['c'];

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

  <div class="bg-w pb-15px mb-10px">
    <div class='pb-15px'>
      <div class="pt-10px px-15px">
        <div class="font-16px font-SemiBold">บัญชีสรุปยอด</div>
        <div class="font-15px font-Bold font-italic mt-15px">คำนวณส่วนต่าง</div>
        <div class="row mt-10px">
          <div class="col-md-4">
            <div class="border border-radius-5px py-5px mb-10px">
              <div class="text-center font-Medium">95,000.00</div>
            </div>
            <div class="text-center font-15px font-SemiBold">ยอดรวมเงินสดที่ได้รับ</div>
          </div>
          <div class="col-md-4">
            <div class="border border-radius-5px py-5px mb-10px">
              <div class="text-center font-Medium">100,000.00</div>
            </div>
            <div class="text-center font-15px font-SemiBold">ยอดส่วนต่างที่โชว์หน้าระบบ</div>
          </div>
          <div class="col-md-4">
            <div class="border border-radius-5px py-5px border-0 card-header-primary mb-10px">
              <div class="text-center text-primary font-Bold">5,000.00</div>
            </div>
            <div class="text-center font-15px font-SemiBold">ส่วนต่าง</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-w py-15px">
    <div class="row px-15px summary_event">
      <div class="col-lg-6">
        <div class="border-round mb-10px p-0 overflow-hidden">
          <div class="p-10px font-16px font-Bold">ยอดรวมถอนที่ลูกค้าถอนจากระบบ ต่อวัน</div>
          <div class="table-responsive ">
            <table class="table p-0 m-0 ">
              <thead>
                <tr class="bg-head-table-grey ">
                  <td>บัญชีถอน</td>
                  <td class="text-right">ยอดรวมถอน ต่อวัน</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td nowrap>
                    <div><img src="assets/image/scb-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 743-1-0467-6</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">1,381,652.00</td>
                </tr>
                <tr>
                  <td nowrap class="">
                    <div><img src="assets/image/ktb-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 743-1-9000-8</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">1,189,002.00</td>
                </tr>
                <tr class="bg-danger-2 p-0">
                  <td nowrap class="">
                    <div class="font-16px font-Medium">ยอดรวมถอนทุกบัญชี</div>
                  </td>
                  <td nowrap class="text-right">
                    <div class="font-18px font-Bold text-danger">2,570,654.00</div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="bg-danger-2 pt-1"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="border-round mb-10px p-0 overflow-hidden">
          <div class="p-10px font-16px font-Bold">ยอดรวมถอนที่ออกจากธนาคาร ต่อวัน</div>
          <div class="table-responsive ">
            <table class="table p-0 m-0 ">
              <thead>
                <tr class="bg-head-table-grey ">
                  <td>บัญชีถอน</td>
                  <td class="text-right">ยอดรวมถอน ต่อวัน</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td nowrap>
                    <div><img src="assets/image/scb-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 743-1-0467-6</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">1,200,000.00</td>
                </tr>
                <tr>
                  <td nowrap class="">
                    <div><img src="assets/image/ktb-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 743-1-9000-8</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">1,200,000.00</td>
                </tr>
                <tr class="bg-danger-2 p-0">
                  <td nowrap class="">
                    <div class="font-16px font-Medium">ยอดรวมถอนทุกบัญชี</div>
                  </td>
                  <td nowrap class="text-right">
                    <div class="font-18px font-Bold text-danger">2,400,000.00</div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="bg-danger-2 pt-1"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="border-round mb-10px p-0 overflow-hidden">
          <div class="p-10px font-16px font-Bold">ยอดรวมฝากที่ลูกค้าฝากเข้าระบบ ต่อวัน</div>
          <div class="table-responsive ">
            <table class="table p-0 m-0 ">
              <thead>
                <tr class="bg-head-table-grey ">
                  <td>บัญชีฝาก</td>
                  <td class="text-right">ยอดรวมฝาก ต่อวัน</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td nowrap>
                    <div><img src="assets/image/scb-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 743-1-0467-6</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">59,250,288.50</td>
                </tr>
                <tr>
                  <td nowrap class="">
                    <div><img src="assets/image/ktb-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 743-1-9000-8</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">20,335,187.00</td>
                </tr>
                <tr>
                  <td nowrap class="">
                    <div><img src="assets/image/gsb.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 448-2-1456-2</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">3,588,050.00</td>
                </tr>
                <tr>
                  <td nowrap class="">
                    <div><img src="assets/image/kbank-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 346-9-2245-1</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">11,468,350.00</td>
                </tr>
                <tr class="bg-success-2 p-0">
                  <td nowrap class="">
                    <div class="font-16px font-Medium">ยอดรวมฝากทุกบัญชี</div>
                  </td>
                  <td nowrap class="text-right">
                    <div class="font-18px font-Bold text-success">94,641,875.50</div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="bg-success-2 pt-1"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="border-round mb-10px p-0 overflow-hidden">
          <div class="p-10px font-16px font-Bold">ยอดรวมฝากที่ลูกค้าฝากเข้าธนาคาร ต่อวัน</div>
          <div class="table-responsive ">
            <table class="table p-0 m-0 ">
              <thead>
                <tr class="bg-head-table-grey ">
                  <td>บัญชีฝาก</td>
                  <td class="text-right">ยอดรวมฝาก ต่อวัน</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td nowrap>
                    <div><img src="assets/image/scb-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 743-1-0467-6</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">1,381,652.00</td>
                </tr>
                <tr>
                  <td nowrap class="">
                    <div><img src="assets/image/ktb-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 743-1-9000-8</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">1,189,002.00</td>
                </tr>
                <tr>
                  <td nowrap class="">
                    <div><img src="assets/image/gsb.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 448-2-1456-2</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">3,588,050.00</td>
                </tr>
                <tr>
                  <td nowrap class="">
                    <div><img src="assets/image/kbank-high.png" class="w-30px" alt=""> <span class="ml-10px"> สมพงษ์ สงวนศรี 346-9-2245-1</span></div>
                  </td>
                  <td nowrap class="text-right font-SemiBold">11,468,350.00</td>
                </tr>
                <tr class="bg-success-2 p-0">
                  <td nowrap class="">
                    <div class="font-16px font-Medium">ยอดรวมฝากทุกบัญชี</div>
                  </td>
                  <td nowrap class="text-right">
                    <div class="font-18px font-Bold text-success">40,017,200.00</div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="bg-success-2 pt-1"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>


</body>


</html>
<?php Aww::loadAsset('assets/js/force_logout.js'); ?>