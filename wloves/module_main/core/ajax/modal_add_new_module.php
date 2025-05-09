<?php
$_PAGE['permission'] = ['core', 'core_program_setting', 'core_module_setup'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');

function formTemplate($title, $detail, $options = [])
{
  $is_required = (substr($title, -3) == '{*}') ? '<span class="text-danger">*</span>' : '';
  $title = $is_required ? str_replace('{*}', '', $title) : $title;
  $main_class = (isset($options['main_class'])) ? $options['main_class'] : '';

  echo '<div class="form-row ' . $main_class . '">
          <div class="col-sm-3 font-14px text-secondary pt-10px">' . $title . $is_required . '</div>
          <div class="col-sm-9">
          ' . $detail . '
          </div>
        </div>';
}

//select module
$modules = Module::selectExistsModule();
$key = [
  'value' => 'key',
  'name' => 'name',
];
$module_type_options = TiwForm::generateSelectData($modules, $key, ['is_search' => true, 'prefix' => '../../../', 'is_return' => true, 'is_data' => true]);

//select display
$display_options = ['list_encode' => '[{"value":"user","name":"Inside User Management"},{"value":"notuser","name":"Outside User Management"}]', 'is_return' => true, 'is_search' => true, 'prefix' => '../../../'];

//select user type
$user_types = User_type::selectUserType();
$key = [
  'value' => 'id',
  'name' => 'name',
];
$user_type_options = TiwForm::generateSelectData($user_types, $key, ['is_search' => true, 'prefix' => '../../../', 'is_return' => true, 'is_data' => true]);

?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<div class="modal-header">
  <h5 class="modal-title">Add new module</h5>
</div>
<form method="post">
  <div class="modal-body">
    <?php
    formTemplate('Module Type{*}', TiwForm::normal('select', '', ['name' => 'module', 'class' => 'mb-10px select_module_event', 'placeholder' => 'Select Module', 'required' => true], $module_type_options));

    formTemplate('Module Name{*}', TiwForm::normal('text', '', ['name' => 'name', 'placeholder' => 'Enter', 'required' => true], ['is_return' => true]));

    formTemplate('Description', TiwForm::normal('textarea', '', ['name' => 'description', 'placeholder' => 'Enter', 'class' => '
    min-h-70px'], ['is_return' => true]));

    formTemplate('Display{*}', TiwForm::normal('select', '', ['name' => 'display', 'placeholder' => 'Select Display', 'class' => 'mb-10px', 'required' => true], $display_options), ['main_class' => 'scope_select_display_event']);
    ?>
    <div class="mx--15px line-dashed"></div>
    <div class="font-14px font-SemiBold text-info mb-10px">MODULE CONFIGURE</div>
    <?php
    formTemplate('Manage User Type{*}', TiwForm::normal('select', '', ['name' => 'managed_user_type_id', 'class' => 'mb-10px', 'placeholder' => 'Select User Type', 'required' => true], $user_type_options), ['main_class' => 'scope_manage_user_event']);

    formTemplate('Admin{*}', TiwForm::normal('select', '', ['name' => 'admin_user_type_id', 'class' => 'mb-10px', 'placeholder' => 'Select User Type', 'required' => true], $user_type_options), ['main_class' => 'scope_select_admin_event']);

    formTemplate('Multiple Owner', '<div class="d-flex align-items-center min-h-45px">' . TiwForm::normal('checkbox', 1, ['name' => 'is_multiple_owner', 'class' => ''], ['style' => '3', 'label' => 'Activate', 'is_return' => true]) . '</div>', ['main_class' => 'scope_multiple_owner_event']);

    formTemplate('Ownership{*}', TiwForm::normal('select', '', ['name' => 'vendor_user_type_id', 'class' => 'mb-10px', 'placeholder' => 'Select User Type', 'required' => true], $user_type_options), ['main_class' => 'scope_select_ownership_event']);
    ?>
  </div>
  <div class="modal-footer">
    <?php
    TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-light min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'Cancel']);
    TiwForm::normal('btn', '', ['name' => 'submit_add_new_module', 'type' => 'submit', 'class' => 'min-w-100px'], ['text' => 'ADD']);
    ?>
  </div>
</form>

<script>
  $(function() {
    $(document).on('change', '.select_module_event input[select_value]', function(e) {
      var select_id = $(this).val();
      var select_data = $(this).parents('.form-select-img').find('.select-group .select_list_' + select_id).attr('data-list');
      select_data = select_data ? jQuery.parseJSON($.base64.decode(select_data)) : [];

      showHideFormByModuleTypeEvent(select_data.config_list)
    });
  });

  function showHideFormByModuleTypeEvent(permission = {}) {
    $('.scope_select_display_event').hide();
    $('.scope_manage_user_event').hide();
    $('.scope_select_admin_event').hide();
    $('.scope_multiple_owner_event').hide();
    $('.scope_select_ownership_event').hide();

    $('.scope_select_display_event input[select_value]').attr('required', false);
    $('.scope_manage_user_event input[select_value]').attr('required', false);
    $('.scope_select_admin_event input[select_value]').attr('required', false);
    $('.scope_select_ownership_event input[select_value]').attr('required', false);

    if (permission.display) {
      $('.scope_select_display_event').show();
      $('.scope_select_display_event input[select_value]').attr('required', true);
    }
    if (permission.manage_user_type) {
      $('.scope_manage_user_event').show();
      $('.scope_manage_user_event input[select_value]').attr('required', true);
    }
    if (permission.admin) {
      $('.scope_select_admin_event').show();
      $('.scope_select_admin_event input[select_value]').attr('required', true);
    }
    if (permission.multiple_owner) {
      $('.scope_multiple_owner_event').show();
    }
    if (permission.ownership) {
      $('.scope_select_ownership_event').show();
      $('.scope_select_ownership_event input[select_value]').attr('required', true);
    }
  }
</script>