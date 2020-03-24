<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">

            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>
              <!-- Alert  -->
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
	        <?php } if(isset($data['success']) && $data['success'] !== ''){ ?>
	            <div class="mb-4">
	              <div class="card bg-success text-white shadow">
	                <div class="card-body" id="message-success">
	                  <?php echo $data['success']; ?>
	                </div>
	              </div>
	            </div>
				<script>
					Swal.mixin({
						toast: true,
						position: 'top-end',
						showConfirmButton: false,
						timer: 5000,
						timerProgressBar: true,
						onOpen: (toast) => {
							toast.addEventListener('mouseenter', Swal.stopTimer)
							toast.addEventListener('mouseleave', Swal.resumeTimer)
						}
					}).fire({
						icon: 'success',
						title: '<?php echo $data['success'] ?>'
					}).then(_ => document.getElementById('a-login').click())
				</script>
	        <?php } ?>
              <form class="user" method="POST" name="frm" action="./Register/PostRegister">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" name="first" class="form-control form-control-user" id="input-first" value="<?php if(isset($firstname)) echo $firstname; ?>" placeholder="First Name" autocomplete="on" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" name="last" class="form-control form-control-user" id="input-last" value="<?php if(isset($lastname)) echo $lastname; ?>" placeholder="Last Name" autocomplete="on" required>
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-user" id="input-email" value="<?php if(isset($email)) echo $email; ?>" placeholder="Email Address" autocomplete="on" required>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" name="password" class="form-control form-control-user" id="input-password" placeholder="Password" autocomplete="off" required>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" name="confirmpassword" class="form-control form-control-user" id="input-confirm-password" placeholder="Repeat Password" autocomplete="off" required>
                  </div>
                </div>
                <input type="submit" name="registerbtn" class="btn btn-primary btn-user btn-block" value="Register Account">
                <hr>
                <a href="#" class="btn btn-google btn-user btn-block">
                  <i class="fab fa-google fa-fw"></i> Register with Google
                </a>
                <a href="#" class="btn btn-facebook btn-user btn-block">
                  <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                </a>
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="./ForgotPassword">Forgot Password?</a>
              </div>
              <div class="text-center">
                <a class="small" id="a-login" href="./Login">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

</div>