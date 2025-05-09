<?php

if ($_POST) {
  if (isset($_POST['submit_sidebar_mode'])) {
    unset($_POST['submit_sidebar_mode']);
    $result = WLoves::setProgramSetup($_POST); //single, multiple
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}
$program_info = WLoves::getProgramSetup();

?>
<div class="col-lg-9 col-xl-10">
  <div class="form-row">
    <div class="col-xl-6 mb-10px h-100">
      <div class="editable-card p-10px h-100 <?= ($program_info['module_sidebar_mode'] == 'single') ? 'select-module-mode' : '' ?>">
        <div class="font-18px text-info font-SemiBold text-center mb-5px">Single</div>
        <div class="font-14px text-secondary text-center mb-15px">นำหัวข้อหน้าภายในแต่ละโมดูล ออกมาแสดงเป็นเมนูแทนที่ชื่อโมดูลเดิม รูปแบบนี้เหมาะสำหรับระบบที่มีโมดูลน้อย แต่หน้าเยอะและ ต้องการให้มันดูเต็ม</div>
        <div class="d-flex justify-content-center mb-20px">
          <form method="POST">
            <?php
            $is_disabled = ($program_info['module_sidebar_mode'] == 'single') ? 'disabled' : '';
            TiwForm::normal('hidden', 'single', ['name' => 'module_sidebar_mode']);
            TiwForm::normal('btn', '', ['name' => 'submit_sidebar_mode', 'type' => 'submit', 'class' => 'btn_submit_sidebar', $is_disabled => true], ['text' => 'SELECT']);
            ?>
          </form>
        </div>
        <img src="../../structure/image/select_sigle_mode.png" class="w-100">
      </div>
    </div>
    <div class="col-xl-6 mb-10px h-100">
      <div class="editable-card p-10px h-100 <?= ($program_info['module_sidebar_mode'] == 'multiple') ? 'select-module-mode' : '' ?>">
        <div class="font-18px text-info font-SemiBold text-center mb-5px">Grouping</div>
        <div class="font-14px text-secondary text-center mb-15px">แสดงเมนูรายโมดูล ภายในประกอบด้วยหัวข้อและหน้าของแต่ละโมดูล รูปแบบนี้เหมาะกับระบบที่มีหลายโมดูล และไม่ต้องการให้เมนูรกหรือ เยอะเกินไป</div>
        <div class="d-flex justify-content-center mb-20px">
          <form method="POST">
            <?php
            $is_disabled = ($program_info['module_sidebar_mode'] == 'multiple') ? 'disabled' : '';
            TiwForm::normal('hidden', 'multiple', ['name' => 'module_sidebar_mode']);
            TiwForm::normal('btn', '', ['name' => 'submit_sidebar_mode', 'type' => 'submit', 'class' => 'btn_submit_sidebar', $is_disabled => true], ['text' => 'SELECT']);
            ?>
          </form>
        </div>
        <img src="../../structure/image/select_grouping_mode.png" class="w-100">
      </div>
    </div>
  </div>
</div>