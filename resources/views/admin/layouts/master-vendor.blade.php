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
            @include('admin.layouts.aside-menu-vendor')
				<!-- App-Content -->
				<div class="app-content main-content">
					<div class="side-app">
						@include('admin.layouts.header-vendor')
						@yield('page-header')
						@yield('content')
						<!-- Email Vevification success -->
						<div class="modal" id="modaldemo4">
							<div class="modal-dialog modal-dialog-centered text-center " role="document">
								<div class="modal-content tx-size-sm">
									<div class="modal-body text-center p-4">
										<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
										<i class="fe fe-check-circle fs-100 text-success lh-1 mb-5 d-inline-block"></i>
										<h4 class="text-success tx-semibold">Email Address Verified!</h4>
										<p class="mg-b-20 mg-x-20">Congradulation Your email address has been verified, for the second step you have to compelete you information, Thank you for your understanding.</p><button aria-label="Close" class="btn btn-success pd-x-25" data-dismiss="modal" type="button">Continue</button>
									</div>
								</div>
							</div>
						</div>
		</div><!-- End Page -->
			@include('admin.layouts.footer-scripts')
	</body>
</html>
