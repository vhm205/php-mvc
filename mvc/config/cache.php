<?php
	class Cache
	{
		public $redis;
		public $key;

		public function __construct($key = '') {
			try {
				Predis\Autoloader::register();
				$this->redis = new Predis\Client();
				$this->key 	 = $key;
			} catch (\Throwable $th) {
				throw $th;
			}
		}

		public function set($value, $key = '')
		{
			try {
				$this->key = $key ? $key : $this->key;
				$this->redis->set($this->key, $value);
			} catch (Exception $ex) {
				echo "Couldn't connect to Redis";
				echo $e->getMessage();
			}
		}

		public function get($key = '')
		{
			try {
				$this->key = $key ? $key : $this->key;
				return $this->redis->get($this->key);
			} catch (Exception $ex) {
				echo "Couldn't connect to Redis";
				echo $e->getMessage();
			}
		}

		public function expire($second, $key)
		{
			try {
				$this->key = $key ? $key : $this->key;
				$this->redis->expire($this->key, $second);
			} catch (Exception $ex) {
				echo $e->getMessage();
			}
		}

		public function delete($key = '')
		{
			try {
				$this->key = $key ? $key : $this->key;
				$this->redis->del($this->key);
			} catch (Exception $ex) {
				echo $e->getMessage();
			}
		}

		public function deleteAll()
		{
			try {
				$this->redis->flushAll();
			} catch (Exception $ex) {
				echo $e->getMessage();
			}
		}
	}
	
?>