<?php
require_once '.framework/import.php';
$page = '';
$is_failed = '';
$event_id = (isset($_GET['id'])) ? $_GET['id'] : '';

function writeNumber($number)
{
  $number_arr = preg_split('//', $number, -1, PREG_SPLIT_NO_EMPTY);
  $html = '';
  foreach ($number_arr as $value) {
    $html .= '<img class="number" src="assets/images/game_daily_deposit/' . $value . '.png">';
  }
  echo $html;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  ?>
</head>

<body class="pos-rel">
  <?php
  if ($is_login) {
    $user_data = User::getCurrent();
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้ากิจกรรมฝากประจำ',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $event_data = nga_management::getEventDepositByID($code, $event_id);
    $event_day_list = nga_user::getUserEventDatelist($code, $user_data['id'], $event_id);

    $stack_day = [];
    $stack_7_day = [];
    $today = date('Y-m-d');
    // $today = '2022-12-10';
    foreach ($event_day_list as $key => $day_data) {
      $count = count($stack_day);
      $count_7_day = count($stack_7_day);
      if ($event_data['event_type'] == 'long_term') {
        if ($day_data['is_pass_condition']) {
          $stack_day[] = $day_data['date'];
        } else {
          $stack_day[] = '';
        }
      } else {
        if ($day_data['is_pass_condition']) {
          $stack_day[] = $day_data['date'];
          if (strtotime($day_data['date']) <= strtotime($today)) {
            $stack_7_day[] = $day_data['date'];
          }
        } else {
          $stack_day[] = '';
          if (strtotime($day_data['date']) < strtotime($today)) {
            $stack_7_day = [];
          }
        }
      }
    }
    if ($event_data['event_type'] == 'long_term') {
      if (date('t', strtotime($event_data['from_date_time'])) == 31) {

        $current_date = date('d');
        foreach ($event_day_list as $key => $value) {
          if ($current_date != 1) {
            $compare_date = date('d', strtotime($value['date']));
            if ($compare_date < $current_date) {
              if (!$value['is_pass_condition']) {
                $is_failed = 'is_failed';
              }
            }
          }
        }
      } else if (date('t', strtotime($event_data['from_date_time'])) <= 30) {
        if (date('d') != 1) {
          foreach ($event_day_list as $key => $value) {
            if (!$value['is_pass_condition']) {
              $is_failed = 'is_failed';
            }
          }
        }
      }
    } else {
      $count_day = count($stack_7_day);


      $to_date_plus_7 = date('Y-m-d', strtotime($event_data['to_date_time'] . ' - 6 days'));
      $diff = date_diff(date_create($today), date_create($event_data['to_date_time']));
      $day_remain = $diff->format("%a");
      if (strtotime($to_date_plus_7) < strtotime($today)) {
        if ($count_day < 7 && $day_remain + $count_day < 7) {
          $is_failed = 'is_failed';
        }
      }
      $stack_day = $stack_7_day;
      //เรียงลำดับarrayใหม่
      $stack_day = array_values($stack_day);
    }
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>

  <div class="daily-deposit-container">
    <!-- btn close -->
    <a href="event.php">
      <div class="btn-close-game">
        <?= file_get_contents('assets/images/game_slot/close.svg') ?>
      </div>
    </a>

    <!-- title -->
    <div class="title-slot-game">
      <img src="assets/images/game_daily_deposit/daily_logo.png">
      <lottie-player class="blink blink-1" src="assets/plugin/lottie/json/star-shine.json" background="transparent" speed="1" loop autoplay></lottie-player>
      <lottie-player class="blink blink-2" src="assets/plugin/lottie/json/star-shine.json" background="transparent" speed="1" loop autoplay></lottie-player>
      <lottie-player class="blink blink-3" src="assets/plugin/lottie/json/star-shine.json" background="transparent" speed="1" loop autoplay></lottie-player>
    </div>

    <?php if ($is_failed) { ?>
      <div class="failed">
        <img src="assets/images/game_daily_deposit/tag-failed.png">
      </div>
    <?php } ?>

    <div class="game-body <?= $is_failed ?>">
      <div class="body-title">
        <?= Ty::get('fixed_atleast', [], ["case" => "ucfirst"]) ?> <span class="amount"><?= number_format($event_data['deposit_amount'], 0) ?></span> <?= Ty::get('baht') ?><br>
        <?= Ty::get('intotal') ?> <span class="amount"><?= $event_data['event_type'] == 'short_term' ? '7' : '30' ?></span> <?= Ty::get('days') ?> <?= Ty::get('get_bonus') ?> <span class="amount-color"><?= number_format($event_data['credit_receive'], 0) ?></span> <?= Ty::get('baht') ?>
      </div>
      <div class="calendar-box">

        <?php
        $range = range(1, 30);
        if (date('m', strtotime($event_data['from_date_time'])) == 2) {
          $range = range(1, 28);
        }
        if ($event_data['event_type'] == 'short_term') {
          $range = range(1, 7);
        }
        foreach ($range as $i) {
        ?>
          <div class="calendar-items <?= $event_data['event_type'] == 'short_term' ? 'seven-day-layout' : '' ?>">
            <div class="count-box">
              <div class="number-group">
                <?php writeNumber($i) ?>
              </div>
              <?php if (isset($stack_day[$i - 1]) &&  $stack_day[$i - 1]) { ?>
                <img class="bg-cover-green" src="assets/images/game_daily_deposit/bg-cover.png">
              <?php } else { ?>
                <img class="base" src="assets/images/game_daily_deposit/bg_base.png">
              <?php } ?>
            </div>
            <div class="reward-box">
              <?php if (isset($stack_day[$i - 1]) &&  $stack_day[$i - 1]) { ?>
                <img class="check" src="assets/images/game_daily_deposit/check.png">
              <?php } else { ?>
                <p><?= number_format($event_data['deposit_amount'], 0) ?>.-</p>
              <?php } ?>
            </div>
          </div>
        <?php } ?>
        <div class="calendar-items">
          <div class="treasure-box">
            <div class="treasure-pos-rel">
              <img class="flare" src="assets/images/game_daily_deposit/flare.png">
              <img class="treasure-img" src="assets/images/game_daily_deposit/treasure.png">
              <div class="treasure-reward-group">
                <?php writeNumber($event_data['credit_receive'] * 1) ?>
                <div class="reward-text">
                  <p><?= Ty::get('credit_bonus') ?></p>
                  <p><?= Ty::get('free') ?>!</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if ($is_failed) { ?>
      <div class="click-deposit is_failed">
        <div class="box-bg">
          <a href="event.php">
            <p><?= Ty::get('back1', [], ["case" => "ucfirst"]) ?></p>
          </a>
        </div>
      </div>
    <?php } else { ?>
      <div class="click-deposit">
        <div class="box-bg">
          <a href="deposit.php">
            <p><?= Ty::get('dep_click', [], ["case" => "ucfirst"]) ?>!</p>
          </a>
        </div>
      </div>
    <?php } ?>
    <?php
    $day_start = Aww::formatDate($event_data['from_date_time'], 'd');
    $month_start = Aww::formatMonthNameTH(Aww::formatDate($event_data['from_date_time'], 'm'));
    $year_start = Aww::formatDate($event_data['from_date_time'], 'Y') + 543;
    $full_date_start = $day_start . ' ' .  $month_start . ' ' . $year_start;

    $day_end = Aww::formatDate($event_data['to_date_time'], 'd');
    $month_end = Aww::formatMonthNameTH(Aww::formatDate($event_data['to_date_time'], 'm'));
    $year_end = Aww::formatDate($event_data['to_date_time'], 'Y') + 543;
    $full_date_end = $day_end . ' ' .  $month_end . ' ' . $year_end;
    ?>
    <div class="game-rule <?= $is_failed ?>">
      <div class="title font-18px"><?= Ty::get('termsandconditions') ?></div>
      <p class="mb-0 mt--20px font-16px" style="white-space: pre-line; ">
        <?= $event_data['detail'] ?>
      </p>
      <?php /*
      <div class="title font-18px">ข้อตกลงและเงื่อนไข</div>
      <ul >
        <li  class="font-16px">สะสมยอดฝากขั้นต่ำ <?= number_format($event_data['deposit_amount'], 0) ?> บาท/วัน ติดต่อกันครบ <?= $event_data['event_type'] == 'short_term' ? '7' : '30' ?> วัน รับเครดิตฟรี <?= number_format($event_data['credit_receive'], 0) ?> บาท</li>
        <li  class="font-16px">ระยะเวลากิจกรรม <?= $full_date_start ?> - <?= $full_date_end ?> เมื่อหมดเขตระยะเวลากิจกรรม จะไม่สามารถแลกรางวัลได้</li>
      </ul>
      */ ?>
    </div>
  </div>



  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/plugin/lottie/js/lottie-player.js');
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

</body>

</html>