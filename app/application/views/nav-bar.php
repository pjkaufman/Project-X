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
                          <a href="javascript:;" class="href"><?php echo $_SESSION['links']['Profile']['name'] ?></a>
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
              <?php
                $drp = 1;
                foreach( $_SESSION['links'] as $link ) {
                    if ( $_SESSION['is_admin']===true || ( $_SESSION['is_admin']===false && $link['access'] != 1 )) {
                        switch ( $link['code']) {
                            case 0: // the link is just a list item, nothing more
                                echo "<li>";
                                echo "<a href='javascript:;' class='href'> " . $link['name'] . "</a>";
                                echo "</li>";
                                break;
                            case 1: // the link is a start of a dropdown list
                                echo '<li>';
                                echo "<a href='javascript:;' data-toggle='collapse' data-target='#drp" . $drp . "'>" . $link['name'] . "</a>";
                                echo '<ul id="drp' . $drp . '" class="collapse">';
                                $drp++;
                                break;
                            case 2: // the link is the end of a dropdown list
                                echo "<li>";
                                echo "<a href='javascript:;' class='href'> " . $link['name'] . "</a>";
                                echo "</li>";
                                echo "</ul>";
                                break;
                            case 3: // the link is the active link
                                echo '<li class="active">';
                                echo "  <a href='javascript:;' class='href'>" . $link['name'] . "</a>";
                                echo '</li>';
                                break;
                            defualt:
                                break;
                        } 
                    }
                }
            ?>
                </ul>
          <!-- /.navbar-collapse -->
      </nav>
  </div>
  <!-- /#wrapper -->
  <script src="<?php echo base_url() . 'assets/js/navbar.js' ?>"></script>
</body>

</html>
