<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
require_once '../../.framework/import.php';
require_once __DIR__ . '/assets/plugin/mpdf/vendor/autoload.php';

$get_invoice =  nga_agent::getMyInvoiceMonthly($_GET['c']);
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$setting_page = [
  'margin_left' => 5,
  'margin_right' => 5,
  'margin_top' => 10,
  'margin_bottom' => 10,
  'default_font' => 'garuda',
];

function DateThai($strDate)
{
  $strYear = date("Y", strtotime($strDate)) + 543;
  $strMonth = date("n", strtotime($strDate));
  $strDay = date("j", strtotime($strDate));
  $strHour = date("H", strtotime($strDate));
  $strMinute = date("i", strtotime($strDate));
  $strSeconds = date("s", strtotime($strDate));
  $strMonthCut = array("", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม");
  $strMonthThai = $strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
}

function pdf_create()
{
  global $get_invoice;
  ob_start();
?>

  <style>
    @import url("assets/plugin/mpdf/vendor/mpdf/mpdf/data/lang2fonts.css");

    .invoice-body-pdf {
      width: 100%;
      height: 100%;
    }

    .title-box {
      width: 100%;
      text-align: center;
    }

    .title-box .title {
      font-size: 25px;
      font-weight: bold;
      color: #2f678e;
    }

    .table-header {
      width: 100%;
      font-size: 16px;
    }

    .table-header tr td {
      padding: 5px;
    }

    .table-header tr td:nth-child(2) {
      width: 50%;
    }

    .table-header tr td:nth-child(1),
    .table-header tr td:nth-child(3) {
      color: #676A6F;
    }

    .table-body {
      margin-top: 15px;
      width: 100%;
      border: 1px solid #DBDCDF;
      font-size: 15px;
      border-spacing: 0px;
    }

    .table-body tr td:nth-child(2) {
      width: 75%;
    }

    .table-body tr td {
      padding: 5px;
      border: 0.5px solid #DBDCDF;
    }

    .table-body thead tr td {
      background-color: #e6e6e6;
      color: #2f678e;
      font-weight: bold;
    }

    .table-body thead tr td:nth-child(3) {
      text-align: right;
    }

    .table-body tbody tr td:nth-child(3) {
      text-align: right;
      background-color: #eff5fd;
    }

    .table-body tfoot tr td {
      text-align: right;
      color: #3E88FB;
      font-size: 16px;
      font-weight: Bold;
    }

    .table-body tr td:nth-child(1) {
      width: 40px;
      text-align: center;
    }

    .table-body tfoot td:nth-child(1) {
      border-right: 0px;
    }

    .table-body tfoot td:nth-child(2) {
      border-left: 0px;
    }

    .table-body tfoot td:nth-child(3) {
      background-color: #dae7fb;
    }

    .table-footer {
      width: 100%;
      font-size: 16px;
      margin-top: 15px;
    }

    .table-footer tr td {
      padding-bottom: 10px;
    }

    .table-footer tr td:nth-child(1) {
      width: 20%;
      vertical-align: top;
    }

    .table-footer tr:nth-child(1) td:nth-child(2) {
      height: 500px;
      border: 1px solid red;
    }

    .text-danger {
      color: #ED4234;
    }

    .font-14px {
      font-size: 14px;
    }
  </style>

  <div class="invoice-body-pdf">
    <div class="title-box">
      <p class="title">ใบแจ้งหนี้ (INVOICE)</p>
    </div>
    <table class="table-header">
      <tr>
        <td>ลูกค้า</td>
        <td><?= $get_invoice['agent_name'] ?></td>
        <td>เลขที่ใบแจ้งหนี้</td>
        <td><?= $get_invoice['invoice_no'] ?></td>
      </tr>
      <tr>
        <td>Website</td>
        <td><?= $get_invoice['my_url'] ?></td>
        <td>วันที่ออกใบแจ้งหนี้</td>
        <td><?= DateThai(date('y-m-1')); ?></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>วันที่ครบกำหนด</td>
        <td><?= DateThai(date('y-m-5')); ?></td>
      </tr>
    </table>
    <table class="table-body">
      <thead>
        <tr>
          <td></td>
          <td>รายการ (Description)</td>
          <td width="30%">จำนวนเงิน (บาท)</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>ค่าบริการ Website</td>
          <td><?= number_format($get_invoice['website_service_charge'], 2) ?></td>
        </tr>
        <tr>
          <td>2</td>
          <td>ค่าบริการ API</td>
          <td><?= number_format($get_invoice['api_service_charge'], 2) ?></td>
        </tr>
        <tr>
          <td>3</td>
          <td>ยอดรายได้เกิน <?= number_format(3000000) ?> คิดเป็น 1%</td>
          <td>
            <?php
            $cal_discount = $get_invoice['total_discount'] - $get_invoice['website_service_charge'];
            ?>
            <?= ($cal_discount <= 0) ? 0.00 :  number_format($cal_discount, 2)  ?>
            <p class="font-14px">
              <?php if ($get_invoice['total_discount']) { ?>
                (<?= number_format($get_invoice['total_discount'], 2) ?> - ค่าบริการ Website)
              <?php } ?>
            </p>
          </td>
        </tr>
        <tr>
          <td>4</td>
          <td>ค่าบริการสูตร</td>
          <td><?= number_format($get_invoice['formula_service_charge'], 2) ?></td>
        </tr>
      </tbody>
      <tfoot>
        <tr>
          <td></td>
          <td>รวมทั้งสิ้น (บาท)</td>
          <td><?= number_format($get_invoice['total_invoice_price'], 2) ?></td>
        </tr>
      </tfoot>
    </table>
    <table class="table-footer">
      <tbody>
        <tr>
          <td>ช่องทางการชำระเงิน</td>
          <td>
            <div class="">
              <p style="line-height: 50px;">ธนาคารกสิกรไทย เลขที่บัญชี 137-8-64064-0 </p>
              <div style="font-size:5px;">&nbsp;</div>
              <p>ชื่อบัญชี นาง กชกร เปรมธนวัฒน์</p>
              <div style="font-size:5px;">&nbsp;</div>
              <p>โอนเงินแล้วกรุณาแจ้งสลิป ที่ Line @nomoregame</p>
            </div>
          </td>
        </tr>
        <tr>
          <td>หมายเหตุ</td>
          <td class="text-danger">กรุณาชำระเงินภายในวันที่ 5 ของทุกเดือน เพื่อป้องกันระบบถูกปิดอัตโนมัติ</td>
        </tr>
      </tbody>
    </table>

  </div>
<?php
  return ob_get_clean();
}

function pdf_nodata()
{
  ob_start();
?>
  <div class="no-data-body">
    <h1 style="text-align: center;">NO DATA</h1>
  </div>
<?php
  return ob_get_clean();
}

$mpdf = new \Mpdf\Mpdf($setting_page);

if ($get_invoice) {
  $html = pdf_create();
} else {
  $html = pdf_nodata();
}
$mpdf->WriteHTML($html);
$mpdf->Output();
