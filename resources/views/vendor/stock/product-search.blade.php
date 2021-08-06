@extends('admin.layouts.master-vendor')
@section('css')
    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">
    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <style>
        .image{
            width: 100%;
            max-width: 500px;
            padding: 15px;
            margin: auto;
            display: block;
        }
    </style>
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Stock Management</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Stock &nbsp;>  search for product</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection


    @section('content')
    <div class="row">
        <div class="card-body pb-0">
            <div class="image">
                <img class="mb-4" src="https://ariba.ma/mgmt/assets/img/search.svg" alt="search">
            </div>
            <form action="{{route('vendor-stock-get-product-list')}}" method='GET' role="form" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-2">
                    <div class="col-md-11">
                        <input type='text' class='form-control' name='search' >
                    </div>
                    <button class="btn btn-primary ml-3 mt-1" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <!-- INTERNAL Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

    <!--INTERNAL Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

@endsection