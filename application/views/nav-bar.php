<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo base_url() .'index.php/home'; ?>">Project X</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active">
          <a href="<?php echo base_url() .'index.php/home'; ?>">
            <span class="glyphicon glyphicon-home"></span> Home <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-wrench"></span>Administration <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() .'index.php/config'; ?>"><span class="glyphicon glyphicon-cog"></span> Configuration</a></li>
            <li><a href="<?php echo base_url() .'index.php/versions'; ?>"><span class="glyphicon glyphicon-file"></span> Version Info</a></li>
             <li><a href="<?php echo base_url() .'index.php/logs'; ?>"><span class="glyphicon glyphicon-blackboard"></span> Logs </a></li>
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><div id="clock" class="clock">loading ...</div></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <span class="glyphicon glyphicon-user"></span><?php echo ' ' . $_SESSION['username']; ?> <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="<?php echo base_url() .'index.php/account'; ?>"><span class="glyphicon glyphicon-eye-open"></span> Profile</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="<?php echo base_url() . 'index.php/user/logout'; ?>"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
