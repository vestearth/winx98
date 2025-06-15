<?php
require_once '.framework/import.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('', $og_data);
  Aww::loadAsset('assets/css/main.css');
  ?>
</head>

<body>
  <?php
  if ($is_login) {
    $user_data = User::getCurrent();
    $data = [
      'user_id' => $user_data['id'],
      'detail' => 'เข้าหน้ากิจกรรมเปิดไพ่',
    ];
    $user_log = nga_user::addNewUserLog($code, $data);
    $get_card = nga_management::getCardSetting($code);
    $is_play = nga_management::checkUserCanRandomCard($code, $user_data['id']);
  } else {
    Aww::redirectOG('landing.php');
  }
  ?>
  <div class="game-card-container">
    <!-- btn close -->
    <a href="event.php">
      <div class="btn-close-game">
        <?= file_get_contents('assets/images/game_slot/close.svg') ?>
      </div>
    </a>

    <!-- game card title -->
    <div class="game-card-title-container">
      <div class="game-card-title">
        <div class="title-bg"></div>

        <?php for ($i = 1; $i < 4; $i++) { ?>
          <div class="effect-star" data-number="<?= $i ?>">
            <lottie-player class="star event_effect_star_<?= $i ?>" src="assets/plugin/lottie/json/star-shine.json" background="transparent" speed="1" loop></lottie-player>
          </div>
        <?php } ?>
      </div>
    </div>
    <?php
    $is_play['can_random'] = 1;
    ?>
    <!-- title description -->
    <?php if ($is_play['can_random']) { ?>
      <div class="game-card-title-description event_session_1 px-3px"><?= Ty::get('choose_card') ?></div>
    <?php } else { ?>
      <div class="game-card-title-description px-3px"><?= Ty::get('used_up') ?></div>
    <?php } ?>

    <!-- open card -->
    <div class="open-card-container <?= ($is_play['can_random']) ? 'event_session_1' : 'is-used'; ?>">
      <div class="open-card-body">
        <?php for ($i = 0; $i < 6; $i++) { ?>
          <div class="open-card-list <?= ($is_play['can_random']) ? 'event_open_card' : ''; ?>">
            <img src="assets/images/game_card/card-back.png" alt="Card" class="card-back">
            <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo" class="card-logo">
          </div>
        <?php } ?>
      </div>
    </div>

    <!-- quota play  -->
    <div class="pb-5px mb-15px d-flex justify-content-center scope_credit_balance">
      <span class="text-purple font-18px text-center">
        <?= Ty::get('chance_prize') ?> <?= number_format($user_data['credit_card_balance']); ?> <?= Ty::get('chance') ?>
      </span>
    </div>

    <!-- rule -->
    <div class="game-rule event_session_1">
      <div class="content-box">
        <div class="title font-18px"><?= Ty::get('termsandconditions') ?></div>
        <ul>
          <li class="font-16px"><?= Ty::get('dep_balance') ?> <?= $get_card['minimum_deposit']; ?> <?= Ty::get('credit') ?> <?= Ty::get('win_1_prize') ?></li>
          <li class="font-16px"><?= Ty::get('there_are') ?> <?= number_format($get_card['limit_claim_per_day']); ?> <?= Ty::get('times_day') ?></li>
          <li class="font-16px"><?= $get_card['detail']; ?></li>
          <li class="font-16px"><?= Ty::get('question') ?></li>
        </ul>
      </div>
    </div>

    <!-- history -->
    <div class="px-5px max-w-300px m-auto event_session_1  mb-20px">
      <a href="game_card_history.php" class="btn btn-history font-SemiBold ">
        <?= Ty::get('reward_history') ?>
      </a>
    </div>

    <div class="card-session-reward event_session_2">
      <div class="d-flex justify-content-center">
        <div class="card-reward-container">
          <div class="card-reward-group event_reward_group">
            <div class="card-reward-front">
              <img src="assets/images/game_card/card-front.png" alt="Card Reward">
            </div>
            <div class="card-reward-back">
              <img src="assets/images/game_card/card-back.png" alt="Card" class="card-back">
              <img src="assets/images/logo.png?v=<?= rand(1, 999) ?>" alt="Logo" class="card-logo">
            </div>
          </div>

          <div class="effect-star-shine" data-number="<?= $i ?>">
            <lottie-player class="star-shine" src="assets/plugin/lottie/json/star.json" background="transparent" speed="1" loop></lottie-player>
          </div>
        </div>
      </div>

      <div class="reward-detail event_session_after_open">
        <div class="text-1"><?= Ty::get('congrats') ?>! <?= Ty::get('you_got') ?></div>
        <div class="text-2">
          <span class="reward_name"><?= Ty::get('special') ?></span>
          <p class="mb-0 reward_reward font-16px"></p>
        </div>
        <div class="text-3 mb-10px"><?= Ty::get('claim_reward') ?></div>
        <div class="manage-btn-group">
          <a href="game_card_history.php" class="btn-history-2">
            <?= Ty::get('reward_history') ?>
          </a>
          <a href="event.php" class="btn-close-page">
            <div><?= Ty::get('close_page') ?></div>
          </a>
        </div>
      </div>
    </div>

  </div>


  <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
  <?php
  include 'layout/footer.php';
  Structure::loadFooter();
  Aww::loadAsset('assets/js/force_logout.js');
  ?>

  <script>
    <?php for ($i = 1; $i < 5; $i++) { ?>
      const lottie_star_<?= $i ?> = document.querySelector('.event_effect_star_<?= $i ?>');
      setTimeout(() => {
        lottie_star_<?= $i ?>.play();
      }, 800);
    <?php } ?>
    const lottie_star_shine = document.querySelector('.star-shine');

    $(function() {
      $(document).on('click', '.event_open_card', async function(e) {
        var result = await getCardReward();
        if (result) {
          var response = JSON.parse(result);
        }
        //if result success
        if (response.response_status) {
          // check thai type 
          var type_text = '';
          if (response.response_data.recive_type == 'reward') {
            type_text = '<?= Ty::get('rewards') ?>';
          } else if (response.response_data.recive_type == 'point') {
            type_text = '<?= Ty::get('point') ?>';
          } else if (response.response_data.recive_type == 'credit') {
            type_text = '<?= Ty::get('credit') ?>';
          }
          // end check thai type
          $('.event_session_1').hide();
          $('.event_session_2').fadeIn();
          $('.scope_credit_balance').remove();
          setTimeout(() => {
            $('.reward_name').text(response.response_data.recive_amount + ' ' + type_text);
            $('.reward_reward').text(response.response_data.remark);
            $('.event_reward_group').addClass('flip');
            $('.event_session_after_open').fadeIn(700);
            $('.effect-star-shine').fadeIn(700, function(e) {
              lottie_star_shine.play();
            });
          }, 700);
        } else {
          //else error
          Aww.notification('error', response.response_message);
        }
      });
      $('script').remove();
    });

    async function getCardReward() {
      var url = 'ajax/ajax_reward_card.php';
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