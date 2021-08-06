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
            <h4 class="page-title mb-0">Create vendor</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/vendor"><i class="fe fe-file-text mr-2 fs-14"></i>vendors</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/admin/vendor">Add vendor</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Set vendor </h3>
                </div>
                <div class="card-body pb-2">

                    <form action="{{ route('add-vendor') }}" method='POST' role="form" enctype="multipart/form-data">
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
                                                    name='firstname'  value='{{ old('firstname')}}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Last Name</label>
                                                <input class="form-control mb-4" placeholder="last name" type="text"
                                                    name='lastname'  value='{{ old('lastname')}}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Display Name</label>
                                                <input class="form-control mb-4" placeholder="display Name" type="text"
                                                    name='display_name'  value='{{ old('display_name')}}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Date of Birth</label>
                                                <input class="form-control mb-4" placeholder="date of birth" type="date"
                                                    name='birthday'  value='{{ old('birthday')}}'>
                                            </div>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Email</label>
                                                <input class="form-control mb-" placeholder="email" type="email"
                                                    name='email'  value='{{ old('email')}}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Phone Number</label>
                                                <input class="form-control mb-" placeholder="phone number" type="text"
                                                    name='telephone'  value='{{ old('telephone')}}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Fax</label>
                                                <input class="form-control mb-" placeholder="fax" type="text" name='fax'  value='{{ old('fax')}}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Status</label>
                                                <div class="col-md-12">
                                                    <select class="form-control select2" name="status">
                                                        <option value="1" @if(old('status')==1) 'selected' @endif>Approved</option>
                                                        <option value="0"  @if(old('status')==0) 'selected' @endif>Disapproved</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Address</label>
                                                <input class="form-control mb-4" placeholder="address" type="text"
                                                    name='address_1'  value='{{ old('address_1')}}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">City</label>
                                                <input class="form-control mb-4" placeholder="city" type="text" name='city'  value='{{ old('city')}}'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Post Code</label>
                                                <input class="form-control mb-4" placeholder="postcode" type="text"
                                                    name='postcode'  value='{{ old('postcode')}}'>
                                            </div>
                                            <!--<div class="col-lg">
                                                            <label class="col-md-4 form-label">Country</label>
                                                            <select class="form-control select2" name="country_id">
                                                                <option value="">---Select---</option>
                                                                @foreach ($data['countries'] as $country)
                                                                    <option value="{{ $country->country_id }}">{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg">
                                                            <label class="col-md-6 form-label">State</label>
                                                            <select class="form-control select2" name="zone_id">
                                                                <option value="">---None---</option>
                                                            </select>
                                                        </div>-->
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Password</label>
                                                <input class="form-control mb-4" placeholder="password" type="password"
                                                    name='password'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Confirm Password</label>
                                                <input class="form-control mb-4" placeholder="confirm password"
                                                    type="password" name='password_confirmation'>
                                            </div>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg-4 col-sm-12">
                                                <label class="col-md-12 form-label">Vendor image</label>
                                                <input type="file" class="dropify" name='image' data-height="210"   value='{{ old('image')}}'/>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <label class="col-md-12 form-label">Store Logo</label>
                                                <input type="file" class="dropify" name='logo' data-height="210"   value='{{ old('logo')}}'/>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <label class="col-md-12 form-label">Banner Image</label>
                                                <input type="file" class="dropify" name='banner' data-height="210"   value='{{ old('banner')}}'/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END-VENDOR TAB -->

                                    <!-- start-GENERAL STORE TAB -->
                                    <div class="tab_content active">
                                        <!-- ENGLISH -->
                                        <div class="row">
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
                                                                type="text" name='name_1'   value='{{ old('name_1')}}'>
                                                        </div>
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <label class="col-md-12 form-label">Store Description</label>
                                                            <textarea rows="6" class="form-control mb-4"
                                                                placeholder="description" name='description_1'> {{ old('description_1')}}</textarea>
                                                        </div>
                                                        <input type='hidden' id='blog_description' name="content">
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <label class="col-md-12 form-label">Shipping Policy</label>
                                                            <textarea rows="6" class="form-control mb-4"
                                                                placeholder="shipping policy"
                                                                name='shipping_policy_1'>{{ old('shipping_policy_1')}}</textarea>
                                                        </div>
                                                        <input type='hidden' id='blog_description' name="content">
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <label class="col-md-12 form-label">Return Policy</label>
                                                            <textarea rows="6" class="form-control mb-4"
                                                                placeholder="return policy"
                                                                name='return_policy_1'>{{ old('return_policy_1')}}</textarea>
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
                                                                type="text" name='name_2'  value='{{ old('name_2')}}'>
                                                        </div>
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <label class="col-md-12 form-label">Store Description</label>
                                                            <textarea rows="6" class="form-control mb-4"
                                                                placeholder="description" name='description_2'>{{ old('description_2')}}</textarea>
                                                        </div>
                                                        <input type='hidden' id='blog_description' name="content">
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <label class="col-md-12 form-label">Shipping Policy</label>
                                                            <textarea rows="6" class="form-control mb-4"
                                                                placeholder="shipping policy"
                                                                name='shipping_policy_2'>{{ old('shipping_policy_2')}}</textarea>
                                                        </div>
                                                        <input type='hidden' id='blog_description' name="content">
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <label class="col-md-12 form-label">Return Policy</label>
                                                            <textarea rows="6" class="form-control mb-4"
                                                                placeholder="return policy"
                                                                name='return_policy_2'>{{ old('return_policy_2')}}</textarea>
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
                                                                type="text" name='name_3' value='{{ old('name_3')}}'>
                                                        </div>
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <label class="col-md-12 form-label">Store Description</label>
                                                            <textarea rows="6" class="form-control mb-4"
                                                                placeholder="description" name='description_3'>{{ old('description_3')}}</textarea>
                                                        </div>
                                                        <input type='hidden' id='blog_description' name="content">
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <label class="col-md-12 form-label">Shipping Policy</label>
                                                            <textarea rows="6" class="form-control mb-4"
                                                                placeholder="shipping policy"
                                                                name='shipping_policy_3'>{{ old('shipping_policy_3')}}</textarea>
                                                        </div>
                                                        <input type='hidden' id='blog_description' name="content">
                                                    </div>
                                                    <div class="row row-sm">
                                                        <div class="col-md-12">
                                                            <label class="col-md-12 form-label">Return Policy</label>
                                                            <textarea rows="6" class="form-control mb-4"
                                                                placeholder="return policy"
                                                                name='return_policy_3'>{{ old('return_policy_3')}}</textarea>
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
                                            <h1 class="card-title  mt-5 mb-5">Payment information :</h1>
                                        </div>
                                        <div class="row row-sm mt-4">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Type of work</label>
                                                <div class="col-md-12">
                                                    <select class="form-control select2" name="type">
                                                        <option value="Individual"
                                                                @if( old('type')=="Individual") seleted @endif>
                                                            Individual(vendor)
                                                        </option>
                                                        <option value="Cooperative"
                                                                @if( old('type')=="Cooperative") seleted @endif>
                                                            Cooperative
                                                        </option>
                                                        <option value="Company"
                                                                @if( old('type')=="Company") seleted @endif>Company
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Select bank name</label>
                                                <div class="col-md-12">
                                                    <select class="form-control select2" name="bank_name">
                                                        <option value="CIH"
                                                                @if( old('bank_name')=="CIH") seleted @endif>CIH
                                                        </option>
                                                        <option value="Barid bank"
                                                                @if( old('bank_name')=="Barid bank") seleted @endif>
                                                            Barid bank
                                                        </option>
                                                        <option value="BMCE bank"
                                                                @if( old('bank_name')=="BMCE bank") seleted @endif>BMCE
                                                            bank
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Account Name</label>
                                                <input class="form-control mb-4" placeholder="Account Name" type="text"
                                                       name='bank_account_name' value='{{ old('bank_account_name')}}'>
                                            </div>

                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">RIB</label>
                                                <input class="form-control mb-4" placeholder="RIB" type="text"
                                                       name='bank_account_number'
                                                       value='{{ old('bank_account_number')}}'>
                                            </div>

                                        </div>
                                        <div class="row row-sm mt-4">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Method</label>
                                                <div class="col-md-12">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                               name="is_pre_order" value=1>
                                                        <span class="custom-control-label">Pre-order</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Supplier Email</label>
                                                <input class="form-control mb-4" placeholder="Supplier Email"
                                                       type="email"
                                                       name='supplier_email' value='{{ old('supplier_email')}}'>
                                            </div>
                                        </div>

                                        <div lass="row row-sm mt-4">
                                            <h2 class="card-title mt-5 mb-5">Identity Card Picture :</h2>
                                        </div>

                                        <div class="row row-sm mt-4">
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Front</label>
                                                <input type="file" class="dropify" name='identity_picture1'
                                                       data-height="310" value='{{ old('identity_picture1')}}'/>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Back</label>
                                                <input type="file" class="dropify" name='identity_picture2'
                                                       data-height="310" value='{{ old('identity_picture2')}}'/>
                                            </div>
                                        </div>

                                        <div lass="row row-sm mt-4">
                                            <h2 class="card-title mt-5 mb-5">Additional Document :</h2>
                                        </div>
                                        <div class="row row-sm mt-4">
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Trade Register</label>
                                                <input type="file" class="dropify_file" name='company_trade_register'
                                                       data-height="310" value='{{ old('company_trade_register')}}'/>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Company Status</label>
                                                <input type="file" class="dropify_file" name='company_status'
                                                       data-height="310" value='{{ old('company_status')}}'/>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Company Tax</label>
                                                <input type="file" class="dropify_file" name='company_tax'
                                                       data-height="310" value='{{ old('company_tax')}}'/>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <label class="col-md-12 form-label">Company Registration</label>
                                                <input type="file" class="dropify_file" name='company_registration'
                                                       data-height="310" value='{{ old('company_registration')}}'/>
                                            </div>
                                        </div>

                                    </div>
                                    <!-- END-Payment TAB -->

                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 mb-0">Save</button>
                    </form>
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

    <!--INTERNAL Form Advanced Element -->
    <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script>
        $('select[name=country_id]').on('change', function () {
            $.ajax({
                url: "{{ route('get-zones') }}",
                type: "GET",
                data: {
                    'country_id': this.value
                },
                success: function (json) {
                    alert("success2");
                    let html = '<option value="">---Select---</option>';
                    if (json['zone'] && json['zone'] != '') {
                        for (let i = 0; i < json['zone'].length; i++) {
                            html += '<option value="' + json['zone'][i]['zone_id'] + '"';

                            html += '>' + json['zone'][i]['name'] + '</option>';
                        }
                    } else {
                        html += '<option value="0" selected="selected">---None---</option>';
                    }

                    $('select[name=\'zone_id\']').html(html);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert("error");
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                },

            });
        });

    </script>



@endsection
