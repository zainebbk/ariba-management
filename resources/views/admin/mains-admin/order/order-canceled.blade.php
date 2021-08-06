@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Order Canceled ( {{ count($orders) }} )</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Order Canceled</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row flex-lg-nowrap">
        <div class="col-12">
            @if($message = Session::get('success'))
                <div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{$message}}.
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
                                                <th class="w-7 h-7 rounded shadow mr-3">Order Id</th>
                                                <th class="wd-15p border-bottom-0">New Order Id</th>
                                                <th class="wd-15p border-bottom-0">Client</th>
                                                <th class="wd-15p border-bottom-0">Sales Agent</th>
                                                <th class="wd-15p border-bottom-0">From</th>
                                                <th class="wd-15p border-bottom-0">Status</th>
                                                <th class="wd-15p border-bottom-0">Reason</th>
                                                <th class="wd-15p border-bottom-0">Total</th>
                                                <th class="wd-15p border-bottom-0">Payment city</th>
                                                <th class="wd-15p border-bottom-0">Date Added</th>
                                                <th class="wd-15p border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td>{{ $order->order_id }}</td>
                                                    <td>@if ($order->invoice_id){{ $order->invoice_id }}@else{{ $order->order_id }} @endif</td>
                                                    <td>{{ $order->firstname }} {{ $order->lastname }}</td>
                                                    <td>{{$order->s_firstname ?? '--None--'}} </td>
                                                    <td>@if ($order->from_app) App @else Website @endif</td>
                                                    <td>{{ $order->status_name }}</td>
                                                    <td>{{ $order->reason }}</td>
                                                    <td>{{ number_format(floatval($order->total),2) }} <small>Dh</small></td>
                                                    <td> {{$order->payment_city}}</td>
                                                    <td>{{$order->date_added}}</td>
                                                    <td class="align-middle">
                                                        <div class="btn-group align-top">
                                                            <button class="btn btn-sm btn-info"
                                                                    data-id="{{$order->order_id}}"><a
                                                                    href="{{ route('order-show-waiting', $order->order_id) }}"
                                                                    style="color: white">Edit</a></button>
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
    <!-- INTERNAl Data tables -->
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/datatables.js')}}"></script>
@endsection
