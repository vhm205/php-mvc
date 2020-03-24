<?php
	class UserModel extends Database
	{
		public function InsertUser($data)
		{
			try {
				$insertUser = $this->table('users')
						   	   	   ->insert($data);
				return $insertUser;
			} catch (Exception $ex) {
				return false;
			}
		}

		public function UpdateUser($userId, $data)
		{
			try {
				$updateProfile = $this->table('users')
									  ->update(['ID' => $userId], $data);
				return $updateProfile;
			} catch (Exception $ex) {
				return false;
			}
		}

		public function GetUserById($userId)
		{
			try{
				$user = $this->table('users')
							 ->fields([
								 'ID', 'FULLNAME', 'EMAIL', 'PHONE', 'GENDER', 'AVATAR'
								])
							 ->where(['ID' => $userId])
							 ->get();
				return $user;
			} catch (Exception $ex) {
				return false;
			}
		}

		public function GetUserByEmail($email)
		{
			try{
				$user = $this->table('users')
							 ->fields(['ID', 'PASSWORD_LOCAL', 'TOKEN', 'STATUS'])
							 ->where(['EMAIL' => $email ])
							 ->get();
				return $user;
			} catch (Exception $ex) {
				return false;
			}
			
		}

		// Check if your account is activated
		public function CheckActiveCode($active_code)
		{
			try{
				$checkExists = $this->table('users')
									->fields(['TOKEN', 'STATUS'])
									->where([
										'TOKEN'  => $active_code,
										'STATUS' => 0
									], 'AND')
									->get();
				return $checkExists;
			} catch (Exception $ex) {
				return false;
			}
		}

		// Update status for account is activated
		public function UpdateActiveCode($active_code)
		{
			try{
				$activeUser = $this->table('users')
								   ->update(['TOKEN' => $active_code], [
										'TOKEN'  => NULL,
										'STATUS' => 1
									]);
				return $activeUser;
			} catch (Exception $ex) {
				return false;
			}
		}

		// Update password for Reset password
		public function UpdatePassword($email, $password)
		{
			try{
				$updatePassword = $this->table('users')
									   ->update(['EMAIL' => $email], [
											'PASSWORD_LOCAL' => $password,
											'TOKEN' 				 => NULL,
											'TOKEN_EXPIRE' 	 => NULL,
											'UPDATE_AT'		 	 => DATETIMENOW
										]);
				return $updatePassword;
			} catch (Exception $ex) {
				return false;
			}
		}

		// Update Token Expire for Forgot password
		public function UpdateToken($email, $token)
		{
			try{
				$updateToken = $this->table('users')
									->updateExpireToken($email, $token);
				return $updateToken;
			} catch (Exception $ex) {
				return false;
			}
		}

		// Check Token Expire for Reset password
		public function CheckToken($email, $token)
		{
			try{
				$checkToken = $this->table('users')
								   ->checkTokenExists($email, $token);
				return $checkToken;
			} catch (Exception $ex) {
				return false;
			}
		}
	}
?>
