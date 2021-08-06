@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title mb-0">products Tables</h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/product"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="/">Products Table</a></li>
        </ol>
    </div>
</div>


<!----------- Search Form ---------->
<div style="margin: 20px 0">
    <form action="{{route('stock-get-product-list')}}" method='GET' role="form" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-2">
            <div class="col-md-11">
                <input type='text' class='form-control' name='search'>
            </div>
            <button class="btn btn-primary ml-3 mt-1" type="submit">Search</button>
        </div>
    </form>
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
@if(!count($products))
<!-- <script>
    $('#modaldemo5').modal('show');
</script> -->
<div class="modal" id="modaldemo5">
    <div class="modal-dialog modal-dialog-centered text-center" role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body text-center p-4">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                <i class="fe fe-x-circle fs-100 text-danger lh-1 mb-5 d-inline-block"></i>
                <h4 class="text-danger">Error: Cannot found the product!</h4>
                <p class="mg-b-20 mg-x-20">Please try again.</p><button aria-label="Close" class="btn btn-danger pd-x-25" data-dismiss="modal" type="button" onclick="window.location='{{route('stock-search-product')}}'">Continue</button>
            </div>
        </div>
    </div>
</div>
@else
<div class="row flex-lg-nowrap">
    <div class="col-12">
        @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{ $message }}.
        </div>
        @endif
        <div class="row flex-lg-nowrap">
            <div class="col-12 mb-3">
                <div class="e-panel card">
                    <div class="card-body">
                        <div class="e-table">
                            <div class="table-responsive table-lg mt-3">
                                <table class="table table-bordered table-hover  mp-0  table-vcenter border-top text-nowrap" id="example1">
                                    <thead>
                                        <tr>
                                            <th class="w-7 h-7 rounded shadow mr-3">Picture</th>
                                            <th class="wd-15p border-bottom-0"> Model</th>
                                            <th class="wd-15p border-bottom-0">Title</th>
                                            <th class="wd-15p border-bottom-0">Product id</th>
                                            <!-- <th class="wd-15p border-bottom-0">Store</th> -->
                                            <!-- <th class="wd-15p border-bottom-0">Brand</th> -->
                                            <th class="wd-15p border-bottom-0">SKU</th>
                                            <th class="wd-20p border-bottom-0">Price</th>
                                            <th class="wd-20p border-bottom-0">Quantity</th>
                                            <th class="wd-20p border-bottom-0">Status</th>
                                            <th class="wd-20p border-bottom-0">Added date</th>
                                            <th class="border-bottom-0 w-10">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                        <tr data-id='{{$product->product_id}}' onclick="window.location='{{route('stock-get-product',$product->product_id)}}'" target='_blank'>
                                            <td><img class="w-7 h-7 rounded shadow mr-3" src="https://ariba.ma/image/{{ $product->image }}" alt="{{ $product->name }}"></td>
                                            <td>{{ $product->model }}</td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->product_id }}</td>
                                            {{--<td>{{ $product->display_name ?? '' }}</td>--}}
                                            {{-- <td>{{ $product->manufacturer }}</td> --}}
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->price-number_format(floatval($product->price*0.2),2) }} DH</td>
                                            <td><span class="badge badge-primary mt-2">{{ $product->quantity }}</span>
                                            </td>
                                            <td>
                                                @if ($product->status == 0)<span class="badge badge-danger mt-2">Disabled</span>@else<span class="badge badge-success mt-2">Enabled</span>@endif
                                            </td>
                                            <td>{{ $product->date_added }}</td>
                                            <td class="align-middle">
                                                <div class="btn-group align-top">
                                                    <button class="btn btn-sm btn-primary" type="button"><a href="{{route('stock-get-product',$product->product_id)}}" target="_blank" style="color:white">Show</a></button>
                                                    <!--<button class="btn btn-sm btn-info" type="button"><a href="verify/{{ $product->product_id }}" style="color:white">Verify</a></button>-->
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--/div-->
                </div>
            </div>
            @endif()

            @endsection
            @section('js')
            <!-- INTERNAl Data tables -->
            <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
            <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>

            <!-- INTERNAL Clipboard js -->
            <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
            <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>

            <!-- INTERNAL Prism js -->
            <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
            @if(!count($products))
            <script>
                $('#modaldemo5').modal('show');
            </script>
            @endif()
            @endsection
