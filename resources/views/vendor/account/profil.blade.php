@extends('admin.layouts.master-vendor')
@section('css')
	<style>
	
		.avatar {
			background: #ffffff no-repeat center/cover !important;
		}
		.open-file{
			color: #705ec8 !important;
			text-decoration: underline;
			text-transform:lowercase;
			font-size: 14px;
		}
		.border-nav{
			padding: 14px;
			list-style: none;
			border: 1px solid #ebecf1;
		}
	</style>
	<!-- INTERNAL Accordion Css -->
	<link href="{{URL::asset('assets/plugins/accordion/accordion.css')}}" rel="stylesheet" />
	@endsection
	@section('page-header')
		<!--Page header-->
		<div class="page-header">
			<div class="page-leftheader">
				<h4 class="page-title mb-0">Account</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Account</a></li>
					<li class="breadcrumb-item active" aria-current="page"><a href="#">My data</a></li>
				</ol>
			</div>
		</div>
		<!--End Page header-->
	@endsection
	@section('content')
				<!--/app header-->

				<div class="col-xl-12 col-md-12 col-lg-12">
					<div class="card card-blog-overlay2 text-white"  @if($vendor->banner!=null &&Storage::disk('ftp')->exists($vendor->banner)) 
						style="background:url('https://ariba.ma/image/{{$vendor->banner}}') center !important;" @else style="background:url({{URL::asset('assets/images/photos/thumb2.jpg')}}) !important;" @endif>
						<div class="card-body text-center">
							<img class="avatar avatar-xxl brround mb-5" @if($vendor->logo!=null &&Storage::disk('ftp')->exists($vendor->logo)) src="https://ariba.ma/image/{{$vendor->logo}}"
							 @else src="https://ariba.ma/image/catalog/profile-pic.png"  @endif alt="img">
							<h4 class="font-weight-semibold mb-1">{{$description_eng[0]->name ?? $description_ar[0]->name ?? $description_fr[0]->name}}</h4>
							<p class="fs-12 mb-0">ARIBA SELLER</p>
						</div>
						<div class="card-body border-transparent">
							<div class="row mb-3">
								<div class="col-4 fs-12"></div>
								<div class="col-8 font-weight-semibold fs-12"></div>
							</div>
							<div class="row">
								<div class="col-4 fs-12"></div>
								<div class="col-8 font-weight-semibold fs-12"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="main-proifle">
					<div class="row">
						<div class="col-lg-9 col-sm-10">
							<div class="box-widget widget-user">
								<div class="widget-user-image1 d-sm-flex">
									<img alt="User Avatar" class="rounded-circle border p-0" height="70px;" src="https://ariba.ma/image/{{$vendor->image}}">
									<div class="mt-1 ml-lg-6 col-12">
										<h4 class="pro-user-username mb-3 font-weight-bold">{{$vendor->firstname}} {{$vendor->lastname}}
											@if($vendor->status==1)<span class="badge badge-success">Approved</span> <i class="fa fa-check-circle text-success"></i>
												@else<span class="badge badge-danger">Pending</span> <i class="fa fa-times-circle text-danger"></i>
											@endif</h4>
										<ul class="row">
											<li class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mt-3"><span class="profile-icon"><i class="fe fe-globe"></i></span><span class="h6 mt-3">{{$vendor->display_name}}</span></li>
											<li class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mt-3"><span class="profile-icon "><i class="fe fe-mail"></i></span><span class="h6 mt-3">{{$vendor->email}}</span></li>
											<li class="col-xl-4 col-lg-6 col-md-12 mt-3"><span class="profile-icon"><i class="fe fe-flag"></i></span><span class="h6 mt-3">{{$vendor->address_1}}, {{$vendor->city}}, {{$vendor->postcode}}</span></li>
											<li class="col-xl-4 col-lg-6 col-md-12 mt-3"><span class="profile-icon"><i class="fe fe-phone-call"></i></span><span class="h6 mt-3">{{$vendor->telephone}}</span></li>
											<li class="col-xl-4 col-lg-6 col-md-12 mt-3"><span class="profile-icon"><i class="fe fe-calendar"></i></span><span class="h6 mt-3">{{date('Y-m-d', strtotime($vendor->birthday))}}</span></li>
											<li class="col-xl-4 col-lg-6 col-md-12 mt-3"><span class="profile-icon"><i class="fe fe-printer"></i></span><span class="h6 mt-3">{{$vendor->fax}}</span></li>
										
										</ul>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-sm-2">
							<div class="text-lg-right btn-list ">
							<a href="{{route('vendor-account-update')}}" class="btn btn-primary" ><i class="fa fa-pencil"></i> </a>
							</div>
						</div>
					</div>
					<div class="col-lg-12 col-md-auto">
						<div class="mt-5">
							<div class="main-profile-contact-list row">
								<div class="media col-xl-2 col-lg-2 col-sm-12">
									<div class="media-icon bg-primary text-white mr-3 mt-1">
										<i class="fa fa-comments fs-18"></i>
									</div>
									<div class="media-body">
										<small class="text-muted">Products</small>
										<div class="font-weight-bold number-font">
											{{$count_product[0]->total}}
										</div>
									</div>
								</div>
								<div class="media col-xl-2 col-lg-2 col-sm-12">
									<div class="media-icon bg-secondary text-white mr-3 mt-1">
										<i class="fa fa-users fs-18"></i>
									</div>
									<div class="media-body">
										<small class="text-muted">Reviews</small>
										<div class="font-weight-normal1">
											{{$count_review[0]->total}}
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					
					<div class="profile-cover">
						<div class="wideget-user-tab">
							<div class="tab-menu-heading p-0">
								<div class="tabs-menu1 px-3">
									<ul class="nav">
										<li><a href="#tab-7" class="active fs-14" data-toggle="tab">{{ __('About') }}</a></li>
										<li><a href="#tab-9" data-toggle="tab" class="fs-14">{{ __('Store Information') }}</a></li>
										<li><a href="#tab-10" data-toggle="tab" class="fs-14">{{ __('Documents') }}</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div><!-- /.profile-cover -->
				</div>
				<!-- Row -->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="border-0">
							<div class="tab-content">
								<div class="tab-pane active" id="tab-7">
									
									<div class="card ">
										<div class="card-body">
											<h5 class="font-weight-bold">About Store</h5>
											<div class="main-profile-bio mb-0">
												<p>{{$vendor->about}}</p>
											</div>
										</div>

									
										<div class="card-body border-top">
											<h5 class="font-weight-bold">Information</h5>
											<div class="table-responsive">
												<table class="table mb-0 mt-5">
													<tbody>
														<tr>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Type of work </span>
															</td>
															<td class="py-2 px-0">{{$vendor->type}}</td>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-1">Bank name
																</span>
															</td>
															<td class="py-2 px-0">{{$vendor->bank_name}}</td>
														</tr>
														<tr>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">RIB </span>
															</td>
															<td class="py-2 px-0">{{$vendor->bank_account_number}}</td>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Account name </span>
															</td>
															<td class="py-2 px-0">{{$vendor->bank_account_name}}</td>
														</tr>
														<tr>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Order method </span>
															</td>
															<td class="py-2 px-0">@if($vendor->is_pre_order==1) Pre-order @else Stock @endif</td>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Supplier</span>
															</td>
															<td class="py-2 px-0">{{$vendor->supplier_email}}</td>
														</tr>
														@if($vendor->type=='Company' || $vendor->type=='Cooperative')
														<tr>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company name </span>
															</td>
															<td class="py-2 px-0">{{$vendor->company}}</td>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company owner </span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_president}}</td>
														</tr>
														<tr>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company address </span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_address1}}</td>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company city </span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_city}} {{$vendor->company_zip_code}}</td>
														</tr>
														<tr>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company country </span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_country}}</td>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company email</span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_email}}</td>
														</tr>
														<tr>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company phone </span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_phone}}</td>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company fax</span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_fax}}</td>
														</tr>
														<tr>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company register Number </span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_register_number}}</td>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Company register City</span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_register_city}}</td>
														</tr>
														<tr>
															<td class="py-2 px-0">
																<span class="font-weight-semibold w-50">Your position</span>
															</td>
															<td class="py-2 px-0">{{$vendor->company_position }}</td>
														</tr>
														@endif
													</tbody>
												</table>
											</div>
										</div>

										<div class="card-body border-top">
											<h5 class="font-weight-bold">ID Card</h5>
											<div class="mt-4">
												<p class="mb-0"></p>
												<div class="row row-sm">
													<div class="col-md-2 col-lg-2"></div>
													<div class="col-md-2 col-lg-2">
														<div class="card overflow-hidden ">
															<img @if(Storage::disk('ftp')->exists($vendor->identity_picture1) && $vendor->identity_picture1!=null) 	
																src="https://ariba.ma/image/{{ $vendor->identity_picture1 }}" @else src="https://media.istockphoto.com/vectors/error-page-or-file-not-found-icon-vector-id924949200" @endif class="card-image1" height="100%">
															<div class="card-body">
																<h5 class="card-title text-center">Front</h5>
															</div>
														</div>
													</div>	
													<div class="col-md-4 col-lg-4"></div>
													<div class="col-md-2 col-lg-2">
														<div class="card overflow-hidden ">
															<img @if(Storage::disk('ftp')->exists($vendor->identity_picture2) && $vendor->identity_picture2!=null) 	
																src="https://ariba.ma/image/{{ $vendor->identity_picture2}}" @else src="https://media.istockphoto.com/vectors/error-page-or-file-not-found-icon-vector-id924949200" @endif class="card-image1" height="100%">
															<div class="card-body">
																<h5 class="card-title text-center">Back</h5>
															</div>
														</div>
													</div>
													<div class="col-md-2 col-lg-2"></div>
												</div>
											</div>
										</div>


										<div class="card-body border-top">
											<h5 class="font-weight-bold"></h5>	
										</div>
										
									</div>
								</div>
								
								<div class="tab-pane" id="tab-9">
								<div class="card">
									<div class="card-body">
								<div class="row">
									<!-- ENGLISH -->
									<div class="col-lg-4">
										<div class="expanel expanel-default">
											<div class="expanel-heading">
												<h3 class="expanel-title" style="text-align: center">Store
													information
													in English &nbsp <i class="flag flag-us"></i></h3>
											</div>
											<div class="expanel-body">
												<div class="row row-sm">
													<div class="col-lg">
														<label class="col-md-12 form-label">Store Name</label>
														<input class="form-control mb-4"
																placeholder="store name"
																type="text" style="color: black" disabled
																value='{!!$description_eng[0]->name ?? '' !!}'
																name='name_1'>
													</div>
												</div>
												<ul class="demo-accordion accordionjs m-0">
													<li>
														<div><h3>Store Description</h3></div>
														<div>
															{!! html_entity_decode($description_eng[0]->description) !!}
														</div>
													</li>
													<li>
														<div><h3>Shipping Policy</h3></div>
														<div>
															{!! html_entity_decode($description_eng[0]->shipping_policy) !!}
														</div>
													</li>
													<li>
														<div><h3>Return Policy</h3></div>
														<div  class="panel-body">
															{!! html_entity_decode($description_eng[0]->return_policy) !!}
														</div>
													</li>
												</ul>
												
											</div>
										</div>
									</div>
									<!-- FRENCH -->
									<div class="col-lg-4">
										<div class="expanel expanel-default">
											<div class="expanel-heading">
												<h3 class="expanel-title" style="text-align: center">Store
													information
													in French &nbsp<i class="flag flag-fr"></i></h3>
											</div>
											<div class="expanel-body">
												<div class="row row-sm">
													<div class="col-lg">
														<label class="col-md-12 form-label">Store Name</label>
														<input class="form-control mb-4"
																placeholder="store name"
																type="text" style="color: black" disabled
																value='{{ old('name_2') ?? ($description_fr[0]->name ?? '') }}'
																name='name_2'>
													</div>
												</div>
												<ul class="demo-accordion accordionjs m-0">
													<li>
														<div><h3>Store Description</h3></div>
														<div>
															{!! html_entity_decode($description_fr[0]->description) !!}
														</div>
													</li>
													<li>
														<div><h3>Shipping Policy</h3></div>
														<div>
															{!! html_entity_decode($description_fr[0]->shipping_policy) !!}
														</div>
													</li>
													<li>
														<div><h3>Return Policy</h3></div>
														<div  class="panel-body">
															{!! html_entity_decode($description_fr[0]->return_policy) !!}
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<!-- ARABIC -->
									<div class="col-lg-4">
										<div class="expanel expanel-default">
											<div class="expanel-heading">
												<h3 class="expanel-title" style="text-align: center">Store
													information
													in Arabic &nbsp <i class="flag flag-ma"></i></h3>
											</div>
											<div class="expanel-body">
												<div class="row row-sm">
													<div class="col-lg">
														<label class="col-md-12 form-label">Store Name</label>
														<input class="form-control mb-4"
																placeholder="store name" 
																type="text" style="color: black" disabled
																value='{{ old('name_3') ?? ($description_ar[0]->name ?? '') }}'
																name='name_3'>
													</div>
												</div>
												<ul class="demo-accordion accordionjs m-0">
													<li>
														<div><h3>Store Description</h3></div>
														<div>
															{!! html_entity_decode($description_ar[0]->description) !!}
														</div>
													</li>
													<li>
														<div><h3>Shipping Policy</h3></div>
														<div>
															{!! html_entity_decode($description_ar[0]->shipping_policy) !!}
														</div>
													</li>
													<li>
														<div><h3>Return Policy</h3></div>
														<div  class="panel-body">
															{!! html_entity_decode($description_ar[0]->return_policy) !!}
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
							<!-- END-GENERAL STORE TAB -->
					</div>

								<div class="tab-pane" id="tab-10">
									<div class="card">
										<div class="card-body border-top">
											<h5 class="font-weight-bold">Justification Document</h5>
												<div class="mt-6">
												<p class="mb-0"></p>
													<div class="row row-sm">

											@php
											if($vendor->company_status!=null && Storage::disk('ftp')->exists($vendor->company_status))
											{
												$found=1;
											}else{
												$found=0;
											}
											@endphp
												<div class="col-md-4 col-lg-4">
													<ul class="nav panel-tabs border-nav mt-5" @if($found==0) style="border: 1px solid #f94859;" @endif>
														<li class="active">
															<a class="d-flex" target="_blank" @if($found==1) href="https://ariba.ma/image/{{$vendor->company_status}}" @endif>
																<img src="{{URL::asset('assets/images/files/document.png')}}" alt="img" class="w-7 h-7 mr-4">
																<div class="mt-1">
																	<h5 class="mb-1 font-weight-bold mt-0">Company Status @if($found==0) <span class="badge badge-danger-light">must upload ! </span>@endif</h5>
																	<p class="mb-0 text-muted">Company Status</p>
																</div>
															</a>
														</li>
													</ul>
												</div>

											@php
											if($vendor->company_trade_register!=null && Storage::disk('ftp')->exists($vendor->company_trade_register))
											{
												$found=1;
											}else{
												$found=0;
											}
											@endphp
												<div class="col-md-4 col-lg-4">
													<ul class="nav panel-tabs border-nav mt-5" @if($found==0) style="border: 1px solid #f94859;" @endif>
														<li class="active">
															<a class="d-flex" target="_blank" @if($found==1) href="https://ariba.ma/image/{{$vendor->company_trade_register}}" @endif>
																<img src="{{URL::asset('assets/images/files/document.png')}}" alt="img" class="w-7 h-7 mr-4">
																<div class="mt-1">
																	<h5 class="mb-1 font-weight-bold mt-0">Trade Register @if($found==0) <span class="badge badge-danger-light">must upload ! </span>@endif</h5>
																	<p class="mb-0 text-muted">Trade Register</p>
																</div>
															</a>
														</li>
													</ul>
												</div>


											@php
											if($vendor->company_tax!=null && Storage::disk('ftp')->exists($vendor->company_tax))
											{
												$found=1;
											}else{
												$found=0;
											}
											@endphp
												<div class="col-md-4 col-lg-4">
													<ul class="nav panel-tabs border-nav mt-5" @if($found==0) style="border: 1px solid #f94859;" @endif>
														<li class="active">
															<a class="d-flex" target="_blank" @if($found==1) href="https://ariba.ma/image/{{$vendor->company_tax}}" @endif>
																<img src="{{URL::asset('assets/images/files/document.png')}}" alt="img" class="w-7 h-7 mr-4">
																<div class="mt-1">
																	<h5 class="mb-1 font-weight-bold mt-0">Company Tax @if($found==0) <span class="badge badge-danger-light">must upload ! </span>@endif</h5>
																	<p class="mb-0 text-muted">Company Tax </p>
																</div>
															</a>
														</li>
													</ul>
												</div>
											</div>
											
											@php
											if($vendor->company_registration!=null && Storage::disk('ftp')->exists($vendor->company_registration))
											{
													$found=1;
											}else{
												$found=0;
											}
											@endphp
											<div class="row">
												<div class="col-md-4 col-lg-4">
													<ul class="nav panel-tabs border-nav mt-5" @if($found==0) style="border: 1px solid #f94859;" @endif>
														<li class="active">
															<a class="d-flex" target="_blank" @if($found==1) href="https://ariba.ma/image/{{$vendor->company_registration}}" @endif>
																<img src="{{URL::asset('assets/images/files/document.png')}}" alt="img" class="w-7 h-7 mr-4">
																<div class="mt-1">
																	<h5 class="mb-1 font-weight-bold mt-0">Company Registration @if($found==0) <span class="badge badge-danger-light">must upload ! </span>@endif</h5>
																	<p class="mb-0 text-muted">Company Registration </p>
																</div>
															</a>
														</li>
													</ul>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div><!-- end app-content-->
	</div>
@endsection
@section('js')
<!--INTERNAL Accordion js-->
<script src="{{URL::asset('assets/plugins/accordion/accordion.min.js')}}"></script>
<script>$(".demo-accordion").accordionjs();</script>
@endsection