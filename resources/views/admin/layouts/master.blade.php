<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Ariba - Admin Panel" name="description">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta content="Ariba" name="author">
		<meta name="keywords" content="admin panel ariba"/>
		@include('admin.layouts.head')
	</head>

	<body class="app sidebar-mini">
		<!---Global-loader-->
		<div id="global-loader" >
			<img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
		</div>
		<!--- End Global-loader-->
		<!-- Page -->
		<div class="page">
			<div class="page-main">
                @include('admin.layouts.aside-menu')
				<!-- App-Content -->
				<div class="app-content main-content">
					<div class="side-app">
						@include('admin.layouts.header')
						@yield('page-header')
						@yield('content')
		</div><!-- End Page -->
			@include('admin.layouts.footer-scripts')
	</body>
</html>
