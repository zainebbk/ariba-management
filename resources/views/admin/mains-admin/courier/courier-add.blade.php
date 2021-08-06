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
            <h4 class="page-title mb-0">Add courier</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Add courier</a></li>
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
                    <h3 class="card-title">Create courier </h3>
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
                    <form action="{{route('add-courier')}}" method='POST' role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Personal Data</h3>
                            </div>
                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Name</label>
                                        <input class="form-control mb-4" placeholder="Name" type="text" name='name' value="{{old('name')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Address</label>
                                        <input class="form-control mb-4" placeholder="Address" type="text" name='address' value="{{old('address')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Price</label>
                                        <input class="form-control mb-4" placeholder="Price" type="text" name='price' value="{{old('price')}}">
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Type</label>
                                        <select class="form-control select2" name="type">
                                            <option value="Personal Driver">Personal Driver</option>
                                            <option value="Company">Company</option>
                                        </select>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Transportation</label>
                                        <input class="form-control mb-4" placeholder="Transportation" type="text" name='transportation' value="{{old('transportation')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="custom-control custom-checkbox" style="padding-top: 30px; padding-left: 40px">
                                            <input type="checkbox" class="custom-control-input" name="contactor">
                                            <span class="custom-control-label col-lg-12" style="padding-left: 0px">Contactor Card</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Phone</label>
                                        <input class="form-control mb-4" placeholder="Phone" type="text" name='phone' value="{{old('phone')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Whatsapp</label>
                                        <input class="form-control mb-4" placeholder="Whatsapp" type="text" name='whatsapp' value="{{old('whatsapp')}}">
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Cities</label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" multiple="multiple" onchange="console.log($(this).children(':selected').length)"
                                            class="search-box" name="cities[]">
                                                @foreach ($data['cities'] as $city)
                                                    <option value="{{$city->zone_id}}">{{$city->name}}</option>
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
