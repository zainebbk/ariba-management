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
            <h4 class="page-title mb-0">Update Customer</h4>
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
                    <h3 class="card-title">Edit Customer </h3>
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
                    <form action="{{route('update-blocked-customer',[$data['customer']->customer_id])}}" method='POST' role="form" enctype="multipart/form-data">
                        @csrf
                        <input id="customer_id" type="hidden" value="{{$data['customer']->customer_id}}">
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Customer Personal Information &nbsp</h3>
                            </div>
                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">First Name</label>
                                        <input class="form-control mb-4" placeholder="First Name" type="text" name='firstname' value='{{ old("firstname") ?? $data["customer"]->firstname}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Last Name</label>
                                        <input class="form-control mb-4" placeholder="Last Name" type="text" name='lastname' value='{{old("lastname") ?? $data["customer"]->lastname}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">User Name</label>
                                        <input class="form-control mb-4" placeholder="User Name" type="text" name='display_name' value='{{old("display_name") ?? $data["customer"]->display_name}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Email &nbsp @if($data["customer"]->verify_email==0)<i class="fa fa-exclamation-triangle text-warning" data-placement="top" data-toggle="tooltip" title="not verified"></i>@endif</label>
                                        <input class="form-control mb-4" placeholder="Email" type="text" name='email' value='{{old("email") ?? $data["customer"]->email}}'>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Phone &nbsp @if($data["customer"]->verify_telephone==0)<i class="fa fa-exclamation-triangle text-warning" data-placement="top" data-toggle="tooltip" title="not verified"></i>@endif</label>
                                        <input class="form-control mb-4" placeholder="Phone" type="text" name='telephone' value='{{old("telephone") ?? $data["customer"]->telephone}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Address</label>
                                        <input class="form-control mb-4" placeholder="Address" type="text" name='address_1' value='{{old("address_1") ?? $data["customer"]->address_1}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Post Code</label>
                                        <input class="form-control mb-4" placeholder="Post Code" type="text" name='postcode' value='{{old("postcode") ?? $data["customer"]->postcode}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">City</label>
                                        <input class="form-control mb-4" placeholder="City" type="text" name='city' value='{{old("city") ?? $data["customer"]->city}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Sales Agent</label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="salesagent_id">
                                            <option value="none">---None---</option>
                                                @foreach($data['salesagents'] as $salesagent)
                                                    <option value="{{$salesagent->salesagent_id}}" @if($data["salesagent_id"]) {{$data["salesagent_id"]->salesagent_id==$salesagent->salesagent_id ? 'selected' : ''}}@endif>{{$salesagent->firstname}} {{$salesagent->lastname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Location (Google Map)</label>
                                        <div class="ml-4"><a style="color: #705ec8;" href={{$data['maplink']}} target="blank">click here</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-md-6 col-lg-3">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="blocked" {{ old('blocked', $data['customer']->blocked)==1 ? 'checked' : '' }} >
                                    <span class="custom-control-label col-lg-12">Blocked</span>
                                </label>
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
    <script>
        $(".custom-switch-input").change(function(){
            if ($('.custom-switch-input:checked').length >=1) {
                $('#send-email').prop("disabled",false);
            } else {
                $('#send-email').prop("disabled",true);
            }
        });
        $(document).on('click', '..send-email', function(e) {
            e.preventDefault();
            var id=$("#id_salesagent").val();
            var myCheckboxes = new Array();
            $(".custom-switch-input:checked").each(function() {
                myCheckboxes.push($(this).val());
            });
            $.ajax({
                url:"{{ route('send-email') }}",
                type:"POST",
                data:{ "_token": "{{ csrf_token() }}",'checkboxes':myCheckboxes,'id':id},
                success:function (data) {
                    console.log(data['data'][0]["firstname"]);
                    console.log(data['data']);
                },
                error: function (ajaxContext) {
                    console.log(ajaxContext.responseText);
                }
            });
        });

    </script>
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
