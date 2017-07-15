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
				<div class="input-group" style="margin: 2px;">
						<div class="form-group">
							<label for="username">Username</label>
							<div class="input-group">
  							<span class="input-group-addon glyphicon glyphicon-user" id="basic-addon1"></span>
  							<input type="text" id="username" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1">
						 </div>
						<div class="form-group">
							<label for="password">Password</label>
							<div class="input-group">
								<span class="input-group-addon glyphicon glyphicon-lock" id="basic-addon1"></span>
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" aria-describedby="basic-addon1">
							</div>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-default" value="Login">
						</div>
				</div>
				</form>
				<div>
						<a href="<?php echo base_url('index.php/user/register');?>"><p>New User</p></a>
			 	</div>
			</div>
		</div>
	</div><!-- .row -->
</div><!-- .container -->
