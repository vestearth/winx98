<div class="content-header-container">
  <h3 class="header-title text-info">กราฟเส้น</h3>
</div>
<div class="content-body-container">
  <div class="form-row">
    <div class="col-12">
      <?php
      $data = [
        'label' => ['2021-08-08', '2021-09-08', '2021-10-08', '2021-11-08', '2021-12-08'],
        'cat' => [51, 41, 30, 20, 10],
        'dog' => [10, 20, 30, 40, 50],
        'pig' => [41, 50, 80, 50, 25],
      ];
      $options = [
        'title' => [
          'name' => 'ทดสอบ TITLE',
          'position' => 'center'
        ],
        'label' => [
          'position' => 'start'
        ],
        'x' => [
          'title' => 'แกน X',
        ],
        'y' => [
          'title' => 'แกน Y',
        ]
      ];
      Artgraph::line('graph_1', $data, $options);
      ?>
    </div>
  </div>
  <div class="form-row">
    <div class="col-12">
    </div>
  </div>
</div>