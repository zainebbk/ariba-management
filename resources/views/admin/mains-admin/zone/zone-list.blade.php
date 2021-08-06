@extends('admin.layouts.master')
@section('css')
 <!-- INTERNAL Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
    <!--Page header-->
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title mb-0">Zones Tables</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/zone"><i class="fe fe-layout  mr-2 fs-14"></i>Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="/">Zones Table</a></li>
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

             
                <div class='row' style="margin-bottom: 25px ;">
                    <div class="col-lg-3">
                        <label class="col-md-12 form-label">Regions</label>
                        <select class="form-control select2" name="region_id">
                            <option value=0  {{old("region_id")==0 ? "selected" : ""}}>---Select---</option>
                            @foreach ($regions as $region)
                                <option  @if(isset($region_id1) ){{$region_id1==$region->region_id ? "selected" : ""}} @endif value="{{ $region->region_id }}">{{ $region->region }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                            <label class="col-md-12 form-label">Province</label>
                            <select class="form-control select2" name="province_id">
                                <option value=0>---None---</option>
                            </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-md-12 form-label">Ville</label>
                        <select class="form-control select2" name="ville_id">
                            <option value=0>---None---</option>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <label class="col-md-12 form-label">Quartier</label>
                        <select class="form-control select2" name="quartier_id">
                            <option value=0>---None---</option>
                        </select>
                    </div>
                    <div class="col-lg-2" style="margin-top: 10px">
                        <button type="submit" class="btn btn-primary mt-4 mb-0" id='search-zone'>Search</button>
                    </div>
                </div>
               

        
            <div class="row flex-lg-nowrap">
            
                <div class="col-12 mb-3 zones">
                    @include('admin.mains-admin.zone.zone')
                </div>
            </div>
        </div>


    </div>
            @endsection
            @section('js')

                <!-- INTERNAL Clipboard js -->
                <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
                <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>

                <!-- INTERNAL Prism js -->
                <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

                 <!--INTERNAL Select2 js -->
                <script src="{{ URL::asset('assets/plugins/select2/select2.full.min.js') }}"></script>
                <script src="{{ URL::asset('assets/js/select2.js') }}"></script>

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

                <script type="text/javascript">
                    $(function () {
                        $('body').on('click', '.pagination a', function (e) {
                            e.preventDefault();
                           // $('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 10000;" src="https://i.imgur.com/v3KWF05.gif />');
                            var url = $(this).attr('href');
                            window.history.pushState("", "", url);
                            loadZones(url);
                        });
                
                        function loadZones(url) {
                            $.ajax({
                                url: url
                            }).done(function (data) {
                                $('.zones').html(data);
                            }).fail(function () {
                                console.log("Failed to load data!");
                            });
                        }
                    });
                    $(function () {
                        $('body').on('click', '#search-zone', function (e) {
                            e.preventDefault();
                            region_id=$('select[name=region_id]').val();
                            province_id=$('select[name=province_id]').val();
                            ville_id=$('select[name=ville_id]').val();
                            quartier_id=$('select[name=quartier_id]').val();
                            $.ajax({
                                url: "{{ route('search-zones') }}",
                                type: "GET",
                                data: {'region_id': region_id,'province_id': province_id,
                                'ville_id': ville_id,'region_id': region_id,'quartier_id': quartier_id
                            },
                            }).done(function (data) {
                                $('.zones').html(data);
                            }).fail(function () {
                                console.log("Failed to load data!");
                            });
                        });
                    });
                    $('select[name=region_id]').on('change', function() {
                        
                        $.ajax({
                            url: "{{ route('on-change-zones') }}",
                            type: "GET",
                            data: {
                                'region_id': this.value
                            },
                            success: function(json) {
                                let html = '<option value="">---Select---</option>';
                                if (json['result'] && json['result'] != '') {
                                    for (let i = 0; i < json['result'].length; i++) {
                                        html += '<option @if(isset($province_id1) ){{$province_id1==$province->province_id ? "selected" : ""}} @endif value="' + json['result'][i]['province_id'] + '"';

                                        html += '>' + json['result'][i]['province'] + '</option>';
                                    }
                                } else {
                                   
                                }

                                $('select[name=\'province_id\']').html(html);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert("error");
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            },

                        });
                    });


                    $('select[name=province_id]').on('change', function() {
                        $.ajax({
                            url: "{{ route('on-change-zones') }}",
                            type: "GET",
                            data: {
                                'province_id': this.value
                            },
                            success: function(json) {
                                let html = '<option value="">---Select---</option>';
                                if (json['result'] && json['result'] != '') {
                                    for (let i = 0; i < json['result'].length; i++) {
                                        html += '<option @if(isset($ville_id1) ){{$ville_id1==$ville->ville_id ? "selected" : ""}} @endif value="' + json['result'][i]['ville_id'] + '"';

                                        html += '>' + json['result'][i]['ville'] + '</option>';
                                    }
                                } else {
                                   
                                }

                                $('select[name=\'ville_id\']').html(html);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert("error");
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            },

                        });
                    });

                    $('select[name=ville_id]').on('change', function() {
                        $.ajax({
                            url: "{{ route('on-change-zones') }}",
                            type: "GET",
                            data: {
                                'ville_id': this.value
                            },
                            success: function(json) {
                                let html = '<option value="">---Select---</option>';
                                if (json['result'] && json['result'] != '') {
                                    for (let i = 0; i < json['result'].length; i++) {
                                        html += '<option  @if(isset($quartier_id1) ){{$quartier_id1==$quartier->quartier_id ? "selected" : ""}} @endif value="' + json['result'][i]['quartier_id'] + '"';

                                        html += '>' + json['result'][i]['quartier'] + '</option>';
                                    }
                                } else {
                                   
                                }

                                $('select[name=\'quartier_id\']').html(html);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert("error");
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            },

                        });
                    });

                   

                </script>

            @endsection
