<!-- Category Modal-->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="POST" name="frmUpdateCategory">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="input-update-name-category">Name</label>
						<input type="text" class="form-control" id="input-update-name-category">
					</div>
					<div class="form-group">
						<label for="input-update-slug-category">Slug</label>
						<input type="text" class="form-control" id="input-update-slug-category">
					</div>
					<div class="form-group">
						<label for="">Parent Category</label>
						<select class="custom-select" id="input-update-parent-category">
							<option value="0" selected>-- TOP --</option>
							<?php echo $data['show_option_categories']; ?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" type="button" id="btn-update-detail-category">Update Category</button>
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>

