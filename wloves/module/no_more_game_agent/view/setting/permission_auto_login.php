<?php

$table_ally_options = [
  [
    'value' => 'เปิดการใช้งาน',
    'name' => 'เปิดการใช้งาน',
  ],
  [
    'value' => 'ปิดการใช้งาน',
    'name' => 'ปิดการใช้งาน',
  ],
];

function messageTemplate($class = '')
{
?>
  <div class="<?= $class ?> mt--10px mb-10px hidden">
    <div class="d-flex align-items-center">
      <?= file_get_contents('assets/image/icon/exclmation_mark.svg') ?>
      <span class="font-13px text-danger ml-5px"></span>
    </div>
  </div>
<?php
}
?>
<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">ตั้งค่าสิทธิ์ลิงก์เข้าสู่ระบบอัตโนมัติ
    </div>
    <div class="font-15px text-secondary">จัดการสิทธิ์เข้าสู่ระบบอัตโนมัติ</div>
  </div>
</div>

<div class="editable-card core-new border-radius-0 mb-50px">

  <div id="auto_login_permission" class="container-pagination no-border-radius table-square" <?= Homepagify::createHomepagify('auto_login_permission', '?c=' . $_GET['c'], '', 'รายชื่อ Admin',) ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th nowrap data-sort="full_name" data-filter="<?= Homepagify::dataFilter('full_name', 'text') ?>">ชื่อ</th>
            <th nowrap data-sort="username" data-filter="<?= Homepagify::dataFilter('username', 'text') ?>">Username</th>
            <th nowrap class="thin-cell">สิทธิ์เข้าถึง</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $(document).on('keyup change', '.event_check_password', function(e) {
      var password = $(this).val();
      let count = password.length;
      console.log(count);
      if (count > 7) {
        $('.btn_add_user_event').attr('disabled', false);
        $('.event_text_font').removeClass('text-danger');
        $('.event_text_font').addClass('text-success');
      } else {
        $('.btn_add_user_event').attr('disabled', true);
        $('.event_text_font').removeClass('text-success');
        $('.event_text_font').addClass('text-danger');
      }
    });
  });
</script>