<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../../.framework/import.php';

$is_mini = (isset($_POST['is_mini']) && ($_POST['is_mini'] == 'true')) ? 1 : 0;
Aww::cookie('_menu_style', $is_mini);
