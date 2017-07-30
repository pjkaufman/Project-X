<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
    <div class="content">
      <div class="navbar navbar-default">
        <div class="navbar navbar-inverse bg-inverse" style="border-style:groove;border-width-bottom:px;border-color:#B0C4DE;">
          <div class="container" style="margin-top:5px;">
            <div class="navbar-brand" style="color:#eee;margin-left:10px;">Plugin and Dependency Versions</div>
            <ul class="nav navbar-nav navbar-right">
              <button id="remove" class="btn btn-danger" style="width:auto;"><span class="glyphicon glyphicon-minus"></span>Remove Version</button>
              <button id="add" class="btn btn-primary" style="margin-left:20px;width:auto;"><span class="glyphicon glyphicon-plus"></span>Add New Version</button>
            </ul>
          </div>
        </div>
        <div id="modal-container">
        </div>
        <div class="container">
          <div id="versions">
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
