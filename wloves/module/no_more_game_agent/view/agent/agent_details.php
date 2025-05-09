<?php
$agent_history = nga_agent::selectAgentLogHistory($code, ['agent_id' => $id]);
?>
<div class="bg-whites form-row px-15px py-15px">
  <div class="col-lg-8">
    <div class="mb-10px">
      <div class="card-header-primary py-10px  font-SemiBold font-14px">
        ข้อมูลเบื้องต้น
      </div>
      <div class="card-white px-15px py-10px font-Medium">
        <div class="form-row">
          <div class="col-3">
            <div class="agent-user-img">
              <img src="<?= $agent_detail['agent_image'] ?>">
            </div>
          </div>
          <div class="col-9">
            <?= phase_2('ชื่อเอเยนต์', 4, $agent_detail['agent_name'], '', '', 'pb-10px') ?>
            <?= phase_2('รหัสเอเยนต์', 4, $agent_detail['agent_code'], '', '', 'pb-10px') ?>
            <?= phase_2('เปอร์เซ็นต์ระบบ', 4, $agent_detail['percent_commission'] . '%', '', '', 'pb-10px') ?>
            <?= phase_2('URL', 4, $agent_detail['agent_url'], '', '', 'pb-10px') ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="mb-10px">
      <div class="card-header-primary py-10px  font-SemiBold font-14px">
        ข้อมูลติดต่อเอเยนต์
      </div>
      <div class="card-white px-15px py-10px font-Medium">
        <?= phase_2('ชื่อ - นามสกุล', 4, $agent_detail['full_name'], '', '', 'pb-10px') ?>
        <?= phase_2('หมายเลขโทรศัพท์', 4, $agent_detail['tel'], '', '', 'pb-10px') ?>
        <?= phase_2('Line ID', 4, $agent_detail['line_id'], '', '', 'pb-10px') ?>
        <?= phase_2('บัญชีธนาคาร', 4, '<div class="d-flex">
              <div class = "my-auto bank-img medium-size">
                <img src="' . $agent_detail['bank_image'] . '">
              </div>
              <div class="px-10px">
                <div class="my-0 py-0 w-100">' . $agent_detail['bank_name_th'] . '</div>
                <div class="my-0 py-0 w-100">' . $agent_detail['bank_number'] . '</div>
              </div>
            </div>', '', '', 'pb-10px') ?>
      </div>
    </div>
  </div>
</div>

<div class="bg-whites px-15px py-15px">
  <div class="card-header-primary py-10px font-SemiBold font-14px">
    Log history
  </div>
  <div class="card-white pb-10px font-Medium">
    <table class="table p-100 table-in-card table-striped-1">
      <thead class="table-strip">
        <tr class="font-14px text-sub">
          <th class="col-2">วันที่และเวลา</th>
          <th class="col-8">รายละเอียด</th>
          <th class="col-2 text-right">ผู้ทำรายการ</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($agent_history as $log_history) { ?>
          <tr>
            <td><?= Aww::formatDate($log_history['insert_date_time'], 'd/m/Y, H:i'); ?></td>
            <td><?= $log_history['detail']; ?></td>
            <td class="text-right"><?= $log_history['action_by']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>