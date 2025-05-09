<?php
class F_Permission
{
  public static $has_permissions     = [];
  public static $functions_available = [];
  public static $main_menus          = [];
  public static $basic_settings      = [
    [
      'key' => 'permission_template',
      'name' => 'Permission Template',
    ],
    [
      'key' => 'team',
      'name' => 'Team',
    ],
    [
      'key' => 'category',
      'name' => 'Category',
    ],
    [
      'key' => 'tag',
      'name' => 'Tag',
    ],
  ];

  // check permission for core and module page

  public static function checkCore()
  {
    $is_dev = F_User::isDev();
    if ($is_dev) {
      return true;
    }

    header('Location: ../../module_main/login/logout.php');
    Aww::notification('No Dev Permission', 'error');
    exit();
  }

  public static function checkModule($page)
  {
    global $_GET;

    $user_info   = F_User::getCurrentUser();
    $permissions = User_Permission::getUserPermissionList($user_info['id']);

    if ($page['permission'][0] == 'user') {
      return true;
    } else if (isset($_GET['c']) && $_GET['c']) {
      if ($page['permission'][2]) {
        if (isset($permissions[$_GET['c'] . '_' . $page['permission'][2]])) {
          return true;
        }
      } else if ($page['permission'][1]) {
        if (isset($permissions[$_GET['c'] . '_' . $page['permission'][1]])) {
          return true;
        }
      } else if ($page['permission'][0]) {
        if (isset($permissions[$_GET['c'] . '_' . $page['permission'][0]])) {
          return true;
        }
      }
    }
    Aww::redirect('../../module_main/login/logout.php');
    Aww::notification('No User Permission', 'error');
  }

  // redirect
  public static function redirectToFirstModuleAvailable()
  {
    foreach (F_Permission::$functions_available as $function) {
      F_WLoves::setConfigMenuList($function['module']);
      if (isset(F_Config::$menu_list[$function['module']])) {
        $menu = F_Config::$menu_list[$function['module']];

        if (isset(F_Permission::$has_permissions[$function['code'] . '_' . $menu['page_name']])) {
          foreach ($menu['menu_items'] as $menu_items) {
            if (isset(F_Permission::$has_permissions[$function['code'] . '_' . $menu_items['page_name']])) {
              if ($menu_items['url']) {
                Aww::redirect('module/' . $menu['page_name'] . '/' . $menu_items['url'] . '?c=' . $function['code']);
              }
            }
          }
        }
      }
    }

    Aww::redirect('module_main/landing/index.php?action=not_found');
  }

  public static function redirectToPageInsidePermission($page_name, $page_name_sub, $c)
  {
    $is_dev = F_User::isDev();

    foreach (F_Permission::$functions_available as $function) {
      F_WLoves::setConfigMenuList($function['module']);
    }

    $menu_list   = F_Config::$menu_list;
    $permissions = F_Permission::$has_permissions;

    foreach ($menu_list as $menu) {
      echo $menu['page_name'] . '<br />';
      if ($menu['page_name'] == $page_name) {

        foreach ($menu['menu_items'] as $menu_items) {
          if ($menu_items['page_name'] == $page_name_sub) {
            // Redirect if no sub_menu
            if (!$menu_items['sub_menu']) {
              Aww::redirect('module/' . $menu['page_name'] . '/' . $menu_items['url'] . '?c=' . $c);
            }

            foreach ($menu_items['sub_menu'] as $sub_menu) {
              if (isset($permissions[$_GET['c'] . '_' . $sub_menu['page_name']])) {
                Aww::redirect('module/' . $menu['page_name'] . '/' . $sub_menu['url'] . '?c=' . $c);
              } else if ($is_dev) {
                Aww::redirect('module/' . $menu['page_name'] . '/' . $sub_menu['url'] . '?c=' . $c);
              }
            }
          }
        }
      }
    }

    Aww::notification('Permission Denied! [' . $page_name . '][' . $page_name_sub . '][' . $c . ']', 'error');
    Aww::redirect('module_main/login/index.php?error=Permission Denied!');
  }


  public static function templateConfigPermission($options = [])
  {
    $is_edit = (isset($options['is_edit']) && $options['is_edit']) ? true : false;
    $prefix = (isset($options['prefix'])) ? $options['prefix'] : '../../';
    $permission_array = static::randerPermissionList($options);
    include 'template_permission.php';
  }

  public static function templateConfigHidePermission($options = [])
  {
    $is_edit = (isset($options['is_edit']) && $options['is_edit']) ? true : false;
    $prefix = (isset($options['prefix'])) ? $options['prefix'] : '../../';
    $permission_array = static::randerPermissionList($options);
    include 'template_hide_permission.php';
  }

  private static function randerPermissionList($options = [])
  {
    $all_module      = Module::selectModule(); //module ทั้งหมดจาก database
    $all_module_list = F_Permission::$functions_available; //module ที่มีจริง ๆ จาก config
    $menu_list       = F_Config::$menu_list; //page ทั้งหมด

    $permission = (isset($options['permission'])) ? $options['permission'] : [];
    $block_permission = (isset($options['block_permission'])) ? $options['block_permission'] : false;

    $file_menu_list = F_Config::$menu_list;

    $permission_array = [];
    foreach ($all_module as $module) { //all module
      $menu = array_key_exists($module['module'], $file_menu_list) ? $file_menu_list[$module['module']] : '';
      if (!$menu) {
        continue;
      }
      $module_code = $module['code'];

      $permission_array[$module['code']] = $module;
      $permission_array[$module['code']]['list'] = [];

      if (isset($menu_list[$module['module']]) && $menu_list[$module['module']]['menu_items']) {
        foreach ($menu_list[$module['module']]['menu_items'] as $page_group_key => $page_group) { //sub module
          if (isset($page_group['sub_menu']) || $module['module'] == 'User') {
            if ($module['module'] == 'User') { //user permission list
              $name = $module['code'] . '_user';
              $condition = !isset($block_permission[$name]);
              if ($condition) {
                $checked = (isset($permission[$name])) ? true : false;

                $permission_array[$module['code']]['list'][0] = [
                  'name' => 'MANAGE',
                  'list' => []
                ];

                $permission_array[$module['code']]['list'][0]['list'][] = [
                  'key' => $name,
                  'name' => $module['name'] . ' List',
                  'description' => ($module['description'] ? $module['description'] : '-'),
                  'checked' => $checked,
                ];
              }

              $user_type_info = User_type::getUserTypeByID($module['managed_user_type_id']);

              $permission_array[$module['code']]['list'][1] = [
                'name' => 'BASIC SETTING',
                'list' => []
              ];

              //user type basic setting
              foreach (static::$basic_settings as $user_type_setting) {
                $name = 'user_type_' . $module['managed_user_type_id'] . '_' . $user_type_setting['key'];

                $condition = (!isset($block_permission[$name]));

                if ($user_type_setting['key'] == 'permission_template') {
                  $condition_function = $user_type_info['is_permission_template'];
                } else if ($user_type_setting['key'] == 'team') {
                  $condition_function = $user_type_info['is_has_team'];
                } else if ($user_type_setting['key'] == 'category') {
                  $condition_function = $user_type_info['is_has_category'];
                } else if ($user_type_setting['key'] == 'tag') {
                  $condition_function = $user_type_info['is_has_tag'];
                } else {
                  $condition_function = 0;
                }

                if ($condition && $condition_function) {
                  $checked = (isset($permission[$name])) ? true : false;

                  $permission_array[$module['code']]['list'][1]['list'][] = [
                    'key' => $name,
                    'name' => (isset($user_type_setting['name']) ? $user_type_setting['name'] : '-'),
                    'description' => '-',
                    'type' => 'function',
                    'checked' => $checked,
                  ];
                }
              }
            } else { //module permission list
              $page_key = 0;
              foreach ($page_group['sub_menu'] as $page) { //menu page
                $name = $module_code . '_' . $page['page_name'];
                $condition = !isset($block_permission[$name]);
                if ($condition) {
                  if ($page_key == 0) {
                    $permission_array[$module['code']]['list'][$page_group_key] = [
                      'name' => $page_group['title'],
                      'list' => [],
                    ];
                  }
                  $checked = (isset($permission[$name])) ? true : false;
                  $permission_array[$module['code']]['list'][$page_group_key]['list'][$page_key] = [
                    'key' => $name,
                    'name' => $page['title'],
                    'description' => (isset($page['description']) && $page['description'] ? $page['description'] : '-'),
                    'checked' => $checked,
                    'function' => [],
                  ];

                  if (isset($page['function'])) { //funtion about condition in page ex. button add edit update or etc.
                    $function_key = 0;
                    foreach ($page['function'] as $function) {
                      $type = (isset($function['type']) && $function['type']) ? $function['type'] : 'function';
                      $name = $module_code . '_' . $function['page_name'];
                      $checked = (isset($permission[$name])) ? true : false;

                      $permission_array[$module['code']]['list'][$page_group_key]['list'][$page_key]['function'][$function_key] = [
                        'key' => $name,
                        'name' => (isset($function['title']) ? $function['title'] : '-'),
                        'description' => (isset($function['description']) ? $function['description'] : '-'),
                        'type' => $type,
                        'checked' => $checked,
                      ];

                      $function_key++;
                    } //foreach function 
                  } //$page['function']
                  $page_key++;
                } //end if $condition
              } //foreach page
            }
          } //end if $page_group['sub_menu']
          $permission_array[$module['code']]['list'] = array_values($permission_array[$module['code']]['list']);
        } //foreach page_group 
      }
    } //foreach module
    return $permission_array;
  }

  private static function randerCheckbox($options)
  {
    $name = (isset($options['name']) && $options['name']) ? $options['name'] : '';
    $is_edit = (isset($options['is_edit']) && $options['is_edit']) ? true : false;
    $checked = (isset($options['checked']) && $options['checked']) ? true : false;
    $type = (isset($options['type']) && $options['type']) ? $options['type'] : '';

    $green_class = ($type == 'function') ? 'green' : '';
    if ($is_edit) {
      $checkbox = TiwForm::normal('checkbox', 1, ['name' => 'checked[' . $name . ']', 'class' => $green_class . ' __check_list_permission_event', 'checked' => $checked], ['style' => '3', 'is_return' => true]);
    } else {
      if ($checked) {
        $color = ($type == 'function') ? 'text-success' : 'text-primary';
        $checkbox = '<span class="' . $color . ' font-14px __check_list_permission_event __is_checked">YES</span>';
      } else {
        $checkbox = '<span class="font-14px __check_list_permission_event text-danger">NO</span>';
      }
    }
    echo $checkbox;
  }

  private static function randerCheckboxHidePermission($options)
  {
    $name = (isset($options['name']) && $options['name']) ? $options['name'] : '';
    $is_edit = (isset($options['is_edit']) && $options['is_edit']) ? true : false;
    $checked = (isset($options['checked']) && $options['checked']) ? true : false;

    if ($is_edit) {
      $checkbox = TiwForm::normal('checkbox', 1, ['name' => 'checked[' . $name . ']', 'class' => 'red __check_list_permission_event', 'checked' => $checked], ['style' => '3', 'is_return' => true]);
    } else {
      if ($checked) {
        $checkbox = '<span class="text-danger font-14px __check_list_permission_event __is_checked">Hide</span>';
      } else {
        $checkbox = '<span class="font-14px __check_list_permission_event text-primary">No</span>';
      }
    }
    echo $checkbox;
  }
}
