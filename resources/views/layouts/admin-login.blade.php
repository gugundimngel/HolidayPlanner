<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="Best tour planner is leading travel agency in delhi offer best holiday packages services">
		<meta name="author" content="Ansonika">
		<link rel="shortcut icon" type="image/png" href="{!! asset('public/img/favicon.png') !!}"/>
		<title>Holiday Planner | @yield('title')</title>
		<!-- Favicons-->
		<link rel="shortcut icon" href="{!! asset('public/img/Frontend/img/favicon.png') !!}" type="image/x-icon">
		<link rel="apple-touch-icon" type="image/x-icon" href="{!! asset('public/img/Frontend/img/apple-touch-icon-57x57-precomposed.png') !!}">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="{!! asset('public/img/Frontend/img/apple-touch-icon-72x72-precomposed.png') !!}">
		<link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="{!! asset('public/img/Frontend/img/apple-touch-icon-114x114-precomposed.png') !!}">
		
		<!-- GOOGLE WEB FONT -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">
		 <!-- BASE CSS -->
		<link href="{{URL::asset('public/css/Frontend/bootstrap.min.css')}}" rel="stylesheet">
		<link href="{{URL::asset('public/css/Frontend/login.css')}}" rel="stylesheet">
		<link href="{{URL::asset('public/css/Frontend/vendors.css')}}" rel="stylesheet">
		<!-- ALTERNATIVE COLORS CSS -->
		<link href="#" id="colors" rel="stylesheet">
		<!-- YOUR CUSTOM CSS -->
		<link href="{{URL::asset('public/css/Frontend/custom.css')}}" rel="stylesheet">
		<link href="{{URL::asset('public/css/Frontend/modernizr_slider.css')}}" rel="stylesheet">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script src="{{URL::asset('public/js/Frontend/jquery-2.2.4.min.js')}}"></script>			
	</head>
	<div id="login_bg">
		<!--<div id="loader">
			<div class="loading_image">
				<div class="valid">
					<img src="{!! asset('public/img/loader.gif') !!}">
				</div>
			</div>
		</div>--> 
		
		@yield('content')
		
		<!-- COMMON SCRIPTS -->
		<script type="text/javascript">
			var site_url = "<?php echo URL::to('/'); ?>";
		</script>
		<script src="{{URL::asset('public/js/Frontend/common_scripts.js')}}"></script>
		<!--<script src="{{URL::asset('public/js/Frontend/main.js')}}"></script>
		<script src="{{URL::asset('public/js/Frontend/validate.js')}}"></script>
		<script src="{{URL::asset('public/js/Frontend/readmore_fade.js')}}"></script>
		<script src="{{URL::asset('public/js/Frontend/custom.js')}}"></script>-->
		
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	</body>
</html>