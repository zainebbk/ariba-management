@extends('admin.layouts.master')
@section('css')
    <!-- INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css -->

    <!-- INTERNAL Date Picker css -->
    <link href="{{ URL::asset('assets/plugins/date-picker/date-picker.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ URL::asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!-- INTERNAL Mutipleselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/multipleselect/multiple-select.css') }}">

    <!-- INTERNAL Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">

    <!-- INTERNAl Quill css -->
    <link href="{{ URL::asset('assets/plugins/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/quill/quill.bubble.css') }}" rel="stylesheet">

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
                <li class="breadcrumb-item"><a href="/admin/product"><i class="fe fe-file-text mr-2 fs-14"></i>Products</a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page"><a href="/admin/product">Set product</a></li>   <button class="bubbly-button">Click me!</button>-->
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row">
        <div class="card">
            <div class="card-body pb-2">
                <!-- Search bar-->
                <div class="col-lg-12">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" id="search-product" name="searchProduct"
                            placeholder="Searching.....">
                        <span class="input-group-append">
                            <button class="btn ripple btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                    <div id="product_list"></div>
                </div>
            </div>
            <!--  End search bar -->
        </div>
    </div>
    </div>
    <!-- Row -->
    <div class="row" id="refresh">
        <div class="col-lg-12 col-md-12" id="main-product">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Set product </h3>
                    </div>
                    <div class="card-body pb-2">

                        <form action="{{ route('verify-product', [$data['product'][0]->product_id]) }}" id='update-form'
                            method='POST' role="form" enctype="multipart/form-data">
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
                                            <!-- ENGLISH -->
                                            <div class="col-lg-12">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-heading">
                                                        <h3 class="expanel-title" style="text-align: center">Product
                                                            information in English &nbsp <i class="flag flag-us"></i></h3>
                                                    </div>
                                                    <div class="expanel-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg">
                                                                <input type='hidden' id='id_master'
                                                                name="id_master">
                                                                <label class="col-md-6 form-label">Product name</label>
                                                                <input class="form-control mb-4" placeholder="product name"
                                                                    type="text" name='name_1'
                                                                    value='{{ $data['description_eng'][0]->name ?? '' }}'>
                                                            </div>
                                                            <div class="col-lg">
                                                                <label class="col-md-6 form-label">Meta title</label>
                                                                <input type="text" id="example-meta_title"
                                                                    name="meta_title_1" class="form-control"
                                                                    placeholder="meta title"
                                                                    value='{{ $data['description_eng'][0]->meta_title ?? '' }}'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-6 form-label">Description</label>
                                                                <div class="ql-wrapper ql-wrapper-demo">
                                                                    <div id="quillEditor">{!! $data['description_eng'][0]->description !!}</div>
                                                                    <input type='hidden' id='description_1'
                                                                        name="description_1">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- FRENCH -->
                                            <div class="col-lg-12">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-heading">
                                                        <h3 class="expanel-title" style="text-align: center">Product
                                                            information in French &nbsp<i class="flag flag-fr"></i></h3>
                                                    </div>
                                                    <div class="expanel-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg">
                                                                <label class="col-md-6 form-label">Product name*</label>
                                                                <input class="form-control mb-4" placeholder="product name"
                                                                    type="text" name='name_2'
                                                                    value='{{ $data['description_fr'][0]->name ?? '' }}'>
                                                            </div>
                                                            <div class="col-lg">
                                                                <label class="col-md-6 form-label">Meta title*</label>
                                                                <input type="text" id="example-meta_title"
                                                                    name="meta_title_2" class="form-control"
                                                                    placeholder="meta title"
                                                                    value='{{ $data['description_fr'][0]->meta_title ?? '' }}'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-6 form-label">Description*</label>
                                                                <div class="ql-wrapper ql-wrapper-demo">
                                                                    <div id="quillEditor2">{!! $data['description_fr'][0]->description !!}</div>
                                                                    <input type='hidden' id='description_2'
                                                                        name="description_2">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ARABIC -->
                                            <div class="col-lg-12">
                                                <div class="expanel expanel-default">
                                                    <div class="expanel-heading">
                                                        <h3 class="expanel-title" style="text-align: center">Product
                                                            information in Arabic &nbsp <i class="flag flag-ma"></i></h3>
                                                    </div>
                                                    <div class="expanel-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg">
                                                                <label class="col-md-6 form-label">Product name*</label>
                                                                <input class="form-control mb-4" placeholder="product name"
                                                                    type="text" name='name_3'
                                                                    value='{{ $data['description_ar'][0]->name ?? '' }}'>
                                                            </div>
                                                            <div class="col-lg">
                                                                <label class="col-md-6 form-label">Meta title*</label>
                                                                <input type="text" id="example-meta_title"
                                                                    name="meta_title_3" class="form-control"
                                                                    placeholder="meta title"
                                                                    value='{{ $data['description_ar'][0]->meta_title ?? '' }}'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-6 form-label">Description*</label>
                                                                <div class="ql-wrapper ql-wrapper-demo">
                                                                    <div id="quillEditor3">{!! $data['description_ar'][0]->description !!}</div>
                                                                    <input type='hidden' id='description_3'
                                                                        name="description_3">
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
                                                    <label class="col-md-12 form-label">Model Code*</label>
                                                    <input class="form-control mb-4" placeholder="model" type="text"
                                                        name='model' value="{{ $data['product'][0]->model ?? '' }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">SKU*</label>
                                                    <input class="form-control mb-4" placeholder="sku" type="text"
                                                        name='sku' value="{{ $data['product'][0]->sku ?? '' }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">UPC</label>
                                                    <input class="form-control mb-4" placeholder="upc" type="text"
                                                        name='upc' value="{{ $data['product'][0]->upc ?? '' }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">GTIN / EAN*</label>
                                                    <input class="form-control mb-4" placeholder="gtn" type="text"
                                                        name='gtn' value="{{ $data['product'][0]->isbn ?? '' }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">JAN</label>
                                                    <input class="form-control mb-4" placeholder="jan" type="text"
                                                        name='jan' value="{{ $data['product'][0]->jan ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Date Available</label>
                                                    <input class="form-control mb-" placeholder="date available" type="date"
                                                        name='date_available'
                                                        value="{{ $data['product'][0]->date_available ?? '' }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Sort order</label>
                                                    <input class="form-control mb-" placeholder="sort order" type="number"
                                                        name='sort_order' value="{{ $data['product'][0]->sort_order }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Status</label>
                                                    <div class="col-md-12">
                                                        <select class="form-control select2" name="status">
                                                            <option value="1"
                                                                {{ $data['status']->status == 1 ? 'selected' : '' }}>
                                                                Enabled
                                                            </option>
                                                            <option value="0"
                                                                {{ $data['status']->status == 0 ? 'selected' : '' }}>
                                                                Disabled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Quantity*</label>
                                                    <input class="form-control mb-4" placeholder="quantity" type="text"
                                                        name='quantity'
                                                        value="{{ $data['product'][0]->quantity ?? '' }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Price*</label>
                                                    <input class="form-control mb-4" placeholder="price" type="text"
                                                        name='price' value="{{ $data['product'][0]->price ?? '' }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Manufacturer*</label>
                                                    <div class="col-md-12">
                                                        <select class="form-control select2" name="manufacturer_id">
                                                            @foreach ($data['manufacturers'] as $manufacturer)
                                                                <option value="{{ $manufacturer->manufacturer_id }}"
                                                                    {{ $manufacturer->manufacturer_id == $data['product'][0]->manufacturer_id ? 'selected' : '' }}>
                                                                    {{ $manufacturer->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Width</label>
                                                    <input class="form-control mb-4" placeholder="width" type="number"
                                                        name='width' value="{{ $data['product'][0]->width ?? 0 }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Height</label>
                                                    <input class="form-control mb-4" placeholder="height" type="number"
                                                        name='height' value="{{ $data['product'][0]->height ?? 0 }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Length</label>
                                                    <input class="form-control mb-4" placeholder="length" type="number"
                                                        name='length' value="{{ $data['product'][0]->length ?? 0 }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Vendor*</label>
                                                    <div class="col-md-12">
                                                        <select class="form-control select2" name="vendor_id">
                                                            @foreach ($data['vendors'] as $vendor)
                                                                <option value="{{ $vendor->vendor_id }}"
                                                                    {{ $vendor->vendor_id == $data['product'][0]->vendor_id ? 'selected' : '' }}>
                                                                    {{ $vendor->display_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="col-lg-12 col-sm-12">
                                                    <label class="col-md-12 form-label">Product image*</label>
                                                    <input type="file" class="dropify" name='image' @if (!File::exists(public_path('/uploads/' . $data['image']->image))) data-default-file="https://ariba.ma/image/{{ $data['image']->image }}" @else data-default-file="/../uploads/{{ $data['image']->image }}" @endif data-height="310" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END-DATA TAB -->

                                        <!-- START-Specification TAB -->
                                        <div class="tab_content">
                                            <div class="row row-sm">
                                                <div class="col-lg-12 col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Categories*</h3>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <select multiple="multiple"
                                                                onchange="console.log($(this).children(':selected').length)"
                                                                class="search-box" name="categories[]">
                                                                @foreach ($data['categories'] as $category)
                                                                    <option value="{{ $category->category_id }}"
                                                                        {{ $data['productCategories']->contains('category_id', $category->category_id) ? 'selected' : '' }}>
                                                                        {{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Filters</h3>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <select multiple="multiple"
                                                                onchange="console.log($(this).children(':selected').length)"
                                                                class="search-box" name="filters[]">
                                                                @foreach ($data['filters'] as $filter)
                                                                    <option value="{{ $filter->filter_id }}"
                                                                        {{ $data['productFilters']->contains('filter_id', $filter->filter_id) ? 'selected' : '' }}>
                                                                        {{ $filter->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg">
                                                    <label class="col-md-6 form-label">Set Number*</label>
                                                    <input class="form-control mb-4" placeholder="set" type="number"
                                                        id="setNumber" name='set_number'
                                                        value="{{ $data['product'][0]->set_number ?? 0 }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-4 form-label">Option</label>
                                                <select class="form-control select2" name="option">
                                                    @if ($data['option_id'] == 13)
                                                        <option value=13>Shoes Size</option>
                                                    @else<option value=11>Size</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="row row-sm">
                                                <div class="card-header">
                                                    <h3 class="card-title">Specification</h3>
                                                </div>
                                                <div class="col-lg-12 col-sm-12">
                                                    <div class="card">
                                                        <div class="table-responsive">
                                                            @if ($data['option_id'] == 13)
                                                                <table class="table card-table table-vcenter text-nowrap">
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
                                                                    <tbody id="shoes" style="">
                                                                        @foreach ($data['options'] as $option)
                                                                            @if ($option->option_value_id == 49)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="35"
                                                                                            name="49" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control "
                                                                                            type="number" name="quantity_35"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_35"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control "
                                                                                            type="number" name="price_35"
                                                                                            value="{{ $option->price }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_35"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 50)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="36"
                                                                                            name="50" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_36"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control  set"
                                                                                            type="number" name="set_36"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_36"
                                                                                            value="{{ $option->price }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_36"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 51)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="37"
                                                                                            name="51" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_37"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_37"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_37"
                                                                                            value="{{ $option->price }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_37"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 52)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="38"
                                                                                            name="52" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_38"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_38"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_38"
                                                                                            value="{{ $option->price }}"
                                                                                            min="0" placeholder="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_38"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 53)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="39"
                                                                                            name="53" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_39"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_39"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_39"
                                                                                            value="{{ $option->price }}"
                                                                                            min="0" placeholder="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_39"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 54)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="40"
                                                                                            name="54" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_40"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_40"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_40"
                                                                                            value="{{ $option->price }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_40"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 55)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="41"
                                                                                            name="55" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_41"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_41"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_41"
                                                                                            value="{{ $option->price }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_41"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                        @endforeach
                                                                    </tbody>
                                                                    <!-- END SHOES SIZE -->
                                                                </table>
                                                            @endif
                                                            <!-- Size -->
                                                            @if ($data['option_id'] == 11)
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
                                                                    <tbody>
                                                                        @foreach ($data['options'] as $option)
                                                                            @if ($option->option_value_id == 58)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control" type="text"
                                                                                            value="XS" name="58" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control "
                                                                                            type="number" name="quantity_xs"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_xs"
                                                                                            value="0" placeholder="0"
                                                                                            min="0"></td>
                                                                                    <td><input class="form-control "
                                                                                            type="number" name="price_xs"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_xs"
                                                                                            placeholder="ean" value="">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 46)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control" type="text"
                                                                                            value="S" name="46" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_s"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control  set"
                                                                                            type="number" name="set_s"
                                                                                            value="0" placeholder="0"
                                                                                            min="0"></td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_s"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_s"
                                                                                            placeholder="ean" value="">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 47)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control" type="text"
                                                                                            value="M" name="47" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_m"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_m"
                                                                                            value="0" placeholder="0"
                                                                                            min="0"></td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_m"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_m"
                                                                                            placeholder="ean" value="">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 48)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control" type="text"
                                                                                            value="L" name="48" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_l"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_l"
                                                                                            value="0" placeholder="0"
                                                                                            min="0"></td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_l"
                                                                                            min="0" placeholder="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_l"
                                                                                            placeholder="ean" value="">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 59)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control" type="text"
                                                                                            value="XL" name="59" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_xl"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_xl"
                                                                                            value="0" value="0"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_xl"
                                                                                            min="0" placeholder="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_xl"
                                                                                            placeholder="ean" value="">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 60)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control" type="text"
                                                                                            value="XXL" name="60" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number"
                                                                                            name="quantity_xxl"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_xxl"
                                                                                            value="0" placeholder="0"
                                                                                            min="0"></td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_xxl"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_xxl"
                                                                                            placeholder="ean" value="">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                    </tbody>
                                                                </table>
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                        <!-- table-responsive -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END-Specification TAB -->

                                        <!-- START-IMAGES TAB -->
                                        <div class="tab_content">
                                            <label class="col-md-4 form-label">Product images : </label>
                                            <div class="row row-sm mt-4">
                                                @foreach ($data['images'] as $image)
                                                    <div class="col-lg-4 col-sm-12">
                                                        <input type="file" class="dropify disable-image" disabled
                                                            name='images[]'
                                                            data-default-file="https://ariba.ma/image/{{ $image->image }}"
                                                            data-height="210" />
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- END-IMAGE TAB -->
                                        <style>
                                            input[name="disable-image"].disabled {
                                                pointer-events: none;
                                            }

                                        </style>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4 mb-0">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <!-- Search product details-->
            <div class="card" style="display: none" id="search_product_info">
                <div class="card-header">

                    <div class="col-lg-6 col-md-6">
                        <h3 class="card-title">Master Product details</h3>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="btn-list text-right">
                            <a href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                class="btn btn-primary">Connect product</a>
                            <a href="https://laravel.spruko.com/admitro/Vertical-IconSidedar-Light/#"
                                class="btn btn-secondary">Change and connect</a>
                        </div>
                    </div>

                </div>
                <div class="card-body pb-2">
                    <div class="panel panel-primary">
                        <div class="tab_wrapper first_tab">
                            <ul class="tab_list">
                                <li>General Information</li>
                                <li>Data</li>
                                <li>Images</li>
                            </ul>
                            <div class="content_wrapper">
                                <!-- start-GENERAL TAB -->
                                <div class="tab_content active">

                                    <!-- english -->
                                    <div class="expanel expanel-default">
                                        <div class="expanel-heading">
                                            <h3 class="expanel-title">GENERAL INFORMATION &nbsp <i class="flag flag-usa"
                                                    style=""></i><span id="description_eng" style="padding: 5px 10px 5px;"
                                                    class="float-right bubbly-button"><i style=""
                                                        class="fa fa-exchange float-right"></i></span></h3>
                                        </div>
                                        <div class="expanel-body">
                                            <dl class="row">
                                                <dt class="col-sm-3">NAME</dt>
                                                <dd class="col-sm-9" id="name3"></dd>

                                                <dt class="col-sm-3">DESCRIPTION</dt>
                                                <dd class="col-sm-9" id="description3">

                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <!-- END-english -->

                                    <!-- FRENCH -->
                                    <div class="expanel expanel-default">
                                        <div class="expanel-heading">
                                            <h3 class="expanel-title">GENERAL INFORMATION &nbsp <i class="flag flag-fr"
                                                    style=""></i><SPAN id="description_fr" style="padding: 5px 10px 5px;"
                                                    class="float-right bubbly-button"><i style=""
                                                        class="fa fa-exchange float-right"></i></SPAN></h3>
                                        </div>
                                        <div class="expanel-body">
                                            <dl class="row">
                                                <dt class="col-sm-3">NAME</dt>
                                                <dd class="col-sm-9" id="name1"></dd>

                                                <dt class="col-sm-3">DESCRIPTION</dt>
                                                <dd class="col-sm-9" id="description1">

                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <!-- END-FRENCH -->

                                    <!-- Arabic -->
                                    <div class="expanel expanel-default">
                                        <div class="expanel-heading">
                                            <h3 class="expanel-title">GENERAL INFORMATION &nbsp <i class="flag flag-ma"
                                                    style=""></i><span id="description_ar" style="padding: 5px 10px 5px;"
                                                    class="float-right bubbly-button"><i style=""
                                                        class="fa fa-exchange float-right"></i></span></h3>
                                        </div>
                                        <div class="expanel-body">
                                            <dl class="row">
                                                <dt class="col-sm-3">NAME</dt>
                                                <dd class="col-sm-9" id="name2"></dd>

                                                <dt class="col-sm-3">DESCRIPTION</dt>
                                                <dd class="col-sm-9" id="description2">

                                                </dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <!-- END-Arabic -->
                                </div>
                                <div class="tab_content ">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="card overflow-hidden">
                                            <img src="" id="image" alt="image" class="card-image1 ">
                                            <div class="card-body">
                                                <h5 class="card-title" id="card-name"></h5>
                                                <p class="card-text" id="card-description"></p>
                                            </div>
                                            <div class="card-footer">
                                                <small class="text-muted">Category</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab_content">
                                    <label class="col-md-4 form-label">Product images : </label>
                                    <div class="row row-sm mt-4">
                                        <img src="" id="image1" alt="image" class="card-image1 " style="max-width: 30%;">
                                        <img src="" id="image2" alt="image" class="card-image1 " style="max-width: 30%;">
                                        <img src="" id="image3" alt="image" class="card-image1 " style="max-width: 30%;">
                                        <img src="" id="image4" alt="image" class="card-image1 " style="max-width: 30%;">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function() {

            $('#search-product').on('keyup', function() {
                var query = $(this).val();
                $('#search_product_info').css('display', 'none');
                $('#main-product').attr('class', 'col-lg-12 col-md-12');
                $.ajax({
                    url: "{{ route('search') }}",
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(data) {
                        $('#product_list').html(data);
                    },
                    error: function(ajaxContext) {
                        alert(ajaxContext.responseText);
                    }
                })
                // end of ajax call
            });

            $(document).on('click', '.search-select', function(e) {
                e.preventDefault();
                var product_id = $(this).attr("data-id");
                $.ajax({
                    url: "{{ route('search-details') }}",
                    type: "GET",
                    data: {
                        'id': product_id
                    },
                    success: function(data1) {
                        $('input[name=id_master]').val(data1["product"]["product_id"]);
                        let imageee = data1["images"][0]["image"];
                        var imagesrc = "https://ariba.ma/image/" + data1["product"]["image"];

                        $('#name1').html(data1["product"]["name"]);
                        $('#card-name').html(data1["product"]["name"]);
                        var txt = data1["description_eng"][0]["description"];

                        $('#name1').html(data1["description_fr"][0]["name"]);
                        $('#description1').html(data1["description_fr"][0]["description"]);

                        $("#image").attr("src", "https://ariba.ma/image/" + data1["product"][
                            "image"
                        ]);

                        $('#name2').html(data1["description_ar"][0]["name"]);
                        $('#description2').html(data1["description_ar"][0]["description"]);

                        $('#name3').html(data1["description_eng"][0]["name"]);
                        $('#description3').html(data1["description_eng"][0]["description"]);

                        if (txt.length > 155) {
                            $('#card-description').html(txt.substring(0, 150) + '...');
                        } else {
                            $('#card-description').html(txt);
                        }
                        for (var i = 1; i <= data1["images"].length; i++) {
                            $("#image" + i).attr("src", "https://ariba.ma/image/" + data1[
                                "images"][i]["image"]);
                        }

                    },
                    error: function(ajaxContext) {
                        alert(ajaxContext.responseText);
                    }

                })
                var value = $(this).text();
                $('#main-product').attr('class', 'col-lg-6 col-md-6');
                $('#search-product').val($.trim(value));
                $('#product_list').html("");
                $('#search_product_info').css('display', 'block');
            });
        });

        $(document).on('click', '#description_fr', function(e) {
            var name = $('#name1');
            var meta = $('#name1');
            var description = $('#description1');
            $('input[name=name_2]').val(name.html());
            $('input[name=name_2]').css('border-color', '#705ec8');

            $('input[name=meta_title_2]').val(meta.html());
            $('input[name=meta_title_2]').css('border-color', '#705ec8');

            $('textarea[name=description_2]').val(description.html());
            $('textarea[name=description_2]').css('border-color', '#705ec8');
        });

        $(document).on('click', '#description_ar', function(e) {
            var name = $('#name2');
            var meta = $('#name2');
            var description = $('#description2');
            $('input[name=name_3]').val(name.html());
            $('input[name=name_3]').css('border-color', '#705ec8');

            $('input[name=meta_title_3]').val(meta.html());
            $('input[name=meta_title_3]').css('border-color', '#705ec8');

            $('textarea[name=description_3]').val(description.html());
            $('textarea[name=description_3]').css('border-color', '#705ec8');
        });

        $(document).on('click', '#description_eng', function(e) {
            var name = $('#name3');
            var meta = $('#name3');
            var description = $('#description3');
            $('input[name=name_1]').val(name.html());
            $('input[name=name_1]').css('border-color', '#705ec8');

            $('input[name=meta_title_1]').val(meta.html());
            $('input[name=meta_title_1]').css('border-color', '#705ec8');

            $('textarea[name=description_1]').val(description.html());
            $('textarea[name=description_1]').css('border-color', '#705ec8');
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
