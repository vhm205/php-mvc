<div class="element">
	<div class="element-main">
		<h1>New Password</h1>
		<p></p>
		<?php require_once './mvc/views/blocks/message.php' ?>
		<form method="POST" action="./ForgotPassword/reset">
			<div class="form-group">
				<input type="password" name="newpassword" class="form-control form-control-user" id="input-newpassword" placeholder="New Password" autocomplete="off" required>
			</div>
			<input type="hidden" name="email" value="<?php echo $data['email'] ?? null  ?>" />
			<input type="hidden" name="code" value="<?php echo $data['code'] ?? null ?>" />
			<input type="submit" name="btnResetPassword" class="btn btn-primary btn-user btn-block" value="Sign Up"><hr>
		</form>
		<div class="text-center">
			<a class="small" href="./Login">Already have an account? Login!</a>
		</div>
		<div class="text-center">
			<a class="small" href="./Register">Create an Account!</a>
		</div>
	</div>
</div>