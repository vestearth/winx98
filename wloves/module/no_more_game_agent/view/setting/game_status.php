<?php
$type = isset($_GET['type']) ? $_GET['type'] : '';

if ($_POST) {
  if (isset($_POST['submit_swap_list'])) {
    $current_id = $_POST['id'];
    $move_to_id = $_POST['move_to_id'];
    $result = nga_management::swapSortProduct($code, $current_id, $move_to_id);
  }
  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}


$game_status = nga_management::getGameActiveStatus($code);

$list_games = [
  [
    'id' => 'CARD',
    'name' => 'เปิดไพ่',
    'status' => $game_status['is_open_card_game'] ? true : false,
    'count' => $game_status['card_count'],
    'key' => 'is_open_card_game'
  ],
  [
    'id' => 'BOARD',
    'name' => 'บอร์ดเกม',
    'status' => $game_status['is_open_board_game'] ? true : false,
    'count' => $game_status['board_count'],
    'key' => 'is_open_board_game'
  ],
  [
    'id' => 'SLOT',
    'name' => 'สล็อตเสี่ยงโชค',
    'status' => $game_status['is_open_slot_game'] ? true : false,
    'count' => $game_status['slot_count'],
    'key' => 'is_open_slot_game'
  ],
  [
    'id' => 'ARCADE',
    'name' => 'ตู้เกม Arcade',
    'status' => $game_status['is_open_arcade_game'] ? true : false,
    'count' => $game_status['arcade_count'],
    'key' => 'is_open_arcade_game'
  ],
  [
    'id' => 'CASINOLIVE',
    'name' => 'คาสิโน',
    'status' => $game_status['is_open_casinolive_game'] ? true : false,
    'count' => $game_status['casinolive_count'],
    'key' => 'is_open_casinolive_game'
  ],
  [
    'id' => 'FISHING',
    'name' => 'เกมตกปลา',
    'status' => $game_status['is_open_fishing_game'] ? true : false,
    'count' => $game_status['fishing_count'],
    'key' => 'is_open_fishing_game'
  ],
  [
    'id' => 'SPORT',
    'name' => 'ไก่ชน',
    'status' => $game_status['is_open_sport_game'] ? true : false,
    'count' => $game_status['sport_count'],
    'key' => 'is_open_sport_game'
  ],
  [
    'id' => 'SPORTBOOK',
    'name' => 'เกมกีฬา',
    'status' => $game_status['is_open_sportbook'] ? true : false,
    'count' => 1,
    'key' => 'is_open_sportbook'
  ],
  [
    'id' => 'LOTTO',
    'name' => 'หวย',
    'status' => $game_status['is_open_lotto'] ? true : false,
    'count' => 1,
    'key' => 'is_open_lotto'
  ],
];

if ($type) {
  $type_games = nga_management::getProductIDByGameType($code, $type);
}

?>


<div class="d-flex align-items-center justify-content-between my-5px mx-15px">
  <div class="mb-5px">
    <div class="font-18px text-info font-SemiBold">ตั้งค่าเกม
    </div>
    <div class="font-15px text-secondary">จัดการ เปิด / ปิด การทำงานของเกมที่เชื่อมต่อกับเว็บไซต์</div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6">
    <div class="table-responsive">
      <table class="table table-custom-gray">
        <thead>
          <tr>
            <td>หมวดหมู่เกม</td>
            <td class="thin-cell">จำนวนค่ายเกม</td>
            <td class="thin-cell">การใช้งาน</td>
            <td class="thin-cell"></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($list_games as $key => $game) { ?>
            <tr class="<?= $type == $game['id'] ? 'active' : '' ?>">
              <td class="pl-15px font-SemiBold"><?= $game['name'] ?></td>
              <td class="text-right"><?= $game['count'] ?></td>
              <td class="text-right">
                <?php
                $api = [
                  'api' => 'nga_management::updateGameActiveStatus',
                  'params' => [
                    'code' => $_GET['c'],
                    'data' => [
                      $game['key'] => '{' . $game['key'] . '}',
                    ]
                  ]
                ];
                $option_live = [
                  'type' => 1,
                  'is_on_off' => 1
                ];
                ?>
                <?php
                TiwForm::liveForm('checkbox', $game['key'], $game['status'], $api, $option_live);
                ?>
              </td>
              <td>
                <?php if ($game['count'] > 1) { ?>
                  <a href="?c=<?= $_GET['c'] ?>&type=<?= $game['id']  ?>">
                    <?= file_get_contents('assets/icon/icon-arrow-right.svg') ?>
                  </a>
                <?php } else { ?>
                  <div style="height:40px"></div>
                <?php } ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php if ($type && $type_games) { ?>
    <div class="col-lg-6">
      <div class="table-responsive">
        <table class="table table-custom-gray table-list-swap">
          <thead>
            <tr>
              <td colspan="2">จัดเรียงลำดับค่ายเกม</td>
            </tr>
          <tbody>
            <?php
            $type_games_count = count($type_games);
            foreach ($type_games as $key => $type) {
              $up_id = '';
              $down_id = '';
              if (isset($type_games[($key - 1)]['id'])) {
                $up_id = $type_games[($key - 1)]['id'];
              }
              if (isset($type_games[($key + 1)]['id'])) {
                $down_id = $type_games[($key + 1)]['id'];
              }
            ?>
              <tr>
                <td class="thin-cell">
                  <div class="d-flex align-items-center mr-10px">
                    <form method="post">
                      <input type="hidden" name="id" value="<?= $type['id'] ?>">
                      <input type="hidden" name="move_to_id" value="<?= $down_id ?>">
                      <button type="submit" name="submit_swap_list" class="btn p-0 border-0 shadow-none" <?= ($key + 1) == $type_games_count ? 'disabled' : '' ?>>
                        <?= file_get_contents('assets/icon/icon-down.svg') ?>
                      </button>
                    </form>
                    <form method="post">
                      <input type="hidden" name="id">
                      <input type="hidden" name="id" value="<?= $type['id'] ?>">
                      <input type="hidden" name="move_to_id" value="<?= $up_id ?>">
                      <button type="submit" name="submit_swap_list" class="btn p-0 border-0 shadow-none" <?= $key == 0 ? 'disabled' : '' ?>>
                        <?= file_get_contents('assets/icon/icon-up.svg') ?>
                      </button>
                    </form>
                  </div>
                </td>
                <td class="font-SemiBold"><?= $type['product_id'] ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php } ?>
</div>

<?php /*
<div class="editable-card core-new border-radius-0 " style="min-height: calc(100vh - 135px);">
  <div class="table-responsive">
    <table class="table table-form ">
      <thead class="">
        <tr>
          <th class="text-secondary font-Medium border-0">เกม</th>
          <th class="text-secondary font-Medium border-0">สถานะเปิดการใช้งาน</th>
          <th class="text-secondary font-Medium border-0">เกม</th>
          <th class="text-secondary font-Medium border-0">สถานะเปิดการใช้งาน</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="font-SemiBold">เปิดไพ่</td>
          <td class="text-primary font-Medium border-right-1px">
            <?php
            $api = [
              'api' => 'nga_management::updateGameActiveStatus',
              'params' => [
                'code' => $_GET['c'],
                'data' => [
                  'name' => '{is_open_card_game}',
                ]
              ]
            ];
            $option_live = [
              'type' => 1,
              'is_on_off' => 1
            ];
            ?>
            <?php
            $api['params']['data'] = [
              'is_open_card_game' => '{is_open_card_game}',
            ];
            TiwForm::liveForm('checkbox', 'is_open_card_game', $card_check, $api, $option_live);
            ?>
            <!-- <span class="ml-10px">เปิดใช้งาน</span> -->
          </td>
          <td class="font-SemiBold">บอร์ดเกม</td>
          <td class="text-primary font-Medium">
            <?php
            $api['params']['data'] = [
              'is_open_board_game' => '{is_open_board_game}',
            ];
            TiwForm::liveForm('checkbox', 'is_open_board_game', $board_check, $api, $option_live);
            ?>
          </td>
        </tr>
        <tr>
          <td class="font-SemiBold">สล็อตเสี่ยงโชค</td>
          <td class="text-primary font-Medium">
            <?php
            $api['params']['data'] = [
              'is_open_slot_game' => '{is_open_slot_game}',
            ];
            TiwForm::liveForm('checkbox', 'is_open_slot_game', $slot_check, $api, $option_live);
            ?>
          </td>
          <td class="font-SemiBold">ตู้เกม Arcade</td>
          <td class="text-primary font-Medium">
            <?php
            $api['params']['data'] = [
              'is_open_arcade_game' => '{is_open_arcade_game}',
            ];
            TiwForm::liveForm('checkbox', 'is_open_arcade_game', $arcade_check, $api, $option_live);
            ?>
          </td>
        </tr>
        <tr>
          <td class="font-SemiBold">คาสิโน</td>
          <td class="text-primary font-Medium">
            <?php
            $api['params']['data'] = [
              'is_open_casinolive_game' => '{is_open_casinolive_game}',
            ];
            TiwForm::liveForm('checkbox', 'is_open_casinolive_game', $casino_live_check, $api, $option_live);
            ?>
          </td>
          <td class="font-SemiBold">เกมตกปลา</td>
          <td class="text-primary font-Medium">
            <?php
            $api['params']['data'] = [
              'is_open_fishing_game' => '{is_open_fishing_game}',
            ];
            TiwForm::liveForm('checkbox', 'is_open_fishing_game', $fishing_check, $api, $option_live);
            ?>
          </td>
        </tr>
        <tr>
          <td class="font-SemiBold">เกมกีฬา</td>
          <td class="text-primary font-Medium">
            <?php
            $api['params']['data'] = [
              'is_open_sport_game' => '{is_open_sport_game}',
            ];
            TiwForm::liveForm('checkbox', 'is_open_sport_game', $sport_check, $api, $option_live);
            ?>
          </td>
          <td></td>
          <td></td>
        </tr>
      </tbody>

    </table>
  </div>
</div>

 */ ?>