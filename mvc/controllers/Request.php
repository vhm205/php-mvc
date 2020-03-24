<?php
	class Request extends Controller
	{
		protected $UserModel = NULL;

		public function __construct() {
			if(!isset($_COOKIE['is_logged'])){
				Functions::logout();
			}

			require_once './mvc/validation/mainValid.php';
			require_once './mvc/config/cache.php';
			$this->UserModel = $this->model('UserModel');
		}

		public function UpdateAvatar($userId)
		{
			require_once './mvc/config/upload.php';

			$upload = new Uploader($_FILES['avatar']);
			$extAllowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
			$limit  = 1048576;

			$upload->setDir('./public/images/');
			$upload->allowFileType($extAllowed);
			$upload->limitFileSize($limit);

			if(count($upload->errors) === 0){
				if($upload->upload()){
					// Remove avatar old
					if(isset($_POST['old-avatar'])){
						$old_avatar = $_POST['old-avatar'];
						$filename = explode('/', $old_avatar)[3];

						if($filename !== 'avatar_default.png'){
							try { unlink($old_avatar); } catch (Exception $ex) {}
						}
					}

					$data = [
						'AVATAR' 	=> $upload->filename,
						'UPDATE_AT' => DATETIMENOW
					];

					if($this->UserModel->UpdateUser($userId, $data)){
						// Remove cache
						$cache = new Cache($_SESSION['USERKEY']);
						$cache->delete();

						http_response_code(200);
						echo json_encode([
							'status'  => 1,
							'filename' => $upload->filename,
							'message' => Message::$transSuccess['upload_avatar_success']
						]);
						die();
					}
					// If update is failed, Then delete image uploaded
					unlink($upload->fullpath);
				}
				http_response_code(500);
				echo json_encode([
					'status'  => 0,
					'message' => Message::$transErrors['upload_avatar_failed']
				]);
				die();
			}

			http_response_code(400);
			echo json_encode([
				'status'  => 0,
				'errors' => $upload->errors
			]);
		}

		public function UpdateProfile($userId)
		{
			$fullname = $_POST['fullname'] ?? null;
			$phone 	  = $_POST['phone'] ?? null;
			$gender	  = $_POST['gender'] ?? null;
			$data 	  = [];

			!empty($fullname) ?
					$data['FULLNAME'] = Validation::safe($fullname) : null;

			!empty($phone) ?
					$data['PHONE'] = Validation::safe($phone) : null;

			!empty($gender) ?
					$data['GENDER'] = Validation::safe($gender) : null;

			$errors = ValidUpdateProfile($fullname, $gender, $phone);

			if(count($errors) === 0){
				$data['UPDATE_AT'] = DATETIMENOW;

				if($this->UserModel->UpdateUser($userId, $data)){
					// Remove cache
					$cache = new Cache($_SESSION['USERKEY']);
					$cache->delete();

					http_response_code(200);
					echo json_encode([
						'status' => 1,
						'message' => Message::$transSuccess['update_profile']
					]);
					die();
				}
			}

			http_response_code(400);
			echo json_encode([
				'status' => 0,
				'message' => Message::$transErrors['update_profile'],
				'errors' => $errors
			]);
			die();
		}
	}

?>
