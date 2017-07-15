      <div id="account-info">
        <img id="profile-pic" width="200" height="200" src="<?php echo base_url() . 'assets/images/' . $_SESSION['avatar'];?>" class="rounded mx-auto d-block" alt="profile picture">
        <p id="profile"><span class="label label-info">Change profile</span></p>
        <div style="display: none;" id="add-image">
          <?php echo $error;?>
          <?php echo form_open_multipart('account/do_upload');?>
          <input type="file" name="userfile" size="20" />
          <br /><br />
          <input type="submit" value="upload" />
        </form>
        </div>
        <p><span class="label label-default">Username: </span><?php echo $_SESSION['username'];?></p>
        <p><span class="label label-default">Email: </span><?php echo $_SESSION['email'];?></p>
        <p><span class="label label-default">Admin: </span>
          <?php
            if ($_SESSION['is_admin']===false){
              echo 'false';
            }else{
              echo 'true';
            }
            ?>
        </p>
      </div>
  </body>
</html>
