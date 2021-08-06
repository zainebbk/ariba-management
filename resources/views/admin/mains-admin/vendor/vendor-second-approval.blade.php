@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Vendor: Second Approval</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/">Vendors Table</a></li>
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
            @if($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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
                                        id="example1">
                                        <thead>
                                        <tr>
                                            <th class="w-7 h-7 rounded shadow mr-3">Picture</th>
                                            <th class="wd-15p border-bottom-0">Vendor name</th>
                                            <th class="wd-15p border-bottom-0">User name</th>
                                            <th class="wd-15p border-bottom-0">Store name</th>
                                            <th class="wd-15p border-bottom-0">Products</th>
                                            <th class="wd-15p border-bottom-0">Email</th>
                                            <th class="wd-15p border-bottom-0">Phone</th>
                                            <th class="wd-15p border-bottom-0">Birthday</th>
                                            <th class="wd-15p border-bottom-0">Date added</th>
                                            <th class="wd-20p border-bottom-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['vendors'] as $vendor)
                                            <tr id="tr-{{ $vendor->vendor_id}}">
                                                @php $imagesrc="http://www.ariba.ma/image/catalog/profile-pic.png"; @endphp
                                                <td><img class="w-7 h-7 rounded shadow mr-3" src="{{$imagesrc ?? ''}}"
                                                         alt="{{$vendor->vendorname}}"></td>
                                                <td>{{$vendor->vendorname}}</td>
                                                <td>{{$vendor->display_name}}</td>
                                                <td>{{$vendor->store}}</td>
                                                <td><span
                                                        class="badge badge-success mt-2">{{$vendor->totalproduct}}</span>
                                                </td>
                                                <td>{{$vendor->email}}</td>
                                                <td>{{$vendor->telephone}}</td>
                                                <td>{{$vendor->birthday}}</td>
                                                <td>{{$vendor->date_added}}</td>
                                                <td class="align-middle">
                                                    <div class="btn-group align-top">
                                                        <button class="btn btn-sm btn-info" type="button"><a
                                                                href="./update/{{$vendor->vendor_id}}"
                                                                style="color:white">Edit</a></button>
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

    <!-- INTERNAL Clipboard js -->
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.min.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/clipboard/clipboard.js')}}"></script>

    <!-- INTERNAL Prism js -->
    <script src="{{URL::asset('assets/plugins/prism/prism.js')}}"></script>
@endsection
