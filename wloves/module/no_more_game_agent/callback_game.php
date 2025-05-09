<?php
$_WLOVES['no_check_permission'] = 1;
require_once '../../.framework/import.php';

$code = 'uwklw';
$raw_data = file_get_contents('php://input');
$data = json_decode($raw_data);
$result = nga_api::callBackFromGame($code, $data);
die();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('../../');
  // Aww::loadAsset('assets/css/no_more_gaming.css');
  ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php //include_once '../../structure/layout/header-default.php';
  ?>

  <?php //include_once '../../structure/layout/footer.php'; 
  ?>
  <?php Structure::loadFooter('../../'); ?>

</body>

</html>