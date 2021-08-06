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
            <h4 class="page-title mb-0">Update Product Movement</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Update Product Movement</a></li>
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
                    <h3 class="card-title">Update Product Movement</h3>
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
                    @can('archive-edit')
                    <form action="{{route('reseller-archive-update',[$archive->depot_product_movement_id ])}}" method='POST' role="form" enctype="multipart/form-data">
                        @csrf
                    @endcan
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Product Movement Information &nbsp</h3>
                            </div>
                            <div class="expanel-body">
                                <div class="row row-sm">

                                    <div class="col-lg-6">
                                        <label class="col-md-4 form-label">Product</label>
                                        <div class="col-md-12">
                                            <select class="search-box" name="product_id">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->product_id }}" @if($archive->product_id==$product->product_id) selected @endif>
                                                        {{ $product->names[0]->name ?? ''}} | {{ $product->ean ?? ''}} | {{ $product->model ?? ''}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <label class="col-md-6 form-label">Depot From</label>
                                        <div class="col-md-12">
                                            <select class="search-box" name="depot_from_id">
                                                @foreach ($depots as $depot)
                                                    <option value="{{ $depot->depot_id }}" @if($archive->depot_from_id==$depot->depot_id) selected @endif>
                                                        {{ $depot->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <label class="col-md-6 form-label">Depot To</label>
                                        <div class="col-md-12">
                                            <select class="search-box" name="depot_to_id">
                                                @foreach ($depots as $depot)
                                                    <option value="{{ $depot->depot_id }}" @if($archive->depot_to_id==$depot->depot_id) selected @endif>
                                                        {{ $depot->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg">
                                        <label class="col-md-6 form-label">Type</label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="is_carton">
                                                @if($archive->is_carton==1)<option value=1  selected>Carton</option> @endif
                                                @if($archive->is_carton==0)<option value=0  selected>Unity</option>@endif
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                @if($archive->is_carton==1)
                                    <div class="col-lg" id="quantity">
                                        <label class="col-md-12 form-label">Quantity</label>
                                        <input class="form-control mb-4" placeholder="Quantity" value="{{old('quantity') ?? $archive->quantity}}" type="number" name='quantity'>
                                    </div>
                                @else
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
                                                         @foreach ($options as $option)
                                                            @if($option->option_value==35)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="35" name="49" disabled>
                                                                    </th>
                                                                    <td><input class="form-control " type="number"
                                                                            name="quantity_35" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                            @if($option->option_value==36)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="36" name="50" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_36" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                            @if($option->option_value==37)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="37" name="51" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_37" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                            @if($option->option_value==38)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="38" name="52" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_38" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                            @if($option->option_value==39)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="39" name="53" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_39" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                            @if($option->option_value==40)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="40" name="54" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_40" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                            @if($option->option_value==41)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="41" name="55" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_41" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                            @if($option->option_value==42)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="42" name="56" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_42" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                            @if($option->option_value==43)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="43" name="57" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_43" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                            @if($option->option_value==44)
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="44" name="61" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_44" placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif



                            </div>
                        </div>
                        @can('archive-edit')
                        <div>
                            <a type='button' href=" {{ route('reseller-archive') }}" class="btn btn-primary mt-4 mb-0">Back</a>
                            <input type="submit" value="Save" name="action" class="btn btn-primary mt-4 mb-0">
                        </div>
                    </form>
                        @endcan
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
