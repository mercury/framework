<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?= $gs_title ?> | Dashboard</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="<?= $this->asset('/mercury/assets/bootstrap/css/bootstrap.min.css') ?>">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="/mercury/assets/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins
				 folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="/mercury/assets/css/skins/_all-skins.min.css">
		<!-- Date Picker -->
		<link rel="stylesheet" href="/mercury/assets/plugins/datepicker/datepicker3.css">
		<!-- Daterange picker -->
		<link rel="stylesheet" href="/mercury/assets/plugins/daterangepicker/daterangepicker-bs3.css">
		<!-- bootstrap wysihtml5 - text editor -->
		<link rel="stylesheet" href="/mercury/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
				<script src="http://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
				<script src="http://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">

			<header class="main-header">
				<!-- Logo -->
				<a href="/admin" class="logo">
					<!-- mini logo for sidebar mini 50x50 pixels -->
					<span class="logo-mini"><b>M</b>PHP</span>
					<!-- logo for regular state and mobile devices -->
					<span class="logo-lg"><b>Mercury</b>PHP</span>
				</a>
				<!-- Header Navbar: style can be found in header.less -->
				<nav class="navbar navbar-static-top" role="navigation">
					<!-- Sidebar toggle button-->
					<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
						<span class="sr-only">Toggle navigation</span>
					</a>
					<div class="navbar-custom-menu">
						<ul class="nav navbar-nav">



						</ul>
					</div>
				</nav>
			</header>
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				<!-- sidebar: style can be found in sidebar.less -->
				<section class="sidebar">

					<!-- search form -->
					<form action="#" method="get" class="sidebar-form">
						<div class="input-group">
							<input type="text" name="q" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
								<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
					<!-- /.search form -->
					<!-- sidebar menu: : style can be found in sidebar.less -->
					<ul class="sidebar-menu">
						<li class="header">MAIN NAVIGATION</li>

						<li class="<?= $gs_currentpage == '/admin/controllers' ? active : ''?>">
							<a href="/admin/controllers">
								<i class="fa fa-folder"></i> <span>Controllers</span>
							</a>
						</li>
						<li class="<?= $gs_currentpage == '/admin/models' ? active : ''?>">
							<a href="/admin/models">
								<i class="fa fa-folder"></i> <span>Models</span>
							</a>
						</li>
						<li class="<?= $gs_currentpage == '/admin/templates' ? active : ''?>">
							<a href="/admin/templates">
								<i class="fa fa-folder"></i> <span>Templates</span>
							</a>
						</li>
						<li class="<?= $gs_currentpage == '/admin/views' ? active : ''?>">
							<a href="/admin/views">
								<i class="fa fa-folder"></i> <span>Views</span>
							</a>
						</li>
						<li class="<?= $gs_currentpage == '/admin/routes' ? active : ''?>">
							<a href="/admin/routes">
								<i class="fa fa-folder"></i> <span>Routes</span>
							</a>
						</li>
						<li class="treeview <?= $gs_currentpage == '/admin/gitcommit' ? active : ''?>">
							<a href="#">
								<i class="fa fa-github"></i> <span>Github</span>
								<i class="fa fa-angle-left pull-right"></i>
							</a>
							<ul class="treeview-menu">
								<li><a href="/admin/gitcommit"><i class="fa fa-circle-o"></i> Commit</a></li>
								<li><a href="/admin/gitsearch"><i class="fa fa-circle-o"></i> Search</a></li>
							</ul>
						</li>

					</ul>
				</section>
				<!-- /.sidebar -->
			</aside>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">

				<?= $this->section('content') ?>

			</div><!-- /.content-wrapper -->
			<footer class="main-footer">
				<div class="pull-right hidden-xs">
					<b>Version</b> 1.0.0
				</div>
				<strong>Copyright &copy; 2015 <a href="https://github.com/skdeepak88/mercury">Mercury</a>.</strong> All rights reserved.
			</footer>

		</div><!-- ./wrapper -->

		<!-- jQuery 2.1.4 -->
		<script src="/mercury/assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		<script>
			$.widget.bridge('uibutton', $.ui.button);
		</script>
		<!-- Bootstrap 3.3.5 -->
		<script src="/mercury/assets/bootstrap/js/bootstrap.min.js"></script>
		<!-- daterangepicker -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
		<script src="/mercury/assets/plugins/daterangepicker/daterangepicker.js"></script>
		<!-- datepicker -->
		<script src="/mercury/assets/plugins/datepicker/bootstrap-datepicker.js"></script>
		<!-- Bootstrap WYSIHTML5 -->
		<script src="/mercury/assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
		<!-- Slimscroll -->
		<script src="/mercury/assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<!-- FastClick -->
		<script src="/mercury/assets/plugins/fastclick/fastclick.min.js"></script>
		<!-- AdminLTE App -->
		<script src="/mercury/assets/js/app.min.js"></script>
	</body>
</html>
