<?php
	class Login extends Controller
	{
		protected $UserModel = NULL;

		public function __construct()
		{
			if(isset($_COOKIE['is_logged'])){
				header('location: ' . ORIGIN_URL . '/Home');
			}

			$this->UserModel = $this->model('UserModel');
		}

		public function index()
		{
			$this->view('master-auth', [
				'page' => 'auth/login'
			]);
		}

		public function logout()
		{
			require_once './mvc/config/cache.php';
			$cache = new Cache($_SESSION['USERKEY']);
			$cache->delete();

			session_destroy();
			setcookie('auth-token', null, -1, '/', DOMAIN);
			setcookie('is_logged', null, -1, '/', DOMAIN);
			setcookie('user_id', null, -1, '/', DOMAIN);
			header('location: ' . ORIGIN_URL . '/Login');
		}

		public function PostLogin()
		{
			if(isset($_POST['loginbtn'])){
				$email = Validation::safe($_POST['email']);
				$pass  = Validation::safe($_POST['password']);
				$GLOBALS['user']  = NULL;

				require_once './mvc/validation/authValid.php';

				// Validate Login
				$errors = ValidLogin($email, $pass, $this->UserModel);

				if(count($errors) === 0){
					$passwordHashed = $GLOBALS['user'][0]['PASSWORD_LOCAL'];

					if(password_verify($pass, $passwordHashed)){
						require_once './mvc/config/jwt.php';
						
						$userId = $GLOBALS['user'][0]['ID'];
						$token = JWT::encode([ 'ID' => $userId ], SECRET);

						// Set cookie for 2 days
						$time = time() + (86400 * 2);

						setcookie('auth-token', $token, $time, '/', DOMAIN, false, true);
						setcookie('is_logged', true, $time, '/', DOMAIN, false, true);
						setcookie('user_id', $userId, $time, '/', DOMAIN, false, true);

						header('location: ' . ORIGIN_URL . '/Home') OR die();
					}

					$errors[] = Message::$validErrors['password_wrong'];
				}

				$this->view('master-auth', [
					'page' 	 => 'auth/login',
					'errors' => $errors
				]) OR die();
			}

			header('location: ' . ORIGIN_URL . '/error/404.php');
		}
	}
?>
