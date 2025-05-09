<?php
F_Config::$menu_list['No_more_game_agent'] = [
  'title'       => 'No_more_game_agent',
  'page_name'   => 'no_more_game_agent',
  'module_name' => 'No_more_game_agent',
  'icon'        => 'module/no_more_game_agent/assets/icon/icon-menu-admin.svg',
  'menu_items'  => [
    [
      'title'     => 'ดูแลระบบ',
      'page_name' => 'admin',
      'icon'      => 'module/no_more_game_agent/assets/icon/icon-menu-admin.svg',
      'url'       => 'customer_list.php',
      'sub_menu'  => [
        [
          'title'     => 'ลูกค้า',
          'page_name' => 'customer',
          'icon'      => '',
          'url'       => 'customer_list.php'
        ],
        [
          'title'     => 'รายการฝาก',
          'page_name' => 'deposit_withdraw',
          'icon'      => '',
          'url'       => 'deposit_list.php'
        ],
        [
          'title'     => 'รายการถอน',
          'page_name' => 'manage_withdraw',
          'icon'      => '',
          'url'       => 'withdraw_list.php'
        ],
        [
          'title'     => 'รายการอนุมัติถอนเงิน',
          'page_name' => 'auto_withdraw',
          'icon'      => '',
          'url'       => 'auto_withdraw_list.php'
        ],
        [
          'title'     => 'รายการลดเครดิต',
          'page_name' => 'credit_discount',
          'icon'      => '',
          'url'       => 'credit_discount_list.php'
        ],
        // [
        //   'title'     => 'Statements',
        //   'page_name' => 'statements',
        //   'icon'      => '',
        //   'url'       => 'statements_list.php'
        // ],
        // [
        //   'title'     => 'Bot Statements & Log',
        //   'page_name' => 'bot_statement_log',
        //   'icon'      => '',
        //   'url'       => 'bot_statement_log.php'
        // ],
        // [
        //   'title'     => 'รายการแลกของรางวัล',
        //   'page_name' => 'redemption',
        //   'icon'      => '',
        //   'url'       => 'redemption_list.php'
        // ],
        [
          'title'     => 'ความคิดเห็นของลูกค้า',
          'page_name' => 'opinion',
          'icon'      => '',
          'url'       => 'opinion_list.php'
        ],
      ]
    ],
    [
      'title'     => 'กระเป๋าเงิน',
      'page_name' => 'wallet',
      'icon'      => 'module/no_more_game_agent/assets/icon/icon-menu-admin.svg',
      'url'       => '',
      'sub_menu'  => [
        [
          'title'     => 'รวมรายการเพิ่มเครดิต',
          'page_name' => 'add_credit_list',
          'icon'      => '',
          'url'       => 'add_credit_list.php'
        ],
        // [
        //   'title'     => 'รายการโบนัสชวนเพื่อน',
        //   'page_name' => 'bonus_invite',
        //   'icon'      => '',
        //   'url'       => 'bonus_invite.php'
        // ],
        // [
        //   'title'     => 'รายการโบนัสชวนเพื่อน 3 ชั้น',
        //   'page_name' => 'bonus_invite_new',
        //   'icon'      => '',
        //   'url'       => 'bonus_invite_new.php'
        // ],
        // [
        //   'title'     => 'รายการโบนัสชวนเพื่อนรายวัน',
        //   'page_name' => 'bonus_invite_daily',
        //   'icon'      => '',
        //   'url'       => 'bonus_invite_daily.php'
        // ],
        [
          'title'     => 'รายการคืนยอดเสีย',
          'page_name' => 'loss_return',
          'icon'      => '',
          'url'       => 'loss_return.php'
        ],
        [
          'title'     => 'สรุปรายการคืนยอด',
          'page_name' => 'summarize_returns',
          'icon'      => '',
          'url'       => 'summarize_returns.php'
        ],
      ]
    ],
    [
      'title'     => 'พันธมิตร',
      'page_name' => 'agent',
      'icon'      => 'module/no_more_game_agent/assets/icon/icon-menu-admin.svg',
      'url'       => '',
      'sub_menu'  => [
        [
          'title'     => 'พันธมิตร',
          'page_name' => 'agent',
          'icon'      => '',
          'url'       => 'agent.php'
        ],
      ]
    ],
    [
      'title'     => 'พันธมิตร',
      'page_name' => 'alliance',
      'icon'      => 'module/no_more_game_agent/assets/icon/icon-menu-admin.svg',
      'url'       => '',
      'sub_menu'  => [
        [
          'title'     => 'ยอดแพ้ - ชนะพันธมิตร',
          'page_name' => 'loss_win_alliance',
          'icon'      => '',
          'url'       => 'loss_win_alliance.php'
        ],
        [
          'title'     => 'ยอดรวมพันธมิตร',
          'page_name' => 'loss_win_with_alliance',
          'icon'      => '',
          'url'       => 'loss_win_with_alliance.php'
        ],
        [
          'title'     => 'สรุปแยกตามพันธมิตร',
          'page_name' => 'summary_with_alliance',
          'icon'      => '',
          'url'       => 'summary_with_alliance.php'
        ],
        // รอเปิดตอนต่อ API เสร็จ
        [
          'title'     => 'สรุปพันธมิตรหาลูกค้า',
          'page_name' => 'summary_customer_marketing',
          'icon'      => '',
          'url'       => 'summary_customer_marketing.php'
        ],
      ]
    ],
    [
      'title'     => 'การจัดการ',
      'page_name' => 'management',
      'icon'      => 'module/no_more_game_agent/assets/icon/icon-menu-admin.svg',
      'url'       => '',
      'sub_menu'  => [
        // [
        //   'title'     => 'การโยกเงิน',
        //   'page_name' => 'rocking_money',
        //   'icon'      => '',
        //   'url'       => 'rocking_money.php'
        // ],
        [
          'title'     => 'ประวัติการเล่นเกม',
          'page_name' => 'game_history',
          'icon'      => '',
          'url'       => 'game_history.php'
        ],
        [
          'title'     => 'สถิติเกมแยกรายผู้ให้บริการ',
          'page_name' => 'provider_report',
          'icon'      => '',
          'url'       => 'provider_report.php'
        ],
        // [
        //   'title'     => 'สถิติหวยแยกรายประเภท',
        //   'page_name' => 'lotto_report',
        //   'icon'      => '',
        //   'url'       => 'lotto_report.php'
        // ],
        // [
        //   'title'     => 'ประวัติการเล่นหวย',
        //   'page_name' => 'lotto_history',
        //   'icon'      => '',
        //   'url'       => 'lotto_history.php'
        // ],
        // [
        //   'title'     => 'ประวัติการเล่นเกมกีฬา',
        //   'page_name' => 'football_history',
        //   'icon'      => '',
        //   'url'       => 'football_history.php'
        // ],
        [
          'title'     => 'ตั้งค่าฐานข้อมูลระบบ',
          'page_name' => 'system_database',
          'icon'      => '',
          'url'       => 'system_database.php'
        ],
      ]
    ],
    // [
    //   'title'     => 'ข้อมูลสรุปและสถิติ',
    //   'page_name' => 'summary_stats',
    //   'icon'      => 'module/no_more_game_agent/assets/icon/icon-menu-summary.svg',
    //   'url'       => '',
    //   'sub_menu'  => [
    //     [
    //       'title'     => 'ภาพรวม',
    //       'page_name' => 'overview',
    //       'icon'      => '',
    //       'url'       => 'overview.php'
    //     ],
    //     [
    //       'title'     => 'รายงานสรุปยอดฝาก / ถอน',
    //       'page_name' => 'summary_report',
    //       'icon'      => '',
    //       'url'       => 'summary_report.php'
    //     ],
    //     [
    //       'title'     => 'รายงานสรุปยอดฝาก / ถอน แยกรายบัญชี',
    //       'page_name' => 'summary_report_by_account',
    //       'icon'      => '',
    //       'url'       => 'summary_report_by_account.php'
    //     ],
    //     [
    //       'title'     => 'รายงานสรุปยอด แพ้/ชนะ',
    //       'page_name' => 'summary_winloss',
    //       'icon'      => '',
    //       'url'       => 'summary_winloss.php'
    //     ],
    //     // [
    //     //   'title'     => 'รายงานสรุปการฝากเงินไม่สำเร็จ',
    //     //   'page_name' => 'failed_deposit_summary_report',
    //     //   'icon'      => '',
    //     //   'url'       => 'failed_deposit_summary_report.php'
    //     // ],
    //     [
    //       'title'     => 'รายงานสรุปยอดโยกเงิน',
    //       'page_name' => 'cash_flow_summary_report',
    //       'icon'      => '',
    //       'url'       => 'cash_flow_summary_report.php'
    //     ],
    //     [
    //       'title'     => 'รายงานสรุปผลแยกตามโปรโมชั่น',
    //       'page_name' => 'promotion_summary_report',
    //       'icon'      => '',
    //       'url'       => 'promotion_summary_report.php'
    //     ],
    //     [
    //       'title'     => 'รายงานสรุปผลแยกตามลูกค้า',
    //       'page_name' => 'customer_summary_report',
    //       'icon'      => '',
    //       'url'       => 'customer_summary_report.php'
    //     ],
    //     [
    //       'title'     => 'รายงานการชวนเพื่อน',
    //       'page_name' => 'friend_invite_report',
    //       'icon'      => '',
    //       'url'       => 'friend_invite_report.php'
    //     ],
    //     [
    //       'title'     => 'รายงานโบนัสจากการชวนเพื่อน',
    //       'page_name' => 'friend_bonus_report',
    //       'icon'      => '',
    //       'url'       => 'friend_bonus_report.php'
    //     ],
    //     [
    //       'title'     => 'รายงานหมุนวงล้อ & เล่นไพ่',
    //       'page_name' => 'play_report',
    //       'icon'      => '',
    //       'url'       => 'play_report.php'
    //     ],
    //     [
    //       'title'     => 'รายงานยอดฝากสะสม',
    //       'page_name' => 'deposit_event_report',
    //       'icon'      => '',
    //       'url'       => 'deposit_event_report.php'
    //     ],
    //     [
    //       'title'     => 'รายงานสถานะลูกค้า',
    //       'page_name' => 'customer_status_report',
    //       'icon'      => '',
    //       'url'       => 'customer_status_report.php'
    //     ],
    //     [
    //       'title'     => 'ประวัติการทำงานแอดมิน',
    //       'page_name' => 'history_admin_report',
    //       'icon'      => '',
    //       'url'       => 'history_admin_report.php'
    //     ],
    //     [
    //       'title'     => 'ประวัติ User',
    //       'page_name' => 'history_user_report',
    //       'icon'      => '',
    //       'url'       => 'history_user_report.php'
    //     ],
    //     // [
    //     //   'title'     => 'รายการสรุปการคืนยอด',
    //     //   'page_name' => 'refund_summary',
    //     //   'icon'      => '',
    //     //   'url'       => 'refund_summary.php'
    //     // ],
    //     // [
    //     //   'title'     => 'บัญชีสรุปยอด',
    //     //   'page_name' => 'summary_account',
    //     //   'icon'      => '',
    //     //   'url'       => 'summary_account.php'
    //     // ],
    //   ]
    // ],
    // [
    //   'title'     => 'รายการรายจ่าย',
    //   'page_name' => 'monthly_report',
    //   'icon'      => 'module/no_more_game_agent/assets/icon/icon-menu-admin.svg',
    //   'url'       => '',
    //   'sub_menu'  => [
    //     [
    //       'title'     => 'ยอดรายเดือน',
    //       'page_name' => 'agent_monthly',
    //       'icon'      => '',
    //       'url'       => 'agent_monthly.php'
    //     ],
    //   ]
    // ],
  ]
];

// $hidden_permission_user_ids = ['1', '52'];
// $munu_hidden_permission = [
//   'title'     => 'การพักเงิน',
//   'page_name' => 'management_hold_money',
//   'icon'      => 'module/no_more_game_agent/assets/icon/icon-menu-admin.svg',
//   'url'       => '',
//   'sub_menu'  => [
//     [
//       'title'     => 'การพักเงิน SCB',
//       'page_name' => 'hold_money',
//       'icon'      => '',
//       'url'       => 'hold_money.php'
//     ],
//     [
//       'title'     => 'การพักเงิน KBANK',
//       'page_name' => 'hold_money_kbank',
//       'icon'      => '',
//       'url'       => 'hold_money_kbank.php'
//     ],
//   ]
// ];
// F_WLoves::addMenuHiddenFixPermission($hidden_permission_user_ids, $munu_hidden_permission);
