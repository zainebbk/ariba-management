@extends('admin.layouts.master')
@section('css')
    <!--INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Company List</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Company List</a></li>
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
                            <div class="row row-sm">
                                <div class="col-md-2">
                                    <select class="form-control select2 selected-employee" name="employee">
                                        <option value="none" selected>--- Select Employee ---</option>
                                        @foreach ($data['employees'] as $employee)
                                            <option value="{{ $employee->employee_id }}">
                                                {{ $employee->firstname }} {{ $employee->lastname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="e-table">
                                <div class="table-responsive table-lg mt-3">
                                    <table
                                        class="table table-bordered mp-0 table-striped table-vcenter border-top text-nowrap"
                                        id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">Name</th>
                                                <th class="wd-15p border-bottom-0">Employee</th>
                                                <th class="wd-15p border-bottom-0">Address 1</th>
                                                <th class="wd-15p border-bottom-0">Phone</th>
                                                <th class="wd-15p border-bottom-0">Owner</th>
                                                <th class="wd-15p border-bottom-0">Owner Email</th>
                                                <th class="wd-15p border-bottom-0">Owner Phone</th>
                                                <th class="wd-15p border-bottom-0">Note</th>
                                                <th class="wd-20p border-bottom-0">Date added</th>
                                                <th class="wd-20p border-bottom-0">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="change-company">
                                            @foreach ($data['companies'] as $company)
                                                <tr>
                                                    <td>{{ $company->name }}</td>
                                                    <td>{{ $company->e_firstname }} {{ $company->e_lastname }}</td>
                                                    <td>{{ $company->address1 }} {{ $company->city }}</td>
                                                    <td>{{ $company->phone }}</td>
                                                    <td>{{ $company->owner }}</td>
                                                    <td>{{ $company->ownerEmail }}</td>
                                                    <td>{{ $company->ownerPhone }}</td>
                                                    <td><span class="badge @if ($company->note ==
                                                            'null') badge-danger
                                                    @elseif($company->note=="good") badge-success @else
                                                        badge-warning @endif
                                                        mt-2">{{ $company->note }}</span></td>
                                                <td>{{ $company->date_added }}</td>
                                                <td class="align-middle">
                                                    <div class="btn-group align-top">
                                                        <button class="btn btn-sm btn-info approve-btn" type="button"><a
                                                                href="company/{{ $company->id }}" class="approve"
                                                                style="color:white">Show</a>
                                                        </button>
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
                <script>
                    $('select[name=employee]').on('change', function() {
                        var employee_id = this.value;
                        $.ajax({
                            url: "{{ route('company-search') }}",
                            type: "GET",
                            data: {
                                'id': employee_id
                            },
                            success: function(data) {
                                $('#change-company').html(data);
                            },
                            error: function(ajaxContext) {
                                console.log(ajaxContext.responseText);
                            }
                        });
                    });

                </script>

            @endsection
