@extends('admin.layouts.master')
@section('css')
    <!-- INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL Date Picker css -->
    <link href="{{ URL::asset('assets/plugins/date-picker/date-picker.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ URL::asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!-- INTERNAL Mutipleselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/multipleselect/multiple-select.css') }}">

    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">

    <!-- INTERNAL Jquerytransfer css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/jQuerytransfer/icon_font/icon_font.css') }}">

    <!-- INTERNAL multi css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/multi/multi.min.css') }}">
    <!-- Include Quill stylesheet -->
    {{-- <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet"> --}}
    <!-- INTERNAl Quill css -->
    <link href="{{ URL::asset('assets/plugins/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/quill/quill.bubble.css') }}" rel="stylesheet">

    <!-- INTERNAl WYSIWYG Editor css -->
    <link href="{{ URL::asset('assets/plugins/wysiwyag/richtext.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ URL::asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!-- INTERNAL  Tabs css-->
    <link href="{{ URL::asset('assets/plugins/tabs/style.css') }}" rel="stylesheet" />

    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Set product</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin/product"><i class="fe fe-file-text mr-2 fs-14"></i>products</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/admin/product">Set product</a></li>
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
                    <h3 class="card-title">Set product </h3>
                </div>
                <div class="card-body pb-2">

                    <form action="{{ route('add-product') }}" id="add-product" method='POST' role="form" enctype="multipart/form-data"
                        >
                        @csrf
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
                        <div class="panel panel-primary">
                            <div class="tab_wrapper first_tab">
                                <ul class="tab_list">
                                    <li class="">General Information</li>
                                    <li>Data</li>
                                    <li>Specification</li>
                                    <li>Images</li>
                                </ul>
                                <div class="content_wrapper">
                                    <!-- start-GENERAL TAB -->

                                    <div class="tab_content active">

                                        <div class='row'>

                                        <!-- FRENCH -->
                                            <div class="col-lg-4">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-heading">
                                                        <h3 class="expanel-title" style="text-align: center">Product information
                                                            in French &nbsp<i class="flag flag-fr"></i></h3>
                                                    </div>
                                                    <div class="expanel-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg">
                                                                <label class="col-md-6 form-label">Product name*</label>
                                                                <input class="form-control mb-4" placeholder="product name"
                                                                    type="text" name='name_2'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-6 form-label">Description</label>
                                                                <div class="ql-wrapper ql-wrapper-demo">
                                                                    <div id="quillEditor2"></div>
                                                                    <input type='hidden' id='description_2'
                                                                        name="description_2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ARABIC -->
                                            <div class="col-lg-4">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-heading">
                                                        <h3 class="expanel-title" style="text-align: center">Product information
                                                            in Arabic &nbsp <i class="flag flag-ma"></i></h3>
                                                    </div>
                                                    <div class="expanel-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg">
                                                                <label class="col-md-6 form-label">Product name*</label>
                                                                <input class="form-control mb-4" placeholder="product name"
                                                                    type="text" name='name_3'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-6 form-label">Description</label>
                                                                <div class="ql-wrapper ql-wrapper-demo">
                                                                    <div id="quillEditor3"></div>
                                                                    <input type='hidden' id='description_3'
                                                                        name="description_3">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ENGLISH -->
                                            <div class="col-lg-4">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-heading">
                                                        <h3 class="expanel-title" style="text-align: center">Product information
                                                            in English &nbsp <i class="flag flag-us"></i></h3>
                                                    </div>
                                                    <div class="expanel-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg">
                                                                <label class="col-md-6 form-label">Product name</label>
                                                                <input class="form-control mb-4" placeholder="product name"
                                                                    type="text" name='name_1'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-6 form-label">Description</label>
                                                                <div class="ql-wrapper ql-wrapper-demo">
                                                                    <div id="quillEditor"></div>
                                                                    <input type='hidden' id='description_1'
                                                                        name="description_1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- END-GENERAL TAB -->

                                    <!-- DATA TAB -->
                                    <div class="tab_content">
                                        <div class="row row-sm">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Quantity*</label>
                                                <input class="form-control mb-4" placeholder="quantity" type="number" value=1
                                                    name='quantity' readonly>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Price*</label>
                                                <input class="form-control mb-4" placeholder="price" type="number"
                                                    name='price'>
                                            </div>
                                            <!--<div class="col-lg">
                                                <label class="col-md-12 form-label">SKU</label>
                                                <input class="form-control mb-4" placeholder="sku" type="text" name='sku'>
                                            </div>

                                             <div class="col-lg">
                                                <label class="col-md-12 form-label">UPC</label>
                                                <input class="form-control mb-4" placeholder="upc" type="text" name='upc'>
                                            </div>-->
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">GTIN / EAN</label>
                                                <input class="form-control mb-4" placeholder="gtn" type="text" name='gtn'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Status</label>
                                                <div class="col-md-12">
                                                    <select class="form-control select2" name="status">
                                                        <option value="1">Enabled</option>
                                                        <option value="0" selected>Disabled</option>
                                                    </select>
                                                </div>
                                            </div>
                                             <!--<div class="col-lg">
                                                <label class="col-md-12 form-label">JAN</label>
                                                <input class="form-control mb-4" placeholder="jan" type="text" name='jan'>
                                            </div>-->
                                        </div>
                                        <div class="row row-sm">
                                             <!--<div class="col-lg">
                                                <label class="col-md-12 form-label">Date Available</label>
                                                <input class="form-control mb-" placeholder="date available" type="date"
                                                    name='date_available'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Sort order</label>
                                                <input class="form-control mb-" placeholder="sort order" value="0"
                                                    type="number" name='sort_order'>
                                            </div>-->

                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Article Number</label>
                                                <input class="form-control mb-4" placeholder="model" type="text"
                                                    name='article number'>
                                            </div>

                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Manufacturer/Distributor*</label>
                                                <div class="col-md-12">
                                                    <select class="form-control select2" name="manufacturer_id">
                                                        @foreach ($data['manufacturers'] as $manufacturer)
                                                            <option value="{{ $manufacturer->manufacturer_id }}">
                                                                {{ $manufacturer->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="row row-sm">
                                            <div class="col-lg">
                                                <label class="col-md-6 form-label">Width</label>
                                                <input class="form-control mb-4" placeholder="width" type="number"
                                                    name='width'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-6 form-label">Height</label>
                                                <input class="form-control mb-4" placeholder="height" type="number"
                                                    name='height'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-6 form-label">Length</label>
                                                <input class="form-control mb-4" placeholder="length" type="number"
                                                    name='length'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-6 form-label">Vendor</label>
                                                <div class="col-md-12">
                                                    <select class="form-control select2" name="vendor_id">
                                                        @foreach ($data['vendors'] as $vendor)
                                                            <option value="{{ $vendor->vendor_id }}">
                                                                {{ $vendor->display_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>-->
                                        <div class="row row-sm">
                                            <div class="col-lg-12 col-sm-12">
                                                <label class="col-md-12 form-label">Product image</label>
                                                <input type="file" class="dropify" name='image' data-height="310" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END-DATA TAB -->

                                    <!-- START-Specification TAB -->
                                    <div class="tab_content">
                                        <div class="row row-sm">
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label class="col-md-6 form-label">Categories*</label>
                                                        <select multiple="multiple" 
                                                            class="search-box" name="categories[]">
                                                            @foreach ($data['categories'] as $category)
                                                                <option value="{{ $category->category_id }}">
                                                                    {{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label class="col-md-6 form-label">Filters*</label>
                                                        <select multiple="multiple"
                                                            onchange="console.log($(this).children(':selected').length)"
                                                            class="search-box" name="filters[]">
                                                            @foreach ($data['filters'] as $filter)
                                                                <option value="{{ $filter->filter_id }}">
                                                                    {{ $filter->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-6 form-label">Set Number*</label>
                                                <input class="form-control mb-4" placeholder="set" type="number" value="0"
                                                    name='set_number' id="setNumber">
                                            </div>
                                        </div>
                                        <div class="col-lg">
                                            <label class="col-md-4 form-label">Option</label>
                                            <select class="form-control select2" name="option">
                                                <option value=13>Shoes Size</option>
                                                <option value=11>Size</option>
                                            </select>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="card-header">
                                                <h3 class="card-title">Specification</h3>
                                            </div>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="card">
                                                    <div class="table-responsive">
                                                        <table class="table card-table table-vcenter text-nowrap" id="shoes"
                                                            style="">
                                                            <thead>
                                                                <tr>
                                                                    <th>Value</th>
                                                                    <th>Quantity</th>
                                                                    <th>Set</th>
                                                                    <th>+ Price</th>
                                                                    <th>EAN</th>
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
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_35" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control " type="number"
                                                                            name="price_35" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_35" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][0] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="36" name="50" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_36" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control  set" type="number"
                                                                            name="set_36" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_36" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_36" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][1] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="37" name="51" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_37" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_37" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_37" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_37" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][2] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="38" name="52" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_38" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_38" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_38" min="0" placeholder="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_38" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][3] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="39" name="53" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_39" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_39" value="0" value="0"
                                                                            placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_39" min="0" placeholder="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_39" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][4] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="40" name="54" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_40" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_40" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_40" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_40" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][5] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="41" name="55" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_41" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_41" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_41" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_41" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][6] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="42" name="56" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_42" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_42" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_42" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_42" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][7] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="43" name="57" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_43" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_43" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_43" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_43" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][8] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="44" name="61" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_44" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_44" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_44" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_44" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][9] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control"
                                                                            type="number" value="45" name="62" disabled>
                                                                    </th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_45" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_45" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_45" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_45" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][10] }}"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table class="table card-table table-vcenter text-nowrap"
                                                            id="sizes">
                                                            <thead>
                                                                <tr>
                                                                    <th>Value</th>
                                                                    <th>Quantity</th>
                                                                    <th>Set</th>
                                                                    <th>+ Price</th>
                                                                    <th>EAN</th>
                                                                </tr>
                                                            </thead>
                                                            <!-- SHOES SIZE -->
                                                            <tbody>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control" type="text"
                                                                            value="XS" name="58" disabled></th>
                                                                    <td><input class="form-control " type="number"
                                                                            name="quantity_xs" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_xs" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control " type="number"
                                                                            name="price_xs" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_xs" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][0] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control" type="text"
                                                                            value="S" name="46" disabled></th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_s" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control  set" type="number"
                                                                            name="set_s" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_s" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text" name="ean_s"
                                                                            placeholder="ean" readonly
                                                                            value="{{ $data['ean'][1] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control" type="text"
                                                                            value="M" name="47" disabled></th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_m" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_m" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_m" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text" name="ean_m"
                                                                            placeholder="ean" readonly
                                                                            value="{{ $data['ean'][2] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control" type="text"
                                                                            value="L" name="48" disabled></th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_l" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_l" value="0" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_l" min="0" placeholder="0"></td>
                                                                    <td><input class="form-control" type="text" name="ean_l"
                                                                            placeholder="ean" readonly
                                                                            value="{{ $data['ean'][3] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control" type="text"
                                                                            value="XL" name="59" disabled></th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_xl" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_xl" value="0" value="0"
                                                                            placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_xl" min="0" placeholder="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_xl" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][4] }}"></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row"><input class="form-control" type="text"
                                                                            value="XXL" name="60" disabled></th>
                                                                    <td><input class="form-control" type="number"
                                                                            name="quantity_xxl" placeholder="0" min="0">
                                                                    </td>
                                                                    <td><input class="form-control set" type="number"
                                                                            name="set_xxl" value="0" placeholder="0"
                                                                            min="0"></td>
                                                                    <td><input class="form-control" type="number"
                                                                            name="price_xxl" placeholder="0" min="0"></td>
                                                                    <td><input class="form-control" type="text"
                                                                            name="ean_xxl" placeholder="ean" readonly
                                                                            value="{{ $data['ean'][5] }}"></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END-Specification TAB -->
                                    <!-- START-IMAGES TAB -->
                                    <div class="tab_content">
                                        <label class="col-md-4 form-label">Upload images : </label>
                                        <div class="row row-sm mt-4">
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="file" class="dropify" name='image1' data-height="210" />
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="file" class="dropify" name='image2' data-height="210" />
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="file" class="dropify" name='image3' data-height="210" />
                                            </div>
                                        </div>
                                        <div class="row row-sm mt-4">
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="file" class="dropify" name='image4' data-height="210" />
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="file" class="dropify" name='image5' data-height="210" />
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <input type="file" class="dropify" name='image6' data-height="210" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END-IMAGE TAB -->

                                    <!-- START-master-DB TAB
                                                        <div class="tab_content">
                                                            <div class="row row-sm">
                                                                <div class="col-lg-12 col-sm-12">
                                                                    <div class="form-group row">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">Master categories : English</h3>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <select multiple="multiple" onchange="console.log($(this).children(':selected').length)" class="search-box" name="master_categories[]">

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row row-sm">
                                                                <div class="col-lg-12 col-sm-12">
                                                                    <div class="form-group row">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">Master categories : French</h3>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <select multiple="multiple" onchange="console.log($(this).children(':selected').length)" class="search-box" name="master_categories[]">

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row row-sm">
                                                                <div class="col-lg-12 col-sm-12">
                                                                    <div class="form-group row">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">Master categories : Arabic</h3>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <select multiple="multiple" onchange="console.log($(this).children(':selected').length)" class="search-box" name="master_categories[]">

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        END-master-DB TAB -->


                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 mb-0" id="save">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script type="text/javascript">
        $( "#add-product" ).submit(function() {
            $('#save').toggleClass('btn-primary btn-primary btn-loading');
            return true;
        });

        $('#sizes').css("display", "none");
        $(document).ready(function() {
            $(".set").bind('keyup mouseup', function() {
                var sum = 0;
                $('.set').each(function() {
                    if (this.value)
                        sum += parseFloat(this.value);
                });
                $("#setNumber").val(sum);
            });

        });

        $('#add-produc').submit(function() {
            var content = $("#quillEditor3").contents().html();
            $("#description_3").val(content);
            var content = $("#quillEditor2").contents().html();
            $("#description_2").val(content);
            var content = $("#quillEditor").contents().html();
            $("#description_1").val(content);

            return true;
        });

        $('select[name=option]').on('change', function() {
            if (this.value == 13) {
                $('#sizes').hide();
                $('#shoes').show();
            } else {
                $('#sizes').show();
                $('#shoes').hide();
            }
        });

    </script>

    <!-- INTERNAL File uploads js -->
    <script src="{{ URL::asset('assets/plugins/fileupload/js/dropify.js') }}"></script>
    <script src="{{ URL::asset('assets/js/filupload.js') }}"></script>


    <!-- INTERNAL WYSIWYG Editor js -->
    <script src="{{ URL::asset('assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-editor.js') }}"></script>

    <!-- INTERNAL quill js -->
    <script src="{{ URL::asset('assets/plugins/quill/quill.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-editor2.js') }}"></script>

    <!--- INTERNAL Tabs js-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

    <!-- INTERNAL Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/date-picker/date-picker.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/date-picker/jquery-ui.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>

    <!-- INTERNAL Multipleselect js -->
    <script src="{{ URL::asset('assets/plugins/multipleselect/multiple-select.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/multipleselect/multi-select.js') }}"></script>

    <!--INTERNAL Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
@endsection
