<?php
if ($_POST) {
  if (isset($_POST['submit_theme_color'])) {
    unset($_POST['submit_theme_color']);

    if ($_POST['default_theme'] == 'white') {
      $_POST['theme'] = 'white';
      $_POST['color_highlight'] = '#235E88';
      $_POST['color_base_background'] = '#fbfbfb';
      $_POST['color_selected_menu'] = '#eaeaea';
      $_POST['color_base_icon'] = '#778396';
    } else if ($_POST['default_theme'] == 'dark') {
      $_POST['theme'] = 'dark';
      $_POST['color_highlight'] = '#235E88';
      $_POST['color_base_background'] = '#313a41';
      $_POST['color_selected_menu'] = '#212f39';
      $_POST['color_base_icon'] = '#d8d9da';
    }

    $result = WLoves::setProgramSetup($_POST);
  }

  if (isset($result)) {
    $response_message = isset($response_message) ? $response_message : $result['response_message'];
    $response_status = $result['response_status'] ? 'success' : 'error';
    $response_redirect = isset($response_redirect) ? $response_redirect : '';

    Aww::notification($response_message, $response_status);
    Aww::redirect($response_redirect);
  }
}

?>
<form method="post" enctype="multipart/form-data" id="form_theme_program">
  <input type="hidden" name="submit_theme_color">
  <div class="row">
    <div class="col-12 px-0">
      <div class="title-detail px-15px">
        <h3 class="text-uppercase font-16px">Theme & color</h3>
        <p class="font-14px">Set program theme color</p>
      </div>
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-12 px-0">
      <div class="title-detail px-15px">
        <h3 class="text-uppercase font-14px">MAIN THEME</h3>
        <p class="font-14px">Configure theme for this system.</p>
      </div>
    </div>
  </div>
  <div class="form-row form-group ">
    <div class="col-sm-2 mb-0 align-self-center">
      <label class="text-secondary"> Light Mode </label>
    </div>
    <div class="col-sm-4 align-self-center">
      <div class="check-theme-program white <?= (F_WLoves::getTheme() == 'white') ? 'active' : '' ?>" data-theme="white">
        <div class="d-flex">
          <div class="left"></div>
          <div class="right"></div>
        </div>
      </div>
    </div>
    <div class="col-sm-2 mb-0 align-self-center">
      <label class="text-secondary"> Dark Mode </label>
    </div>
    <div class="col-sm-4 align-self-center">
      <div class="check-theme-program dark <?= (F_WLoves::getTheme() == 'dark') ? 'active' : '' ?>" data-theme="dark">
        <div class="d-flex">
          <div class="left"></div>
          <div class="right"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 px-0">
      <hr class="border-dashed">
      <div class="title-detail px-15px">
        <h3 class="text-uppercase font-14px">HIGHLIGHT</h3>
        <p class="font-14px">Use in many location on this system, recommend to select your company’s identity color.</p>
      </div>
    </div>
  </div>
  <div class="form-row form-group ">
    <div class="col-sm-2 mb-0 align-self-center">
      <label class="text-secondary"> Highlight Color </label>
    </div>
    <div class="col-sm-4  font-Medium text_progress align-self-center">
      <div div class="d-flex align-items-center">
        <?= TiwForm::normal('color', $program['color_highlight'], ['name' => 'color_highlight', 'class' => 'color-border-circle change_theme_submit']); ?>
        <div class="mb-10px ml-5px">
          <?= $program['color_highlight'] ?>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 px-0">
      <hr class="border-dashed">
      <div class="title-detail px-15px">
        <h3 class="text-uppercase font-14px">CUSTOMIZE SIDE NAV MENU COLOR</h3>
        <p class="font-14px">Menu color only affects the side nav menu but only just highlight color will be use to other location on system. </p>
      </div>
    </div>
  </div>
  <div class="form-row form-group ">
    <div class="col-sm-2 mb-0 align-self-center">
      <label class="text-secondary"> Base Background </label>
    </div>
    <div class="col-sm-4 font-Medium text_progress align-self-center">
      <div div class="d-flex align-items-center">
        <?= TiwForm::normal('color', $program['color_base_background'], ['name' => 'color_base_background', 'class' => 'color-border-circle change_theme_submit']); ?>
        <div class="mb-10px ml-5px">
          <?= $program['color_base_background'] ?>
        </div>
      </div>
    </div>
    <div class="col-sm-2 mb-0 align-self-center">
      <label class="text-secondary"> Selected Menu </label>
    </div>
    <div class="col-sm-4  font-Medium text_progress align-self-center">
      <div class="d-flex align-items-center">
        <?= TiwForm::normal('color', $program['color_selected_menu'], ['name' => 'color_selected_menu', 'class' => 'color-border-circle change_theme_submit']); ?>
        <div class="mb-10px ml-5px">
          <?= $program['color_selected_menu'] ?>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row form-group ">
    <div class="col-sm-2 mb-0 align-self-center">
      <label class="text-secondary"> Base Icon Color </label>
    </div>
    <div class="col-sm-4 f font-Medium text_progress align-self-center">
      <div div class="d-flex align-items-center">
        <?= TiwForm::normal('color', $program['color_base_icon'], ['name' => 'color_base_icon', 'class' => 'color-border-circle change_theme_submit']); ?>
        <div class="mb-10px ml-5px">
          <?= $program['color_base_icon'] ?>
        </div>
      </div>
    </div>
  </div>
  <div class="form-row form-group ">
    <div class="col-sm-2 mb-0 align-self-center">
      <label class="mb-0 text-secondary">Reset to</label>
    </div>
    <div class="col-sm-4 f font-Medium text_progress align-self-center">
      <div div class="d-flex align-items-center">
        <input type="hidden" class="default-theme" name="default_theme">
        <input type="hidden" name="theme" value="<?= Structure::getThemeClass(); ?>">
        <button type="button" class="btn-vis-border white" data-default_theme="white">Default Light Mode</button>
        |
        <button type="button" class="btn-vis-border dark" data-default_theme="dark">Default Dark Mode</button>
      </div>
    </div>
  </div>
</form>

<script>
  $(function() {
    //main theme
    $('.check-theme-program').click(function(e) {
      $('.check-theme-program').removeClass('active');
      var theme = $(this).data('theme');
      $(this).addClass('active');
      var color_highlight = $('input[name=color_highlight]').val();
      var bg_nav = $('input[name=color_base_background]').val();
      var color_hover_nav = $('input[name=color_selected_menu]').val();
      var color_icon_text = $('input[name=color_base_icon]').val();
      $.post('../../module_main/core/controller/layout/ajax.sidenav.php', {
        submit_toggle_theme: 1,
        theme: theme,
        color_highlight: color_highlight,
        bg_nav: bg_nav,
        color_hover_nav: color_hover_nav,
        color_icon_text: color_icon_text
      }).done(function() {
        location.reload();
      });
      $('input[name="theme"]').val(theme);
      $('#form_theme_program').submit();
    });

    //highlight and customize side nav menu color
    $('.change_theme_submit').change(function(e) {
      var color_highlight = $('input[name=color_highlight]').val();
      var bg_nav = $('input[name=color_base_background]').val();
      var color_hover_nav = $('input[name=color_selected_menu]').val();
      var color_icon_text = $('input[name=color_base_icon]').val();
      $.post('../../module_main/core/controller/layout/ajax.sidenav.php', {
        submit_toggle_theme: 1,
        theme: '<?= Structure::getThemeClass(); ?>',
        color_highlight: color_highlight,
        bg_nav: bg_nav,
        color_hover_nav: color_hover_nav,
        color_icon_text: color_icon_text
      }).done(function() {
        location.reload();
      });
      $('#form_theme_program').submit();
    });

    //reset to
    $('.btn-vis-border').click(function(e) {
      var theme = $(this).data('default_theme');
      var check_theme = $('.default-theme').val(theme);
      if (theme == 'white') {
        var color_highlight = '#235E88';
        var bg_nav = '#fbfbfb';
        var color_hover_nav = '#eaeaea';
        var color_icon_text = '#778396';
      } else if (theme == 'dark') {
        var color_highlight = '#235E88';
        var bg_nav = '#313a41';
        var color_hover_nav = '#212f39';
        var color_icon_text = '#d8d9da';
      }

      if (check_theme) {
        $.post('../../module_main/core/controller/layout/ajax.sidenav.php', {
          submit_toggle_theme: 1,
          theme: theme,
          color_highlight: color_highlight,
          bg_nav: bg_nav,
          color_hover_nav: color_hover_nav,
          color_icon_text: color_icon_text
        }).done(function() {
          location.reload();
        });
      }
      $('#form_theme_program').submit();
    });
  });
</script>