<?php
if ($_POST) {
  if (isset($_POST['submit_detail_sbo'])) {
    unset($_POST['submit_detail_sbo']);
    $result =  nga_api_seamless_sbobet::getQueryReplay($code, $_POST['id_sbo']);
    if ($result['message'] == 'Success') {
      $data = [
        'admin_id' => $current_user,
        'user_id' => $id,
        'action' => 'edit_user',
        'detail' => 'ดูข้อมูล SBOBET (หน้าข้อมูลลูกค้า)'
      ];
      $admin_log = nga_user::addNewAdminActionLog($code, $data);
    }
    echo '<script>window.open("' . $result['data']['url'] . '", "_blank");</script>';
  } else {
    if (isset($result)) {
      $response_message = isset($response_message) ? $response_message : $result['response_message'];
      $response_status = $result['response_status'] ? 'success' : 'error';
      $response_redirect = isset($response_redirect) ? $response_redirect : '';

      Aww::notification($response_message, $response_status);
      Aww::redirect($response_redirect);
    }
  }
}
?>
<div class='bg-white mb-1px pb-10px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">

    <div class="msg col-lg-6">
      <div class='topic ml-10px'>
        ประวัติการเดิมพันกีฬา </div>
      <div class="font-14px text-sub ml-10px">
        ข้อมูลรายละเอียดประวัติการเดิมพันกีฬา
      </div>
    </div>
  </div>
</div>
<div class="bg-white">
  <div id="sport_played" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('sport_played', '?c=' . $code . '&user_id=' . $customer_data['id'], '', '') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วันที่เล่นเกม</th>
            <th nowrap>เวลาที่เล่นเกม</th>
            <th nowrap>เกม</th>
            <th nowrap>เลขบิล</th>
            <th nowrap>ยอดเล่น</th>
            <th nowrap class="thin-cell">ได้/เสีย</th>
            <th nowrap class="thin-cell">สถานะ</th>
            <th nowrap class="thin-cell"></th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>