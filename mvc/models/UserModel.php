<?php
	class UserModel extends Database
	{
		public function InsertUser($data)
		{
			try {
				return $this->table('users')
						   	   	   ->insert($data);
			} catch (Exception $ex) {
				return false;
			}
		}

		public function UpdateUser($userId, $data)
		{
			try {
				return $this->table('users')
									  ->update(['ID' => $userId], $data);
			} catch (Exception $ex) {
				return false;
			}
		}

		public function GetUserById($userId)
		{
			try{
				return $this->table('users')
							 ->fields([
								 'ID', 'FULLNAME', 'EMAIL', 'PHONE', 'GENDER', 'AVATAR'
								])
							 ->where(['ID' => $userId])
							 ->get();
			} catch (Exception $ex) {
				return false;
			}
		}

		public function GetUserByEmail($email)
		{
			try{
				return $this->table('users')
							 ->fields(['ID', 'PASSWORD_LOCAL', 'TOKEN', 'STATUS'])
							 ->where(['EMAIL' => $email ])
							 ->get();
			} catch (Exception $ex) {
				return false;
			}
			
		}

		// Check if your account is activated
		public function CheckActiveCode($active_code)
		{
			try{
				return $this->table('users')
									->fields(['TOKEN', 'STATUS'])
									->where([
										'TOKEN'  => $active_code,
										'STATUS' => 0
									], 'AND')->get();
			} catch (Exception $ex) {
				return false;
			}
		}

		// Update status for account is activated
		public function UpdateActiveCode($active_code)
		{
			try{
				return $this->table('users')
								   ->update(['TOKEN' => $active_code], [
										'TOKEN'  => NULL,
										'STATUS' => 1
									]);
			} catch (Exception $ex) {
				return false;
			}
		}

		// Update password for Reset password
		public function UpdatePassword($email, $password)
		{
			try{
				return $this->table('users')
									   ->update(['EMAIL' => $email], [
											'PASSWORD_LOCAL' => $password,
											'TOKEN' 				 => NULL,
											'TOKEN_EXPIRE' 	 => NULL,
											'UPDATE_AT'		 	 => DATETIMENOW
										]);
			} catch (Exception $ex) {
				return false;
			}
		}

		// Update Token Expire for Forgot password
		public function UpdateToken($email, $token)
		{
			try{
				return $this->table('users')
									->updateExpireToken($email, $token);
			} catch (Exception $ex) {
				return false;
			}
		}

		// Check Token Expire for Reset password
		public function CheckToken($email, $token)
		{
			try{
				return $this->table('users')
								   ->checkTokenExists($email, $token);
			} catch (Exception $ex) {
				return false;
			}
		}
	}
?>
