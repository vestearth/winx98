<div class="w-loves-card border-radius-0 p-0 mb-10px">
  <div id="file_server_log" class="container-pagination no-border-radius" <?= Homepagify::createHomepagify('file_server_log', '', '', 'Log history') ?>>
    <div class="table-responsive">
      <table class="table table-sort table-search">
        <thead>
          <tr>
            <th nowrap data-sort="text" data-filter="<?= Homepagify::dataFilter('text', 'text') ?>">Date modify</th>
            <th nowrap data-sort="text" data-filter="<?= Homepagify::dataFilter('text', 'text') ?>">By</th>
            <th nowrap data-sort="text" data-filter="<?= Homepagify::dataFilter('text', 'text') ?>">Action</th>
            <th nowrap data-sort="text" data-filter="<?= Homepagify::dataFilter('text', 'text') ?>">Compare</th>
            <th nowrap data-sort="text" data-filter="<?= Homepagify::dataFilter('text', 'text') ?>">Table</th>
            <th nowrap data-sort="text" data-filter="<?= Homepagify::dataFilter('text', 'text') ?>">Column name</th>
            <th nowrap data-sort="text" data-filter="<?= Homepagify::dataFilter('text', 'text') ?>">Type</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>