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

    <!-- INTERNAL multi css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/multi/multi.min.css') }}">
    <!-- Include Quill stylesheet -->
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">
    <!-- INTERNAl Quill css -->
    <link href="{{ URL::asset('assets/plugins/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/quill/quill.bubble.css') }}" rel="stylesheet">

    <!-- INTERNAl WYSIWYG Editor css -->
    <link href="{{ URL::asset('assets/plugins/wysiwyag/richtext.css') }}" rel="stylesheet" />

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
            <h4 class="page-title mb-0">Add Product</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/vendor/product"><i class="fe fe-file-text mr-2 fs-14"></i>Products</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/admin/product">Add Product</a></li>
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
                    <h3 class="card-title">Add product </h3>
                </div>
                <div class="card-body pb-2">

                    <form action="{{ route('vendor-add-product') }}" id="add-product" method='POST' role="form" enctype="multipart/form-data"
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
                                                        <h3 class="expanel-title" style="text-align: center">Product information
                                                            in French &nbsp<i class="flag flag-fr"></i></h3>
                                                    </div>
                                                    <div class="expanel-body">
                                                        <div class="row row-sm">
                                                            <div class="col-lg">
                                                                <label class="col-md-12 form-label">Product name*</label>
                                                                <input class="form-control mb-4" placeholder="product name"
                                                                    type="text" name='name_2'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Description</label>
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
                                                                <label class="col-md-12 form-label">Product name*</label>
                                                                <input class="form-control mb-4" placeholder="product name"
                                                                    type="text" name='name_3'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Description</label>
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
                                                                <label class="col-md-12 form-label">Product name</label>
                                                                <input class="form-control mb-4" placeholder="product name"
                                                                    type="text" name='name_1'>
                                                            </div>
                                                        </div>
                                                        <div class="row row-sm">
                                                            <div class="col-md-12">
                                                                <label class="col-md-12 form-label">Description</label>
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
                                                    name='quantity' min=1>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Price*</label>
                                                <input class="form-control mb-4" placeholder="price" type="number"
                                                    name='price'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">GTIN / EAN</label>
                                                <input class="form-control mb-4" placeholder="gtn" type="text" name='gtn'>
                                            </div>
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Article Number</label>
                                                <input class="form-control mb-4" placeholder="model" type="text"
                                                    name='model'>
                                            </div>
                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg mt-4">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input mb-4" name="stock_status_id" value="option1" >
                                                    <span class="custom-control-label">Pre-order</span>
                                                </label>
                                             </div>
                                             <div class="col-lg-3">
                                                <label class="col-md-12 form-label">Estimated Time (pre-order days)*</label>
                                                <input class="form-control mb-4" placeholder="estimated day" type="number" value="1"
                                                    name='estimated_day' min=1>
                                            </div>
                                             <div class="col-lg">
                                                <label class="col-md-12 form-label">Supplier (optional)</label>
                                                <div class="col-md-12">
                                                    <select  class="form-control select2" name="supplier_id">
                                                        <option disabled selected value> -- Select an option -- </option>
                                                        @foreach ($data['suppliers'] as $supplier)
                                                            <option value="{{ $supplier->supplier_id }}">
                                                                {{ $supplier->firstname }} {{ $supplier->lastname }}</option>
                                                        @endforeach
                                                    </select>
                                                    <a  class="modal-effect" href='#'
                                                    data-effect="effect-scale" data-target="#add_supplier" data-toggle="modal" style="text-decoration: underline;color:#705ec8">Add supplier</a>
                                                </div>
                                            </div>

                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Manufacturer/Distributor*</label>
                                                <div class="col-md-12">
                                                    <select  class="form-control select2" name="manufacturer_id">
                                                        @foreach ($data['manufacturers'] as $manufacturer)
                                                            <option value="{{ $manufacturer->manufacturer_id }}">
                                                                {{ $manufacturer->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <a  class="modal-effect" href='#'
                                                    data-effect="effect-scale" data-target="#add_manufacturer" data-toggle="modal" style="text-decoration: underline;color:#705ec8">Add manufacturer</a>
                                                </div>
                                                
                                            </div>

                                        </div>

                                        <div class="row row-sm">
                                            <div class="col-lg-3 col-sm-12">
                                                <label class="col-md-12 form-label  mt-2">Main Image</label>
                                                <input type="file" class="dropify mt-2" name='image' data-height="130" />
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
                                                        <label class="col-md-12 form-label">Categories*</label>
                                                        <select multiple="multiple"
                                                            class="search-box category" name="categories[]" id="mySelect">
                                                            <option value="not_found" >
                                                                Not found</option>
                                                            @foreach ($data['categories'] as $category)
                                                                <option class="to_disable" value="{{ $category->category_id }}">
                                                                    {{ $category->name }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2" id="newCategory" style="display:none">
                                                <label class="col-md-12 form-label">New Category*</label>
                                                <input class="form-control mb-4" placeholder="New Category" type="text"
                                                    name='new_category'>
                                            </div>

                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <label class="col-md-12 form-label">Filters*</label>
                                                        <select multiple="multiple" 
                                                            class="search-box" name="filters[]">
                                                            @foreach ($data['filters'] as $filter)
                                                                <option value="{{ $filter->filter_id }}">
                                                                    {{ $filter->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="col-md-12 form-label">Set Number*</label>
                                                <input class="form-control mb-4" placeholder="set" type="number" value="0"
                                                    name='set_number' id="setNumber" readonly>
                                            </div>
                                            <div class="col-lg-2">
                                                <label class="col-md-12 form-label">Minimum Order*</label>
                                                <input class="form-control mb-4" placeholder="set" type="number" value="1"
                                                    name='min_order' min=1>
                                            </div>
                                            
                                            <div class="col-lg">
                                                <label class="col-md-12 form-label">Option*</label>
                                                <select class="form-control select2" name="option">
                                                    <option value=13>Shoes Size</option>
                                                    <option value=11>Size</option>
                                                </select>
                                            </div>
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
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4 mb-0" id="save">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

      <!-- Add supplier -->
    <div class="modal" id="add_supplier">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="smallmodal1">Add Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="alert alert-success success_container" style="display: none">
                                supplier has been added successfully
                            </div>

                            <div class="alert alert-danger error_container" style="display: none">
                                <ul id="error-validation">
                                </ul>
                            </div>
                     
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Supplier Informations
                                </h3>
                            </div>

                            <div class="expanel-body supplier">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">First Name</label>
                                        <input class="form-control mb-4" placeholder="firstame" type="text"
                                                name='firstname' value='{{ old('firstname') }}'>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Last Name</label>
                                        <input class="form-control mb-4" placeholder="lastname" type="text"
                                                name='lastname' value='{{ old('lastname') }}'>
                                    </div>
                                </div>
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Email</label>
                                        <input class="form-control mb-4" placeholder="email" type="email"
                                                name='email' value='{{ old('email') }}'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  id="save_supplier">Add</button>
                    </div>
            </div>
        </div>
    </div>

     <!-- Add Manufacturer -->
     <div class="modal" id="add_manufacturer">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="smallmodal1">Add Manufacturer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="alert alert-success success_container" style="display: none">
                                Manufacturer has been added successfully
                            </div>

                            <div class="alert alert-danger error_container" style="display: none">
                                <ul id="error-validation">
                                </ul>
                            </div>
                     
                        <div class="expanel expanel-default">
                            <div class="expanel-heading">
                                <h3 class="expanel-title" style="text-align: center">Manufacturer Informations
                                </h3>
                            </div>

                            <div class="expanel-body supplier">
                                <div class="row row-sm">
                                    <div class="col-lg">
                                        <label class="col-md-12 form-label">Name</label>
                                        <input class="form-control mb-4" placeholder="firstame" type="text"
                                                name='name' value='{{ old('name') }}'>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"  id="save_manufacturer">Add</button>
                    </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script type="text/javascript">
        
        var discount_row = 0;
        function addDiscount() {
            html = '<tr id="discount-row' + discount_row + '">';
            html += '  <td class="text-right"><input type="number"  min=2 name="product_discount[' + discount_row + '][quantity]" value="" placeholder="Quantity" class="form-control" /></td>';
            html += '  <td class="text-right"><input type="number"  min=0 name="product_discount[' + discount_row + '][priority]" value="" placeholder="Priority" class="form-control" /></td>';
            html += '  <td class="text-right"><input type="number"  min=0 name="product_discount[' + discount_row + '][price]" value="" placeholder="Price" class="form-control" /></td>';
            html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="date" name="product_discount[' + discount_row + '][date_start]" value="" placeholder="Date Start" data-date-format="YYYY-MM-DD" class="form-control" /></div></td>';
            html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="date" name="product_discount[' + discount_row + '][date_end]" value="" placeholder="Date End" data-date-format="YYYY-MM-DD" class="form-control" /></div></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#discount-row' + discount_row + '\').remove();"  class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#discount tbody').append(html);

            discount_row++;
        }

       
    </script>

    <script>
        $( "#add_supplier" ).on('shown.bs.modal', function(e){
            clear();
        });

        $( "#add_manufacturer" ).on('shown.bs.modal', function(e){
            clear();
        });

        function clear()
        {
            $('.error_container').css('display','none');
            $('#error-validation').css('display','none');
            $('.success_container').css('display','none');
            $('.supplier input').val('');
        }
    </script>

    <script type="text/javascript">
        $( "#add-product" ).submit(function() {
            $('#save').toggleClass('btn-primary btn-primary btn-loading');
            return true;
        });

        $(document).on('click', '#save_supplier', function(e) {
            e.preventDefault();
            var firstname=$('.supplier input[name="firstname"]').val();
            var lastname=$('.supplier input[name="lastname"]').val();
            var email=$('.supplier input[name="email"]').val();

            $.ajax({
                url: "{{route('vendor-supplier-add')}}",
                header: 'Content-Type: application/json',
                type: 'POST',
                data:{ "_token": "{{ csrf_token() }}",'firstname':firstname,'lastname':lastname,'email':email,},

                success: function(json) {
                    $('.error_container').css('display','none');
                    $('.success_container').css('display','block');
                    let html = '  <option disabled selected value> -- Select an option -- </option>';
                        if (json['result'] && json['result'] != '') {
                            for (let i = 0; i < json['result'].length; i++) {
                                html += '<option value="' + json['result'][i]['supplier_id'] + '"';
                                html += '>' + json['result'][i]['firstname'] +' '+json['result'][i]['lastname']+'</option>';
                            }
                        } 

                    $('select[name=\'supplier_id\']').html(html);
                    $( "#add_supplier" ).modal('hide');
                },

                error: function(response) {
                    var data = response.responseJSON.errors;
                    $('#error-validation').css('display','block');
                    $('.success_container').css('display','none');
                    $('#error-validation').html('');
                    $('.error_container').css('display','block');
                    $.each(response.responseJSON.errors, function(key,value) {
                        $('#error-validation').append('<li>'+value+'</li>');
                    });
                }
            });
        });

        $(document).on('click', '#save_manufacturer', function(e) {
            e.preventDefault();
            var name=$('.supplier input[name="name"]').val();

            $.ajax({
                url: "{{route('vendor-manufacturer-add')}}",
                header: 'Content-Type: application/json',
                type: 'POST',
                data:{ "_token": "{{ csrf_token() }}",'name':name,},

                success: function(json) {
                    $('.error_container').css('display','none');
                    $('.success_container').css('display','block');
                    let html = '  <option disabled selected value> -- Select an option -- </option>';
                        if (json['result'] && json['result'] != '') {
                            for (let i = 0; i < json['result'].length; i++) {
                                html += '<option value="' + json['result'][i]['manufacturer_id'] + '"';
                                html += '>' + json['result'][i]['name']+'</option>';
                            }
                        } 

                    $('select[name=\'manufacturer_id\']').html(html);
                    $( "#add_manufacturer" ).modal('hide');
                },

                error: function(response) {
                    var data = response.responseJSON.errors;
                    $('#error-validation').css('display','block');
                    $('.success_container').css('display','none');
                    $('#error-validation').html('');
                    $('.error_container').css('display','block');
                    $.each(response.responseJSON.errors, function(key,value) {
                        $('#error-validation').append('<li>'+value+'</li>');
                    });
                }
            });
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

        $('#add-product').submit(function() {
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
 
        $(function() {
            $('#mySelect').change(function() {
                if (this.value == "not_found") {
                    $('.to_disable').removeClass('selected');
                    $('.to_disable').attr('disabled', true);
                    $('.to_disable').addClass('disabled');
                    $('#newCategory').css('display','block');
                } 
                else {
                    $('.to_disable').attr('disabled', false);
                    $('.to_disable').removeClass('disabled');
                    $('#newCategory').css('display','none');
                }
          });
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
