<?php
	class Functions
	{
		public static function logout()
		{
			header('Location: ' . ORIGIN_URL . '/Login/logout');
		}

		public static function buttonStyle()
		{
			return "font-size: 16px; font-family: Helvetica, Arial, sans-serif;background:#e9703e;color: #ffffff; text-decoration: none; text-decoration: none;border-radius: 3px; padding: 12px 18px; border: 1px solid #e9703e; display: inline-block;";
		}

		public static function templateMailRegister($token)
		{
			$linkVerify = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . BASE_DIR . '/Register/verify/' . $token;
				
			return "<h2> Link kích hoạt tài khoản từ Admin VHM: </h2>
							<h3><a style='" . Functions::buttonStyle() . "' href='$linkVerify' target='_blank'>Active account</a></h3>";
		}

		public static function templateMailResetPass($email, $code)
		{
			$linkReset = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . BASE_DIR . '/ForgotPassword/reset/' . $email . '/' . $code;

			return "<h2> Link reset password từ Admin VHM: </h2>
							<h3><a style='" . Functions::buttonStyle() . "' href='$linkReset' target='_blank'>Reset your password</a></h3>";
		}

		public static function toSlug($str)
		{
			$str = trim(mb_strtolower($str));
			$str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
			$str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
			$str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
			$str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
			$str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
			$str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
			$str = preg_replace('/(đ)/', 'd', $str);
			$str = preg_replace('/[^a-z0-9-\s]/', '', $str);
			$str = preg_replace('/([\s]+)/', '-', $str);
			return $str;
		}
	}
	
?>