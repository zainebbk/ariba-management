@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Order List ({{count($invoices)}})</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="#"><i class="fe fe-layers mr-2 fs-14"></i>Order list</a></li>
            </ol>
        </div> 
    </div>
    <!--End Page header-->
@endsection
@section('content')

		<!-- Row-->
        <div class="row">
            <div class="col-lg-12">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="search" name="search"
                        placeholder="Search......">
                    <span class="input-group-append">
                        <button class="btn ripple btn-primary" type="submit">Search</button>
                    </span>
                </div>
                <div id="product_list"></div>
            </div>   

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row m-0 no-gutters">
                            <div class="col-lg-12">
                                <div class="border border-right-0 p-0 invoicelist" id="invoicelist">
                                    <div class="card-body p-0">
                                        <div class="tab-menu-heading sub-panel-heading p-0 border-0">
                                            <div class="tabs-menu">
                                                <!-- Tabs -->
                                                <ul class="nav panel-tabs">
                                                    @foreach($invoices as $invoice)
                                                        <li class="active">
                                                            <a class="d-flex" target="_blank" href="{{route("invoice-show",[$invoice->invoice_id])}}">
                                                                <img src="{{URL::asset('assets/images/files/file.png')}}" alt="img" class="w-7 h-7 mr-4">
                                                                <div class="mt-1">
                                                                    <h5 class="mb-1 font-weight-bold mt-0">Invoice  #{{str_pad($invoice->invoice_no, 4, '0', STR_PAD_LEFT)}}</h5>
                                                                    <p class="mb-0 text-muted">Order Id : {{$invoice->invoice_id}}</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                    @if(count($invoices)==0)
                                                        <li class="active">
                                                            <a class="d-flex" data-toggle="tab" href="#" aria-expanded="true">
                                                                <img src="'.URL::asset('assets/images/files/file.png').'" alt="img" class="w-7 h-7 mr-4">
                                                                <div class="mt-1">
                                                                    <h5 class="mb-1 font-weight-bold mt-0">No results found !</h5>
                                                                    <p class="mb-0 text-muted">No order or invoice with this number</p>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End row-->

</div><!-- end app-content-->

@endsection
@section('js')
<script type="text/javascript">
    $('#search').on('keyup',function(){
       
        $value=$(this).val();
        if ($value.length == 0)
            $value=null;
        $.ajax({
            type : 'get',
            url : "{{route('invoice-search')}}",
            data:{'search':$value},
            success:function(data){
                $('.panel-tabs').html(data);
            },
            error: function(ajaxContext) {
                console.log(ajaxContext.responseText);
            }
        });
    })
    </script>
    <script type="text/javascript">
    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });
    </script>
		<!-- INTERNAL simplebar JS -->
		<script src="{{URL::asset('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
@endsection