<?php
if ($_POST) {
  if (isset($_POST['submit_add_language'])) {
    unset($_POST['submit_add_language']);
    $result = Language::addNewSystemLanguage($_POST);
  } else if (isset($_POST['submit_cancel_language'])) {
    unset($_POST['submit_cancel_language']);
    $result = Language::deleteSystemLanguage($_POST['id']);
  } else if (isset($_POST['submit_make_default_language'])) {
    unset($_POST['submit_make_default_language']);
    $result = Language::updateSystemLanguage($_POST['id'], ['is_system_default' => 1]);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

$select_language = Language::selectLanguage(['not_exists' => true]);
$language_options = [
  'list' => []
];
foreach ($select_language as $language) {
  $language_options['list'][] = [
    'value' => $language['locale_name'],
    'name' => $language['title'],
    'img' => $language['img_path'],
  ];
}
?>
<div class="col-lg-10 box-nav-top">
  <div class="editable-card core-new pb-15px" style="min-height: unset;">
    <div class="d-flex align-items-center justify-content-between flex-wrap p-15px">
      <div class="title-detail">
        <h3 class="text-uppercase font-SemiBold font-16px text-info mb-0">Language setting</h3>
        <p class="font-14px font-Regular mb-0">Configure program language, Default language can’t be cancel, Everyone use this program can be change personal language follow this list.</p>
      </div>
      <?php if (count($select_language)) { ?>
        <div class="mt-10px">
          <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => ''], ['text' => '+ ADD LANGUAGE', 'type' => '', 'modal_id' => 'add_language_modal', 'modal_data' => []]); ?>
        </div>
      <?php } ?>
    </div>
    <div class="table-responsive">
      <table class="table-bg-card-back">
        <thead>
          <tr>
            <th>Language</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if ($languages) {
            foreach ($languages as $language) {
          ?>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="flag-image mr-10px">
                      <img src="<?= $language['img_path'] ?>">
                    </div>
                    <div class="mr-10px text-uppercase"><?= $language['display_name'] ?></div>
                    <?= ($language['is_system_default']) ? '<div class="badge-primary">Default</div>' : ''; ?>
                  </div>
                </td>
                <td class="thin-cell">
                  <?php if (!$language['is_system_default']) { ?>
                    <div class="btn-group dot3">
                      <button type="button" class="form-btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= file_get_contents('../../structure/image/icon/general/more.svg'); ?>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right border-0 shadow-sm">
                        <form action="" method="post">
                          <?= TiwForm::normal('hidden', $language['id'], ['name' => 'id']) ?>
                          <button type="submit" class="btn dropdown-item justify-content-start" name="submit_make_default_language">
                            <span class="ml-5px">Make default</span>
                          </button>
                        </form>
                        <form action="" method="post">
                          <?= TiwForm::normal('hidden', $language['id'], ['name' => 'id']) ?>
                          <button type="submit" class="btn dropdown-item justify-content-start" name="submit_cancel_language">
                            <span class="ml-5px text-danger">Cancel Language</span>
                          </button>
                        </form>
                      </div>
                    </div>
                  <?php } ?>
                </td>
              </tr>
          <?php
            }
          } else {
            echo '<span class="font-14px text-secondary text-center">NO DATA</span>';
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php Tiwdal::startModal('add_language_modal', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
<div class="modal-header">
  <h5 class="modal-title">Add more language to this program</h5>
</div>
<form action="" method="post">
  <div class="modal-body">
    <div class="form-row">
      <div class="col-md-3 pt-5px">
        Language<span class="text-danger">*</span>
      </div>
      <div class="col-md-9">
        <?php
        TiwForm::normal('select-img', '', ['name' => 'locale_name', 'placeholder' => 'Please Select'], $language_options);
        ?>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php
    TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-light min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'Cancel']);
    TiwForm::normal('btn', '', ['type' => 'submit', 'class' => 'min-w-100px', 'name' => 'submit_add_language'], ['text' => 'ADD']);
    ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>