<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

	<div class="col-xl-10 col-lg-12 col-md-9">

		<div class="card o-hidden border-0 shadow-lg my-5">
			<div class="card-body p-0">
				<!-- Nested Row within Card Body -->
				<div class="row">
					<div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
					<div class="col-lg-6">
						<div class="p-5">
							<div class="text-center">
								<h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
							</div>
							<?php if(isset($data['errors']) && count($data['errors']) > 0) { ?>
									<div class="mb-4">
										<div class="card bg-danger text-white shadow">
											<div class="card-body" id="message-error">
												<?php foreach ($data['errors'] as $value): ?>
													<?php echo $value . '<br />'; ?>
												<?php endforeach ?>
											</div>
										</div>
									</div>
							<?php } ?>
							<form class="user" method="POST" name="frm" action="./Login/PostLogin">
								<div class="form-group">
									<input type="email" name="email" class="form-control form-control-user" id="input-email" value="<?php if(isset($email)) echo $email; ?>" placeholder="Email Address" autocomplete="on" required>
								</div>
								<div class="form-group">
									<input type="password" name="password" class="form-control form-control-user" id="input-password" placeholder="Password" autocomplete="off" required>
								</div>
								<div class="form-group">
									<div class="custom-control custom-checkbox small">
										<input type="checkbox" name="remember" class="custom-control-input" id="input-remember">
										<label class="custom-control-label" for="input-remember">Remember Me</label>
									</div>
								</div>
								<input type="submit" name="loginbtn" class="btn btn-primary btn-user btn-block" value="Login">
								<hr>
								<a href="index.html" class="btn btn-google btn-user btn-block">
									<i class="fab fa-google fa-fw"></i> Login with Google
								</a>
								<a href="index.html" class="btn btn-facebook btn-user btn-block">
									<i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
								</a>
							</form>
							<hr>
							<div class="text-center">
								<a class="small" href="./ForgotPassword">Forgot Password?</a>
							</div>
							<div class="text-center">
								<a class="small" href="./Register">Create an Account!</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

</div>

</div>
