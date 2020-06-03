<form action="" method="post" name="frmNewPost">
	<div class="row mb-3">
		<div class="col d-flex flex-row-reverse">
			<!-- Button Open Config -->
			<a href="#" class="post-config ml-3 mt-2">
				<i class="fas fa-cog"></i>
			</a>
			<!-- Button Public -->
			<a href="#" class="btn btn-primary btn-icon-split btn-public-post">
				<span class="icon text-white-50">
					<i class="fas fa-flag"></i>
				</span>
				<span class="text">Public</span>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<!-- Dropdown Card Example -->
			<div class="card shadow mb-4">
				<!-- Card Header - Dropdown -->
				<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Add New Post</h6>
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
					<input type="text" class="form-control" name="title" id="post-title" placeholder="Title">
					<hr />
					<textarea id="editor" name="content"></textarea>
				</div>
			</div>
		</div>
		<div class="col col-md-4 col-lg-3 post-toolbar">
			<div class="card mb-4 py-3 border-left-primary">
				<div class="card-body">
					<div class="form-group">
						<label for="post-slug">Slug</label>
						<input type="text" class="form-control" name="slug" id="post-slug" aria-describedby="helpIdSlug" disabled>
						<small id="helpIdSlug" class="form-text text-muted"></small>
					</div>
					<div class="form-group">
						<label for="post-tag">Tag</label>
						<input type="text" class="form-control" name="tag" id="post-tag" aria-describedby="helpIdTag">
						<small id="helpIdTag" class="form-text text-muted"></small>
					</div>
					<div class="form-group">
						<label>Categories</label>
						<select multiple class="form-control" name="categories" id="post-categories">
							<<?php echo $data['show_option_categories']; ?>
						</select>
						<div class="contain-categories p-1" data-ids=""></div>
						<button type="button" id="btn-add-categories" class="btn btn-outline-primary btn-block mt-1">Add categories</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script src="./vendor/ckeditor/ckeditor/ckeditor.js"></script>
<script src="./public/js/configCkeditor.js"></script>
<script src="./public/js/blog/addPost.js"></script>
