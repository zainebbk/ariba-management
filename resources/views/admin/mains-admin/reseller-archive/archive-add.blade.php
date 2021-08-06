@extends('admin.layouts.master')
@section('css')
    <!-- INTERNAL File Uploads css -->
    <link href="{{URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css')}}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{URL::asset('assets/plugins/fileupload/css/fileupload.css')}}" rel="stylesheet" type="text/css" />
    <!--INTERNAL Select2 css -->
    <link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

    <!-- INTERNAL Mutipleselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/multipleselect/multiple-select.css') }}">

    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Add Product Movement</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Add Product Movement</a></li>
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
                    <h3 class="card-title">Create Product Movement </h3>
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
                    <form action="{{route('reseller-archive-add')}}" method='POST' role="form" enctype="multipart/form-data">
                        @csrf
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Product Movement &nbsp</h3>
                            </div>
                            <div class="expanel-body">
                                <div class="row row-sm">
                            
                                    <div class="col-lg-5">
                                        <label class="col-md-6 form-label">Product</label>
                                        <div class="col-md-12">
                                            <select class="search-box"  name="product_id">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->product_id }}">
                                                        {{ $product->names[0]->name ?? ''}} | {{ $product->ean ?? ''}} | {{ $product->model ?? ''}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Depot From</label>
                                        <div class="col-md-12">
                                            <select class="search-box" name="depot_from_id" readonly>
                                                @foreach ($depots as $depot)
                                                    <option value="{{ $depot->depot_id }}">
                                                        {{ $depot->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Depot To</label>
                                        <div class="col-md-12">
                                            <select class="search-box" name="depot_to_id">
                                                @foreach ($depots as $depot)
                                                    <option value="{{ $depot->depot_id }}">
                                                        {{ $depot->name }}</option>
                                                @endforeach 
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <label class="col-md-6 form-label">Type</label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="is_carton"> 
                                                <option value=0 selected>Unity</option>
                                                <option value=1>Carton</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg" id="quantity" style="display:none">
                                    <label class="col-md-12 form-label">Quantity</label>
                                    <input class="form-control mb-4" placeholder="Quantity" type="number" name='quantity' value="{{old('quantity')}}">
                                </div> 
                                <div class="row row-sm mt-5"  id="shoes">
                                    <div class="col-lg-12 col-sm-12">
                                        <label class="col-md-12 form-label">Sizes / Quantity</label>
                                        <div class="card">
                                            <div class="table-responsive">
                                                <table class="table card-table table-vcenter text-nowrap"
                                                    style="">
                                                    <thead>
                                                        <tr>
                                                            <th>Value</th>
                                                            <th>Quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <!-- SHOES SIZE -->
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="35" name="49" disabled>
                                                            </th>
                                                            <td><input class="form-control " type="number"
                                                                    name="quantity_35" placeholder="0" min="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="36" name="50" disabled>
                                                            </th>
                                                            <td><input class="form-control" type="number"
                                                                    name="quantity_36" placeholder="0" min="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="37" name="51" disabled>
                                                            </th>
                                                            <td><input class="form-control" type="number"
                                                                    name="quantity_37" placeholder="0" min="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="38" name="52" disabled>
                                                            </th>
                                                            <td><input class="form-control" type="number"
                                                                    name="quantity_38" placeholder="0" min="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="39" name="53" disabled>
                                                            </th>
                                                            <td><input class="form-control" type="number"
                                                                    name="quantity_39" placeholder="0" min="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="40" name="54" disabled>
                                                            </th>
                                                            <td><input class="form-control" type="number"
                                                                    name="quantity_40" placeholder="0" min="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="41" name="55" disabled>
                                                            </th>
                                                            <td><input class="form-control" type="number"
                                                                    name="quantity_41" placeholder="0" min="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="42" name="56" disabled>
                                                            </th>
                                                            <td><input class="form-control" type="number"
                                                                    name="quantity_42" placeholder="0" min="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="43" name="57" disabled>
                                                            </th>
                                                            <td><input class="form-control" type="number"
                                                                    name="quantity_43" placeholder="0" min="0"></td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row"><input class="form-control"
                                                                    type="number" value="44" name="61" disabled>
                                                            </th>
                                                            <td><input class="form-control" type="number"
                                                                    name="quantity_44" placeholder="0" min="0"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a type="button" href="{{route('reseller-archive')}}" class="btn btn-icon btn-primary">Back</a>
                            <input  type="submit" value="Save" name="action" class="btn btn-primary" style=" position: absolute;right: 60px;">
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

    <!-- INTERNAL Multipleselect js -->
    <script src="{{URL::asset('assets/plugins/multipleselect/multiple-select.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/multipleselect/multi-select.js')}}"></script>
    

    <!--INTERNAL Sumoselect js-->
    <script src="{{URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>

    <!--INTERNAL multi js-->
    <script src="{{URL::asset('assets/plugins/multi/multi.min.js')}}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{URL::asset('assets/js/formelementadvnced.js')}}"></script>
    <script src="{{URL::asset('assets/js/form-elements.js')}}"></script>
    <script src="{{URL::asset('assets/js/file-upload.js')}}"></script>
    <script>
        $('select[name=is_carton]').on('change', function() {
            if (this.value == 0) {
                $('#quantity').hide();
                $('#shoes').show();
            } else {
                $('#quantity').show();
                $('#shoes').hide();
            }
        });
    </script>
@endsection
