<?php

$_PAGE['permission'] = ['no_more_game_agent', 'management', 'provider_report'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav']);

$code = $_GET['c'];
$get_data = nga_statistic::getSummaryCreditTransaction($code);
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$chart_labels = [''];
$chart_sum_withdraw = [''];
$chart_sum_deposit = [''];

foreach ($get_data['graph_data'] as $key => $value) {
  array_push($chart_labels, Aww::formatDate($key, 'd/m/Y', true));
  array_push($chart_sum_withdraw, $value['sum_withdraw']);
  array_push($chart_sum_deposit, $value['sum_deposit']);
}
$chart_labels = json_encode($chart_labels);
$chart_sum_withdraw = json_encode($chart_sum_withdraw);
$chart_sum_deposit = json_encode($chart_sum_deposit);

if (isset($_GET['submit_clear_summary'])) {
  $from_date = Util::getSystemDate('-' . 7 . ' days');
  $to_date = Aww::formatDate('', 'Y-m-d');
} else {
  $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : Util::getSystemDate('-' . 7 . ' days');
  $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : Aww::formatDate('', 'Y-m-d');
}

$select_summary_provider =  nga_statement::selectBetHistoryByProductIDDate($code, $from_date, $to_date);

$data_nav = [
  'param_name'  => 'page',
  'class' => 'bg-whites',
  'list' => [
    [
      'id'  => 1,
      'name'  => 'รายการทั้งหมด',
    ],
  ]
];
$link = 'summary_report.php?c=' . $_GET['c'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('../../');
  Aww::loadAsset('assets/css/no_more_gaming.css');
  ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php include_once '../../structure/layout/header-default.php'; ?>

  <div class="editable-card core-new border-radius-bottom-0 ">
    <div class="editable-card-header rounded-0 d-flex justify-content-between p-0 bg-whites nav-lines ">
      <?= Boatnav::dinner($data_nav, $link); ?>
    </div>
  </div>

  <?php
  include 'view/provider/history.php';
  ?>

  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php Structure::loadFooter('../../'); ?>

</body>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>

<script>
  $(document).ready(function() {
    $(document).on('click', '.icon_up_summary', function() {
      $('.summary_event').hide();
      $('.icon_up_summary').hide();
      $('.icon_down_summary').show();
    });

    $(document).on('click', '.icon_down_summary', function() {
      $('.summary_event').show();
      $('.icon_down_summary').hide();
      $('.icon_up_summary').show();
    });

    $(document).on('click', '.icon_up_filter', function() {
      $('.filter_event').hide();
      $('.icon_up_filter').hide();
      $('.icon_down_filter').show();
      $('.date_filter').show();
    });

    $(document).on('click', '.icon_down_filter', function() {
      $('.filter_event').show();
      $('.icon_down_filter').hide();
      $('.icon_up_filter').show();
      $('.date_filter').hide();
    });
  });

  $(document).on('click', '.evnet_clear_search', function() {
    $('.scope_btn_clear_search').click();
  });
</script>



</html>