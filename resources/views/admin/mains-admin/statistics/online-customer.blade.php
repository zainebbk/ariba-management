@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Online Customer</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Online Customer</a></li>
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
                                    <table class="table table-bordered mp-0 table-striped table-vcenter border-top"
                                        id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="w-7 h-7 rounded shadow mr-3" style="width: 20%">IP</th>
                                                <th class="wd-15p border-bottom-0 " style="width: 20%">online Name</th>
                                                <th class="wd-15p border-bottom-0" style="width: 1%">Url</th>
                                                <th class="wd-15p border-bottom-0" style="width: 20%">Referer</th>
                                                <th class="wd-15p border-bottom-0" style="width: 30%">Date added</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($onlines as $online)
                                                <td><a href="https://whatismyipaddress.com/ip/{{ $online->ip }}"
                                                        target="_blank" style="color:#705ec8">{{ $online->ip }}</a></td>
                                                <td>
                                                    @if (isset($online->fullname))<a
                                                            href="{{ route('update-customer', $online->customer_id) }}">{{ $online->fullname }}</a>
                                                    @else Guest @endif()
                                                </td>
                                                <td><a href={{ $online->url }} style="color:#705ec8" target="_blank"
                                                        rel="noreferrer">{{ $online->url }}</a></td>
                                                <td>{{ $online->referer }}</td>
                                                <td>{{ $online->date_added }}</td>
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
        <script src="{{ URL::asset('assets/js/datatables.js') }}"></script>

        <script>
            $(document).ready(function() {
                $('#table-1').DataTable({
                    "order": [
                        [4, "desc"]
                    ]
                });
            });
        </script>

    @endsection
