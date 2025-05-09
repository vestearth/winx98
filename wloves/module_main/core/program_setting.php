<?php
$_PAGE['permission'] = ['core', 'core_program_setting', 'core_program_setting_setup'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav', 'itnav', 'itlanguage', 'input-pattern']);

WLoves::initSystem();

$page = (isset($_GET['page']) && $_GET['page']) ? $_GET['page'] : 1;
$setting_type = isset($_GET['setting']) ? $_GET['setting'] : 'general';
$status = (isset($_GET['status']) && $_GET['status']) ? $_GET['status'] : '';

$module_code_selected = isset($_GET['module_code']) ? $_GET['module_code'] : '';

if (isset($_POST['submit_add_user'])) {
  $data = [
    'username' => $_POST['username'],
    'password' => $_POST['password']
  ];
  $api_result = User::addNewUser($module_code_selected, $data);

  if ($api_result['response_status']) {
    $user_id = $api_result['response_data']['insert_id'];
    $permission_code = explode(',', $_POST['permission_code']);
    User_Permission::trigger($user_id, $permission_code, 1);

    Aww::notification($api_result['response_message'], 'success');
    Aww::redirect('');
  } else {
    Aww::notification($api_result['response_message'], 'error');
    Aww::redirect('');
  }
}

$languages = Language::selectSystemLanguage();

$data_nav = [
  'param_name'  => 'setting',
  'title' => 'Setting',
  'class' => 'list-bg-none',
  'list' => [
    [
      'id'  => 'general',
      'name'  => 'General Information',
      'icon'   => 'structure/image/icon/general/general.svg',
    ],
    [
      'id'  => 'language',
      'name'  => 'Language',
      'icon'   => 'structure/image/icon/general/language.svg',
      'count'  => count($languages),
    ],
    [
      'id'  => 'theme',
      'name'  => 'Theme & Color',
      'icon'   => 'structure/image/icon/general/theme.svg',
    ],
    // [
    //   'id'  => 'database',
    //   'name'  => 'Database Connection',
    //   'icon'   => 'structure/image/icon/general/database.svg',
    // ],
    [
      'id'  => 'alert',
      'name'  => 'Alert',
      'icon'   => 'structure/image/icon/general/alert.svg',
    ],
    [
      'id'  => 'user_type',
      'name'  => 'User Type',
      'icon'   => 'structure/image/icon/general/user-type.svg',
    ],
  ]
];

$list_info                      = WLoves::getProgramSetup();
$list_info['logo_image']        = File::getPath('logo_image');
$list_info['signin_image']      = File::getPath('signin_image');
$list_info['favicon']           = File::getPath('favicon');
$list_info_person               = WLoves::selectContactList('*');

$is_error = F_WLoves::$initial_data['sidenav']['check_error'];

// Module
// $exists_modules = Func::selectExistsModule();
// $modules        = Doc::selectModule([], ['it_nav_wolves' => 1]);

$program = F_WLoves::$initial_data['program'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php Structure::loadMeta('../../'); ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php include_once '../../structure/layout/header-default.php'; ?>

  <div class="form-row">
    <div class="col-lg-2">
      <div class="setting-menu-container">
        <div class="topic-container">
          <div class="topic-header-wrap">
            <h3 class="header-title  font-16px font-SemiBold text-info">Program Setting</h3>
            <p class="header-description font-14px font-Regular text-secondary">
              Setting program data and configure
              your program theme.
            </p>
          </div>
          <?php Boatnav::wolves($data_nav, '?c='); ?>
        </div>
      </div>
    </div>
    <?php
    if ($setting_type == 'general') {
      include '../../module_main/core/view/program_setting/general_detail.php';
    } else if ($setting_type == 'language') {
      include '../../module_main/core/view/program_setting/language.php';
    } else if ($setting_type == 'theme') {
      include '../../module_main/core/view/program_setting/theme.php';
    } else if ($setting_type == 'database') {
    } else if ($setting_type == 'alert') {
      include '../../module_main/core/view/program_setting/alert_list.php';
    } else if ($setting_type == 'user_type') {
      include '../../module_main/core/view/program_setting/user_type.php';
    }
    ?>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>

</html>