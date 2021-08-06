@extends('admin.layouts.master')
@section('css')
<!-- INTERNAL Prism Css -->
<link href="{{URL::asset('assets/plugins/prism/prism.css')}}" rel="stylesheet">
    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Categories List</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Categories List</a></li>
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
                            @can('permission-create')
                                <a href="{{ route('category-add') }}"><button type="button" class="btn btn-primary"><i
                                            class="fe fe-plus mr-2"></i>Add
                                        Category</button>
                                </a>
                            @endcan
                         </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Category Tree</h3>
                </div>
                <div class="card-body">
                    <style>
                        .ml-12, .mx-12 {
                            margin-left: 12rem !important;
                        }
                     </style>
                    @foreach ($categories as $category)
                        @if($category->parent_id == 0 )
                            @php  $margin=0; @endphp
                            <ol class="breadcrumb breadcrumb-arrow mt-3" style="color:white;background-color: none !important;">
                                <li ><a  href='{{route('category-show',[$category->category_id])}}'>{{ $category->names[0]->name}}</a></li> 
                            </ol>
                            @include('admin.mains-admin.category.category', $category)
                        @endif
                    @endforeach
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
