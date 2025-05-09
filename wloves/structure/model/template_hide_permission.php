<div class="permission-container mx--15px">
  <div class="permission-module-top-action">
    <?php if ($is_edit) { ?>
      <div class="permission-module-checked">
        <div class="permission-check-list text-primary __check_all_permission_event">Check All permission</div>
        <div class="permission-check-list text-danger _clear_all_permission_event">Clear All permission</div>
      </div>
    <?php } else { ?>
      <div></div>
    <?php } ?>
    <div class="permission-top-action pt-10px">
      <div class="t1">View:</div>
      <div class="t-list __show_permission_box_all">Show all</div>
      <div class="t-list __hide_permission_box_all">Hide all</div>
    </div>
  </div>

  <?php
  foreach ($permission_array as $module) { //all module
    if ($module['list']) {
      $module_code = $module['code'];
      if (isset($module['list'][0]['list']) && $module['list'][0]['list']) {
  ?>
        <div class="permission-module-group">
          <div class="permission-module-title">
            <div class="permission-module-name">
              <span class="text-secondary">Module: <?= $module['module'] ?></span> |
              <span class="text-primary"><?= $module['name'] ?></span> | <span class="text-primary __amount_checked_permission_per_module">0</span><span class="text-secondary __amount_all_permission_per_module">/0</span>
            </div>
            <div class="permission-module-action">
              <div class="btn-action-group">
                <?php if ($is_edit) { ?>
                  <div class="btn-action-list text-primary __check_permission_group_event">Check All</div>
                  <div class="btn-action-list text-danger __clear_permission_group_event">Clear All</div>
                <?php } ?>

              </div>
              <div class="permission-hide-module-detail">
                Hide <?= file_get_contents($prefix . 'structure/image/icon/general/arrow.svg') ?>
              </div>
            </div>
          </div>
          <div class="table-permission">
            <table>
              <?php
              foreach ($module['list'] as $page_group) { //sub module
                if ($page_group['list']) {
              ?>
                  <thead>
                    <tr>
                      <th class="w-300px min-w-200px"><?= $page_group['name'] ?></th>
                      <th class="thin-cell">Hide Page/Function</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    foreach ($page_group['list'] as $page) { //menu page
                    ?>
                      <tr>
                        <td class="pt-5px">
                          <div class="d-flex align-items-center">
                            <?php if (isset($page['type']) && $page['type'] == 'function') { ?>
                              <div class="min-w-15px mr-5px"><?= file_get_contents($prefix . 'structure/image/icon/general/enter.svg') ?></div>
                            <?php } ?>
                            <span class="mt-5px font-SemiBold"><?= $page['name'] ?></span>
                          </div>
                        </td>
                        <td class="thin-cell">
                          <div class="d-flex justify-content-center font-SemiBold">
                            <?php
                            TiwForm::normal('hidden', 0, ['name' => 'permission_all[' . $page['key'] . ']']);

                            self::randerCheckboxHidePermission(['name' => $page['key'], 'is_edit' => $is_edit, 'checked' => $page['checked']]);
                            ?>
                          </div>
                        </td>
                      </tr>
                      <?php
                      if (isset($page['function']) && $page['function']) {
                        foreach ($page['function'] as $function) {
                      ?>
                          <tr>
                            <td class="pt-5px">
                              <div class="d-flex align-items-center">
                                <div class="min-w-15px"><?= file_get_contents($prefix . 'structure/image/icon/general/enter.svg') ?></div>
                                <span class="pl-5px mt-5px font-SemiBold"><?= $function['name'] ?></span>
                              </div>
                            </td>
                            <td class="thin-cell">
                              <div class="d-flex justify-content-center font-SemiBold">
                                <?php
                                TiwForm::normal('hidden', 0, ['name' => 'permission_all[' . $function['key'] . ']']);
                                self::randerCheckboxHidePermission(['name' => $function['key'], 'is_edit' => $is_edit, 'checked' => $function['checked'], 'type' => $function['type']]);
                                ?>
                              </div>
                            </td>
                          </tr>
                    <?php
                        } //foreach function
                      } //$page
                    } //foreach page
                    ?>
                  </tbody>
              <?php
                }
              } //foreach page_group
              ?>
            </table>
          </div>
        </div>
  <?php
      }
    }
  }
  ?>
</div>