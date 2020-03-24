<?php
	class Home extends Controller
	{
		protected $UserModel = NULL;
		protected $user = NULL;

		public function __construct() {
			if(!isset($_COOKIE['is_logged'])){
				Functions::logout();
			}

			require_once './mvc/middleware/CheckCache.php';
			$this->UserModel = $this->model('UserModel');
			$this->user = GetUserInfo($this->UserModel);
		}

		public function index()
		{
			$this->view('master-main', [
				'page' => 'main/home',
				'user' => $this->user ?? Functions::logout()
			]);
		}
	}

?>
