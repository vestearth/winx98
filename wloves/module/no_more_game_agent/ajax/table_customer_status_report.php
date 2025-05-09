<?php
$_PAGE['permission'] = ['no_more_game_agent', 'admin', 'credit_discount'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];

$where = [
  'last_active' => isset($_POST['last_active']) ? $_POST['last_active'] : '',
  'day_diff' => isset($_POST['day_diff']) ? $_POST['day_diff'] : '',
  'username' => isset($_POST['username']) ? $_POST['username'] : '',
  'bank_number' => isset($_POST['bank_number']) ? $_POST['bank_number'] : '',
  'is_deactivate' => isset($_POST['is_deactivate']) ? $_POST['is_deactivate'] : '',
];

if ($_POST['is_deactivate'] == 'all') {
  unset($where['is_deactivate']);
}
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];
$select = nga_user::selectUserStatus($code, $where, $options);

?>
<tbody data-total_count="<?= $select['total_count'] ?>">
  <?php foreach ($select['list'] as $value) { ?>
    <tr>
      <td nowrap>
        <?= Aww::formatDate($value['last_active'], 'd/m/Y'); ?>
      </td>
      <td nowrap class="">
        <?= number_format($value['day_diff']) . ' วัน' ?>
      </td>
      <td nowrap><?= hidePhoneNumber($value['username']) ?></td>
      <td nowrap class="">
        <div class="d-flex">
          <div class="w-30px">
            <img src="<?= $value['bank_image'] ?>" class="w-100 border-radius-50px">
          </div>
          <div class="pl-5px">
            <p class="mb-0"><?= $value['bank_name_th'] ?></p>
            <p class="mb-0"><?= $value['bank_number'] ?></p>
            <p class="mb-0"><?= $value['bank_name'] ?></p>
          </div>
        </div>
      </td>
      <td nowrap class="thin-cell">
        <?php if ($value['is_deactivate']) { ?>
          <div class="d-flex justify-content-center align-items-center">
            <span class="ml-5px text-danger">ไม่ได้ใช้งาน</span>
          </div>
        <?php } else { ?>
          <div class="d-flex justify-content-center align-items-center">
            <span class="ml-5px text-primary">ใช้งาน</span>
          </div>
        <?php } ?>
      </td>

      <td class="thin-cell">
        <?php if ($value['is_deactivate']) { ?>
          <div class="m-5px cursor-pointer" <?= Tiwdal::register('activate_user_modal', $value); ?>>
            <div class="active-btn">
              <img src="assets/icon/status_off.svg" class="img-responsive">
            </div>
          </div>
        <?php } else { ?>
          <div class="m-5px cursor-pointer" <?= Tiwdal::register('deactivate_user_modal', $value); ?>>
            <div class="active-btn">
              <img src="assets/icon/status_on.svg" class="img-responsive">
            </div>
          </div>
        <?php } ?>
      </td>
    </tr>
  <?php } ?>
</tbody>