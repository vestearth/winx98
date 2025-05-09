<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'customer'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];
$bank_alias_data = json_decode($_POST['bank_number_alias'], true);

?>

<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        แก้ไขบัญชีอื่น
        <p class="mb-10px text-secondary font-14px">กรณีต้องการที่จะลบบัญชีธนาคาร (4 ตัวท้าย) ให้ระบุ 0 ในช่องที่ต้องการจะลบ</p>
      </h5>
    </div>
    <div class="modal-body mt-15px">
      <div class="form-row">
        <?php foreach ($bank_alias_data as $four_letter_bank) { ?>
          <div class="col-lg-4 my-auto pb-10px">
            เลขที่บัญชีธนาคาร (4 ตัวท้าย)
          </div>
          <div class="col-lg-8 pb-10px">
            <div class="form-row">
              <div class="col">
                <?php TiwForm::normal('text', $four_letter_bank, ['name' => 'alias_bank_account[]', 'class' => '', 'placeholder' => '']); ?>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="user_id" value="<?= $_POST['id']; ?>">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-close-modal min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_edit_alias', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>