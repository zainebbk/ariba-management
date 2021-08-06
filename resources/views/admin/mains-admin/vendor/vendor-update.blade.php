@extends('admin.layouts.master')
@section('css')
    <!-- INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

    <!-- INTERNAL Date Picker css -->
    <link href="{{ URL::asset('assets/plugins/date-picker/date-picker.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ URL::asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!-- INTERNAL  Tabs css-->
    <link href="{{ URL::asset('assets/plugins/tabs/style.css') }}" rel="stylesheet" />


@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Edit vendor</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/vendor"><i class="fe fe-file-text mr-2 fs-14"></i>vendors</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/admin/vendor">Edit vendor</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <style>
        input[name="disable-image"].disabled {
            pointer-events: none;
        }

    </style>
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit vendor </h3>
                </div>
                <div class="card-body pb-2">
                    @can('vendor-edit')
                        <form action="{{ route('update-vendor', [$vendor->vendor_id]) }}" method='POST' role="form"
                            enctype="multipart/form-data">
                            @csrf

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success" role="alert"><button type="button" class="close"
                                        data-dismiss="alert" aria-hidden="true">×</button>
                                    <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{ $message }}.
                                </div>
                            @endif
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endcan
                        <div class="panel panel-primary">
                            <div class="tab_wrapper first_tab">
                                <ul class="tab_list">
                                    <li>Vendor</li>
                                    <li>General Store</li>
                                    <li>Payment</li>
                                </ul>
                                <div class="content_wrapper">

                                    <!-- START-VENDOR TAB -->
                                    <div class="tab_content">
                                        <div class="row row-sm">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">First Name</label>
                                                <input class="form-control mb-4" placeholder="first name" type="text"
                                                    name='firstname' value='{{ old('firstname') ?? $vendor->firstname }}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Last Name</label>
                                                <input class="form-control mb-4" placeholder="last name" type="text"
                                                    name='lastname' value='{{ old('lastname') ?? $vendor->lastname }}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Display Name</label>
                                                <input class="form-control mb-4" placeholder="display Name" type="text"
                                                    name='display_name'
                                                    value='{{ old('display_name') ?? $vendor->display_name }}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Date of Birth</label>
                                                <input class="form-control mb-4" placeholder="date of birth" type="date"
                                                    name='birthday'
                                                    value="{{ old('birthday') ?? date('Y-m-d', strtotime($vendor->birthday)) }}">
                                            </div>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Email</label>
                                                <input class="form-control mb-" placeholder="email" type="email"
                                                    name='email' value='{{ old('email') ?? $vendor->email }}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Phone Number</label>
                                                <input class="form-control mb-" placeholder="phone number" type="text"
                                                    name='telephone'
                                                    value='{{ old('telephone') ?? $vendor->telephone }}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Fax</label>
                                                <input class="form-control mb-" placeholder="fax" type="text" name='fax'
                                                    value='{{ old('fax') ?? $vendor->fax }}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Status</label>
                                                <div class="col-md-12">
                                                    <select class="form-control select2" name="status">
                                                        <option @if ($vendor->status == 1) selected @endif value="1">Approved
                                                        </option>
                                                        <option @if ($vendor->status == 0) selected @endif value="0">Disapproved
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Address</label>
                                                <input class="form-control mb-4" placeholder="address" type="text"
                                                    name='address_1'
                                                    value='{{ old('address_1') ?? $vendor->address_1 }}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">City</label>
                                                <input class="form-control mb-4" placeholder="city" type="text" name='city'
                                                    value='{{ old('city') ?? $vendor->city }}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Post Code</label>
                                                <input class="form-control mb-4" placeholder="postcode" type="text"
                                                    name='postcode' value='{{ old('postcode') ?? $vendor->postcode }}'>
                                            </div>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg-4 col-sm-12">
                                                <label class="col-md-12 form-label">Vendor image</label>
                                                <input type="file" class="dropify" name='identity_picture2'
                                                    data-default-file="https://ariba.ma/image/{{ $vendor->image }}"
                                                    value='{{ old('image') ?? $vendor->image }}'
                                                    data-height="310"  />
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <label class="col-md-12 form-label">Logo</label>
                                                <input type="file" class="dropify" name='logo'
                                                       data-default-file="https://ariba.ma/image/{{ $vendor->logo }}"
                                                       value='{{ old('logo') ?? $vendor->logo }}'
                                                       data-height="310"  />
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <label class="col-md-12 form-label">Banner image</label>
                                                <input type="file" class="dropify" name='banner'
                                                       data-default-file="https://ariba.ma/image/{{ $vendor->banner }}"
                                                       value='{{ old('banner') ?? $vendor->banner }}'
                                                       data-height="310"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="blocked" @if( $vendor->blocked==1) checked @endif>
                                                <span class="custom-control-label col-lg-12">Blocked</span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- END-VENDOR TAB -->

                                    <!-- start-GENERAL STORE TAB -->
                                    <div class="tab_content active">
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
                                                                       type="text"
                                                                       value='{{ old('name_1') ?? ($description_eng[0]->name ?? '') }}'
                                                                       name='name_1'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Store Description</label>
                                                                <textarea rows="6" class="form-control mb-4"
                                                                          placeholder="description"
                                                                          value='{{ old('description_1') ?? ($description_eng[0]->description ?? '') }}'
                                                                          name='description_1'>{{ old('description_1') ?? ($description_eng[0]->description ?? '') }}</textarea>
                                                            </div>
                                                            <input type='hidden' id='blog_description' name="content">
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Shipping Policy</label>
                                                                <textarea rows="6" class="form-control mb-4"
                                                                          placeholder="shipping policy"
                                                                          value='{{ old('shipping_policy_1') ?? ($description_eng[0]->shipping_policy ?? '') }}'
                                                                          name='shipping_policy_1'>{{ old('shipping_policy_1') ?? ($description_eng[0]->shipping_policy ?? '') }}</textarea>
                                                            </div>
                                                            <input type='hidden' id='blog_description' name="content">
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Return Policy</label>
                                                                <textarea rows="6" class="form-control mb-4"
                                                                          placeholder="return policy"
                                                                          value='{{ old('return_policy_1') ?? ($description_eng[0]->return_policy ?? '') }}'
                                                                          name='return_policy_1'>{{ old('return_policy_1') ?? ($description_eng[0]->return_policy ?? '') }}</textarea>
                                                            </div>
                                                            <input type='hidden' id='blog_description' name="content">
                                                        </div>
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
                                                                       type="text"
                                                                       value='{{ old('name_2') ?? ($description_fr[0]->name ?? '') }}'
                                                                       name='name_2'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Store Description</label>
                                                                <textarea rows="6" class="form-control mb-4"
                                                                          placeholder="description"
                                                                          value='{{ old('description_2') ?? ($description_fr[0]->description ?? '') }}'
                                                                          name='description_2'>{{ old('description_2') ?? ($description_fr[0]->description ?? '') }}</textarea>
                                                            </div>
                                                            <input type='hidden' id='blog_description' name="content">
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Shipping Policy</label>
                                                                <textarea rows="6" class="form-control mb-4"
                                                                          placeholder="shipping policy"
                                                                          value='{{ old('shipping_policy_2') ?? ($description_fr[0]->shipping_policy ?? '') }}'
                                                                          name='shipping_policy_2'>{{ old('shipping_policy_2') ?? ($description_fr[0]->shipping_policy ?? '') }}</textarea>
                                                            </div>
                                                            <input type='hidden' id='blog_description' name="content">
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Return Policy</label>
                                                                <textarea rows="6" class="form-control mb-4"
                                                                          placeholder="return policy"
                                                                          value='{{ old('return_policy_2') ?? ($description_fr[0]->return_policy ?? '') }}'
                                                                          name='return_policy_2'>{{ old('return_policy_2') ?? ($description_fr[0]->return_policy ?? '') }}</textarea>
                                                            </div>
                                                            <input type='hidden' id='blog_description' name="content">
                                                        </div>
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
                                                                       type="text"
                                                                       value='{{ old('name_3') ?? ($description_ar[0]->name ?? '') }}'
                                                                       name='name_3'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Store Description</label>
                                                                <textarea rows="6" class="form-control mb-4"
                                                                          placeholder="description"
                                                                          value='{{ old('description_3') ?? ($description_ar[0]->description ?? '') }}'
                                                                          name='description_3'>{{ old('description_3') ?? ($description_ar[0]->description ?? '') }}</textarea>
                                                            </div>
                                                            <input type='hidden' id='blog_description' name="content">
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Shipping Policy</label>
                                                                <textarea rows="6" class="form-control mb-4"
                                                                          placeholder="shipping policy"
                                                                          value='{{ old('shipping_policy_3') ?? ($description_ar[0]->shipping_policy ?? '') }}'
                                                                          name='shipping_policy_3'>{{ old('shipping_policy_3') ?? ($description_ar[0]->shipping_policy ?? '') }}</textarea>
                                                            </div>
                                                            <input type='hidden' id='blog_description' name="content">
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Return Policy</label>
                                                                <textarea rows="6" class="form-control mb-4"
                                                                          placeholder="return policy"
                                                                          value='{{ old('return_policy_3') ?? ($description_ar[0]->return_policy ?? '') }}'
                                                                          name='return_policy_3'>{{ old('return_policy_3') ?? ($description_ar[0]->return_policy ?? '') }}</textarea>
                                                            </div>
                                                            <input type='hidden' id='blog_description' name="content">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END-GENERAL STORE TAB -->

                                    <!-- START-Payment TAB -->
                                    <div class="tab_content active">
                                        <div lass="row row-sm mt-2">
                                            <h2 class="card-title">Payment information :</h2>
                                        </div>
                                        <div class="row row-sm mt-4">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Type of work</label>
                                                <div class="col-md-12">
                                                    <select class="form-control select2" name="type">
                                                        <option value="Company" @if($vendor->type=="Company") selected @endif>Company</option>
                                                        <option value="Cooperative" @if($vendor->type=="Cooperative") selected @endif>Cooperative</option>
                                                        <option value="Individual" @if($vendor->type=="Individual") selected @endif>Individual(vendor)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Select bank name</label>
                                                <div class="col-md-12">
                                                    <select class="form-control select2" name="bank_name">
                                                        <option value="CIH" @if ($vendor->bank_name == 'CIH') selected @endif>CIH</option>
                                                        <option value="Barid bank" @if ($vendor->bank_name == 'Barid bank') selected @endif>Barid bank</option>
                                                        <option value="BMCE bank" @if ($vendor->bank_name == 'BMCE bank') selected @endif>BMCE bank</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">RIB</label>
                                                <input class="form-control mb-4" placeholder="RIB" type="text"
                                                    name='bank_account_number'
                                                    value='{{ old('bank_account_number') ?? $vendor->bank_account_number }}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Account Name</label>
                                                <input class="form-control mb-4" placeholder="Account Name"
                                                    value='{{ old('bank_account_name') ?? $vendor->bank_account_name }}'
                                                    type="text" name='bank_account_name'>
                                            </div>
                                        </div>

                                        <div class="row row-sm mt-4">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Method</label>
                                                <div class="col-md-12">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="is_pre_order" value=1 @if($vendor->is_pre_order==1) checked @endif>
                                                        <span class="custom-control-label" >Pre-order</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Supplier Email</label>
                                                <input class="form-control mb-4" placeholder="Supplier Email"
                                                       type="email"
                                                       name='supplier_email' value='{{ old('supplier_email') ?? $vendor->supplier_email}}'>
                                            </div>
                                        </div>

                                        <div lass="row row-sm mt-4">
                                            <h2 class="card-title">Identity Card Picture :</h2>
                                        </div>
                                        <div class="row row-sm mt-4">
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Front</label>
                                                <input type="file" class="dropify" name='identity_picture1'
                                                    data-default-file="https://ariba.ma/image/{{ $vendor->identity_picture1 }}"
                                                    value='{{ old('identity_picture1') ?? $vendor->identity_picture1 }}'
                                                    data-height="310"  />
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Back</label>
                                                <input type="file" class="dropify" name='identity_picture2'
                                                    data-default-file="https://ariba.ma/image/{{ $vendor->identity_picture2 }}"
                                                    value='{{ old('identity_picture2') ?? $vendor->identity_picture2 }}'
                                                    data-height="310"  />
                                            </div>
                                        </div>

                                        <div lass="row row-sm mt-4">
                                            <h2 class="card-title mt-5 mb-5" >Additional Document :</h2>
                                        </div>
                                        <div class="row row-sm mt-4">
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Trade Register &nbsp <a href="https://ariba.ma/image/{{ $vendor->company_trade_register }}" target="_blank" ><button type="button" class="btn btn-dark btn-svgs btn-svg-white"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"></path><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"></path></svg><div class="btn-svg-text">Open</div></button></a></label>
                                                <input type="file" class="dropify_file" name='company_trade_register' data-default-file="https://ariba.ma/image/{{ $vendor->company_trade_register }}"
                                                    data-height="310"  value='{{ old('company_trade_register')}}' />
                                                </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Company Status &nbsp <a href="https://ariba.ma/image/{{ $vendor->company_status }}" target="_blank" ><button type="button" class="btn btn-dark btn-svgs btn-svg-white"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"></path><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"></path></svg><div class="btn-svg-text">Open</div></button></a></label>
                                                <input type="file" class="dropify_file" name='company_status' data-default-file="https://ariba.ma/image/{{ $vendor->company_status }}"
                                                    data-height="310"  value='{{ old('company_status')}}' />
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Company Tax &nbsp <a href="https://ariba.ma/image/{{ $vendor->company_tax }}" target="_blank" ><button type="button" class="btn btn-dark btn-svgs btn-svg-white"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"></path><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"></path></svg><div class="btn-svg-text">Open</div></button></a></label>
                                                <input type="file" class="dropify_file" name='company_tax' data-default-file="https://ariba.ma/image/{{ $vendor->company_tax }}"
                                                    data-height="310"  value='{{ old('company_tax')}}' />
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Company Registration &nbsp <a href="https://ariba.ma/image/{{ $vendor->company_registration }}" target="_blank" ><button type="button" class="btn btn-dark btn-svgs btn-svg-white"><svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"></path><path d="M13 4H6v16h12V9h-5V4zm3 14H8v-2h8v2zm0-6v2H8v-2h8z" opacity=".3"></path><path d="M8 16h8v2H8zm0-4h8v2H8zm6-10H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"></path></svg><div class="btn-svg-text">Open</div></button></a></label>
                                                <input type="file" class="dropify_file" name='company_registration' data-default-file="https://ariba.ma/image/{{ $vendor->company_registration}}"
                                                    data-height="310"  value='{{ old('company_registration')}}' />
                                            </div>
                                        </div>

                                    </div>
                                    <!-- END-Payment TAB -->

                                </div>
                            </div>
                        </div>
                        @can('vendor-edit')
                            <button type="submit" class="btn btn-primary mt-4 mb-0">Save</button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
    <!--- INTERNAL Tabs js-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>

    <!--INTERNAL Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

    <!-- INTERNAL Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/date-picker/date-picker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>

    <!-- INTERNAL File uploads js -->
    <script src="{{ URL::asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filupload.js') }}"></script>

@endsection
