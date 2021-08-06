@extends('admin.layouts.master-vendor')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Suggest Category List</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Category List</a></li>
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
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-hidden="true">×
                    </button>
                    <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i>{{ $message }}.
                </div>
            @endif

            <div class="row flex-lg-nowrap">
                <div class="col-12 mb-3">
                    <div class="e-panel card">
                        <div class="card-body">

                            <a href="{{ route('vendor-category-add') }}">
                                <button type="button" class="btn btn-primary"><i
                                        class="fe fe-plus mr-2"></i>Suggest New
                                    Category
                                </button>
                            </a>

                            <div class="e-table">
                                <div class="table-responsive table-lg mt-3">
                                    <table
                                        class="table table-bordered mp-0 table-striped table-vcenter border-top text-nowrap"
                                        id="example1">
                                        <thead>
                                        <tr>
                                            <th class="wd-15p border-bottom-0">Id</th>
                                            <th class="wd-15p border-bottom-0">Category Name</th>
                                            <th class="wd-15p border-bottom-0">Description</th>
                                            <th class="wd-15p border-bottom-0">Created at</th>
                                            <th class="wd-20p border-bottom-0">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody id="change-permission">
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>{{ $category->category_suggest_id }}</td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->description }}</td>
                                                <td>{{ $category->date_added }}</td>
                                                <td class="align-middle">
                                                    <div class="btn-group align-top">
                                                        <button class="btn btn-sm btn-info approve-btn" type="button"><a
                                                                href="{{ route("vendor-category-show",[$category->category_suggest_id]) }}"
                                                                class="approve" style="color:white">Edit</a>
                                                        </button>
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
