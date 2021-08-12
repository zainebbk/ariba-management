@extends('admin.layouts.master-vendor')
@section('css')
    <!-- INTERNAL File Uploads css -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!-- INTERNAL File Uploads css-->
    <link href="{{ URL::asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Edit Depository</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Update Depository</a></li>
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
                    <h3 class="card-title">Edit Depository </h3>
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

                    <form action="{{ route('vendor-depository-update') }}" method='post'>
                        @csrf
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Depository Informations
                                </h3>
                            </div>

                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Depository Name</label>
                                        <input class="form-control mb-4" placeholder="Depository Name" type="text"
                                               name='name' value='{{ old('name') ?? $depository->name }}'>

                                        <label class="col-md-12 form-label">Depository Address</label>
                                        <input class="form-control mb-4" placeholder="Depository Address" type="text"
                                               name='address' value='{{ old('name') ?? $depository->address }}'>

                                        <label class="col-md-12 form-label">Depository Volume</label>
                                        <input class="form-control mb-4" placeholder="Depository Volume" type="number"
                                               name='volume' value='{{ old('name') ?? $depository->volume }}'>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div>
                            <input type="submit" value="Save" class="btn btn-primary mt-4 mb-0">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- INTERNAL File uploads js -->
    <script src="{{ URL::asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filupload.js') }}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/file-upload.js') }}"></script>
@endsection
