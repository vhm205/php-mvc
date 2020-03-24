<?php
	function ValidUpdateProfile($fullname, $gender, $phone)
	{
		$errors = [];
		$genderRange = ['male', 'female', 'another'];

		if(!empty($fullname) && !Validation::range($fullname, 3, 30)){
			$errors['FULLNAME'] = Message::$validErrors['fullname_too_long'];
		}

		if(!empty($phone) && !Validation::range($phone, 10, 11)){
			$errors['PHONE'] = Message::$validErrors['phone_invalid'];
		}

		if(!empty($gender) && !in_array($gender, $genderRange)){
			$errors['GENDER'] = Message::$validErrors['gender_wrong'];
		}

		return $errors;
	}
?>