$( document ).ready(function() {
    $('p#profile').click(function(){
      add_form();
    });
});

function add_form(){
  var form = '<?php echo $error;?>

<?php echo form_open_multipart(\'upload/do_upload\');?>

<input type="file" name="userfile" size="20" />

<br /><br />

<input type="submit" value="upload" />

</form>';
}
