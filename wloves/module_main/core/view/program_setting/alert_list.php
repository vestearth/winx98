<div class="col-lg-10">
  <div class="editable-card core-new p-15px">
    <div class="header">
      <h5 class="mb-0">ALERT LISTS</h5>
      <p class="mb-0">Please check to complete all list for perfect program.</p>
    </div>
    <hr class="hr-install mx--15px">
    <div class="master-form-body-wrap">
      <div class="master-form-items form-row">
        <div class="col-12 align-self-center">
          <?php if (!$is_error['is_exists']) {
            echo file_get_contents('../../structure/image/icon/general/alert_false.svg');
          } else {
            echo file_get_contents('../../structure/image/icon/general/alert_true.svg');
          } ?>
          <span class="font-weight-bold text-secondary ml-10px">หา folder 'system/resource/file' ไม่พบ ระบบจะไม่สามารถอัพ image / file ต่างๆ ขึ้นระบบได้</span>
        </div>
      </div>

      <div class="master-form-items form-row">
        <div class="col-12 align-self-center">
          <?php if (!$is_error['is_writable']) {
            echo file_get_contents('../../structure/image/icon/general/alert_false.svg');
          } else {
            echo file_get_contents('../../structure/image/icon/general/alert_true.svg');
          } ?>
          <span class="font-weight-bold text-secondary ml-10px">folder 'system/resource/file' permission ไม่ใช่ 777 ผู้ใช้ทั่วไปจะไม่สามารถอัพ image / file ต่างๆ ขึ้นระบบได้</span>
        </div>
      </div>
      <hr class="hr-install mx--15px">
      <div class="config-domain-log p-0">
        <?php
        $domain_name = (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') ? 'https://' : 'http://';
        $domain_name .= $_SERVER['SERVER_NAME'];
        $config_domain = F_BRIDGE_API_URL ? explode("/system/", F_BRIDGE_API_URL)[0] : '';
        $is_verify = ($domain_name != $config_domain) ? '<span class="text-danger">โดเมนไม่ตรงกัน</span>' : '<span class="text-success">โดเมนตรงกัน</span>';
        ?>
        <div class="font-14px text-secondary font-SemiBold">CONFIG DOMAIN</div>
        <div class="mb-15px text-info"><?= $config_domain ?></div>
        <div class="font-14px text-secondary font-SemiBold">WEBSITE DOMAIN</div>
        <div class="mb-15px text-info"><?= $domain_name ?></div>
        <div class="d-flex align-items-center">
          <div class="status-config-domain-img">
            <div class="img mr-10px">
              <img src="../../structure/image/etc/<?= ($domain_name == $config_domain) ? 'correct.gif' : 'wrong.gif'; ?>" alt="">
            </div>
          </div>
          <div class="verify-detail mb-20px">
            <span class="font-14px text-secondary"></span>
            <?= $is_verify ?>
          </div>
        </div>

        <a href="download/config.text" class="btn-download-config btn_download_config_event btn-primary" target="_blank" download="config.php">ดาวน์โหลดไฟล์ Config.php</a>
        <div class="text-danger font-14px mt-10px">หมายเหตุ<br>- แนะนำให้โหลดจาก Server<br>- Permission ใน module_main/core/<u>download</u> ต้องเป็น <u>777</u></div>
      </div>
    </div>
  </div>
</div>