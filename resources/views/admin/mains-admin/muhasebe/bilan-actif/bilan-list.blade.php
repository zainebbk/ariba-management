@extends('admin.layouts.master')
@section('css')
    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Bilan Actif</h4>
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

                                {{-- <a href="{{ route('cpc-show-add') }}"><button type="button" class="btn btn-primary"><i
                                            class="fe fe-plus mr-2"></i>Add to 'Bilan Passif'</button>
                                </a> --}}
                            
                            <div class="e-table">
                                <div class="table-responsive table-lg mt-3">
                                    <table
                                        class="table table-bordered mp-0 table-vcenter border-top text-nowrap"
                                        id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">Id</th>
                                                <th class="wd-15p border-bottom-0">Model</th>
                                                <th class="wd-15p border-bottom-0">Parent</th>
                                                <th class="wd-15p border-bottom-0">Group</th>
                                                <th class="wd-15p border-bottom-0">Type</th>
                                                <th class="wd-20p border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="change-role">
                                            @foreach ($cpcs as $cpc) 
                                                <tr @if($cpc->is_parent ) style="background-color: #e9e5fb;
                                                border-color: #e9e5fb;
                                                box-shadow: 0 0px 10px -5px rgb(112 94 200 / 50%);" @endif>
                                                    <td>{{ $cpc->id }}</td>
                                                    <td @if($cpc->is_parent ) class="font-weight-bold text-uppercase" @endif>{{ $cpc->model }}</td>
                                                    <td>{{ $cpc->parent }}</td>
                                                    <td class="font-weight-bold" >{{ $cpc->groupe }}</td>
                                                    <td><span @if($cpc->type=='Active immobilisé') class="badge badge-gradient-warning"
                                                         @elseif($cpc->type=='Active circulant') class="badge badge-gradient-success"
                                                          @else class="badge badge-gradient-danger" @endif >{{ $cpc->type }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="btn-group align-top">
                                                            <a target="_blank"
                                                                href="{{ route('bilan-actif-show', [$cpc->id]) }}">
                                                                <button class="btn btn-sm btn-primary approve-btn"
                                                                    type="button"  ><i class="fa fa-pencil"></i> edit
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

                @endsection
