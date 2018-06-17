<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    <div class="content">
      <div class="row">
        <div id="drp" class="col-sm-3" style="min-width:300px;"></div>
        <div class="col-sm-3"><button type="button" class="btn btn-success" id="apply" style="width:100%;"><span class="fa fa-filter"></span>Apply</button></div>
        <div class="col-sm-3"><button type="button" class="btn btn-secondary" id="clear" style="width:100%;"><span class="fa fa-refresh"></span>Clear</button></div>
        <div class="col-sm-3"></div>
      </div>
      <div id="table" style="width:100%;"></div>
      <script src="<?php echo base_url() . 'assets/js/logs.js' ?>"></script>
    </div>
  </body>
</html>
