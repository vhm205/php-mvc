<?php 
	require_once './mvc/config/jwt.php';
	require_once './mvc/config/cache.php';

	function GetUserInfo($UserModel)
	{
		$userId = $_COOKIE['user_id'] ?? null;
		$userKey = "userInfo" . $userId;

		$cache = new Cache($userKey);
		$jsonUser = json_decode($cache->get());

		// If cache is found, otherwise get from CSDL
		if(isset($jsonUser)){
			$user = [(array)$jsonUser[0]];
		} else{
			if($userId){
				$user = $UserModel->GetUserById($userId);
			} else{
				// Get token from cookie & decode, Then get user ID
				try {
					$userId = JWT::decode($_COOKIE['auth-token'], SECRET)->ID;
					$user	= $UserModel->GetUserById($userId);
				} catch (Exception $ex) {
					Functions::logout();
				}
			}
			// Set cache and Expire after 2 days
			$userKey = "userInfo" . $userId;
			$cache->set(json_encode($user), $userKey);
			$cache->expire(86400 * 2, $userKey);
		}

		if(!isset($_SESSION['USERKEY'])){
			$_SESSION['USERKEY'] = $userKey;
		}	

		return $user;
	}
?>
