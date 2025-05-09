<div class="content-header-container">
  <h3 class="header-title">การเขียน Ajax Modal<p class="font-14px mt-5px">ใช้กรณีที่ต้องการให้ตัวแปรที่ส่งไป แทนค่าใน Tag Html ให้ โดยอัตโนมัติ และ สามารถส่ง POST เข้าไปใน Modal เพื่อ Custom ได้</p>
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
          'name' => 'Edit Modal'
        ];
        $options = [
          'is_ajax' => 1,
          'pre_fix' => 'view/',
          // 'auto_form' => 0,
          // 'code' => $_GET['c']
        ];
        ?>
        <button class="btn btn-primary" <?php Tiwdal::register('ex_ajax', $edit_data, $options); ?>>Click for open ajax modal.</button>
      </div>
      <div class="code-container">
        <pre><code data-language="php">&lt;?php
  //เรียกใช้ Module tiwdal ไว้ที่หัวของหน้านั้น ๆ
  Structure::loadModules(['tiwdal']);

  //ตัวแปรที่ใช้ในการแทนค่าใน Tag
  $edit_data = [
    'id'   => 1,
    'name' => 'Edit Modal'
  ]; //ข้อมูลที่ต้องการส่งไปที modal เพื่อใช้ auto form
  $options = [
    'is_ajax' => 1, //ถ้ามีตัวแปรนี้จะเป็น Ajax Modal
  ];
?&gt;

&lt;button class="btn btn-primary" &lt;?php Tiwdal::register('ajax_modal', $edit_data, $options);?&gt;>
  Click for open ajax modal.
&lt;/button&gt;</code></pre>
      </div>
    </div>
  </div>
</div>
<div class="content-body-container">
  <div class="row">
    <div class="col-12">
      <p>
        $id = id ของ Modal<br>
        $size = ขนาด Modal (ใส่หรือไม่ใส่ก็ได้) / sm, md, lg, xl<br>
        $options = เงื่อนไขอื่น ๆ ที่ต้องการวาดที่หัว modal (ใส่หรือไม่ใส่ก็ได้) เช่น ['class' => 'test1 test2', 'data-id' => '1']<br>
      </p>
      <label class="text-primary">*** วางโค๊ดนี้ในหน้าเดียวกันโปรแกรมจะทำการสร้าง modal ให้ในหน้านั้นเพื่อที่จะนำไฟล์ ajax มาแสดง</label>
      <div class="code-container">
        <pre><code data-language="php">
&lt;?php Tiwdal::ajaxModal($id, $size, $options);?&gt;
        </code></pre>
      </div>
    </div>
  </div>
</div>
<div class="content-body-container">
  <div class="row">
    <div class="col-12">
      <label>ตัวอย่างไฟล์ Ajax</label>
      <label class="text-primary">*** หลักการตั้งชื่อไฟล์ modal_<span class="text-danger">ไอดี</span>.php<br>กรณีตัวอย่างก็คือ <span class="text-success">modal_ex_ajax.php</span> และต้องเอาไว้ในโฟลเดอร์ ajax/ เท่านั้น<br><span class="text-secondary">(ระบบจะทำการดึงไฟล์ให้อัตโนมัติถ้าตั้งชื่อไฟล์ตามไอดี modal ถูกต้อง)</span></label>
      <div class="code-container">
        <pre><code data-language="php">&lt;?php
  $_PAGE['permission'] = ['core', 'core_template', 'tiwdal'];
  require_once '../../../../.framework/import.php';
?&gt;
<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
  <span aria-hidden='true'>&times;</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">Ex. Edit Modal</h5>
</div>
<div class="modal-body">
  <label>ID :</label>
  <input type="text" class="form-control" name="id">
  <label>Name :</label>
  <input type="text" class="form-control" name="name">
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-modal-cancel" data-dismiss="modal">Cancel</button>
  <button type="button" class="btn btn-primary">Confirm</button>
</div></code></pre>
      </div>
    </div>
  </div>
</div>

<?php Tiwdal::ajaxModal('ex_ajax'); ?>