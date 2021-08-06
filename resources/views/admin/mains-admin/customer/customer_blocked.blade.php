@extends('admin.layouts.master')
@section('css')
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Blocked Customers List</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="">Blocked List</a></li>
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
                                            <th class="w-7 h-7 rounded shadow mr-3">Image</th>
                                            <th class="wd-15p border-bottom-0">Customer Full Name</th>
                                            <th class="wd-15p border-bottom-0">Email</th>
                                            <th class="wd-15p border-bottom-0">Sales Agent</th>
                                            <th class="wd-15p border-bottom-0">Phone</th>
                                            <th class="wd-15p border-bottom-0">Address</th>
                                            <th class="wd-15p border-bottom-0">Date added</th>
                                            <th class="wd-20p border-bottom-0">Preview</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data['customers'] as $customer)
                                            <tr id="tr-{{ $customer->customer_id}}">
                                                @php $imagesrc="https://ariba.ma/image/catalog/profile-pic.png"; @endphp
                                                <td><img class="w-7 h-7 rounded shadow mr-3" src="{{$imagesrc ?? ''}}" alt="{{$customer->firstname}}"></td>
                                                <td>{{$customer->firstname}} {{$customer->lastname}}</td>
                                                <td>{{$customer->email}}</td>
                                                <td>{{$customer->s_firstname}} {{$customer->s_lastname ?? '-- NONE --'}}</td>
                                                <td>{{$customer->telephone}}</td>
                                                <td>{{$customer->address_1}} {{$customer->postcode}} {{$customer->city}}</td>
                                                <td>{{$customer->date_added}}</td>
                                                <td class="align-middle">
                                                    <div class="btn-group align-top">
                                                        <button class="btn btn-sm btn-info" data-id="{{$customer->customer_id}}"><a  href="blocked/update/{{$customer->customer_id}}" style="color: white">Preview</a></button>
                                                    </div>
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
                <!--Delete customer -->
                <div class="modal  fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodal" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="smallmodal1">Verification</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to approve this sales agent ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="approve">Approve</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end delete customer modal -->

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

                    <script>
                        $(document).on('click', '.approve-btn', function(e) {
                            e.preventDefault();
                            var id = $(this).data('id');
                            $('#approve').data('id',id);
                        });

                        $(document).on('click', '#approve', function(e) {
                            e.preventDefault();
                            var salesagent_id=  $('#approve').data('id');
                            $.ajax({
                                url:"{{ route('first-approve-sales-agent') }}",
                                type:"POST",
                                data:{ "_token": "{{ csrf_token() }}",'salesagent_id':salesagent_id},
                                success:function (data) {
                                    $('#smallmodal').modal('hide');
                                    // let tr=$("table").find(`[data-elem='${salesagent_id}']`);
                                    var tr= $("#tr-" + salesagent_id);
                                    tr.css('background-color', '#ffc7cè');
                                    var table = $('#example1').DataTable();
                                    tr.fadeOut(120, function () {
                                        table.row($(this)).remove().draw();
                                    });
                                },
                                error: function (ajaxContext) {
                                    alert(ajaxContext.responseText);
                                }
                            })
                        });

                        $(document).ready(function() {
                            $('#example').DataTable( {
                                initComplete: function () {
                                    this.api().columns().every( function () {
                                        var column = this;
                                        var select = $('<select><option value=""></option></select>')
                                            .appendTo( $(column.footer()).empty() )
                                            .on( 'change', function () {
                                                var val = $.fn.dataTable.util.escapeRegex(
                                                    $(this).val()
                                                );

                                                column
                                                    .search( val ? '^'+val+'$' : '', true, false )
                                                    .draw();
                                            } );

                                        column.data().unique().sort().each( function ( d, j ) {
                                            select.append( '<option value="'+d+'">'+d+'</option>' )
                                        } );
                                    } );
                                }
                            } );
                        } );

                    </script>
@endsection
