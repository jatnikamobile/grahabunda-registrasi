<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title> @yield('title') </title>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<link rel="icon" href="/template/images/thumb/logo-grahabunda.png" type="image/ico" />

		<!-- bootstrap & fontawesome -->
	    <link rel="stylesheet" href="/template/css/bootstrap.min.css" />
	    <link rel="stylesheet" href="/template/font-awesome/4.5.0/css/font-awesome.min.css" />
	    <!-- page specific plugin styles -->

	    <!-- text fonts -->
	    <link rel="stylesheet" href="/template/css/fonts.googleapis.com.css" />

	    <!-- ace styles -->
	    <link rel="stylesheet" href="/template/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	    <link rel="stylesheet" href="/template/css/ace-skins.min.css" />
	    <link rel="stylesheet" href="/template/css/ace-rtl.min.css" />
	    <!-- jQuery -->
    	<script src="/template/jquery.min.js"></script>
	</head>

	<body class="login-layout" style="background-image: url(/template/images/bg.jpeg); background-size: cover;">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-12">
						<div class="login-container">
							<br><br><hr>
							<div class="center">
								<h1>
									<img src="/template/images/thumb/logo-grahabunda.png" width="100" alt="logo_rs">
									<br>
									<span class="red"> Modul Registrasi</span>
								</h1>
							</div>
							<div class="space-6"></div><hr>
							<div class="position-relative">
								@yield('content')
							</div>
							<div class="center">
								<h4 class="blue" id="id-company-text">&copy; RSU Graha Bunda</h4>
							</div><hr>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.main-content -->
			</div><!-- /.main-container -->

		<!-- basic scripts -->

		
		<script type="text/javascript">
			$(document).ready(function(){
				$.ajaxSetup({
					headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }
				});
			});
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/template/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<!-- inline scripts related to this page -->
		@yield('script')
	</body>
</html>
