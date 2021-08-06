@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Order Completed ( {{ count($orders) }} )</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Order Completed</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row flex-lg-nowrap">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">×</button>
                    <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{ $message }}.
                </div>
            @endif
            <div class="row flex-lg-nowrap">
                <div class="col-12 mb-3">
                    <div class="e-panel card">
                        <div class="card-body">
                            <div class="e-table">
                                <div class="table-responsive table-lg mt-3">
                                    <table
                                        class="table table-bordered mp-0 table-striped table-vcenter border-top text-nowrap"
                                        id="example-order">
                                        <thead>
                                            <tr>
                                                <th class="w-7 h-7 rounded shadow mr-3">Order Nbr</th>
                                                <th class="w-7 h-7 rounded shadow mr-3">Order Id</th>
                                                <th class="wd-15p border-bottom-0">Customer</th>
                                                <th class="wd-15p border-bottom-0">Sales Agent</th>
                                                <th class="wd-15p border-bottom-0">No. of Products</th>
                                                <th class="wd-15p border-bottom-0">From</th>
                                                <th class="wd-15p border-bottom-0">Status</th>
                                                <th class="wd-15p border-bottom-0">Total</th>
                                                <th class="wd-15p border-bottom-0">Shipping Method</th>
                                                <th class="wd-15p border-bottom-0">Date Added</th>
                                                <th class="wd-15p border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $order->order_id }}</td>
                                                    <td>{{ $order->invoice_id ?? '' }}</td>
                                                    <td>{{ $order->cname }}</td>
                                                    <td>{{ $order->s_name ?? '--None--' }} </td>
                                                    <td><span class="badge badge-danger">{{ $order->county ?? 0 }}</span>
                                                    </td>
                                                    <td>
                                                    @if ($order->from_app) App @else
                                                            Website @endif
                                                    </td>
                                                    <td><span class="badge badge-warning">{{ $order->status }}</span></td>
                                                    <td>{{ number_format(floatval($order->total+ $order->tax),2) }} <small>Dh</small>
                                                    </td>
                                                    <td> {{ $order->shipping_method }}</td>
                                                    <td>{{ $order->date_added }}</td>
                                                    <iframe src="{{ route('invoice-pdf', $order->invoice_id) }}"
                                                        style="position:absolute; visibility: hidden" id="myframe"
                                                        name="{{ $order->invoice_id }}" class='frame'></iframe>
                                                    <td class="align-middle">
                                                        <div class="btn-group align-top">
                                                            <a class='' href="{{ route('order-depot-show-finished', $order->order_id) }}"
                                                                   ><button class="btn btn-sm btn-success"
                                                                data-id="{{ $order->order_id }}"><i
                                                                    class="si si-pencil"></i> Show &nbsp;</button></a>

                                                            <button type="button" class="btn btn-sm btn-info  print" data-id="{{ $order->invoice_id }}"
                                                                value="invoice"><i
                                                                    class="si si-printer"></i> Invoice</button>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    <script>
        $(document).on('click', '.print', function(e) {
            $ele = $(this);
            let invoice_id = $ele.data('id');
            window.frames[invoice_id].window.print();
        });

    </script>
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
@endsection
