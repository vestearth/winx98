<?php
if ($data_username) {
  $result_otp = nga_user::requestTelOtp($code, $data_username);
  $original_otp = md5($result_otp['response_data']['otp']);
} else {
  if ($ref_id_link) {
    Aww::redirect('signup.php?step=1&ref=' . $ref_id_link);
  } else if ($ref_market) {
    Aww::redirect('signup.php?step=1&ref_m=' . $ref_market);
  } else {
    Aww::redirect('signup.php?step=1');
  }
}
?>
<form action="signup.php?step=2" method="post">
  <div class="form-group">
    <label for="username"><?= Ty::get('Phonenumber') ?></label>
    <div class="input-icon user">
      <input type="hidden" name="ref" value="<?= $upline_no; ?>">
      <input type="hidden" name="ref_id" value="<?= $ref_id_link; ?>">
      <input type="hidden" name="ref_marketing" value="<?= $ref_market; ?>">
      <input type="text" name="username" id="username" value="<?= $data_username ?>" class="form-input-custom" placeholder="<?= Ty::get('loginwphonenumb') ?>" required readonly>
      <input type="hidden" name="origin_otp" value="<?= $original_otp; ?>">
    </div>
  </div>

  <div class="mng-form-group-otp">
    <div class="form-title"><?= Ty::get('verify_otp') ?></div>
    <div class="form-input-group scope_input_otp">
      <input type="number" name="otp[]" maxlength="1" placeholder="." required class="event_input_otp" autofocus>
      <input type="number" name="otp[]" maxlength="1" placeholder="." required class="event_input_otp">
      <input type="number" name="otp[]" maxlength="1" placeholder="." required class="event_input_otp">
      <input type="number" name="otp[]" maxlength="1" placeholder="." required class="event_input_otp">
      <input type="number" name="otp[]" maxlength="1" placeholder="." required class="event_input_otp">
      <input type="number" name="otp[]" maxlength="1" placeholder="." required class="event_input_otp">
    </div>
  </div>
  <div class="text-pink-2 my-3">
    <?= Ty::get('note', [], ["case" => "ucfirst"]) ?> : <?= Ty::get('fewmins_otp') ?>
  </div>
  <div class="group-btn">
    <a href="login.php" class="btn btn-cancel">
      <?= Ty::get('back', [], ["case" => "ucfirst"]) ?>
    </a>
    <button type="submit" class="btn btn-sub arrow">
      <?= Ty::get('next') ?>
    </button>
  </div>
</form>

<script>
  $(function() {
    // $(document).on('click', '.event_btn_back', function() {
    //   $('#scope_signup_form').attr('action', 'signup.php?step=1');
    //   $('#scope_signup_form').submit();
    // });

    $(document).on('keyup', '.event_input_otp', function(e) {
      var otp = $(this).val();
      var otp_chars = otp.split('');
      if (otp.length == 1) {
        // input 1 digit
        if ($(this).next().length) {
          $(this).next().select();
        } else {
          $(this).blur();
        }
      } else if (otp.length > 0) {
        // ctrl + v
        var char_1 = otp_chars[0] ? otp_chars[0] : '';
        var char_2 = otp_chars[1] ? otp_chars[1] : '';
        var char_3 = otp_chars[2] ? otp_chars[2] : '';
        var char_4 = otp_chars[3] ? otp_chars[3] : '';
        var char_5 = otp_chars[4] ? otp_chars[4] : '';
        var char_6 = otp_chars[5] ? otp_chars[5] : '';
        $($('.scope_input_otp input')[0]).val(char_1);
        $($('.scope_input_otp input')[1]).val(char_2);
        $($('.scope_input_otp input')[2]).val(char_3);
        $($('.scope_input_otp input')[3]).val(char_4);
        $($('.scope_input_otp input')[4]).val(char_5);
        $($('.scope_input_otp input')[5]).val(char_6);
        $(this).blur();
      } else if (e.keyCode == 8) {
        // backspace
        if ($(this).prev().length) {
          $(this).val('').prev().select();
        } else {
          $(this).val('').focus();
        }
      }
    });
    $(document).on('click', '.event_input_otp', function(e) {
      $(this).select();
    });
  });
</script>