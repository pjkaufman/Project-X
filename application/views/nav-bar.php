<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
  <div id="wrapper">
      <!-- Navigation from https://startbootstrap.com/template-overviews/sb-admin/ -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
          <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="<?php echo base_url() . 'index.php/home'; ?>">Project X</a>
          </div>
          <!-- Top Menu Items -->
          <ul class="nav navbar-right top-nav">
              <li class="active"><div id="clock" class="clock" style="color:#999;text-shadow:none;">loading ...</div></li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo ' ' . $_SESSION['username'] . ' '; ?> <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                      <li>
                          <a href="<?php echo base_url() . 'index.php/account'; ?>"><i class="fa fa-fw fa-user"></i> Profile</a>
                      </li>
                      <li class="divider"></li>
                      <li>
                          <a href="<?php echo base_url() . 'index.php/user/logout'; ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                      </li>
                  </ul>
              </li>
          </ul>
          <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
          <nav class="collapse navbar-collapse navbar-ex1-collapse">
              <ul class="nav navbar-nav side-nav">
                  <li class="active">
                      <a href="<?php echo base_url() . 'index.php/home'; ?>"><i class="fa fa-fw fa-home"></i> Home</a>
                  </li>
                  <li>
                      <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-wrench"></i> Administartion<i class="fa fa-fw fa-caret-down"></i></a>
                      <ul id="demo" class="collapse">
                          <li>
                              <a href="<?php echo base_url() . 'index.php/config'; ?>"><i class="fa fa-fw fa-cog"></i> Configuration</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url() . 'index.php/versions'; ?>"><i class="fa fa-fw fa-info-circle"></i> Version Info</a>
                          </li>
                          <li>
                              <a href="<?php echo base_url() . 'index.php/logs'; ?>"><i class="fa fa-fw fa-file"></i> Logs</a>
                          </li>
                      </ul>
                  </li>
                </ul>
          <!-- /.navbar-collapse -->
      </nav>
  </div>
  <!-- /#wrapper -->
</body>

</html>
