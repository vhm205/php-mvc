<!-- Profile Modal-->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="POST" name="frmUpdateProfile">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Your Profile</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="userId" value="<?php echo $data['user'][0]['ID'] ?>" />
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" name="email" id="email" value="<?php echo $data['user'][0]['EMAIL'] ?>" disabled>
					</div>
					<div class="form-group">
						<label for="fullname">Full Name</label>
						<input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $data['user'][0]['FULLNAME'] ?>">
						<div class="invalid-feedback" id="fullname-message"></div>
					</div>
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input type="number" class="form-control" name="phone" id="phone" value="<?php echo $data['user'][0]['PHONE'] ?>">
						<div class="invalid-feedback" id="phone-message"></div>
					</div>
					<div class="form-group">
						<label class="d-block">Gender</label>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="gender-male" name="gender" value="male" 
							<?php if($data['user'][0]['GENDER'] === 'male') echo 'checked'; ?>>
							<label class="custom-control-label" for="gender-male">Male</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="gender-female" name="gender" value="female" 
							<?php if($data['user'][0]['GENDER'] === 'female') echo 'checked'; ?>>
							<label class="custom-control-label" for="gender-female">Female</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="gender-another" name="gender" value="another"
							<?php if($data['user'][0]['GENDER'] === 'another') echo 'checked'; ?>>
							<label class="custom-control-label" for="gender-another">Another</label>
						</div>
					</div>
					<div class="form-group d-flex">
						<img src="./public/images/<?php echo $data['user'][0]['AVATAR'] ?>" class="img-thumbnail img-fluid avatar-preview mr-3" id="avatar-preview" alt="preview">
						<div class="custom-file">
							<input type="file" class="custom-file-input" id="avatar" name="avatar" accept="image/*">
							<label class="custom-file-label" for="avatar">Choose file</label>
						</div>
					</div>					
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="submit">Update Profile</button>
					<button class="btn btn-secondary" type="button" data-dismiss="modal" id="btn-cancel">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

