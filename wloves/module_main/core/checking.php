<?php
$_PAGE['permission'] = ['core', 'core_dev', 'core_checking'];

require_once '../../.framework/import.php';
Structure::loadModules(['boatnav']);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$menu = isset($_GET['menu']) ? $_GET['menu'] : 1;

$data_nav = [
  'param_name'  => 'page',
  'type' => 'mutiple',
  'title_list' => [
    [
      'title' => 'Program checking',
      'icon'   => '',
      'class' => '',
      'list' => [
        [
          'id'  => 1,
          'name'  => 'File & Server compare',
          'count' => 10
        ],
      ]
    ],
  ]
];
$link = 'checking.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('../../');
  ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php
  include_once '../../structure/layout/header.php';
  include_once '../../structure/layout/sidenav.php';
  ?>

  <div class="form-row mt--20px mx--20px">
    <div class="col-lg-2 col-md-4 p-0">
      <div class="w-loves-card border-radius-0 p-0 h-full-struceture">
        <div class="px-20px py-10px">
          <div class="font-18px font-Bold">Checking</div>
        </div>
        <hr class="my-0">
        <?php Boatnav::wolves($data_nav, $link); ?>
      </div>
    </div>
    <?php
    if ($page == 1) {
      include_once 'checking/file_server_compare.php';
    }
    ?>
  </div>

  <?php
  include_once '../../structure/layout/footer.php';
  Structure::loadFooter('../../');
  ?>

  <script>
    document.getElementById("content-x").style.paddingBottom = "0px";
  </script>
</body>

</html>