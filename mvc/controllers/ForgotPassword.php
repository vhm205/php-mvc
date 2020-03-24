<?php
	class ForgotPassword extends Controller
	{
		protected $UserModel = NULL;
		
		public function __construct() {
			if(isset($_COOKIE['is_logged'])){
				header('location: ' . ORIGIN_URL . '/Home');
			}
			
			require_once './mvc/validation/authValid.php';
			$this->UserModel = $this->model('UserModel');
		}

		public function index()
		{
			$this->view('master-auth', [
				'page' => 'auth/forgot-password'
			]);
		}

		public function reset($email = '', $token = null)
		{
			$errors = [];
			
			// Check email & code is exists on params
			if(!empty($email) && $token){
				// Check token & token expire
				if(!$this->UserModel->CheckToken($email, $token)){
					$errors[] = Message::$transErrors['token_expired'];
				}

				$this->view('master-auth', [
					'page' => 'auth/reset-password',
					'email' => $email,
					'code' => $token,
					'errors' => count($errors) ? $errors : null
				]);
				die();
			}

			if(isset($_POST['btnResetPassword'])){
				$newpassword = Validation::safe($_POST['newpassword']);
				$email = Validation::safe($_POST['email']);
				$token = Validation::safe($_POST['code']);

				// Check token & token expire
				if(!$this->UserModel->CheckToken($email, $token)){
					$errors[] = Message::$transErrors['token_expired'];
				} else{
					// Validate Reset Password
					$errors = ValidResetPassword($email, $newpassword, $token, $this->UserModel);
				}

				if(count($errors) === 0){
					$passwordHashed = password_hash($newpassword, PASSWORD_BCRYPT, array('cost' => 12));

					// Update new password
					if($this->UserModel->UpdatePassword($email, $passwordHashed)){
						$this->view('master-auth', [
							'page'  => 'auth/reset-password',
							'success' => Message::$transSuccess['reset_pass_success']
						]);
						die();
					}
					$errors[] = Message::$validErrors['error_server'];
				}

				$this->view('master-auth', [
					'page'  => 'auth/reset-password',
					'email' => $email,
					'code'	=> $token,
					'errors' => $errors
				]);
				die();
			}

			header('location: ' . ORIGIN_URL . '/error/404.php');
		}

		public function SendMailPasswordReset()
		{
			if(isset($_POST['btnForgotPass'])){
				$email = Validation::safe($_POST['email']);
				$token = md5(uniqid(time()));

				// Validate Forgot password
				$errors = ValidForgotPassword($email, $this->UserModel);

				if(count($errors) === 0){
					require_once './mvc/config/send_mail.php';

					// Update token & token expire
					if($this->UserModel->UpdateToken($email, $token)){
						$subject  = "Email Reset Password";
						$body 	  = Functions::templateMailResetPass($email, $token);
						$sendMail = sendMail(EMAIL_CONFIRM, EMAIL_PASSWORD, $email, $subject, $body);

						// Send mail to reset password
						if($sendMail){
							$this->view('master-auth', [
								'page'  => 'auth/forgot-password',
								'success' => Message::$transSuccess['send_mail_reset']
							]);
							die();
						}

						$errors[] = Message::$transSendMail['send_failed'];
					}
				}

				$this->view('master-auth', [
					'page'  => 'auth/forgot-password',
					'errors' => $errors
				]);
				die();
			}

			header('location: ' . ORIGIN_URL . '/error/404.php');
		}
	}
	
?>