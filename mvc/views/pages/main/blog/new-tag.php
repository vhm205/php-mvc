<form action="" method="post" name="frmNewTag">
	<div class="row">
		<div class="col-12 col-sm-12 col-md-12 col-lg-4">
			<!-- Dropdown Card Example -->
			<div class="card shadow mb-4">
				<!-- Card Header - Dropdown -->
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Add New Tag</h6>
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
								class="form-control form-control-sm" name="tag" id="post-tag" aria-describedby="helpId" required>
						<small class="form-text help-text text-muted">Help text</small>
					</div>
					<button type="button" id="btn-add-tag" class="btn btn-outline-primary btn-block mt-1">Add Tag</button>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card mb-4 py-3 border-left-primary">
				<div class="card-body">
					<div class="clearfix">
						<button type="button" id="btn-delete-tag-checked" class="btn btn-danger mb-2 float-right">Delete</button>
					</div>
					<div class="list-group-item d-flex justify-content-between align-items-center form-check-all-tag bg-primary text-white">
						<div class="form-check form-check-inline">
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="input-check-all-tag">
								<label class="custom-control-label header-tag" for="input-check-all-tag">Name</label>
							</div>
						</div>
						<div class="header-tag">Options</div>
					</div>
					<ul class="list-group list-tags">
						<?php foreach ($data['tags'] as $value) { ?>
							<li class="list-group-item d-flex justify-content-between align-items-center" data-uid="<?php echo $value['ID']; ?>">
								<div class="form-check form-check-inline">
									<label class="form-check-label">
										<div class="tagname d-flex">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="ckTag<?php echo $value['ID']; ?>" value="<?php echo $value['ID']; ?>">
												<label class="custom-control-label" for="ckTag<?php echo $value['ID']; ?>"></label>
											</div>
											<input type="text" class="form-control form-control-sm d-none input-edit-name" value="<?php echo $value['NAME']; ?>">
											<span class="tag ml-1"><?php echo $value['NAME']; ?></span>
										</div>
									</label>
								</div>
								<div class="tag-options">
									<a href="#" data-uid="<?php echo $value['ID']; ?>" class="alert-link mr-2 text-primary edit-tag">
										<i class="fas fa-pencil-alt"></i>
										Edit
									</a>
									<a href="#" data-uid="<?php echo $value['ID']; ?>" class="alert-link text-primary delete-tag">
										<i class="fas fa-trash"></i>
										Delete
									</a>
								</div>
							</li>
						<?php } ?>
					</ul>
					<ul class="pagination mt-2 float-right">
						<!-- Previous Page -->
						<li class="page-item <?php if($data['current_page'] === 1) echo 'disabled'; ?>">
							<a class="page-link" href="./Blog/NewTag/<?php echo ($data['current_page'] - 1); ?>">Previous</a>
						</li>

						<?php for ($i = 1; $i <= $data['total']; $i++) { ?>
							<li class="page-item <?php if($data['current_page'] === $i) echo 'active'; ?>">
								<a class="page-link" href="./Blog/NewTag/<?php echo $i; ?>"><?php echo $i; ?></a>
							</li>
						<?php } ?>
						
						<!-- Next Page -->
						<li class="page-item <?php if($data['current_page'] === $data['total']) echo 'disabled'; ?>">
							<a class="page-link" href="./Blog/NewTag/<?php echo ($data['current_page'] + 1); ?>">Next</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</form>

<script src="./public/js/blog/addTag.js"></script>
