@extends('admin.layouts.master-vendor')
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

    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">

    <!-- INTERNAL Jquerytransfer css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/jQuerytransfer/jquery.transfer.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/jQuerytransfer/icon_font/icon_font.css') }}">

    <!-- INTERNAL multi css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/multi/multi.min.css') }}">

    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">

    <!-- INTERNAl Quill css -->
    <link href="{{ URL::asset('assets/plugins/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/quill/quill.bubble.css') }}" rel="stylesheet">

    <!-- INTERNAL File Uploads css -->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />

    <!-- INTERNAL File Uploads css-->
    <link href="{{ URL::asset('assets/plugins/fileupload/css/fileupload.css') }}" rel="stylesheet" type="text/css" />

    <!-- INTERNAL Prism Css -->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!-- INTERNAL  Tabs css-->
    <link href="{{ URL::asset('assets/plugins/tabs/style.css') }}" rel="stylesheet" />

    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Update product</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/vendor/product"><i class="fe fe-file-text mr-2 fs-14"></i>Products</a>
                </li>
                <!-- <li class="breadcrumb-item active" aria-current="page"><a href="/admin/product">Set product</a></li>   <button class="bubbly-button">Click me!</button>-->

            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row" id="refresh">
        <div class="col-lg-12 col-md-12">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Update product </h3>
                    </div>
                    <div class="card-body pb-2">
{{--                        @can('product-edit')--}}
                            <form action="{{ route('vendor-update-product', [$data['product'][0]->product_id]) }}" id='update-form'
                                method='POST' role="form" enctype="multipart/form-data">
                                @csrf
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success" role="alert"><button type="button" class="close"
                                            data-dismiss="alert" aria-hidden="true">??</button>
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
{{--                            @endcan--}}
                            <div class="panel panel-primary">
                                <div class="tab_wrapper first_tab">
                                    <ul class="tab_list">
                                        <li class="">General Information</li>
                                        <li>Data</li>
                                        <li>Specification</li>
                                        <li>Discount</li>
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
                                                            </div>
                                                            <div class="row row-sm">
                                                                <div class="col-md-12">
                                                                    <label class="col-md-6 form-label">Description</label>
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
                                                <div class="col-lg-4">
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
                                                            </div>
                                                            <div class="row row-sm">
                                                                <div class="col-md-12">
                                                                    <label class="col-md-6 form-label">Description</label>
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

                                                 <!-- ENGLISH -->
                                                <div class="col-lg-4">
                                                    <div class="expanel expanel-default">
                                                        <div class="expanel-heading">
                                                            <h3 class="expanel-title" style="text-align: center">Product
                                                                information in English &nbsp <i class="flag flag-us"></i></h3>
                                                        </div>
                                                        <div class="expanel-body">
                                                            <div class="row row-sm">
                                                                <div class="col-lg">
                                                                    <label class="col-md-6 form-label">Product name</label>
                                                                    <input class="form-control mb-4" placeholder="product name"
                                                                        type="text" name='name_1'
                                                                        value='{{ $data['description_eng'][0]->name ?? '' }}'>
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

                                            </div>
                                        </div>

                                        <!-- END-GENERAL TAB -->

                                        <!-- DATA TAB -->
                                        <div class="tab_content">
                                            <div class="row row-sm">
                                                <div class="col-lg">
                                                    <label class="col-md-6 form-label">Quantity*</label>
                                                    <input class="form-control mb-4" placeholder="quantity" type="number"
                                                        name='quantity'
                                                        value="{{ $data['product'][0]->quantity ?? '' }}">
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-4 form-label">Price*</label>
                                                    <input class="form-control mb-4" placeholder="price" type="number"
                                                        name='price' value="{{$data['product'][0]->price-number_format(floatval($data['product'][0]->price*0.2),2) ?? '' }}">
                                                </div>

                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">GTIN / EAN</label>
                                                    <input class="form-control mb-4" placeholder="gtn" type="text"
                                                        name='gtn' value="{{ $data['product'][0]->isbn ?? '' }}">
                                                </div>

                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Status</label>
                                                    <div class="col-md-12">
                                                        <select class="form-control select2" disabled >
                                                            <option value="1"
                                                                {{ $data['status']->status == 1 ? 'selected' : '' }} >
                                                                Enabled
                                                            </option>
                                                            <option value="0"
                                                                {{ $data['status']->status == 0 ? 'selected' : '' }}>
                                                                Disabled</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Article Number</label>
                                                    <input class="form-control mb-4" placeholder="model" type="text"
                                                        name='model' value="{{ $data['product'][0]->model ?? '' }}">
                                                </div>
                                            </div>
                                            
                                            <div class="row row-sm">
                                                 <div class="col-lg mt-4">
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input mb-4" name="stock_status_id" value="option1" @if( $data['product'][0]->stock_status_id==8) checked @endif()>
                                                        <span class="custom-control-label">Pre-order</span>
                                                    </label>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="col-md-12 form-label">Estimated Time (pre-order days)*</label>
                                                    <input class="form-control mb-4" placeholder="estimated time" type="number"  value="{{ $data['product'][0]->estimated_day ?? 0 }}"
                                                        name='estimated_day'>
                                                </div>
                                                
                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Supplier (optional)</label>
                                                    <div class="col-md-12">
                                                        <select  class="form-control select2" name="supplier_id">
                                                            <option disabled selected value> -- Select an option -- </option>
                                                            @foreach ($data['suppliers'] as $supplier)
                                                                <option value="{{ $supplier->supplier_id }}" {{ $supplier->supplier_id == $data['product'][0]->supplier_id ? 'selected' : '' }}>
                                                                    {{ $supplier->firstname }} {{ $supplier->lastname }}</option>
                                                            @endforeach
                                                        </select>
                                                        <a href="{{route('vendor-supplier-add')}}" style="text-decoration: underline;color:#705ec8">Add supplier</a>
                                                    </div>
                                                </div>

                                                <div class="col-lg">
                                                    <label class="col-md-12 form-label">Manufacturer/Distributor*</label>
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
                                                <div class="col-lg-3 col-sm-12">
                                                    <label class="col-md-12 form-label">Main Image*</label>
                                                    <input type="file" class="dropify" name='image' @if (!File::exists(public_path('/uploads/' . $data['image']->image))) data-default-file="https://ariba.ma/image/{{ $data['image']->image }}" @else data-default-file="/../uploads/{{ $data['image']->image }}" @endif data-height="310" />
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END-DATA TAB -->


                                        <!-- START-Specification TAB -->
                                        <div class="tab_content">
                                            <div class="row row-sm">
                                                <div class="col-lg-3 col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label class="col-md-6 form-label">Categories*</label>
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
                                                <div class="col-lg-3 col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <label class="col-md-6 form-label">Filters*</label>
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

                                                <div class="col-lg-3 col-sm-12">
                                                    <label class="col-md-6 form-label">Set Number*</label>
                                                    <input class="form-control mb-4" placeholder="set" type="number"
                                                        id="setNumber" name='set_number'
                                                        value="{{ $data['product'][0]->set_number ?? 0 }}" readonly>
                                                </div>
                                                <div class="col-lg-3">
                                                    <label class="col-md-12 form-label">Minimum Order*</label>
                                                    <input class="form-control mb-4" placeholder="set" type="number"
                                                      value="{{ $data['product'][0]->min_order ?? 0 }}"
                                                        name='min_order'>
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
                                                                            @if ($option->option_value_id == 56)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="42"
                                                                                            name="56" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_42"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_42"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_42"
                                                                                            value="{{ $option->price }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_42"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 57)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="43"
                                                                                            name="57" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_43"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_43"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_43"
                                                                                            value="{{ $option->price }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_43"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 61)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="44"
                                                                                            name="61" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_44"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_44"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_44"
                                                                                            value="{{ $option->price }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_44"
                                                                                            value="{{ $option->ciopean }}"
                                                                                            placeholder="ean">
                                                                                    </td>
                                                                                </tr>
                                                                            @endif
                                                                            @if ($option->option_value_id == 62)
                                                                                <tr>
                                                                                    <th scope="row"><input
                                                                                            class="form-control"
                                                                                            type="number" value="45"
                                                                                            name="62" disabled>
                                                                                    </th>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="quantity_45"
                                                                                            value="{{ $option->quantity }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control set"
                                                                                            type="number" name="set_45"
                                                                                            value="{{ $option->set_number }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="number" name="price_45"
                                                                                            value="{{ $option->price }}"
                                                                                            placeholder="0" min="0">
                                                                                    </td>
                                                                                    <td><input class="form-control"
                                                                                            type="text" name="ean_45"
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

                                        <div class="tab_content">
                                            <div class="table-responsive">
                                                <table id="discount" class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <td class="text-center">Quantity</td>
                                                            <td class="text-center">Priority</td>
                                                            <td class="text-center">Price</td>
                                                            <td class="text-center">Date Start</td>
                                                            <td class="text-center">Date End</td>
                                                            <td></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       @foreach ($data['discounts'] as $discount)
                                                        <tr id="discount-row{{$loop->index}}">
                                                            <td class="text-right"><input type="number" min=0 name="product_discount['{{$loop->index}}'][quantity]" value="{{$discount->quantity}}" placeholder="Quantity" class="form-control" /></td>
                                                            <td class="text-right"><input type="number" min=0 name="product_discount['{{$loop->index}}'][priority]" value="{{$discount->priority}}" placeholder="Priority" class="form-control" /></td>
                                                            <td class="text-right"><input type="number" min=0 name="product_discount['{{$loop->index}}'][price]" value="{{$discount->price}}" placeholder="Price" class="form-control" /></td>
                                                            <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="date" name="product_discount['{{$loop->index}}'][date_start]" value="{{$discount->date_start}}" placeholder="Date Start" data-date-format="YYYY-MM-DD" class="form-control" /></div></td>
                                                            <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="date" name="product_discount['{{$loop->index}}'][date_end]" value="{{$discount->date_end}}" placeholder="Date End" data-date-format="YYYY-MM-DD" class="form-control" /></div></td>
                                                            <td class="text-left"><button type="button" onclick="$('#discount-row{{$loop->index}}').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                                        </tr>
                                                       @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="5"></td>
                                                            <td class="text-left"><button type="button" onclick="addDiscount();" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>


                                        <!-- START-IMAGES TAB -->
                                        <div class="tab_content">
                                            <label class="col-md-4 form-label">Product images : </label>
                                            <div class="row row-sm mt-4">
                                                @foreach ($data['images'] as $image)
                                                    <div class="col-lg-4 col-sm-12">
                                                        <input type="file" class="dropify disable-image"
                                                            name='{{$image->product_image_id }}'
                                                            data-default-file="https://ariba.ma/image/{{ $image->image }}"
                                                            data-height="210" />
                                                    </div>
                                                @endforeach
                                                @for($i=0; $i<(9-count($data['images'])); $i++)
                                                <div class="col-lg-4 col-sm-12">
                                                    <input type="file" class="dropify disable-image"
                                                        name='images[]'
                                                        data-height="210" multiple />
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                        <!-- END-IMAGE TAB
                                        <style>
                                            input[name="disable-image"].disabled {
                                                pointer-events: none;
                                            }

                                        </style>-->
                                    </div>
                                </div>
                            </div>
{{--                            @can('product-edit')--}}
                                <button type="submit" class="btn btn-primary mt-4 mb-0" id="save">Save</button>
                            </form>
{{--                        @endcan--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
        $('form').on('focus', 'input[type=number]', function (e) {
            $(this).on('wheel.disableScroll', function (e) {
                e.preventDefault();
            })
        });

        $('form').on('blur', 'input[type=number]', function (e) {
             $(this).off('wheel.disableScroll');
        });
    var discount_row = {{count($data['discounts'])}};
    function addDiscount() {
        html = '<tr id="discount-row' + discount_row + '">';
        html += '  <td class="text-right"><input type="number" min=0 name="product_discount[' + discount_row + '][quantity]" value="" placeholder="Quantity" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="number" min=0 name="product_discount[' + discount_row + '][priority]" value="" placeholder="Priority" class="form-control" /></td>';
        html += '  <td class="text-right"><input type="number" min=0 name="product_discount[' + discount_row + '][price]" value="" placeholder="Price" class="form-control" /></td>';
        html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="date" name="product_discount[' + discount_row + '][date_start]" value="" placeholder="Date Start" data-date-format="YYYY-MM-DD" class="form-control" /></div></td>';
        html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="date" name="product_discount[' + discount_row + '][date_end]" value="" placeholder="Date End" data-date-format="YYYY-MM-DD" class="form-control" /></div></td>';
        html += '  <td class="text-left"><button type="button" onclick="$(\'#discount-row' + discount_row + '\').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
        html += '</tr>';

        $('#discount tbody').append(html);

        discount_row++;
    }
</script>
    <script type="text/javascript">

        $( "#update-form" ).submit(function() {
            $('#save').toggleClass('btn-primary btn-primary btn-loading');
            return true;
        });

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

        $('#update-form').submit(function() {
            var content = $("#quillEditor3").contents().html();
            $("#description_3").val(content);
            var content = $("#quillEditor2").contents().html();
            $("#description_2").val(content);
            var content = $("#quillEditor").contents().html();
            $("#description_1").val(content);

            return true;
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
