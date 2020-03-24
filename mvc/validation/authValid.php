<?php
	function ValidRegister($fullname, $email, $password, $confirm_pass, $model)
	{
		$errors = [];
		if(empty($fullname) || 
			empty($email) || 
			empty($password) || 
			empty($confirm_pass)){
			$errors[] = Message::$validErrors['input_required'];
		}

		if(!Validation::valid_email($email)){
			$errors[] = Message::$validErrors['email_invalid'];
		} else{
			// Check email exists
			if($model->GetUserByEmail($email)){
				$errors[] = Message::$validErrors['email_existed'];
			}
		}

		if(!Validation::is_length($password, 6)){
			$errors[] = Message::$validErrors['password_least_chars'];
		}

		if($password !== $confirm_pass){
			$errors[] = Message::$validErrors['password_confirm_not_match'];
		}

		return $errors;
	}

	function ValidLogin($email, $password, $model)
	{
		$errors = [];

		if(empty($email) || empty($password)){
			$errors[] = Message::$validErrors['input_required'];
		}

		if(!Validation::valid_email($email)){
			$errors[] = Message::$validErrors['email_invalid'];
		} else{
			$GLOBALS['user'] = $model->GetUserByEmail($email);

			// Check email exists
			if(!$GLOBALS['user']){
				$errors[] = Message::$validErrors['email_not_exists'];
			}

			// Check account is active and status = 1
			if(!empty($GLOBALS['user']) && $GLOBALS['user'][0]['STATUS'] === 0){
				$errors[] = Message::$validErrors['email_not_active'];
			}
		}

		if(!Validation::is_length($password, 6)){
			$errors[] = Message::$validErrors['password_least_chars'];
		}

		return $errors;
	}

	function ValidForgotPassword($email, $model)
	{
		$errors = [];

		if(empty($email)){
			$errors[] = Message::$validErrors['input_required'];
		}

		if(!Validation::valid_email($email)){
			$errors[] = Message::$validErrors['email_invalid'];
		} else{
			$user = $model->GetUserByEmail($email);
			
			if(!$user){
				$errors[] = Message::$validErrors['email_not_exists'];
			}

			if(!empty($user) && $user[0]['STATUS'] === 0){
				$errors[] = Message::$validErrors['email_not_active'];
			}
		}

		return $errors;
	}

	function ValidResetPassword($email, $password, $code, $model)
	{
		$errors = [];

		if(empty($password)){
			$errors[] = Message::$validErrors['input_required'];
		}

		if(empty($email) || empty($code)){
			$errors[] = Message::$validErrors['error_server'];
		} else{
			!Validation::valid_email($email) ? $errors[] = Message::$validErrors['error_server'] : (!$model->GetUserByEmail($email) ? $errors[] = Message::$validErrors['email_not_exists'] : null);
		}

		if(!Validation::is_length($password, 6)){
			$errors[] = Message::$validErrors['password_least_chars'];
		}

		return $errors;
	}
?>