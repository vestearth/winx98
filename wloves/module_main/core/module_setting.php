<?php
$_PAGE['permission'] = ['core', 'core_program_setting', 'core_module_setup'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav', 'itnav', 'itlanguage', 'input-pattern']);

WLoves::initSystem();

$setting_type = isset($_GET['type']) ? $_GET['type'] : 'arrange';
$module_code  = isset($_GET['module_code']) ? $_GET['module_code'] : '';

if ($_POST) {
  if (isset($_POST['submit_add_new_module'])) {
    unset($_POST['submit_add_new_module']);
    if (!$_POST['display']) {
      unset($_POST['display']);
    }

    $result = Module::addNewModule($_POST);

    if ($result['response_status']) {
      $id = $result['response_data']['insert_id'];
      $module_info = Module::getModuleByID($id);

      $response_redirect = 'module_setting.php?c=&type=module&module_code=' . $module_info['code'];
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

$list_info                      = WLoves::getProgramSetup();
$list_info['logo_image']        = File::getPath('logo_image');
$list_info['mobile_logo_image'] = File::getPath('mobile_logo_image');
$list_info_person               = WLoves::selectContactList('*');

$is_error = F_WLoves::$initial_data['sidenav']['check_error'];

// Module
$exists_modules = Func::selectExistsModule();
$modules        = Doc::selectModule([], ['it_nav_wolves' => 1]);

//new
$other_modules = Module::selectGeneralModule();
$user_modules = Module::selectUserModule();
$user_management_position = Module::getUserMngPostion();
$all_module = Module::selectModule();


//Arrange Module Position menu
$data_program = [
  'param_name' => 'type',
  'class' => 'list-bg-none',
  'list' => [],
];
$program_info = WLoves::getProgramSetup();
if (isset($program_info['module_sidebar_mode'])) {
  $data_program['list'][] = [
    'id'   => 'module_mode',
    'name' => 'Module mode',
    'icon' => 'structure/image/icon/general/setting.svg'
  ];
}
$data_program['list'][] = [
  'id'   => 'arrange',
  'name' => 'Arrange Module Position',
  'icon' => 'structure/image/icon/general/arrange.svg'
];

//Other Module setting menu
$data_module = [
  'param_name' => 'type',
  'class' => 'list-bg-none',
  'list' => [],
];
foreach ($other_modules as $module) {
  $data_module['list'][] = [
    'id'   => 'module&module_code=' . $module['code'],
    'name' => '<span class="text-uppercase">' . $module['module'] . '</span> | ' . $module['name'] . ($module['display'] == 'user' ? '<br><span class="font-12px">USER TYPE: <span class="text-primary">' . $module['display'] . '</span></span>' : ''),
    'icon' => 'structure/image/icon/general/icon-setting.svg'
  ];
}

//User Module setting menu
$data_user_module = [
  'param_name' => 'type',
  'class' => 'list-bg-none',
  'list' => [],
];
foreach ($user_modules as $module) {
  $data_user_module['list'][] = [
    'id'   => 'module&module_code=' . $module['code'],
    'name' => '<span class="text-uppercase">' . $module['module'] . '</span> | ' . $module['name'] . '<br><span class="font-12px">USER TYPE: <span class="text-primary">' . $module['managed_user_type_name'] . '</span></span>',
    'icon' => 'structure/image/etc/user.svg'
  ];
}

$_GET['type'] = ($setting_type == 'module') ? $setting_type . '&module_code=' . $module_code : $setting_type;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php Structure::loadMeta('../../'); ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php include_once '../../structure/layout/header-default.php'; ?>

  <div class="form-row">
    <div class="col-lg-3 col-xl-2">
      <div class="setting-menu-container">

        <div class="topic-container">
          <div class="topic-header-wrap">
            <h3 class="header-title  font-16px font-SemiBold text-info">Manage Module</h3>
            <p class="header-description font-14px font-Regular text-secondary">
              Manage module on this program.
            </p>
          </div>
          <h3 class="header-title mb-0 text-uppercase font-14px text-muted">Display</h3>
          <?= Boatnav::wolves($data_program, '?c='); ?>
        </div>

        <div class="topic-container">
          <div class="topic-header-wrap mb-5px">
            <h3 class="header-title mb-10px text-uppercase font-14px text-muted">Module setting</h3>
            <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'w-100'], ['text' => '+ ADD NEW MODULE', 'modal_id' => 'add_new_module', 'modal_data' => [], 'is_ajax' => true, 'prefix' => '']); ?>
          </div>
          <?= Boatnav::wolves($data_module, '?c='); ?>
        </div>

        <div class="topic-container">
          <h3 class="header-title mb-0 text-uppercase font-14px text-muted">USER MANAGEMENT</h3>
          <?= Boatnav::wolves($data_user_module, '?c='); ?>
        </div>

      </div>
    </div>
    <?php
    if ($setting_type == 'arrange') {
      include '../../module_main/core/view/program_setting/arrange_module.php';
    } else if ($setting_type == 'module_mode') {
      include '../../module_main/core/view/program_setting/module_mode.php';
    } else if ($setting_type == 'module') {
      include '../../module_main/core/view/program_setting/module.php';
    }
    ?>
  </div>

  <?php Tiwdal::ajaxModal('add_new_module', 'modal-md'); ?>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>

</html>