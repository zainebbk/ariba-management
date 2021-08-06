@extends('admin.layouts.master')
@section('css')

    <!-- INTERNAL File Uploads css -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ URL::asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">

@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Add to cpc</h4>
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
                    <h3 class="card-title">Add to cpc </h3>
                </div>
                <div class="card-body pb-2">
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
                    <form action="{{ route('whitelist-add') }}" method='POST' role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">IP ADDRESSS
                                </h3>
                            </div>

                            <div class="expanel-body">
                                <div class="row row-sm">

                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Type</label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="type">
                                                <option value="ip" selected>IP Address</option>
                                                <option value="country">Country</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg country" style="display:none">
                                        <label class="col-md-12 form-label">Country</label>
                                        <div class="col-md-12">
                                            <select
                                            onchange="console.log($(this).children(':selected').length)"
                                            class="search-box" name="country">
                                                
                                       
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg ip_address">
                                        <label class="col-md-12 form-label">IP Address or Country ISO code</label>
                                        <input class="form-control mb-4" placeholder="IP/ISO code" type="text"
                                            name='ip_address' value='{{ old('ip_address') }}'>
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

<script>
    $('select[name=type]').on('change', function() 
    {
        if(this.value=='country')
        {
            $('.country').css('display','block');
            $('.ip_address').css('display','none');
        }
        else 
          {  
              $('.country').css('display','none');
              $('.ip_address').css('display','block');
          }
    });
    </script>
  <!-- INTERNAL Select2 js -->
  <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
  <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

  <!-- INTERNAL Datepicker js -->
  <script src="{{ URL::asset('assets/plugins/date-picker/date-picker.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>

  <!-- INTERNAL File-Uploads Js-->
  <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

  <!-- INTERNAL File uploads js -->
  <script src="{{ URL::asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
  <script src="{{ URL::asset('assets/js/filupload.js') }}"></script>

  <!--INTERNAL Sumoselect js-->
  <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

  <!--INTERNAL Form Advanced Element -->
  <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
  <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
  <script src="{{ URL::asset('assets/js/file-upload.js') }}"></script>
@endsection
