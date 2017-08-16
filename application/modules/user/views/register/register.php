<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container">
	<div class="log-in">
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
				<div class="page-header">
					<h1>Register</h1>
				</div>
				<?= form_open() ?>
					<div class="form-group">
						<label for="username">Username</label>
						<div class="input-group">
							<span class="input-group-addon fa fa-user" id="basic-addon1"></span>
							<input type="text" id="username" name="username" class="form-control" placeholder="Enter a username" aria-describedby="basic-addon1">
					 </div>
						<p class="help-block">At least 4 characters, letters or numbers only</p>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<div class="input-group">
							<span class="input-group-addon fa fa-envelope" id="basic-addon1"></span>
							<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" aria-describedby="basic-addon1">
					 </div>
						<p class="help-block">A valid email address</p>
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<div class="input-group">
							<span class="input-group-addon fa fa-lock" id="basic-addon1"></span>
							<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password" aria-describedby="basic-addon1">
						</div>
						<p class="help-block">At least 6 characters</p>
					</div>
					<div class="form-group">
						<div class="input-group">
						<label for="password_confirm">Confirm password</label>
						<div class="input-group">
							<span class="input-group-addon fa fa-lock" id="basic-addon1"></span>
							<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password" aria-describedby="basic-addon1">
						</div>
						</div>
						<p class="help-block">Must match your password</p>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-default" value="Register">
					</div>
				</form>
			</div>
		</div>
	</div><!-- .row -->
</div><!-- .container -->
