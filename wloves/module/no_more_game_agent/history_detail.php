<?php

$_PAGE['permission'] = ['no_more_game_agent', 'agent', 'agent'];
require_once '../../.framework/import.php';
Structure::loadModules(['boatnav']);

$code = $_GET['c'];
$id = $_GET['id'];
$agent_id = $_GET['agent_id'];
$_GET['page'] = 3;
$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

$agent_detail = nga_agent::getAgentByID($code, $agent_id);
if ($_POST) {
  if (isset($_POST['submit_complete_bill'])) {
    $result = nga_agent::setBillComplete($code, $_POST['id']);
  } else if (isset($_POST['submit_cancel_bill'])) {
    $result = nga_agent::setBillCancel($code, $_POST['id']);
  } else if (isset($_POST['submit_restore_bill'])) {
    $result = nga_agent::setBillRestore($code, $_POST['id']);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
};


$com_bill_id = nga_agent::getCommissionBillByID($code, $id);
$com_bill_id['date_data'] = Aww::formatDate($com_bill_id['insert_date_time'], 'd/m/Y');
$status_list = [
  [
    'value' => 'All',
    'text' => 'All'
  ],
  [
    'value' => 'success',
    'text' => 'ได้รับแล้ว'
  ],
  [
    'value' => 'cancel',
    'text' => 'ยกเลิก'
  ],
  [
    'value' => 'waiting',
    'text' => 'รอรับ'
  ],
];

$status = isset($_GET['status']) ? $_GET['status'] : 0;

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
$link = 'agent_detail.php?c=' . $_GET['c'] . '&id=' . $agent_id;

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
      <div class="editable-card-header rounded-0 d-flex justify-content-between p-0 bg-whites nav-lines">
        <?= Boatnav::dinner($data_nav, $link); ?>
      </div>
    </div>
  </div>
  <div class='bg-white mb-15px pb-10px'>
    <div class="d-flex top-tap justify-content-between  pt-10px">
      <div class="msg col-lg-6">
        <div class='topic ml-10px'>
          รายละเอียดประวัติการเงิน | <span class="text-primary"><?= Aww::formatDate($com_bill_id['insert_date_time'], 'd/m/Y'); ?> </span></div>
        <div class="font-14px text-sub ml-10px">
          ประวัติรายการการเงินเอเยนต์
        </div>
      </div>
      <div class="button-panel col-lg-6 d-flex justify-content-end">
        <?php if ($com_bill_id['status'] == 'completed') {  //? 1==success 
        ?>
          <div class="d-flex my-auto px-15px text-waiting">
            <a class="mr-15px ml-5px svg-success text-success"><?= file_get_contents('./assets/icon/icon-status.svg') ?> <span class="pl-5px mt-10px">บิลนี้ชำระเงินเรียบร้อยแล้ว</span></a>
          </div>
          <button class="btn btn-close-modal mx-5px w-140px" disabled> <span class="pr-10px svg-light"><?= file_get_contents('./assets/icon/icon-x.svg') ?></span>ยกเลิกบิล</button>
          <button class="btn btn-close-modal mx-5px w-140px" disabled> <span class="pr-10px svg-light"><?= file_get_contents('./assets/icon/icon-checks.svg') ?></span> ชำระเงินแล้ว</button>
      </div>
    <?php } else if ($com_bill_id['status'] == 'cancel') { //? 2==cancel
    ?>
      <div class="d-flex my-auto px-15px text-waiting">
        <a class="mr-15px ml-5px svg-danger text-danger"><?= file_get_contents('./assets/icon/icon-status.svg') ?> <span class="pl-5px mt-10px">บิลนี้ถูกยกเลิกแล้ว</span></a>
      </div>
      <button <?= Tiwdal::register('restore_bill_modal', $com_bill_id) ?> class="btn btn-close-modal mx-5px w-140px text-blue-4" href="history_detail.php?c=<?= $code ?>"> <span class="pr-10px"><?= file_get_contents('./assets/icon/icon-restore.svg') ?></span>RESTORE</button>
    </div>
  <?php } else { ?>
    <div class="d-flex my-auto px-15px text-waiting">
      <a class="mr-15px ml-5px"><?= file_get_contents('./assets/icon/icon-status.svg') ?></a>
      <span>รอชำระเงิน</span>
    </div>
    <button <?= Tiwdal::register('cancel_bill_modal', $com_bill_id) ?> class="btn btn-danger mx-5px w-140px" href="history_detail.php?c=<?= $code ?>&status=2"> <span class="pr-10px"><?= file_get_contents('./assets/icon/icon-x.svg') ?></span>ยกเลิกบิล</button>
    <button <?= Tiwdal::register('complete_bill_modal', $com_bill_id) ?> class="btn btn-success mx-5px w-140px" href="history_detail.php?c=<?= $code ?>&status=1"> <span class="pr-10px"><?= file_get_contents('./assets/icon/icon-checks.svg') ?></span> ชำระเงินแล้ว</button>
  </div>
<?php }  ?>
</div>
</div>
<div id="agent_history_detail" class="container-pagination bg-white  no-border-radius" <?= Homepagify::createHomepagify('agent_history_detail', '?c=' . $code . '&id=' . $id . '&from_date=' . $from_date . '&to_date=' . $to_date, '', 'รายการการเงิน ') ?>>
  <div class="table-responsive">
    <table class="table table-striped-2">
      <thead>
        <tr>
          <th class="" nowrap>รหัสลูกค้า</th>
          <th class="text-center" nowrap>Turnover</th>
          <th class="text-center" nowrap>Valid turnover</th>
          <th class="text-center " nowrap>Stake count <span class="text-danger">Mockup</span></th>
          <th class=" text-center" nowrap>Gorss commission <span class="text-danger">Mockup</span></th>
          <th class="text-center " nowrap>Lose</th>
          <th class="text-center" nowrap>Lose commission</th>
          <th class="text-center " nowrap>Total</th>
          <th nowrap>Games</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<?php include_once '../../structure/layout/footer.php'; ?>
<?php Structure::loadFooter('../../'); ?>
</body>

</html>

<?php Tiwdal::startModal('complete_bill_modal', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title text-center">ชำระเงิน</h5>
    </div>
    <div class="modal-body">
      <div class="text-center">
        คุณต้องการ <span class="text-success"> "ชำระเงินรายการนี้" </span> ใช่หรือไม่
      </div>
      <div class="text-center">
        ข้อมูลการเงินในวันดังกล่าวจะถูกเคลียร์และโอนย้ายไปยัง "ประวัติการเงิน"
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="{id}">
    <button type="button" class="btn btn-close-modal min-w-80px h-40px" data-dismiss="modal">ยกเลิก</button>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_complete_bill', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-success h-40px',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('cancel_bill_modal', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title text-center">ยกเลิกบิล</h5>
    </div>
    <div class="modal-body">
      <div class="text-center">
        คุณต้องการ <span class="text-danger"> "ยกเลิกบิลนี้"</span> ใช่หรือไม่
      </div>
      <div class="text-center">
        ข้อมูลการเงินในวันดังกล่าวจะถูกยกเลิกและโอนย้ายไปยัง "ประวัติการเงิน"
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="{id}">
    <button type="button" class="btn btn-close-modal min-w-80px h-40px" data-dismiss="modal">ยกเลิก</button>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_cancel_bill', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-danger h-40px',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('restore_bill_modal', 'modal-md'); ?>
<form method="post" class="">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title text-center">เรียกคืนบิล</h5>
    </div>
    <div class="modal-body">
      <div class="text-center">
        คุณต้องการ<span class="text-primary"> "เรียกคืนบิลนี้"</span> ใช่หรือไม่
      </div>
      <div class="text-center">
        ข้อมูลการเงินในวันดังกล่าวจะถูกยกเลิกและโอนย้ายไปยัง "ประวัติการเงิน"
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <input type="hidden" name="{id}">
    <button type="button" class="btn btn-close-modal min-w-80px h-40px" data-dismiss="modal">ยกเลิก</button>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_restore_bill', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary h-40px',], ['text' => 'ยืนยัน']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Aww::loadAsset('assets/js/force_logout.js'); ?>