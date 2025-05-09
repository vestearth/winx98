<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../../.framework/import.php';

$code = isset($_POST['code']) ? $_POST['code'] : '';

$favorite = Aww::cookie('_page_favorite');
$favorite = $favorite ? json_decode($favorite, true) : [];

unset($favorite[$code]);

Aww::cookie('_page_favorite', json_encode($favorite));
