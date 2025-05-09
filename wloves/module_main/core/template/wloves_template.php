<?php
  $_PAGE['permission'] = ['core', 'core_template', 'core_template_4'];
  require_once '../../.framework/import.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php Structure::loadMeta('../../');?>
</head>

<body class="<?=Structure::getThemeClass();?>">
  <?php include_once '../../structure/layout/header-default.php';?>

  <h1>Code Here!</h1>

  <?php
    include_once '../../structure/layout/footer.php';
    Structure::loadFooter('../../');
  ?>
</body>

</html>