<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'opinion'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];
?>
<form method="post" enctype="multipart/form-data">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header border-bottom">
      <h5 class="modal-title font-16px font-SemiBold">ความคิดเห็นของลูกค้า</h5>
    </div>
    <div class="modal-body bg-white p-0">
      <div class="row m-0">
        <div class="col-lg-6 border-right">
          <div class="row mb-14px mt-25px">
            <div class="col-4 font-Medium font-14px text-secondary">วัน/เวลา</div>
            <div class="col-8"> <?= Aww::formatDate($_POST['insert_date_time'], 'd/m/Y, H:i'); ?></div>
          </div>
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary">ชื่อลูกค้า</div>
            <div class="col-8"><?= $_POST['bank_name'] ?></div>
          </div>
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary">รหัสลูกค้า</div>
            <div class="col-8"><?= $_POST['username'] ?></div>
          </div>
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary">Line Id</div>
            <div class="col-8"><?= $_POST['line_id'] ?></div>
          </div>
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary">กลุ่มลูกค้า</div>
            <div class="col-8"><?= $_POST['user_group_name'] ?></div>
          </div>
          <hr class="mx--15px">
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary">หมวดหมู่</div>
            <div class="col-8"><?= $_POST['group_name'] ?></div>
          </div>
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary">หัวข้อ</div>
            <div class="col-8"><?= $_POST['title_name'] ?></div>
          </div>
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary">ความพึงพอใจ</div>
            <div class="col-8">
              <div class="d-flex justify-content-start align-items-center">
                <?php if ($_POST['rating'] == 1) { ?>
                  <?= file_get_contents("./../assets/icon/icon-dot-red.svg"); ?>
                  <span class="ml-5px">แย่มาก</span>
                <?php } else if ($_POST['rating'] == 2) { ?>
                  <?= file_get_contents("./../assets/icon/icon-dot-yellow.svg");  ?>
                  <span class="ml-5px">แย่</span>
                <?php } else if ($_POST['rating'] == 3) { ?>
                  <?= file_get_contents("./../assets/icon/icon-dot-orange.svg"); ?>
                  <span class="ml-5px">พอใช้</span>
                <?php } else if ($_POST['rating'] == 4) { ?>
                  <?= file_get_contents("./../assets/icon/icon-dot-green.svg"); ?>
                  <span class="ml-5px">ดี</span>
                <?php } else if ($_POST['rating'] == 5) { ?>
                  <?= file_get_contents("./../assets/icon/icon-dot-blue.svg"); ?>
                  <span class="ml-5px">ดีมาก</span>
                <?php } else { ?>
                  -
                <?php  } ?>
              </div>
            </div>
          </div>
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary">รายละเอียด</div>
            <div class="col-8">
              <?= $_POST['detail'] ?>
            </div>
          </div>
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary">ไฟล์แนบ</div>
            <div class="col-8">
              <?php
              $options = [
                'width' => '120px',
                'height' => '100%',
                'bg-img' => 'assets/image/placeholder_square.jpg',
                'is_btn' => 1, //ไม่เอาปุ่มทั้งหมด
                'is_view' => 1, //ไม่เอาปุ่ม view
                'is_delete' => 0, //ไม่เอาปุ่ม ลบ
                'is_upload' => 0,
              ];
              TiwForm::normal('upload-img', $_POST['comment_file'], ['name' => 'text', 'readonly' => 'true', 'disable' => 'true'], $options);
              ?>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="row mb-14px mt-25px">
            <div class="col-4 font-Medium font-14px text-secondary">การดำเนินการ</div>
            <div class="col-8">
              <?php
              $is_edit = false;
              if ($_POST['status'] != 'completed') {
                $is_edit = true;
                $options = [
                  'list' => [
                    [
                      'value' => 'pending',
                      'name' => 'กำลังดำเนินการ',
                    ],
                    [
                      'value' => 'completed',
                      'name' => 'เสร็จสิ้น',
                    ],
                  ],
                ];
                TiwForm::normal('select', '', ['name' => 'status', 'class' => "border rounded mb-0"], $options);
              } else {
                echo '<span class="text-success">เสร็จสิ้น</span>';
              }
              ?>
            </div>
          </div>
          <div class="row mb-14px">
            <div class="col-4 font-Medium font-14px text-secondary <?= !$is_edit ? 'my-auto' : '' ?>">หมายเหตุ (ถ้ามี)</div>
            <div class="col-8">
              <?php TiwForm::normal('textarea', $_POST['remark'], ['name' => 'remark', 'class' => "border rounded mb-0 min-h-70px"], ['is_edit' => $is_edit]); ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="id" value="<?= $_POST['id'] ?>">
    <?php if ($_POST['status'] != 'completed') { ?>
      <?= TiwForm::normal('btn', '', ['name' => 'submit_opinion', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
    <?php } else { ?>
      <button class="btn btn-close-modal min-w-80px" data-dismiss="modal">ปิด</button>
    <?php } ?>
  </div>
</form>