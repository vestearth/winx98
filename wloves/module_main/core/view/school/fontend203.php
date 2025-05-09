<div class="content-header-container">
  <h3 class="header-title">การเขียน Modal แบบปกติ<p class="font-14px mt-5px">ถ้าต้องการ Custom Modal เองให้นำโค๊ดจากตรงนี้ไป (กรณีที่ Modal มีความซับซ้อนเป็นพิเศษ)</p>
  </h3>
</div>
<div class="content-body-container">
  <div class="row">
    <div class="col-12">
      <div class="code-container mt-10px">
          <pre><code data-language="php">Question 1 : ทำไมใช้ tiwdal ในไฟล์ Ajax, Ajax Table ไม่ได้ ?
ตอบ : ต้อง include ไฟล์ tiwform เข้าไปในไฟล์ Ajax ด้วย
Structure::loadMetaForAjax('../../');</code></pre>
      </div>
    </div>
    <div class="col-12">
      <label>ตัวอย่างปุ่มเปิด Modal</label>
      <div class="mb-10px">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#general_modal">
          General Modal
        </button>
      </div>
      <div class="code-container">
        <pre><code data-language="php"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#general_modal">
  General Modal
</button></code></pre>
      </div>
    </div>
  </div>
</div>

<div class="content-body-container">
  <div class="row">
    <div class="col-12">
      <label>ตัวอย่าง Modal</label>
      <div class="code-container">
        <pre><code data-language="php"><div class="modal fade" id="general_modal" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ex. General Modal</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Content
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div></code></pre>
      </div>
    </div>
  </div>
</div>

<div class="modal render-modal fade" id="general_modal" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ex. General Modal</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Content
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save</button>
      </div>
    </div>
  </div>
</div>