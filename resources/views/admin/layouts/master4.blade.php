<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Ariba - Admin Panel" name="description">
		<meta content="infdodat" name="author">
		<meta name="keywords" content="ariba admin panel"/>
		@include('admin.layouts.custom-head')
	</head>
	<body class="h-100vh bg-primary">
		@yield('content')
		@include('admin.layouts.custom-footer-scripts')
	</body>
</html>
