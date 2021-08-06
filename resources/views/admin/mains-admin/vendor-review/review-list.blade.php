@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Vendor Review</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Vendor Review</a></li>
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
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                    </button>
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
                                                <th class="wd-15p border-bottom-0">Id</th>
                                                <th class="wd-15p border-bottom-0">Vendor</th>
                                                <th class="wd-15p border-bottom-0">Customer Name</th>
                                                <th class="wd-15p border-bottom-0">Review</th>
                                                <th class="wd-15p border-bottom-0">Status</th>
                                                <th class="wd-15p border-bottom-0">Date Added</th>
                                                <th class="wd-20p border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="change-permission">
                                            @foreach ($reviews as $review)
                                                <tr>
                                                    <td>{{ $review->review_id }}</td>
                                                    <td><a href="{{route('update-vendor',$review->vendor_id)}}">{{ $review->vendor_name }}</a></td>
                                                    <td><a href="{{route('update-customer',$review->vendor_id)}}">{{ $review->name }}</a></td>
                                                    <td>{{ Str::limit($review->text, 120) }}</td>
                                                    <td>
                                                        @if ($review->status)<span
                                                            class="badge badge-success"> Enabled </span>@else<span
                                                                class="badge badge-danger">Disabled </span>@endif()
                                                    </td>
                                                    <td>{{ $review->date_added }}</td>
                                                    <td class="align-middle">
                                                        <div class="btn-group align-top">
                                                            <a>
                                                                <button data-review="{{ $review->text }}"
                                                                    data-status="{{ $review->status }}"
                                                                    data-id="{{ $review->review_id }}"
                                                                    data-effect="effect-scale" data-target="#show"
                                                                    data-toggle="modal"
                                                                    class="btn btn-sm btn-primary modal-effect show-review"
                                                                    type="button"><i class="fa fa-eye"></i></button>
                                                            </a>
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

    <!--Show Review -->
    <div class="modal  fade" id="show" tabindex="-1" role="dialog" aria-labelledby="smallmodal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="smallmodal1">Review Text</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="review-text"></p>
                </div>
                <form id="form-review" action="" method="POST">
                    @csrf
                    <div class="modal-footer">
                        <button type="submit" id="approve" class="btn btn-success">Approve</button>
                        <button type="submit" id="disapprove" class="btn btn-danger">Disapprove</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('.show-review').on('click', function(e) {
            e.preventDefault();
            $('#review-text').html($(this).attr("data-review"));
            var status = $(this).attr("data-status");
            var id = $(this).attr("data-id");
            if (status==1) {
                $('#approve').css('display', 'none');
                $('#disapprove').css('display', 'block');
                $('#form-review').attr("action", "review/disapprove/" + id);
            } else {
                $('#disapprove').css('display', 'none');
                $('#approve').css('display', 'block');
                $('#form-review').attr("action", "review/approve/" + id);
            }

        });
    </script>
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
