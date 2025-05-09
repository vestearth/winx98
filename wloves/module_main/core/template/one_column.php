<?php
$_PAGE['permission'] = ['core', 'core_template', 'core_template_1'];

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
    <div class="col-12">
      <div class="topic-page">
        <div class="topic-page-name">
          <h3>topic </h3>
          <span>Sub topic</span>
        </div>
        <div>
          <button class="btn btn-primary"> button </button>
        </div>
      </div>

      <div class="w-loves-card">
        <div class="w-loves-card-header">
          <h3>Product List</h3>
          <p> List of sub categories you've added. </p>
        </div>
      </div>
    </div>
  </div>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>
</body>

</html>