@extends('admin.layouts.master')
@section('css')
    <!-- INTERNAL File Uploads css -->
    <link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
    <style>
        #send-email:disabled {
            cursor: not-allowed;
            pointer-events: all !important;
        }
    </style>

@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Update sales Agent</h4>
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
                    <h3 class="card-title">Edit sales agent </h3>
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
                    @if (Auth::user()->hasAnyPermission(['salesagent-send-email', 'salesagent-edit']))
                    <form action="{{route('update-sales-agent',[$data['sales_agent']->salesagent_id])}}" method='POST' role="form" enctype="multipart/form-data">
                        @csrf
                        <input id="id_salesagent" type="hidden" value="{{$data['sales_agent']->salesagent_id}}">
                    @endif
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Sales Agent Personal Information &nbsp</h3>
                            </div>
                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">First Name</label>
                                        <input class="form-control mb-4" placeholder="First Name" type="text" name='firstname' value='{{$data["sales_agent"]->firstname}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Last Name</label>
                                        <input class="form-control mb-4" placeholder="Last Name" type="text" name='lastname' value='{{$data["sales_agent"]->lastname}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">User Name</label>
                                        <input class="form-control mb-4" placeholder="User Name" type="text" name='display_name' value='{{$data["sales_agent"]->display_name}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Birthday</label>
                                        <input class="form-control mb-4" placeholder="Birthday" type="date" name='birthday' value="{{ date('Y-m-d', strtotime($data['sales_agent']->birthday)) }}">
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Email &nbsp @if($data["sales_agent"]->verify_email==0)<i class="fa fa-exclamation-triangle text-warning" data-placement="top" data-toggle="tooltip" title="not verified"></i>@endif</label>
                                        <input class="form-control mb-4" placeholder="Email" type="text" name='email' value='{{$data["sales_agent"]->email}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Phone &nbsp @if($data["sales_agent"]->verify_telephone==0)<i class="fa fa-exclamation-triangle text-warning" data-placement="top" data-toggle="tooltip" title="not verified"></i>@endif</label>
                                        <input class="form-control mb-4" placeholder="Phone" type="text" name='telephone' value='{{$data["sales_agent"]->telephone}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Address</label>
                                        <input class="form-control mb-4" placeholder="Address" type="text" name='address' value='{{$data["sales_agent"]->address}}'>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="address" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Post Code</label>
                                        <input class="form-control mb-4" placeholder="Post Code" type="text" name='postcode' value='{{$data["sales_agent"]->postcode}}'>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="postcode" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">City</label>
                                        <input class="form-control mb-4" placeholder="City" type="text" name='city' value='{{$data["sales_agent"]->city}}'>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="city" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Country</label>
                                        <input class="form-control mb-4" placeholder="Country" type="text" name='country' value='{{$data["sales_agent"]->country}}'>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="country" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Sales Agent Payment Information &nbsp</h3>
                            </div>
                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Bank Name</label>
                                        <input class="form-control mb-4" placeholder="Bank Name" type="text" name='bank_name' value='{{$data["sales_agent"]->bank_name}}'>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="bank_name" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">RIB</label>
                                        <input class="form-control mb-4" placeholder="RIB" type="text" name='rib' value='{{$data["sales_agent"]->rib}}'>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="rib" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Bank Owner Phone</label>
                                        <input class="form-control mb-4" placeholder="Bank Owner Phone" type="text" name='bank_owner_telephone' value='{{$data["sales_agent"]->bank_owner_telephone}}'>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="bank_owner_telephone" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Bank Owner Name</label>
                                        <input class="form-control mb-4" placeholder="Bank Owner Name" type="text" name='bank_owner_name' value='{{$data["sales_agent"]->bank_owner_name}}'>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="bank_owner_name" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                             </div>
                        </div>
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Sales Agent Identity Card &nbsp</h3>
                            </div>
                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                            <img  src="https://ariba.ma/image/{{$data['sales_agent']->identity_picture1}}" alt="image"  class="card-image1 ">
                                            <div class="card-body">
                                                <h5 class="card-title">Front</h5>
                                            </div>
                                        </div>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="identity_picture1" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                    <div class="col-md-6 col-lg-6">
                                        <div class="card overflow-hidden">
                                            <img src="https://ariba.ma/image/{{$data['sales_agent']->identity_picture2}}" alt="image"  class="card-image1 ">
                                            <div class="card-body">
                                                <h5 class="card-title">Back</h5>
                                            </div>
                                        </div>
                                        <label class="custom-switch">
                                            <input type="checkbox" name="send-email[]" value="identity_picture2" class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Sales Agent Image</h3>
                            </div>
                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-md-12 col-lg-4"></div>
                                    <div class="col-md-12 col-lg-4">
                                        <div class="card overflow-hidden">
                                            <img src="https://ariba.ma/image/{{$data['sales_agent']->image}}" alt="image"  class="card-image1 ">
                                        </div>
                                    </div>
                                </div>
                                <label class="custom-switch">
                                    <input type="checkbox" name="send-email[]" value="image" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row row-sm">
                            <div class="col-md-6 col-lg-9">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="status" @if($data['sales_agent']->status==1) checked @endif>
                                    <span class="custom-control-label col-lg-12">Approved</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            @can('salesagent-edit')
                                <input type="submit" value="Save" name="action" class="btn btn-primary mt-4 mb-0">
                                <input type="submit" value='Send for modification' name="action" id="send-email" class="btn btn-success ml-5 mt-4 mb-0" disabled >
                             @endcan
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
