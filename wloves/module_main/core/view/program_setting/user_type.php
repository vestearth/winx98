<?php
$data_user_type = User_type::selectUserType();

$id = isset($_GET['id'])  ? $_GET['id'] : '';

if ($_POST) {
  if (isset($_POST['submit_add_user_type'])) {
    unset($_POST['submit_add_user_type']);
    $result = User_type::addNewUserType($_POST);
  } else if (isset($_POST['submit_delete_user_type'])) {
    $result = User_type::deleteUserType($id);

    if ($result['response_status']) {
      $response_redirect = 'program_setting.php?setting=' . $setting_type;
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

$nav_type_param = isset($_GET['nav_type']) ? $_GET['nav_type'] : '1';
$data_nav_top = [
  'class' => '',
  'list' => [
    [
      'id' => 1,
      'name' => 'Hide Permission',
      'icon' => '',
      'count' => '',
    ],
    [
      'id' => 2,
      'name' => 'Information Setting',
      'icon' => '',
      'count' => '',
    ],
    [
      'id' => 3,
      'name' => 'User Type Details',
      'icon' => '',
      'count' => '',
    ],
  ],
];
$link_top = 'program_setting.php?setting=user_type&id=' . $id;

//select Reference User Type
$reference_user_options = [
  'list' => [
    [
      'value' => 0,
      'name' => 'No Reference',
    ]
  ]
];
foreach ($data_user_type as $data) {
  array_push($reference_user_options['list'], ['value' => $data['id'], 'name' => $data['name']]);
}
?>

<div class="col-lg-10">
  <div class="form-row">
    <div class="col-xl-4 mb-10px">
      <div class="d-flex align-items-center justify-content-between">
        <div class="title-group">
          <h3 class="font-16px font-SemiBold mb-0">User type</h3>
          <p class="font-14px font-Regular mb-0">Manage your user type.</p>
        </div>
        <button class="btn btn-primary w-auto text-uppercase" <?php Tiwdal::register('add_user_type_modal'); ?>>+ Add NEW USER TYPE</button>
      </div>
      <div class="table-responsive mt-10px">
        <table class="table-bg-card-back type-1">
          <thead>
            <tr>
              <th nowrap>User Type</th>
              <th nowrap class="thin-cell text-right">Function</th>
              <th nowrap class="thin-cell text-right">Permission</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data_user_type as $data) { ?>
              <tr data-tr="program_setting.php?c=&setting=user_type&id=<?= $data['id'] ?>" class="<?= ($data['id'] == $id) ? 'active' : '' ?>">
                <td class="text-info">
                  <?= $data['name'] ?>
                </td>
                <td class="text-right">
                  <span class='text-primary'><?= $data['checked_count'] ?></span>/ <?= $data['total_count'] ?>
                </td>
                <td class="text-success text-right">
                  <?= $data['checked_percent'] ?>%
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-xl-8">
      <?php
      if ($id) {
        $user_information = User_type::getUserTypeByID($id);
        include '../../module_main/core/program_user_type_detail.php';
      }
      ?>
    </div>
  </div>
</div>


<?php Tiwdal::startModal('add_user_type_modal', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title">ADD USER TYPE</h5>
</div>
<form method="post">
  <div class="modal-body">
    <div class="form-row">
      <div class="col-sm-3 pt-5px font-14px text-secondary">User Type Name<span class="text-danger">*</span></div>
      <div class="col-sm-9">
        <?= TiwForm::normal('text', '', ['name' => 'name', 'placeholder' => 'Enter']) ?>
      </div>
      <div class="col-sm-3 pt-5px font-14px text-secondary">Description</div>
      <div class="col-sm-9">
        <?= TiwForm::normal('textarea', '', ['name' => 'description', 'placeholder' => 'Enter']); ?>
      </div>
      <div class="col-sm-3 pt-5px font-14px text-secondary">Ref. Information</div>
      <div class="col-sm-9">
        <?= TiwForm::normal('select', '', ['name' => 'ref_user_type_id'], $reference_user_options); ?>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-light w-80px" data-dismiss="modal">Cancel</button>
    <button type="submit" name="submit_add_user_type" class="btn btn-primary w-100px">SAVE</button>
  </div>
</form>
<?php Tiwdal::endModal() ?>