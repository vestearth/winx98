<div class="content-header-container mt-3 d-flex align-items-center justify-content-between">
  <h3 class="header-title text-info">เขียน CSS แบบ WOLVES</h3>
  <a href="school.php?topic=800&sub=803" class="btn btn-light">test form</a>
</div>
<div class="content-body-container">
  <div class="row">
    <h5 class="col-12 text-danger">!! อ่านก่อนนำไปใช้งาน : การเชียน CSS รูปแบบ WOLVES </h5>
    <h6 class="col-12 text-warning">!! ถ้ามีการ custom ต่างๆของ css </h6>
    <div class="col-12">
      <h6>ตัวอย่าง</h6>
      <div class="code-container mb-3">
        <pre>
          <code data-language="css">
/* แบบที่ใช้ตอนนี้*/
{
  background-color: var(--color-bg);
  color: var(--color-bg);
}
/* แบบที่ไม่ใช้แล้ว จะไม่มีการใช้โค้ดสี (ตัวอย่าง : #FFFFFF) */
{
  background-color:#FFFFFF;
  color: #FFFFFF;
}
          </code>
        </pre>
      </div>
    </div>
    <h6 class="col-12 text-warning">!! ถ้าจะตัดแบบพวกปุ่ม หรือเปลี่ยนสี background ให้ใส่เป็น class แทน</h6>
    <div class="col-12">
      <h6>ตัวอย่าง</h6>
      <div class="code-container mb-3">
        <pre><code data-language="php"><div class="bg-primary text-warning"></div></code></pre>
      </div>
    </div>
  </div>
</div>
<div class="content-header-container mt-3">
  <h3 class="header-title text-info">Class Theme</h3>
</div>
<div class="content-body-container">
  <p class="font-weight-bold text-info"> ปุ่มต่างๆ </p>
  <div class="row">
    <div class="col-12 mb-3 d-flex flex-wrap align-items-center">
      <button type="button" class="copyColor mr-10px btn btn-primary">.btn-primary</button>
      <button type="button" class="copyColor mr-10px btn btn-secondary">.btn-secondary</button>
      <button type="button" class="copyColor mr-10px btn btn-success">.btn-success</button>
      <button type="button" class="copyColor mr-10px btn btn-danger">.btn-danger</button>
      <button type="button" class="copyColor mr-10px btn btn-warning">.btn-warning</button>
      <button type="button" class="copyColor mr-10px btn btn-info">.btn-info</button>
      <button type="button" class="copyColor mr-10px btn btn-light">.btn-light</button>
      <button type="button" class="copyColor mr-10px btn btn-dark">.btn-dark</button>
    </div>
    <div class="col-12 mb-3 d-flex flex-wrap align-items-center">
      <button type="button" class="copyColor mb-10px mr-10px btn btn-outline-primary">.btn-outline-primary</button>
      <button type="button" class="copyColor mb-10px mr-10px btn btn-outline-secondary">.btn-outline-secondary</button>
      <button type="button" class="copyColor mb-10px mr-10px btn btn-outline-success">.btn-outline-success</button>
      <button type="button" class="copyColor mb-10px mr-10px btn btn-outline-danger">.btn-outline-danger</button>
      <button type="button" class="copyColor mb-10px mr-10px btn btn-outline-warning">.btn-outline-warning</button>
      <button type="button" class="copyColor mb-10px mr-10px btn btn-outline-info">.btn-outline-info</button>
      <button type="button" class="copyColor mb-10px mr-10px btn btn-outline-light">.btn-outline-light</button>
      <button type="button" class="copyColor mb-10px mr-10px btn btn-outline-dark">.btn-outline-dark</button>
    </div>
  </div>
  <p class="font-weight-bold text-info"> สีต่างๆ </p>
  <div class="row">
    <div class="col-12 mb-3 ">
      <div class="p-3 mb-2 bg-primary text-dark">.bg-primary</div>
      <div class="p-3 mb-2 bg-secondary text-dark">.bg-secondary</div>
      <div class="p-3 mb-2 bg-success text-dark">.bg-success</div>
      <div class="p-3 mb-2 bg-danger text-dark">.bg-danger</div>
      <div class="p-3 mb-2 bg-warning text-dark">.bg-warning</div>
      <div class="p-3 mb-2 bg-info text-light">.bg-info</div>
      <div class="p-3 mb-2 bg-light text-dark">.bg-light</div>
      <div class="p-3 mb-2 bg-dark text-light">.bg-dark</div>
      <div class="p-3 mb-2 bg-white">.bg-white</div>
    </div>
  </div>
  <p class="font-weight-bold text-info"> สีตัวหนังสือต่างๆ </p>
  <div class="row">
    <div class="col-12 mb-3 ">
      <p class="text-primary">.text-primary</p>
      <p class="text-success">.text-success</p>
      <p class="text-danger">.text-danger</p>
      <p class="text-warning">.text-warning</p>
      <p class="text-info">.text-info <span class="text-danger ml-30px"> ( ใช้บ่อยส่วน title )</span></p>
      <p class="text-secondary">.text-secondary <span class="text-danger ml-30px"> ( ใช้บ่อยส่วน detail )</span></p>
      <p class="text-light bg-dark">.text-light</p>
      <p class="text-dark">.text-dark</p>
      <p class="text-muted">.text-muted</p>
      <p class="text-white bg-light">.text-white</p>
    </div>
  </div>
</div>
<div class="content-header-container">
  <h3 class="header-title text-info">CSS Theme</h3>
</div>
<div class="content-body-container">
  <p class="font-weight-bold text-info"> สีที่ใช้ใน Theme </p>
  <div class="row">
    <div class="col-6">
      <p class="font-weight-bold text-info"> DARK THEME </p>
    </div>
    <div class="col-6">
      <p class="font-weight-bold text-info"> WHITE THEME </p>
    </div>
    <div class="col-6 bg-black p-2 font-SemiBold">
      <div class="p-3 mb-2 theme-bg-color">var(--bg-color)</div>
      <div class="p-3 mb-2 theme-bg-card">var(--bg-card)</div>
      <div class="p-3 mb-2 theme-bg-card-optional-1">var(--bg-card-optional-1)</div>
      <div class="p-3 mb-2 theme-bg-card-optional-2">var(--bg-card-optional-2)</div>
      <div class="p-3 mb-2 theme-bg-card-navbar">var(--bg-card-navbar)</div>
      <div class="p-3 mb-2 theme-bg-card-back">var(--bg-card-back)</div>
      <div class="p-3 mb-2 theme-bg-table">var(--bg-table)</div>
      <div class="p-3 mb-2 theme-bg-table-hover">var(--bg-table-hover)</div>
      <div class="p-3 mb-2 theme-color-line">var(--color-line)</div>
      <div class="p-3 mb-2 theme-color-field">var(--color-field)</div>
      <div class="p-3 mb-2 theme-color-field-active">var(--color-field-active)</div>
      <div class="p-3 mb-2 theme-color-info">var(--color-info)</div>
      <div class="p-3 mb-2 theme-color-secondary">var(--color-secondary)</div>
      <div class="p-3 mb-2 theme-color-place-holder">var(--color-place-holder)</div>
      <div class="p-3 mb-2 theme-color-primary">var(--color-primary)</div>
      <div class="p-3 mb-2 theme-color-success">var(--color-success)</div>
      <div class="p-3 mb-2 theme-color-warning">var(--color-warning)</div>
      <div class="p-3 mb-2 theme-color-danger">var(--color-danger)</div>
      <div class="p-3 mb-2 theme-color-light">var(--color-light)</div>
      <div class="p-3 mb-2 theme-color-dark text-black-50">var(--color-dark)</div>
    </div>
    <div class="col-6 bg-white p-2 font-SemiBold">
      <div class="p-3 mb-2 theme-bg-color">var(--bg-color)</div>
      <div class="p-3 mb-2 theme-bg-card">var(--bg-card)</div>
      <div class="p-3 mb-2 theme-bg-card-optional-1">var(--bg-card-optional-1)</div>
      <div class="p-3 mb-2 theme-bg-card-optional-2">var(--bg-card-optional-2)</div>
      <div class="p-3 mb-2 theme-bg-card-navbar">var(--bg-card-navbar)</div>
      <div class="p-3 mb-2 theme-bg-card-back">var(--bg-card-back)</div>
      <div class="p-3 mb-2 theme-bg-table">var(--bg-table)</div>
      <div class="p-3 mb-2 theme-bg-table-hover">var(--bg-table-hover)</div>
      <div class="p-3 mb-2 theme-color-line">var(--color-line)</div>
      <div class="p-3 mb-2 theme-color-field">var(--color-field)</div>
      <div class="p-3 mb-2 theme-color-field-active">var(--color-field-active)</div>
      <div class="p-3 mb-2 theme-color-info">var(--color-info)</div>
      <div class="p-3 mb-2 theme-color-secondary">var(--color-secondary)</div>
      <div class="p-3 mb-2 theme-color-place-holder">var(--color-place-holder)</div>
      <div class="p-3 mb-2 theme-color-primary">var(--color-primary)</div>
      <div class="p-3 mb-2 theme-color-success">var(--color-success)</div>
      <div class="p-3 mb-2 theme-color-warning">var(--color-warning)</div>
      <div class="p-3 mb-2 theme-color-danger">var(--color-danger)</div>
      <div class="p-3 mb-2 theme-color-light">var(--color-light)</div>
      <div class="p-3 mb-2 theme-color-dark text-white">var(--color-dark)</div>
    </div>
  </div>
</div>
</div>
<script src="../../../../structure/js/color_data.js"></script>
<script>
  $(document).ready(function() {

    $('.copyColor').on('click', function() {
      var copyText = $(this).attr('class');
      copyText = copyText.replace("copyColor mr-10px ", " ")
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val(copyText).select();
      document.execCommand("copy");
      $temp.remove();
      Aww.notification("success", 'Copy ' + copyText);
    });
  });
</script>