<div class='bg-white mb-1px pb-10px'>
  <div class="d-flex top-tap justify-content-between  pt-10px">

    <div class="msg col-lg-6">
      <div class='topic ml-10px'>
        ประวัติการเล่นเกม </div>
      <div class="font-14px text-sub ml-10px">
        ข้อมูลรายละเอียดประวัติการเล่นเกม
      </div>
    </div>
  </div>
</div>
<div class="bg-white">
  <div id="game_played" class="container-pagination bg-white no-border-radius" <?= Homepagify::createHomepagify('game_played', '?c=' . $code . '&user_id=' . $customer_data['id'], '', '') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search ">
        <thead>
          <tr>
            <th nowrap data-sort="transaction_date_time" data-filter="<?= Homepagify::dataFilter('transaction_date', 'date') ?>">วันที่เล่นเกม</th>
            <th nowrap>เวลาที่เล่นเกม</th>
            <th nowrap data-sort="game_name" data-filter="<?= Homepagify::dataFilter('game_name', 'text') ?>">เกม</th>
            <th nowrap>ได้/เสีย</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>