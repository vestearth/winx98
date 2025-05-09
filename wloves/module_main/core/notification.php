<?php
$_WLOVES['no_check_permission'] = 1;
$_PAGE['permission']            = ['index', '', 'notification'];

require '../../.framework/import.php';
Structure::loadModules(['datatables']);
$notifications = (F_WLoves::$notification['notifications']) ? F_WLoves::$notification['notifications'] : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php Structure::loadMeta('../../'); ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php include '../../structure/layout/header-default.php'; ?>

  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="w-love-table-header-container">
          <div class="w-love-table-header-wrap">
            <div class="table-header-detail-group">
              <h3>Notification</h3>
            </div>
          </div>
        </div>
        <div class="w-data-table-container">
          <table class="table w-data-table w-table-exportable" data-scrollY="100%" data-scrollX="100%" data-exportable-type="colvis,excel" data-orders="[3,'desc']">
            <thead>
              <tr>
                <th class="thin-cell no-sort" nowrap>Topic</th>
                <th class="no-sort" nowrap>Description</th>
                <th class="no-sort" nowrap>Link</th>
                <th class="thin-cell no-sort" nowrap>Date</th>
                <th class="thin-cell no-sort" nowrap></th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($notifications as $idx => $data) {
              ?>
                <tr>
                  <td nowrap>
                    <?= $data['topic']; ?>
                  </td>
                  <td nowrap>
                    <?= $data['description']; ?>
                  </td>
                  <td nowrap>
                    <?= $data['link']; ?>
                  </td>
                  <td data-sort="<?= strtotime($data['insert_date_time']); ?>" nowrap>
                    <small><?= Aww::formatDate($data['insert_date_time'], 'd/m/Y H:i:a'); ?></small>
                  </td>
                  <td>
                    <?= ($data['is_read']) ? 'Read' : ''; ?>
                  </td>
                </tr>
              <?php
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php
  include '../../structure/layout/footer.php';
  Structure::loadFooter("../../");
  ?>
</body>

</html>