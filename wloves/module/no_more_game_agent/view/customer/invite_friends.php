<?php

$friend_id = isset($_GET['friend_id']) ? $_GET['friend_id'] : '';
$upline_id = isset($_GET['upline_id']) ? $_GET['upline_id'] : '';

function phase_2($msg1, $num_range, $msg2, $class1 = '', $class2 = '', $class = '')
{
  $num = (12 - $num_range);
  echo  '<div class="form-row px-15px py-5px font-14px ' . $class . '">
  <div class="col-lg-' . $num_range . ' font-Medium text-grey ' . $class1 . '">
  ' . $msg1 . '
  </div>
  <div class="col-lg-' . $num . ' ' . $class2 . ' ">
  ' . $msg2 . '
  </div>
  </div>';
}
?>

<div class='bg-white mb-1px pb-10px mb-1px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">
    <div class="msg col-lg-6">
      <div class='topic'>
        ชวนเพื่อน </div>
      <div class="font-14px text-sub">
        จัดการข้อมูลรายละเอียดเพื่อน
      </div>
    </div>
    <div class="button-panel col-lg-6 ">
      <div class="form-row">
        <div class="col-lg-6 ">
        </div>
      </div>
    </div>
  </div>
</div>

<div class='form-row'>
  <div class="col-lg-5 border-right pb-10px table-mx-0 px-0 bg-whites ">
    <div id="invite_friends" class="container-pagination mx-15px no-border-radius no-header" <?= Homepagify::createHomepagify('invite_friends', '?c=' . $code . '&user_id=' . $customer_data['id'] . '&friend_id=' . $friend_id, '', 'ลูกค้า') ?>>
      <div class="table-responsive">
        <table class="table table-sort table-search">
          <thead>
            <tr>
              <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">ยูสเซอร์ (agent)</th>
              <th nowrap data-sort="">ยอดรับรวม</th>
              <th class="text-center" nowrap data-sort="">สถานะ</th>
              <th nowrap></th>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <?php
  if ($friend_id) {
    $friend_data = nga_user::getUserDownlinePlayGame($code, $friend_id, $upline_id);
  ?>
    <div class=" col-lg-7 ">
      <div class="d-flex top-tap justify-content-between pt-10px bg-white ml--5px py-10px">
        <div class="msg col-lg-7">
          <div class='topic '>
            เพื่อน <span class="text-blue">| <?= $friend_data['username'] ?></span> </div>
          <div class="font-14px text-sub">
            ข้อมูลรายละเอียดการเล่นเกมและยอดเงินในการเล่นเกม
          </div>
        </div>
        <?php /* 
        <div class="button-panel col-lg-5 ">
          <div class="d-flex justify-content-end ">
            <button type="button" class="btn btn-hovers dropdown-toggle dot-svg rotate-90 fill-none " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= file_get_contents('./assets/icon/icon-3dot.svg'); ?>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <button type="button" class="btn dropdown-item text-align-center " <?= Tiwdal::register('delete_modal'); ?>>
                <span><img src="./assets/icon/icon-delete.svg" alt=""></span>
                <span class="ml-5px text-danger">Delete Leave Type</span>
              </button>
            </div>
          </div>
        </div>
        */ ?>
      </div>
      <div class="bg-white ml--5px table-border-top">
        <div class="font-italic font-14px font-Bold pl-15px">ข้อมูลทั่วไป</div>
        <?= phase_2('ยูสเซอร์ (agent)', 3, $friend_data['username'] . ', ' .  $friend_data['bank_name'], '', '', 'pl-15px') ?>
        <?= phase_2('ยอดรับรวม', 3, $friend_data['sum_receive'], '', 'text-blue', 'pl-15px') ?>
        <?= phase_2('กดรับแล้วทั้งหมด', 3, '<span class="text-green">' . number_format($friend_data['sum_receive_complete'], 2) . '</span> (เครดิต)', '', 'text-grey', 'pl-15px') ?>
        <?= phase_2('ยอดคงค้างทั้งหมด', 3, number_format($friend_data['sum_outstanding_receive'], 2), '', 'text-orange', 'pl-15px') ?>
        <?
        $status_check = '';
        if ($friend_data['status'] == 'waiting') {
          $status_check = 'รอรับ';
          $status_check_color = 'text-orange';
        } else if ($friend_data['status'] == 'completed') {
          $status_check = 'รับแล้ว';
          $status_check_color = 'text-green';
        } else if ($friend_data['status'] == 'cancel') {
          $status_check = 'ยกเลิก';
          $status_check_color =  'text-red';
        }
        echo phase_2('สถานะรับเงิน', 3, $status_check, '', $status_check_color, 'pl-15px');
        echo phase_2('ฝากครั้งแรก', 3, number_format($friend_data['first_time_deposit'], 2), '',  '');
        ?>

      </div>

      <div class="bg-white ml--5px">
        <div class="pl-15px pb-10px font-Bold font-italic font-14px">รายการยอดเล่น</div>
        <div class="table-responsive">
          <table class="table p-100 table-style-1 table-border-side mb-0">
            <thead class="table-head-grey">
              <tr>
                <th class="col-4">วัน</th>
                <th class="text-right col-2">ยอดเล่น</th>
                <th class="text-right col-2">เงินคืนทั้งหมด</th>
                <th class="text-right col-2">ยอดเงินกดรับแล้ว</th>
                <th class="text-right col-2">ยอดเงินคงค้าง</th>
              </tr>
            </thead>
            <?php
            if ($friend_data) {
              $total_money_upline_received = 0;
              $total_sum_money_upline = 0;
              $total_money_upline_outstanding = 0;
            ?>
              <tbody>
                <?php
                foreach ($friend_data['list'] as $played_list) {
                  $total_sum_money_upline += $played_list['sum_money_upline'];
                  $total_money_upline_received += $played_list['money_upline_received'];
                  $total_money_upline_outstanding += $played_list['money_upline_outstanding'];
                ?>
                  <tr>
                    <td><?= Aww::formatDate($played_list['transaction_date'], 'd/m/Y'); ?></td>
                    <td class="text-right"><?= number_format($played_list['sum_money_diff']); ?></td>
                    <td class="text-right"><?= number_format($played_list['sum_money_upline'], 2); ?></td>
                    <td class="text-right"><?= number_format($played_list['money_upline_received'], 2); ?></td>
                    <td class="text-right"><?= number_format($played_list['money_upline_outstanding'], 2); ?></td>
                  </tr>
                <?php } ?>
                <tr class="border-none">
                  <td></td>
                  <td class="text-right bg-fade-blue">ยอดรับรวม</td>
                  <td class="text-right font-14px text-blue bg-fade-blue"><?= number_format($total_sum_money_upline, 2); ?></td>
                  <td class="text-green text-right font-16px text-green bg-fade-blue"><?= number_format($total_money_upline_received, 2); ?></td>
                  <td class="text-right font-14px text-red bg-fade-blue"><?= number_format($total_money_upline_outstanding, 2); ?></td>
                </tr>
              </tbody>
            <?php } ?>
          </table>
        </div>
      </div>


    </div>
  <?php } ?>
</div>