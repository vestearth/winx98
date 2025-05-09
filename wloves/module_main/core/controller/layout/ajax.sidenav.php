<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../../../.framework/import.php';
$data_wloves = WLoves::getInitialData();
$data_wloves_theme = $data_wloves['program'];

$color['white'] = [
  'bg-color' => '#EEEEED',
  'bg-card' => '#FBFBFB',
  'bg-card-optional-1' => '#D5D5D5',
  'bg-card-optional-2' => '#DEDEDE',
  'bg-card-navbar' => '#E6E6E6',
  'bg-card-back' => '#DADEE3',
  'bg-table' => '#F7F7F7',
  'bg-table-hover' => '#E6E6E6',
  'bg-hover-optional-1' => '#F5F5F5',
  'bg-hover-optional-2' => '#EAEAEA',
  'color-line' => '#DADEE3',
  'color-field' => '#D0D6DD',
  'color-field-active' => '#5C9CFF',
  'color-info' => '#3A4248',
  'color-secondary' => '#58606E',
  'color-place-holder' => '#9CA2A8',
  'color-primary' => '#3E88FB',
  'color-success' => '#0BAA22',
  'color-warning' => '#FFBD3A',
  'color-danger' => '#FE635B',
  'color-light' => '#E6E6E6',
  'color-dark' => '#000000',
  'color-sub-table' => '#F2F2F2',
  'color-active-table' => '#DAE7FB',
  'color-search-border' => '#CED2D5',
  'color-highlight' => $_POST['color_highlight'],
  'bg-nav' => $_POST['bg_nav'],
  'color-hover-nav' => $_POST['color_hover_nav'],
  'color-icon-text' => $_POST['color_icon_text'],
  'color-dark-or-light' => '#ffffff',
];
$color['dark'] = [
  'bg-color' => '#232B32',
  'bg-card' => '#2E373D',
  'bg-card-optional-1' => '#1B2126',
  'bg-card-optional-2' => '#282E33',
  'bg-card-navbar' => '#3A4248',
  'bg-card-back' => '#2A3238',
  'bg-table' => '#2E373D',
  'bg-table-hover' => '#3A4248',
  'bg-hover-optional-1' => '#1B2126',
  'bg-hover-optional-2' => '#1B2126',
  'color-line' => '#2A3238',
  'color-field' => '#454C52',
  'color-field-active' => '#89B3F7',
  'color-info' => '#DADBE0',
  'color-secondary' => '#A5AABE',
  'color-place-holder' => '#778396',
  'color-primary' => '#3E88FB',
  'color-success' => '#31C947',
  'color-warning' => '#FFBD3A',
  'color-danger' => '#FE635B',
  'color-light' => '#3A4248',
  'color-dark' => '#FFFFFF',
  'color-sub-table' => '#3A4248',
  'color-active-table' => '#354d70',
  'color-search-border' => '#CED2D5',
  'color-highlight' => $_POST['color_highlight'],
  'bg-nav' => $_POST['bg_nav'],
  'color-hover-nav' => $_POST['color_hover_nav'],
  'color-icon-text' => $_POST['color_icon_text'],
  'color-dark-or-light' => '#000000',
];
if (isset($_POST['submit_read_notification'])) {
  header('Content-Type: application/json');
  $api_result = Notification::read(F_User::getCurrentUserID(), 'user');
  echo json_encode($api_result);
} else if (isset($_POST['submit_toggle_theme'])) {
  header('Content-Type: application/json');
  $theme = ($_POST['theme'] == 'dark') ? 'dark' : 'white';
  // $api_result = WLoves::setTheme($theme);
  // css color
  $myfile = fopen("../../../../.framework/core/css/theme.css", "w") or die("Unable to open file!");
  $css_color = ":root {\n";
  foreach ($color[$theme] as $key => $value) {
    $css_color .= " --" . $key . ": " . $value . ";\n";
  }
  $css_color .= "}";

  fwrite($myfile, $css_color);
  fclose($myfile);
}
