@extends('admin.layouts.master-vendor')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Products Tables</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/vendor/dashboard"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/">Products Table</a></li>
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
                                        id="example1">
                                        <thead>
                                            <tr>
                                                <th class="w-7 h-7 rounded shadow mr-3">Picture</th>
                                                <th class="wd-15p border-bottom-0">Product title</th>
                                                <th class="wd-15p border-bottom-0">Product id</th>
                                                <th class="wd-15p border-bottom-0">Brand</th>
                                                <th class="wd-15p border-bottom-0">EAN</th>
                                                <th class="wd-15p border-bottom-0">AR Number</th>
                                                <th class="wd-20p border-bottom-0">Price</th>
                                                <th class="wd-20p border-bottom-0">Quantity</th>
                                                <th class="wd-20p border-bottom-0">Added date</th>
                                                <th class="border-bottom-0 w-10">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['products'] as $product)
                                                <tr>
                                                    <td><img class="w-7 h-7 rounded shadow mr-3"
                                                            src="https://ariba.ma/image/{{ $product->image }}"></td>
                                                    <td><a
                                                            href="{{ route('vendor-update-product', $product->product_id) }}">{{ $product->name }}</a>
                                                    </td>
                                                    <td>{{ $product->product_id }}</td>
                                                    <td>{{ $product->manufacturer }}</td>
                                                    <td>{{ $product->ean }}</td>
                                                    <td>{{ $product->model }}</td>
                                                    <td>{{ $product->price - number_format(floatval($product->price * 0.2), 2) }}
                                                        DH</td>
                                                    <td><span
                                                            class="badge badge-danger mt-2">{{ $product->quantity }}</span>
                                                    </td>
                                                    <td>{{ $product->date_added }}</td>
                                                    <td class="align-middle">
                                                        <div class="btn-group align-top">
                                                            <button class="btn btn-sm btn-primary" type="button"><a
                                                                    href="update/{{ $product->product_id }}"
                                                                    target="_blank" style="color:white">Edit</a></button>
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

        <!-- INTERNAL Clipboard js -->
        <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
        <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>

        <!-- INTERNAL Prism js -->
        <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

        <script>
            $('#example1').DataTable({
                "columnDefs": [{
                        "targets": [4],
                        "visible": false,
                        "searchable": true
                    },
                    {
                        "targets": [5],
                        "visible": false,
                        "searchable": true
                    },
                ],
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                    lengthMenu: '_MENU_',
                }
            });

        </script>
    @endsection
