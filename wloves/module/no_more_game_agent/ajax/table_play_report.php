<?php
$_PAGE['permission'] = ['no_more_game_agent', 'summary_stats', 'play_report'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];
