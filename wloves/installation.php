<?php
$_WLOVES['no_check_permission'] = 1;
// require_once '.framework/import.php';

$checkConfigFolder = 0;
$checkConfigTemplateFile = 0;
$checkConfigOutputFile = 0;
$checkResourceFolder = 0;

if (file_exists('../system/installation.php')) {

  require_once '../system/installation.php';
  require_once '.framework/import.php';

  if (Installation::checkConfigFolder($root_path)) {
    $checkConfigFolder = 1;
  }
  if (Installation::checkConfigTemplateFile($root_path)) {
    $checkConfigTemplateFile = 1;
  }
  if (Installation::checkConfigOutputFile($root_path)) {
    $checkConfigOutputFile = 1;
  }
  if (Installation::checkResourceFolder($root_path)) {
    $checkResourceFolder = 1;
  }

  if (!Installation::hasConfigFile($root_path)) {
    // echo 'โหลดตั้งค่า';
    // Aww::redirect('');
    if (isset($_POST['db_server'])) {
      $result = run_installation($_POST);
      if (isset($result['result'])) {
        if ($result['result'] == 'ERROR') {
          Aww::notification($result['message'], 'error');
          Aww::redirect('');
        } else {
          Aww::redirect('index.php?result=ready');
        }
      } else {
        // echo 'Result ไม่ถูกต้อง';
        // die();
        Aww::notification('Result ไม่ถูกต้อง', 'error');
        Aww::redirect('');
      }
    }
  }
  else {
    Aww::redirect('index.php?result=ready');
  }

} 
else {
  echo 'Not Found "system/installation.php"';
  die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php Structure::loadMeta(); ?>
</head>

<body class="white">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-4 p-0">
        <div class="install-group-left"> 
          <div class="install-logo mb-10px">
            <img src="structure/image/logo/logo-install.svg" alt="">
          </div>
          <div class="title-main mb-25px">
            <h5 class="mb-0">WLOVES INSTALLATION</h5>
            <p class="mb-0">BY WLOVES GROUP</p>
          </div>
          <div class="title-menu mb-20px">
            MAIN CONFIGURE
          </div>
          <div class="sub-menu file mb-15px">
            <span class="mr-5px">FILE PERMISSION</span>
            <?=file_get_contents('structure/image/icon/checkmark.svg');?>
          </div>
          <div class="sub-menu database mb-15px">
            <span class="mr-5px">DATABASE CONECTION</span>
            <?=file_get_contents('structure/image/icon/checkmark.svg');?>
          </div>
          <div class="sub-menu guardian mb-15px">
            <span class="mr-5px">SET GUARDIAN</span>
            <?=file_get_contents('structure/image/icon/checkmark.svg');?>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-md-8">
        <form method="post">
          <div class="p-20px">
            <div class="install-group-right">
              <div class="header">
                <h5 class="mb-0">WLOVES INSTALLATIOPN</h5>
                <p class="mb-0">SET DATABASE CONNECTION AND PROGRAMGUARDIAN</p>
              </div>
              <hr class="hr-install">
              <div class="body">
                <div class="sub-header mb-10px">
                  <h5 class="mb-0">FILE PERMISSION</h5>
                </div>
                <div class="form-row install-form">
                  <div class="col-lg-12">
                    <div class="permission-file permission-file-group <?=($checkConfigFolder) ? 'active' : ''?>">
                      <div class="icon-chmod mr-5px mb-5px">
                        <div class="false">
                          <img src="structure/image/icon/icon-chmod-false.svg" alt="">
                        </div>
                        <div class="true">
                          <img src="structure/image/icon/icon-chmod-true.svg" alt="">
                        </div>
                      </div>
                      <span class="font-14px font-SemiBold text-check-active">chmod folder /system/config to 777</span>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="permission-file permission-file-group <?=($checkConfigOutputFile) ? 'active' : ''?>">
                      <div class="icon-chmod mr-5px mb-5px">
                        <div class="false">
                          <img src="structure/image/icon/icon-chmod-false.svg" alt="">
                        </div>
                        <div class="true">
                          <img src="structure/image/icon/icon-chmod-true.svg" alt="">
                        </div>
                      </div>
                      <span class="font-14px font-SemiBold text-check-active">chmod file /system/config/config_output.php to 777</span>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="permission-file permission-file-group <?=($checkConfigTemplateFile) ? 'active' : ''?>">
                      <div class="icon-chmod mr-5px mb-5px">
                        <div class="false">
                          <img src="structure/image/icon/icon-chmod-false.svg" alt="">
                        </div>
                        <div class="true">
                          <img src="structure/image/icon/icon-chmod-true.svg" alt="">
                        </div>
                      </div>
                      <span class="font-14px font-SemiBold text-check-active">chmod file /system/config/config_template.php to777</span>
                    </div>
                  </div>
                  <div class="col-lg-12">
                    <div class="permission-file permission-file-group <?=($checkResourceFolder) ? 'active' : ''?>">
                      <div class="icon-chmod mr-5px mb-5px">
                        <div class="false">
                          <img src="structure/image/icon/icon-chmod-false.svg" alt="">
                        </div>
                        <div class="true">
                          <img src="structure/image/icon/icon-chmod-true.svg" alt="">
                        </div>
                      </div>
                      <span class="font-14px font-SemiBold text-check-active">chmod Folder /system/resource/file to 777</span>
                    </div>
                  </div>
                </div>
              </div>
              <hr class="hr-install dash">
              <div class="body">
                <div class="sub-header mb-25px">
                  <h5 class="mb-0">DATABASE CONNECTION</h5>
                </div>
                <div class="form-row install-form">
                  <div class="col-lg-4">
                    <label>DATABASE TYPE</label>
                  </div>
                  <div class="col-lg-8">
                    <p>MySQL</p>
                  </div>
                  <div class="col-lg-4">
                    <label>DATABASE SERVER</label>
                  </div>
                  <div class="col-lg-8">
                    <?=TiwForm::normal('text', '', ['name' => 'db_server', 'placeholder' => 'Enter', 'class' => 'progress-database']);?>
                  </div>
                  <div class="col-lg-4">
                    <label>DATABASE USERNAME</label>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-row">
                      <div class="col-6">
                        <?=TiwForm::normal('text', '', ['name' => 'db_username', 'placeholder' => 'Enter', 'class' => 'progress-database']);?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>DATABASE PASSWORD</label>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-row">
                      <div class="col-6">
                        <?=TiwForm::normal('text', '', ['name' => 'db_password', 'placeholder' => 'Enter', 'class' => 'progress-database']);?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>DATABASE NAME</label>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-row">
                      <div class="col-6">
                        <?=TiwForm::normal('text', '', ['name' => 'db_name', 'placeholder' => 'Enter', 'class' => 'progress-database']);?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>DATABASE PORT</label>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-row">
                      <div class="col-3">
                        <?=TiwForm::normal('text', '', ['name' => 'db_port', 'placeholder' => 'Enter', 'class' => 'progress-database']);?>
                      </div>
                      <div class="col">
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4"></div>
                  <div class="col-lg-8">
                    <button type="button" class="btn btn-outline-secondary check_install" >TEST CONNECTION</button>
                  </div>
                  <div class="col-lg-4"></div>
                  <div class="col-lg-8">
                    <span class="text-alert font-14px font-weight-normal mb-10px hidden">Something wrong. Please recheck server connection again. </span>
                    <span class="text-success font-14px font-weight-normal mb-10px hidden">Connected</span>
                  </div>
                </div>
              </div>
              <hr class="hr-install dash">
              <div class="body">
                <div class="sub-header mb-25px">
                  <h5 class="mb-0">PROGRAM GUARDIAN | <span>This data can’t Edit after generate program. Please take some note or remember to your heart.</span></h5>
                </div>
                <div class="form-row install-form">
                  <div class="col-lg-4">
                    <label>USERNAME</label>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-row">
                      <div class="col-6">
                        <?=TiwForm::normal('text', '', ['name' => 'admin_id', 'placeholder' => 'Enter', 'class' => 'progress-guardian']);?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>PASSWORD</label>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-row">
                      <div class="col-6">
                        <?=TiwForm::normal('text', '', ['name' => 'admin_pw', 'placeholder' => 'Enter', 'class' => 'progress-guardian']);?>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <label>CONFIRM PASSWORD</label>
                  </div>
                  <div class="col-lg-8">
                    <div class="form-row">
                      <div class="col-6">
                        <?=TiwForm::normal('text', '', ['name' => 'admin_pw_con', 'placeholder' => 'Enter password again.', 'class' => 'progress-guardian']);?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="px-20px">
            <div class="install-group-bottom">
              <div class="group-title">
                <h5 class="mb-0">Generate Program</h5>
                <p class="mb-0">Make Sure your data before click “Generate Program” if you make it while confused or funny you will be lay off.</p>
              </div>
              <input type="hidden" name="db_type" value="mysql">
              <button type="submit" class="btn btn-check-generate btn-outline-secondary" disabled>GENERATE PROGRAM</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    var progress_database = $('.progress-database');
    progress(progress_database);

    $('.progress-database').on('click change keyup mouseup', function (e) {
      var progress_database = $('.progress-database');
      progress(progress_database);
    });

    function progress(read_progress) {
      var number_value = 0;
      for (let index = 0; index < read_progress.length; index++) {
        (read_progress[index].value) ? number_value++ : '';
      }
      var sum_progress = number_value * 100 / read_progress.length;
      if (sum_progress >= 100) {
        $('.database').addClass('active');
      } else {
        $('.database').removeClass('active');
      }
    }
    
    var progress_guardian = $('.progress-guardian');
    progressGuardian(progress_guardian);

    $('.progress-guardian').on('click change keyup mouseup', function (e) {
      var progress_guardian = $('.progress-guardian');
      progressGuardian(progress_guardian);
    });

    function progressGuardian(read_progress) {
      var number_value = 0;
      for (let index = 0; index < read_progress.length; index++) {
        (read_progress[index].value) ? number_value++ : '';
      }
      var sum_progress = number_value * 100 / read_progress.length;
      if (sum_progress >= 100) {
        $('.guardian').addClass('active');
      } else {
        $('.guardian').removeClass('active');
      }
    }

    $(document).on('click', '.check_install', function() {
      var db_server = $('input[name="db_server"]').val();
      var db_name = $('input[name="db_name"]').val();
      var db_username = $('input[name="db_username"]').val();
      var db_password = $('input[name="db_password"]').val();
      var db_port = $('input[name="db_port"]').val();

      var url = 'ajax_check_connect_install.php';
      var params = {
        'db_server': db_server,
        'db_name': db_name,
        'db_username': db_username,
        'db_password': db_password,
        'db_port': db_port,
      };
      $.post(url, params).done(function(data) {
        var permission_file_group = $('.permission-file-group');
        if (data == 'success') {
          $('.text-success').removeClass('hidden');
          $('.text-alert').addClass('hidden');
          $('.btn-check-generate').removeClass('btn-outline-secondary').addClass('btn-outline-primary');
          $('.btn-check-generate').prop('disabled', false);
          progressFile(permission_file_group);
        } else {
          $('.text-alert').removeClass('hidden');
          $('.text-success').addClass('hidden');
          $('.btn-check-generate').removeClass('btn-outline-primary').addClass('btn-outline-secondary');
          $('.btn-check-generate').prop('disabled', true);
          // progressFile(permission_file_group);
        }
      })
    });

    var permission_file = $('.permission-file');
    progressPermission(permission_file);

    function progressPermission(read_progress) {
      var number_value = 0;
      for (let index = 0; index < read_progress.length; index++) {
        // (read_progress[index].value) ? number_value++ : '';
        if ($(read_progress[index]).hasClass('active')) {
          number_value++
        }
      }
      var sum_progress = number_value * 100 / read_progress.length;
      if (sum_progress >= 100) {
        $('.file').addClass('active');
      } else {
        $('.file').removeClass('active');
      }
    }

    function progressFile(read_progress) {
      var number_value = 0;
      for (let index = 0; index < read_progress.length; index++) {
        // (read_progress[index].value) ? number_value++ : '';
        if ($(read_progress[index]).hasClass('active')) {
          number_value++
        }
      }
      var sum_progress = number_value * 100 / read_progress.length;
      if (sum_progress >= 100) {
        $('.btn-check-generate').prop('disabled', false);
      } else {
        $('.btn-check-generate').removeClass('btn-outline-primary').addClass('btn-outline-secondary');
        $('.btn-check-generate').prop('disabled', true);
      }
    }
 
  </script>
  
  <?php
  include 'structure/layout/footer.php';
  Structure::loadFooter();
  ?>
</body>

</html>