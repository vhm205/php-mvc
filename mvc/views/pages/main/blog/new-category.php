<div class="row">
	<div class="col-12 col-sm-12 col-md-12 col-lg-4">
		<!-- Dropdown Card Example -->
		<div class="card shadow mb-4">
			<!-- Card Header - Dropdown -->
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Add New Category</h6>
				<div class="dropdown no-arrow">
					<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
						<div class="dropdown-header">Options:</div>
						<a class="dropdown-item" href="#">Save Draft</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</div>
			</div>
			<!-- Card Body -->
			<div class="card-body">
				<div class="form-group">
					<label for="post-category">Name</label>
					<input type="text"
							class="form-control form-control-sm" name="category" id="post-category" aria-describedby="helpId">
				</div>
				<div class="form-group">
					<label for="">Slug</label>
					<input type="text"
							class="form-control form-control-sm" name="slug" id="post-slug-category" aria-describedby="helpId">
				</div>
				<div class="form-group">
					<label for="">Parent Category</label>
					<select class="custom-select" name="parent-category" id="post-parent-category">
						<option value="0" selected>-- TOP --</option>
						<?php echo $data['show_option_categories']; ?>
					</select>
				</div>
				<button type="button" id="btn-add-categories" class="btn btn-outline-primary btn-block mt-1">Add Category</button>
			</div>
		</div>
	</div>
	<div class="col">
		<div class="card mb-4 py-3 border-left-primary">
			<div class="card-body">
				<!-- <nav class="list-categories">
					<ul>
						<li>1</li>
						<li>2
							<ul>
								<li>Child 1</li>
								<li>
									<div class="d-flex justify-content-between">
										<div class="name-category">Child 2</div>
										<div class="category-options">
											<a href="#" data-uid="uid" class="alert-link mr-2 text-danger edit-category">
												<i class="fas fa-pencil-alt"></i>
												Edit
											</a>
											<a href="#" data-uid="uid" class="alert-link text-danger delete-category">
												<i class="fas fa-trash"></i>
												Delete
											</a>
										</div>
									</div>
									<ul>
										<li>Child Child 1</li>
										<li>Child Child 2</li>
									</ul>
								</li>
							</ul>
						</li>
						<li>3</li>
						<li>4</li>
					</ul>
				</nav> -->
				<nav class="list-categories">
					<?php echo $data['show_categories']; ?>
				</nav>
			</div>
		</div>
	</div>
</div>

<script src="./public/js/blog/addCategory.js"></script>
