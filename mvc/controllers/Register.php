<?php
	class Register extends Controller
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
				'page' => 'auth/register'
			]);
		}

		public function verify($active_code)
		{
			$active_code = Validation::safe($active_code);

			// Check active code doesn't existed
			if($this->UserModel->CheckActiveCode($active_code)){
				// Update active code
				if($this->UserModel->UpdateActiveCode($active_code)){
					http_response_code(200);
					$this->view('master-auth', [
						'page' 	  => 'auth/login',
						'success' => Message::$transSuccess['active_success']
					]);
					die();
				}
			}

			header('location: ' . ORIGIN_URL . '/error/404.php');
		}

		public function PostRegister()
		{
			if(isset($_POST['registerbtn'])){
				$firstname 	  = Validation::safe($_POST['first']);
				$lastname 	  = Validation::safe($_POST['last']);
				$fullname 	  = $firstname . ' ' . $lastname;
				$email 		  	= Validation::safe($_POST['email']);
				$password	  	= Validation::safe($_POST['password']);
				$confirm_pass = Validation::safe($_POST['confirmpassword']);
				$active_code  = md5(uniqid(time()));
				
				require_once './mvc/validation/authValid.php';
				
				// Validate Register
				$errors = ValidRegister($fullname, $email, $password, $confirm_pass, $this->UserModel);

				if(count($errors) === 0){
					$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
					$data = [
						'FULLNAME' 		 	=> $fullname,
						'EMAIL'    		 	=> $email,
						'PASSWORD_LOCAL' => $password,
						'TOKEN'	   		 	=> $active_code
					];

					if($this->UserModel->InsertUser($data)){
						require_once './mvc/config/send_mail.php';

						$subject  = "Email Activation Confirmation";
						$body 	  = Functions::templateMailRegister($active_code);
						$sendMail = sendMail(EMAIL_CONFIRM, EMAIL_PASSWORD, $email, $subject, $body);

						// Send mail is success, then render register page
						if($sendMail){
							$this->view('master-auth', [
								'page' => 'auth/register',
								'success' => Message::$transSuccess['register_success']
							]);
							die();
						} else{
							$errors[] = Message::$transSendMail['send_failed'];
						}
					} else{
						$errors[] = Message::$transErrors['register_failed'];
					}
				}

				$this->view('master-auth', [
					'page' => 'auth/register',
					'errors' => $errors
				]) OR die();
			}

			header('location: ' . ORIGIN_URL . '/error/404.php');
		}
	}
?>