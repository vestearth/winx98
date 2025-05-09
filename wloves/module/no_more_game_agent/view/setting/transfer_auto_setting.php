<?php
$type_deposit_auto_options = [
  'list' => [
    [
      'value' => 'to_bank_account',
      'name' => 'โอนไปยังบัญชี',
    ],
    [
      'value' => 'to_bot_account',
      'name' => 'โอนไปยังกลุ่ม BOT',
    ],
  ],
];

$deposit_condition_options = [
  'list' => [
    [
      'value' => 'balance',
      'name' => 'เมื่อถึงยอดที่กำหนด',
    ],
    [
      'value' => 'time',
      'name' => 'เมื่อถึงเวลาที่กำหนด',
    ],
  ],
];

$select_bot_auto_transfer =   nga_management_bot::selectBotGroup($code, ['is_open' => 1]);

$bot_auto_transfer_key = [
  'value' => 'id',
  'name' => 'bot_name',
  'img' => 'bank_image',
];
$bot_auto_transfer_options = TiwForm::generateSelectData($select_bot_auto_transfer, $bot_auto_transfer_key, []);

$bank = Bank::select();
$bank_list['list'] = [];
foreach ($bank as $bank_data) {
  $bank_list['list'][] = [
    'value' => $bank_data['abb'],
    'name' => $bank_data['name_th'],
    'img' => $bank_data['image'],
  ];
}

$select_bot_auto_transfer = nga_management::selectBotAutoTransfer($code);

$count_bot_auto_transaction = nga_management::countBotAutoTransfer($code);
?>
<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">ตั้งค่าการโอนอัตโนมัติ (<?= number_format($count_bot_auto_transaction['count_list']) ?>)
    </div>
    <div class="font-15px text-secondary">จัดการตั้งค่าการโอนอัตโนมัติ</div>
  </div>
  <?php TiwForm::normal('btn', '', ['name' => '', 'class' => 'h-40px'], ['type' => 'button', 'text' => '+ เพิ่มการโอนอัตโนมัติ', 'modal_id' => 'modal_add_auto_transfer', 'modal_data' => '']); ?>
</div>

<div class="mb-5px mx-15px">
  <div class="form-row">
    <?php
    foreach ($select_bot_auto_transfer as $val) {
      if ($val['transfer_condition'] == 'time') {
        $val['modal_condition_msg'] = 'โอนเมื่อถึงเวลา';
        $val['modal_condition_result'] = Aww::formatDate($val['transfer_condition_time'], 'H:i') . 'น. <span class="text-info"> (ของทุกวัน) </span>';
      } else {
        $val['modal_condition_msg'] = 'โอนเมื่อมียอดฝากเกิน (฿)';
        $val['modal_condition_result'] = number_format($val['transfer_condition_amount'], 2);
      }
      $val['modal_to_bank_img'] = ($val['transfer_type'] == 'to_bank_account') ? $val['to_bank_image'] : $val['to_bot_bank_image'];
      $val['modal_to_bank_name_th'] = ($val['transfer_type'] == 'to_bank_account') ? $val['to_bank_name_th'] : $val['to_bot_bank_name_th'];
      $val['modal_to_bank_name'] = ($val['transfer_type'] == 'to_bank_account') ? $val['to_bank_name'] : $val['to_bot_bank_account_name'];
      $val['modal_to_bank_no'] = ($val['transfer_type'] == 'to_bank_account') ? $val['to_bank_no'] : $val['to_bot_bank_account_no'];
    ?>
      <div class="col-6">
        <div class="editable-card p-15px mb-15px">
          <div class="form-row border-bottom-1px pb-10px mb-10px">
            <div class="col-5">
              <div class="w-100">
                <div class="d-flex flex-column">
                  <img src="<?= $val['from_bank_image'] ?>" class="w-50px mb-15px border-radius-10px">
                  <p class="mb-0 font-14px"><?= $val['from_bank_name_th'] ?></p>
                  <p class="mb-0 font-14px"><?= $val['from_bot_bank_account_name'] ?></p>
                  <p class="mb-0 font-Bold font-14px"><?= $val['from_bot_bank_account_no'] ?></p>
                </div>
              </div>
            </div>
            <div class="col-2">
              <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                <?= file_get_contents('assets/icon/full_arrow_right.svg') ?>
              </div>
            </div>
            <div class="col-5">
              <div class="w-100">
                <div class="d-flex flex-column">
                  <img src="<?= $val['modal_to_bank_img'] ?>" class="w-50px mb-15px border-radius-10px">
                  <p class="mb-0 font-14px"><?= $val['modal_to_bank_name_th'] ?></p>
                  <p class="mb-0 font-14px"><?= $val['modal_to_bank_name'] ?></p>
                  <p class="mb-0 font-Bold font-14px"><?= $val['modal_to_bank_no'] ?></p>
                </div>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-6 align-self-center">
              <p class="mb-0 font-16px font-Bold"><?= $val['modal_condition_msg'] ?></p>
            </div>
            <div class="col-6">
              <div class="d-flex align-items-center justify-content-end">
                <p class="mb-0 font-16px text-primary font-Bold mr-10px"><?= $val['modal_condition_result'] ?></p>
                <div class="box-icon-custom" <?= Tiwdal::register('modal_delete', $val); ?>>
                  <?= file_get_contents('assets/icon/icon-delete.svg') ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<?php Tiwdal::startModal('modal_add_auto_transfer', 'modal-md'); ?>
<form method="post">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">×</span>
  </button>
  <div class="modal-header">
    <h5 class="modal-title text-uppercase">เพิ่มการโอนอัตโนมัติ</h5>
  </div>
  <div class="modal-body">
    <div class="form-group mt-10px">
      <div class="form-row align-items-center">
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            ประเภทการโอน<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('select', '', ['name' => 'transfer_type', 'required' => 'true', 'class' => 'event_type_deposit_auto'], $type_deposit_auto_options); ?>
          </div>
        </div>
        <div class="col-lg-12 pb-15px">
          <i class="font-14px font-Bold">บัญชีต้นทาง</i>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            กลุ่ม BOT<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('select-img', '', ['name' => '', 'class' => 'event_group_bot_1', 'required' => 'true'], $bot_auto_transfer_options); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            บัญชีธนาคาร<span class=" text-danger">*</span>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium scope_bank_from_bot_1">
            <?php TiwForm::normal('select', '', ['name' => 'from_bot_group_list_id', 'required' => 'true'], ['list' => []]); ?>
          </div>
        </div>
        <div class="col-lg-12 pb-15px">
          <i class="font-14px font-Bold">บัญชีปลายทาง</i>
        </div>
        <div class="scope_form_deposit_to col-12">
          <div class="form-row">
            <div class="col-lg-3">
              <div class=" font-14px font-Medium mb-10px py-5px">
                ธนาคาร<span class=" text-danger">*</span>
              </div>
            </div>
            <div class="col-lg-9">
              <div class="ml-5px font-16px font-Medium">
                <?php TiwForm::normal('select-img', '', ['name' => 'to_bank_abb', 'required' => 'true'], $bank_list); ?>
              </div>
            </div>
            <div class="col-lg-3">
              <div class=" font-14px font-Medium mb-10px py-5px">
                เลขที่บัญชี<span class=" text-danger">*</span>
              </div>
            </div>
            <div class="col-lg-9">
              <div class="ml-5px font-16px font-Medium">
                <?php TiwForm::normal('number', '', ['name' => 'to_bank_no', 'required' => 'true']); ?>
              </div>
            </div>
            <div class="col-lg-3">
              <div class=" font-14px font-Medium mb-10px py-5px">
                ชื่อบัญชี
              </div>
            </div>
            <div class="col-lg-9">
              <div class="ml-5px font-16px font-Medium">
                <?php TiwForm::normal('text', '', ['name' => 'to_bank_name']); ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12 pb-15px">
          <i class="font-14px font-Bold">เงื่อนไขการโอน</i>
        </div>
        <div class="col-lg-3">
          <div class=" font-14px font-Medium mb-10px py-5px">
            เงื่อนไข
          </div>
        </div>
        <div class="col-lg-9">
          <div class="ml-5px font-16px font-Medium">
            <?php TiwForm::normal('select', '', ['name' => 'transfer_condition', 'required' => 'true', 'class' => 'event_auto_deposit_conditon'], $deposit_condition_options); ?>
          </div>
        </div>
        <div class="col-lg-3">
          <p class="mb-0 scope_title_condition">เมื่อมียอดเงินคงเหลือเกิน</p>
        </div>
        <div class="col-lg-9">
          <div class="form-row">
            <div class="col-12">
              <div class="scope_input_condition">
                <div class="d-flex align-items-center">
                  <?= TiwForm::normal('number', '', ['name' => 'transfer_condition_amount']); ?> <span class="ml-5px font-12px text-nowrap">บาท ยอดเงินคงเหลือจะถูกโอนออกอัตโนมัติ</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer justify-content-end">
    <?= TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn btn-cancels min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก']); ?>
    <?= TiwForm::normal('btn', '', ['name' => 'submit_add_auto_transfer', 'type' => 'submit', 'class' => 'm-5px min-w-120px btn btn-primary',], ['text' => 'บันทึก']); ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>

<?php Tiwdal::startModal('modal_delete', 'modal-md'); ?>
<form method="post">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
  <div class="modal-header d-flex justify-content-center">
    <h5 class="modal-title">ลบการโอนอัตโนมัติ</h5>
  </div>
  <div class="modal-body">
    <div class="form-row mb-15px">
      <div class="col-12">
        <p class="mb-0 font-14px text-center text-secondary">คุณต้องการลบการโอนอัตโนมัติ</p>
      </div>
    </div>
    <div class="px-50px">
      <div class="form-row pb-10px mb-10px">
        <div class="col-5 d-flex justify-content-end">
          <div class="">
            <div class="d-flex flex-column">
              <img src="assets/image/placeholder_square.jpg" name="{from_bank_image}" class="w-50px mb-15px border-radius-10px">
              <span class="mb-0 font-14px" name="{from_bank_name_th}"></span>
              <span class="mb-0 font-14px" name="{from_bot_bank_account_name}"></span>
              <span class="mb-0 font-Bold font-14px" name="{from_bot_bank_account_no}"></span>
            </div>
          </div>
        </div>
        <div class="col-2">
          <div class="w-100 h-100 d-flex align-items-center justify-content-center">
            <?= file_get_contents('assets/icon/full_arrow_right.svg') ?>
          </div>
        </div>
        <div class="col-5">
          <div class="w-100">
            <div class="d-flex flex-column">
              <img src="assets/image/placeholder_square.jpg" name="{modal_to_bank_img}" class="w-50px mb-15px border-radius-10px">
              <span class="mb-0 font-14px" name="{modal_to_bank_name_th}"></span>
              <span class="mb-0 font-14px" name="{modal_to_bank_name}"></span>
              <span class="mb-0 font-Bold font-14px" name="{modal_to_bank_no}"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col-12 text-center">
        <p class="mb-0 text-secondary font-14px"> ที่มีเงื่อนไขการ<span name="{modal_condition_msg}"></span> <span class="text-danger" name="{modal_condition_result}"></span> ใช่หรือไม่?</p>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php
    TiwForm::normal('btn', '', ['name' => '', 'type' => 'button', 'class' => 'btn-close-modal min-w-90px', 'data-dismiss' => 'modal'], ['text' => 'ยกเลิก', 'type' => '']);
    TiwForm::normal('btn', '', ['name' => 'submit_delete_auto_transfer', 'type' => 'submit', 'class' => 'btn-danger min-w-120px'], ['text' => 'ยืนยัน', 'type' => '']);
    ?>
  </div>
  <input type="hidden" name="{id}">
</form>
<?php Tiwdal::endModal() ?>

<div class="scope_clone d-none">
  <div class="scope_clone_condition_amount">
    <div class="d-flex align-items-center">
      <?= TiwForm::normal('number', '', ['name' => 'transfer_condition_amount']); ?> <span class="ml-5px font-12px text-nowrap">บาท ยอดเงินคงเหลือจะถูกโอนออกอัตโนมัติ</span>
    </div>
  </div>
  <div class="scope_clone_condition_time">
    <div class="d-flex align-items-center">
      <?= TiwForm::normal('time', '', ['name' => 'transfer_condition_time']); ?> <span class="ml-5px font-12px text-nowrap">ของทุกวัน ก่อนเวลา 23:50 ยอดเงินคงเหลือจะถูกโอนออกอัตโนมัติ</span>
    </div>
  </div>
  <div class="scope_clone_form_deposit_customer">
    <div class="form-row">
      <div class="col-lg-3">
        <div class=" font-14px font-Medium mb-10px py-5px">
          ธนาคาร<span class=" text-danger">*</span>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="ml-5px font-16px font-Medium">
          <?php TiwForm::normal('select-img', '', ['name' => 'to_bank_abb', 'required' => 'true'], $bank_list); ?>
        </div>
      </div>
      <div class="col-lg-3">
        <div class=" font-14px font-Medium mb-10px py-5px">
          เลขที่บัญชี<span class=" text-danger">*</span>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="ml-5px font-16px font-Medium">
          <?php TiwForm::normal('number', '', ['name' => 'to_bank_no', 'required' => 'true']); ?>
        </div>
      </div>
      <div class="col-lg-3">
        <div class=" font-14px font-Medium mb-10px py-5px">
          ชื่อบัญชี
        </div>
      </div>
      <div class="col-lg-9">
        <div class="ml-5px font-16px font-Medium">
          <?php TiwForm::normal('text', '', ['name' => 'to_bank_name', 'required' => 'true']); ?>
        </div>
      </div>
    </div>
  </div>
  <div class="scope_clone_form_deposit_bot">
    <div class="form-row">
      <div class="col-lg-3">
        <div class=" font-14px font-Medium mb-10px py-5px">
          กลุ่ม BOT<span class=" text-danger">*</span>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="ml-5px font-16px font-Medium">
          <?php TiwForm::normal('select-img', '', ['name' => 'bank', 'required' => 'true', 'class' => 'event_group_bot_2'], $bot_auto_transfer_options); ?>
        </div>
      </div>
      <div class="col-lg-3">
        <div class=" font-14px font-Medium mb-10px py-5px">
          บัญชีธนาคาร<span class=" text-danger">*</span>
        </div>
      </div>
      <div class="col-lg-9">
        <div class="ml-5px font-16px font-Medium scope_bank_from_bot_2">
          <?php TiwForm::normal('select', '', ['name' => 'to_bot_group_list_id', 'required' => 'true'], ['list' => []]); ?>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).on('change', '.event_auto_deposit_conditon', function() {
    var val = $(this).val();
    if (val == 'balance') {
      $('.scope_title_condition').text('เมื่อมียอดเงินคงเหลือเกิน');
      var clone = $('.scope_clone').find('.scope_clone_condition_amount').html();
    } else if (val == 'time') {
      $('.scope_title_condition').text('เมื่อถึงเวลา');
      var clone = $('.scope_clone').find('.scope_clone_condition_time').html();
    }
    $('.scope_input_condition').html(clone);
  });

  $(document).on('change', '.event_type_deposit_auto', function() {
    var val = $(this).val();
    if (val == 'to_bank_account') {
      var clone = $('.scope_clone').find('.scope_clone_form_deposit_customer').html();
    } else if (val == 'to_bot_account') {
      var clone = $('.scope_clone').find('.scope_clone_form_deposit_bot').html();
    }
    $('.scope_form_deposit_to').html(clone);
  });

  $(document).on('change', '.event_group_bot_1 input', function() {
    var val = $(this).val();
    var params = {
      code: '<?= $code; ?>',
      id: val,
      name: 'from_bot_group_list_id'
    };
    $.post('ajax/ajax_select_bot_bank_select.php', params)
      .done(function(data) {
        $('.scope_bank_from_bot_1').html(data)
      })
  });

  $(document).on('change', '.event_group_bot_2 input', function() {
    var val = $(this).val();
    var params = {
      code: '<?= $code; ?>',
      id: val,
      name: 'to_bot_group_list_id'
    };
    $.post('ajax/ajax_select_bot_bank_select.php', params)
      .done(function(data) {
        $('.scope_bank_from_bot_2').html(data)
      })
  });
</script>