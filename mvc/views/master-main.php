<?php require_once './mvc/views/blocks/header.php'; ?>

<!-- Page Wrapper -->
<div id="wrapper">
	<!-- Require Sidebar -->
	<?php require_once './mvc/views/blocks/sidebar.php'; ?>
	
	<!-- Content Wrapper -->
	<div id="content-wrapper" class="d-flex flex-column">	
		<!-- Main Content -->
		<div id="content">
			<!-- Require Navbar -->
			<?php require_once './mvc/views/blocks/navbar.php'; ?>

			<!-- Begin Page Content -->
			<div class="container-fluid">
				<?php
					if(isset($data['page'])){
						$filename = "./mvc/views/pages/" . $data['page'] . ".php";
						if(file_exists($filename)) require_once $filename;
					}
				?>
			</div>
			<!-- End of Page Content -->

		</div>
		<!-- End of Main Content -->

<?php require_once './mvc/views/blocks/footer.php' ?>
