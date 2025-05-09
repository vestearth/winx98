<?php
$get_data = '';
if (isset($_GET['date'])) {
  $get_date = $_GET['date'];
  $seperate_date = explode(' - ', $get_date);
  $from_date = isset($seperate_date[0]) ? $seperate_date[0] : Util::getSystemDate('-' . 7 . ' days');
  $to_date = isset($seperate_date[1]) ? $seperate_date[1] : Aww::formatDate('', 'Y-m-d');
  $from_date_replace = str_replace('/', '-', $from_date);
  $to_date_replace = str_replace('/', '-', $to_date);
  $from_date_replace_2 = Aww::formatDate($from_date_replace, 'Y-m-d');
  $to_date_replace_2 = Aww::formatDate($to_date_replace, 'Y-m-d');
} else {
  $from_date_replace_2 = Util::getSystemDate('-' . 7 . ' days');
  $to_date_replace_2 = Aww::formatDate('', 'Y-m-d');
  $from_date = Aww::formatDate(Util::getSystemDate('-' . 7 . ' days'), 'd/m/Y');
  $to_date = Aww::formatDate('', 'd/m/Y');
}
$date_input = $from_date_replace_2 . ' to ' . $to_date_replace_2;
?>
<div class='bg-white pb-10px border-bottom'>
  <div class="d-flex top-tap justify-content-between  pt-10px">
    <div class="msg col-lg-6">
      <div class='topic'>
        สรุปยอด แพ้/ชนะ เอเยนต์ </div>
      <div class="font-14px text-sub ">
        ข้อมูลรายละเอียดสรุปยอด แพ้/ชนะ เอเยนต์
      </div>
    </div>
    <div class="date-range px-15px">
      <form method="get" id="form_event_date_range">
        <?= TiwForm::normal('daterange', $date_input, ['name' => 'date', 'class' => 'event_date_range'], []); ?>
        <input type="hidden" name="c" value="<?= $code; ?>">
        <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
        <input type="hidden" name="page" value="<?= $_GET['page']; ?>">
      </form>
    </div>
  </div>
</div>

<div class="bg-whites mt-15px pt-10px">
  <div class="form-row px-15px ">
    <div class="col-lg-3 ">
      <div class="mb-10px">
        <div class="card-header-success py-10px  font-SemiBold font-14px">
          ยอดชนะทั้งหมด
        </div>
        <div class="card-white px-15px py-10px font-Medium">

          <div class=" font-14px">
            <span class="font-20px font-Bold text-success"><?= number_format($agent_detail['total_win'], 2); ?></span>
            บาท
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="mb-10px">
        <div class="card-header-danger py-10px font-SemiBold font-14px">
          ยอดแพ้ทั้งหมด
        </div>
        <div class="card-white px-15px py-10px font-Medium">
          <div class=" font-14px">
            <?php
            $total_loss = $agent_detail['total_lose'] * -1;
            ?>
            <span class="font-20px font-Bold text-danger"><?= number_format($total_loss, 2); ?> </span>บาท
          </div>

        </div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="mb-10px">
        <div class="card-header-primary  font-SemiBold font-14px">
          รายได้เข้าระบบ
        </div>
        <div class="card-white px-15px py-10px font-Medium">
          <div class=" font-14px d-flex justify-content-between">
            <div>
              <?php if ($agent_detail['total_income'] > 0) {
                $income_style = 'text-success';
              } else {
                $income_style = 'text-danger';
              } ?>
              <span class="font-20px font-Bold <?= $income_style; ?>"><?= number_format($agent_detail['total_income'], 2); ?> </span>บาท
            </div>
            <!-- <div class="text-vertical-center my-auto">
              (10%)
            </div> -->
          </div>

        </div>
      </div>
    </div>

    <?php /* 
    <div class="col-lg-3">
      <div class="mb-10px">
        <div class="card-header-primary  font-SemiBold font-14px">
          ยอดเสียระบบ
        </div>
        <div class="card-white px-15px py-10px font-Medium">
          <div class=" font-14px d-flex justify-content-between">
            <div>
              <span class="font-20px font-Bold text-primary"><?= number_format(0, 2); ?> </span>บาท
            </div>
            <!-- <div class="text-vertical-center my-auto">
              (10%)
            </div> -->
          </div>

        </div>
      </div>
    </div>
    */ ?>

  </div>
</div>

<div class='bg-white py-10px border-bottom border-top'>
  <div class="d-flex top-tap justify-content-between ">
    <div class="msg col-lg-6">
      <div class='topic'>
        รายการแพ้/ชนะ เอเยนต์ | <span class="text-primary"> <?= $from_date; ?> - <?= $to_date; ?></span> </div>
      <div class="font-14px text-sub ">
        ข้อมูลรายละเอียดสรุปยอด แพ้/ชนะ เอเยนต์
      </div>
    </div>
    <div class="px-15px my-auto">
      <?php
      $clear_bill_modal = [
        'from_date' => $from_date,
        'to_date' => $to_date,
        'form_date_data' => $from_date_replace_2,
        'to_date_data' => $to_date_replace_2,
      ]
      ?>
      <button class="btn btn-success" <?= Tiwdal::register('clear_modal', $clear_bill_modal) ?>>CLEAR BILLING</button>
    </div>
  </div>
</div>

<div id="agent_result_loss_start" class="container-pagination bg-white  no-border-radius hide-detail-table" <?= Homepagify::createHomepagify('agent_result_loss_start', '?c=' . $code . '&from_date=' . $from_date_replace_2 . '&to_date=' . $to_date_replace_2 . '&agent_id=' . $id, '', 'รายการแพ้/ชนะ เอเยนต์ ') ?>>
  <div class="table-responsive">
    <table class="table table-striped-2">
      <thead>
        <tr>
          <th class="" nowrap>เอเยนต์</th>
          <th class="text-center" nowrap>Turnover</th>
          <th class="text-center" nowrap>Valid turnover</th>
          <th class="text-center" nowrap>Stake count</th>
          <th class="text-center" nowrap>Gorss commission</th>
          <th class="text-center" nowrap>Lose</th>
          <th class="text-center" nowrap>Lose commission</th>
          <th class="text-center" nowrap>Total lose</th>
          <th nowrap>Games</th>
        </tr>
      </thead>
    </table>
  </div>
</div>

<?php Tiwdal::startModal('clear_modal', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title text-center">CLEAR BILLING</h5>
    </div>
    <div class="modal-body">
      <div class="text-center">
        คุณต้องการ <span class="text-success">"เคลียร์ยอด <span name="{from_date}">01/02/2565</span> - <span name="{to_date}"></span>”</span> ใช่หรือไม่

      </div>
      <div class="text-center">
        ข้อมูลการเงินในวันดังกล่าวจะถูกเคลียร์และโอนย้ายไปยัง "ประวัติการเงิน"
      </div>

    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="{form_date_data}">
    <input type="hidden" name="{to_date_data}">
    <button type="button" class="btn btn-close-modal min-w-80px h-40px" data-dismiss="modal">ยกเลิก</button>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_clear_bill', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-success h-40px',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<script>
  $(document).ready(function() {
    $(document).on('change', '.event_date_range', function() {
      var date_range = $('.event_date_range').val();
      var date_range_arr = date_range.split(' - ');
      var date_start = date_range_arr[0];
      var date_end = date_range_arr[1];
      if (date_start != '' && date_end != undefined) {
        $('#form_event_date_range').submit();
      }
    });

  });
</script>