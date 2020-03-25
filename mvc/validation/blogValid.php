<?php
	function ValidBlogTag($name, $model)
	{
		$errors = [];

		if(empty($name)){
			$errors[] = Message::$validErrorsBlog['tag_null'];
		}

		if(count($model->getTagByName($name)) > 0){
			$errors[] = Message::$validErrorsBlog['tag_exists'];
		}

		if(!empty($name) && !Validation::range($name, 1, 30)){
			$errors[] = Message::$validErrorsBlog['too_long'];
		}

		return $errors;
	}
	
	function ValidBlogCategory($name, $slug, $parentId, $model, $checkExists = 1)
	{
		$errors = [];

		if(empty($name) || empty($slug) || !isset($parentId)){
			$errors[] = Message::$validErrorsBlog['category_null'];
		}

		if(!is_int($parentId)){
			$errors[] = Message::$validErrorsBlog['parent_id_wrong'];
		}

		if($checkExists === 1 && count($model->getCategoryByName($name)) > 0){
			$errors[] = Message::$validErrorsBlog['category_exists'];
		}

		if(!empty($name) && !Validation::range($name, 1, 30)){
			$errors[] = Message::$validErrorsBlog['too_long'];
		}

		return $errors;
	}
?>