@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Vendor Tables</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/">First Approval</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
<style>
    button:disabled {
        cursor: not-allowed;
        pointer-events: all !important;
    }

</style>
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
                                            <th class="wd-15p border-bottom-0">First Name</th>
                                            <th class="wd-15p border-bottom-0">Last Name</th>
                                            <th class="wd-15p border-bottom-0">User Name</th>
                                            <th class="wd-15p border-bottom-0">Email</th>
                                            <th class="wd-15p border-bottom-0">Phone</th>
                                            <th class="wd-15p border-bottom-0">Birthday</th>
                                            <th class="wd-15p border-bottom-0">Date added</th>
                                            <th class="wd-15p border-bottom-0">Status</th>
                                            @if (Auth::user()->hasAnyPermission(['vendor-approve', 'vendor-disapprove'] ))
                                                <th class="wd-20p border-bottom-0">Approve</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data['vendors'] as $vendor)
                                            <tr id="tr-{{ $vendor->vendor_id}}">
                                                @php $imagesrc="http://www.ariba.ma/image/catalog/profile-pic.png"; @endphp
                                                <td><img class="w-7 h-7 rounded shadow mr-3"
                                                         src="{{ $imagesrc ?? '' }}" alt="pic">
                                                </td>
                                                <td>{{ $vendor->firstname }}</td>
                                                <td>{{ $vendor->lastname }}</td>
                                                <td>{{ $vendor->display_name }}</td>
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->telephone }}</td>
                                                <td>{{ $vendor->birthday }}</td>
                                                <td>{{ $vendor->date_added }}</td>
                                                <td>
                                                    @if ($vendor->approved == 0)<span
                                                        class="badge badge-warning mt-2 status">Waiting for
                                                            approval</span>@else<span
                                                        class="badge badge-success mt-2 status">Enabled</span>
                                                    @endif
                                                </td>
                                                <td class="align-middle">
                                                    @can('vendor-approve')
                                                        <div class="btn-group align-top">
                                                            <button @if ($vendor->approved == 1) disabled @endif
                                                            class="btn btn-sm btn-success approve"
                                                                    data-id="{{ $vendor->vendor_id }}"><i
                                                                    class="fa fa-thumbs-o-up" @if ($vendor->approved == 0) data-placement="left" data-toggle="tooltip" title="Approve" @endif></i></button>
                                                        </div>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
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

                    <script>
                        $(document).on('click', '.approve', function(e) {
                            e.preventDefault();
                            $ele = $(this);
                            var vendor_id = $(this).data('id');
                            $.ajax({
                                url: "{{ route('approve-vendor') }}",
                                type: "POST",
                                data: {
                                    "_token": "{{ csrf_token() }}",
                                    'vendor_id': vendor_id
                                },
                                success: function() {
                                    var tr= $("#tr-" + vendor_id);
                                    tr.css('background-color', '#ffc7cè');
                                    var table = $('#example1').DataTable();
                                    tr.fadeOut(200, function () {
                                        table.row($(this)).remove().draw();
                                    });
                                },
                                error: function(ajaxContext) {
                                    alert(ajaxContext.responseText);
                                }
                            })
                        });
                    </script>
@endsection
