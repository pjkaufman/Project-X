<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
    <div class="content">
      <div>
        <div class="navbar navbar-default">
          <div class="navbar navbar-default" style="border-style:groove;border-width-bottom:px;border-color:#B0C4DE;background: linear-gradient(#eee,#ddd);">
            <div class="container" style="margin-top:5px;">
              <div class="navbar-brand" style="color:black;">Configuration</div>
            </div>
          </div>
          <div class="container" style="margin:10px;">
            <div class="col-sm-1"></div>
            <div id="config" class="row time_zones">
              <div class="col-sm-3">Time Zone:</div>
              <div class="col-sm-4">
                <select class="time_zone">
                </select>
              </div>
              <div class="col-sm-1"></div>
              <div class="col-sm-3">
                <button id="time_zone" class="update" style="margin-left:20px;width:auto;">Update</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
