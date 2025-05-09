<?php
$_PAGE['permission'] = ['no_more_game_agent', 'monthly_report', 'agent_monthly'];
require_once '../../.framework/import.php';

$code = $_GET['c'];

if ($_POST) {
  if (isset($_POST['upload-file'])) {
    $id = $_POST['id'];
    $slip = $_FILES['slip'];
    $result = nga_agent::uploadBillSlip($code, $id, $slip);
  }
  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

$select_bill = nga_agent::selectBillFromAdmin($code);
$get_invoice =  nga_agent::getMyInvoiceMonthly($code);
$result = [];
if ($get_invoice) {
  $arr_bot = [
    "mobileNumber" => "0650681886",
    "amount" => floatval($get_invoice['total_invoice_price'])
  ];
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL            => "http://ppqr.wolve.dev/generateqr",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING       => "",
    CURLOPT_MAXREDIRS      => 10,
    CURLOPT_TIMEOUT        => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST  => "POST",
    CURLOPT_HTTPHEADER     => array(
      'Content-Type: application/json; charset=UTF-8',
    ),
    CURLOPT_POSTFIELDS     => json_encode($arr_bot),
  ));

  $response = curl_exec($curl);
  //check is time out
  if ($response === false) {
    $errno = curl_errno($curl);
    curl_close($curl);
    // Check if the error is due to a timeout
    if ($errno === CURLE_OPERATION_TIMEDOUT) {
      return Amst::repError('Connection timeout');
    }
  } else {
    curl_close($curl);
  }
  $result = json_decode($response, true);
}
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

  <div class="container-fluid mt-15px">
    <div class="row">
      <div class="col-lg-6">
        <div class="w-loves-card  border-radius-0 p-15px mb-15px">
          <div class="d-flex justify-content-between align-items-center  mb-15px">
            <div class="">
              <div class="font-18px font-SemiBold">ชำระค่าบริการรายเดือน</div>
              <div class="font-15px">การชำระค่าบริการรายเดือน และประวัติการชำระค่าบริการ</div>
            </div>
            <?php if ($get_invoice) { ?>
              <?php TiwForm::normal('btn', '', ['name' => '', 'class' => ''], ['type' => 'button', 'text' => 'แนบสลิป', 'modal_id' => 'add_upload_slip', 'modal_data' => []]); ?>
            <?php } ?>
          </div>
          <?php if (!$get_invoice) { ?>
            <div class="total-outstanding-balance" style="background-color: #E8F4E6;">
              <div class="text-success font-Bold font-24px">ไม่มียอดค้างจ่าย</div>
            </div>
          <?php } else { ?>
            <div class="total-outstanding-balance">
              <div class="font-14px font-SemiBold"> คุณมียอดค้างจ่ายประจำรอบเดือน : <span class=" font-Bold">มิถุนายน 2023</span></div>
              <div class="text-danger font-Bold font-24px"><?= number_format($get_invoice['total_invoice_price'], 2) ?> <span class="font-14px font-SemiBold">บาท</span></div>
            </div>
            <p class="text-center mt-20px font-15px">สแกน QR code ด้านล่างเพื่อชำระเงิน</p>
            <?php if ($result['qrstring']) { ?>
              <!-- <div class="max-w-300px mx-auto">
                <div class="img-1by1 holder">
                  <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?= urlencode($result['qrstring']) ?>&choe=UTF-8" alt="">
                </div>
              </div> -->
            <?php } else { ?>
              <!-- <p class="text-center font-18px">ไม่มี qrcode</p> -->
              <!-- <p class="text-center font-18px">
                ธนาคาร : ไทยพาณิชย์ <br>
                ชื่อบัญชี : นายศรายุทธ เดชแพง<br>
                เลขบัญชี : 4241507136 <br>
              </p> -->
            <?php } ?>
            <div class="max-w-300px mx-auto">
              <div class="img-1by1 holder">
                <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?= urlencode($result['qrstring']) ?>&choe=UTF-8" alt="">
              </div>
            </div>
            <div class=" max-w-500px mx-auto d-flex mb-15px">
              <?= file_get_contents('assets/icon/icon-danger.svg'); ?>
              <span class="ml-10px text-danger font-16px font-Medium">QR Code นี้ใช้สำหรับชำระค่าบริการรายเดือน เท่านั้น</span>
            </div>
            <div class=" max-w-500px mx-auto  d-flex mb-15px">
              <?= file_get_contents('assets/icon/icon-danger.svg'); ?>
              <span class="ml-10px text-danger font-16px font-Medium">QR Code นี้สามารถใช้สแกนโอนเงินได้เพียงครั้งเดียวเท่านั้น</span>
            </div>
            <div class="max-w-500px mx-auto d-flex mb-15px">
              <?= file_get_contents('assets/icon/icon-danger.svg'); ?>
              <span class="ml-10px text-danger font-16px font-Medium">กรุณาโอนเงินไปที่บัญชีที่ระบุไว้ข้างต้นพร้อมกับเลขทศนิยมที่ถูกต้อง</span>
            </div>
            <div class="font-Bold font-22px text-center">ยอดเงินที่ต้องโอน <span class="text-danger"> <?= number_format($get_invoice['total_invoice_price'], 2) ?> </span> บาท</div>
          <?php }  ?>
        </div>
        <?php if ($get_invoice) { ?>
          <div class="w-loves-card  border-radius-0 p-15px mb-15px">
            <div class="row">
              <div class="col-lg-6">
                <div class="row mb-15px">
                  <div class="col-lg-4">
                    <div class="font-16px text-secondary">ลูกค้า</div>
                  </div>
                  <div class="col-lg-8">
                    <div class="font-16px font-SemiBold"><?= $get_invoice['agent_name'] ?></div>
                  </div>
                </div>
                <div class="row mb-15px">
                  <div class="col-lg-4">
                    <div class="font-16px text-secondary">Website</div>
                  </div>
                  <div class="col-lg-8">
                    <div class="font-16px font-SemiBold">
                      <a href="<?= $get_invoice['my_url'] ?>"><?= $get_invoice['my_url'] ?></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="row mb-15px">
                  <div class="col-lg-6">
                    <div class="font-16px text-secondary">เลขที่ใบแจ้งหนี้</div>
                  </div>
                  <div class="col-lg-6">
                    <div class="font-16px font-SemiBold"><?= $get_invoice['invoice_no'] ?></div>
                  </div>
                </div>
                <div class="row mb-15px">
                  <div class="col-lg-6">
                    <div class="font-16px text-secondary">วันที่ออกใบแจ้งหนี้</div>
                  </div>
                  <div class="col-lg-6">
                    <div class="font-16px font-SemiBold">
                      <?= Aww::formatDate($get_invoice['invoice_date'], 'd/m/Y, H:i'); ?>
                    </div>
                  </div>
                </div>
                <div class="row mb-15px">
                  <div class="col-lg-6">
                    <div class="font-16px text-secondary">วันที่ครบกำหนด</div>
                  </div>
                  <div class="col-lg-6">
                    <div class="font-16px font-SemiBold">
                      <?php $date_paid = date('Y-m-5'); ?>
                      <?= Aww::formatDate($date_paid, 'd/m/Y, H:i'); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <table class="table table-custom">
              <thead>
                <tr>
                  <th class="bg-blue-2 text-primary">รายการ (Description)</th>
                  <th class="bg-blue-2 text-primary thin-cell">จำนวนเงิน (บาท)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class=" font-16px font-Medium">ค่าบริการ Website</td>
                  <td class=" font-16px font-Medium text-right"><?= number_format($get_invoice['website_service_charge'], 2)  ?></td>
                </tr>
                <tr>
                  <td class=" font-16px font-Medium">ค่าบริการ API</td>
                  <td class=" font-16px font-Medium text-right"><?= number_format($get_invoice['api_service_charge'], 2)  ?></td>
                </tr>
                <tr>
                  <td class=" font-16px font-Medium">ยอดรายได้เกิน <?= number_format(3000000) ?> คิดเป็น 1%</td>
                  <td class=" font-16px font-Medium text-right">
                    <?php
                    $cal_discount = $get_invoice['total_discount'] - $get_invoice['website_service_charge'];
                    ?>
                    <?= ($cal_discount <= 0) ? 0.00 :  number_format($cal_discount, 2)  ?>
                    <?php if ($get_invoice['total_discount']) { ?>
                      <p class="font-14px">
                        (<?= number_format($get_invoice['total_discount'], 2) ?> - ค่าบริการ Website)
                      </p>
                    <?php } ?>
                  </td>
                </tr>
                <tr>
                  <td class=" font-16px font-Medium">ค่าบริการสูตร</td>
                  <td class=" font-16px font-Medium text-right"><?= number_format($get_invoice['formula_service_charge'], 2)  ?></td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td class=" font-16px font-Medium text-primary text-right">รวมทั้งสิ้น (บาท)</td>
                  <td class=" font-16px font-Medium text-right"><?= number_format($get_invoice['total_invoice_price'], 2); ?></td>
                </tr>
              </tfoot>
            </table>
            <div class="row mb-15px">
              <div class="col-lg-4">
                <div class="font-16px text-secondary">ช่องทางการชำระเงิน</div>
              </div>
              <div class="col-lg-8">
                <div class="font-16px font-SemiBold">
                  ธนาคาร : ไทยพาณิชย์ <br>
                  ชื่อบัญชี : นายศรายุทธ เดชแพง<br>
                  เลขบัญชี : 4241507136 <br>
                  Promptpay : 0650681886<br>
                </div>
              </div>
            </div>
            <div class="row mb-15px">
              <div class="col-lg-4">
                <div class="font-16px text-secondary">หมายเหตุ</div>
              </div>
              <div class="col-lg-8">
                <div class="font-16px font-SemiBold text-danger">กรุณาชำระเงินภายในวันที่ 5 ของทุกเดือน เพื่อป้องกันระบบถูกปิดอัตโนมัติ</div>
              </div>
            </div>
          </div>
        <?php }  ?>
      </div>
      <div class="col-lg-6">
        <div class="w-loves-card border-radius-0 p-0">
          <div class="font-18px px-20px py-15px  font-Bold">ประวัติการชำระค่าบริการรายเดือน <span class="font-15px font-Medium"><?= count($select_bill) ?> รายการ</span></div>
          <table class="table table-custom">
            <thead>
              <tr>
                <th class="bg-blue-2 text-primary">รอบจ่าย</th>
                <th class="bg-blue-2 text-primary">ยอดที่ต้องจ่าย</th>
                <th class="bg-blue-2 text-primary">สถานะ</th>
                <th class="bg-blue-2 text-primary">วันที่ชำระ</th>
                <th class="bg-blue-2 text-primary thin-cell">สลิป</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($select_bill) { ?>
                <?php foreach ($select_bill as $key => $bill_list) { ?>
                  <tr>
                    <td class=" font-16px font-Medium">
                      <?php
                      $month = Aww::formatDate($bill_list['bill_date'], 'm');
                      ?>
                      <?= Aww::formatMonthNameTH($month) . ', ' . Aww::formatDate($bill_list['bill_date'], 'Y'); ?>
                    </td>
                    <td class=" font-16px font-Medium">
                      <?= number_format($bill_list['bill_price'], 2) ?>
                    </td>
                    <td>
                      <?php if ($bill_list['is_read'] == '0') { ?>
                        <div class="d-flex align-items-center ">
                          <?= file_get_contents('assets/icon/icon-circle-red.svg'); ?>
                          <span class="text-danger font-SemiBold font-16px ml-10px">ยังไม่ได้จ่าย</span>
                        </div>
                      <?php } else if ($bill_list['is_read'] == '1') { ?>
                        <div class="d-flex align-items-center ">
                          <?= file_get_contents('assets/icon/icon-circle-green.svg'); ?>
                          <span class="text-success font-SemiBold font-16px ml-10px">จ่ายแล้ว</span>
                        </div>
                      <?php } else if ($bill_list['is_read'] == '-1') { ?>
                        <div class="d-flex align-items-center ">
                          <?= file_get_contents('assets/icon/icon-circle-yellow.svg'); ?>
                          <span class="text-warning font-SemiBold font-16px ml-10px">กำลังดำเนินการ</span>
                        </div>
                      <?php } ?>
                    </td>
                    <td>
                      <?php
                      if ($bill_list['is_read'] != '1') {
                      ?>
                        <span class="text-secondary font-16px">ยังไม่ได้ชำระ</span>
                      <?php } else if ($bill_list['is_read'] == '1') { ?>
                        <span class="font-16px"><?= Aww::formatDate($bill_list['paid_date_time'], 'd/m/Y, H:i'); ?> </span>
                      <?php } else { ?>
                        <span class="font-16px d-none"><?= Aww::formatDate($bill_list['paid_date_time'], 'd/m/Y, H:i'); ?> </span>
                      <?php } ?>
                    </td>
                    <td>
                      <?php if ($bill_list['is_read'] == '1' || $bill_list['is_read'] == '-1') {
                      ?>
                        <a href="<?= $bill_list['slip']; ?>" target="_blank">
                          <div class="monthly-slip-img">
                            <img src="<?= $bill_list['slip']; ?>" class="">
                          </div>
                        </a>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              <?php } else { ?>
                <tr>
                  <td colspan="4" class="text-center">ไม่มีข้อมูล</td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php Tiwdal::startModal('add_upload_slip', 'modal-md'); ?>
  <form method="post" class="form-loading" enctype="multipart/form-data">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">×</span>
    </button>
    <div class="modal-header">
      <h5 class="modal-title text-uppercase">แนบสลิป</h5>
    </div>
    <div class="modal-body">
      <div class="form-group mt-10px">
        <div class="form-row align-items-center">
          <div class="col-lg-3">
            <div class="font-14px font-Medium mb-10px py-5px">
              สลิป
            </div>
          </div>
          <div class="col-lg-9">
            <div class="ml-5px font-16px font-Medium">
              <?= TiwForm::normal('file', '', ['name' => 'slip']) ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer justify-content-end">
      <?= TiwForm::normal('hidden', $get_invoice['id'], ['name' => 'id']) ?>
      <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ยกเลิก</button>
      <?= TiwForm::normal('btn', '', ['name' => 'upload-file', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'Upload']); ?>
    </div>
  </form>
  <?php Tiwdal::endModal() ?>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

</body>

</html>

<script>
  $(document).ready(function() {
    $(document).on('click', '.icon_up_filter', function() {
      $('.filter_event').hide();
      $('.icon_up_filter').hide();
      $('.icon_down_filter').show();
      $('.date_filter').show();
    });

    $(document).on('click', '.icon_down_filter', function() {
      $('.filter_event').show();
      $('.icon_down_filter').hide();
      $('.icon_up_filter').show();
      $('.date_filter').hide();
    });

  });
</script>