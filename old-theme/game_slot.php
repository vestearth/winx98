<?php
require_once '.framework/import.php';

function lottieLoading()
{
  echo '<lottie-player class="loader" src="assets/plugin/lottie/json/loader.json" background="transparent" speed="1" loop autoplay></lottie-player>';
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
      'detail' => 'เข้าหน้ากิจกรรมสล็อตเสี่ยงโชค',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $get_slot = nga_management::getSlotSetting($code);
    $is_play = nga_management::checkUserCanRandomSlot($code, $user_data['id']);
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>
  <div class="slot-container">
    <!-- btn close -->
    <a href="event.php" class="btn-close-game">
      <?= file_get_contents('assets/images/game_slot/close.svg') ?>
    </a>
    <!-- title -->
    <div class="title-slot-game">
      <img src="assets/images/game_slot/new/slot-title.png?v=1" alt="Slot game title">
    </div>
    <!-- money rain effect -->
    <?php /*
    <lottie-player class="money-rain" src="assets/plugin/lottie/json/money-rain.json" background="transparent" speed="1"></lottie-player>
    */ ?>

    <div class="slot-responsive">
      <div class="slot-box">
        <div class="effect-star-1">
          <lottie-player class="star" src="assets/plugin/lottie/json/star-shine.json" background="transparent" speed="1" loop autoplay></lottie-player>
        </div>
        <div class="effect-star-2">
          <lottie-player class="star" src="assets/plugin/lottie/json/star-shine.json" background="transparent" speed="1" loop autoplay></lottie-player>
        </div>

        <div class="slot-mask-bg-body">
          <div class="slot-mask-bg"></div>
        </div>
        <div class="slot-random-frame">
          <div class="slot-reward"></div>
          <div class="slot-reward"></div>
          <div class="slot-reward"></div>
        </div>
        <div class="slot-mask-body">
          <div class="slot-mask scope_slot_mask">
            <div class="logo-img">
              <img src="assets/images/logo.png?gen=<?= rand(0.1, 11111111111); ?>" alt="Logo">
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="px-30px">
      <div class="btn-play-slot <?= ($is_play['can_random']) ? 'event_play_slot' : 'loading font-16px'; ?>">
        <?= ($is_play['can_random']) ? Ty::get('play') . '!' : Ty::get('used_up'); ?>
      </div>
    </div>
    <div class="pb-5px d-flex justify-content-center">
      <span class="text-warning font-18px text-center">
        <?= Ty::get('chance_prize') ?> <?= number_format($user_data['credit_slot_balance']); ?> <?= Ty::get('chance') ?>
      </span>
    </div>

    <div class="game-rule">
      <div class="title font-18px"><?= Ty::get('termsandconditions') ?></div>
      <ul>
        <li class="font-16px"><?= Ty::get('dep_balance') ?> <?= $get_slot['minimum_deposit']; ?> <?= Ty::get('credit') ?> <?= Ty::get('win_1_prize') ?></li>
        <li class="font-16px"><?= Ty::get('there_are') ?> <?= number_format($get_slot['limit_claim_per_day']); ?> <?= Ty::get('draw_prize') ?></li>
        <li class="font-16px"><?= $get_slot['detail']; ?></li>
        <li class="font-16px"><?= Ty::get('question') ?></li>
      </ul>
    </div>

    <div class="px-30px d-flex justify-content-center mb-20px">
      <a href="game_slot_history.php" class="btn-history-rewards">
        <?= Ty::get('reward_history') ?>
      </a>
    </div>
  </div>

  <!-- modal reward -->
  <div class="modal-slot-backdrop">
    <a href="game_slot.php">
      <div class="modal-close">
        <?= file_get_contents('assets/images/game_slot/close.svg'); ?>
      </div>
    </a>
    <div class="modal-slot-body">
      <div class="title">
        <img src="assets/images/game_slot/new/slot-title.png?v=1" alt="Slot game title">
      </div>
      <div class="slot-reward">
        <lottie-player class="reward-star-shine" src="assets/plugin/lottie/json/star.json" background="transparent" speed="1" loop autoplay></lottie-player>
        <div class="reward-mask-bg">
          <img src="assets/images/game_slot/new/reward/slot (<?= rand(1, 25) ?>).png" class="event_slot_img_1">
          <img src="assets/images/game_slot/new/reward/slot (<?= rand(1, 25) ?>).png" class="event_slot_img_2">
          <img src="assets/images/game_slot/new/reward/slot (<?= rand(1, 25) ?>).png" class="event_slot_img_3">
        </div>
        <div class="reward-mask"></div>
      </div>
      <div class="credit-title"><?= Ty::get('you_got') ?></div>
      <div class="credit-number">100</div>
      <div class="credit-text">เครดิต!</div>
      <div class="w-100">
        <a href="game_slot_history.php" class="btn-slot-history">
          <?= Ty::get('reward_history') ?>
        </a>
      </div>
      <a href="game_slot.php" class="btn-close-page">
        <?= Ty::get('close_page') ?>
      </a>
    </div>
  </div>

  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/plugin/lottie/js/lottie-player.js');
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

  <script>
    // const money_rain = document.querySelector('.money-rain');
    // setTimeout(() => {
    //   money_rain.play();
    // }, 500);
    // money_rain.addEventListener('complete', e => {
    //   money_rain.style.display = 'none';
    // });

    $(function() {
      $(document).on('click', '.event_play_slot', function(e) {
        if (!$(this).hasClass('loading')) {
          // money_rain.stop();
          $('.scope_slot_mask').addClass('active');
          $(this).removeClass('.event_play_slot').addClass('loading').html('<?= lottieLoading(); ?>');
          $('.slot-random-frame').addClass('playing');
          setTimeout(async () => {
            var reward = await getSlotReward();
            if (reward) {
              var response = JSON.parse(reward);
            }
            $('.slot-random-frame').removeClass('playing');
            //if reward success
            if (response.response_status) {
              var type_text = '';
              if (response.response_data.recive_type == 'reward') {
                type_text = '<?= Ty::get('rewards') ?>' + '!';
              } else if (response.response_data.recive_type == 'point') {
                type_text = '<?= Ty::get('point') ?>' + '!';
              } else if (response.response_data.recive_type == 'credit') {
                type_text = '<?= Ty::get('credit') ?>' + '!';
              }

              var rand_img_1 = 'assets/images/game_slot/reward/slot (<?= rand(1, 25) ?>).png';
              if (response.response_data.recive_amount >= 100 && response.response_data.recive_amount < 1000) {
                var rand_slot_show = '<?= rand(1, 3) ?>';
                if (rand_slot_show == 1) {
                  $('.event_slot_img_1').attr("src", rand_img_1);
                  $('.event_slot_img_2').attr("src", rand_img_1);
                } else if (rand_slot_show == 2) {
                  $('.event_slot_img_2').attr("src", rand_img_1);
                  $('.event_slot_img_3').attr("src", rand_img_1);
                } else {
                  $('.event_slot_img_1').attr("src", rand_img_1);
                  $('.event_slot_img_3').attr("src", rand_img_1);
                }
              } else if (response.response_data.recive_amount >= 1000) {
                $('.event_slot_img_1').attr("src", rand_img_1);
                $('.event_slot_img_2').attr("src", rand_img_1);
                $('.event_slot_img_3').attr("src", rand_img_1);
              } else {
                $('.event_slot_img_1').attr("src", 'assets/images/game_slot/new/reward/slot (<?= rand(1, 25) ?>).png');
                $('.event_slot_img_2').attr("src", 'assets/images/game_slot/new/reward/slot (<?= rand(1, 25) ?>).png');
                $('.event_slot_img_2').attr("src", 'assets/images/game_slot/new/reward/slot (<?= rand(1, 25) ?>).png');
              }
              if (response.response_data.recive_type == 'reward') {
                $('.credit-title').text('<?= Ty::get('congrats') . ' ' . Ty::get('you_got') ?>');
                $('.credit-number').text('<?= Ty::get('special') ?>');
                $('.credit-number').addClass('font-30px');
                $('.credit-text').text('<?= Ty::get('claim_reward') ?>');
                $('.credit-text').addClass('font-15px');
              } else {
                $('.credit-number').text(response.response_data.recive_amount);
                $('.credit-text').text(type_text);

              }
              openSlotRewardModal();
              //else error
            } else {
              Aww.notification('error', response.response_message);
              resetPlaySlot();
            }
          }, 3000);
        }
      });

      $(document).on('mouseleave', '.event_play_slot', function(e) {
        if (!$(this).hasClass('loading')) {
          $('.scope_slot_mask').removeClass('active');
        }
      });
      $(document).on('mouseover', '.event_play_slot', function(e) {
        if (!$(this).hasClass('loading')) {
          $('.scope_slot_mask').addClass('active');
        }
      });
      $('script').remove();
    });

    function openSlotRewardModal() {
      $('body').css('overflow', 'hidden');
      $('.modal-slot-backdrop').css('display', 'flex');
    }

    function resetPlaySlot() {
      $('.scope_slot_mask').removeClass('active');
      $('.event_play_slot').removeClass('loading').html('เล่น!');
      $('.slot-random-frame').removeClass('playing');
    }

    async function getSlotReward() {
      var url = 'ajax/ajax_reward_slot.php';
      var params = {
        'code': '<?= $code; ?>',
        'user_id': '<?= $user_data['id']; ?>',
      };
      var result = await $.post(url, params).done(function(data) {
        var json = JSON.parse(data);
        return json;
      });
      return result;
    }
  </script>

</body>

</html>