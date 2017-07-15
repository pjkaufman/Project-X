<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">
      <div class="well well-sm">
        <div class="row">
          <div class="col-sm-6 col-md-4">
            <img id="profile-pic" width="200" height="200" src="<?php echo base_url() . 'assets/images/' . $_SESSION['avatar'];?>" alt="Profile picture" class="img-rounded img-responsive" />
          </div>
            <div class="col-sm-6 col-md-8">
              <h4><i class="glyphicon glyphicon-user"></i><?php echo $_SESSION['username'];?></h4>
              <p>
              <i class="glyphicon glyphicon-envelope"></i><?php echo $_SESSION['email'];?>
              <br />
              Admin:
              <?php
                if ($_SESSION['is_admin']===false){
                  echo 'false';
                }else{
                  echo 'true';
                }
              ?>
              <br />
              <p id="profile"><span class="btn btn-info">Change Profile Picture</span></p>
              <div style="display: none;" id="add-image">
                <?php echo $error;?>
                <?php echo form_open_multipart('account/do_upload');?>
                  <input type="file" name="userfile" size="20" />
                  <br /><br />
                  <input type="submit" value="upload" />
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
</body>
</html>
