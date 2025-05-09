<div class="content-header-container">
  <h3 class="header-title text-info">กราฟแท่ง แนวตั้ง</h3>
</div>
<div class="content-body-container">
  <div class="form-row">
    <div class="col-12">
      <?php
      $data = [
        'label' => ['2021-08-08', '2021-09-08', '2021-10-08', '2021-11-08', '2021-12-08'],
        'cat' => [51, 41, 30, 20, 10],
        'dog' => [10, 20, 30, 40, 100],
        'pig' => [25, 51, 80, 50, 25],
      ];
      $options = [
        'title' => [
          'name' => 'ทดสอบ TITLE',
          'position' => 'center'
        ],
        'label' => [
          'position' => 'center'
        ],
        'startzero' => true
      ];
      Artgraph::line('graph_1', 'bar', $data, $options);
      ?>
    </div>
  </div>
</div>

<div class="content-header-container mt-20px">
  <h3 class="header-title text-info">กราฟแท่ง แนวนอน</h3>
</div>
<div class="content-body-container">
  <div class="form-row">
    <div class="col-12">
      <?php
      $data = [
        'label' => ['2021-08-08', '2021-09-08', '2021-10-08', '2021-11-08', '2021-12-08'],
        'cat' => [51, 41, 30, 20, 10],
        'dog' => [10, 20, 30, 40, 100],
        'pig' => [25, 51, 80, 50, 25],
      ];
      $options = [
        'title' => [
          'name' => 'ทดสอบ TITLE',
          'position' => 'center'
        ],
        'label' => [
          'position' => 'center'
        ],
        'startzero' => true
      ];
      Artgraph::line('graph_2', 'bar_horizontal', $data, $options);
      ?>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>