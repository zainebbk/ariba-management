@extends('admin.layouts.master')
@section('css')

<!-- INTERNAL Sumoselect css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect.css') }}">

<!--INTERNAL Select2 css -->
<link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />

@endsection
@section('page-header')

<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">Stock Management</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="">Stock &nbsp;> search for product</a></li>
        </ol>
    </div>
</div>
<!--End Page header-->

<div>

    <!----------- Search Form ---------->
    <div style="margin: 20px 0">
        <form action="{{route('vendor-stock-get-product-list')}}" method='GET' role="form" enctype="multipart/form-data">
            @csrf
            <div class="input-group mb-2">
                <div class="col-md-11">
                    <input type='text' class='form-control' name='search'>
                </div>
                <button class="btn btn-primary ml-3 mt-1" type="submit">Search</button>
            </div>
        </form>
    </div>

   <!----------- Errors ---------->

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

    @if ($message = Session::get('success'))
    <div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{ $message }}.
    </div>
    @endif



    <!----------- Product Details ---------->

    <div class="card">

        <div class="card-header">
            <h4 class="card-title">{{$product[0]->name}} <span class="float-right" style="font-size: 14px; font-weight: 350; color: #999; line-height: 20px">&nbsp;#{{$product[0]->ean}}</span> </h4>
        </div>

        @php
        $length = strlen($product[0]->image);
        $id = $product[0]->product_id;
        $v_i=0;
        $jpg = substr($product[0]->image, -4);
        @endphp

        <div class="card-body">
            <div class="row row-sm">
                <div class="col-lg-4 col-sm-12">
                    <img src="https://ariba.ma/image/{{ $product[0]->image }}" class="card-image1 mb-4" style="width:500px;height: 600px" alt="Product images">
                </div>
                <div class="col-lg-8 col-sm-12">

                    <form action="{{ route('vendor-stock_save', $id)}}"  method="post">
                        @csrf
                        <!-- <input type="text" name="id" id="product_id" value="{{ $id }}" hidden> -->

                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap">

                                <thead>
                                    <tr>
                                        <th>Value</th>
                                        <th>Quantity</th>
                                        <th> <span class="badge badge-default  mt-2"> {{$product[0]->Sett}}</span> &nbsp; Set</th>
                                    </tr>
                                </thead>

                                <!-- SHOES SIZE -->
                                <tbody>
                                    @foreach ($options as $option)

                                    <tr>
                                        <td scope="row"><input class="form-control"  name="name"  type="number" value="{{$option->name}}" disabled></td>
                                        <td hidden><input name="product_details['{{$loop->index}}'][product_option_value_id]"  type="number" value="{{$option->product_option_value_id}}" > </td>
                                        <td><input class="form-control "  name="product_details['{{$loop->index}}'][quantity]" type="number"  placeholder="0" min="0" value="{{$option->quantity}}"></td>
                                        <td>
                                            <span class="badge badge-primary mt-2"  name="product_details['{{$loop->index}}'][set_number]" type="number" value="{{$option->set_number}}">{{$option->set_number}}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                        <button class="btn btn-primary ml-3  " type="submit">Save</button>
                        <!-- id="save-{{$id}}" data-id="{{$id}}" class="btn btn-primary ml-3 savee" -->
                    </form>

                </div>
     </div>


 <!-----------   Stock   -------------->

            <form action="{{ route('vendor-update_stocks' , $id) }}" method="post">
                @csrf
                <div class="col-12 mt-5 mb-2">
                    <h3 class="card-title">Stock</h3>
                </div>

                @foreach ($places as $plc)
                <div class="input-group mb-3" style="display: flex">

                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3"><input type="text" id="quantity" class="form-control" value="{{$plc->quantity}}" name="product_stock['{{$loop->index}}'][quantity]" style="height:20px;border:none"></span>
                    </div>

                    <div>
                        <select class="form-control select2" name="product_stock['{{$loop->index}}'][place]">
                            @foreach ( $placee as $pl)
                            <option value="{{$pl->name}}" {{ $plc->place == $pl->name ? 'selected' : '' }}>{{$pl->name}} </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select class="form-control select2" name="product_stock['{{$loop->index}}'][depot]">
                            @foreach ( $depot as $dp)
                            <option value="{{$dp->name}}" {{ $dp->name == $dp->name ? 'selected' : '' }}>{{$dp->name}} </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="text" name="product_stock['{{$loop->index}}'][type]" class="form-control" id="type" @if($plc->type) value="Piece" @else value="Set" @endif >

                    <div>

                        <select class="form-control select2" name="product_stock['{{$loop->index}}'][option_value]">

                            <option value="None">---</option>
                            @foreach ( $optionn as $o)
                            <option value="{{$o->name}}" {{ $plc->option_value == $o->name ? 'selected' : '' }}>{{$o->name}}
                            </option>
                            @endforeach

                        </select>

                    </div>

                    <input type="text" value="{{$plc->date_added}}" class="form-control" id="basic-url" readonly>

                </div>
                @endforeach
                <button class="btn btn-primary ml-3  " type="submit">Save</button>
            </form>

<!-----------  Add New Stock   -------------->

            <form action="{{ route('vendor-place_save') }}" method="get">


                <div class="col-12 mt-5 mb-2">
                    <h3 class="card-title">New Stock</h3>
                </div>

                <!--------SET /PIECE--------------------->

                <div class="card-header">
                    <h3 class="mb-0 card-title">Choose a type</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group ">
                                <div class="custom-controls-stacked">

                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="type" value="0" checked="">
                                        <span class="custom-control-label">Set</span>
                                    </label>

                                    <label class="custom-control custom-radio">
                                        <input type="radio" class="custom-control-input" name="type" value="1">
                                        <span class="custom-control-label">Piece</span>
                                    </label>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--------OPTIONS--------------------->

                <div id="piece" style="display: none;">

                    <div class="card-header">
                        <h3 class="mb-0 card-title">Options</h3>
                    </div>

                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6 mb-0">
                                <div class="form-group">

                                    <select class="form-control select2 custom-select" name="option" data-placeholder="Choose a size">
                                        <option label="Choose a size"></option>
                                        @foreach ( $optionn as $o)
                                        <option value="{{$o->name}}">{{$o->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--------QUANTITY / PLACE--------------------->

                <div class="card-header">
                    <h3 class="mb-0 card-title">Insert Quantity and Place</h3>
                </div>

                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">

                            <div class="form-group">
                                <input type="number" class="form-control" id="name1" name="qte_place" placeholder="Quantity" value="1" min=1>
                            </div>

                        </div>

                       <div class="form-group col-md-6 mb-0">
                            <div class="form-group">
                               <select class="search-box"  name="place" data-placeholder="Choose a row" >
                                    @foreach ( $placee as $pl)
                                    <option value="{{$pl->name}}">{{$pl->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <!-- <h6  style="margin-left: 490px;" type="button"  data-toggle="modal" data-target="#place"><i class="fa fa-plus-circle"></i>  Add a new Place</h6> -->




                    </div>
                </div>

                <!--------DEPOT------------->

                <div class="card-header">
                    <h3 class="mb-0 card-title">Choose a depository</h3>
                </div>

                <div class="card-body">
                    <div class="form-row">

                        <div class="form-group col-md-6 mb-0">
                            <div class="form-group">
                                <select class="search-box" name="depot" data-placeholder="Choose a depository">
                                    @foreach ( $depot as $dp)
                                    <option value="{{$dp->name}}">{{$dp->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                    </div>
                    <h6  type="button"  data-toggle="modal" data-target="#depot"><i class="fa fa-plus-circle"></i>  Add a new Depository</h6>

                </div>

                <input type="text" name="product_id" value="{{ $id }}" hidden>
                <button type="submit" class="btn btn-primary mt-2">Add New Stock</button>
            </form>
        </div>
    </div>

    <!--------- Depository Modal ------------>


        <div  class="modal fade" id="depot" tabindex="-1" role="dialog" aria-labelledby="depotlabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add a new Depository</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <form action="{{ route('vendor-stock-depository-add') }}" method='POST' role="form" enctype="multipart/form-data">
                    @csrf
                        <div class="modal-body">
                            <div class="col-md-11">
                                <div class="card-header">
                                    <h3 class="mb-0 card-title">Depository Name</h3>
                                </div>
                                <input type='text' class='form-control' name='name' placeholder="Name">

                                <div class="card-header">
                                    <h3 class="mb-0 card-title">Depository Address</h3>
                                </div>
                                <input type='text' class='form-control' name='address' placeholder="Adress">

                                <div class="card-header">
                                    <h3 class="mb-0 card-title">Depository Volume</h3>
                                </div>
                                <input type='text' class='form-control' name='volume' placeholder="Volume">


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
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

<!--INTERNAL Sumoselect js-->
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

<!--INTERNAL Form Advanced Element -->
<script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

<script type="text/javascript">
    $('input[name=type]').on('change', function() {
        if (this.value == 0) {
            $('#piece').hide();
        } else {
            $('#piece').show();
        }
    });

</script>
<style>
    h6 {
        color: #6958BE;
    }
</style>

@endsection
