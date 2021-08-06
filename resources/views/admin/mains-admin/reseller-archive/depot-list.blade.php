@extends('admin.layouts.master')
@section('css')
    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Depot List</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Depot List</a></li>
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
                            @can('depot-create')
                                <a href="{{ route('depot-add') }}">
                                    <button type="button" class="btn btn-primary"><i class="fe fe-plus mr-2"></i>Add
                                        Depot</button>
                                </a>
                            @endcan
                            <div class="e-table">
                                <div class="table-responsive table-lg mt-3">
                                    <table
                                        class="table table-bordered mp-0 table-striped table-vcenter border-top text-nowrap"
                                        id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">Id Depot</th>
                                                <th class="wd-15p border-bottom-0">Depot Name</th>
                                                <th class="wd-15p border-bottom-0">Id Vendor</th>
                                                <th class="wd-15p border-bottom-0">Vendor Name</th>
                                                <th class="wd-15p border-bottom-0">Address</th>
                                                <th class="wd-15p border-bottom-0">Volume</th>
                                                <th class="wd-15p border-bottom-0">Date Added</th>
                                                @can('depot-edit')
                                                <th class="wd-20p border-bottom-0">Action</th>
                                                @endcan
                                            </tr>
                                        </thead>
                                        <tbody id="change-edit">
                                            @foreach ($depots as $depot)
                                                <tr>
                                                    <td>{{ $depot->depot_id }}</td>
                                                    <td>{{ $depot->name }}</td>
                                                    <td>{{ $depot->vendor_id  ?? "---None---"}}</td>
                                                    <td>{{ $depot->vendor_name ?? "---None---"}}</td>
                                                    <td>{{ $depot->address }}</td>
                                                    <td>{{ $depot->volume }}</td>
                                                    <td>{{ $depot->date_added }}</td>
                                                    @can('depot-edit')
                                                    <td class="align-middle">
                                                        <div class="btn-group align-top">
                                                            <button class="btn btn-sm btn-info approve-btn" type="button"><a
                                                                    href="{{ route("depot-show",[$depot->depot_id]) }}" class="approve"
                                                                    style="color:white">Show</a>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    @endcan
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--/div-->
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
                    <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>

                    <!-- INTERNAL Clipboard js -->
                    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
                    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>

                    <!-- INTERNAL Prism js -->
                    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
                    <!-- INTERNAL Select2 js -->
                    <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
                    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

                    <!--INTERNAL Sumoselect js-->
                    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

                    <!--INTERNAL Form Advanced Element -->
                    <script src="{{ URL::asset('assets/js/formelementadvnced.js') }}"></script>
                    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

                @endsection
