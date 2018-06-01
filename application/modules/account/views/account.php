<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
    <div class="content">
      <div class="container" id="right">
        <div class="row">
          <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="well well-sm">
              <div class="row">
                <div class="col-sm-6 col-md-4">
                  <img id="profile-pic" width="200" height="200" src="<?php echo base_url() . 'assets/images/' . $_SESSION['avatar'];?>" alt="Profile picture" class="img-rounded img-responsive" />
                  <p id="profile" style="margin-top: 3px;"><span class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i>Change Picture</span></p>
                  <div style="display: none;" id="add-image">
                    <?php echo $error;?>
                    <?php echo form_open_multipart('account/do_upload');?>
                      <input type="file" name="userfile" size="20" />
                      <br /><br />
                      <input type="submit" value="upload" />
                    </form>
                  </div>
                </div>
                  <div class="col-sm-6 col-md-8">
                    <h4><i class="glyphicon glyphicon-user"></i><?php echo $_SESSION['username'];?></h4>
                    <p>
                    <i class="glyphicon glyphicon-envelope"></i><?php echo $_SESSION['email'];?>
                    <br />
                    <i class="glyphicon glyphicon-certificate"></i>
                    <?php
                      if ($_SESSION['is_admin']===false) {
                          echo 'User';
                      } else {
                          echo 'Admin';
                      }
                    ?>
                    <br />
                    <i class="glyphicon glyphicon-calendar"></i>Last Login: <?php echo $_SESSION['last_login'];?>
                    <br />
                    <i class="glyphicon glyphicon-piggy-bank"></i>Logins: <?php echo $_SESSION['num_logins'];?>
                    <br />
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </body>
</html>
