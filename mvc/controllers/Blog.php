<?php 
	class Blog extends Controller
	{
		protected $UserModel = NULL;
		protected $BlogModel = NULL;
		protected $user = NULL;

		public function __construct() {
			if(!isset($_COOKIE['is_logged'])){
				Functions::logout();
			}

			require_once './mvc/middleware/CheckCache.php';
			require_once './mvc/validation/blogValid.php';
			$this->UserModel = $this->model('UserModel');
			$this->BlogModel = $this->model('BlogModel');
			$this->user = GetUserInfo($this->UserModel);
		}

		public function index()
		{
			header('location: ' . ORIGIN_URL . '/error/404.php');
		}

		public function NewPost()
		{
			$categories = $this->BlogModel->getAllCategories();
			$showOptionsCategories = $this->showListCategories($categories, 0, 'option');

			$this->view('master-main', [
				'page' => 'main/blog/new-post',
				'show_option_categories' => $showOptionsCategories,
				'user' => $this->user ?? Functions::logout()
			]);
		}

		public function NewCategory()
		{
			$categories = $this->BlogModel->getAllCategories();
			$showCategories = $this->showListCategories($categories);
			$showOptionsCategories = $this->showListCategories($categories, 0, 'option');
			
			$this->view('master-main', [
				'page' => 'main/blog/new-category',
				'show_option_categories' => $showOptionsCategories,
				'show_categories' => $showCategories,
				'user' => $this->user ?? Functions::logout()
			]);
		}

		public function NewTag($currentPage = 1)
		{
			if(!Validation::valid_integer($currentPage) || $currentPage < 1) $currentPage = 1;

			$limit = 5;
			$allTags = count($this->BlogModel->getAllTag());
			$tagOnePage = ceil($allTags / $limit);
			$offset = ($currentPage * $limit) - $limit;
			$getTagsByLimit = $this->BlogModel->getTagsByLimit($offset, $limit);

			if($currentPage > $tagOnePage) $currentPage = $tagOnePage;

			$this->view('master-main', [
				'page' => 'main/blog/new-tag',
				'tags' => $getTagsByLimit,
				'total' => (int)$tagOnePage,
				'current_page' => (int)$currentPage,
				'user' => $this->user ?? Functions::logout()
			]);
		}

		// Handle Tags

		public function addNewTag()
		{
			$name = Validation::safe($_REQUEST['name']);
			$errors = ValidBlogTag($name, $this->BlogModel);

			if(count($errors) === 0){
				$addTag = $this->BlogModel->addNewTag([
					'NAME' => $name,
					'SLUG' => Functions::toSlug($name)
				]);

				if($addTag){
					$htmlInfo = "
						<li class='list-group-item d-flex justify-content-between align-items-center' data-uid='$addTag'>
							<div class='form-check form-check-inline'>
								<label class='form-check-label'>
									<div class='tagname d-flex'>
										<div class='custom-control custom-checkbox'>
											<input type='checkbox' class='custom-control-input' id='ckTag$addTag' value='$addTag'>
											<label class='custom-control-label' for='ckTag$addTag'></label>
										</div>
										<input type='text' class='form-control form-control-sm d-none input-edit-name' value='$name'>
										<span class='tag ml-1'>$name</span>
									</div>
								</label>
							</div>
							<div class='tag-options'>
								<a href='#' data-uid='$addTag' class='alert-link mr-2 text-primary edit-tag'>
									<i class='fas fa-pencil-alt'></i>
									Edit
								</a>
								<a href='#' data-uid='$addTag' class='alert-link text-primary delete-tag'>
									<i class='fas fa-trash'></i>
									Delete
								</a>
							</div>
						</li>
					";

					http_response_code(200);
					echo json_encode([
						'content' => $htmlInfo,
						'message' => Message::$validSuccessBlog['add_tag']
					]);
					die();
				}

				$errors[] = Message::$validErrorsBlog['add_tag_failed'];
			}

			http_response_code(400);
			echo json_encode([
				'status'  => 0,
				'errors' => $errors
			]);
			die();
		}

		public function updateTag()
		{
			$id = Validation::safe($_REQUEST['id']);
			$name = Validation::safe($_REQUEST['name']);
			$errors = ValidBlogTag($name, $this->BlogModel);

			if(count($errors) === 0){
				$data = [
					'NAME' => $name,
					'SLUG' => Functions::toSlug($name),
					'UPDATE_AT' => DATETIMENOW
				];
				if($this->BlogModel->updateTagById($id, $data)){
					http_response_code(200);
					die();
				}
			}

			http_response_code(400);
			die();
		}

		public function deleteTag($id)
		{
			$this->BlogModel->deleteTag(Validation::safe($id)) ? 
							http_response_code(200) :
							http_response_code(400);
			die();
		}
		
		public function deleteManyTag()
		{
			if(!is_array($_REQUEST['arrId'])){
				http_response_code(400);
				die();
			}

			$this->BlogModel->deleteManyTag($_REQUEST['arrId']) ? 
							http_response_code(200) :
							http_response_code(400);
			die();
		}

		// Handle Categories

		public function showListCategories($menus, $parent_id = 0, $type = 'template', $insert_text = '')
		{
			$resultCategories = '';
			$menu_tmp = [];

			foreach ($menus as $key => $value) {
				if($value['PARENT_ID'] === $parent_id){
					$menu_tmp[] = $value;
					unset($menus[$key]);
				}
			}

			if($menu_tmp){
				if($type === 'template'){
					foreach ($menu_tmp as $value) {
						$resultCategories .= "
						<ul class='card shadow mb-1'>
							<li data-uid='".$value['ID']."'>
								<a href='#collapseCategories".$value['ID']."' class='d-block card-header py-3 d-flex' data-toggle='collapse' role='button' aria-expanded='true' aria-controls='collapseCategories".$value['ID']."'>
									<h6 class='m-0 font-weight-bold text-primary'>".$value['NAME']."</h6>
									<span class='d-none'>".$value['PARENT_ID']."</span>
								</a>
								<div class='collapse' id='collapseCategories".$value['ID']."'>
									<div class='card-body'>
										<div class='d-flex'>
											<div class='form-group mr-2'>
												<label>Name</label>
												<input type='text' class='form-control edit-name-category' value='".$value['NAME']."'>
											</div>
											<div class='form-group'>
												<label>Slug</label>
												<input type='text' class='form-control edit-slug-category' value='".$value['SLUG']."'>
											</div>
											<div class='form-group'>
												<label></label>
												<button type='button' data-uid='".$value['ID']."' class='form-control btn btn-success mt-2 ml-2 btn-update-category'>
													<i class='fas fa-check'></i>
												</button>
											</div>
											<div class='form-group'>
												<label></label>
												<button type='button' data-uid='".$value['ID']."' class='form-control btn btn-danger mt-2 ml-2 btn-delete-category'>
													<i class='fas fa-trash'></i>
												</button>
											</div>
										</div>
										<a href='#' class='ml-2 link-edit-category' data-toggle='modal' data-target='#categoryModal' data-uid='".$value['ID']."'>Edit</a>
									</div>
								</div>
							</li>
						";
						$resultCategories .= $this->showListCategories($menus, $value['ID']);
						$resultCategories .= '</ul>';
					}
				}
				if($type === 'option'){
					foreach ($menu_tmp as $value) {
						$resultCategories .= "<option value='".$value['ID']."'>".$insert_text.$value['NAME']."</option>";
						$resultCategories .= $this->showListCategories($menus, $value['ID'], $type, html_entity_decode('&nbsp;&nbsp;+&nbsp;'));
					}
				}
			}

			return $resultCategories;
		}

		public function addNewCategory()
		{
			$name = Validation::safe($_REQUEST['name']);
			$slug = Validation::safe(Functions::toSlug($_REQUEST['slug']));
			$parentId = (int)Validation::safe($_REQUEST['parent_id']);

			$errors = ValidBlogCategory($name, $slug, $parentId, $this->BlogModel);

			if(count($errors) === 0){
				$data = [
					'NAME' 			=> $name,
					'SLUG' 			=> $slug,
					'PARENT_ID' => $parentId
				];
				$addCategory = $this->BlogModel->addNewCategory($data);

				if($addCategory){
					$htmlInfo = "
					<ul class='card shadow mb-1'>
						<li data-uid='$addCategory'>
							<a href='#collapseCategories$addCategory' class='d-block card-header py-3' data-toggle='collapse' role='button' aria-expanded='true' aria-controls='collapseCategories$addCategory'>
								<h6 class='m-0 font-weight-bold text-primary'>$name</h6>
								<span class='d-none'>$parentId</span>
							</a>
							<div class='collapse' id='collapseCategories$addCategory'>
								<div class='card-body'>
									<div class='d-flex'>
										<div class='form-group mr-2'>
											<label>Name</label>
											<input type='text' class='form-control edit-name-category' value='$name'>
										</div>
										<div class='form-group'>
											<label>Slug</label>
											<input type='text' class='form-control edit-slug-category' value='$slug'>
										</div>
										<div class='form-group'>
											<label></label>
											<button type='button' data-uid='$addCategory' class='form-control btn btn-success mt-2 ml-2 btn-update-category'>
												<i class='fas fa-check'></i>
											</button>
										</div>
										<div class='form-group'>
											<label></label>
											<button type='button' data-uid='$addCategory' class='form-control btn btn-danger mt-2 ml-2 btn-delete-category'>
												<i class='fas fa-trash'></i>
											</button>
										</div>
									</div>
									<a href='#' class='ml-2 link-edit-category' data-toggle='modal' data-target='#categoryModal' data-uid='$addCategory'>Edit</a>
								</div>
							</div>
						</li>
					</ul>
					";
					if($parentId === 0){
						$htmlForOption = "<option value='$addCategory'>$name</option>";
					} else{
						$htmlForOption = "<option value='$addCategory'>&nbsp;&nbsp;+&nbsp;$name</option>";
					}

					http_response_code(200);
					echo json_encode([
						'content' => $htmlInfo,
						'option'	=> $htmlForOption,
						'message' => Message::$validSuccessBlog['add_category']
					]);
					die();
				}

				$errors[] = Message::$validErrorsBlog['add_category_failed'];
			}

			http_response_code(400);
			echo json_encode([
				'status'  => 0,
				'errors' => $errors
			]);
			die();
		}

		public function deleteCategory($id)
		{
			$this->BlogModel->deleteCategory(Validation::safe($id)) ? 
							http_response_code(200) :
							http_response_code(400);
			die();
		}

		public function updateCategory()
		{
			$id = Validation::safe($_REQUEST['id']);
			$name = Validation::safe($_REQUEST['name']);
			$slug = Validation::safe($_REQUEST['slug']);

			$errors = ValidBlogCategory($name, $slug, 1, $this->BlogModel);

			if(count($errors) === 0){
				$data = [
					'NAME' => $name,
					'SLUG' => $slug,
					'UPDATE_AT' => DATETIMENOW
				];
				if($this->BlogModel->updateCategoryById($id, $data)){
					http_response_code(200);
					die();
				}
			}

			http_response_code(400);
			die();
		}

		public function updateDetailCategory()
		{
			$id = Validation::safe($_REQUEST['id']);
			$name = Validation::safe($_REQUEST['name']);
			$slug = Validation::safe($_REQUEST['slug']);
			$parentId = (int)Validation::safe($_REQUEST['parent_id']);

			$errors = ValidBlogCategory($name, $slug, $parentId, $this->BlogModel, 0);

			if(count($errors) === 0){
				$data = [
					'NAME' => $name,
					'SLUG' => $slug,
					'PARENT_ID' => $parentId,
					'UPDATE_AT' => DATETIMENOW
				];
				if($this->BlogModel->updateCategoryById($id, $data)){
					http_response_code(200);
					die();
				}
			}

			http_response_code(400);
			die();
		}

		// Handle Posts

		public function addNewPost()
		{
			$title = htmlspecialchars(strip_tags(trim($_POST['title'])));
			$content = $_POST['content'];
			$slug = Validation::safe(Functions::toSlug($_POST['slug']));
			$tags = $_POST['tags'][0] !== '' ? json_encode($_POST['tags']) : 'Undefined';
			$categories = $_POST['categories'] ? json_encode($_POST['categories']) : 'Uncategorised';

			$errors = ValidBlogPost($title, $content, $slug, $this->BlogModel);

			if(count($errors) === 0){
				$data = [
					'POST_TITLE' => $title,
					'POST_CONTENT' => $content,
					'POST_SLUG' => $slug,
					'TAGS' => $tags,
					'CATEGORIES' => $categories
				];

				if($this->BlogModel->addNewPost($data)){
					http_response_code(200);
					echo json_encode([
						'status'  => 1,
						'message' => Message::$validSuccessBlog['add_post']
					]);
					die();
				}
				$errors[] = Message::$validErrorsBlog['add_post_failed'];
			}

			http_response_code(400);
			echo json_encode([
				'status'  => 0,
				'errors' => $errors
			]);
			die();
		}
	}

?>
