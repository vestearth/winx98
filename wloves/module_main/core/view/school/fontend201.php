<div class="content-header-container">
  <h3 class="header-title">การเขียน Edit Modal<p class="font-14px mt-5px">ใช้กรณีที่ต้องการให้ตัวแปรที่ส่งไป แทนค่าใน Tag Html ให้ โดยอัตโนมัติ</p>
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
      <h6>อธิบายเพิ่มเติม</h6>
      <div>
        <p>Tag ที่สามารถถูกแทนค่าอัตโนมัติ ได้แก่<br>input , select option, img, checkbox, textarea, span<br>โดยการใน name ใน Tag นั้น ๆ ให้ตรงกับตัวแปรที่ส่งค่าเข้าไป</p>
      </div>
      <label>ตัวอย่าง</label>
      <div class="mb-10px">
        <?php
          $edit_data = [
            'id'   => 1,
            'name' => 'Edit Modal',
          ];
        ?>
        <button class="btn btn-primary" <?php Tiwdal::register('edit_modal', $edit_data);?>>Click for open edit modal.</button>
      </div>
      <div class="code-container">
        <pre><code data-language="php">&lt;?php
  //เรียกใช้ Module tiwdal ไว้ที่หัวของหน้านั้น ๆ
  Structure::loadModules(['tiwdal']);

  // Param 1 = ไอดีของ Modal
  $data = [
    'id'   => 1,
    'name' => 'Edit Modal'
  ]; //ข้อมูลที่ต้องการส่งไปที modal เพื่อใช้ auto form (ไม่มีไม่ต้องส่งไป)
?&gt;

&lt;button class="btn btn-primary" &lt;?php Tiwdal::register('modal_name', $data);?&gt;>
  Click for open edit modal.
&lt;/button&gt;</code></pre>
      </div>
    </div>
  </div>
</div>

<div class="content-body-container">
  <div class="row">
    <div class="col-12">
      <label>ตัวอย่าง Modal</label>
      <p>
        $id = id ของ Modal<br>
        $size = ขนาด Modal (ใส่หรือไม่ใส่ก็ได้) / sm, md, lg, xl<br>
        $options = เงื่อนไขอื่น ๆ ที่ต้องการวาดที่หัว modal (ใส่หรือไม่ใส่ก็ได้) เช่น ['class' => 'test1 test2', 'data-id' => '1']<br>
      </p>
      <div class="code-container">
        <pre><code data-language="php">&lt;?php Tiwdal::startModal($id, $size, $options);?&gt;
  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
  <div class="modal-header">
    <h5 class="modal-title">Ex. Edit Modal</h5>
  </div>
  <div class="modal-body">
    <label>ID :</label>
    <input type="text" class="form-control" name="{id}">
    <label>Name :</label>
    <input type="text" class="form-control" name="{name}">
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary">Confirm</button>
  </div>
&lt;?php Tiwdal::endModal()?&gt;</code></pre>
      </div>
    </div>
  </div>
</div>

<?php Tiwdal::startModal('edit_modal');?>
  <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
    <span aria-hidden='true'>&times;</span>
  </button>
  <div class="modal-header">
    <h5 class="modal-title">Ex. Edit Modal</h5>
  </div>
  <div class="modal-body">
    <label>ID :</label>
    <input type="text" class="form-control" name="{id}">
    <label>Name :</label>
    <input type="text" class="form-control" name="{name}">
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary">Confirm</button>
  </div>
<?php Tiwdal::endModal()?>