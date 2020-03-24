<?php
	class App
	{
		protected $controller = 'Home';
		protected $action 	  = 'index';
		protected $params	  = [];

		function __construct() {
			$arr = $this->urlProcess();
			
			// Handle Controller Url
			if(file_exists("./mvc/controllers/$arr[0].php")){
				$this->controller = $arr[0];
				unset($arr[0]);
			}
			
			require_once "./mvc/controllers/$this->controller.php";

			$this->controller = new $this->controller;

			// Handle Action Url
			if(isset($arr[1])){
				if(method_exists($this->controller, $arr[1])){
					$this->action = $arr[1];
				}
				unset($arr[1]);
			}

			// Handle Params Url
			$this->params = $arr ? array_values($arr) : [];

			call_user_func_array([$this->controller, $this->action], $this->params);
		}

		public function urlProcess()
		{
			if(isset($_GET["url"])){
				return explode('/', filter_var(trim($_GET["url"], '/')));
			}
		}

	}

?>