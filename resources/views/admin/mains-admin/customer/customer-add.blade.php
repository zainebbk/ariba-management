@extends('admin.layouts.master')
@section('css')
    <!-- INTERNAL File Uploads css -->
    <link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
    <!--INTERNAL Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Add Customer</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Add Customer</a></li>
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
                    <h3 class="card-title">Create Customer </h3>
                </div>
                <div class="card-body pb-2">
                    @if($message = Session::get('success'))
                        <div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{$message}}.
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
                    <form action="{{route('add-customer')}}" method='POST' role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Customer Personal Information &nbsp</h3>
                            </div>
                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">First Name</label>
                                        <input class="form-control mb-4" placeholder="First Name" type="text" name='firstname' value="{{old('firstname')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Last Name</label>
                                        <input class="form-control mb-4" placeholder="Last Name" type="text" name='lastname' value="{{old('lastname')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">User Name</label>
                                        <input class="form-control mb-4" placeholder="User Name" type="text" name='display_name' value="{{old('display_name')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Email</label>
                                        <input class="form-control mb-4" placeholder="Email" type="text" name='email' value="{{old('email')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Password</label>
                                        <input class="form-control mb-4" placeholder="Password" type="password" name='password' value="{{old('password')}}">
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Phone</label>
                                    <input class="form-control mb-4" placeholder="Phone" type="text" name='telephone' value="{{old('telephone')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Address</label>
                                        <input class="form-control mb-4" placeholder="Address" type="text" name='address_1' value="{{old('address_1')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">City</label>
                                        <input class="form-control mb-4" placeholder="City" type="text" name='city' value="{{old('city')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Post Code</label>
                                        <input class="form-control mb-4" placeholder="Post Code" type="text" name='postcode' value="{{old('postcode')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Sales Agent</label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="salesagent_id">
                                            <option value="0" selected>-- NONE --</option>
                                                @foreach($data['salesagents'] as $salesagent)
                                                    <option value="{{$salesagent->salesagent_id}}">{{$salesagent->firstname}} {{$salesagent->lastname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="submit" value="Save" name="action" class="btn btn-primary mt-4 mb-0">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- INTERNAL Select2 js -->
    <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>

    <!-- INTERNAL Timepicker js -->
    <script src="{{URL::asset('assets/plugins/time-picker/jquery.timepicker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/time-picker/toggles.min.js')}}"></script>

    <!-- INTERNAL Datepicker js -->
    <script src="{{URL::asset('assets/plugins/date-picker/date-picker.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/date-picker/jquery-ui.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/input-mask/jquery.maskedinput.js')}}"></script>

    <!-- INTERNAL File-Uploads Js-->
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

    <!-- INTERNAL File uploads js -->
    <script src="{{URL::asset('assets/plugins/fileupload/js/dropify.js')}}"></script>
    <script src="{{URL::asset('assets/js/filupload.js')}}"></script>

    <!-- INTERNAL Multipleselect js -->
    <script src="{{URL::asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/multipleselect/multi-select.js')}}"></script>

    <!--INTERNAL Sumoselect js-->
    <script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <!--INTERNAL telephoneinput js-->
    <script src="{{URL::asset('assets/plugins/telephoneinput/telephoneinput.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/telephoneinput/inttelephoneinput.js')}}"></script>

    <!--INTERNAL jquery transfer js-->
    <script src="{{URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.js')}}"></script>

    <!--INTERNAL multi js-->
    <script src="{{URL::asset('assets/plugins/multi/multi.min.js')}}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{URL::asset('assets/js/formelementadvnced.js')}}"></script>
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
    <script src="{{URL::asset('assets/js/file-upload.js')}}"></script>
@endsection
