<?php
	define('DOMAIN', 'localhost');	
	define('BASE_URL', 'http://localhost/');
	define('BASE_DIR', dirname($_SERVER['PHP_SELF']));
	define('ORIGIN_URL', 'http://localhost' . BASE_DIR);
	define('HOSTNAME', 'localhost');
	define('USERNAME', 'phpmyadmin');
	define('PASSWORD', 'admin123');
	define('DBNAME', 'admin_panel');
	define('DATETIMENOW', date('Y-m-d H:i:s'));

	// Config PHPMailer
	define('EMAIL_CONFIRM', 'vuhuynhminh101@gmail.com');
	define('EMAIL_PASSWORD', 'Nguyenthikimyen102');
	
	// Config secret for JsonWebToken
	define('SECRET', 'VHM@102');
?>
