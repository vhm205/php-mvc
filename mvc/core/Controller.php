<?php
	class Controller
	{
		public function model($model)
		{
			$filename = "./mvc/models/$model.php";
			if(file_exists($filename)){
				require_once $filename;
				return new $model;
			}
		}

		public function view($view, $data = [])
		{
			$filename = "./mvc/views/$view.php";
			if(file_exists($filename)){
				require_once $filename;
			}
		}
	}
?>
