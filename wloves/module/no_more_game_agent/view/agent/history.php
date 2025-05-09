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

$status_list = [
  [
    'value' => 'completed',
    'text' => 'ชำระเงินแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ยกเลิก'
  ],
  [
    'value' => 'waiting',
    'text' => 'รอชำระเงิน'
  ],
];

$content = isset($_GET['content']) ? $_GET['content'] : 0;
$status = isset($_GET['status']) ? $_GET['status'] : 0;
?>
<?php if ($content == 0) { ?>
  <div class='bg-white pb-10px border-bottom'>
    <div class="d-flex top-tap justify-content-between  pt-10px">
      <div class="msg col-lg-6">
        <div class='topic'>
          ประวัติการเงิน </div>
        <div class="font-14px text-sub ">
          รายการสรุปข้อมูลประวัติการเงินเอเยนต์
        </div>
      </div>
      <div class="date-range px-15px">
        <form method="get" id="form_event_date_range">
          <?= TiwForm::normal('daterange', $date_input, ['name' => 'date', 'placeholder' => 'วว/ดด/ปปปป - วว/ดด/ปปปป', 'class' => 'event_date_range'], []); ?>
          <input type="hidden" name="c" value="<?= $code; ?>">
          <input type="hidden" name="id" value="<?= $_GET['id']; ?>">
          <input type="hidden" name="page" value="<?= $_GET['page']; ?>">
        </form>
      </div>
    </div>
  </div>
  <div id="agent_history" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('agent_history', '?c=' . $code . '&agent_id=' . $_GET['id'] . '&from_date=' . $from_date_replace_2 . '&to_date=' . $to_date_replace_2, '', 'ประวัติการเงิน') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-striped-2">
        <thead>
          <tr>
            <th nowrap data-sort="status" data-filter="<?= Homepagify::dataFilter('status', 'select', $status_list) ?>">สถานะ</th>
            <th nowrap data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วันและเวลาที่เคลียร์ยอด</th>
            <th nowrap class="text-center" data-sort="sum_income">ยอดได้</th>
            <th nowrap class="text-center" data-sort="sum_loss">ยอดเสีย</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
<?php } else { ?>
  <div class='bg-white mb-15px pb-10px'>
    <div class="d-flex top-tap justify-content-between pt-10px">
      <div class="msg col-lg-6">
        <div class='topic'>
          รายละเอียดประวัติการเงิน | <span class="text-primary font-Medium ">19/02/2565 - 20/02/2565 </span></div>
        <div class="font-14px text-sub">
          ประวัติรายการการเงินเอเยนต์
        </div>
      </div>
      <div class="button-panel col-lg-6 d-flex justify-content-end">
        <?php if ($status == 1) {  //? 1==success 
        ?>
          <div class="d-flex my-auto px-15px text-waiting">
            <a class="mr-15px ml-5px svg-success text-success"><?= file_get_contents('./assets/icon/icon-status.svg') ?> <span class="pl-5px mt-10px">บิลนี้ชำระเงินเรียบร้อยแล้ว</span></a>
          </div>
          <button class="btn btn-close-modal mx-5px w-140px" disabled> <span class="pr-10px svg-light"><?= file_get_contents('./assets/icon/icon-x.svg') ?></span>ยกเลิกบิล</button>
          <button class="btn btn-close-modal mx-5px w-140px" disabled> <span class="pr-10px svg-light"><?= file_get_contents('./assets/icon/icon-checks.svg') ?></span> ชำระเงินแล้ว</button>
      </div>
    <?php } elseif ($status == '2') { //? 2==cancel
    ?>
      <div class="d-flex my-auto px-15px text-waiting">
        <a class="mr-15px ml-5px svg-danger text-danger"><?= file_get_contents('./assets/icon/icon-status.svg') ?> <span class="pl-5px mt-10px">บิลนี้ถูกยิกเลิกแล้ว</span></a>
      </div>
      <a class="btn btn-close-modal mx-5px w-140px text-blue-4" href="history_detail.php?c=<?= $code ?>"> <span class="pr-10px"><?= file_get_contents('./assets/icon/icon-restore.svg') ?></span>RESTORE</a>
    </div>
  <?php } else { ?>
    <div class="d-flex my-auto px-15px text-waiting">
      <a class="mr-15px ml-5px"><?= file_get_contents('./assets/icon/icon-status.svg') ?></a>
      <span>รอชำระเงิน</span>
    </div>
    <a class="btn btn-danger mx-5px w-140px" href="history_detail.php?c=<?= $code ?>&status=2"> <span class="pr-10px"><?= file_get_contents('./assets/icon/icon-x.svg') ?></span>ยกเลิกบิล</a>
    <a class="btn btn-success mx-5px w-140px" href="history_detail.php?c=<?= $code ?>&status=1"> <span class="pr-10px"><?= file_get_contents('./assets/icon/icon-checks.svg') ?></span> ชำระเงินแล้ว</a>
  </div>
<?php }  ?>
</div>
</div>
<div id="agent_history_detail" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('agent_history_detail', '?c=' . $code, '', 'รายการการเงิน ') ?>>
  <div class="table-responsive">
    <table class="table table-striped-2">
      <thead>
        <tr>
          <th class="" nowrap>รหัสลูกค้า</th>
          <th class="text-center" nowrap>Turnover</th>
          <th class="text-center" nowrap>Valid turnover</th>
          <th class="text-center " nowrap>Stake count</th>
          <th class=" text-center" nowrap>Gorss commission</th>
          <th class="text-center " nowrap>Win lose</th>
          <th class="text-center" nowrap>Win lose commission</th>
          <th class="text-center " nowrap>Total win lose</th>
          <th nowrap>Games</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<?php } ?>

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