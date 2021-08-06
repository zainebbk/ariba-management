@extends('admin.layouts.master')
@section('css')
    <!-- INTERNAL File Uploads css -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ URL::asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

    <!-- INTERNAL Mutipleselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/multipleselect/multiple-select.css') }}">

    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">

    <!-- INTERNAL multi css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/multi/multi.min.css') }}">
    

@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Edit Category</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Update Category</a></li>
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
                    <h3 class="card-title">Update Category </h3>
                </div>
                <form action="{{ route('category-update',[$category->category_id]) }}" method='POST' role="form" enctype="multipart/form-data">
                    @csrf
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
                   
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Category Information &nbsp
                                </h3>
                            </div>

                            <div class="expanel-body">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Category Name  &nbsp<i class="flag flag-fr"></i></label>
                                        <input class="form-control mb-4" placeholder="Category Name" type="text" name='name_fr'
                                            value='{{ old('name_fr') ?? $category->names[0]->name }}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Category Name &nbsp<i class="flag flag-ma"></i></label>
                                        <input class="form-control mb-4" placeholder="Category Name" type="text" name='name_ar'
                                            value='{{ old('name_ar') ?? $category->names[1]->name}}'>
                                    </div>
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Category Name &nbsp<i class="flag flag-us"></i></label>
                                        <input class="form-control mb-4" placeholder="Category Name" type="text" name='name_eng'
                                            value='{{ old('name_eng')  ?? $category->names[2]->name}}'>
                                    </div>                                    
                                </div>

                                
                            <div class="row row-sm">

                                <div class="col-lg-5">
                                    <label class="col-md-12 form-label">Parent Category</label>
                                    <div class="col-md-12">
                                        <select 
                                            
                                            class="form-control select2" name="category">
                                            <option value=0  @if($category->parent_id==0) selected @endif> ---None---</option>
                                            @foreach ($categories as $allcategory)
                                                <option value="{{ $allcategory->category_id }}" @if($allcategory->category_id== $category->parent_id) selected @endif>{{ $allcategory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label class="col-md-12 form-label">Status</label>
                                    <div class="col-md-12">
                                        <select 
                                            class="form-control select2" name="status">
                                                <option value="1" @if($category->status==1) selected @endif> Enabled</option>
                                                <option value="0"  @if($category->status==0) selected @endif> Disabled</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-sm-12">
                                    <label class="col-md-12 form-label">Category image</label>
                                    <input type="file" class="dropify" name='image' data-default-file="https://ariba.ma/image/{{ $category->image }}"  data-height="150" />
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

    <!-- INTERNAL Multipleselect js -->
    <script src="{{ URL::asset('assets/plugins/multipleselect/multiple-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/multipleselect/multi-select.js') }}"></script>

    <!--INTERNAL Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/file-upload.js') }}"></script>
@endsection
