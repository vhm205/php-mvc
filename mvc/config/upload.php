<?php
	class Uploader
	{
		public $imageResize;
		public $uploadfile;
		public $extension;
		public $filename;
		public $fullpath;
		public $errors;
		public $dir;

		public function __construct($input) {
			$this->imageResize = new \Gumlet\ImageResize($input['tmp_name']);
			$this->uploadfile = $input;
			$this->errors = [];
			$this->dir = './public/uploads/';
		}

		public function upload($filename = '')
		{
			// File name . date('-Y_m_d_H:i:s')
			$this->filename = $filename ? $filename : sha1_file($this->uploadfile['tmp_name']) . ($_COOKIE['user_id'] ?? null);

			// Extension
			$this->extension = pathinfo($this->uploadfile['name'], PATHINFO_EXTENSION);

			// File name & Extension
			$this->filename = sprintf('%s.%s', $this->filename, $this->extension);

			// Full path
			$this->fullpath = $this->dir . $this->filename;

			if(file_exists($this->fullpath)){
				return false;
			}

			$this->imageResize->resizeToBestFit(500, 300);

			return $this->imageResize->save($this->fullpath) ? true : false;
		}

		public function compress($source, $destination, $quality)
		{
			$info = getimagesize($source);

			switch ($info['mime']) {
				case 'image/jpeg':
					$image = imagecreatefromjpeg($source);
					imagejpeg($image, $destination, $quality);
					break;
				case 'image/png':
					$image = imagecreatefrompng($source);
					imagepng($image, $destination, $quality);
					break;
				case 'image/gif':
					$image = imagecreatefromgif($source);
					imagegif($image, $destination, $quality);
					break;
				default:
					break;
			}
			
			imagedestroy($image);
		}

		public function allowFileType($typesAllowed)
		{
			if(!in_array($this->uploadfile['type'], $typesAllowed)){
				$this->errors[] = Message::$validErrors['invalid_file_type'];
			}
		}

		public function limitFileSize($size = 1048576)
		{
			if($this->uploadfile['size'] > $size){
				$this->errors[] = Message::$validErrors['file_too_large'];
			}
		}

		public function setDir($dir)
		{
			if(is_dir($dir)) $this->dir = $dir;
		}

		public function error()
		{
			switch ($this->uploadfile['error']) {
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('No file sent.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('Exceeded filesize limit.');
				default:
					throw new RuntimeException('Unknown errors.');
			}
		}
	}
	
?>
