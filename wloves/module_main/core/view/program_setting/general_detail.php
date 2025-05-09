<?php
if ($_POST) {
  if (isset($_POST['submit_info_program'])) {
    unset($_POST['submit_info_program']);
    $result = WLoves::setProgramSetup($_POST);
    if ($result['response_status']) {
      Aww::redirect('program_setting.php?c=&setting=general');
    }
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}
?>
<div class="col-lg-10 box-nav-top">
  <form method="post">
    <input type="hidden" name="submit_info_program">
    <div class="editable-card core-new p-15px" style="min-height: unset;">
      <div class="row">
        <div class="col-12 px-0">
          <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="title-detail px-15px">
              <h3 class="text-uppercase font-SemiBold font-16px text-info mb-0">Program general detail</h3>
              <p class="font-14px font-Regular mb-0">Enter your program detail. and setting base data</p>
            </div>
            <div class="px-15px">
              <?php
              if ($status == 'edit') {
                echo '<div class="d-flex">';
                echo '<a href="program_setting.php?c=&setting=general" class="btn btn-light h-35px mr-5px">CANCEL</a>';
                TiwForm::normal('btn', '', ['type' => 'submit'], ['text' => Itlanguage::translate('SAVE')]);
                echo '</div>';
              } else {
                echo '<a href="program_setting.php?c=&setting=general&status=edit">' . TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-outline-info border'], ['text' => 'EDIT DATA', 'type' => '', 'is_return' => true]) . '</a>';
              }
              ?>
            </div>
          </div>
          <hr class="">
        </div>
        <div class="col-12 font-14px pb-20px font-SemiBold text-info">
          GENERAL INFORMATION
        </div>
      </div>
      <?php
      if ($status == 'edit') {
      ?>
        <div class="form-row form-group ">
          <div class="col-sm-2 mb-0">
            <label class=" text-secondary font-14px"> Program Name </label>
          </div>
          <div class="col-sm-10 font-18px font-Medium">
            <?php TiwForm::normal('text', $program['program_name'], ['name' => 'program_name', 'placeholder' => 'Enter']); ?>
          </div>
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2 mb-0">
            <label class=" text-secondary font-14px"> Description </label>
          </div>
          <div class="col-sm-10 font-16px font-Medium">
            <?php TiwForm::normal('textarea', $program['description'], ['name' => 'description', 'placeholder' => 'Enter']); ?>
          </div>
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2 mb-0">
            <label class=" text-secondary font-14px"> Program Owner </label>
          </div>
          <div class="col-sm-10 font-16px font-Medium">
            <?php TiwForm::normal('text', $program['customer'], ['name' => 'customer', 'placeholder' => 'Enter']); ?>
          </div>
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2">
            <label class=" text-secondary font-14px"> Program Start Date </label>
          </div>
          <div class="col-sm-4 font-16px font-Medium">
            <?php TiwForm::normal('date', $program['start_date'], ['name' => 'start_date', 'placeholder' => 'Enter']); ?>
          </div>
          <div class="col-sm-2">
            <label class=" text-secondary font-14px"> Program Time Out </label>
          </div>
          <div class="col-sm-4 font-16px font-Medium">
            <?php TiwForm::normal('time', $program['end_time'], ['name' => 'end_time', 'placeholder' => 'Enter']); ?>
          </div>
        </div>
        <div class=" font-14px pb-20px pt-10px font-SemiBold text-info">
          PROGRAM BASIC SETTING
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2">
            <label class=" text-secondary font-14px"> Default Currency </label>
          </div>
          <div class="col-sm-4 font-16px font-Medium">
            <?php
            $options = [
              'is_search' => true, //หากต้องการใช้ select แบบค้นหาได้ให้ใส่มา
              'list' => [
                [
                  'value' => '',
                  'name' => 'please select',
                  'disabled' => true
                ],
                [
                  'value' => 'thb',
                  'name' => 'Thai Baht'
                ],
                [
                  'value' => 'dhk',
                  'name' => 'Dollar hk'
                ],
              ]
            ];
            TiwForm::normal('select', $program['default_currency'], ['name' => 'default_currency'], $options);
            ?>
          </div>
        </div>
        <div class=" font-14px pb-20px pt-10px font-SemiBold text-info">
          SERVICE CONTACT
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2 mb-0">
            <label class=" text-secondary font-14px"> Support Email </label>
          </div>
          <div class="col-sm-4 font-16px font-Medium">
            <?php TiwForm::normal('email', $program['support_email'], ['name' => 'support_email', 'placeholder' => 'Enter']); ?>
          </div>
        </div>
      <?php
      } else {
      ?>
        <div class="form-row form-group">
          <div class="col-sm-2 mb-0">
            <label class=" text-secondary font-14px"> Program Name </label>
          </div>
          <div class="col-sm-10 font-18px font-Medium text-primary">
            <span class="text_progress"><?= $program['program_name'] ?></span>
          </div>
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2 mb-0">
            <label class=" text-secondary font-14px"> Description </label>
          </div>
          <div class="col-sm-10 font-16px font-Medium">
            <span class="text_progress"><?= $program['description'] ?></span>
          </div>
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2 mb-0">
            <label class=" text-secondary font-14px"> Program Owner </label>
          </div>
          <div class="col-sm-10 font-16px font-Medium">
            <span class="text_progress"><?= $program['customer'] ?></span>
          </div>
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2">
            <label class=" text-secondary font-14px"> Program Start Date </label>
          </div>
          <div class="col-sm-4 font-16px font-Medium">
            <span class="text_progress"><?= Aww::formatDate($program['start_date'], 'd/m/Y'); ?></span>
          </div>
          <div class="col-sm-2">
            <label class=" text-secondary font-14px"> Program Time Out </label>
          </div>
          <div class="col-sm-4 font-16px font-Medium">
            <span class="text_progress"><?= Aww::formatDate($program['end_time'], 'H:i'); ?></span>
          </div>
        </div>
        <div class=" font-14px pb-20px pt-10px font-SemiBold text-info">
          PROGRAM BASIC SETTING
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2">
            <label class=" text-secondary font-14px"> Default Currency </label>
          </div>
          <div class="col-sm-4 font-16px font-Medium">
            <span class="text_progress"><?= ($program['default_currency'] == 'thb') ? 'Thai Baht' : 'Dollar hk' ?></span>
          </div>
        </div>
        <div class=" font-14px pb-20px pt-10px font-SemiBold text-info">
          SERVICE CONTACT
        </div>
        <div class="form-row form-group">
          <div class="col-sm-2">
            <label class=" text-secondary font-14px">Service Emil</label>
          </div>
          <div class="col-sm-4 font-16px font-Medium">
            <span class="text_progress"><?= $program['support_email'] ?></span>
          </div>
        </div>
      <?php } ?>
    </div>
  </form>
</div>