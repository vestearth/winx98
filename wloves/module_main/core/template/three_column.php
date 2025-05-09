<?php
$_PAGE['permission'] = ['core', 'core_template', 'core_template_3'];

require_once '../../.framework/import.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php Structure::loadMeta('../../'); ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php include_once '../../structure/layout/header-default.php'; ?>

  <div class="form-row">
    <div class="col-lg-2 mt-10px">
      <div class="w-loves-card-header">
        <h3>Product List</h3>
        <p> List of sub categories you've added. </p>
      </div>
      <div class="menu-sub-category">
        <h3>main</h3>
        <a href="?c" class="sub-topic-items main-topic filter-menu-items active">
          <span class="sub-topic-title">
            name
          </span>
        </a>
      </div>
    </div>
    <div class="col-lg-2">
      <div class="w-loves-card mt-10px">
        <div class="w-loves-card-header">
          <h3>Product List</h3>
          <p> List of sub categories you've added. </p>
        </div>
        <div class="menu-sub-category">
          <h3>category</h3>
          <a href="?c" class="sub-topic-items filter-menu-items active">
            <span class="sub-topic-title">
              name
            </span>
          </a>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="w-loves-card mt-10px">
      </div>
    </div>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>

</html>