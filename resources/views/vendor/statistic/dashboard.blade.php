@extends('admin.layouts.master-vendor')
@section('css')

@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Dashboard</h4>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <div class="row">
        <div class="col-6 col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-cash-multiple text-red"></i> 1000 DH</div>
                    <div class="text-muted mb-0"><a href="/vendor/order/finished"> Total Sales</a></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-cart-outline text-blue"></i>{{count($order_finish)}}</div>
                    <div class="text-muted mb-0"><a href="/vendor/order/finished">Orders Completed</a></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-account-multiple-outline text-primary"></i>
                        {{ $total_employees ?? 0 }}</div>
                    <div class="text-muted mb-0"><a href="/vendor/employee">Total Employees</a></div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center list-icons">
                    <svg class="svg-icon2  fill-white text-primary icon-dropshadow-primary" x="0" y="240"
                        viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet"
                        focusable="false">
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4v0a2 2 0 100-4v0zm-8 2a2 2 0 11-4 0v0a2 2 0 114 0v0z">
                        </path>
                    </svg>
                    <p class="card-text mt-3 mb-0">New Orders</p>
                    <p class="h2 text-center font-weight-bold"><a href="/vendor/order/to-verify">{{ count($new_orders) ?? 10 }}</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center list-icons">
                    <svg class="svg-icon2  fill-white text-dark icon-dropshadow-primary" x="0" y="240" viewBox="0 0 24 24"
                        height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4v0a2 2 0 100-4v0zm-8 2a2 2 0 11-4 0v0a2 2 0 114 0v0z">
                        </path>
                    </svg>
                    <p class="card-text mt-3 mb-0">Total Products</p>
                    <p class="h2 text-center font-weight-bold"><a href="/vendor/product">{{ count($total_products) }}</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center list-icons">
                    <svg class="svg-icon2  fill-white text-pink icon-dropshadow-primary" x="0" y="240" viewBox="0 0 24 24"
                        height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4v0a2 2 0 100-4v0zm-8 2a2 2 0 11-4 0v0a2 2 0 114 0v0z">
                        </path>
                    </svg>
                    <p class="card-text mt-3 mb-0">Total Orders</p>
                    <p class="h2 text-center font-weight-bold"><a>{{ count($order_total) }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <!--Row-->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Top Product Sales Overview</h3>
                    <div class="card-options">
                        <a class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="fe fe-more-horizontal fs-20"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item sales" data-id="today">Today</a>
                            <a class="dropdown-item sales" data-id="lastweek">Last Week</a>
                            <a class="dropdown-item sales" data-id="lastmonth">Last Month</a>
                            <a class="dropdown-item sales" data-id="lastyear">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @include('vendor.statistic.top-sales')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--End row-->
@endsection
@section('js')
    <script>
        $(document).on('click', '.sales', function(e) {
            e.preventDefault();
            var time = $(this).data('id');
            $.ajax({
                url: "{{ route('vendor-top-sales') }}",
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}",
                    'time': time
                },
                success: function(data) {
                    $('#top-sales-time').html(data);
                },
                error: function(ajaxContext) {
                    alert(ajaxContext.responseText);
                }
            })
        });
    </script>
@endsection
