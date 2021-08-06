@extends('admin.layouts.master')
@section('css')
    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">IP Address : WhiteList</h4>
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
            @if ($message = Session::get('error'))
                <div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">×</button>
                    <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{ $message }}.
                </div>
            @endif

            <div class="row flex-lg-nowrap">
                <div class="col-12 mb-3">
                    <div class="e-panel card">
                        <div class="card-body">
                            @can('role-create')
                                <a href="{{ route('whitelist-show-add') }}"><button type="button" class="btn btn-primary"><i
                                            class="fe fe-plus mr-2"></i>Add to whitelist</button>
                                </a>
                            @endcan
                            <div class="e-table">
                                <div class="table-responsive table-lg mt-3">
                                    <table
                                        class="table table-bordered mp-0 table-striped table-vcenter border-top text-nowrap"
                                        id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">Id Address</th>
                                                <th class="wd-15p border-bottom-0">Type</th>
                                                <th class="wd-15p border-bottom-0">Country</th>
                                                <th class="wd-15p border-bottom-0">Created at</th>
                                                <th class="wd-15p border-bottom-0">Updated at</th>
                                                <th class="wd-20p border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="change-role">
                                            @foreach ($blacklists as $whitelist)
                                                 @php 
                                                    $iso = substr($whitelist->ip_address, 8);
                                                    $country=Firewall::getCountryName(strtolower($iso));
                                                @endphp
                                                <tr>
                                                    <td>{{ $whitelist->ip_address }}</td>
                                                    <td><span class="badge badge-gradient-danger">blocked</span></td>
                                                    <td>{{  $country ?? '-----------' }}</td>
                                                    <td>{{ $whitelist->created_at ?? '------------' }}</td>
                                                    <td>{{ $whitelist->updated_at ?? '------------' }}</td>
                                                    <td class="align-middle">
                                                        <div class="btn-group align-top">
                                                            <a
                                                                href="{{ route('whitelist-remove', [$whitelist->ip_address]) }}">
                                                                <button class="btn btn-sm btn-danger approve-btn"
                                                                    type="button"><i class="fa fa-trash"></i> remove
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </td>
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
