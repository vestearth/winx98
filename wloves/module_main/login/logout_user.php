<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../.framework/import.php';
User::logout();

Aww::redirect('index.php');
