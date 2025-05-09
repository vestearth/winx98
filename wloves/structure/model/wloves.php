<?php
class F_WLoves
{
  public static $initial_data    = [];
  public static $favorite_data   = [];
  public static $sidenav_is_open = [];
  public static $notification    = [];
  public static $hidden_menu     = [];
  public static $hidden_menu_user_ids    = [];
  public static $hidden_menu_permissions = [];

  static function init()
  {
    $can_import = true;
    if (class_exists('Installation') && !Installation::hasConfigFile()) {
      $can_import = false;
    }
    if ($can_import) {
      static::$initial_data = WLoves::getInitialData();
      if (!static::$initial_data) {
        echo 'Empty initial_data';
        die();
      }
      F_User::$get_current = static::$initial_data['current_user_data'];

      F_Permission::$functions_available = isset(static::$initial_data['permission']['module_list']) ? static::$initial_data['permission']['module_list'] : [];
      F_Permission::$has_permissions     = isset(static::$initial_data['permission']['allow_list']) ? static::$initial_data['permission']['allow_list'] : [];

      F_Config::$menu_core_list['Core']['menu_items'][1]['sub_menu'][3]['url'] = isLocalhost() ? 'dbadminer/' : 'dbadminer/adminer_login.php';

      F_Log::$log_list = isset(static::$initial_data['sidenav']['log']) ? static::$initial_data['sidenav']['log'] : [];

      F_Log::init();
    }
  }

  static function getProgramName()
  {
    $program_name = isset(static::$initial_data['program']['program_name']) ? static::$initial_data['program']['program_name'] : '';
    return $program_name;
  }

  static function setConfigMenuList($module_name, $path_prefix = '')
  {
    if (file_exists($path_prefix . 'module/' . strtolower($module_name) . '/config/menu.php')) {
      include $path_prefix . 'module/' . strtolower($module_name) . '/config/menu.php';
    }
  }

  static function getColorClass()
  {
    $color_theme = isset(static::$initial_data['program']['color_theme']) ? static::$initial_data['program']['color_theme'] : '';

    $color_highlight = isset(static::$initial_data['program']['color_highlight']) ? static::$initial_data['program']['color_highlight'] : '';
    $color_base_background = isset(static::$initial_data['program']['color_base_background']) ? static::$initial_data['program']['color_base_background'] : '';
    $color_selected_menu = isset(static::$initial_data['program']['color_selected_menu']) ? static::$initial_data['program']['color_selected_menu'] : '';
    $color_base_icon = isset(static::$initial_data['program']['color_base_icon']) ? static::$initial_data['program']['color_base_icon'] : '';

    if (!$color_theme) {
      return true;
    }

    echo '<style>
    body #sidenav {
      background-color: ' . $color_base_background . ' !important;
    }

    body #sidenav .menu .list:hover, 
    body #sidenav .menu .list.active {
      background-color: ' . $color_selected_menu . ' !important;
    }

    body #sidenav .menu .list .set-frame svg , 
    body #sidenav .menu .list .set-frame svg *, 
    body #sidenav .menu .list .set-frame svg * *, 
    body #sidenav .user .list .set-frame svg ,
    body #sidenav .user .list .set-frame svg *, 
    body #sidenav .user .list .set-frame svg * * { 
      fill: ' . $color_base_icon . ' !important;
    }
    
    body #sidenav .menu .list .set-frame p, 
    body #sidenav .user .list .set-frame p {
      color: ' . $color_base_icon . ' !important;
    }

    body #sidenav .bottom .log.active,
    body #sidenav .bottom .log:hover 
    body #sidenav .user .list:hover, 
    body #sidenav .user .list.active, 
    body #sidenav .core-bottom .list:hover, 
    body #sidenav .core-bottom .list.active {
      background-color: ' . $color_selected_menu . ' !important;
    }

    body #sidenav .user .list:hover svg *, 
    body #sidenav .user .list.active svg *, 
    body #sidenav .core-bottom .list:hover svg *, 
    body #sidenav .core-bottom .list.active svg * {
      fill: ' . $color_highlight . ' !important;
    }

    body #sidenav .menu .list:hover, 
    body #sidenav .menu .list.active, 
    body #sidenav .user .list:hover, 
    body #sidenav .user .list.active {
      background-color: ' . $color_selected_menu . ' !important;
    }

    body #sidenav .bottom .log:hover,
    body #sidenav .bottom .log.active,
    body #sidenav .bottom .profile:hover,
    body #sidenav .bottom .profile.active {
      background-color: ' . $color_selected_menu . ' !important;
    }

    body #sidenav .menu .list.active .set-frame svg, 
    body #sidenav .menu .list.active .set-frame svg *, 
    body #sidenav .menu .list.active .set-frame svg * *, 
    body #sidenav .user .list.active .set-frame svg, 
    body #sidenav .user .list.active .set-frame svg *, 
    body #sidenav .user .list.active .set-frame svg * *, 
    body #sidenav .menu .list:hover .set-frame svg, 
    body #sidenav .menu .list:hover .set-frame svg *, 
    body #sidenav .menu .list:hover .set-frame svg * *, 
    body #sidenav .user .list:hover .set-frame svg, 
    body #sidenav .user .list:hover .set-frame svg *, 
    body #sidenav .user .list:hover .set-frame svg * * {
      fill: ' . $color_highlight . ' !important;
    }

    body #sidenav .menu .list.active .set-frame p , 
    body #sidenav .menu .list:hover .set-frame p { 
      color: ' . $color_highlight . ' !important;
    }

    body #sidenav .menu .sub-menu .main-sub .list-sub:hover p, 
    body #sidenav .menu .sub-menu .main-sub .list-sub.active p {
      color: ' . $color_highlight . ' !important;
    }

    body #sidenav .menu .sub-menu .main-sub .list-sub:hover svg,
    body #sidenav .menu .sub-menu .main-sub .list-sub.active svg,
    body #sidenav .menu .sub-menu .main-sub .list-sub:hover svg *,
    body #sidenav .menu .sub-menu .main-sub .list-sub.active svg *,
    body #sidenav .menu .sub-menu .main-sub .list-sub:hover svg * *,
    body #sidenav .menu .sub-menu .main-sub .list-sub.active svg * * {
      fill: ' . $color_highlight . ' !important;
    }

    body #sidenav .menu .sub-menu .main-sub .list-sub:hover, 
    body #sidenav .menu .sub-menu .main-sub .list-sub.active, 
    body #sidenav .user .sub-menu .main-sub .list-sub:hover, 
    body #sidenav .user .sub-menu .main-sub .list-sub.active {
      background-color: ' . $color_selected_menu . ' !important;
    }

    .text-theme {
      color: ' . $color_theme . ' !important;
    }

    .bg-theme {
      background-color: ' . $color_theme . ' !important;
    }

    .it-nav-dinner .list.active {
      border-bottom: 3px solid ' . $color_theme . ' !important;
    }

    .it-nav-wolves .list.active .icon svg path {
      fill: ' . $color_theme . ' !important;
    }
    .it-nav-wolves .list.active .icon svg * {
      fill: ' . $color_theme . ' !important;
    }
    .it-nav-wolves .list.active .name,.it-nav-wolves .list.active .count {
      color: ' . $color_theme . ' !important;
    }

    body .dropdown.dd-primary .dropdown-menu .dropdown-item {
      color: ' . $color_theme . ' !important;
    }
    body .dropdown.dd-primary .dropdown-menu .dropdown-item svg path{
      fill: ' . $color_theme . ' !important;
    }
    body .tab-stork-menu nav .nav-tabs .nav-item.nav-link.active, body .tab-stork-menu nav .nav-tabs .nav-item.nav-link:hover {
      border-bottom: 3.5px solid ' . $color_theme . ' !important;
    }
    .btn-primary.focus, .btn-primary:focus {
      color: ' . $color_theme . ' !important;
    }

    body .menu-chat .list.active,body .menu-chat .list.active:hover {
      background-color: ' . $color_theme . ' !important;
    }

    body .menu-chat .list .icon .noti {
      background: ' . $color_theme . ' !important;
    }

    body .wallet-group .img.theme svg path,
    body .wallet-group .img.theme svg circle {
      fill: ' . $color_theme . ';
    }

    body .choose-paper-size:hover, body .choose-paper-size.active {
      border-color: ' . $color_theme . ';
    }

    body .choose-paper-size:hover .choose-paper-group .img svg rect, body .choose-paper-size.active .choose-paper-group .img svg rect {
      fill: ' . $color_theme . ';
    }

    body .choose-paper-size:hover .choose-paper-group .detail, body .choose-paper-size.active .choose-paper-group .detail {
      color: ' . $color_theme . ';
    }

    body .flatpickr-calendar .flatpickr-innerContainer .flatpickr-rContainer .flatpickr-days .dayContainer .flatpickr-day.startRange {
      background-color: ' . $color_theme . ';
    }


    body .flatpickr-calendar .flatpickr-innerContainer .flatpickr-rContainer .flatpickr-days .dayContainer .flatpickr-day.endRange {
      background-color: ' . $color_theme . ';
    }
    body .flatpickr-calendar .flatpickr-innerContainer .flatpickr-rContainer .flatpickr-days .dayContainer .flatpickr-day:hover {
      background-color: ' . $color_theme . ';
    }
    body.white-theme .flatpickr-calendar .flatpickr-innerContainer .flatpickr-rContainer .flatpickr-days .dayContainer .flatpickr-day.startRange {
      background-color: ' . $color_theme . ';
    }
    body.white-theme .flatpickr-calendar .flatpickr-innerContainer .flatpickr-rContainer .flatpickr-days .dayContainer .flatpickr-day.endRange {
      background-color: ' . $color_theme . ';
    }
    body.white-theme .flatpickr-calendar .flatpickr-innerContainer .flatpickr-rContainer .flatpickr-days .dayContainer .flatpickr-day:hover {
      background-color: ' . $color_theme . ';
    }

    body .filter-group .filter-days div:hover {
      color: ' . $color_theme . ';
    }
    
    body .filter-group .filter-days div.active {
      color: ' . $color_theme . ';
    }

    body .hover-bg-theme:hover {
      background-color: ' . $color_theme . ';
    }
    #sidenav .sub-menu .list-sub.active{
      background-color: ' . $color_selected_menu . ' !important;
    }
    #sidenav .sub-menu .list-sub.active svg{
      fill: ' . $color_highlight . ' !important;
    }
    #sidenav .sub-menu .list-sub.active svg path{
      fill: ' . $color_highlight . ' !important;
    }
    #sidenav .sub-menu .list-sub.active svg ellipse{
      fill: ' . $color_highlight . ' !important;
    }
    #sidenav .sub-menu .list-sub.active p{
      color: ' . $color_highlight . ' !important;
    }
    .it-nav-wolves .list.active .icon svg path{
      fill: ' . $color_highlight . ' !important;
    }
    .it-nav-wolves .list.active .name {
      color: ' . $color_highlight . ' !important;
    }
    .it-nav-dinner .list.active{
      border-bottom: 3px solid ' . $color_highlight . ' !important;
    }
    .btn-login{
      background-color: ' . $color_highlight . ' !important;
    }
    </style>';

    return true;
  }

  static function getTheme()
  {
    $theme = isset(static::$initial_data['theme']) ? static::$initial_data['theme'] : false;
    return $theme;
  }

  static function addMenuHiddenFixPermission($user_ids = [], $menu = [])
  {
    $user_info   = F_User::getCurrentUser();
    self::$hidden_menu_user_ids = $user_ids;
    if (in_array($user_info['id'], self::$hidden_menu_user_ids)) {
      self::$hidden_menu = $menu;
    }
  }
  static function rederMenuHiddenFixPermission($code = '')
  {
    $user_info   = F_User::getCurrentUser();
    if (in_array($user_info['id'], self::$hidden_menu_user_ids)) {
      if (self::$hidden_menu) {
        foreach (self::$hidden_menu['sub_menu'] as $key => $sub_menu) {
          if ($code) {
            self::$hidden_menu_permissions[$code . '_' . $sub_menu['page_name']] = 1;
          }
        }
      }
      return self::$hidden_menu;
    }
    return false;
  }
  static function checkHiddenPermission()
  {
    $user_info   = F_User::getCurrentUser();
    if (!in_array($user_info['id'], self::$hidden_menu_user_ids)) {
      Aww::notification('No User Permission', 'error');
      Aww::redirect('../../module_main/login/logout.php');
    }
  }
}



F_WLoves::init();
