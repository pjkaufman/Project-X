<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
  <div class="content">
    <h2 style="text-align:center">The Database Difference Checker</h2>
    <div>
      <p>The Database Difference Checker can take a snapshot of a database and compare two databases based on user input</p>
    </div>
    <div class="options">
      <div class="Snapshot" style="display: inline-block">
      <button class="glyphicon glyphicon-camera .btn-default"> Snapshot </button>
    </div>
    <div class="DB2" style="display: inline-block">
    <button class="glyphicon glyphicon-duplicate .btn-default"> Database Comparison (2 DB's)</button>
  </div>
  <div class="DB1" style="display: inline-block">
  <button class="glyphicon glyphicon-file .btn-default"> Database Comparison (1 DB)</button>
</div>
<div class="reset" style="display: inline-block">
<button class="glyphicon glyphicon-refresh .btn-default"> Reset </button>
</div>
<div class="spinner" style="display: inline-block">
<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>
</div>
  <div class="result">
    <h4 id="rTitle"></h4>
    <pre style='padding: 20px; background-color: #FFFAF0'></pre>
  </div>
    </div>
    <script src="<?php echo base_url() . 'assets/js/compare.js' ?>"></script>
  </div>
  </body>
</html>
