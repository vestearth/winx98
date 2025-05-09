<?php
$_PAGE['permission'] = ['no_more_game_agent', 'management', 'system_database'];
$prefix = '../../../';
require_once $prefix . '.framework/import.php';
Structure::loadMetaForAjax($prefix);
$code = $_GET['c'];

$where = [
  'user_type_id' => 1,
  'full_name' => $_POST['full_name'],
  'username' => $_POST['username'],
];

$options = [
  'total_count' => true,
  'page_no'     => $_POST['page_no'],
  'page_size'   => $_POST['page_size'],
  'sort'        => isset($_POST['data_sort']) ? $_POST['data_sort'] : []
];

$data_list = User::selectUser('dvjdb', $where, $options);
$list = isset($data_list['list']) ? $data_list['list'] : [];
$total_count = isset($data_list['total_count']) ? $data_list['total_count'] : 0;
?>
<tbody data-total_count="<?= $total_count; ?>">
  <?php
  foreach ($list as $data) {
  ?>
    <tr>
      <td class="font-15px font-Medium" nowrap><?= $data['full_name']; ?></td>
      <td class="font-15px font-Medium" nowrap><?= $data['username']; ?></td>
      <td nowrap class="thin-cell py-5px">
        <div class="d-flex align-items-center">
          <?php
          $api = [
            'api' => 'User::updateUser',
            'params' => [
              'id' => $data['id'],
              'data' => [
                'is_permission_god_link' => '{is_permission_god_link}',
              ]
            ]
          ];
          $optional = [
            'type' => 1,
            'is_on_off' =>  1,
          ];

          TiwForm::liveForm('checkbox', 'is_permission_god_link', $data['is_permission_god_link'], $api, $optional);
          ?>
        </div>
      </td>
    </tr>
  <?php } ?>
</tbody>