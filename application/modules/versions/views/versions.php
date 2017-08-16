<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
    <div class="content">
      <div class="navbar navbar-default">
        <div class="navbar navbar-default" style="border-style:groove;border-width-bottom:px;border-color:#B0C4DE;background: linear-gradient(#eee,#ddd);">
          <div class="container" style="margin-top:5px;">
            <div class="navbar-brand" style="color:black;margin-left:10px;">Plugin and Dependency Versions</div>
            <ul class="nav navbar-nav navbar-right">
              <div id="btn_wrapper" style="margin-top:5px;margin-right:5px;">
                <button id="remove" class="btn btn-danger" style="width:auto;"><span class="fa fa-minus"></span>Remove Version</button>
                <button id="add" class="btn btn-primary" style="margin-left:20px;width:auto;"><span class="fa fa-plus"></span>Add New Version</button>
              </div>
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
