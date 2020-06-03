<?php
	class BlogModel extends Database
	{
		// Handle Tags

		public function getAllTag()
		{
			try {
				return $this->table('tags')->get();
			} catch (Exception $th) {
				return false;
			}
		}
		public function getTagsByLimit($offset, $limit)
		{
			try {
				return $this->table('tags')
											->offset($offset)
											->limit($limit)
											->get();
			} catch (Exception $th) {
				return false;
			}
		}
		public function getTagByName($name)
		{
			try {
				return $this->table('tags')
												->where(['NAME' => $name])
												->get();
			} catch (Exception $th) {
				return false;
			}
		}
		public function addNewTag($data)
		{
			try {
				return $this->table('tags')->insert($data);
			} catch (Exception $th) {
				return false;
			}
		}
		public function deleteTag($id)
		{
			try {
				return $this->table('tags')->delete($id);
			} catch (Exception $th) {
				return false;
			}
		}
		public function deleteManyTag($arrId)
		{
			try {
				return $this->table('tags')->deleteMany($arrId);
			} catch (Exception $th) {
				return false;
			}
		}
		public function updateTagById($id, $data)
		{
			try {
				return $this->table('tags')->update(['ID' => $id], $data);
			} catch (Exception $th) {
				return false;
			}
		}

		// Handle Categories

		public function getAllCategories()
		{
			try {
				return $this->table('categories')->get();
			} catch (Exception $th) {
				return false;
			}
		}
		public function getCategoryByName($name)
		{
			try {
				return $this->table('categories')
														->where(['NAME' => $name])
														->get();
			} catch (Exception $th) {
				return false;
			}
		}
		public function addNewCategory($data)
		{
			try {
				return $this->table('categories')->insert($data);
			} catch (Exception $th) {
				return false;
			}
		}
		public function deleteCategory($id)
		{
			try {
				return $this->table('categories')->delete($id);
			} catch (Exception $th) {
				return false;
			}
		}
		public function updateCategoryById($id, $data)
		{
			try {
				return $this->table('categories')->update(['ID' => $id], $data);
			} catch (Exception $th) {
				return false;
			}
		}

		// Handle Posts

		public function addNewPost($data)
		{
			try {
				return $this->table('posts')->insert($data);
			} catch (Exception $th) {
				return false;
			}
		}
		public function getPostByTitle($title)
		{
			try {
				return $this->table('posts')
								->where(['POST_TITLE' => $title])
								->get();
			} catch (Exception $th) {
				return false;
			}
		}
		public function getAllPosts()
		{
			try {
				return $this->table('posts')->get();
			} catch (Exception $th) {
				return false;
			}
		}

	}

?>