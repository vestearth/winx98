<?php
$_PAGE['permission'] = ['no_more_game_agent', 'monthly_report', 'agent_monthly'];
require_once '../../../.framework/import.php';
Structure::loadMetaForAjax('../../../');
$code = $_GET['c'];
$where = [
  'agent_name' => $_POST['agent_name'],
  'agent_url' => $_POST['agent_url'],
];
$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = nmg_agent::selectAgent($code, $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) { ?>
    <tr class="">
      <td nowrap>
        <div class=" d-flex align-items-baseline">
          <div class="mr-10px profile-agent-img">
            <!-- <img src="./assets/icon/icon-flrst-class.svg"> -->
            <img src="<?= $data['img']; ?>">
          </div>
          <div class="font-16px font-SemiBold">
            <?= $data['agent_name']; ?>
          </div>
        </div>
      </td>
      <td nowrap class="disabled-link">
        <div class=" font-16px font-Regular">
          <a href="<?= $data['agent_url']; ?>"><u><?= $data['agent_url']; ?></u></a>
        </div>
      </td>
      <td nowrap align="">
        <div class="font-16px font-Regular">
          <?php
          $month = Aww::formatDate('', 'm');
          ?>
          <?= Aww::formatMonthNameTH($month) . ', ' . Aww::formatDate('', 'Y'); ?>
        </div>
      </td>
      <td nowrap class=" font-16px font-Regular"><?= number_format($data['sum_lose'], 2); ?></td>
      <td align="" nowrap class="font-16px font-Regular">
        <span class="text-success">จ่ายแล้ว</span>
        <span class="text-danger">ยังไม่ได้จ่าย</span>
      </td>
      <td align="" nowrap class=" font-16px"><?= Aww::formatDate('', 'd/m/Y, H:i') ?></td>
      <td align="" nowrap class=" font-16px">
        ระบบ / Admin
      </td>
      <td align="" nowrap class="font-16px">
        <a href="#"><u>ยอดสลิป.jpg</u></a>
      </td>
      <td class="thin-cell">
        <button class="form-btn btn-success" <?php Tiwdal::register('confirm_paid', $data) ?>>
          จ่ายแล้ว
        </button>
      </td>
    </tr>
  <?php
  }
  ?>
</tbody>