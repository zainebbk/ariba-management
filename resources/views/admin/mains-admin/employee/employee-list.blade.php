@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Employees List</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Employees List</a></li>
            </ol>
        </div>
    </div>
    <!--End Page header-->
@endsection
@section('content')
    <!-- Row -->
    <div class="row flex-lg-nowrap">
        <div class="col-12">
            @if($message = Session::get('success'))
                <div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{$message}}.
                </div>
            @endif
            <div class="row flex-lg-nowrap">
                <div class="col-12 mb-3">
                    <div class="e-panel card">
                        <div class="card-body">
                            <div class="e-table">
                                <div class="table-responsive table-lg mt-3">
                                    <table class="table table-bordered mp-0 table-striped table-vcenter border-top text-nowrap" id="example1">
                                        <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">Id</th>
                                            <th class="wd-15p border-bottom-0">Full Name</th>
                                            <th class="wd-15p border-bottom-0">User Name</th>
                                            <th class="wd-15p border-bottom-0">Email</th>
                                            <th class="wd-15p border-bottom-0">Phone</th>
                                            <th class="wd-15p border-bottom-0">Birthday</th>
                                            <th class="wd-15p border-bottom-0">Address</th>
                                            <th class="wd-15p border-bottom-0">Date added</th>
                                            <th class="wd-20p border-bottom-0">Date modified</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['employees'] as $employee)
                                            <tr>
                                                <td>{{$employee->employee_id}}</td>
                                                <td>{{$employee->firstname}} {{$employee->lastname}}</td>
                                                <td>{{$employee->display_name}}</td>
                                                <td>{{$employee->email}}</td>
                                                <td>{{$employee->phone}}</td>
                                                <td>{{ date('Y-m-d', strtotime($employee->birthday)) }}</td>
                                                <td>{{$employee->address}} {{$employee->city}} {{$employee->postcode}}</td>
                                                <td>{{$employee->date_added}}</td>
                                                <td>{{$employee->date_modified}}</td>
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