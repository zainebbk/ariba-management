@extends('admin.layouts.master')
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
    <div class="col-6 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-account-multiple-outline text-primary"></i> {{count($online) ?? '0'}}</div>
                <div class="text-muted mb-0"><a href="{{route('online-customer')}}"> Online</a></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-cash-multiple text-red"></i> {{number_format($order_sale, 2, '.', '') ?? '0'}} DH</div>
                <div class="text-muted mb-0"><a href="{{route('order-finished')}}"> Total Sales</a></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-cart-outline text-blue"></i>{{ count($order_compeleted) ?? '0'}}</div>
                <div class="text-muted mb-0"><a href="{{route('order-finished')}}">Orders Completed<a></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-account-outline text-yellow"></i>{{$total_customer}}</div>
                <div class="text-muted mb-0"><a href="{{route('customer')}}">Total Customers</a></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center list-icons">
                <svg class="svg-icon2  fill-white text-primary icon-dropshadow-primary" x="0" y="240" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><path stroke-linejoin="round" stroke-linecap="round" stroke-width="2" stroke="currentColor" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4v0a2 2 0 100-4v0zm-8 2a2 2 0 11-4 0v0a2 2 0 114 0v0z"></path></svg>
                <p class="card-text mt-3 mb-0">New Orders</p>
                <p class="h2 text-center font-weight-bold"><a href="{{route('order-to-verify')}}">{{$new_order}}</a></p>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center list-icons">
                <svg class="svg-icon2 text-success icon-dropshadow-success" xmlns="http://www.w3.org/2000/svg" height="100%" width="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <p class="card-text mt-3 mb-0">New Sales Agent</p>
                <p class="h2 text-center font-weight-bold"><a href="{{route('sales-agent-first-approval')}}">{{$new_sales_agent}}</a></p>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-4">
        <div class="card">
            <div class="card-body text-center list-icons">
                <svg class="svg-icon2 text-success icon-dropshadow-success" xmlns="http://www.w3.org/2000/svg" height="100%" width="100%" viewBox="0 0 24 24" fill="none" stroke="pink" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <p class="card-text mt-3 mb-0">New Vendor</p>
                <p class="h2 text-center font-weight-bold"><a href="{{route('vendor-first-approval')}}">{{$new_vendors}}</a></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-account-multiple-outline text-primary"></i> {{$total_employee}}</div>
                <div class="text-muted mb-0"><a href="{{route('employee-list')}}">Total Employees</a></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-cash-multiple text-red"></i> {{$total_company}}</div>
                <div class="text-muted mb-0"><a href="{{route('company')}}">Total Companies</a></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-cart-outline text-blue"></i>{{$total_product}}</div>
                <div class="text-muted mb-0"><a href="{{route('admin-product')}}">Total Product<a></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-6 col-lg-3">
        <div class="card">
            <div class="card-body text-center">
                <div class="h2 m-0 font-weight-bold"><i class="mdi mdi-account-outline text-yellow"></i>{{$total_vendor}}</div>
                <div class="text-muted mb-0"><a href="{{route('vendor')}}">Total Vendors</a></div>
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
                    <a class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-horizontal fs-20"></i></a>
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
                    <table class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sold</th>
                                <th>Stock</th>
                                <th>Amount</th>
                                <th>Stock Status</th>
                            </tr>
                        </thead>
                        <tbody id="top-sales-time">
                            @include('admin.mains-admin.statistics.top-sales')
                        </tbody>
                    </table>
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
            var time=  $(this).data('id');
            $.ajax({
                url:"{{ route('top-sales') }}",
                type:"GET",
                data:{ "_token": "{{ csrf_token() }}",'time':time},
                success:function (data) {
                  $('#top-sales-time').html(data);
                },
                error: function (ajaxContext) {
                    alert(ajaxContext.responseText);
                }
            })
        });
</script>
@endsection
