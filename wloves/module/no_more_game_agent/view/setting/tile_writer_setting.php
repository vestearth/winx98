<?php
$link = '?c=' . $_GET['c'] . '&page=' .  $_GET['page'] . '&is_info=1';
$is_edit = isset($_GET['is_edit']) ? $_GET['is_edit'] : 0;
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$required_symbol = ($is_edit) ? '<span class="text-danger">*</span>' : '';

$runner_text = nga_management::getRunnerText($code);
if ($_POST) {
  if (isset($_POST['submit_update_data'])) {
    $field1 = $_POST['field1'];
    $field1 = substr($field1, 0, -3) . 'XXX';

    // $_POST['full_text'] = '🎊🎉SUPER JACKPOT!! ยินดีกับไอดี ' . $field1 . ' ได้รับ jackpot 💰 ' . $_POST['field2'] . ' บาท';
    // $data = [
    //   'field1' => $field1,
    //   'field2' => $_POST['field2'],
    //   'full_text' => $_POST['full_text'],
    //   'from_date_time' => $_POST['from_date_time'],
    //   'to_date_time' => $_POST['to_date_time'],
    //   'is_active' => isset($_POST['is_active']) ? 1 : 0,
    // ];
    $data = [
      // 'field1' => $field1,
      // 'field2' => $_POST['field2'],
      'full_text' => $_POST['full_text'],
      'from_date_time' => $_POST['from_date_time'],
      'to_date_time' => $_POST['to_date_time'],
      'is_active' => isset($_POST['is_active']) ? 1 : 0,
    ];
    $result = nga_management::updateRunnerText($code, $data);
    $response_redirect = 'system_database.php?c=' . $code . '&page=' .  $_GET['page'];
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};
?>
<div class="form-row m-0">
  <div class="col-12 p-0 mb--10px ">
    <div class="col-12 p-0">
      <!-- style="min-height: calc(100vh - 120px);" -->
      <div class="editable-card border-radius-0 mb-10px">
        <form method="post" enctype='multipart/form-data'>
          <div class="d-flex justify-content-between align-items-center px-15px py-10px flex-wrap">
            <div class="">
              <p class="font-weight-bold mb-0">ตั้งค่าประกาศวิ่ง</p>
              <p class="mb-0">จัดการข้อความสำหรับประกาศวิ่งบนเว็บไซต์เพื่อแสดงในหน้าแรก</p>
            </div>
            <div class="d-flex align-items-center">
              <?php if ($is_edit) { ?>
                <a href="system_database.php?c=<?= $_GET['c'] ?>&page=<?= $_GET['page']; ?>" class="btn btn-close-modal mr-5px w-80px ">
                  ยกเลิก
                </a>
                <?php TiwForm::normal('btn', '', ['name' => 'submit_update_data', 'class' => 'btn w-120px'], ['type' => 'submit', 'text' => 'บันทึก']); ?>
              <?php } else { ?>
                <a href="system_database.php?c=<?= $_GET['c'] ?>&page=<?= $_GET['page']; ?>&is_edit=1">
                  <button type="button" class="btn btn-outline-info w-120px mr-10px">แก้ไขข้อมูล</button>
                </a>
              <?php } ?>
            </div>
          </div>

          <hr class="my-0">
          <div class="px-20px py-10px">

            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">แสดงประกาศวิ่ง</label>
                </div>
                <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                  <?php if ($is_edit) {
                    TiwForm::normal('checkbox', 1, ['name' => 'is_active', 'class' => 'mt-5px', $runner_text['is_active'] ? 'checked' : '' => true], ['style' => '1', 'is_on_off' => true]);
                  ?>
                  <?php } else { ?>
                    <label class="font-16px font-Medium pt-7px text-primary">
                      <?= $runner_text['is_active'] == 1 ? 'เปิด' : 'ปิด'; ?>
                    </label>
                  <?php } ?>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="form-row">
                <div class="col-lg-3">
                  <label class="font-15px font-SemiBold text-secondary pt-7px">ข้อความ <?= $required_symbol; ?></label>
                </div>
                <div class="col-lg font-16px font-Medium d-flex align-items-center">
                  <?php if ($is_edit) { ?>
                    <div class="form-row align-items-center w-100">
                      <?php
                      TiwForm::normal('text', $runner_text['full_text'], ['name' => 'field1', 'placeholder' => 'กรอก', 'required' => 'true', 'maxlength' => "10"]);
                      ?>
                    <?php } else { ?>
                      <label class="font-15px pt-7px">
                        <?= $runner_text['full_text']; ?>
                      </label>
                    <?php } ?>

                    <?php /* 
                      <div class="col-4">
                        🎊🎉SUPER JACKPOT!! ยินดีกับไอดี
                      </div>
                      <div class="col-2">
                        <?php
                        TiwForm::normal('text', $runner_text['field1'], ['name' => 'field1', 'placeholder' => 'กรอก', 'required' => 'true', 'maxlength' => "10"]);
                        ?>
                      </div>
                      <div class="col-2">ได้รับ jackpot 💰 </div>
                      <div class="col-3">
                        <?php
                        TiwForm::normal('number', $runner_text['field2'], ['name' => 'field2', 'placeholder' => 'กรอก', 'required' => 'true']);
                        ?>
                      </div>
                      <div class="col-1"> บาท</div>
                    </div>
                  <?php } else { ?>
                    <label class="font-15px pt-7px">
                      🎊🎉SUPER JACKPOT!! ยินดีกับไอดี <span class="text-primary"><?= $runner_text['field1'] ?></span> ได้รับ jackpot 💰 <span class="text-primary"><?= number_format($runner_text['field2'], 2) ?></span> บาท
                    </label>
                  <?php } ?>
                  */ ?>
                    </div>
                </div>
              </div>

              <div class="form-group">
                <div class="form-row">
                  <div class="col-lg-3">
                    <label class="font-15px font-SemiBold text-secondary pt-7px">ช่วงเวลาแสดงข้อความ <?= $required_symbol; ?></label>
                  </div>
                  <div class="col-lg-5 font-16px font-Medium d-flex align-items-center">
                    <?php if ($is_edit) {
                      TiwForm::normal('datetime', Aww::formatDate($runner_text['from_date_time'], 'Y-m-d H:i'), ['name' => 'from_date_time'], []);
                      echo
                      '<span class="mx-20px py-5px">
                    ถึง
                    </span>';
                      TiwForm::normal('datetime', Aww::formatDate($runner_text['to_date_time'], 'Y-m-d H:i'), ['name' => 'to_date_time'], []);
                    ?>
                    <?php } else { ?>
                      <label class="font-16px font-Medium pt-7px">
                        <?= Aww::formatDate($runner_text['from_date_time'], 'd/m/Y, H:i') . ' - ' . Aww::formatDate($runner_text['to_date_time'], 'd/m/Y, H:i') ?>
                      </label>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
        </form>
      </div>
      <div class="editable-card core-new border-radius-0 mb-50px pos-rel">
        <?php if ($is_edit) { ?>
          <div class="filter-block-table"></div>
        <?php } ?>
        <div id="tile_writing" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('tile_writing', '?c=' . $_GET['c'], '', 'ประวัติการแก้ไขประกาศวิ่ง',) ?>>
          <div class="table-responsive">
            <table class="table table-sort table-search">
              <thead>
                <tr>
                  <th nowrap data-sort="insert_date_time" data-filter="<?= Homepagify::dataFilter('insert_date', 'date') ?>">วัน/เวลาที่แก้ไข</th>
                  <th nowrap data-sort="full_text" data-filter="<?= Homepagify::dataFilter('full_text', 'text') ?>">คำอธิบาย</th>
                  <th class="thin-cell" data-sort="admin_username" data-filter="<?= Homepagify::dataFilter('admin_username', 'text') ?>">โดย</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>