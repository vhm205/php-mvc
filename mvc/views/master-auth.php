<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo ORIGIN_URL ?>/" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="VHM">

	<title> Login - Register </title>

	<!-- Custom fonts for this template-->
	
	<link href="./public/libs/css/all.min.css" rel="stylesheet" />

	<link href="//fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
	<link href='//fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900' rel='stylesheet' />

	<!-- Custom styles for this template-->
	<link href="./public/css/sb-admin-2.min.css" rel="stylesheet" />
	<link href="./public/css/style-auth.css" rel="stylesheet" type="text/css" media="all"/>

	<script src="./public/libs/js/jquery.min.js" async></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@9" async></script>

</head>
<body class="bg-gradient-primary" id="page-top">

	<?php
		if(isset($data['page'])){
			$filename = "./mvc/views/pages/" . $data['page'] . ".php";
			if(file_exists($filename)) require_once $filename;
		}
	?>

	<!-- Bootstrap core JavaScript-->
	<script src="./public/libs/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="./public/libs/js/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="./public/js/sb-admin-2.min.js"></script>
</body>
</html>