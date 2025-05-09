<?php
  $_PAGE['permission'] = ['core', 'core_template', 'tiwdal'];
  require_once '../../../../.framework/import.php';
?>
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
  <button type="button" class="btn btn-primary">Save</button>
</div>