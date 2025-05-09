<?php

//checkbox permission and update
function randerCheckbox($options = [])
{
  global $id;

  $is_edit = (isset($options['is_edit']) && $options['is_edit']) ? true : false;
  $checked = (isset($options['checked']) && $options['checked']) ? true : false;
  $key     = (isset($options['key']) && $options['key']) ? $options['key'] : '';
  $checked = (isset($options['checked']) && $options['checked']) ? true : false;

  if ($key == 'full_name') {
    echo '<span class="text-primary">ON</span>';
    return true;
  }

  if ($is_edit) {
    if ($key) {
      $api = [
        'api' => 'User_type::updateUserType',
        'params' => [
          'id' => $id,
          'data' => [
            $key => '{' . $key . '}',
          ]
        ]
      ];
      TiwForm::liveForm('checkbox', $key, $checked, $api, ['is_on_off' => true]);
    }
  } else {
    if ($checked) {
      $checkbox = '<span class="text-primary">ON</span>';
    } else {
      $checkbox = '<span class="text-danger">OFF</span>';
    }
    echo $checkbox;
  }
}

$function_list = [
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">ALLOW LOGIN on program |</span> 
    <span class="font-14px text-secondary">User use this user type can log in to this system.</span>',
    'key' => 'is_allow_program_login',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">ALLOW LOGIN on Application |</span> 
    <span class="font-14px text-secondary">User use this user type can log in to application.</span>',
    'key' => 'is_allow_app_login',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">ALLOW LOGIN ON WEBSITE |</span> 
    <span class="font-14px text-secondary">User use this user type can login to website.</span>',
    'key' => 'is_allow_login',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">Password condition |</span> 
    <span class="font-14px text-secondary">Require condition when configure user password.</span>',
    'key' => 'is_strict_password',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">ACTION PIN |</span> 
    <span class="font-14px text-secondary">Open function pin on user</span>',
    'key' => 'is_action_pin',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">Permission Template |</span> 
    <span class="font-14px text-secondary">Open function permission template on user info and setting.</span>',
    'key' => 'is_permission_template',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">Category |</span> 
    <span class="font-14px text-secondary">Open function categories on user info and setting.</span>',
    'key' => 'is_has_category',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">Team |</span> 
    <span class="font-14px text-secondary">Open function team on user info and setting.</span>',
    'key' => 'is_has_team',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">Tag |</span> 
    <span class="font-14px text-secondary">Open function tag on user info and setting.</span>',
    'key' => 'is_has_tag',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">Code / ID |</span> 
    <span class="font-14px text-secondary">Auto generate user code or id</span>',
    'key' => 'is_use_pin_code',
  ],
];

$information_list = [
  [
    'title' => 'Profile',
    'list' => [
      [
        'title' => 'Full Name',
        'key'   => 'full_name',
      ],
      [
        'title' => 'Preferred Name',
        'key'   => 'is_has_nick_name',
      ],
      [
        'title' => 'Profile Image',
        'key'   => 'is_has_profile_image',
      ],
    ]
  ],
  [
    'title' => 'Contact Detail',
    'list' => [
      [
        'title' => 'Address Type',
        'key'   => 'is_user_address_type',
      ],
      [
        'title' => 'Address',
        'key'   => 'is_user_address',
      ],
      [
        'title' => 'Telephone No.',
        'key'   => 'is_tel',
      ],
      [
        'title' => 'Email',
        'key'   => 'is_has_email',
      ],
      [
        'title' => 'Line ID',
        'key'   => 'is_has_line',
      ],
      [
        'title' => 'Facebook',
        'key'   => 'is_has_facebook',
      ],
      [
        'title' => 'Wechat',
        'key'   => 'is_has_wechat',
      ],
      [
        'title' => 'Twiter',
        'key'   => 'is_has_twitter',
      ],
      [
        'title' => 'Instagram',
        'key'   => 'is_has_instagram',
      ],
    ]
  ],
  [
    'title' => 'Emergency Contact Person',
    'list' => [
      [
        'title' => 'Emergency Contact Person',
        'key'   => 'is_has_emergency_contact',
      ],
      [
        'title' => 'Emergency Tel No.',
        'key'   => 'is_has_emergency_tel',
      ],
      [
        'title' => 'Relationship',
        'key'   => 'is_has_relationship',
      ],
    ]
  ],
  [
    'title' => 'Other Detail',
    'list' => [
      [
        'title' => 'ID Card No.',
        'key'   => 'is_has_id_card_no',
      ],
      [
        'title' => 'Passport No.',
        'key'   => 'is_has_passport_no',
      ],
      [
        'title' => 'Country of Passport',
        'key'   => 'is_has_passport_country',
      ],
      [
        'title' => 'Nationality',
        'key'   => 'is_has_nationality',
      ],
      [
        'title' => 'Religion',
        'key'   => 'is_has_religion',
      ],
      [
        'title' => 'Sex / Gender',
        'key'   => 'is_has_gender',
      ],
      [
        'title' => 'Birthday & Age',
        'key'   => 'is_has_birthdate',
      ],
    ]
  ],
];

$other_page_list = [
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">MULTIPLE Bank Account |</span> 
    <span class="font-14px text-secondary">Open page “Bank Account” and user can configure multiple bank account</span>',
    'key' => 'is_multiple_bank_account',
  ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">MULTIPLE Address |</span> 
    <span class="font-14px text-secondary">Open page “Address” and user can configure multiple address</span>',
    'key' => 'is_multiple_address',
  ],
  // [
  //   'title' => '<span class="font-16px font-SemiBold text-uppercase">Verify Data |</span> 
  //   <span class="font-14px text-secondary">Open page “Verify” and verify function</span>',
  //   'key' => 'is_topbar_verify_data',
  // ],
  // [
  //   'title' => '<span class="font-16px font-SemiBold text-uppercase">WORKING DETAIL |</span> 
  //   <span class="font-14px text-secondary">Open page “Working Detail”</span>',
  //   'key' => 'is_topbar_working_detail',
  // ],
  [
    'title' => '<span class="font-16px font-SemiBold text-uppercase">CONTACT PERSON |</span> 
    <span class="font-14px text-secondary">Open page “Contact Person”</span>',
    'key' => 'is_topbar_contact_person',
  ],
];

//from user_type.php
?>

<div class="row">
  <div class="col-lg-12 px-0">
    <div class="master-form-header-wrap">
      <div class="title-group">
        <div class="d-flex">
          <div>
            <h3 class="text-uppercase font-SemiBold font-16px">User Information Setting</h3>
            <p class="font-14px font-Regular">Configure function and field for user used this user type</p>
          </div>
        </div>
      </div>
    </div>
    <div class="permission-container px-15px">
      <!-- function -->
      <div class="permission-module-group">
        <div class="permission-module-title">
          <div class="permission-module-name">
            <span class="font-SemiBold">Function</span>
          </div>
          <div class="permission-module-action flex-grow-0">
            <div class="permission-hide-module-detail">
              Hide
              <?= file_get_contents('../../structure/image/icon/general/arrow.svg') ?>
            </div>
          </div>
        </div>
        <div class="table-permission">
          <table>
            <thead>
              <tr>
                <th>Page / Function</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($function_list as $function) { ?>
                <tr>
                  <td>
                    <?= $function['title'] ?>
                    <?php if ($function['key'] == 'is_use_pin_code') {
                      $configure_code = [
                        'user_code_format_text1' => $user_information['user_code_format_text1'], 'user_code_format_text2' => $user_information['user_code_format_text2'], 'user_code_format_digit3' => $user_information['user_code_format_digit3']
                      ];
                      $configure_code_text = $user_information['user_code_format_text1'] . $user_information['user_code_format_text2'] . sprintf('%0' . $user_information['user_code_format_digit3'] . 'd', '');
                    ?>
                      <div class="d-flex align-items-center justify-content-between">
                        <div class="font-14px text-uppercase text-secondary font-SemiBold text-info">
                          Starter ID: <span class="text-primary"><?= $configure_code_text ?></span>
                        </div>
                        <div class="font-14px font-SemiBold text-primary text-underline cursor-pointer" toggle-edit-modal="#modal_configure_code" data-register="<?= base64_encode(json_encode($configure_code)) ?>">Configure</div>
                      </div>
                    <?php } ?>
                  </td>
                  <td class="thin-cell">
                    <div class="d-flex justify-content-center font-SemiBold">
                      <?php
                      $checked = isset($user_information[$function['key']]) ? $user_information[$function['key']] : '';
                      randerCheckbox(['key' => $function['key'], 'is_edit' => true, 'checked' => $checked]);
                      ?>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Basic Information -->
      <div class="permission-module-group">
        <div class="permission-module-title">
          <div class="permission-module-name">
            <span class="font-SemiBold">Basic Information</span>
          </div>
          <div class="permission-module-action flex-grow-0">
            <div class="permission-hide-module-detail">
              Hide
              <?= file_get_contents('../../structure/image/icon/general/arrow.svg') ?>
            </div>
          </div>
        </div>
        <div class="table-permission">
          <table>
            <thead>
              <tr>
                <th class="w-200px">Field</th>
                <th>Action</th>
                <th class="w-200px">Field</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($information_list as $list) {
                $data_key = 0;
              ?>
                <tr class="bg-card">
                  <td colspan="4"><?= $list['title'] ?></td>
                </tr>
                <?php
                for ($f = 0; $f < ceil(count($list['list']) / 2); $f++) {
                  $list_count = 0;
                  echo '<tr>';
                  for ($i = $list_count; $i < 2; $i++) {
                    $data = isset($list['list'][$data_key]) ? $list['list'][$data_key] : ['title' => '', 'key' => ''];
                ?>
                    <td><?= $data['title'] ?></td>
                    <td class="thin-cell">
                      <div class="d-flex justify-content-center font-SemiBold">
                        <?php
                        $checked = isset($user_information[$data['key']]) ? $user_information[$data['key']] : '';
                        randerCheckbox(['key' => $data['key'], 'is_edit' => true, 'checked' => $checked]);
                        ?>
                      </div>
                    </td>
                <?php
                    $data_key += 1;
                    $list_count += 1;
                  }
                  echo '</tr>';
                }
                ?>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- Other Page -->
      <div class="permission-module-group">
        <div class="permission-module-title">
          <div class="permission-module-name">
            <span class="font-SemiBold">Function</span>
          </div>
          <div class="permission-module-action flex-grow-0">
            <div class="permission-hide-module-detail">
              Hide
              <?= file_get_contents('../../structure/image/icon/general/arrow.svg') ?>
            </div>
          </div>
        </div>
        <div class="table-permission">
          <table>
            <thead>
              <tr>
                <th>Page / Function</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($other_page_list as $page) { ?>
                <tr>
                  <td><?= $page['title'] ?></td>
                  <td class="thin-cell">
                    <div class="d-flex justify-content-center font-SemiBold">
                      <?php
                      $checked = isset($user_information[$page['key']]) ? $user_information[$page['key']] : '';
                      randerCheckbox(['key' => $page['key'], 'is_edit' => true, 'checked' => $checked]);
                      ?>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php Tiwdal::startModal('modal_configure_code', 'modal-md'); ?>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">×</span>
</button>
<div class="modal-header">
  <h5 class="modal-title text-uppercase">configure user’s starter code / id</h5>
</div>
<form method="POST">
  <div class="modal-body pb-5px">
    <div class="form-row">
      <div class="col-md-4 font-14px text-secondary pt-10px">
        Code / Symbol / Digit
      </div>
      <div class="col-md-8">
        <div class="form-row">
          <div class="col-sm-4">
            <?= TiwForm::normal('text', '', ['name' => '{user_code_format_text1}', 'placeholder' => 'Ex. EM, CT', 'required' => true]); ?>
          </div>
          <div class="col-sm-4">
            <?php
            $options = [
              'list' => [
                [
                  'value' => '-',
                  'name' => '-'
                ],
                [
                  'value' => '/',
                  'name' => '/'
                ],
                [
                  'value' => '#',
                  'name' => '#'
                ],
                [
                  'value' => '0',
                  'name' => 'None'
                ],
              ]
            ];
            TiwForm::normal('select', '', ['name' => '{user_code_format_text2}'], $options);
            ?>
          </div>
          <div class="col-sm-4">
            <?= TiwForm::normal('number', '', ['name' => '{user_code_format_digit3}', 'placeholder' => '0']); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php
    TiwForm::normal('btn', '', ['type' => 'button', 'class' => 'btn-light min-w-80px', 'data-dismiss' => 'modal'], ['text' => 'Cancel']);
    TiwForm::normal('btn', '', ['type' => 'submit', 'class' => 'min-w-100px', 'name' => 'submit_format_code'], ['text' => 'SAVE']);
    ?>
  </div>
</form>
<?php Tiwdal::endModal() ?>