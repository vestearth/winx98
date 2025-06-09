<?php
$bank_config = Bank::select();
$options_bank = [
  'list' => [],
];
foreach ($bank_config as $key => $data) {
  $options_bank['list'][] = [
    'value' => $data['abb'],
    'name' => $data['name_th'],
    'img' => $data['image'],
  ];
}

?>
<form method="post">
  <div class="form-group">
    <label for="username"><?= Ty::get('Phonenumber') ?></label>
    <div class="input-icon user">
      <input type="hidden" name="ref_id" value="<?= $ref_id; ?>">
      <input type="hidden" name="ref_marketing" value="<?= $ref_marketing; ?>">
      <input type="hidden" name="ref" value="<?= $upline_no; ?>">
      <input
        type="text"
        inputmode="numeric"
        pattern="(06|08|09)\d{8}"
        name="username"
        id="username"
        maxlength="10"
        value="<?= $data_username ?>"
        class="form-input-custom"
        placeholder="<?= Ty::get('loginwphonenumb') ?>"
        required
        oninput="handlePhoneInput(this)">
    </div>
  </div>
  <div class=" form-group">
    <label for="password"><?= Ty::get('Password') ?></label>
    <div class="input-icon password">
      <input
        type="password"
        name="password"
        id="password"
        class="form-input-custom"
        placeholder="<?= Ty::get('pass_fill', [], ["case" => "ucfirst"]) ?>"
        required
        inputmode="numeric"
        pattern="\d*">
    </div>
  </div>
  <div class="form-group">
    <label for="bank"><?= Ty::get('bank', [], ["case" => "ucfirst"]) ?></label>
    <div class="input-icon bank">
      <select name="bank_id" class="bank event_select_bank empty" data-show-content="true" required>
        <option value="" selected><?= Ty::get('bank_select') ?></option>
        <?php foreach ($options_bank['list'] as $bank) { ?>
          <option value="<?= $bank['value'] ?>" data-img="<?= htmlspecialchars($bank['img']) ?>">
            <?= $bank['name'] ?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="bank_name"><?= "ชื่อ (ที่ผูกกับธนาคาร) "; ?></label>
    <div class="input-icon user-contact">
      <input type="text" name="bank_name" id="bank_name" value="" class="form-input-custom" placeholder="<?= "กรอกชื่อบัญชี" ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="bank_name2"><?= "นามสกุล (ที่ผูกกับธนาคาร) "; ?></label>
    <div class="input-icon user-contact">
      <input type="text" name="bank_name2" id="bank_name2" value="" class="form-input-custom" placeholder="<?= "กรอกนามสกุลบัญชี" ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="account"><?= Ty::get('acc_numb', [], ["case" => "ucfirst"]) ?></label>
    <div class="input-icon account">
      <input type="number" name="bank_account" id="account" class="form-input-custom" placeholder="<?= Ty::get('accnumb_fill') ?>" required>
    </div>
  </div>
  <div class="form-group">
    <label for="account"><?= 'Line ID'; ?></label>
    <div class="input-icon line">
      <input type="text" name="bank_account" id="account" class="form-input-custom" placeholder="<?= 'กรอก Line ID'; ?>" required>
    </div>
  </div>
  <!-- 
  <div class="form-group">
    <label for="upline_member_code"><? // "ผู้แนะนำ"; 
                                    ?></label>
    <div class="input-icon aff">
      <input type="text" name="upline_member_code" id="affiliate" value="" class="form-input-custom" placeholder="<?= "กรอกรหัสผู้แนะนำหากมี" ?>">
    </div>
  </div> -->
  <div class="group-btn">
    <button type="submit" name="submit_register" class="btn btn-sub w-100">
      <?= "ยืนยันบัญชี"; ?>
    </button>
  </div>
  <div class="group-btn mt-10px">
    <a href="login.php" class="btn btn-cancel w-100">
      <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
    </a>
  </div>
</form>

<script>
  function handlePhoneInput(el) {
    el.value = el.value.replace(/\D/g, ''); // Only digits

    // Check if valid format
    const isValidPhone = /^(06|08|09)\d{8}$/.test(el.value);

    if (isValidPhone) {
      document.getElementById('password').focus();
    }
  }
  document.getElementById('password').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, ''); // Remove all non-digits
  });

  $(function() {
    var $select = $('select.bank');
    // Hide original select
    $select.hide();

    // Build custom dropdown
    var $custom = $('<div class="custom-bank-select"></div>');
    var $selected = $('<div class="selected-bank" style="background: rgba(0, 0, 0, 0.5); cursor:pointer;border:1px solid #FC8181;padding:8px;border-radius:4px;width:100%;color:#FFFFFF; padding: 11px 0 10px 5px;"></div>');
    var $dropdown = $('<div class="bank-dropdown" style="display:none;position:absolute;z-index:1000;background:#5D5D5D;border:1px solid #ccc;border-radius:4px;max-height:200px;overflow:auto;"></div>');

    function renderSelected() {
      var $opt = $select.find('option:selected');
      var img = $opt.data('img');
      var name = $opt.text();
      $selected.empty();
      var $container = $('<div style="display:flex;align-items:center; margin-left: 45px;"></div>');
      if (img) {
        $container.append('<img class="bank-option-img" src="' + img + '" alt="">');
      }
      $container.append($('<span>').text(name));
      $selected.append($container);
    }

    function renderDropdown() {
      $dropdown.empty();
      $select.find('option').each(function() {
        var $opt = $(this);
        var img = $opt.data('img');
        var name = $opt.text();
        var value = $opt.val();
        var $item = $('<div style="padding:8px;cursor:pointer;display:flex;align-items:center;"></div>');
        if (img) {
          $item.append('<img class="bank-option-img" src="' + img + '" alt="">');
        }
        $item.append($('<span>').text(name));
        $item.data('value', value);
        if ($opt.is(':selected')) $item.css('background', '#343434');
        $item.on('click', function() {
          $select.val(value).trigger('change');
          $dropdown.hide();
          renderSelected();
        });
        $dropdown.append($item);
      });
    }

    $selected.on('click', function(e) {
      e.stopPropagation();
      $('.bank-dropdown').hide();
      renderDropdown();
      $dropdown.toggle();
    });

    $(document).on('click', function() {
      $dropdown.hide();
    });

    $select.after($custom);
    $custom.append($selected).append($dropdown);
    renderSelected();

    $select.on('change', renderSelected);
  });

  $(document).ready(function() {
    $('#username').on('input', function() {
      var input = $(this).val();
      if (input.length === 1 && input !== '0') {
        $(this).val('0');
      }
      var submitBtn = $('.btn-sub');
      if (input.length > 0 && input[0] !== '0') {
        submitBtn.prop('disabled', true);
      } else {
        submitBtn.prop('disabled', false);
      }
    });
  });
</script>