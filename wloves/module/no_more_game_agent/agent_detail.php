<?php

$_PAGE['permission'] = ['no_more_game_agent', 'agent', 'agent'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav']);
$code = $_GET['c'];
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$id = isset($_GET['id']) ? $_GET['id'] : Aww::redirect('agent.php?c=' . $code);

if ($_POST) {
  if (isset($_POST['submit_clear_bill'])) {
    $result = nga_agent::addNewCommissionBill($code, $_POST['form_date_data'], $_POST['to_date_data'], $id);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};

// Call API 
$agent_detail = nga_agent::getAgentByID($code, $id);

function phase_2($msg1, $num_range, $msg2, $class1 = 'font-Medium text-grey', $class2 = '', $class = '')
{
  $num = (12 - $num_range);
  echo  '<div class="form-row py-5px font-14px ' . $class . '">
  <div class="col-lg-' . $num_range . ' ' . $class1 . '">
  ' . $msg1 . '
  </div>
  <div class="col-lg-' . $num . ' ' . $class2 . ' ">
  ' . $msg2 . '
  </div>
  </div>';
}
// Top header nav 
$data_nav = [
  'param_name'  => 'page',
  'class' => 'bg-whites',
  'list' => [
    [
      'id'  => 1,
      'name'  => 'ข้อมูลเอเยนต์',
    ],
    [
      'id'  => 2,
      'name'  => 'สรุปยอด แพ้/ชนะ เอเยนต์',
    ],
    [
      'id'  => 3,
      'name'  => 'ประวัติการเงิน',
    ],
  ]
];
$link = 'agent_detail.php?c=' . $_GET['c'] . '&id=' . $id;

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
  <div class="font-14px px-15px py-10px bg-grey">
    <a href="agent.php?c=<?= $code; ?>" class="text-grey"> เอเยนต์ </a> | <span class="text-primary"> <?= $agent_detail['agent_name']; ?></span>
  </div>
  <div class="bg-whites pt-10px">
    <div class="editable-card core-new border-radius-bottom-0 ">
      <div class="editable-card-header rounded-0 d-flex justify-content-between p-0 bg-whites nav-lines ">
        <?= Boatnav::dinner($data_nav, $link); ?>
      </div>
    </div>
  </div>

  <?php
  if ($page == 1) {
    include 'view/agent/agent_details.php';
  } else if ($page == 2) {
    include 'view/agent/result_loss_start.php';
  } else if ($page == 3) {
    include 'view/agent/history.php';
  }
  ?>


  <?php include_once '../../structure/layout/footer.php'; ?>
  <?php 
  Structure::loadFooter('../../'); 
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

</body>

</html>