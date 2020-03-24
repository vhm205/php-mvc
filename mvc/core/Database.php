<?php
	class Database
	{
		protected static $connection = NULL;
		protected $offset = 0;
		protected $limit  = 0;
		protected $fields = '*';
		protected $where  = '1 = 1';
		protected $order  = 'ID ASC';
		protected $table  = '';
		protected $data   = [];

		public function __construct() {
			if(self::$connection === NULL){
				try {
					self::$connection = new PDO('mysql:host=' . HOSTNAME . ';dbname=' . DBNAME, USERNAME, PASSWORD, array(
						PDO::ATTR_ERRMODE 			 		 => PDO::ERRMODE_EXCEPTION,
						PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
						PDO::ATTR_EMULATE_PREPARES 	 => FALSE
					));

					return self::$connection;
				} catch (PDOException $ex) {
					echo "Connection failed: " . $ex->getMessage();
				}
			}
		}

		public function reset()
		{
			$this->table = '';
		}

		public function table($tbname)
		{
			if(self::$connection !== NULL){
				$this->table = $tbname;
				return $this;
			}
		}

		public function offset($offset)
		{
			if(self::$connection !== NULL){
				$this->offset = $offset;
				return $this;
			}
		}

		public function limit($limit)
		{
			if(self::$connection !== NULL){
				$this->limit = $limit;
				return $this;
			}
		}

		public function fields($fields = [])
		{
			if(self::$connection !== NULL){
				$setFields = implode(',', $fields);
				$this->fields = $setFields;
				return $this;
			}
		}

		public function order($orders = [])
		{
			if(self::$connection !== NULL){
				[$field, $order] = $orders;
				$this->order = "$field $order";
				return $this;
			}
		}

		/*
		* 	Use: $db->table()->where(['ID' => 1, 'USERNAME' => 'admin123'], 'OR')
		*/
		public function where($where, $type = NULL)
		{
			if(self::$connection !== NULL){
				$keyValues = [];
				$replace = null;
				$this->data = array_values($where);

				if($type === NULL){
					foreach ($where as $key => $value) {
						$keyValues[] = ' ' . $key . ' = ? ';
					}
					$replace = str_replace(',', 'OR', implode(',', $keyValues));
				}
				if($type === 'OR' || $type === 'AND'){
					foreach ($where as $key => $value) {
						$keyValues[] = ' ' . $key . ' = ? ';
					}
					$replace = str_replace(',', $type, implode(',', $keyValues));
				}
				if($type === 'NOT'){
					foreach ($where as $key => $value) {
						$keyValues[] = ' NOT ' . $key . ' = ? ';
					}
					$replace = str_replace(',', 'AND', implode(',', $keyValues));
				}
				if($type === 'LIKE'){
					$this->data = [];
					foreach ($where as $key => $value) {
						$this->data[] = "%$value%";
						$keyValues[] = ' ' . $key . " $type ? ";
					}
					$replace = str_replace(',', 'OR', implode(',', $keyValues));
				}

				$this->where = $replace;
				return $this;
			}
		}		

		public function get()
		{
			if($this->limit > 0 && $this->offset >= 0){
				$sql = "SELECT $this->fields FROM $this->table WHERE $this->where ORDER BY $this->order LIMIT ?, ?";
				$this->data[] = $this->offset;
				$this->data[] = $this->limit;
			} else {
				$sql = "SELECT $this->fields FROM $this->table WHERE $this->where ORDER BY $this->order";
			}

			$prepare = self::$connection->prepare($sql);
			$prepare->execute($this->data);

			$result = [];
			$this->data = [];
			while ($row = $prepare->fetch()) {
				$result[] = $row;
			}

			return $result;
		}

		public function insert($data = [])
		{
			if(self::$connection !== NULL){
				$fields = implode(',', array_keys($data));
				$vals 	= implode(',', array_fill(0, count($data), '?'));
				$values = array_values($data);

				$sql = "INSERT INTO $this->table($fields) VALUES($vals)";
				$prepare = self::$connection->prepare($sql);

				$prepare->execute($values);
				return self::$connection->lastInsertId();
				// return $prepare->rowCount();
			}
		}

		/*
		* Use: $db->table()->update(['ID' => 1], ['USERNAME' => 'admin123'])
		*/
		public function update($where, $data = [])
		{
			if(self::$connection !== NULL){
				$keyValues = [];
				foreach ($data as $key => $value) {
					$keyValues[] = $key . ' = ?';
				}

				$setFields = implode(', ', $keyValues);
				$values = array_values($data);
				$values[] = array_values($where)[0];
				$field = strtoupper(array_keys($where)[0]);

				$sql = "UPDATE $this->table SET $setFields WHERE $field = ?";
				$prepare = self::$connection->prepare($sql);

				$prepare->execute($values);
				return $prepare->rowCount();
			}
		}

		public function delete($id)
		{
			if(self::$connection !== NULL){
				$sql = "DELETE FROM $this->table WHERE ID = ?";
				$prepare = self::$connection->prepare($sql);
				$prepare->bindParam(1, $id, PDO::PARAM_INT);

				$prepare->execute();
				return $prepare->rowCount();
			}
		}

		public function deleteMany($arrId)
		{
			if(self::$connection !== NULL){
				$strId = implode(', ', $arrId);
				$sql = "DELETE FROM $this->table WHERE ID IN($strId)";
				$prepare = self::$connection->prepare($sql);

				$prepare->execute();
				return $prepare->rowCount();
			}
		}


		// Special
		public function updateExpireToken($email, $token)
		{
			if(self::$connection !== NULL){
				$sql = "UPDATE $this->table SET TOKEN = ?, TOKEN_EXPIRE=DATE_ADD(NOW(), INTERVAL 5 MINUTE) WHERE EMAIL = ?";
				$prepare = self::$connection->prepare($sql);
				
				$prepare->execute([$token, $email]);
				return $prepare->rowCount();
			}
		}

		// Special
		public function checkTokenExists($email, $token)
		{
			if(self::$connection !== NULL){
				$sql = "SELECT ID FROM $this->table WHERE EMAIL = ? AND TOKEN = ? AND TOKEN <> '' AND TOKEN_EXPIRE > NOW()";

				$prepare = self::$connection->prepare($sql);
				$prepare->execute([$email, $token]);
				return $prepare->fetch();
			}
		}
	}
	
?>
