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
					<div style="margin: 2px;" >
						<div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Your username">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" id="password" name="password" placeholder="Your password">
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
