<?php
	class Validation
	{
		public static function safe($input)
		{
			$input = str_replace("'", '', $input);
			$input = str_replace('"', '', $input);

			// \-\
			$input = preg_replace('/[$%^*!_()+=\\[\]\';,\/{}|":<>?~\\\\]/', '', $input);
			return htmlspecialchars(strip_tags(trim($input)));
		}

		public static function valid_email($input)
		{
			if(filter_var($input, FILTER_VALIDATE_EMAIL)){
				return true;
			}
			return false;
		}

		public static function valid_integer($input)
		{
			if(filter_var($input, FILTER_VALIDATE_INT)){
				return true;
			}
			return false;
		}

		public static function is_length($input, $length)
		{
			if(strlen($input) >= $length){
				return true;
			}
			return false;
		}
		
		public static function range($input, $min, $max)
		{
			if(strlen($input) >= $min && strlen($input) <= $max){
				return true;
			}
			return false;
		}
	}	
?>