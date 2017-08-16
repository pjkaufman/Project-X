<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="row">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
		<div class="col-md-12">
			<div class="log-in">
				<div class="page-header">
					<h1>Login</h1>
				</div>
				<?= form_open() ?>
				<div class="input-group" style="margin:2px;width:99%;">
						<div class="form-group">
							<div class="input-group" style="margin-bottom:10px;">
  							<span class="input-group-addon fa fa-user" id="basic-addon1"></span>
  							<input type="text" id="username" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
						 </div>
						<div class="form-group" style="margin-bottom:15px;">
							<div class="input-group">
								<span class="input-group-addon fa fa-lock" id="basic-addon1"></span>
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-describedby="basic-addon1">
							</div>
						</div>
							<div class="form-group">
								<input style="float: left; margin-right: 10px" type="submit" class="btn btn-default" value="Login">
							</div>
				</div>
				</form>
				<div>
						<a href="<?php echo base_url('index.php/user/register');?>"><p class="btn btn-default">New User</p></a>
			 	</div>
			</div>
		</div>
	</div><!-- .row -->
</div><!-- .container -->
