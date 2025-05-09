<?php
$_PAGE['permission'] = ['core', 'core_dev', 'core_dev_school'];

require_once '../../.framework/import.php';
Structure::loadModules(['boatnav', 'brandnote', 'artgraph', 'brandontable']);

// initial data
$topic_list = [
  'name'        => 'School',
  'description' => 'dont be kak',
  'menu'        => [
    110 => [
      'title' => 'Basic : DO & Dont',
      'url'   => '#',
      'count' => 1
    ],
    200 => [
      'title' => 'Module : TIWDAL',
      'url'   => '#',
      'count' => 3
    ],
    400 => [
      'title' => 'Module : IT EXCEL',
      'url'   => '#',
      'count' => 1
    ],
    500 => [
      'title' => 'Module : BRAND NOTE',
      'url'   => '#',
      'count' => 1
    ],
    600 => [
      'title' => 'Module : TIW FORM',
      'url'   => '#',
      'count' => 1
    ],
    700 => [
      'title' => 'Module : Homepagify',
      'url'   => '#',
      'count' => 1
    ],
    800 => [
      'title' => 'Module : BOAT COLOR',
      'url'   => '#',
      'count' => 1
    ],
    300 => [
      'title' => 'Module : BOAT NAV',
      'url'   => '#',
      'count' => 3
    ],
    900 => [
      'title' => 'Module : ART GRAPH',
      'url'   => '#',
      'count' => 2
    ],
    1000 => [
      'title' => 'Module : BRANDONTABLE',
      'url'   => '#',
      'count' => 2
    ],
  ]
  // I think frontend need some tutorial. no ?
];

$topic_sub_list = [
  110 => [
    'title' => 'Rule',
    'menu'  => [
      111 => [
        'name' => 'Setting Vscode',
        'url'  => '#'
      ],
      112 => [
        'name' => 'การตั้งชื่อ',
        'url'  => '#'
      ]
    ]
  ],
  200 => [
    'title' => 'Modal',
    'menu'  => [
      201 => [
        'name' => 'ตัวอย่าง Modal ปกติ (แนะนำ)',
        'url'  => '#'
      ],
      202 => [
        'name' => 'ตัวอย่าง Ajax Modal',
        'url'  => '#'
      ],
      203 => [
        'name' => 'ตัวอย่าง Custom Modal',
        'url'  => '#'
      ]
    ]
  ],
  400 => [
    'title' => 'Excel',
    'menu'  => [
      401 => [
        'name' => 'ตัวอย่าง import to array',
        'url'  => '#'
      ]
    ]
  ],
  500 => [
    'title' => 'HTML Editor',
    'menu'  => [
      501 => [
        'name' => 'วิธีใช้งาน',
        'url'  => '#'
      ]
    ]
  ],
  600 => [
    'title' => 'FORM',
    'menu'  => [
      601 => [
        'name' => 'Normal Form',
        'url'  => '#'
      ],
      602 => [
        'name' => 'Auto Form',
        'url'  => '#'
      ],
      603 => [
        'name' => 'Live Form',
        'url'  => '#'
      ],
      604 => [
        'name' => 'Live Img',
        'url'  => '#'
      ],
      605 => [
        'name' => 'Available Form',
        'url'  => '#'
      ],
    ]
  ],
  700 => [
    'title' => 'Table pagination',
    'menu'  => [
      701 => [
        'name' => 'Generator Table',
        'url'  => '#'
      ],
      702 => [
        'name' => 'Table',
        'url'  => '#'
      ],
      703 => [
        'name' => 'Function',
        'url'  => '#'
      ]
    ]
  ],
  800 => [
    'title' => 'Color',
    'menu'  => [
      801 => [
        'name' => 'ค้นหาสี',
        'url'  => '#'
      ],
      802 => [
        'name' => 'เขียน CSS แบบ WOLVES',
        'url'  => '#'
      ]
    ]
  ],
  300 => [
    'title' => 'Nav',
    'menu'  => [
      301 => [
        'name' => 'แบบ Wolves (Short)',
        'url'  => '#'
      ],
      302 => [
        'name' => 'แบบ Milkclub (Long)',
        'url'  => '#'
      ],
      303 => [
        'name' => 'แบบ Dinner (Top)',
        'url'  => '#'
      ],
      304 => [
        'name' => 'Generator Code',
        'url'  => '#'
      ]
    ]
  ],
  900 => [
    'title' => 'Graph',
    'menu' => [
      901 => [
        'name' => 'กราฟเส้น',
        'url' => '#'
      ],
      902 => [
        'name' => 'กราฟแท่ง',
        'url' => '#'
      ]
    ]
  ],
  1000 => [
    'title' => 'Handsontable',
    'menu' => [
      1001 => [
        'name' => 'วิธีใช้งาน',
        'url' => '#'
      ],
    ]
  ]
];

$topic_id     = isset($_GET['topic']) ? $_GET['topic'] : 110;                                 // default backend can change later
$topic_sub_id = isset($_GET['sub']) ? $_GET['sub'] : key($topic_sub_list[$topic_id]['menu']); // default backend can change later
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  Structure::loadMeta('../../');
  ?>
</head>

<body class="<?= Structure::getThemeClass(); ?>">
  <?php
  include_once '../../structure/layout/header.php';
  include_once '../../structure/layout/sidenav.php';
  ?>

  <!-- Main menu -->
  <div class="container-fluid mt-2">
    <div class="form-row">
      <div class="col-xl-2">
        <div class="position-resize-fixed">
          <div class="topic-container filter-menu-container">
            <div class="topic-header-wrap">
              <h3 class="header-title"><?= $topic_list['name']; ?></h3>
              <p class="header-description"><?= $topic_list['description']; ?></p>
            </div>
            <div class="topic-items-wrap">
              <?php
              foreach ($topic_list['menu'] as $topic_key => $topic) {
                $active = ($topic_id == $topic_key) ? 'active' : '';
              ?>
                <a href="?topic=<?= $topic_key; ?>" class="topic-items filter-menu-items <?= $active; ?>">
                  <span class="topic-title"><?= $topic['title']; ?></span>
                  <span class="topic-count">(<?= number_format($topic['count']); ?>)</span>
                </a>
              <?php
              }
              ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-2">
        <div class="w-loves-card position-resize-fixed p-0 m-3">
          <div class="sub-topic-container filter-menu-container">
            <div class="p-15px">
              <h5 class="mb-0"><?= $topic_list['menu'][$topic_id]['title']; ?></h5>
            </div>
            <hr>
            <div class="sub-topic-items-wrap">
              <?php
              foreach ($topic_sub_list as $topic_key => $topic_sub_list_data) {
                if ($topic_key == $topic_id) {
              ?>
                  <div class="sub-topic-items-group">
                    <div class="px-15px">
                      <h3><?= $topic_sub_list_data['title']; ?></h3>
                    </div>
                    <?php
                    foreach ($topic_sub_list_data['menu'] as $topic_sub_key => $topic_sub) {
                      $active = ($topic_sub_id == $topic_sub_key) ? 'active' : '';
                    ?>
                      <a href="?topic=<?= $topic_id; ?>&sub=<?= $topic_sub_key; ?>" class="sub-topic-items filter-menu-items <?= $active; ?>">
                        <span class="sub-topic-title">
                          <?= $topic_sub['name']; ?>
                        </span>
                      </a>
                    <?php
                    }
                    ?>
                  </div>
              <?php
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-8">
        <div class="w-love-content-container">
          <div class="w-love-content-container-wrap">
            <?php
            if ($topic_sub_id == 111) {
              include_once 'view/school/basic111.php';
            } else if ($topic_sub_id == 112) {
              include_once 'view/school/basic112.php';
            } else if ($topic_sub_id == 201) {
              include_once 'view/school/fontend201.php';
            } else if ($topic_sub_id == 202) {
              include_once 'view/school/fontend202.php';
            } else if ($topic_sub_id == 203) {
              include_once 'view/school/fontend203.php';
            } else if ($topic_sub_id == 301) {
              include_once 'view/school/fontend301.php';
            } else if ($topic_sub_id == 302) {
              include_once 'view/school/fontend302.php';
            } else if ($topic_sub_id == 303) {
              include_once 'view/school/fontend303.php';
            } else if ($topic_sub_id == 304) {
              include_once 'view/school/fontend304.php';
            } else if ($topic_sub_id == 401) {
              include_once 'view/school/fontend401.php';
            } else if ($topic_sub_id == 501) {
              include_once 'view/school/fontend501.php';
            } else if ($topic_sub_id == 601) {
              include_once 'view/school/fontend601.php';
            } else if ($topic_sub_id == 602) {
              include_once 'view/school/fontend602.php';
            } else if ($topic_sub_id == 603) {
              include_once 'view/school/fontend603.php';
            } else if ($topic_sub_id == 604) {
              include_once 'view/school/fontend604.php';
            } else if ($topic_sub_id == 605) {
              include_once 'view/school/fontend605.php';
            } else if ($topic_sub_id == 701) {
              include_once 'view/school/fontend701.php';
            } else if ($topic_sub_id == 702) {
              include_once 'view/school/fontend702.php';
            } else if ($topic_sub_id == 703) {
              include_once 'view/school/fontend703.php';
            } else if ($topic_sub_id == 801) {
              include_once 'view/school/fontend801.php';
            } else if ($topic_sub_id == 802) {
              include_once 'view/school/fontend802.php';
            } else if ($topic_sub_id == 803) {
              include_once 'view/school/fontend803.php';
            } else if ($topic_sub_id == 901) {
              include_once 'view/school/fontend901.php';
            } else if ($topic_sub_id == 902) {
              include_once 'view/school/fontend902.php';
            } else if ($topic_sub_id == 1001) {
              include_once 'view/school/fontend1001.php';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  include_once '../../structure/layout/footer.php';
  Structure::loadFooter('../../');
  ?>
  <script>
    resizeFixed();

    $(document).ready(function() {
      $(window).on('resize', function() {
        resizeFixed();
      });
    });

    function resizeFixed() {
      var new_width = $('.col-xl-2').width() - 30;
      $('.position-resize-fixed').width(new_width);
    }
  </script>
</body>

</html>