@extends('admin.layouts.master')
@section('css')
    <!-- INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Order #{{$order->invoice_id}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Order Shipped</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
<style>
    .card-header:before {
        content: none;
    }

    .table.details-table td, .table.details-table th {
        padding: .3rem;
    }

    .table.details-table td {
        font-weight: bold;
    }
    .custom-switch-input:checked~.custom-switch-indicator {
       background: #ef4b4b !important;
       border: 1px solid #ef4b4b;
    }

    @media (min-width: 1200px){
        .modal-xl {
            max-width: 1140px !important;
        }
    }

</style>
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="card overflow-hidden">
            <div class="card-status card-status-left bg-gray br-bl-7 br-tl-7"></div>
            <div class="card-header">
                <h3 class="card-title">Order Details</h3>
                <div class="card-options">
                    <a href="{{url('/' . $page='#')}}" class="card-options-fullscreen mr-2"
                       data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                    <a href="{{url('/' . $page='#')}}" class="card-options-collapse mr-2"
                       data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table details-table">
                    <tbody>
                    <tr>
                        <th class="border-0" scope="row">Name</th>
                        <td class="border-0"><a>{{$order->firstname}} {{$order->lastname}}</a></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><a href="mailto:{{$order->email}}">{{$order->email}}</a></td>
                    </tr>
                    <tr>
                        <th scope="row">Phone</th>
                        <td><a href="tel:{{$order->telephone}}">{{$order->telephone}}</a></td>
                    </tr>
                    <tr>
                        <th scope="row">Store Name</th>
                        <td>{{$order->store_name}} </td>
                    </tr>
                    <tr>
                        <th scope="row">Order Date</th>
                        <td>{{ date('d/m/Y', strtotime($order->date_added))}} </td>
                    </tr>
                    <tr>
                        <th scope="row">Payment Method</th>
                        <td> @if($order->payment_code=="cod") Cash On Delivery @else {{$order->payment_method}} @endif </td>
                    </tr>
                    <tr>
                        <th scope="row">Shipping Method</th>
                        <td>{{$order->shipping_method}} </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card overflow-hidden">
            <div class="card-status card-status-left bg-gray br-bl-7 br-tl-7"></div>
            <div class="card-header">
                <h3 class="card-title">Invoice Address</h3>
                <div class="card-options">
                    <a href="{{url('/' . $page='#')}}" class="card-options-fullscreen mr-2"
                       data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                    <a href="{{url('/' . $page='#')}}" class="card-options-collapse mr-2" data-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table details-table">
                    <tbody>
                        <tr>
                            <th scope="row" class="border-0">Name</th>
                            <td class="border-0">{{$order->payment_firstname}} {{$order->payment_lastname}}  </td>
                        </tr>
                        <tr>
                            <th>Company</th>
                            <td>{{$order->payment_company}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Address 1</th>
                            <td> {{$order->payment_address_1}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Address 2</th>
                            <td> {{$order->payment_address_2}} </td>
                        </tr>
                        <tr>
                            <th scope="row">City</th>
                            <td> {{$order->payment_city}} {{$order->payment_postcode}} </td>
                        </tr>
                        <tr>
                            <th scope="row">Zone</th>
                            <td> {{$order->payment_zone}} </td>
                        </tr>
                        <tr>
                            <th scope="row">Country</th>
                            <td>{{$order->payment_country}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card overflow-hidden">
            <div class="card-status card-status-left bg-gray br-bl-7 br-tl-7"></div>
            <div class="card-header">
                <h3 class="card-title">Shipping Address</h3>
                <div class="card-options">
                    <a href="{{url('/' . $page='#')}}" class="card-options-fullscreen mr-2"
                       data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
                    <a href="{{url('/' . $page='#')}}" class="card-options-collapse mr-2" data-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table details-table">
                    <tbody>
                        <tr>
                            <th class="border-0" scope="row">Name</th>
                            <td class="border-0">{{$order->shipping_firstname}} {{$order->shipping_lastname}}   </td>
                        </tr>
                        <tr>
                            <th>Company</th>
                            <td>{{$order->shipping_company}} </td>
                        </tr>
                        <tr>
                            <th scope="row">Shipping Address 1</th>
                            <td>{{$order->shipping_address_1}}</td>
                        </tr>
                        <tr>
                            <th scope="row">Shipping Address 2</th>
                            <td> {{$order->shipping_address_2}} </td>
                        </tr>
                        <tr>
                            <th scope="row">City</th>
                            <td>{{$order->shipping_city}} {{$order->shipping_postcode	}} </td>
                        </tr>
                        <tr>
                            <th scope="row">Zone</th>
                            <td>{{$order->shipping_zone}} </td>
                        </tr>
                        <tr>
                            <th scope="row">Country</th>
                            <td>{{$order->shipping_country}} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card overflow-hidden">
            <div class="card-status card-status-left bg-gray br-bl-7 br-tl-7"></div>
            <div class="card-header">
                <h3 class="card-title">Additional data </h3>
                <div class="card-options">
                    <a class="card-options-fullscreen mr-2" data-toggle="card-fullscreen"><i
                            class="fe fe-maximize"></i></a>
                    <a href="{{url('/' . $page='#')}}" class="card-options-collapse mr-2"
                       data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                </div>
            </div>
            <div class="card-body">
                <table class="table details-table">
                    <tbody>
                    <tr>
                        <th class="border-0" scope="row">IP Address</th>
                        <td class="border-0">{{$order->ip}}  </td>
                    </tr>
                    <tr>
                        <th>User Agent</th>
                        <td> {{$order->user_agent}} From : @if ($order->from_app) Application @else
                                Website @endif</td>
                    </tr>
                    <tr>
                        <th scope="row">Accept Language</th>
                        <td> {{$order->accept_language}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Sales Agent</th>
                        <td><a>{{$order->s_firstname ?? '--None--'}} </a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card overflow-hidden">
            <div class="card-body">
                <div class="card-status bg-gray"></div>
                <h2 class="font-weight-bold">ORDER #{{$order->invoice_id}}</h2>
                <div class="table-responsive push mt-7">
                    <table class="table table-bordered table-hover text-nowrap">
                        <tr class=" ">
                            <th class="text-center " style="width: 1%"></th>
                            <th>Product</th>
                            <th class="text-center" style="width: 1%">SKU</th>
                            <th class="text-center" style="width: 1%">Size</th>
                            <th class="text-center" style="width: 1%">Model</th>
                            <th class="text-center" style="width: 1%">Quantity</th>
                            <th class="text-right" style="width: 1%">Unit Price</th>
                            <th class="text-right" style="width: 1%">TVA</th>
                            <th class="text-right" style="width: 1%">Amount</th>
                        </tr>

                        @php $total=0;@endphp
                        @foreach ($order_products as $order_product)
                            @foreach ($order_options as $order_option)
                                @if ($order_product->order_product_id == $order_option->order_product_id)
                                @php $total+=($order_product->total+$order_product->tax*$order_product->quantity); @endphp
                                    <tr>
                                        <td class="text-center">#</td>
                                        <td>
                                            <a href="{{route("vendor-update-product",$order_product->product_id)}}">
                                                <p class="font-weight-semibold mb-1">{{$order_product->name}}</p>
                                            </a>
                                            <div class="text-muted"></div>
                                        </td>
                                        <td class="text-center">{{$order_product->sku}}</td>
                                        <td class="text-center">{{$order_option->value}}</td>
                                        <td class="text-center">{{$order_product->model}}</td>
                                        <td class="text-center">{{$order_product->quantity}}</td>
                                        <td class="text-right">{{ number_format(floatval( $order_product->price ), 2) }}</td>
                                        <td class="text-center">{{$order_product->tax}}</td>
                                         <td class="text-right">{{ number_format(floatval($order_product->total+$order_product->tax*$order_product->quantity ), 2) }}MAD</td>
                                    </tr>
                                    @endif
                            @endforeach
                        @endforeach

                        <tr>
                            <td colspan="8" class="font-weight-bold text-uppercase text-right h4 mb-0">Total
                                Due
                            </td>
                            <td class="font-weight-bold text-right h4 mb-0">
                                {{number_format(floatval( $total ) ?? 0, 2)?? 0  }}MAD
                            </td>
                        </tr>

                        <tr>
                            <td colspan="9" class="text-right">
                                <button type="button" class="btn btn-success modal-effect"
                                        data-effect="effect-scale" data-target="#shipped" data-toggle="modal"><i
                                        class="fe fe-check mr-2"></i>Compelete
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card overflow-hidden">
            <div class="card-status bg-gray"></div>
            <div class="card-body">
                <h2 class="font-weight-bold">ORDER HISTORY</h2>
                <div class="table-responsive push mt-7">
                    <table class="table table-bordered table-hover text-nowrap">
                        <tr>
                            <th class="text-center ">Date</th>
                            <th>Status</th>
                            <th>Product name</th>
                            <th>Updated by</th>
                            <th>Comment</th>
                        </tr>

                        @foreach($order_history as $history)
                            <tr>
                                <th scope="row">{{$history->date_added}}</th>
                                <td>{{$history->status}}</td>
                                <th>{{$history->name}}</th>
                                <td>{{$history->updateby}}</td>
                                <td>{{$history->comment}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Shipped order -->
<div class="modal" id="shipped">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{route('order-depot-finish',$order->order_id)}}" method="post" class="needs-validation"
                  novalidate="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodal1">Order #{{$order->invoice_id}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">??</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <p style="margin-left: 20px">Are you sure you want to change the order status  compelete ?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="shipped">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@section('js')

    <script>
     

    </script>

    <!-- INTERNAL Select2 js -->
    <script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>

    <!--INTERNAL Form Advanced Element -->
    <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

@endsection
