<?php
	class BlogModel extends Database
	{
		public function getAllTag()
		{
			try {
				$getAllTags = $this->table('tags')->get();
				return $getAllTags;
			} catch (Exception $th) {
				return false;
			}
		}
		public function getTagByName($name)
		{
			try {
				$getTag = $this->table('tags')
												->where(['NAME' => $name])
												->get();
				return $getTag;
			} catch (Exception $th) {
				return false;
			}
		}
		public function addNewTag($data)
		{
			try {
				$addTag = $this->table('tags')->insert($data);
				return $addTag;
			} catch (Exception $th) {
				return false;
			}
		}
		public function deleteTag($id)
		{
			try {
				$deleteTag = $this->table('tags')->delete($id);
				return $deleteTag;
			} catch (Exception $th) {
				return false;
			}
		}
		public function deleteManyTag($arrId)
		{
			try {
				$deleteManyTag = $this->table('tags')->deleteMany($arrId);
				return $deleteManyTag;
			} catch (Exception $th) {
				return false;
			}
		}
		public function updateTagById($id, $data)
		{
			try {
				$updateTag = $this->table('tags')->update(['ID' => $id], $data);
				return $updateTag;
			} catch (Exception $th) {
				return false;
			}
		}

		public function getAllCategories()
		{
			try {
				$getAllCategories = $this->table('categories')->get();
				return $getAllCategories;
			} catch (Exception $th) {
				return false;
			}
		}
		public function getCategoryByName($name)
		{
			try {
				$getCategory = $this->table('categories')
														->where(['NAME' => $name])
														->get();
				return $getCategory;
			} catch (Exception $th) {
				return false;
			}
		}
		public function addNewCategory($data)
		{
			try {
				$addCategory = $this->table('categories')->insert($data);
				return $addCategory;
			} catch (Exception $th) {
				return false;
			}
		}
		public function deleteCategory($id)
		{
			try {
				$deleteCategory = $this->table('categories')->delete($id);
				return $deleteCategory;
			} catch (Exception $th) {
				return false;
			}
		}
	}

?>